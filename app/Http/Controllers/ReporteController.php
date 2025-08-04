<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Inventario;
use App\Models\Produccion;
use App\Models\Venta;
use App\Models\Trabajador;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        $metricas = $this->obtenerMetricas();
        return view('reporte.reporte', compact('metricas'));
    }

    public function obtenerData(Request $request, $tipo)
    {
        try {
            $filtros = $this->procesarFiltros($request);
            $data = $this->generarReporte($tipo, $filtros);
            
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            // Log del error completo para debugging
            \Log::error("Error en reporte $tipo: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => $this->manejarError($tipo, $e),
                'debug' => config('app.debug') ? [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ]);
        }
    }

    public function obtenerMetricasAjax(Request $request)
    {
        try {
            $filtros = $this->procesarFiltros($request);
            $metricas = $this->calcularMetricas($filtros);
            
            return response()->json(['success' => true, 'metricas' => $metricas]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al calcular métricas']);
        }
    }

    public function generarPDF(Request $request, $tipo)
    {
        try {
            $filtros = $this->procesarFiltros($request);
            $data = $this->generarReporte($tipo, $filtros);
            
            $pdf = Pdf::loadView('reporte.pdf-universal', compact('data', 'tipo', 'filtros'))
                     ->setPaper('a4', 'landscape');
            
            return $pdf->download("reporte-{$tipo}-" . now()->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar PDF: ' . $e->getMessage());
        }
    }

    public function generarPDFGeneral(Request $request)
    {
        try {
            $filtros = $this->procesarFiltros($request);
            $reportes = ['lote', 'inventario', 'ventas', 'produccion', 'trabajadores'];
            $datosCompletos = [];
            
            foreach ($reportes as $tipo) {
                $datosCompletos[$tipo] = $this->generarReporte($tipo, $filtros);
            }
            
            $pdf = Pdf::loadView('reporte.pdf-general', compact('datosCompletos', 'filtros'))
                     ->setPaper('a4', 'landscape');
            
            return $pdf->download('reporte-general-' . now()->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar reporte general: ' . $e->getMessage());
        }
    }

    private function procesarFiltros(Request $request)
    {
        $periodo = $request->input('periodo', 'mes');
        $fechaDesde = $request->input('fechaDesde');
        $fechaHasta = $request->input('fechaHasta');
        
        if ($periodo !== 'personalizado' || empty($fechaDesde) || empty($fechaHasta)) {
            switch ($periodo) {
                case 'mes':
                    $fechaDesde = Carbon::now()->subMonth()->format('Y-m-d');
                    $fechaHasta = Carbon::now()->format('Y-m-d');
                    break;
                case 'trimestre':
                    $fechaDesde = Carbon::now()->subMonths(3)->format('Y-m-d');
                    $fechaHasta = Carbon::now()->format('Y-m-d');
                    break;
                case 'año':
                    $fechaDesde = Carbon::now()->subYear()->format('Y-m-d');
                    $fechaHasta = Carbon::now()->format('Y-m-d');
                    break;
                default:
                    // Para todos los datos históricos
                    $fechaDesde = '2020-01-01';
                    $fechaHasta = Carbon::now()->format('Y-m-d');
                    break;
            }
        }
        
        return compact('periodo', 'fechaDesde', 'fechaHasta');
    }

    private function generarReporte($tipo, $filtros)
    {
        switch ($tipo) {
            case 'lote':
                return $this->reporteLotes($filtros);
            case 'inventario':
                return $this->reporteInventario($filtros);
            case 'ventas':
                return $this->reporteVentas($filtros);
            case 'produccion':
                return $this->reporteProduccion($filtros);
            case 'trabajadores':
                return $this->reporteTrabajadores($filtros);
            default:
                return ['items' => []];
        }
    }

    private function reporteLotes($filtros)
    {
        try {
            $lotes = Lote::all();
            
            $items = $lotes->map(function($lote) {
                return [
                    'nombre' => $lote->nombre ?? 'Sin nombre',
                    'fecha_inicio' => $lote->fecha_inicio ? $lote->fecha_inicio->format('Y-m-d') : 'Sin fecha',
                    'area' => $lote->area ?? 0,
                    'capacidad' => $lote->capacidad ? number_format($lote->capacidad, 0) . ' plantas' : 'Sin especificar',
                    'tipo_cacao' => $lote->tipo_cacao ?? 'Sin especificar',
                    'estado' => $lote->estado ?? 'Activo',
                    'observaciones' => $lote->observaciones ?? 'Sin observaciones'
                ];
            });

            return ['items' => $items->toArray()];
        } catch (\Exception $e) {
            \Log::error('Error en reporteLotes: ' . $e->getMessage());
            throw $e;
        }
    }

    private function reporteVentas($filtros)
    {
        try {
            $ventas = Venta::with(['recoleccion.produccion.lote'])
                          ->whereBetween('fecha_venta', [$filtros['fechaDesde'], $filtros['fechaHasta']])
                          ->get();
            
            $items = $ventas->map(function($venta) {
                $lote_nombre = 'Sin lote';
                
                if ($venta->recoleccion && $venta->recoleccion->produccion && $venta->recoleccion->produccion->lote) {
                    $lote_nombre = $venta->recoleccion->produccion->lote->nombre;
                }
                
                return [
                    'id' => $venta->id,
                    'fecha' => $venta->fecha_venta ? Carbon::parse($venta->fecha_venta)->format('Y-m-d') : 'Sin fecha',
                    'cliente' => $venta->cliente ?? 'Cliente General',
                    'lote_produccion' => $lote_nombre,
                    'cantidad' => $venta->cantidad_vendida ?? 0,
                    'precio_kg' => $venta->precio_por_kg ?? 0,
                    'total' => $venta->total_venta ?? 0,
                    'estado' => $venta->estado_pago ?? 'Sin estado',
                    'metodo' => $venta->metodo_pago ?? 'Sin método'
                ];
            });

            return ['items' => $items->toArray()];
        } catch (\Exception $e) {
            \Log::error('Error en reporteVentas: ' . $e->getMessage());
            throw $e;
        }
    }

    private function reporteTrabajadores($filtros)
    {
        try {
            // Obtener trabajadores desde la tabla trabajadors con JOIN a users
            $trabajadores = \DB::table('trabajadors')
                ->leftJoin('users', 'trabajadors.user_id', '=', 'users.id')
                ->select(
                    'trabajadors.id',
                    'users.name as nombre',
                    'trabajadors.direccion',
                    'users.email',
                    'trabajadors.telefono',
                    'trabajadors.tipo_contrato as contrato',
                    'users.estado',
                    'trabajadors.forma_pago as pago'
                )
                ->get();

            $items = $trabajadores->map(function($trabajador) {
                return [
                    'id' => $trabajador->id,
                    'nombre' => $trabajador->nombre ?? 'Sin nombre',
                    'direccion' => $trabajador->direccion ?? 'Sin dirección',
                    'email' => $trabajador->email ?? 'Sin email',
                    'telefono' => $trabajador->telefono ?? 'Sin teléfono',
                    'contrato' => $trabajador->contrato ?? 'Sin contrato',
                    'estado' => ucfirst($trabajador->estado ?? 'inactivo'),
                    'pago' => $trabajador->pago ?? 'Sin definir'
                ];
            });

            return ['items' => $items->toArray()];
        } catch (\Exception $e) {
            \Log::error('Error en reporteTrabajadores: ' . $e->getMessage());
            throw $e;
        }
    }

    private function reporteProduccion($filtros)
    {
        try {
            $producciones = Produccion::with('lote')
                          ->whereBetween('fecha_inicio', [$filtros['fechaDesde'], $filtros['fechaHasta']])
                          ->get();
            
            $items = $producciones->map(function($produccion) {
                // Calcular rendimiento
                $rendimiento = 0;
                if ($produccion->cantidad_cosechada && $produccion->area_asignada && $produccion->area_asignada > 0) {
                    $rendimiento = round(($produccion->cantidad_cosechada / $produccion->area_asignada), 2);
                }
                
                // Calcular progreso basado en estado y fechas
                $progreso = 0;
                
                // Si el estado es completado, el progreso es 100%
                if ($produccion->estado === 'completado') {
                    $progreso = 100;
                } elseif ($produccion->fecha_inicio && $produccion->fecha_programada_cosecha) {
                    $fechaInicio = Carbon::parse($produccion->fecha_inicio);
                    $fechaFin = Carbon::parse($produccion->fecha_programada_cosecha);
                    $hoy = Carbon::now();
                    
                    if ($hoy >= $fechaFin) {
                        $progreso = 100;
                    } elseif ($hoy <= $fechaInicio) {
                        $progreso = 0;
                    } else {
                        $totalDias = $fechaInicio->diffInDays($fechaFin);
                        $diasTranscurridos = $fechaInicio->diffInDays($hoy);
                        $progreso = $totalDias > 0 ? round(($diasTranscurridos / $totalDias) * 100, 1) : 0;
                    }
                }
                
                return [
                    'id' => $produccion->id,
                    'cultivo' => $produccion->tipo_cacao ?? 'Sin tipo',
                    'lote' => $produccion->lote->nombre ?? 'Sin lote',
                    'fecha_inicio' => $produccion->fecha_inicio ? Carbon::parse($produccion->fecha_inicio)->format('Y-m-d') : 'Sin fecha',
                    'fecha_fin_esperada' => $produccion->fecha_programada_cosecha ? Carbon::parse($produccion->fecha_programada_cosecha)->format('Y-m-d') : 'Sin fecha',
                    'area' => $produccion->area_asignada ?? 0,
                    'estado' => $produccion->estado ?? 'Sin estado',
                    'rendimiento' => $rendimiento,
                    'progreso' => $progreso
                ];
            });

            return ['items' => $items->toArray()];
        } catch (\Exception $e) {
            \Log::error('Error en reporteProduccion: ' . $e->getMessage());
            throw $e;
        }
    }

    private function reporteCostosGanancias($filtros)
    {
        $costos = Inventario::where('tipo', 'insumo')->sum('precio_unitario') ?? 0;
        $ventas = Venta::whereBetween('fecha_venta', [$filtros['fechaDesde'], $filtros['fechaHasta']])->sum('total_venta') ?? 0;
        $rentabilidad = $costos > 0 ? (($ventas - $costos) / $costos) * 100 : 0;

        $items = [
            ['concepto' => 'Operación General', 'costo' => $costos, 'venta' => $ventas, 'rentabilidad' => $rentabilidad]
        ];

        return ['items' => $items];
    }

    private function reporteRendimiento($filtros)
    {
        // Primero obtener todos los lotes y sus producciones
        $items = Lote::with('producciones')->get()->map(function($lote) use ($filtros) {
            // Si no hay filtros específicos, usar todas las producciones
            $producciones = $lote->producciones;
            
            // Aplicar filtros de fecha si están definidos
            if (!empty($filtros['fechaDesde']) && !empty($filtros['fechaHasta'])) {
                $producciones = $producciones->filter(function($prod) use ($filtros) {
                    $fechaComparar = $prod->fecha_cosecha_real ?? $prod->fecha_inicio ?? $prod->created_at;
                    if ($fechaComparar) {
                        $fecha = Carbon::parse($fechaComparar)->format('Y-m-d');
                        return $fecha >= $filtros['fechaDesde'] && $fecha <= $filtros['fechaHasta'];
                    }
                    return true; // Incluir si no hay fecha para comparar
                });
            }
            
            // Sumar cantidad cosechada real + estimaciones
            $produccionTotal = $producciones->sum(function($prod) {
                return $prod->cantidad_cosechada ?? $prod->estimacion_produccion ?? 0;
            });
            
            // Calcular rendimiento por hectárea del lote
            $rendimiento = ($lote->area > 0 && $produccionTotal > 0) ? 
                          round($produccionTotal / $lote->area, 2) : 0;
            
            return [
                'lote' => $lote->nombre,
                'area' => number_format($lote->area, 2),
                'produccion' => $produccionTotal,
                'rendimiento' => $rendimiento
            ];
        })->filter(function($item) {
            return $item['area'] > 0; // Mostrar todos los lotes con área definida
        });

        return ['items' => $items];
    }

    private function reporteCalidad($filtros)
    {
        $items = Produccion::with('lote')
                          ->where(function($q) use ($filtros) {
                              $q->whereBetween('fecha_cosecha_real', [$filtros['fechaDesde'], $filtros['fechaHasta']])
                                ->orWhereBetween('fecha_inicio', [$filtros['fechaDesde'], $filtros['fechaHasta']]);
                          })
                          ->get()
                          ->map(function($item) {
                              // Calcular calidad basada en rendimiento real vs estimado
                              $calidad = 3.0; // Base
                              if ($item->cantidad_cosechada && $item->estimacion_produccion && $item->estimacion_produccion > 0) {
                                  $eficiencia = ($item->cantidad_cosechada / $item->estimacion_produccion) * 100;
                                  if ($eficiencia >= 100) $calidad = 5.0;
                                  elseif ($eficiencia >= 80) $calidad = 4.5;
                                  elseif ($eficiencia >= 60) $calidad = 4.0;
                                  elseif ($eficiencia >= 40) $calidad = 3.5;
                              }
                              
                              return [
                                  'lote' => $item->lote->nombre ?? 'N/A',
                                  'humedad' => rand(60, 80) / 10, // Simulado
                                  'tamaño' => ['Grande', 'Mediano', 'Pequeño'][rand(0, 2)], // Simulado
                                  'defectos' => rand(0, 5), // Simulado
                                  'calidad' => $calidad
                              ];
                          });

        return ['items' => $items];
    }

    private function reporteInventario($filtros)
    {
        try {
            $inventarios = Inventario::all();
            
            $items = $inventarios->map(function($inventario) {
                $valor_total = ($inventario->cantidad ?? 0) * ($inventario->precio_unitario ?? 0);
                
                return [
                    'id' => $inventario->id,
                    'producto' => $inventario->nombre ?? 'Sin nombre',
                    'fecha' => $inventario->fecha_registro ? Carbon::parse($inventario->fecha_registro)->format('Y-m-d') : 'Sin fecha',
                    'cantidad' => $inventario->cantidad ?? 0,
                    'unidad' => $inventario->unidad_medida ?? 'unidad',
                    'precio_unitario' => $inventario->precio_unitario ?? 0,
                    'valor_total' => $valor_total,
                    'tipo' => $inventario->tipo ?? 'Sin tipo',
                    'estado' => $inventario->estado ?? 'Sin estado'
                ];
            });

            return ['items' => $items->toArray()];
        } catch (\Exception $e) {
            \Log::error('Error en reporteInventario: ' . $e->getMessage());
            throw $e;
        }
    }

    private function obtenerMetricas()
    {
        return [
            'total_lotes' => Lote::count(),
            'total_produccion' => Produccion::sum('cantidad_cosechada') + Produccion::whereNull('cantidad_cosechada')->sum('estimacion_produccion'),
            'total_ventas' => Venta::sum('total_venta') ?? 0,
            'rentabilidad' => $this->calcularRentabilidad(),
            'calidad_promedio' => $this->calcularCalidadPromedio(),
            'total_trabajadores' => Trabajador::count(),
        ];
    }

    private function calcularMetricas($filtros)
    {
        return [
            'total_lotes' => Lote::count(),
            'total_produccion' => $this->calcularProduccionTotal($filtros),
            'total_ventas' => Venta::whereBetween('fecha_venta', [$filtros['fechaDesde'], $filtros['fechaHasta']])->sum('total_venta') ?? 0,
            'rentabilidad' => $this->calcularRentabilidad(),
            'calidad_promedio' => $this->calcularCalidadPromedio(),
            'total_trabajadores' => Trabajador::count(),
        ];
    }

    private function calcularProduccionTotal($filtros)
    {
        // Obtener todas las producciones y aplicar filtros de fecha de manera más flexible
        $producciones = Produccion::all()->filter(function($prod) use ($filtros) {
            if (empty($filtros['fechaDesde']) || empty($filtros['fechaHasta'])) {
                return true; // Sin filtros, incluir todo
            }
            
            $fechaComparar = $prod->fecha_cosecha_real ?? $prod->fecha_inicio ?? $prod->created_at;
            if ($fechaComparar) {
                $fecha = Carbon::parse($fechaComparar)->format('Y-m-d');
                return $fecha >= $filtros['fechaDesde'] && $fecha <= $filtros['fechaHasta'];
            }
            return true;
        });

        return $producciones->sum(function($prod) {
            return $prod->cantidad_cosechada ?? $prod->estimacion_produccion ?? 0;
        });
    }

    private function calcularCalidadPromedio()
    {
        $producciones = Produccion::whereNotNull('cantidad_cosechada')
                                  ->whereNotNull('estimacion_produccion')
                                  ->where('estimacion_produccion', '>', 0)
                                  ->get();

        if ($producciones->count() == 0) return 3.5; // Valor por defecto

        $calidades = $producciones->map(function($prod) {
            $eficiencia = ($prod->cantidad_cosechada / $prod->estimacion_produccion) * 100;
            if ($eficiencia >= 100) return 5.0;
            elseif ($eficiencia >= 80) return 4.5;
            elseif ($eficiencia >= 60) return 4.0;
            elseif ($eficiencia >= 40) return 3.5;
            return 3.0;
        });

        return $calidades->avg();
    }

    private function calcularRentabilidad()
    {
        $totalVentas = Venta::sum('total_venta') ?? 0;
        $totalCostos = Inventario::sum('precio_unitario') ?? 0;
        
        return $totalCostos > 0 ? (($totalVentas - $totalCostos) / $totalCostos) * 100 : 0;
    }

    private function manejarError($tipo, $exception)
    {
        $mensajes = [
            'lote' => 'Error al cargar datos de lotes. Verifique la base de datos.',
            'produccion' => 'No existen lotes en el período seleccionado. Amplíe el rango de fechas.',
            'costos' => 'Faltan datos de costos para algunos insumos. Verifique el inventario.',
            'rendimiento' => 'Error al calcular rendimiento. Verifique los datos de área de lotes.',
            'calidad' => 'No existen parámetros de calidad definidos para este período.',
            'inventario' => 'Error al acceder a los datos de inventario.',
            'ventas' => 'Error al cargar datos de ventas.',
            'trabajadores' => 'Error al cargar datos de trabajadores.'
        ];

        return $mensajes[$tipo] ?? 'Error inesperado al generar el reporte.';
    }

    // ===== FUNCIONES PDF =====
    
    public function exportarPdfIndividual(Request $request, $tipo)
    {
        try {
            $filtros = $this->procesarFiltros($request);
            $data = $this->generarReporte($tipo, $filtros);
            $metricas = $this->obtenerMetricas();
            
            $datos = [
                'tipo' => $tipo,
                'data' => $data,
                'metricas' => $metricas,
                'filtros' => $filtros,
                'fecha_generacion' => now()->format('d/m/Y H:i:s')
            ];
            
            $pdf = Pdf::loadView('reporte.pdf_individual', $datos);
            $pdf->setPaper('a4', 'landscape');
            
            $nombreArchivo = 'reporte_' . $tipo . '_' . now()->format('Y-m-d') . '.pdf';
            return $pdf->download($nombreArchivo);
            
        } catch (\Exception $e) {
            \Log::error("Error al generar PDF $tipo: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
    
    public function exportarPdfGeneral(Request $request)
    {
        try {
            $filtros = $this->procesarFiltros($request);
            $metricas = $this->obtenerMetricas();
            
            // Obtener datos de todos los tipos
            $datosCompletos = [
                'lote' => $this->generarReporte('lote', $filtros),
                'inventario' => $this->generarReporte('inventario', $filtros),
                'ventas' => $this->generarReporte('ventas', $filtros),
                'produccion' => $this->generarReporte('produccion', $filtros),
                'trabajadores' => $this->generarReporte('trabajadores', $filtros)
            ];
            
            $datos = [
                'datosCompletos' => $datosCompletos,
                'metricas' => $metricas,
                'filtros' => $filtros,
                'fecha_generacion' => now()->format('d/m/Y H:i:s')
            ];
            
            $pdf = Pdf::loadView('reporte.pdf_general', $datos);
            $pdf->setPaper('a4', 'landscape');
            
            $nombreArchivo = 'reporte_general_' . now()->format('Y-m-d') . '.pdf';
            return $pdf->download($nombreArchivo);
            
        } catch (\Exception $e) {
            \Log::error("Error al generar PDF general: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el PDF general: ' . $e->getMessage());
        }
    }
}
