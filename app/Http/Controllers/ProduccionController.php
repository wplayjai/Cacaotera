<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Lote;
use App\Models\Trabajador;
use App\Models\Inventario;
use App\Models\SalidaInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProduccionController extends Controller
{
    // ...existing code...

    // Iniciar producción (cambia estado a 'siembra')
    public function iniciarProduccion($id)
    {
        $produccion = Produccion::findOrFail($id);
        if ($produccion->estado == 'planificado') {
            $produccion->estado = 'siembra';
            $produccion->fecha_cambio_estado = now();
            $produccion->save();
            return redirect()->back()->with('success', 'Producción iniciada correctamente.');
        }
        return redirect()->back()->with('error', 'Solo se puede iniciar una producción planificada.');
    }

    // Completar producción (cambia estado a 'completado')
    public function completarProduccion($id)
    {
        $produccion = Produccion::findOrFail($id);
        if (in_array($produccion->estado, ['siembra','crecimiento','maduracion','cosecha','secado'])) {
            $produccion->estado = 'completado';
            $produccion->fecha_cambio_estado = now();
            $produccion->save();
            return redirect()->back()->with('success', 'Producción completada correctamente.');
        }
        return redirect()->back()->with('error', 'Solo se puede completar una producción en proceso.');
    }
   public function index(Request $request)
    {
        // Definir estados "en producción"
        $estadosEnProduccion = ['planificado', 'siembra', 'crecimiento', 'maduracion', 'cosecha', 'secado'];

        // Construir consulta para producciones
        $query = Produccion::with(['lote', 'trabajadores', 'insumos'])
                           ->whereIn('estado', $estadosEnProduccion);

        // Aplicar filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tipo_cacao', 'like', "%$search%")
                  ->orWhereHas('lote', function ($q) use ($search) {
                      $q->where('nombre', 'like', "%$search%")
                        ->orWhere('ubicacion', 'like', "%$search%");
                  });
            });
        }

     
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_inicio', '>=', $request->input('fecha_inicio'));
        }

        // Obtener producciones paginadas
        $producciones = $query->orderBy('fecha_inicio', 'desc')->paginate(10);

        // Obtener producciones próximas a cosecha
        $proximosCosecha = Produccion::proximosCosecha()->with('lote')->get();

        // Calcular estadísticas
        $estadisticas = [
            'total' => Produccion::whereIn('estado', $estadosEnProduccion)->count(),
            'en_proceso' => Produccion::whereIn('estado', ['siembra', 'crecimiento', 'maduracion', 'cosecha'])->count(),
            'completadas' => Produccion::where('estado', 'completado')->count(),
            'area_total' => Produccion::whereIn('estado', $estadosEnProduccion)->sum('area_asignada'),
        ];

        return view('produccion.index', compact('producciones', 'proximosCosecha', 'estadisticas'));
    }

    // Métodos create y store (sin cambios, como los proporcionaste)
    public function create()
    {
        // Marcar lotes con capacidad disponible
        $lotes = Lote::where('estado', 'activo')
            ->get()
            ->map(function($lote) {
                $lote->disponible = $lote->area_hectareas > Produccion::where('lote_id', $lote->id)
                    ->whereIn('estado', ['planificado','siembra','crecimiento','maduracion','cosecha','secado'])
                    ->sum('area_asignada') ? ($lote->area_hectareas - Produccion::where('lote_id', $lote->id)
                    ->whereIn('estado', ['planificado','siembra','crecimiento','maduracion','cosecha','secado'])
                    ->sum('area_asignada')) > 0 : true;
                return $lote;
            });

        $trabajadores = Trabajador::whereHas('user', function ($query) {
            $query->where('estado', 'activo');
        })->with('user')->get();
        $insumos = Inventario::where('tipo', 'insumo')->get();

        return view('produccion.create', compact('lotes', 'trabajadores', 'insumos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'tipo_cacao' => 'required|string|max:100',
            'trabajadores' => 'required|array|min:1',
            'trabajadores.*' => 'exists:trabajadors,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin_esperada' => 'required|date|after:fecha_inicio',
            'fecha_programada_cosecha' => 'nullable|date|after:fecha_inicio',
            'area_asignada' => 'required|numeric|min:0',
            'estimacion_produccion' => 'required|numeric|min:0',
            'estado' => 'required|in:planificado,siembra,crecimiento,maduracion,cosecha,secado,completado',
            'costo_total' => 'nullable|numeric|min:0',
            'tipo_siembra' => 'nullable|in:directa,transplante,injerto',
            'observaciones' => 'nullable|string|max:1000',
            'insumos' => 'nullable|array',
            'insumos.*.id' => 'exists:inventarios,id',
            'insumos.*.cantidad' => 'nullable|numeric|min:0',
        ]);

        // Validar que el lote tenga capacidad disponible
        $lote = Lote::find($request->lote_id);
        $areaOcupada = Produccion::where('lote_id', $lote->id)
            ->whereIn('estado', ['planificado','siembra','crecimiento','maduracion','cosecha','secado'])
            ->sum('area_asignada');
        $areaDisponible = $lote->area_hectareas - $areaOcupada;
        if ($request->area_asignada > $areaDisponible) {
            return redirect()->back()->withInput()->with('error', 'El área asignada excede la capacidad disponible del lote.');
        }

        // Validar que no exista producción duplicada en el mismo lote y fecha inicio
        $existe = Produccion::where('lote_id', $request->lote_id)
            ->whereDate('fecha_inicio', $request->fecha_inicio)
            ->whereIn('estado', ['planificado','siembra','crecimiento','maduracion','cosecha','secado'])
            ->exists();
        if ($existe) {
            return redirect()->back()->withInput()->with('error', 'Ya existe una producción registrada para este lote y fecha de inicio.');
        }

        DB::beginTransaction();
        try {
            $produccion = Produccion::create([
                'lote_id' => $request->lote_id,
                'tipo_cacao' => $request->tipo_cacao,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin_esperada' => $request->fecha_fin_esperada,
                'fecha_programada_cosecha' => $request->fecha_programada_cosecha,
                'area_asignada' => $request->area_asignada,
                'estimacion_produccion' => $request->estimacion_produccion,
                'estado' => $request->estado ?? 'planificado',
                'fecha_cambio_estado' => now(),
                'costo_total' => $request->costo_total,
                'tipo_siembra' => $request->tipo_siembra,
                'observaciones' => $request->observaciones,
                'activo' => true,
            ]);

            foreach ($request->trabajadores as $trabajador_id) {
                $produccion->trabajadores()->attach($trabajador_id, [
                    'fecha_asignacion' => now(),
                    'rol' => 'operario',
                    'horas_trabajadas' => 0,
                    'tarifa_hora' => null,
                ]);
            }

            if ($request->insumos) {
                foreach ($request->insumos as $insumo) {
                    if ($insumo['cantidad'] > 0) {
                        $inventario = Inventario::find($insumo['id']);
                        if ($inventario->cantidad >= $insumo['cantidad']) {
                            $costo_unitario = $inventario->costo_unitario ?? 0;
                            SalidaInventario::create([
                                'insumo_id' => $insumo['id'],
                                'produccion_id' => $produccion->id,
                                'cantidad' => $insumo['cantidad'],
                                'motivo' => 'Uso en producción',
                                'fecha_salida' => now(),
                                'responsable' => auth()->user()->name,
                            ]);
                            $inventario->decrement('cantidad', $insumo['cantidad']);
                            $produccion->insumos()->attach($insumo['id'], [
                                'cantidad_utilizada' => $insumo['cantidad'],
                                'fecha_uso' => now(),
                                'costo_unitario' => $costo_unitario,
                                'costo_total' => $costo_unitario * $insumo['cantidad'],
                            ]);
                        } else {
                            throw new \Exception("Stock insuficiente para el insumo: {$inventario->nombre}");
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('produccion.index')
                ->with('success', 'Producción creada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear la producción: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function show(Produccion $produccion)
    {
        $produccion->load(['lote', 'trabajadores.user', 'insumos', 'salidaInventarios.insumo']);
        
        return view('produccion.show', compact('produccion'));
    }

    public function edit(Produccion $produccion)
    {
        $lotes = Lote::where('activo', true)->get();
        $trabajadores = Trabajador::with('user')->get();
        $insumos = Inventario::where('activo', true) // Corregido: era 'disponible'
            ->where('tipo', 'insumo')
            ->get();

        $produccion->load(['trabajadores', 'salidaInventarios.insumo']);

        return view('produccion.edit', compact('produccion', 'lotes', 'trabajadores', 'insumos'));
    }

    public function update(Request $request, Produccion $produccion)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'fecha_inicio' => 'required|date',
            'tipo_cacao' => 'required|string',
            'area_asignada' => 'required|numeric|min:0',
            'estimacion_produccion' => 'required|numeric|min:0',
            'fecha_programada_cosecha' => 'required|date',
            'estado' => 'required|in:' . implode(',', array_keys(Produccion::ESTADOS)),
            'cantidad_cosechada' => 'nullable|numeric|min:0',
            'fecha_cosecha_real' => 'nullable|date',
            'trabajadores' => 'required|array',
            'trabajadores.*' => 'exists:trabajadores,id',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            $estadoAnterior = $produccion->estado;
            
            $produccion->update([
                'lote_id' => $request->lote_id,
                'fecha_inicio' => $request->fecha_inicio,
                'tipo_cacao' => $request->tipo_cacao,
                'area_asignada' => $request->area_asignada,
                'estimacion_produccion' => $request->estimacion_produccion,
                'fecha_programada_cosecha' => $request->fecha_programada_cosecha,
                'estado' => $request->estado,
                'cantidad_cosechada' => $request->cantidad_cosechada,
                'fecha_cosecha_real' => $request->fecha_cosecha_real,
                'observaciones' => $request->observaciones,
                'personal_asignado' => $request->trabajadores,
                'fecha_cambio_estado' => $estadoAnterior != $request->estado ? now() : $produccion->fecha_cambio_estado
            ]);

            // Calcular rendimiento y desviación si hay cantidad cosechada
            if ($request->cantidad_cosechada) {
                $produccion->calcularDesviacion();
                $produccion->rendimiento_real = $produccion->porcentajeRendimiento();
                $produccion->save();
            }

            // Actualizar trabajadores
            $produccion->trabajadores()->sync($request->trabajadores);

            DB::commit();
            return redirect()->route('produccion.index')
                ->with('success', 'Producción actualizada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar la producción: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Produccion $produccion)
    {
        DB::beginTransaction();
        try {
            // Restaurar inventario de insumos utilizados
            foreach ($produccion->salidaInventarios as $salida) {
                $salida->insumo->increment('cantidad', $salida->cantidad);
                $salida->delete();
            }

            // Desasociar trabajadores
            $produccion->trabajadores()->detach();

            // Marcar como inactivo en lugar de eliminar
            $produccion->update(['activo' => false]);

            DB::commit();
            return redirect()->route('produccion.index')
                ->with('success', 'Producción eliminada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar la producción: ' . $e->getMessage());
        }
    }

    public function cambiarEstado(Request $request, Produccion $produccion)
    {
        $request->validate([
            'estado' => 'required|in:planificado,siembra,crecimiento,maduracion,cosecha,secado,completado',
            'observaciones' => 'nullable|string|max:500'
        ]);
        $estadoAnterior = $produccion->estado;
        // Si el cambio es anormal, se puede registrar una alerta aquí (ejemplo)
        if (in_array($estadoAnterior, ['crecimiento','maduracion']) && $request->estado == 'cosecha' && empty($request->observaciones)) {
            return redirect()->back()->with('error', 'Debe registrar observaciones para cambios anormales de estado.');
        }
        $produccion->update([
            'estado' => $request->estado,
            'fecha_cambio_estado' => now(),
            'observaciones' => $request->observaciones
        ]);
        return redirect()->back()->with('success', 'Estado actualizado exitosamente');
    }

    public function registrarCosecha(Request $request, Produccion $produccion)
    {
        $request->validate([
            'cantidad_cosechada' => 'required|numeric|min:0',
            'fecha_cosecha_real' => 'required|date',
            'observaciones' => 'nullable|string|max:500'
        ]);
        $porcentaje = $request->cantidad_cosechada / ($produccion->estimacion_produccion ?: 1);
        if ($porcentaje < 0.8) {
            // Generar informe de desviación (puedes implementar lógica extra aquí)
            // Por ahora solo alerta
            session()->flash('error', 'El rendimiento real es inferior al 80% del estimado. Se generará informe de desviación.');
        }
        $produccion->update([
            'cantidad_cosechada' => $request->cantidad_cosechada,
            'fecha_cosecha_real' => $request->fecha_cosecha_real,
            'estado' => 'cosecha',
            'fecha_cambio_estado' => now(),
            'observaciones' => $request->observaciones
        ]);
        // Calcular métricas
        $produccion->calcularDesviacion();
        $produccion->rendimiento_real = $produccion->porcentajeRendimiento();
        $produccion->save();
        return redirect()->back()->with('success', 'Cosecha registrada exitosamente');
    }

    public function reporteRendimiento()
    {
        $producciones = Produccion::with('lote')
            ->whereNotNull('cantidad_cosechada')
            ->orderBy('fecha_cosecha_real', 'desc')
            ->get();

        $estadisticas = [
            'total_producciones' => $producciones->count(),
            'promedio_rendimiento' => $producciones->avg('rendimiento_real'),
            'mayor_rendimiento' => $producciones->max('rendimiento_real'),
            'menor_rendimiento' => $producciones->min('rendimiento_real'),
            'total_cosechado' => $producciones->sum('cantidad_cosechada'),
            'total_estimado' => $producciones->sum('estimacion_produccion')
        ];

        return view('produccion.reporte-rendimiento', compact('producciones', 'estadisticas'));
    }

    public function exportarReporte()
    {
        // Implementar exportación a Excel/PDF
        // Usar Laravel Excel o similar
    }
}