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
            'tipo_insumo' => 'required|string',
            'cantidad' => 'required|numeric|min:0',
            'unidad_medida' => 'required|string',
            'precio_unitario' => 'required|numeric|min:0',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        Inventario::create($request->all());

        return redirect()->back()->with('success', 'Producto agregado correctamente.');
    }
}
