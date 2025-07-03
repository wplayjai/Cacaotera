<?php
namespace App\Http\Controllers;

use App\Models\SalidaInventario;
use Illuminate\Http\Request;

class SalidaInventarioController extends Controller
{
    public function store(Request $request)
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

        \App\Models\SalidaInventario::create($request->all());

        return response()->json(['message' => 'Salida registrada correctamente.']);
    }

    public function lista()
    {
        $salidas = SalidaInventario::orderBy('fecha_registro', 'desc')->get();
        return response()->json($salidas);
    }
}
