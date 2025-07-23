<?php

namespace App\Http\Controllers;

use App\Models\Recoleccion;
use App\Models\Produccion;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecoleccionController extends Controller
{
    public function index(Request $request)
    {
        $query = Recoleccion::with(['produccion.lote'])
            ->activos();

        // Aplicar filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('produccion.lote', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%");
                })
                ->orWhereHas('produccion', function ($q) use ($search) {
                    $q->where('tipo_cacao', 'like', "%$search%");
                });
            });
        }

        // Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_recoleccion', '>=', $request->input('fecha_desde'));
        }

        // Filtro por estado del fruto
        if ($request->filled('estado_fruto')) {
            $query->where('estado_fruto', $request->input('estado_fruto'));
        }

        $recolecciones = $query->orderBy('fecha_recoleccion', 'desc')->paginate(10);
            
        return view('recolecciones.index', compact('recolecciones'));
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

        // Verificar que la producción no esté completada
        $produccion = Produccion::find($request->produccion_id);
        if ($produccion->estado === 'completado') {
            return back()->withErrors(['produccion_id' => 'No se puede agregar recolección a una producción completada.']);
        }

        // Verificar que no exceda la estimación de producción
        $totalRecolectado = $produccion->total_recolectado + $request->cantidad_recolectada;
        if ($totalRecolectado > $produccion->estimacion_produccion * 1.2) { // 20% de tolerancia
            return back()->withErrors([
                'cantidad_recolectada' => 'La cantidad total recolectada excedería significativamente la estimación de producción.'
            ]);
        }

        // Crear la recolección
        $recoleccion = Recoleccion::create($request->all());

        // Actualizar el estado de la producción si es necesario
        $this->actualizarEstadoProduccion($produccion);

        return redirect()->route('produccion.show', $produccion->id)
            ->with('success', 'Recolección registrada exitosamente.');
    }

    public function show(Recoleccion $recoleccion)
    {
        // Cargar todas las relaciones necesarias
        $recoleccion->load([
            'produccion.lote', 
            'produccion' => function($query) {
                $query->withCount('recolecciones');
            }
        ]);
        
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

        $produccion = Produccion::find($request->produccion_id);
        
        // Verificar límites de recolección
        $totalRecolectado = $produccion->total_recolectado - $recoleccion->cantidad_recolectada + $request->cantidad_recolectada;
        if ($totalRecolectado > $produccion->estimacion_produccion * 1.2) {
            return back()->withErrors([
                'cantidad_recolectada' => 'La cantidad total recolectada excedería significativamente la estimación de producción.'
            ]);
        }

        $recoleccion->update($request->all());

        // Actualizar el estado de la producción
        $this->actualizarEstadoProduccion($produccion);

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
        $recolecciones = Recoleccion::with('trabajadoresParticipantes')
            ->where('produccion_id', $produccionId)
            ->activos()
            ->orderBy('fecha_recoleccion', 'desc')
            ->get();

        return response()->json($recolecciones);
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
