<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class LotesController extends Controller
{
    // Muestra el listado de todos los lotes registrados
    public function index()
    {
        $lotes = Lote::all(); // Obtiene todos los lotes de la base de datos
        return view('lotes.create', compact('lotes')); // Envía los lotes a la vista para mostrar
    }

    // Muestra el formulario para crear un nuevo lote
    public function create()
    {
        $lotes = Lote::all(); // Obtiene todos los lotes (puede usarse para mostrar en el formulario)
        return view('lotes.create', compact('lotes')); // Envía los lotes a la vista
    }

    // Guarda un nuevo lote en la base de datos
    public function store(Request $request)
    {
        // Valida los datos enviados desde el formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255', // Nombre obligatorio
            'fecha_inicio' => 'required|date', // Fecha de inicio obligatoria
            'area' => 'required|numeric', // Área obligatoria
            'capacidad' => 'required|integer|min:1|max:99999', // Capacidad obligatoria
            'tipo_cacao' => 'required|string|max:255', // Tipo de cacao obligatorio
            'estado' => 'required|in:Activo,Inactivo', // Estado obligatorio
            'observaciones' => 'nullable|string', // Observaciones opcionales
        ]);

        Lote::create($validated); // Crea el lote con los datos validados

        if ($request->ajax()) {
            // Si la petición es AJAX, responde en JSON
            return response()->json(['success' => true]);
        }

        // Si no es AJAX, redirige al listado con mensaje de éxito
        return redirect()->route('lotes.index')->with('success', 'Lote registrado con éxito 💚');
    }

    // Actualiza los datos de un lote existente
    public function update(Request $request, $id)
    {
        try {
            // Log para depuración: inicio de actualización
            Log::info('=== INICIANDO ACTUALIZACIÓN DE LOTE ===', [
                'id' => $id,
                'request_data' => $request->all(),
                'is_ajax' => $request->ajax()
            ]);

            $lote = Lote::findOrFail($id); // Busca el lote por ID

            // Valida los datos enviados
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'fecha_inicio' => 'required|date',
                'area' => 'required|numeric',
                'capacidad' => 'required|numeric|min:1|max:99999',
                'tipo_cacao' => 'required|string|max:255',
                'estado' => 'required|in:Activo,Inactivo',
                'observaciones' => 'nullable|string',
            ]);

            // Asegura que la capacidad se guarde como entero
            $validated['capacidad'] = (int) $validated['capacidad'];

            $lote->update($validated); // Actualiza el lote con los datos validados

            // Log para depuración: lote actualizado
            Log::info('=== LOTE ACTUALIZADO EXITOSAMENTE ===', [
                'lote_id' => $lote->id,
                'lote_data' => $lote->toArray()
            ]);

            if ($request->ajax()) {
                // Si la petición es AJAX, responde en JSON
                return response()->json([
                    'success' => true,
                    'message' => 'Lote actualizado correctamente',
                    'lote' => $lote
                ]);
            }

            // Si no es AJAX, redirige al listado con mensaje de éxito
            return redirect()->route('lotes.index')->with('success', 'Lote actualizado correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Error de validación: muestra los errores
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
            // Error general: muestra mensaje de error
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

    // Elimina un lote de la base de datos
    public function destroy($id)
    {
        $lote = Lote::findOrFail($id); // Busca el lote por ID
        $lote->delete(); // Elimina el lote
        return redirect()->route('lotes.index')->with('success', 'Lote eliminado correctamente.'); // Redirige con mensaje
    }

    // Exporta el listado de lotes a un archivo PDF
    public function exportPdf()
    {
        try {
            $lotes = Lote::all(); // Obtiene todos los lotes
            $pdf = Pdf::loadView('lotes.pdf', compact('lotes')); // Carga la vista PDF con los lotes

            // Configura el PDF: tamaño y fuente
            $pdf->setPaper('A4', 'landscape');
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif'
            ]);

            return $pdf->download('reporte_lotes_' . date('Y-m-d') . '.pdf'); // Descarga el PDF
        } catch (\Exception $e) {
            // Si hay error, regresa con mensaje
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    // Exporta el PDF de un lote específico
    public function exportPdfLote($id)
    {
        try {
            $lote = Lote::findOrFail($id); // Busca el lote por ID
            $lotes = collect([$lote]); // Lo convierte en colección para la vista PDF
            $pdf = Pdf::loadView('lotes.pdf', compact('lotes')); // Carga la vista PDF con el lote

            // Configura el PDF: tamaño y fuente
            $pdf->setPaper('A4', 'landscape');
            $pdf->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif'
            ]);

            return $pdf->download('reporte_lote_' . $lote->nombre . '_' . date('Y-m-d') . '.pdf'); // Descarga el PDF
        } catch (\Exception $e) {
            // Si hay error, regresa con mensaje
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    // Devuelve todos los lotes en formato JSON (para AJAX)
    public function lista()
    {
        return response()->json(Lote::all()); // Responde con todos los lotes
    }

    // Devuelve un lote individual en formato JSON (por ID, para AJAX)
    public function obtenerLote($id)
    {
        $lote = Lote::findOrFail($id); // Busca el lote por ID
        return response()->json($lote); // Responde con el lote
    }

    // Devuelve todos los lotes activos para la salida de inventario (API)
    public function apiGetAll()
    {
        $lotes = Lote::select('id', 'nombre', 'estado') // Selecciona solo los campos necesarios
                     ->where('estado', 'Activo') // Solo lotes activos
                     ->orderBy('nombre') // Ordena por nombre
                     ->get(); // Obtiene los lotes
        return response()->json($lotes); // Responde con los lotes
    }

    // Devuelve la producción activa de un lote (para API)
    public function produccionActiva($loteId)
    {
        // Busca la producción activa asociada al lote (que no esté completada)
        $produccion = \App\Models\Produccion::where('lote_id', $loteId)
            ->where('estado', '!=', 'completado')
            ->first();

        if ($produccion) {
            // Si hay producción activa, responde con sus datos
            return response()->json([
                'success' => true,
                'produccion' => [
                    'id' => $produccion->id,
                    'tipo_cacao' => $produccion->tipo_cacao,
                ]
            ]);
        } else {
            // Si no hay producción activa, responde con mensaje de error
            return response()->json([
                'success' => false,
                'message' => 'No hay producción activa para este lote.'
            ], 404);
        }
    }
}
