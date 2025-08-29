<?php



namespace App\Http\Controllers;

use App\Models\Recoleccion;
use App\Models\Produccion;
use App\Models\Trabajador;
use App\Models\ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RecoleccionController extends Controller
{
    public function index()
    {
        $recolecciones = Recoleccion::with(['produccion.lote'])
            ->activos()
            ->orderBy('fecha_recoleccion', 'desc')
            ->paginate(10);

        // Agregamos las producciones y trabajadores para el modal de edición
        $producciones = Produccion::with('lote')
            ->whereIn('estado', ['maduracion', 'cosecha'])
            ->where('activo', true)
            ->get();

        $trabajadores = Trabajador::activos()->get();

        return view('recolecciones.index', compact('recolecciones', 'producciones', 'trabajadores'));
    }

    public function create($produccionId = null)
    {
        $producciones = Produccion::with('lote')
            ->whereIn('estado', ['maduracion', 'cosecha'])
            ->where('activo', true)
            ->get();

        $trabajadores = Trabajador::activos()->get();

        $produccionSeleccionada = null;
        if ($produccionId) {
            $produccionSeleccionada = Produccion::find($produccionId);
        }

        return view('recolecciones.create', compact('producciones', 'trabajadores', 'produccionSeleccionada'));
    }

    public function store(Request $request)
    {
        // Validar los datos enviados desde el formulario
        $request->validate([
            'produccion_id' => 'required|exists:producciones,id', // Debe existir la producción
            'fecha_recoleccion' => 'required|date', // Fecha obligatoria
            'cantidad_recolectada' => 'required|numeric|min:0.001|max:9999.999', // Cantidad obligatoria
            'estado_fruto' => 'required|in:maduro,semi-maduro,verde', // Estado del fruto obligatorio
            'trabajadores_participantes' => 'required|array|min:1', // Debe haber al menos un trabajador
            'trabajadores_participantes.*' => 'exists:trabajadors,id', // Cada trabajador debe existir
            'condiciones_climaticas' => 'required|in:soleado,nublado,lluvioso', // Clima obligatorio
            'calidad_promedio' => 'nullable|numeric|min:1|max:5', // Calidad opcional
            'hora_inicio' => 'nullable|date_format:H:i', // Hora inicio opcional
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio', // Hora fin opcional y debe ser después de inicio
            'observaciones' => 'nullable|string|max:500' // Observaciones opcionales
        ]);

        // Buscar la producción seleccionada
        $produccion = Produccion::find($request->produccion_id);
        // Si la producción está completada, no se puede agregar recolección
        if ($produccion->estado === 'completado') {
            return back()->withErrors(['produccion_id' => 'No se puede agregar recolección a una producción completada.']);
        }

        // Verificar que la cantidad recolectada no exceda el 120% de la estimación
        $totalRecolectado = $produccion->total_recolectado + $request->cantidad_recolectada;
        if ($totalRecolectado > $produccion->estimacion_produccion * 1.2) { // 20% de tolerancia
            return back()->withErrors([
                'cantidad_recolectada' => 'La cantidad total recolectada excedería significativamente la estimación de producción.'
            ]);
        }

        // Verificar si ya existe una recolección para el mismo lote
        $loteId = $produccion->lote_id;
        $recoleccionExistente = Recoleccion::whereHas('produccion', function($query) use ($loteId) {
            $query->where('lote_id', $loteId);
        })->first();

        if ($recoleccionExistente) {
            // Si existe, sumar la cantidad recolectada a la anterior
            $cantidadAnterior = $recoleccionExistente->cantidad_recolectada;
            $nuevaCantidad = $cantidadAnterior + $request->cantidad_recolectada;

            // Calcular el stock disponible restando lo vendido
            $totalVendido = \App\Models\Venta::where('recoleccion_id', $recoleccionExistente->id)
                                            ->sum('cantidad_vendida');
            $nuevoStockDisponible = $nuevaCantidad - $totalVendido;

            // Actualizar la recolección existente directamente en la base de datos
            DB::table('recolecciones')
                ->where('id', $recoleccionExistente->id)
                ->update([
                    'cantidad_recolectada' => $nuevaCantidad,
                    'cantidad_disponible' => $nuevoStockDisponible,
                    'fecha_recoleccion' => $request->fecha_recoleccion,
                    'estado_fruto' => $request->estado_fruto,
                    'condiciones_climaticas' => $request->condiciones_climaticas,
                    'calidad_promedio' => $request->calidad_promedio,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                    'observaciones' => $request->observaciones .
                        ($recoleccionExistente->observaciones ? ' | ' . $recoleccionExistente->observaciones : ''),
                    // Une los trabajadores anteriores y nuevos, sin duplicados
                    'trabajadores_participantes' => json_encode(array_unique(array_merge(
                        $recoleccionExistente->trabajadores_participantes ?? [],
                        $request->trabajadores_participantes
                    ))),
                    'updated_at' => now()
                ]);

            // Recargar el modelo para obtener los datos actualizados
            $recoleccionExistente->refresh();

            $mensaje = "Recolección actualizada: {$cantidadAnterior} kg + {$request->cantidad_recolectada} kg = {$nuevaCantidad} kg (Disponible: {$nuevoStockDisponible} kg)";
            $recoleccion = $recoleccionExistente;
        } else {
            // Si no existe, crear una nueva recolección
            $recoleccion = Recoleccion::create(array_merge($request->all(), [
                'cantidad_disponible' => $request->cantidad_recolectada
            ]));
            $mensaje = "Nueva recolección registrada exitosamente.";
        }

        // Actualizar el estado de la producción si corresponde
        $this->actualizarEstadoProduccion($produccion);

        // Redirigir a la vista de la producción con mensaje de éxito
        return redirect()->route('produccion.show', $produccion->id)
            ->with('success', $mensaje);
    }

   public function show(Recoleccion $recoleccion, Request $request)
    {
        $recoleccion->load(['produccion.lote']);

        // Si la petición es AJAX, devolver JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'id' => $recoleccion->id,
                'fecha_recoleccion' => $recoleccion->fecha_recoleccion->format('Y-m-d'),
                'cantidad_recolectada' => $recoleccion->cantidad_recolectada,
                'estado_fruto' => $recoleccion->estado_fruto,
                'condiciones_climaticas' => $recoleccion->condiciones_climaticas,
                'calidad_promedio' => $recoleccion->calidad_promedio,
                'hora_inicio' => $recoleccion->hora_inicio ? $recoleccion->hora_inicio->format('H:i') : null,
                'hora_fin' => $recoleccion->hora_fin ? $recoleccion->hora_fin->format('H:i') : null,
                'trabajadores_count' => is_array($recoleccion->trabajadores_participantes)
                    ? count($recoleccion->trabajadores_participantes)
                    : 0,
                'trabajadores_nombres' => $recoleccion->trabajadoresParticipantes()->pluck('nombre')->implode(', '),
                'observaciones' => $recoleccion->observaciones,
                'duracion_horas' => $recoleccion->hora_inicio && $recoleccion->hora_fin
                    ? round($recoleccion->hora_inicio->diffInMinutes($recoleccion->hora_fin) / 60, 1)
                    : null,
                'produccion' => [
                    
                    'id' => $recoleccion->produccion->id,
                    'tipo_cacao' => $recoleccion->produccion->tipo_cacao,
                    'lote_nombre' => $recoleccion->produccion->lote->nombre ?? 'N/A'
                ]
            ]);
        }

        return view('recolecciones.show', compact('recoleccion'));
    }

    public function edit(Recoleccion $recoleccion)
    {
        $producciones = Produccion::with('lote')
            ->whereIn('estado', ['maduracion', 'cosecha'])
            ->activos()
            ->get();

        $trabajadores = Trabajador::activos()->get();

        return view('recolecciones.edit', compact('recoleccion', 'producciones', 'trabajadores'));
    }

    public function update(Request $request, Recoleccion $recoleccion)
    {
        try {
            $request->validate([
                'produccion_id' => 'required|exists:producciones,id',
                'fecha_recoleccion' => 'required|date',
                'cantidad_recolectada' => 'required|numeric|min:0.001|max:9999.999',
                'estado_fruto' => 'required|in:maduro,semi-maduro,verde',
                'trabajadores_participantes' => 'required|array|min:1',
                'trabajadores_participantes.*' => 'exists:trabajadors,id',
                'condiciones_climaticas' => 'required|in:soleado,nublado,lluvioso',
                'calidad_promedio' => 'nullable|numeric|min:1|max:5',
                'hora_inicio' => 'nullable|date_format:H:i',
                'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
                'observaciones' => 'nullable|string|max:500'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Los datos proporcionados no son válidos.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $produccion = Produccion::find($request->produccion_id);

        // Verificar límites de recolección
        $totalRecolectado = $produccion->total_recolectado - $recoleccion->cantidad_recolectada + $request->cantidad_recolectada;
        if ($totalRecolectado > $produccion->estimacion_produccion * 1.2) {
            $error = 'La cantidad total recolectada excedería significativamente la estimación de producción.';
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => $error], 422);
            }
            
            return back()->withErrors([
                'cantidad_recolectada' => $error
            ]);
        }

        $recoleccion->update($request->all());

        // Actualizar el estado de la producción
        $this->actualizarEstadoProduccion($produccion);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Recolección actualizada exitosamente.'
            ]);
        }

        return redirect()->route('recolecciones.show', ['recoleccione' => $recoleccion->id])
            ->with('success', 'Recolección actualizada exitosamente.');
    }

    public function destroy(Recoleccion $recoleccion)
    {
        $produccionId = $recoleccion->produccion_id;
        $recoleccion->update(['activo' => false]);

        // Actualizar el estado de la producción
        $produccion = Produccion::find($produccionId);
        $this->actualizarEstadoProduccion($produccion);

        return redirect()->route('produccion.show', $produccionId)
            ->with('success', 'Recolección eliminada exitosamente.');
    }

    // Método para obtener recolecciones de una producción específica (AJAX)
    public function porProduccion($produccionId)
    {
        $recolecciones = Recoleccion::where('produccion_id', $produccionId)
            ->activos()
            ->orderBy('fecha_recoleccion', 'desc')
            ->get()
            ->map(function ($recoleccion) {
                return [
                    'id' => $recoleccion->id,
                    'fecha_recoleccion' => $recoleccion->fecha_recoleccion->format('Y-m-d'),
                    'cantidad_recolectada' => $recoleccion->cantidad_recolectada,
                    'estado_fruto' => $recoleccion->estado_fruto,
                    'condiciones_climaticas' => $recoleccion->condiciones_climaticas,
                    'calidad_promedio' => $recoleccion->calidad_promedio,
                    'hora_inicio' => $recoleccion->hora_inicio ? $recoleccion->hora_inicio->format('H:i') : null,
                    'hora_fin' => $recoleccion->hora_fin ? $recoleccion->hora_fin->format('H:i') : null,
                    'trabajadores_count' => is_array($recoleccion->trabajadores_participantes)
                        ? count($recoleccion->trabajadores_participantes)
                        : 0,
                    'trabajadores_nombres' => $recoleccion->trabajadoresParticipantes()->pluck('nombre')->implode(', '),
                    'observaciones' => $recoleccion->observaciones,
                    'duracion_horas' => $recoleccion->hora_inicio && $recoleccion->hora_fin
                        ? round($recoleccion->hora_inicio->diffInMinutes($recoleccion->hora_fin) / 60, 1)
                        : null
                ];
            });

        return response()->json($recolecciones);
    }

    // Método para obtener datos de recolección para edición (AJAX)
    public function getEditData(Recoleccion $recoleccion)
    {
        $producciones = Produccion::with('lote')
            ->whereIn('estado', ['maduracion', 'cosecha'])
            ->activos()
            ->get()
            ->map(function ($produccion) {
                return [
                    'id' => $produccion->id,
                    'display_name' => $produccion->lote ? 
                        "{$produccion->lote->nombre} - {$produccion->tipo_cacao}" : 
                        "Lote sin nombre - {$produccion->tipo_cacao}"
                ];
            });

        $trabajadores = Trabajador::activos()
            ->get()
            ->map(function ($trabajador) {
                return [
                    'id' => $trabajador->id,
                    'nombre_completo' => "{$trabajador->nombre} {$trabajador->apellido}"
                ];
            });

        return response()->json([
            'recoleccion' => [
                'id' => $recoleccion->id,
                'produccion_id' => $recoleccion->produccion_id,
                'fecha_recoleccion' => $recoleccion->fecha_recoleccion->format('Y-m-d'),
                'cantidad_recolectada' => $recoleccion->cantidad_recolectada,
                'estado_fruto' => $recoleccion->estado_fruto,
                'trabajadores_participantes' => $recoleccion->trabajadores_participantes ?? [],
                'condiciones_climaticas' => $recoleccion->condiciones_climaticas,
                'calidad_promedio' => $recoleccion->calidad_promedio,
                'observaciones' => $recoleccion->observaciones,
            ],
            'producciones' => $producciones,
            'trabajadores' => $trabajadores,
            'update_url' => route('recolecciones.update', $recoleccion)
        ]);
    }

    // Método para obtener estadísticas de recolección
    public function estadisticas($produccionId)
    {
        $produccion = Produccion::with('recolecciones')->find($produccionId);

        $stats = [
            'total_recolectado' => $produccion->total_recolectado,
            'porcentaje_completado' => $produccion->porcentaje_recoleccion_completado,
            'cantidad_pendiente' => $produccion->cantidad_pendiente_recoleccion,
            'dias_recolectando' => $produccion->recolecciones()->distinct('fecha_recoleccion')->count(),
            'promedio_diario' => $produccion->recolecciones()->count() > 0
                ? round($produccion->total_recolectado / $produccion->recolecciones()->distinct('fecha_recoleccion')->count(), 2)
                : 0,
            'ultima_recoleccion' => $produccion->ultimaRecoleccion()?->fecha_recoleccion?->format('d/m/Y')
        ];

        return response()->json($stats);
    }

    // Método privado para actualizar el estado de la producción
    private function actualizarEstadoProduccion(Produccion $produccion)
    {
        $porcentajeCompletado = $produccion->porcentaje_recoleccion_completado;

        if ($porcentajeCompletado >= 95 && $produccion->estado !== 'completado') {
            $produccion->update([
                'estado' => 'completado',
                'fecha_cosecha_real' => now(),
                'cantidad_cosechada' => $produccion->total_recolectado
            ]);
        } elseif ($porcentajeCompletado > 0 && $produccion->estado === 'maduracion') {
            $produccion->update(['estado' => 'cosecha']);
        }
    }
}
