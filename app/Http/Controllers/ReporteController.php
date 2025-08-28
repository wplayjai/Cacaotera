<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Lote;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\Produccion;
use App\Models\Trabajador;
use App\Models\User;
use App\Models\SalidaInventario;
use App\Models\Recoleccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller
{
    public function index()
    {
        $metricas = $this->calcularMetricasReales();
        return view('reporte.reporte', compact('metricas'));
    }

    public function obtenerData(Request $request, $tipo)
    {
        try {
            $data = $this->generarReportePorTipo($tipo);
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar datos: ' . $e->getMessage()
            ]);
        }
    }

    public function obtenerMetricasAjax(Request $request)
    {
        try {
            $metricas = $this->calcularMetricasReales();
            return response()->json(['success' => true, 'metricas' => $metricas]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al calcular métricas']);
        }
    }

    public function exportarPdfIndividual(Request $request, $tipo)
    {
        try {
            $data = $this->generarReportePorTipo($tipo);
            $metricas = $this->calcularMetricasReales();

            $datos = [
                'tipo' => $tipo,
                'data' => $data,
                'metricas' => $metricas,
                'fecha_generacion' => Carbon::now()->format('d/m/Y H:i:s')
            ];

            $pdf = Pdf::loadView('reportes.reporte-individual', $datos);
            $pdf->setPaper('A4', 'landscape');

            $nombreArchivo = 'reporte_' . $tipo . '_' . Carbon::now()->format('Y-m-d') . '.pdf';
            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar PDF: ' . $e->getMessage()], 500);
        }
    }



    public function generarReporteGeneral(Request $request)
{
    try {
        Log::info('Iniciando generación de PDF general', [
            'user' => auth()->user()->name ?? 'Anónimo',
            'timestamp' => now()
        ]);

        $datosCompletos = $this->obtenerDatosReales();
        $metricas = $this->calcularMetricasReales();

        $data = [
            'datosCompletos' => $datosCompletos,
            'metricas' => $metricas,
            'fecha_generacion' => Carbon::now()->format('d/m/Y H:i:s'),
            'periodo' => $request->get('periodo', 'Todos los registros'),
            'usuario' => auth()->user()->name ?? 'Sistema Cacaotera',
        ];

        if (!view()->exists('reporte.pdf_general')) {
            throw new \Exception('La vista reporte.pdf_general no existe');
        }

        $pdf = Pdf::loadView('reporte.pdf_general', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'Arial',
            'isRemoteEnabled' => false,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => false
        ]);

        return $pdf->download('reporte_general_' . Carbon::now()->format('Y-m-d') . '.pdf');
    } catch (\Exception $e) {
        Log::error('Error al generar PDF general', [
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile()),
                'trace' => config('app.debug') ? $e->getTraceAsString() : 'Habilita debug para ver más detalles'
            ], 500);
        }

        return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
}
    public function previsualizarReporte(Request $request)
    {
        try {
            $datosCompletos = $this->obtenerDatosReales();
            $metricas = $this->calcularMetricasReales();

            $data = [
                'datosCompletos' => $datosCompletos,
                'metricas' => $metricas,
                'fecha_generacion' => Carbon::now()->format('d/m/Y H:i:s'),
                'periodo' => $request->get('periodo', 'Todos los registros'),
                'usuario' => auth()->user()->name ?? 'Sistema Cacaotera',
            ];

            return view('reporte.pdf_general', $data);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function testPdf()
    {
        try {
            $html = '<h1 style="color: #8B4513;">Test PDF Cacaotera</h1><p>Este es un PDF de prueba generado correctamente.</p>';
            $pdf = Pdf::loadHTML($html);
            $pdf->setPaper('A4', 'portrait');

            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="test.pdf"'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    private function generarReportePorTipo($tipo)
    {
        $datosCompletos = $this->obtenerDatosReales();

        if ($tipo === 'salida_inventario') {
            // Traer datos reales de la tabla SalidaInventario
            $items = \App\Models\SalidaInventario::with(['lote', 'insumo'])->get()->map(function($item) {
                return [
                    'lote' => $item->lote ? $item->lote->nombre : 'Sin lote',
                    'insumo' => $item->insumo ? $item->insumo->nombre : 'Sin insumo',
                    'cantidad' => $item->cantidad . ' ' . ($item->unidad_medida ?? ''),
                    'valor_total' => '$' . number_format($item->precio_unitario, 2)
                ];
            })->toArray();
            $venta_total = \App\Models\Venta::sum('total_venta');
            return [
                'items' => $items,
                'total' => \App\Models\SalidaInventario::count(),
                'venta_total' => $venta_total
            ];
        }

        if ($tipo === 'contabilidad_lotes') {
            // Nuevo tipo de reporte para contabilidad por lotes
            return $this->generarReporteContabilidadLotes();
        }

        switch ($tipo) {
            case 'lote':
                return $datosCompletos['lote'];
            case 'inventario':
                return $datosCompletos['inventario'];
            case 'ventas':
                return $datosCompletos['ventas'];
            case 'produccion':
                return $datosCompletos['produccion'];
            case 'trabajadores':
                return $datosCompletos['trabajadores'];
            default:
                return ['items' => []];
        }
    }

    private function obtenerDatosReales()
    {
        return [
            'lote' => [
                'items' => Lote::all()->map(function($lote) {
                    return [
                        'id' => $lote->id,
                        'nombre' => $lote->nombre,
                        'fecha_inicio' => ($lote->fecha_inicio && $lote->fecha_inicio != '0000-00-00') ? Carbon::parse($lote->fecha_inicio)->format('d/m/Y') : 'Sin fecha',
                        'area' => $lote->area ?? '',
                        'capacidad' => $lote->capacidad ?? '',
                        'tipo_cacao' => $lote->tipo_cacao ?? '',
                        'tipo_cultivo' => $lote->tipo_cultivo ?? '',
                        'estado' => $lote->estado ?? '',
                        'observaciones' => $lote->observaciones ?? '',
                        // Agrega más campos si existen en la tabla
                    ];
                })->toArray(),
                'total' => Lote::count()
            ],
            'inventario' => [
                'items' => Inventario::all()->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nombre' => $item->nombre,
                        'tipo' => $item->tipo,
                        'cantidad' => $item->cantidad ?? '',
                        'unidad_medida' => $item->unidad_medida ?? '',
                        'precio_unitario' => $item->precio_unitario ?? '',
                        'estado' => $item->estado ?? '',
                        'fecha_registro' => $item->fecha_registro ? Carbon::parse($item->fecha_registro)->format('d/m/Y') : '',
                        // Agrega más campos si existen en la tabla
                    ];
                })->toArray(),
                'total' => Inventario::count()
            ],
            'ventas' => [
                'items' => Venta::all()->map(function($venta) {
                    return [
                        'id' => $venta->id,
                        'cliente' => $venta->cliente,
                        'cantidad_vendida' => $venta->cantidad_vendida ?? '',
                        'precio_por_kg' => $venta->precio_por_kg ?? '',
                        'total_venta' => $venta->total_venta ?? '',
                        'estado_pago' => $venta->estado_pago ?? '',
                        'fecha_venta' => $venta->fecha_venta ? Carbon::parse($venta->fecha_venta)->format('d/m/Y') : '',
                        'metodo_pago' => $venta->metodo_pago ?? '',
                        // Agrega más campos si existen en la tabla
                    ];
                })->toArray(),
                'total' => Venta::count()
            ],
            'produccion' => [
                'items' => Produccion::with('lote')->get()->map(function($produccion) {
                    return [
                        'id' => $produccion->id,
                        'lote_id' => $produccion->lote_id,
                        'lote_nombre' => $produccion->lote ? $produccion->lote->nombre : '',
                        'fecha_inicio' => $produccion->fecha_inicio ? Carbon::parse($produccion->fecha_inicio)->format('d/m/Y') : '',
                        'tipo_cacao' => $produccion->tipo_cacao ?? '',
                        'area_asignada' => $produccion->area_asignada ?? '',
                        'estimacion_produccion' => $produccion->estimacion_produccion ?? '',
                        'estado' => $produccion->estado ?? '',
                        'cantidad_cosechada' => $produccion->cantidad_cosechada ?? '',
                        'fecha_cosecha_real' => $produccion->fecha_cosecha_real ? Carbon::parse($produccion->fecha_cosecha_real)->format('d/m/Y') : '',
                        'rendimiento_real' => $produccion->rendimiento_real ?? '',
                        'desviacion_estimacion' => $produccion->desviacion_estimacion ?? '',
                        'personal_asignado' => $produccion->personal_asignado ?? '',
                        'insumos_utilizados' => $produccion->insumos_utilizados ?? '',
                        'fecha_programada_cosecha' => $produccion->fecha_programada_cosecha ? Carbon::parse($produccion->fecha_programada_cosecha)->format('d/m/Y') : '',
                        'notificacion_cosecha' => $produccion->notificacion_cosecha ?? '',
                        'activo' => $produccion->activo ?? '',
                        'observaciones' => $produccion->observaciones ?? '',
                        // Agrega más campos si existen en la tabla
                    ];
                })->toArray(),
                'total' => Produccion::count()
            ],
            'trabajadores' => [
                'items' => Trabajador::with('user')->select([
                    'user_id',
                    'direccion',
                    'telefono',
                    'fecha_contratacion',
                    'tipo_contrato',
                    'forma_pago'
                ])->get()->map(function($trabajador) {
                    return [
                        'user_id' => $trabajador->user_id,
                        'nombre' => $trabajador->user->name ?? 'Sin nombre',
                        'direccion' => $trabajador->direccion,
                        'telefono' => $trabajador->telefono,
                        'fecha_contratacion' => Carbon::parse($trabajador->fecha_contratacion)->format('d/m/Y'),
                        'tipo_contrato' => $trabajador->tipo_contrato,
                        'forma_pago' => $trabajador->forma_pago,
                        'email' => $trabajador->user->email ?? '',
                        'estado' => $trabajador->user->estado ?? '',
                        // 'identificacion' => $trabajador->identificacion // eliminado porque no existe en la tabla
                    ];
                })->toArray(),
                'total' => Trabajador::count()
            ],
            'contabilidad' => [
                'resumen_lotes' => Lote::where('estado', 'activo')
                    ->whereHas('producciones', function($q) {
                        $q->where('activo', 1);
                    })
                    ->with(['producciones' => function($q) {
                        $q->where('activo', 1)
                          ->with(['recolecciones.ventas', 'salidaInventarios.inventario']);
                    }])
                    ->get()
                    ->map(function($lote) {
                        $totalGastos = 0;
                        $totalVentas = 0;
                        $insumos = [];

                        // Obtener gastos usando la misma lógica que ContabilidadController
                        $insumosGastados = \App\Models\SalidaInventario::where('lote_id', $lote->id)
                            ->with('inventario')
                            ->get();

                        foreach($insumosGastados as $salida) {
                            $costo = $salida->cantidad * ($salida->precio_unitario ?? 0);
                            $totalGastos += $costo;

                            if ($salida->inventario) {
                                $key = $salida->inventario->nombre;
                                if (!isset($insumos[$key])) {
                                    $insumos[$key] = [
                                        'nombre' => $salida->inventario->nombre,
                                        'cantidad' => 0,
                                        'costo_total' => 0
                                    ];
                                }
                                $insumos[$key]['cantidad'] += $salida->cantidad;
                                $insumos[$key]['costo_total'] += $costo;
                            }
                        }

                        // Calcular ventas a través de producciones
                        foreach($lote->producciones as $produccion) {
                            foreach($produccion->recolecciones as $recoleccion) {
                                foreach($recoleccion->ventas as $venta) {
                                    $totalVentas += $venta->total_venta ?? 0;
                                }
                            }
                        }

                        $ganancia = $totalVentas - $totalGastos;

                        return [
                            'id' => $lote->id,
                            'nombre' => $lote->nombre,
                            'total_gastos' => $totalGastos,
                            'total_ventas' => $totalVentas,
                            'ganancia' => $ganancia,
                            'rentabilidad' => $totalGastos > 0 ? (($ganancia / $totalGastos) * 100) : 0,
                            'insumos' => array_values($insumos)
                        ];
                    })->toArray(),
                'resumen_general' => $this->calcularResumenGeneralContabilidad()
            ]
        ];
    }

    private function calcularResumenGeneralContabilidad()
    {
        // Usar el precio_unitario registrado en salida_inventarios, no en inventarios
        $totalGastos = SalidaInventario::sum(DB::raw('cantidad * precio_unitario'));

        $totalVentas = Venta::sum('total_venta');
        $gananciaTotal = $totalVentas - $totalGastos;

        return [
            'total_gastos' => $totalGastos,
            'total_ventas' => $totalVentas,
            'ganancia_total' => $gananciaTotal,
            'rentabilidad_general' => $totalGastos > 0 ? (($gananciaTotal / $totalGastos) * 100) : 0
        ];
    }

    private function calcularMetricasReales()
    {
        $totalLotes = Lote::count();
        $totalProduccion = Produccion::sum('cantidad_cosechada');
        $totalVentas = Venta::sum('total_venta');
        $totalTrabajadores = Trabajador::whereHas('user', function($q) {
            $q->where('estado', 'activo');
        })->count();

        // Calcular gastos en insumos (usar precio_unitario de salida_inventarios)
        $totalGastos = SalidaInventario::sum(DB::raw('cantidad * precio_unitario'));
        $rentabilidad = $totalGastos > 0 ? (($totalVentas - $totalGastos) / $totalGastos * 100) : 0;

        $inventarioValor = Inventario::sum(DB::raw('cantidad * precio_unitario'));

        // Producción del mes actual
        $produccionMesActual = Produccion::whereMonth('fecha_cosecha_real', Carbon::now()->month)
            ->whereYear('fecha_cosecha_real', Carbon::now()->year)
            ->sum('cantidad_cosechada');

        // Ventas del mes actual
        $ventasMesActual = Venta::whereMonth('fecha_venta', Carbon::now()->month)
            ->whereYear('fecha_venta', Carbon::now()->year)
            ->sum('total_venta');

        return [
            'total_lotes' => $totalLotes,
            'total_produccion' => $totalProduccion,
            'total_ventas' => $totalVentas,
            'total_trabajadores' => $totalTrabajadores,
            'rentabilidad' => round($rentabilidad, 1),
            'inventario_valor' => $inventarioValor,
            'produccion_mes_actual' => $produccionMesActual,
            'ventas_mes_actual' => $ventasMesActual
        ];
    }

    private function generarReporteContabilidadLotes()
    {
        // Obtener lotes activos con producción
        $lotes = \App\Models\Lote::whereIn('estado', ['activo', 'en_produccion', 'produccion'])
            ->whereHas('producciones', function($query) {
                $query->where('activo', true);
            })
            ->with(['salidaInventarios.insumo'])
            ->get();

        $items = [];

        foreach ($lotes as $lote) {
            $insumosGastados = $lote->salidaInventarios;
            $totalGastado = $insumosGastados->sum(function($salida) {
                return $salida->cantidad * $salida->precio_unitario;
            });

            $items[] = [
                'lote' => $lote->nombre,
                'estado' => $lote->estado,
                'tipo_cacao' => $lote->tipo_cacao,
                'cantidad_insumos' => $insumosGastados->count(),
                'total_gastado' => '$' . number_format($totalGastado, 2),
                'area' => $lote->area . ' hectáreas'
            ];
        }

        return [
            'items' => $items,
            'total' => count($items)
        ];
    }
}
