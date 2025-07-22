<?php
namespace App\Http\Controllers;

use App\Models\SalidaInventario;
use Illuminate\Http\Request;

class SalidaInventarioController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'insumo_id' => 'required|exists:inventarios,id',
                'lote_id' => 'nullable|exists:lotes,id',
                'cantidad' => 'required|numeric|min:0.001',
                'unidad_medida' => 'required|string|max:255',
                'precio_unitario' => 'required|numeric|min:0',
                'estado' => 'required|string|max:255',
                'fecha_registro' => 'required|string',
                'fecha_salida' => 'required|date',
                'observaciones' => 'nullable|string',
            ]);

            // Crear la salida de inventario
            SalidaInventario::create($validatedData);

            // Actualizar el inventario restando la cantidad
            $inventario = \App\Models\Inventario::find($request->insumo_id);
            if ($inventario) {
                $inventario->cantidad -= $request->cantidad;
                $inventario->save();
            }

            return response()->json(['message' => 'Salida registrada correctamente.']);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno: ' . $e->getMessage()
            ], 500);
        }
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
