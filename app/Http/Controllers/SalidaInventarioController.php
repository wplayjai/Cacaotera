<?php
namespace App\Http\Controllers;

use App\Models\SalidaInventario;
use Illuminate\Http\Request;

class SalidaInventarioController extends Controller
{
       public function store(Request $request)
{
    $validatedData = $request->validate([
        'insumo_id' => 'required|integer|',
        'lote_id' => 'nullable|integer|exists:lotes,id',
        'cantidad' => 'required|numeric|min:1',
        'unidad_medida' => 'required|string',
        'precio_unitario' => 'required|numeric|min:0',
        'estado' => 'required|string',
        'fecha_registro' => 'required|date',
        'fecha_salida' => 'required|date',
        'observaciones' => 'nullable|string',
        'produccion_id' => 'nullable|integer',
    ]);

    $produccionId = $validatedData['produccion_id'] ?? null;
    
    // Si quieres asignar una producción por defecto, descomenta la siguiente línea:
    // $produccionId = $validatedData['produccion_id'] ?? 1; // ID de producción por defecto
    
    SalidaInventario::create([
        'insumo_id' => $validatedData['insumo_id'],
        'lote_id' => $validatedData['lote_id'] ?? null,
        'cantidad' => $validatedData['cantidad'],
        'unidad_medida' => $validatedData['unidad_medida'],
        'precio_unitario' => $validatedData['precio_unitario'],
        'estado' => $validatedData['estado'],
        'fecha_registro' => $validatedData['fecha_registro'],
        'fecha_salida' => $validatedData['fecha_salida'],
        'observaciones' => $validatedData['observaciones'] ?? null,
        'produccion_id' => $produccionId, // Usando la variable procesada
    ]);
   

   return response()->json(['message' => 'Salida registrada correctamente'], 201);
  // return dd($request->all());
}

    

    public function index()
    {
        $salidas = SalidaInventario::with(['insumo', 'lote'])
            ->orderBy('fecha_salida', 'desc')
            ->get()
            ->map(function($salida) {
                return [
                    'id' => $salida->id,
                    'producto_nombre' => $salida->insumo ? $salida->insumo->nombre : 'Producto eliminado',
                    'tipo' => $salida->insumo ? $salida->insumo->tipo : 'N/A',
                    'cantidad' => number_format($salida->cantidad, 3),
                    'unidad_medida' => $salida->unidad_medida,
                    'precio_unitario' => number_format($salida->precio_unitario, 2),
                    'lote_nombre' => $salida->lote ? $salida->lote->nombre : null,
                    'fecha_salida' => $salida->fecha_salida,
                    'observaciones' => $salida->observaciones
                ];
            });

        return response()->json($salidas);
    }

    public function lista()
    {
        $salidas = SalidaInventario::with(['insumo', 'lote'])->get()->map(function($salida) {
            // Agrega el nombre del insumo (producto) a cada salida
            $salida->nombre = $salida->insumo ? $salida->insumo->nombre : '';
            // Agrega el nombre del lote si existe
            $salida->lote_nombre = $salida->lote ? $salida->lote->nombre : '';
            return $salida;
        });
        return response()->json($salidas);
    }
}
