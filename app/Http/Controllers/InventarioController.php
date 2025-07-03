<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Lote;
use App\Models\SalidaInventario;
use Illuminate\Http\Request;

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
        $producto = Inventario::findOrFail($id);
        $producto->update($request->all());
        return response()->json(['message' => 'Producto actualizado correctamente.']);
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
        $lotes = Lote::all();              
        $inventarios = Inventario::all();  
        return view('inventario.salida', compact('lotes', 'inventarios'));
    }

    // Registrar una salida de inventario y actualizar stock
    public function storeSalida(Request $request)
{
    $request->validate([
        'insumo_id' => 'required|exists:inventarios,id',
        'lote_nombre' => 'required|string|max:255',
        'tipo_cacao' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'cantidad' => 'required|integer|min:1',
        'unidad_medida' => 'required|string|max:255',
        'precio_unitario' => 'required|numeric|min:0',
        'estado' => 'required|string|max:255',
        'fecha_registro' => 'required|date',
    ]);

    // Guardar la salida
    SalidaInventario::create($request->all());

    // Buscar el insumo por ID
    $insumo = Inventario::find($request->insumo_id);

    if ($insumo) {
        $insumo->cantidad -= $request->cantidad;
        $insumo->cantidad = max(0, $insumo->cantidad); // evitar negativos
        $insumo->save();
    }

    return redirect()->route('inventario.index')->with('success', 'Salida registrada y stock actualizado.');
}

}
