<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;

class LotesController extends Controller
{
    // Mostrar el formulario para crear un nuevo lote
    public function create()
    {
        $lotes = Lote::all(); // Asegúrate de pasar los lotes a la vista
        return view('lotes.create', compact('lotes'));
    }

    // Guardar un nuevo lote
    public function store(Request $request)
    {
        // Validación de los campos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'area' => 'required|numeric',
            'capacidad' => 'required|integer',
            'tipo_cacao' => 'required|string|max:255',
            'estado' => 'required|in:Activo,Inactivo',
            'estimacion_cosecha' => 'nullable|numeric',
            'fecha_programada_cosecha' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        // Crear el lote con los datos validados
        Lote::create($validated);

        // Redirigir de nuevo al formulario con mensaje de éxito
        return redirect()->route('register.lote.form')->with('success', 'Lote registrado con éxito 💚');
    }
}
