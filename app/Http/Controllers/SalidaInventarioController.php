<?php
namespace App\Http\Controllers;

use App\Models\SalidaInventario;
use Illuminate\Http\Request;

class SalidaInventarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'insumo_id' => 'required|exists:inventarios,id',
            'lote_id' => 'nullable|exists:lotes,id',
            'cantidad' => 'required|numeric|min:0.001',
            'unidad_medida' => 'required|string|max:255',
            'precio_unitario' => 'required|numeric|min:0',
            'estado' => 'required|string|max:255',
            'fecha_registro' => 'required|date',
            'motivo' => 'nullable|string|max:255',
            'fecha_salida' => 'nullable|date',
            'responsable' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        SalidaInventario::create($request->all());

        return response()->json(['message' => 'Salida registrada correctamente.']);
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
