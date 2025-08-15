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
use Illuminate\Support\Facades\DB;

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
        \Log::info('Iniciando generación de PDF general', [
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
            'isPhpEnabled' => false,
            'chroot' => public_path(),
            'logOutputFile' => storage_path('logs/dompdf.log'),
            'tempDir' => storage_path('app/temp'),
        ]);

        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $nombreArchivo = "reporte-cacaotera-{$timestamp}.pdf";

        \Log::info('PDF generado exitosamente', ['filename' => $nombreArchivo]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
            'Content-Length' => strlen($pdf->output()),
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);

    } catch (\Exception $e) {
        \Log::error('Error generando PDF general', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'user' => auth()->user()->name ?? 'Anónimo',
            'trace' => $e->getTraceAsString()
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
                'items' => Lote::select([
                    'nombre',
                    'fecha_inicio',
                    'area',
                    'capacidad',
                    'tipo_cacao',
                    'estado',
                    'observaciones'
                ])->get()->map(function($lote) {
                    return [
                        'nombre' => $lote->nombre,
                        'fecha_inicio' => Carbon::parse($lote->fecha_inicio)->format('d/m/Y'),
                        'area' => $lote->area . ' ha',
                        'capacidad' => number_format($lote->capacidad, 0) . ' kg',
                        'tipo_cacao' => $lote->tipo_cacao,
                        'estado' => $lote->estado,
                        'observaciones' => $lote->observaciones
                    ];
                })->toArray(),
                'total' => Lote::count()
            ],
            'inventario' => [
                'items' => Inventario::select([
                    'nombre',
                    'tipo',
                    'cantidad',
                    'unidad_medida',
                    'precio_unitario',
                    'estado',
                    'fecha_registro'
                ])->get()->map(function($item) {
                    return [
                        'nombre' => $item->nombre,
                        'tipo' => $item->tipo,
                        'cantidad' => number_format($item->cantidad, 2) . ' ' . $item->unidad_medida,
                        'precio_unitario' => '$' . number_format($item->precio_unitario, 2),
                        'estado' => $item->estado,
                        'fecha_registro' => Carbon::parse($item->fecha_registro)->format('d/m/Y')
                    ];
                })->toArray(),
                'total' => Inventario::count()
            ],
            'ventas' => [
                'items' => Venta::select([
                    'cliente',
                    'cantidad_vendida',
                    'precio_por_kg',
                    'total_venta',
                    'estado_pago',
                    'fecha_venta',
                    'metodo_pago'
                ])->get()->map(function($venta) {
                    return [
                        'cliente' => $venta->cliente,
                        'cantidad_vendida' => number_format($venta->cantidad_vendida, 2) . ' kg',
                        'precio_por_kg' => '$' . number_format($venta->precio_por_kg, 2),
                        'total_venta' => '$' . number_format($venta->total_venta, 2),
                        'estado_pago' => $venta->estado_pago,
                        'fecha_venta' => Carbon::parse($venta->fecha_venta)->format('d/m/Y'),
                        'metodo_pago' => $venta->metodo_pago
                    ];
                })->toArray(),
                'total' => Venta::count()
            ],
            'produccion' => [
                'items' => Produccion::with('lote')->select([
                    'lote_id',
                    'fecha_inicio',
                    'tipo_cacao',
                    'area_asignada',
                    'estimacion_produccion',
                    'estado',
                    'cantidad_cosechada',
                    'fecha_cosecha_real',
                    'observaciones'
                ])->get()->map(function($produccion) {
                    return [
                        'lote_id' => $produccion->lote_id,
                        'fecha_inicio' => Carbon::parse($produccion->fecha_inicio)->format('d/m/Y'),
                        'tipo_cacao' => $produccion->tipo_cacao,
                        'area_asignada' => $produccion->area_asignada . ' ha',
                        'estimacion_produccion' => $produccion->estimacion_produccion . ' kg',
                        'estado' => $produccion->estado,
                        'cantidad_cosechada' => $produccion->cantidad_cosechada . ' kg',
                        'fecha_cosecha_real' => $produccion->fecha_cosecha_real ? Carbon::parse($produccion->fecha_cosecha_real)->format('d/m/Y') : '',
                        'observaciones' => $produccion->observaciones
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
                        'nombre' => $trabajador->user->name ?? 'Sin nombre',
                        'direccion' => $trabajador->direccion,
                        'telefono' => $trabajador->telefono,
                        'fecha_contratacion' => Carbon::parse($trabajador->fecha_contratacion)->format('d/m/Y'),
                        'tipo_contrato' => $trabajador->tipo_contrato,
                        'forma_pago' => $trabajador->forma_pago,
                        // 'identificacion' => $trabajador->identificacion // eliminado porque no existe en la tabla
                    ];
                })->toArray(),
                'total' => Trabajador::count()
            ]
        ];
    }

    private function calcularMetricasReales()
    {
        $totalLotes = Lote::count();
    $totalProduccion = Produccion::sum('cantidad_cosechada');
            $totalProduccion = Produccion::sum('cantidad_cosechada');
    $totalVentas = Venta::sum('total_venta');
        $totalTrabajadores = Trabajador::whereHas('user', function($q) {
            $q->where('estado', 'activo');
        })->count();
        
        // Calcular rentabilidad
    $costoTotal = Venta::sum(DB::raw('cantidad_vendida * precio_por_kg'));
        $rentabilidad = $totalVentas > 0 ? (($totalVentas - $costoTotal) / $totalVentas * 100) : 0;
        
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
}
