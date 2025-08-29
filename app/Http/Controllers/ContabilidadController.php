<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Lote;
use App\Models\Produccion;
use App\Models\SalidaInventario;
use App\Models\Inventario;
use Barryvdh\DomPDF\Facade\Pdf;

class ContabilidadController extends Controller
{
    // Retorna la ganancia total de ventas
    public function ganancia(Request $request)
    {
        $ganancia = Venta::sum('total_venta');
        return response()->json(['ganancia' => $ganancia]);
    }

    // Nuevo método para contabilidad por lotes
    public function contabilidadPorLotes(Request $request)
    {
        try {
            $loteId = $request->input('lote_id');

            // Obtener lotes activos que tienen producción
            $lotesActivos = Lote::whereIn('estado', ['activo', 'en_produccion', 'produccion'])
                ->whereHas('producciones', function($query) {
                    $query->where('activo', true);
                })
                ->with([
                    'producciones' => function($query) {
                        $query->where('activo', true)
                              ->with(['recolecciones.ventas', 'salidaInventarios.inventario']);
                    }
                ])
                ->get();

            // Si se especifica un lote, filtrar por ese lote
            if ($loteId && $loteId != 'todos') {
                $lotesParaReporte = $lotesActivos->where('id', $loteId);
            } else {
                $lotesParaReporte = $lotesActivos;
            }

            $reporteLotes = [];

            foreach ($lotesParaReporte as $lote) {
                // Obtener insumos gastados en este lote
                $insumosGastados = SalidaInventario::where('lote_id', $lote->id)
                    ->with('inventario')
                    ->get();

                $detalleInsumos = [];
                $totalGastado = 0;

                foreach ($insumosGastados as $salida) {
                    $valorTotal = $salida->cantidad * $salida->precio_unitario;
                    $totalGastado += $valorTotal;

                    $detalleInsumos[] = [
                        'id' => $salida->id,
                        'insumo_nombre' => $salida->inventario ? $salida->inventario->nombre : 'Insumo no encontrado',
                        'cantidad' => $salida->cantidad,
                        'unidad_medida' => $salida->unidad_medida,
                        'precio_unitario' => $salida->precio_unitario,
                        'valor_total' => $valorTotal,
                        'fecha_salida' => $salida->fecha_salida ? $salida->fecha_salida->format('d/m/Y') : 'Sin fecha',
                        'motivo' => $salida->motivo ?: 'Sin especificar',
                        'responsable' => $salida->responsable ?: 'No especificado'
                    ];
                }

                // Obtener ventas de este lote a través de sus producciones
                $ventasLote = [];
                $totalVendido = 0;

                foreach ($lote->producciones as $produccion) {
                    foreach ($produccion->recolecciones as $recoleccion) {
                        foreach ($recoleccion->ventas as $venta) {
                            $totalVendido += $venta->total_venta;
                            $ventasLote[] = [
                                'id' => $venta->id,
                                'fecha_venta' => $venta->fecha_venta ? $venta->fecha_venta->format('d/m/Y') : 'Sin fecha',
                                'cliente' => $venta->cliente,
                                'cantidad_vendida' => $venta->cantidad_vendida,
                                'precio_por_kg' => $venta->precio_por_kg,
                                'total_venta' => $venta->total_venta,
                                'estado_pago' => $venta->estado_pago,
                                'metodo_pago' => $venta->metodo_pago,
                                'produccion_id' => $produccion->id,
                                'recoleccion_id' => $recoleccion->id
                            ];
                        }
                    }
                }

                // También buscar ventas que puedan estar relacionadas indirectamente
                // (por si alguna venta no tiene bien la relación)
                $ventasAdicionales = Venta::whereHas('recoleccion.produccion', function($query) use ($lote) {
                    $query->where('lote_id', $lote->id);
                })->with('recoleccion.produccion')->get();

                foreach ($ventasAdicionales as $venta) {
                    // Verificar si ya está en la lista
                    $yaExiste = collect($ventasLote)->contains('id', $venta->id);
                    if (!$yaExiste) {
                        $totalVendido += $venta->total_venta;
                        $ventasLote[] = [
                            'id' => $venta->id,
                            'fecha_venta' => $venta->fecha_venta ? $venta->fecha_venta->format('d/m/Y') : 'Sin fecha',
                            'cliente' => $venta->cliente,
                            'cantidad_vendida' => $venta->cantidad_vendida,
                            'precio_por_kg' => $venta->precio_por_kg,
                            'total_venta' => $venta->total_venta,
                            'estado_pago' => $venta->estado_pago,
                            'metodo_pago' => $venta->metodo_pago,
                            'produccion_id' => $venta->recoleccion->produccion->id,
                            'recoleccion_id' => $venta->recoleccion->id
                        ];
                    }
                }

                // Calcular ganancia/pérdida
                $ganancia = $totalVendido - $totalGastado;
                $estadoFinanciero = $ganancia >= 0 ? 'ganancia' : 'perdida';

                $reporteLotes[] = [
                    'lote_id' => $lote->id,
                    'lote_nombre' => $lote->nombre,
                    'lote_estado' => $lote->estado,
                    'area' => $lote->area,
                    'tipo_cacao' => $lote->tipo_cacao,
                    'cantidad_insumos' => count($detalleInsumos),
                    'cantidad_ventas' => count($ventasLote),
                    'total_gastado' => $totalGastado,
                    'total_vendido' => $totalVendido,
                    'ganancia' => $ganancia,
                    'estado_financiero' => $estadoFinanciero,
                    'porcentaje_ganancia' => $totalGastado > 0 ? round(($ganancia / $totalGastado) * 100, 2) : 0,
                    'rentabilidad' => $totalVendido > 0 ? round(($ganancia / $totalVendido) * 100, 2) : 0,
                    'insumos_detalle' => $detalleInsumos,
                    'ventas_detalle' => $ventasLote
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'lotes_disponibles' => $lotesActivos->map(function($lote) {
                        return [
                            'id' => $lote->id,
                            'nombre' => $lote->nombre,
                            'estado' => $lote->estado,
                            'tipo_cacao' => $lote->tipo_cacao
                        ];
                    }),
                    'reporte_lotes' => $reporteLotes,
                    'resumen' => [
                        'total_lotes' => count($reporteLotes),
                        'total_gastos' => array_sum(array_column($reporteLotes, 'total_gastado')),
                        'total_ventas' => array_sum(array_column($reporteLotes, 'total_vendido')),
                        'ganancia_total' => array_sum(array_column($reporteLotes, 'ganancia')),
                        'lotes_rentables' => count(array_filter($reporteLotes, function($lote) {
                            return $lote['ganancia'] > 0;
                        })),
                        'lotes_perdidas' => count(array_filter($reporteLotes, function($lote) {
                            return $lote['ganancia'] < 0;
                        }))
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el reporte: ' . $e->getMessage()
            ], 500);
        }
    }

    // Generar PDF del reporte de rentabilidad
    public function generarPdfRentabilidad(Request $request)
    {
        try {
            $loteId = $request->input('lote_id', 'todos');

            // Obtener datos usando el mismo método
            $requestData = new Request(['lote_id' => $loteId]);
            $response = $this->contabilidadPorLotes($requestData);
            $data = $response->getData(true);

            if (!$data['success']) {
                return back()->with('error', 'No se pudo generar el reporte de rentabilidad.');
            }

            $reporteData = $data['data'];

            // Preparar datos para la vista PDF
            $pdfData = [
                'titulo' => 'Reporte de Rentabilidad por Lotes',
                'fecha_generacion' => now()->format('d/m/Y H:i:s'),
                'lotes' => $reporteData['reporte_lotes'],
                'resumen' => $reporteData['resumen'],
                'filtro_aplicado' => $loteId !== 'todos' ?
                    collect($reporteData['lotes_disponibles'])->firstWhere('id', $loteId)['nombre'] ?? 'Lote específico' :
                    'Todos los lotes'
            ];

            $pdf = PDF::loadView('contabilidad.pdf-rentabilidad', $pdfData);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->download('reporte-rentabilidad-' . now()->format('Y-m-d-H-i-s') . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
