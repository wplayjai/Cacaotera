<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Recoleccion;
use App\Models\Produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use Illuminate\Support\Facades\Storage;
=======
use Illuminate\Support\Facades\Log;
>>>>>>> 536a1b91ef0021771059647178693dbdbb4bcc38
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Venta::with(['recoleccion.produccion.lote'])
            ->orderBy('fecha_venta', 'desc');

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cliente', 'LIKE', "%{$search}%")
                  ->orWhereHas('recoleccion.produccion.lote', function($subQ) use ($search) {
                      $subQ->where('nombre', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }

        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        $ventas = $query->paginate(15);

        // Estadísticas
        $estadisticas = $this->calcularEstadisticas();

        // Recolecciones disponibles para la venta (con stock > 0)
        $recoleccionesDisponibles = Recoleccion::with(['produccion.lote'])
            ->where('cantidad_disponible', '>', 0)
            ->orderBy('fecha_recoleccion', 'desc')
            ->get();

        // Debug: verificar que hay recolecciones disponibles
        Log::info('Recolecciones disponibles encontradas: ' . $recoleccionesDisponibles->count());
        foreach ($recoleccionesDisponibles as $rec) {
            Log::info("Recolección {$rec->id}: Stock {$rec->cantidad_disponible}, Lote: " . ($rec->produccion->lote?->nombre ?? 'Sin lote'));
        }

        return view('ventas.index', array_merge($estadisticas, [
            'ventas' => $ventas,
            'recoleccionesDisponibles' => $recoleccionesDisponibles
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_venta' => 'required|date',
            'recoleccion_id' => 'required|exists:recolecciones,id',
            'cliente' => 'required|string|max:255',
            'telefono_cliente' => 'nullable|string|max:20',
            'cantidad_vendida' => 'required|numeric|min:0.01',
            'precio_por_kg' => 'required|numeric|min:0.01',
            'estado_pago' => 'required|in:pagado,pendiente',
            'metodo_pago' => 'required|in:efectivo,transferencia,cheque',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Verificar stock disponible
            $recoleccion = Recoleccion::findOrFail($request->recoleccion_id);

            if ($request->cantidad_vendida > $recoleccion->cantidad_disponible) {
                return back()->with('error', 'La cantidad a vender excede el stock disponible.');
            }

            // Crear la venta
            $venta = new Venta();
            $venta->fecha_venta = $request->fecha_venta;
            $venta->recoleccion_id = $request->recoleccion_id;
            $venta->cliente = $request->cliente;
            $venta->telefono_cliente = $request->telefono_cliente;
            $venta->cantidad_vendida = $request->cantidad_vendida;
            $venta->precio_por_kg = $request->precio_por_kg;
            $venta->total_venta = $request->cantidad_vendida * $request->precio_por_kg;
            $venta->estado_pago = $request->estado_pago;
            $venta->metodo_pago = $request->metodo_pago;
            $venta->observaciones = $request->observaciones;
            $venta->save();

            // Actualizar stock disponible en recolección
            $recoleccion->cantidad_disponible -= $request->cantidad_vendida;
            $recoleccion->save();

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        $venta->load(['recoleccion.produccion.lote']);
        return view('ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        $venta->load(['recoleccion.produccion.lote']);

        $recoleccionesDisponibles = Recoleccion::with(['produccion.lote'])
            ->where(function($query) use ($venta) {
                $query->where('cantidad_disponible', '>', 0)
                      ->orWhere('id', $venta->recoleccion_id);
            })
            ->orderBy('fecha_recoleccion', 'desc')
            ->get();

        return view('ventas.edit', compact('venta', 'recoleccionesDisponibles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'fecha_venta' => 'required|date',
            'recoleccion_id' => 'required|exists:recolecciones,id',
            'cliente' => 'required|string|max:255',
            'telefono_cliente' => 'nullable|string|max:20',
            'cantidad_vendida' => 'required|numeric|min:0.01',
            'precio_por_kg' => 'required|numeric|min:0.01',
            'estado_pago' => 'required|in:pagado,pendiente',
            'metodo_pago' => 'required|in:efectivo,transferencia,cheque',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $recoleccionAnterior = $venta->recoleccion;
            $cantidadAnterior = $venta->cantidad_vendida;

            // Si cambió la recolección, verificar stock
            if ($request->recoleccion_id != $venta->recoleccion_id) {
                $nuevaRecoleccion = Recoleccion::findOrFail($request->recoleccion_id);

                if ($request->cantidad_vendida > $nuevaRecoleccion->cantidad_disponible) {
                    return back()->with('error', 'La cantidad a vender excede el stock disponible del nuevo lote.');
                }

                // Restaurar stock de la recolección anterior
                $recoleccionAnterior->cantidad_disponible += $cantidadAnterior;
                $recoleccionAnterior->save();

                // Reducir stock de la nueva recolección
                $nuevaRecoleccion->cantidad_disponible -= $request->cantidad_vendida;
                $nuevaRecoleccion->save();
            } else {
                // Misma recolección, ajustar la diferencia
                $diferencia = $request->cantidad_vendida - $cantidadAnterior;

                if ($diferencia > $recoleccionAnterior->cantidad_disponible) {
                    return back()->with('error', 'La cantidad adicional excede el stock disponible.');
                }

                $recoleccionAnterior->cantidad_disponible -= $diferencia;
                $recoleccionAnterior->save();
            }

            // Actualizar la venta
            $venta->update([
                'fecha_venta' => $request->fecha_venta,
                'recoleccion_id' => $request->recoleccion_id,
                'cliente' => $request->cliente,
                'telefono_cliente' => $request->telefono_cliente,
                'cantidad_vendida' => $request->cantidad_vendida,
                'precio_por_kg' => $request->precio_por_kg,
                'total_venta' => $request->cantidad_vendida * $request->precio_por_kg,
                'estado_pago' => $request->estado_pago,
                'metodo_pago' => $request->metodo_pago,
                'observaciones' => $request->observaciones
            ]);

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        try {
            DB::beginTransaction();

            // Restaurar stock a la recolección
            $recoleccion = $venta->recoleccion;
            $recoleccion->cantidad_disponible += $venta->cantidad_vendida;
            $recoleccion->save();

            // Eliminar la venta
            $venta->delete();

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta eliminada exitosamente. Stock restaurado.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Marcar una venta como pagada
     */
    public function marcarPagado(Venta $venta)
    {
        try {
            $venta->update([
                'estado_pago' => 'pagado',
                'fecha_pago' => now()
            ]);

            return redirect()->route('ventas.index')
                ->with('success', 'Venta marcada como pagada exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el estado de pago: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar página de reportes de ventas
     */
    public function reporte(Request $request)
    {
        $query = Venta::with(['recoleccion.produccion.lote'])
            ->orderBy('fecha_venta', 'desc');

        // Aplicar filtros si existen
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }

        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cliente', 'LIKE', "%{$search}%")
                  ->orWhereHas('recoleccion.produccion.lote', function($subQ) use ($search) {
                      $subQ->where('nombre', 'LIKE', "%{$search}%");
                  });
            });
        }

        $ventas = $query->paginate(15);

        // Calcular totales
        $totalVentas = $query->count();
        $montoTotal = $query->sum('total_venta');
        $cantidadTotal = $query->sum('cantidad_vendida');
        $ventasPagadas = $query->where('estado_pago', 'pagado')->count();
        $ventasPendientes = $query->where('estado_pago', 'pendiente')->count();

        $datos = [
            'ventas' => $ventas,
            'totalVentas' => $totalVentas,
            'montoTotal' => $montoTotal,
            'cantidadTotal' => $cantidadTotal,
            'ventasPagadas' => $ventasPagadas,
            'ventasPendientes' => $ventasPendientes,
            'filtros' => $request->all()
        ];

        return view('ventas.reporte', $datos);
    }

    /**
     * Mostrar página de reportes de ventas - Versión Simple (sin autenticación)
     */
    public function reporteSimple(Request $request)
    {
        $query = Venta::with(['recoleccion.produccion.lote'])
            ->orderBy('fecha_venta', 'desc');

        // Aplicar filtros si existen
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }

        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('cliente', 'LIKE', "%{$search}%")
                  ->orWhereHas('recoleccion.produccion.lote', function($subQ) use ($search) {
                      $subQ->where('nombre', 'LIKE', "%{$search}%");
                  });
            });
        }

        $ventas = $query->paginate(15);

        // Calcular totales
        $totalVentas = $query->count();
        $montoTotal = $query->sum('total_venta');
        $cantidadTotal = $query->sum('cantidad_vendida');
        $ventasPagadas = $query->where('estado_pago', 'pagado')->count();
        $ventasPendientes = $query->where('estado_pago', 'pendiente')->count();

        $datos = [
            'ventas' => $ventas,
            'totalVentas' => $totalVentas,
            'montoTotal' => $montoTotal,
            'cantidadTotal' => $cantidadTotal,
            'ventasPagadas' => $ventasPagadas,
            'ventasPendientes' => $ventasPendientes,
            'filtros' => $request->all()
        ];

        return view('ventas.reporte_simple', $datos);
    }

    /**
     * Calcular estadísticas para el dashboard
     */
    private function calcularEstadisticas()
    {
        $hoy = Carbon::today();

        $ventasHoy = Venta::whereDate('fecha_venta', $hoy)->count();

        $ingresosTotales = Venta::where('estado_pago', 'pagado')->sum('total_venta');

        $stockTotal = Recoleccion::sum('cantidad_disponible');

        $pagosPendientes = Venta::where('estado_pago', 'pendiente')->count();

        return [
            'ventasHoy' => $ventasHoy,
            'ingresosTotales' => $ingresosTotales,
            'stockTotal' => $stockTotal,
            'pagosPendientes' => $pagosPendientes
        ];
    }

    /**
     * API endpoint para obtener stock disponible
     */
    public function obtenerStock($recoleccionId)
    {
        $recoleccion = Recoleccion::with(['produccion.lote'])->find($recoleccionId);

        if (!$recoleccion) {
            return response()->json(['error' => 'Recolección no encontrada'], 404);
        }

        return response()->json([
            'stock_disponible' => $recoleccion->cantidad_disponible,
            'tipo_cacao' => $recoleccion->produccion->tipo_cacao,
            'lote' => $recoleccion->produccion->lote->nombre ?? 'Sin lote'
        ]);
    }


public function descargarPDF($id)
{
    $venta = Venta::findOrFail($id);
    $ruta = storage_path('app/public/ventas/' . $venta->id . '.pdf');

<<<<<<< HEAD
    if (!file_exists($ruta)) {
        abort(404, 'PDF no encontrado');
    }

    return response()->download($ruta);
}

/**
 * Generar reporte PDF de ventas
 */
public function reportePdf(Request $request)
{
    $query = Venta::with(['recoleccion.produccion.lote'])
        ->orderBy('fecha_venta', 'desc');

    // Aplicar filtros si existen
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('cliente', 'LIKE', "%{$search}%")
              ->orWhereHas('recoleccion.produccion.lote', function($subQ) use ($search) {
                  $subQ->where('nombre', 'LIKE', "%{$search}%");
              });
        });
    }

    if ($request->filled('fecha_desde')) {
        $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
    }

    if ($request->filled('fecha_hasta')) {
        $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
    }

    if ($request->filled('estado_pago')) {
        $query->where('estado_pago', $request->estado_pago);
    }

    $ventas = $query->get();
    
    // Calcular totales
    $totalVentas = $ventas->count();
    $montoTotal = $ventas->sum('total_venta');
    $cantidadTotal = $ventas->sum('cantidad_vendida');
    $ventasPagadas = $ventas->where('estado_pago', 'pagado')->count();
    $ventasPendientes = $ventas->where('estado_pago', 'pendiente')->count();
    $montoPagado = $ventas->where('estado_pago', 'pagado')->sum('total_venta');
    $montoPendiente = $ventas->where('estado_pago', 'pendiente')->sum('total_venta');

    $data = [
        'ventas' => $ventas,
        'fecha_generacion' => Carbon::now()->format('d/m/Y H:i:s'),
        'totalVentas' => $totalVentas,
        'montoTotal' => $montoTotal,
        'cantidadTotal' => $cantidadTotal,
        'ventasPagadas' => $ventasPagadas,
        'ventasPendientes' => $ventasPendientes,
        'montoPagado' => $montoPagado,
        'montoPendiente' => $montoPendiente,
        'filtros' => $request->all(),
        'fechaDesde' => $request->fecha_desde,
        'fechaHasta' => $request->fecha_hasta,
        'estadoPago' => $request->estado_pago
    ];

    $pdf = PDF::loadView('ventas.reporte_pdf', $data);
    
    return $pdf->download('reporte_ventas_' . date('Y-m-d') . '.pdf');
}
}
=======
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }

        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        $ventas = $query->get();

        // Calcular totales (con los nombres que espera la vista PDF)
        $totalVentas = $ventas->count(); // Número total de ventas
        $montoTotal = $ventas->sum('total_venta'); // Monto total
        $cantidadTotal = $ventas->sum('cantidad_vendida'); // Cantidad total vendida
        $ventasPagadas = $ventas->where('estado_pago', 'pagado')->count(); // Número de ventas pagadas
        $ventasPendientes = $ventas->where('estado_pago', 'pendiente')->count(); // Número de ventas pendientes
        $montoPagado = $ventas->where('estado_pago', 'pagado')->sum('total_venta'); // Monto pagado
        $montoPendiente = $ventas->where('estado_pago', 'pendiente')->sum('total_venta'); // Monto pendiente

        $data = [
            'ventas' => $ventas,
            'fecha_generacion' => Carbon::now()->format('d/m/Y H:i:s'),
            'totalVentas' => $totalVentas,
            'montoTotal' => $montoTotal,
            'cantidadTotal' => $cantidadTotal,
            'ventasPagadas' => $ventasPagadas,
            'ventasPendientes' => $ventasPendientes,
            'montoPagado' => $montoPagado,
            'montoPendiente' => $montoPendiente,
            'filtros' => $request->all(),
            'fechaDesde' => $request->fecha_desde,
            'fechaHasta' => $request->fecha_hasta,
            'estadoPago' => $request->estado_pago
        ];

        $pdf = PDF::loadView('ventas.reporte_pdf', $data);

        return $pdf->download('reporte_ventas_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Obtener detalles de recolección para AJAX
     */
    public function obtenerDetalleRecoleccion($recoleccionId)
    {
        try {
            $recoleccion = Recoleccion::with(['produccion.lote'])
                ->where('id', $recoleccionId)
                ->first();

            if (!$recoleccion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recolección no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $recoleccion->id,
                    'cantidad_recolectada' => floatval($recoleccion->cantidad_recolectada),
                    'cantidad_disponible' => floatval($recoleccion->cantidad_disponible),
                    'lote_nombre' => $recoleccion->produccion->lote?->nombre ?? 'Sin lote',
                    'tipo_cacao' => $recoleccion->produccion->tipo_cacao,
                    'fecha_recoleccion' => $recoleccion->fecha_recoleccion->format('d/m/Y')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener detalles: ' . $e->getMessage()
            ], 500);
        }
    }
}
>>>>>>> 536a1b91ef0021771059647178693dbdbb4bcc38
