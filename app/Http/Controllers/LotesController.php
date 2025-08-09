<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

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
        try {
            Log::info('=== INICIANDO ACTUALIZACIÓN DE LOTE ===', [
                'id' => $id,
                'request_data' => $request->all(),
                'is_ajax' => $request->ajax()
            ]);

            $lote = Lote::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'fecha_inicio' => 'required|date',
                'area' => 'required|numeric',
                'capacidad' => 'required|numeric|min:1|max:99999',
                'tipo_cacao' => 'required|string|max:255',
                'estado' => 'required|in:Activo,Inactivo',
                'observaciones' => 'nullable|string',
            ]);

            // Convertir capacidad a entero para asegurar que se guarde correctamente
            $validated['capacidad'] = (int) $validated['capacidad'];

            $lote->update($validated);

            Log::info('=== LOTE ACTUALIZADO EXITOSAMENTE ===', [
                'lote_id' => $lote->id,
                'lote_data' => $lote->toArray()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lote actualizado correctamente',
                    'lote' => $lote
                ]);
            }

            return redirect()->route('lotes.index')->with('success', 'Lote actualizado correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('=== ERROR DE VALIDACIÓN ===', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('=== ERROR GENERAL EN ACTUALIZACIÓN ===', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el lote: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al actualizar el lote.');
        }
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
        try {
            $lotes = Lote::all();
            $pdf = Pdf::loadView('lotes.pdf', compact('lotes'));

            // Configurar opciones del PDF
            $pdf->setPaper('A4', 'landscape');
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif'
            ]);

            return $pdf->download('reporte_lotes_' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    // Exportar PDF de un lote específico
    public function exportPdfLote($id)
    {
        try {
            $lote = Lote::findOrFail($id);
            $lotes = collect([$lote]); // Convertir a colección para mantener compatibilidad con la vista
            $pdf = Pdf::loadView('lotes.pdf', compact('lotes'));

            // Configurar opciones del PDF
            $pdf->setPaper('A4', 'landscape');
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif'
            ]);

            return $pdf->download('reporte_lote_' . $lote->nombre . '_' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
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

    // ✅ API: todos los lotes para salida de inventario
    public function apiGetAll()
    {
        $lotes = Lote::select('id', 'nombre', 'estado')
                     ->where('estado', 'Activo')
                     ->orderBy('nombre')
                     ->get();
        return response()->json($lotes);
    }
}
