<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use Barryvdh\DomPDF\Facade\Pdf;

class LotesController extends Controller
{
    // Mostrar listado
    public function index()
    {
        $lotes = Lote::all();
        return view('lotes.create', compact('lotes'));
    }

    // Formulario de creación
    public function create()
    {
        $lotes = Lote::all();
        return view('lotes.create', compact('lotes'));
    }

    // Guardar nuevo lote
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'area' => 'required|numeric',
            'capacidad' => 'required|integer|min:1|max:99999',
            'tipo_cacao' => 'required|string|max:255',
            'estado' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        Lote::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('lotes.index')->with('success', 'Lote registrado con éxito 💚');
    }

    // Actualizar lote existente
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

    // Eliminar lote
    public function destroy($id)
    {
        $lote = Lote::findOrFail($id);
        $lote->delete();
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado correctamente.');
    }

    // Exportar a PDF
    public function exportPdf()
    {
        $lotes = Lote::all();
        $pdf = Pdf::loadView('lotes.pdf', compact('lotes'));
        return $pdf->download('reporte_lotes.pdf');
    }

    // Exportar PDF de un lote específico
    public function exportPdfLote($id)
    {
        $lote = Lote::findOrFail($id);
        $lotes = collect([$lote]); // Convertir a colección para mantener compatibilidad con la vista
        $pdf = Pdf::loadView('lotes.pdf', compact('lotes'));
        return $pdf->download('reporte_lote_' . $lote->nombre . '.pdf');
    }

    // ✅ AJAX: todos los lotes en JSON
    public function lista()
    {
        return response()->json(Lote::all());
    }

    // ✅ AJAX: lote individual por ID
    public function obtenerLote($id)
    {
        $lote = Lote::findOrFail($id);
        return response()->json($lote);
    }
}
