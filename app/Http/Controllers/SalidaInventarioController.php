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
