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

            // Actualizar métricas de rendimiento automáticamente
            $produccion->actualizarMetricasRendimiento();

            return redirect()->back()->with('success', 'Producción completada correctamente. Métricas de rendimiento actualizadas.');
        }
        return redirect()->back()->with('error', 'Solo se puede completar una producción en proceso.');
    }
   public function index(Request $request)
    {
        // Definir estados "en producción"
        $estadosEnProduccion = ['planificado', 'siembra', 'crecimiento', 'maduracion', 'cosecha', 'secado'];

        // Construir consulta para producciones
    $query = Produccion::with(['lote', 'trabajadores', 'insumos'])
               ->whereIn('estado', $estadosEnProduccion)
               ->where('activo', true);

        // Aplicar filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tipo_cacao', 'like', "%$search%")
                  ->orWhereHas('lote', function ($q) use ($search) {
                      $q->where('nombre', 'like', "%$search%");
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
        // Obtener lotes activos
        $lotes = Lote::where('estado', 'Activo')->get();

        // Obtener trabajadores activos
        $trabajadores = Trabajador::whereHas('user', function ($query) {
            $query->where('estado', 'activo');
        })->with('user')->get();

        // Obtener insumos disponibles
        $insumos = Inventario::where('estado', 'activo')
            ->where('tipo', 'insumo')->get();

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

        // Validar que el lote tenga capacidad disponible (DESHABILITADO)
        /*
        $lote = Lote::find($request->lote_id);
        $areaOcupada = Produccion::where('lote_id', $lote->id)
            ->whereIn('estado', ['planificado','siembra','crecimiento','maduracion','cosecha','secado'])
            ->sum('area_asignada');
        $areaDisponible = $lote->area_hectareas - $areaOcupada;
        if ($request->area_asignada > $areaDisponible) {
            return redirect()->back()->withInput()->with('error', 'El área asignada excede la capacidad disponible del lote.');
        }
        */

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
        $produccion->load([
            'lote',
            'trabajadores.user',
            'insumos',
            'salidaInventarios' => function($query) use ($produccion) {
                $query->where('lote_id', $produccion->lote_id)
                      ->with('insumo', 'lote');
            }
        ]);

        return view('produccion.show', compact('produccion'));
    }

    public function edit(Produccion $produccion)
    {
        $lotes = Lote::where('estado', 'Activo')->get();
        $trabajadores = Trabajador::with('user')->get();
        $insumos = Inventario::where('estado', 'activo') // Corregido: usar columna 'estado'
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
            'trabajadores.*' => 'exists:trabajadors,id',
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

    public function reporteRendimiento(Request $request)
    {
        // Filtros de fecha
        $fechaDesde = $request->input('fecha_desde', now()->subMonths(3)->format('Y-m-d'));
        $fechaHasta = $request->input('fecha_hasta', now()->format('Y-m-d'));
        $estado = $request->input('estado');
        $tipoCacao = $request->input('tipo_cacao');
        $search = $request->input('search');

        // Construir consulta base
        $query = Produccion::with(['lote', 'recolecciones'])
            ->whereBetween('fecha_inicio', [$fechaDesde, $fechaHasta]);

        // Aplicar filtro de búsqueda
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tipo_cacao', 'like', "%$search%")
                  ->orWhereHas('lote', function ($q) use ($search) {
                      $q->where('nombre', 'like', "%$search%");
                  });
            });
        }

        // Aplicar filtros adicionales
        if ($estado) {
            $query->where('estado', $estado);
        }

        if ($tipoCacao) {
            $query->where('tipo_cacao', $tipoCacao);
        }

        $producciones = $query->orderBy('fecha_inicio', 'desc')->paginate(15);

        // Estadísticas generales
        $estadisticas = [
            'total_producciones' => $producciones->total(),
            'area_total' => $query->sum('area_asignada'),
            'produccion_total' => $query->get()->sum('total_recolectado'),
            'rendimiento_promedio' => $this->calcularRendimientoPromedio($query->get())
        ];

        // Obtener tipos de cacao únicos para el filtro
        $tiposCacao = Produccion::distinct()->pluck('tipo_cacao')->filter();

        // Datos para gráficos
        $rendimientoPorMes = $this->obtenerRendimientoPorMes($fechaDesde, $fechaHasta);
        $distribucionTipos = $this->obtenerDistribucionTipos($fechaDesde, $fechaHasta);

        // Análisis de desviaciones (producciones con bajo rendimiento)
        $desviaciones = $query->get()->filter(function ($produccion) {
            $porcentaje = $produccion->estimacion_produccion > 0
                ? ($produccion->total_recolectado / $produccion->estimacion_produccion) * 100
                : 0;
            return $porcentaje < 80 || $porcentaje > 120; // Desviaciones significativas
        })->map(function ($produccion) {
            $porcentaje = $produccion->estimacion_produccion > 0
                ? ($produccion->total_recolectado / $produccion->estimacion_produccion) * 100
                : 0;
            $produccion->porcentaje_rendimiento = $porcentaje;
            $produccion->desviacion_estimacion = $produccion->total_recolectado - $produccion->estimacion_produccion;
            return $produccion;
        });

        // Si es una solicitud de exportación
        if ($request->has('formato')) {
            return $this->exportarReporte($request->input('formato'), $producciones, $estadisticas);
        }

        return view('produccion.reporte', compact(
            'producciones',
            'estadisticas',
            'tiposCacao',
            'rendimientoPorMes',
            'distribucionTipos',
            'desviaciones'
        ));
    }

    private function calcularRendimientoPromedio($producciones)
    {
        $total = $producciones->count();
        if ($total === 0) return 0;

        $sumaRendimientos = $producciones->sum(function ($produccion) {
            return $produccion->estimacion_produccion > 0
                ? ($produccion->total_recolectado / $produccion->estimacion_produccion) * 100
                : 0;
        });

        return round($sumaRendimientos / $total, 1);
    }

    private function obtenerRendimientoPorMes($fechaDesde, $fechaHasta)
    {
        return Produccion::selectRaw('
                DATE_FORMAT(fecha_inicio, "%Y-%m") as mes,
                AVG(
                    CASE
                        WHEN estimacion_produccion > 0
                        THEN (
                            (SELECT COALESCE(SUM(cantidad_recolectada), 0)
                             FROM recolecciones
                             WHERE produccion_id = producciones.id AND activo = 1)
                            / estimacion_produccion
                        ) * 100
                        ELSE 0
                    END
                ) as rendimiento_promedio
            ')
            ->whereBetween('fecha_inicio', [$fechaDesde, $fechaHasta])
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($item) {
                return [
                    'mes' => Carbon::createFromFormat('Y-m', $item->mes)->format('M Y'),
                    'rendimiento_promedio' => round($item->rendimiento_promedio, 1)
                ];
            });
    }

    private function obtenerDistribucionTipos($fechaDesde, $fechaHasta)
    {
        return Produccion::selectRaw('
                tipo_cacao as tipo,
                SUM(
                    (SELECT COALESCE(SUM(cantidad_recolectada), 0)
                     FROM recolecciones
                     WHERE produccion_id = producciones.id AND activo = 1)
                ) as cantidad
            ')
            ->whereBetween('fecha_inicio', [$fechaDesde, $fechaHasta])
            ->groupBy('tipo_cacao')
            ->get()
            ->map(function ($item) {
                return [
                    'tipo' => ucfirst($item->tipo),
                    'cantidad' => round($item->cantidad, 2)
                ];
            });
    }

    public function exportarReporte($formato, $producciones, $estadisticas)
    {
        switch ($formato) {
            case 'pdf':
                return $this->exportarPDF($producciones, $estadisticas);
            case 'excel':
                return $this->exportarExcel($producciones, $estadisticas);
            default:
                return redirect()->back()->with('error', 'Formato de exportación no válido');
        }
    }

    private function exportarPDF($producciones, $estadisticas)
    {
        // Implementar exportación a PDF usando DomPDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('produccion.reporte-pdf', compact('producciones', 'estadisticas'));

        return $pdf->download('reporte-rendimiento-' . date('Y-m-d') . '.pdf');
    }

    private function exportarExcel($producciones, $estadisticas)
    {
        // Implementar exportación a Excel
        // Por ahora, retornar CSV simple
        $filename = 'reporte-rendimiento-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($producciones) {
            $file = fopen('php://output', 'w');

            // Encabezados CSV
            fputcsv($file, [
                'ID', 'Tipo Cacao', 'Lote', 'Área (ha)', 'Estado',
                'Estimado (kg)', 'Recolectado (kg)', 'Rendimiento (%)',
                'Fecha Inicio', 'Fecha Cosecha'
            ]);

            // Datos
            foreach ($producciones as $produccion) {
                $porcentaje = $produccion->estimacion_produccion > 0
                    ? ($produccion->total_recolectado / $produccion->estimacion_produccion) * 100
                    : 0;

                fputcsv($file, [
                    $produccion->id,
                    $produccion->tipo_cacao,
                    $produccion->lote->nombre ?? 'N/A',
                    $produccion->area_asignada,
                    $produccion->estado,
                    $produccion->estimacion_produccion,
                    $produccion->total_recolectado,
                    round($porcentaje, 1),
                    $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'N/A',
                    $produccion->fecha_cosecha_real ? $produccion->fecha_cosecha_real->format('d/m/Y') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Obtener trabajadores disponibles para una producción
     */
    public function trabajadoresDisponibles($id)
    {
        try {
            $trabajadores = Trabajador::whereHas('user', function ($query) {
                $query->where('estado', 'activo');
            })->with('user')->get();

            return response()->json($trabajadores->map(function ($trabajador) {
                return [
                    'id' => $trabajador->id,
                    'nombre' => $trabajador->nombre_completo,
                    'user_name' => $trabajador->user ? $trabajador->user->name : null
                ];
            }));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar trabajadores'], 500);
        }
    }
/**
     * Obtener la producción activa para un lote específico
     */
    public function obtenerProduccionActivaPorLote($loteId)
    {
        try {
            // Definir estados que se consideran "activos" o "en producción"
            $estadosActivos = ['planificado', 'siembra', 'crecimiento', 'maduracion', 'cosecha', 'secado'];
            
            $produccion = Produccion::where('lote_id', $loteId)
                ->whereIn('estado', $estadosActivos)
                ->where('activo', true)
                ->with(['lote', 'trabajadores.user'])
                ->first();

            if (!$produccion) {
                return response()->json([
                    'error' => 'No se encontró una producción activa para el lote seleccionado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'produccion_id' => $produccion->id,
                'produccion' => [
                    'id' => $produccion->id,
                    'tipo_cacao' => $produccion->tipo_cacao,
                    'estado' => $produccion->estado,
                    'fecha_inicio' => $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : null,
                    'area_asignada' => $produccion->area_asignada,
                    'estimacion_produccion' => $produccion->estimacion_produccion,
                    'lote' => [
                        'id' => $produccion->lote->id,
                        'nombre' => $produccion->lote->nombre
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al obtener producción activa por lote: ' . $e->getMessage());
            return response()->json([
                'error' => 'No se pudo obtener la producción activa para el lote seleccionado.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todas las producciones activas para un lote específico
     */
    public function obtenerProduccionesActivasPorLote($loteId)
    {
        try {
            $estadosActivos = ['planificado', 'siembra', 'crecimiento', 'maduracion', 'cosecha', 'secado'];
            
            $producciones = Produccion::where('lote_id', $loteId)
                ->whereIn('estado', $estadosActivos)
                ->where('activo', true)
                ->with(['lote'])
                ->orderBy('fecha_inicio', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'producciones' => $producciones->map(function ($produccion) {
                    return [
                        'id' => $produccion->id,
                        'tipo_cacao' => $produccion->tipo_cacao,
                        'estado' => $produccion->estado,
                        'fecha_inicio' => $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : null,
                        'area_asignada' => $produccion->area_asignada,
                        'estimacion_produccion' => $produccion->estimacion_produccion
                    ];
                })
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al obtener producciones activas por lote: ' . $e->getMessage());
            return response()->json([
                'error' => 'No se pudieron obtener las producciones activas para el lote seleccionado.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
