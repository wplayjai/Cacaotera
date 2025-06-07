<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
    
        if (request()->ajax()) {
    
            return view('inventario.index', compact('productos'))->renderSections()['content'];
            
        }
        
        return view('inventario.index', compact('productos'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_insumo' => 'required|in:Cacao,Derivado,Insumo,Otros',
            'cantidad' => 'required|numeric|min:0',
        ]);
    
        // Determine initial status
        $estado = $validatedData['cantidad'] > 100 ? 'Óptimo' : 'Bajo';
    
        $producto = Producto::create([
            'nombre' => $validatedData['nombre'],
            'tipo_insumo' => $validatedData['tipo_insumo'],
            'cantidad' => $validatedData['cantidad'],
            'estado' => $estado
        ]);
    
        return response()->json([
            'message' => 'Producto agregado exitosamente',
            'producto' => $producto
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        
        $validatedData = $request->validate([
            'cantidad' => 'required|numeric|min:0'
        ]);
    
        $producto->cantidad = $validatedData['cantidad'];
        
        // Update status based on new quantity
        $producto->estado = $producto->cantidad > 100 ? 'Óptimo' : 'Bajo';
        $producto->save();
    
        return response()->json([
            'message' => 'Cantidad actualizada exitosamente',
            'producto' => $producto
        ]);
    }
    
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
    $producto->delete();
    
    if (request()->ajax()) {
        return response()->json([
            'message' => 'Producto eliminado correctamente'
        ]);
    }
    
    return redirect()->route('inventario.index')->with('success', 'Producto eliminado correctamente');
    }
    
    // Endpoint para obtener los datos actuales del inventario para el dashboard
    public function getData()
    {
        $productos = Producto::all();
        
        return response()->json($productos->map(function($producto) {
            return [
                'nombre' => $producto->nombre,
                'tipo_insumo' => $producto->tipo_insumo,
                'cantidad' => number_format($producto->cantidad, 2),
                'estado' => $producto->estado
            ];
        }));
    }
}