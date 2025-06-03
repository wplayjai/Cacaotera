<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Inventario::all();
        return view('inventario.index', compact('productos'));
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
}
