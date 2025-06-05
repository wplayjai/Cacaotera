<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Lote;
use App\Models\SalidaInventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::all();
        $lotes = Lote::select('id', 'nombre', 'tipo_cacao')->get();
        return view('inventario.index', compact('inventarios', 'lotes'));
    }

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

    public function update(Request $request, $id)
    {
        $producto = Inventario::findOrFail($id);
        $producto->update($request->all());
        return response()->json(['message' => 'Producto actualizado correctamente.']);
    }

    public function destroy($id)
    {
        $producto = Inventario::findOrFail($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado correctamente.']);
    }

    public function storeSalida(Request $request)
    {
        $request->validate([
            'lote_nombre' => 'required|string|max:255',
            'tipo_cacao' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'unidad_medida' => 'required|string|max:255',
            'precio_unitario' => 'required|numeric|min:0',
            'estado' => 'required|string|max:255',
            'fecha_registro' => 'required|date',
        ]);

        SalidaInventario::create($request->all());

        return response()->json(['message' => 'Salida registrada correctamente.']);
    }
}
