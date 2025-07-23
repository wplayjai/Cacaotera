<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trabajador;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class TrabajadoresController extends Controller
{
    public function index() 
    {
        $trabajadores = Trabajador::with('user')->get();
        return view('trabajadores.index', compact('trabajadores'));
    }
    
    public function create()
    {
        return view('trabajadores.create');
    }

    public function toggleEstado($id)
{
    $trabajador = Trabajador::with('user')->findOrFail($id);
    $user = $trabajador->user;

    $user->estado = $user->estado === 'activo' ? 'inactivo' : 'activo';
    $user->save();

    return redirect()->back()->with('success', 'Estado del trabajador actualizado correctamente.');
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'identificacion' => 'required',
            'password' => 'required|min:6',
            'direccion' => 'required',
            'telefono' => 'required',
            'fecha_contratacion' => 'required|date',
            'tipo_contrato' => 'required',
            'forma_pago' => 'required',
        ]);
        
        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'identificacion' => $request->identificacion,
            'password' => Hash::make($request->password),
            'rol' => 'trabajador' // si manejas roles
        ]);
        
        // Crear datos del trabajador
        Trabajador::create([
            'user_id' => $user->id,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'fecha_contratacion' => $request->fecha_contratacion,
            'tipo_contrato' => $request->tipo_contrato,
            'forma_pago' => $request->forma_pago,
        ]);
        
        return redirect()->route('trabajadores.index')->with('success', 'Trabajador registrado correctamente');
    }

    public function show($id)
    {
        $trabajador = Trabajador::with('user')->findOrFail($id);
        return view('trabajadores.show', compact('trabajador'));
    }

    public function edit($id)
    {
        $trabajador = Trabajador::with('user')->findOrFail($id);
        
        // Si es una solicitud AJAX, devolver JSON
        if (request()->ajax()) {
            return response()->json($trabajador);
        }
        
        // Para solicitudes normales, devolver la vista
        return view('trabajadores.edit', compact('trabajador'));
    }

    public function update(Request $request, $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        
        // Validación
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string',
            'forma_pago' => 'required|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Actualizar datos del usuario
            $user = User::findOrFail($trabajador->user_id);
            $user->name = $validatedData['nombre'];
            $user->email = $validatedData['email'];
            
            $user->save();
            
            // Actualizar datos del trabajador
            $trabajador->direccion = $validatedData['direccion'];
            $trabajador->telefono = $validatedData['telefono'];
            $trabajador->tipo_contrato = $validatedData['tipo_contrato'];
            $trabajador->forma_pago = $validatedData['forma_pago'];
            $trabajador->save();
            
            DB::commit();
            
            // Para solicitudes AJAX
            if ($request->ajax()) {
                $trabajador->load('user'); // Recargar la relación
                return response()->json([
                    'success' => true,
                    'trabajador' => $trabajador,
                    'message' => 'Trabajador actualizado correctamente'
                ]);
            }
            
            // Para solicitudes normales
            return redirect()->route('trabajadores.index')
                ->with('success', 'Trabajador actualizado correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Para solicitudes AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el trabajador: ' . $e->getMessage()
                ], 500);
            }
            
            // Para solicitudes normales
            return back()->withErrors('Error al actualizar el trabajador: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $trabajador = Trabajador::findOrFail($id);
            $user = User::findOrFail($trabajador->user_id);
            
            $trabajador->delete();
            $user->delete();
            
            // Para solicitudes AJAX
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Trabajador eliminado correctamente'
                ]);
            }
            
            // Para solicitudes normales
            return redirect()->route('trabajadores.index')
                ->with('success', 'Trabajador eliminado correctamente');
                
        } catch (\Exception $e) {
            // Para solicitudes AJAX
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el trabajador: ' . $e->getMessage()
                ], 500);
            }
            
            // Para solicitudes normales
            return back()->withErrors('Error al eliminar el trabajador: ' . $e->getMessage());
        }
    }
    // Control de asistencia
    public function asistencia()
    {
        $trabajadores = Trabajador::with('user')->get();
        $fecha_actual = Carbon::now()->format('Y-m-d');
        
        // Contar asistencias de hoy
        $asistencias_hoy = Asistencia::whereDate('fecha', Carbon::today())->count();
        
        return view('trabajadores.asistencia', compact('trabajadores', 'fecha_actual', 'asistencias_hoy'));
    }
    
    public function registrarAsistencia(Request $request)
    {
        $request->validate([
            'trabajador_id' => 'required|exists:trabajadors,id',
            'fecha' => 'required|date',
            'lote_id' => 'required|exists:lotes,id',
            'hora_entrada' => 'required',
            'hora_salida' => 'required',
        ]);
        
        // Verificar si ya existe una asistencia para este trabajador en esta fecha y lote
        $asistencia = Asistencia::where('trabajador_id', $request->trabajador_id)
                              ->where('fecha', $request->fecha)
                              ->where('lote_id', $request->lote_id)
                              ->first();
        
        if ($asistencia) {
            // Actualizar la asistencia existente
            $asistencia->update([
                'hora_entrada' => $request->hora_entrada,
                'hora_salida' => $request->hora_salida,
                'lote_id' => $request->lote_id,
                'observaciones' => $request->observaciones,
            ]);
            
            $mensaje = 'Asistencia actualizada correctamente';
        } else {
            // Crear nueva asistencia
            Asistencia::create([
                'trabajador_id' => $request->trabajador_id,
                'fecha' => $request->fecha,
                'lote_id' => $request->lote_id,
                'hora_entrada' => $request->hora_entrada,
                'hora_salida' => $request->hora_salida,
                'observaciones' => $request->observaciones,
            ]);
            
            $mensaje = 'Asistencia registrada correctamente';
        }
        
        return redirect()->back()->with('success', $mensaje);
    }
    
    public function listarAsistencias(Request $request)
    {
        $fecha_inicio = $request->fecha_inicio ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $fecha_fin = $request->fecha_fin ?? Carbon::now()->format('Y-m-d');
        
        $query = Asistencia::with(['trabajador.user', 'lote'])
                          ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        
        // Filtrar por trabajador si se especifica
        if ($request->trabajador_id) {
            $query->where('trabajador_id', $request->trabajador_id);
        }
        
        // Filtrar por lote si se especifica
        if ($request->lote_id) {
            $query->where('lote_id', $request->lote_id);
        }
        
        $asistencias = $query->orderBy('fecha', 'desc')->get();
        
        return view('trabajadores.listar_asistencias', compact('asistencias', 'fecha_inicio', 'fecha_fin'));
    }
    
    // Generación de reportes
    public function reportes()
    {
        return view('trabajadores.reportes');
    }
    
    public function generarReporteAsistencia(Request $request)
    {
        $request->validate([
            'tipo_reporte' => 'required|in:asistencia,todos',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);
        
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        
        $query = Asistencia::with(['trabajador.user'])
                          ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        
        if ($request->trabajador_id) {
            $query->where('trabajador_id', $request->trabajador_id);
        }
        
        $asistencias = $query->orderBy('fecha', 'desc')->get();
        
        // Estadísticas
        $total_dias = Carbon::parse($fecha_inicio)->diffInDays(Carbon::parse($fecha_fin)) + 1;
        $estadisticas = [];
        
        foreach ($asistencias->groupBy('trabajador_id') as $trabajador_id => $asistencias_trabajador) {
            $trabajador = $asistencias_trabajador->first()->trabajador;
            $total_asistencias = $asistencias_trabajador->count();
            $horas_trabajadas = 0;
            
            foreach ($asistencias_trabajador as $asistencia) {
                if ($asistencia->hora_entrada && $asistencia->hora_salida) {
                    $entrada = Carbon::parse($asistencia->hora_entrada);
                    $salida = Carbon::parse($asistencia->hora_salida);
                    $horas_trabajadas += $entrada->diffInHours($salida);
                }
            }
            
            $estadisticas[] = [
                'trabajador' => $trabajador->user->name,
                'total_asistencias' => $total_asistencias,
                'porcentaje_asistencia' => round(($total_asistencias / $total_dias) * 100, 2),
                'horas_trabajadas' => $horas_trabajadas,
            ];
        }
        
        return view('trabajadores.reporte_asistencia', compact('asistencias', 'estadisticas', 'fecha_inicio', 'fecha_fin'));
    }
    
    public function exportarReporteAsistencia(Request $request)
    {
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        
        $query = Asistencia::with(['trabajador.user'])
                          ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
        
        if ($request->trabajador_id) {
            $query->where('trabajador_id', $request->trabajador_id);
        }
        
        $asistencias = $query->orderBy('fecha', 'desc')->get();
        
        // Generar PDF (requiere paquete barryvdh/laravel-dompdf)
        $pdf = PDF::loadView('trabajadores.pdf.reporte_asistencia', compact('asistencias', 'fecha_inicio', 'fecha_fin'));
        
        return $pdf->download('reporte_asistencia_' . Carbon::now()->format('Ymd') . '.pdf');
    }
}