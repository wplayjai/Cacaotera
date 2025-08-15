<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Lote;
use App\Models\SalidaInventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InventarioController extends Controller
{
    // Mostrar inventario general
   public function index()
{
    $inventarios = Inventario::all();
    $lotes = Lote::select('id', 'nombre', 'tipo_cacao')->get();
    return view('inventario.index', compact('inventarios', 'lotes'));
}

    // Guardar nuevo producto en inventario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Fertilizantes,Pesticidas',
            'cantidad' => 'required|integer|min:1',
            'unidad_medida' => 'required|in:kg,ml',
            'precio_unitario' => 'required|numeric|min:0',
            'estado' => 'required|in:Óptimo,Por vencer,Restringido',
            'fecha_registro' => 'required|date',
        ]);

        $producto = Inventario::create($request->all());

        return response()->json([
            'message' => 'Producto agregado correctamente.',
            'producto' => $producto
        ]);
    }

    // Actualizar producto
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:Fertilizantes,Pesticidas',
            'cantidad' => 'required|integer|min:1',
            'unidad_medida' => 'required|in:kg,ml',
            'precio_unitario' => 'required|numeric|min:0',
            'estado' => 'required|in:Óptimo,Por vencer,Restringido',
            'fecha_registro' => 'required|date',
        ]);

        $producto = Inventario::findOrFail($id);
        $producto->update($request->all());
        
        return response()->json([
            'message' => 'Producto actualizado correctamente.',
            'producto' => $producto
        ]);
    }

    // Mostrar un producto específico
    public function show($id)
    {
        $producto = Inventario::findOrFail($id);
        return response()->json($producto);
    }

    // Eliminar producto
    public function destroy($id)
    {
        $producto = Inventario::findOrFail($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado correctamente.']);
    }

    public function listarSalidas()
{
    $salidas = SalidaInventario::with('insumo')->get();


    return response()->json($salidas);
}


    // Mostrar formulario de salida de inventario
    public function salida()
    {
        $lotes = Lote::where('estado', 'Activo')->get();              
        $productos = Inventario::all();  
        return view('inventario.salida', compact('lotes', 'productos'));
    }

    // Registrar una salida de inventario y actualizar stock
    public function storeSalida(Request $request)
{
    $request->validate([
        'insumo_id' => 'required|exists:inventarios,id',
        'cantidad' => 'required|numeric|min:0.001',
        'fecha_salida' => 'required|date',
        'lote_id' => 'nullable|exists:lotes,id',
        'observaciones' => 'nullable|string|max:255',
        'unidad_medida' => 'nullable|string|max:255',
        'precio_unitario' => 'nullable|numeric|min:0',
        'estado' => 'nullable|string|max:255',
    ]);

    // Buscar el insumo por ID para obtener información adicional
    $insumo = Inventario::find($request->insumo_id);
    
    if (!$insumo) {
        return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    // Verificar stock disponible
    if ($insumo->cantidad < $request->cantidad) {
        return response()->json(['message' => 'Stock insuficiente. Disponible: ' . $insumo->cantidad], 422);
    }

    // Crear la salida con los datos del formulario y del insumo
    SalidaInventario::create([
        'insumo_id' => $request->insumo_id,
        'lote_id' => $request->lote_id,
        'cantidad' => $request->cantidad,
        'fecha_salida' => $request->fecha_salida,
        'observaciones' => $request->observaciones,
        'precio_unitario' => $insumo->precio_unitario,
        'unidad_medida' => $insumo->unidad_medida,
        'estado' => $insumo->estado,
        'fecha_registro' => now(),
    ]);

    // Actualizar el stock del insumo
    $insumo->cantidad -= $request->cantidad;
    $insumo->cantidad = max(0, $insumo->cantidad); // evitar negativos
    
    // Actualizar estado si se agota
    if ($insumo->cantidad == 0) {
        $insumo->estado = 'Agotado';
    }
    
    $insumo->save();

    return response()->json(['message' => 'Salida registrada y stock actualizado correctamente'], 200);
}

    // Mostrar reporte de inventario
    public function reporte(Request $request)
    {
        $query = Inventario::query();

        // Filtros
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_registro', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_registro', '<=', $request->fecha_hasta);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $inventarios = $query->orderBy('fecha_registro', 'desc')->get();

        // Obtener todas las salidas de inventario con sus relaciones
        $salidaQuery = SalidaInventario::with(['insumo', 'lote', 'produccion']);
        
        // Aplicar filtros de fecha a las salidas también
        if ($request->filled('fecha_desde')) {
            $salidaQuery->whereDate('fecha_salida', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $salidaQuery->whereDate('fecha_salida', '<=', $request->fecha_hasta);
        }

        $salidas = $salidaQuery->orderBy('fecha_salida', 'desc')->get();

        // Estadísticas
        $totalProductos = $inventarios->count();
        $valorTotalInventario = $inventarios->sum(function($producto) {
            return $producto->cantidad * $producto->precio_unitario;
        });
        $productosOptimos = $inventarios->where('estado', 'Óptimo')->count();
        $productosAlerta = $inventarios->whereIn('estado', ['Por vencer', 'Restringido'])->count();

        // Estadísticas de salidas
        $totalSalidas = $salidas->count();
        $valorTotalSalidas = $salidas->sum(function($salida) {
            return $salida->cantidad * $salida->precio_unitario;
        });

        return view('inventario.reporte', compact(
            'inventarios',
            'salidas',
            'totalProductos',
            'valorTotalInventario',
            'productosOptimos',
            'productosAlerta',
            'totalSalidas',
            'valorTotalSalidas'
        ));
    }

    // Generar PDF del reporte
    public function reportePdf(Request $request)
    {
        $query = Inventario::query();

        // Aplicar los mismos filtros que en el reporte
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_registro', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_registro', '<=', $request->fecha_hasta);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $inventarios = $query->orderBy('fecha_registro', 'desc')->get();

        // Obtener salidas de inventario con filtros
        $salidaQuery = SalidaInventario::with(['insumo', 'lote', 'produccion']);
        
        if ($request->filled('fecha_desde')) {
            $salidaQuery->whereDate('fecha_salida', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $salidaQuery->whereDate('fecha_salida', '<=', $request->fecha_hasta);
        }

        $salidas = $salidaQuery->orderBy('fecha_salida', 'desc')->get();

        // Estadísticas
        $totalProductos = $inventarios->count();
        $valorTotalInventario = $inventarios->sum(function($producto) {
            return $producto->cantidad * $producto->precio_unitario;
        });
        $productosOptimos = $inventarios->where('estado', 'Óptimo')->count();
        $productosAlerta = $inventarios->whereIn('estado', ['Por vencer', 'Restringido'])->count();
        
        // Estadísticas de salidas
        $totalSalidas = $salidas->count();
        $valorTotalSalidas = $salidas->sum(function($salida) {
            return $salida->cantidad * $salida->precio_unitario;
        });

        // Filtros aplicados para mostrar en el PDF
        $filtros = [];
        if ($request->filled('fecha_desde')) {
            $filtros['Fecha desde'] = Carbon::parse($request->fecha_desde)->format('d/m/Y');
        }
        if ($request->filled('fecha_hasta')) {
            $filtros['Fecha hasta'] = Carbon::parse($request->fecha_hasta)->format('d/m/Y');
        }
        if ($request->filled('tipo')) {
            $filtros['Tipo de insumo'] = $request->tipo;
        }
        if ($request->filled('estado')) {
            $filtros['Estado'] = $request->estado;
        }
        if ($request->filled('search')) {
            $filtros['Búsqueda'] = $request->search;
        }

        $pdf = PDF::loadView('inventario.reporte-pdf', compact(
            'inventarios',
            'salidas',
            'totalProductos',
            'valorTotalInventario',
            'productosOptimos',
            'productosAlerta',
            'totalSalidas',
            'valorTotalSalidas',
            'filtros'
        ));

        return $pdf->download('reporte_inventario_' . date('Y-m-d_H-i-s') . '.pdf');
}

}
