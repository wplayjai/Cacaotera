<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use Barryvdh\DomPDF\Facade\Pdf;

class LotesController extends Controller
{
    // Mostrar la lista de lotes
    public function index()
    {
        $lotes = Lote::all(); // Obtener todos los lotes
        return view('lotes.create', compact('lotes')); // Reutilizamos la vista 'create' para mostrar la lista
    }

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
        return redirect()->route('lotes.index')->with('success', 'Lote registrado con éxito 💚');
    }

    // Actualizar un lote existente
    public function update(Request $request, $id)
    {
        $lote = Lote::findOrFail($id);
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
        $lote->update($validated);

        return redirect()->route('lotes.index')->with('success', 'Lote actualizado correctamente.');
    }

    // Eliminar un lote
    public function destroy($id)
    {
        $lote = Lote::findOrFail($id);
        $lote->delete();
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado correctamente.');
    }

    // Exportar lotes a PDF
    public function exportPdf()
    {
        $lotes = Lote::all(); // Obtén todos los lotes de la base de datos
        $pdf = Pdf::loadView('lotes.pdf', compact('lotes')); // Carga la vista para el PDF
        return $pdf->download('reporte_lotes.pdf'); // Descarga el archivo PDF
    }
}
