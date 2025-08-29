<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trabajador;
use App\Models\Asistencia;
use App\Models\Lote;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

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
        try {
            $request->validate([
                'trabajadores' => 'required|array|min:1',
                'trabajadores.*' => 'exists:trabajadors,id',
                'fecha_registro' => 'required|date',
                'lote_id' => 'required|exists:lotes,id',
                'hora_entrada' => 'required',
                'hora_salida' => 'nullable',
            ]);

            $trabajadores = $request->trabajadores;
            $fecha = $request->fecha_registro;
            $lote_id = $request->lote_id;
            $hora_entrada = $request->hora_entrada;
            $hora_salida = $request->hora_salida;
            $estado_asistencia = $request->estado_asistencia ?? [];
            $observaciones = $request->observaciones ?? [];

            $registrados = 0;
            $actualizados = 0;

            foreach ($trabajadores as $trabajador_id) {
                // Verificar si ya existe una asistencia para este trabajador en esta fecha
                $asistencia = Asistencia::where('trabajador_id', $trabajador_id)
                                      ->where('fecha', $fecha)
                                      ->first();

                $estado = $estado_asistencia[$trabajador_id] ?? 'presente';
                $obs = $observaciones[$trabajador_id] ?? null;

                if ($asistencia) {
                    // Actualizar la asistencia existente
                    $asistencia->update([
                        'hora_entrada' => $hora_entrada,
                        'hora_salida' => $hora_salida,
                        'lote_id' => $lote_id,
                        'estado' => $estado,
                        'observaciones' => $obs,
                    ]);
                    $actualizados++;
                } else {
                    // Crear nueva asistencia
                    Asistencia::create([
                        'trabajador_id' => $trabajador_id,
                        'fecha' => $fecha,
                        'lote_id' => $lote_id,
                        'hora_entrada' => $hora_entrada,
                        'hora_salida' => $hora_salida,
                        'estado' => $estado,
                        'observaciones' => $obs,
                    ]);
                    $registrados++;
                }
            }

            $mensaje = "Asistencia procesada: {$registrados} registros nuevos, {$actualizados} actualizados";

            return response()->json([
                'success' => true,
                'message' => $mensaje
            ]);

        } catch (\Exception $e) {
            Log::error('Error en registrarAsistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar asistencia: ' . $e->getMessage()
            ], 500);
        }
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
        try {
            // Manejar diferentes parámetros de fecha
            $fecha_inicio = $request->fecha_desde ?? $request->fecha_inicio;
            $fecha_fin = $request->fecha_hasta ?? $request->fecha_fin;
            $periodo = $request->periodo;
            $formato = $request->formato ?? 'pdf';

            // Si viene período pero no fechas específicas, calcular fechas
            if ($periodo && (!$fecha_inicio || !$fecha_fin)) {
                switch ($periodo) {
                    case 'hoy':
                        $fecha_inicio = $fecha_fin = Carbon::today()->format('Y-m-d');
                        break;
                    case 'semana':
                        $fecha_inicio = Carbon::now()->startOfWeek()->format('Y-m-d');
                        $fecha_fin = Carbon::now()->endOfWeek()->format('Y-m-d');
                        break;
                    case 'mes':
                        $fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
                        $fecha_fin = Carbon::now()->endOfMonth()->format('Y-m-d');
                        break;
                    case 'trimestre':
                        $fecha_inicio = Carbon::now()->startOfQuarter()->format('Y-m-d');
                        $fecha_fin = Carbon::now()->endOfQuarter()->format('Y-m-d');
                        break;
                    default:
                        $fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
                        $fecha_fin = Carbon::now()->endOfMonth()->format('Y-m-d');
                }
            }

            // Validar que las fechas existan
            if (!$fecha_inicio || !$fecha_fin) {
                return response()->json(['error' => 'Las fechas de inicio y fin son requeridas.'], 400);
            }

            $query = Asistencia::with(['trabajador.user', 'lote'])
                              ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);

            if ($request->trabajador_id) {
                $query->where('trabajador_id', $request->trabajador_id);
            }

            $asistencias = $query->orderBy('fecha', 'desc')->get();

            // Calcular estadísticas
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

            if ($formato === 'excel') {
                // Generar Excel
                $filename = 'reporte_asistencia_' . Carbon::now()->format('Ymd_His') . '.xlsx';

                // Crear array de datos para Excel
                $data = [];
                $data[] = ['REPORTE DE ASISTENCIA'];
                $data[] = ['Período: ' . $fecha_inicio . ' al ' . $fecha_fin];
                $data[] = ['Generado: ' . Carbon::now()->format('d/m/Y H:i')];
                $data[] = [''];
                $data[] = ['Fecha', 'Trabajador', 'Lote', 'Entrada', 'Salida', 'Estado', 'Observaciones'];

                foreach ($asistencias as $asistencia) {
                    $data[] = [
                        $asistencia->fecha,
                        $asistencia->trabajador->user->name,
                        $asistencia->lote->nombre ?? 'N/A',
                        $asistencia->hora_entrada,
                        $asistencia->hora_salida,
                        ucfirst($asistencia->estado ?? 'presente'),
                        $asistencia->observaciones
                    ];
                }

                // Usar PhpSpreadsheet si está disponible, sino generar CSV
                $headers = [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ];

                // Generar CSV simple como fallback
                $csv = '';
                foreach ($data as $row) {
                    $csv .= implode(',', array_map(function($field) {
                        return '"' . str_replace('"', '""', $field) . '"';
                    }, $row)) . "\n";
                }

                return response($csv, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="reporte_asistencia_' . Carbon::now()->format('Ymd_His') . '.csv"',
                ]);

            } else {
                // Generar PDF
                $pdf = PDF::loadView('trabajadores.pdf.reporte_asistencia', compact('asistencias', 'estadisticas', 'fecha_inicio', 'fecha_fin'))
                         ->setPaper('a4', 'landscape');

                return $pdf->download('reporte_asistencia_' . Carbon::now()->format('Ymd_His') . '.pdf');
            }

        } catch (\Exception $e) {
            Log::error('Error al generar reporte de asistencia: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar el reporte: ' . $e->getMessage()], 500);
        }
    }

    // === MÉTODOS PARA VISTAS UNIFICADAS ===

    /**
     * Vista unificada de asistencia - combina registro y listado
     */
    public function asistenciaUnificada()
    {
        $trabajadores = Trabajador::with('user')
            ->whereHas('user', function($query) {
                $query->where('estado', 'activo');
            })
            ->get();

        $lotes = Lote::where('estado', 'activo')->get();

        $asistencias = Asistencia::with(['trabajador.user'])
            ->whereDate('fecha', '>=', Carbon::now()->subDays(30))
            ->orderBy('fecha', 'desc')
            ->get();

        // Estadísticas básicas
        $estadisticas = [
            'presentes' => Asistencia::whereDate('fecha', Carbon::today())->count(),
            'tardanzas' => Asistencia::whereDate('fecha', Carbon::today())
                ->whereTime('hora_entrada', '>', '08:30:00')->count(),
            'total_trabajadores' => $trabajadores->count(),
            'horas_promedio' => Asistencia::whereDate('fecha', Carbon::today())
                ->whereNotNull('horas_trabajadas')
                ->avg('horas_trabajadas') ?? 0,
        ];

        // Calcular ausentes como trabajadores que no tienen registro hoy
        $trabajadores_con_asistencia = Asistencia::whereDate('fecha', Carbon::today())
            ->pluck('trabajador_id')->toArray();
        $estadisticas['ausentes'] = $trabajadores->count() - count($trabajadores_con_asistencia);

        return view('trabajadores.asistencia-unificada', compact('trabajadores', 'lotes', 'asistencias', 'estadisticas'));
    }

    /**
     * Vista unificada de reportes - todos los reportes en uno
     */
    public function reportesUnificados()
    {
        $trabajadores = Trabajador::with('user')
            ->whereHas('user', function($query) {
                $query->where('estado', 'activo');
            })
            ->get();

        // Métricas generales
        $totalTrabajadores = Trabajador::count();
        $trabajadoresActivos = Trabajador::whereHas('user', function($query) {
            $query->where('estado', 'activo');
        })->count();

        // Porcentaje de asistencia del mes actual
        $inicioMes = Carbon::now()->startOfMonth();
        $diasTranscurridos = Carbon::now()->diffInDays($inicioMes) + 1;
        $totalAsistenciasMes = Asistencia::whereDate('fecha', '>=', $inicioMes)->count();
        $trabajadoresActivos = Trabajador::whereHas('user', function($query) {
            $query->where('estado', 'activo');
        })->count();

        $asistenciasEsperadas = $trabajadoresActivos * $diasTranscurridos;
        $porcentajeAsistencia = $asistenciasEsperadas > 0 ?
            round(($totalAsistenciasMes / $asistenciasEsperadas) * 100, 1) : 0;

        // Productividad promedio (ejemplo básico)
        $productividadPromedio = 50; // Placeholder - calcular según recolecciones

        return view('trabajadores.reportes-unificados', compact(
            'trabajadores',
            'totalTrabajadores',
            'trabajadoresActivos',
            'porcentajeAsistencia',
            'productividadPromedio'
        ));
    }

    /**
     * Filtrar asistencias via AJAX
     */
    public function filtrarAsistencias(Request $request)
    {
        try {
            $query = Asistencia::with(['trabajador.user']);

            if ($request->fecha_desde) {
                $query->whereDate('fecha', '>=', $request->fecha_desde);
            }

            if ($request->fecha_hasta) {
                $query->whereDate('fecha', '<=', $request->fecha_hasta);
            }

            if ($request->trabajador_id) {
                $query->where('trabajador_id', $request->trabajador_id);
            }

            $asistencias = $query->orderBy('fecha', 'desc')->get();

            return response()->json([
                'success' => true,
                'asistencias' => $asistencias
            ]);
        } catch (\Exception $e) {
            Log::error('Error en filtrarAsistencias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar asistencias: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar reporte de asistencia via AJAX (versión unificada)
     */
    public function generarReporteAsistenciaUnificado(Request $request)
    {
        try {
            $periodo = $request->periodo;
            $fechaDesde = $request->fecha_desde;
            $fechaHasta = $request->fecha_hasta;
            $trabajadorId = $request->trabajador_id;

        // Calcular fechas según período
        switch ($periodo) {
            case 'semana':
                $fechaDesde = Carbon::now()->startOfWeek();
                $fechaHasta = Carbon::now()->endOfWeek();
                break;
            case 'mes':
                $fechaDesde = Carbon::now()->startOfMonth();
                $fechaHasta = Carbon::now()->endOfMonth();
                break;
            default:
                $fechaDesde = $fechaDesde ? Carbon::parse($fechaDesde) : Carbon::now()->startOfMonth();
                $fechaHasta = $fechaHasta ? Carbon::parse($fechaHasta) : Carbon::now()->endOfMonth();
        }

        $query = Asistencia::with(['trabajador.user'])
            ->whereBetween('fecha', [$fechaDesde, $fechaHasta]);

        if ($trabajadorId) {
            $query->where('trabajador_id', $trabajadorId);
        }

        $asistencias = $query->get();

        // Calcular resumen
        $resumen = [
            'presentes' => $asistencias->count(),
            'tardanzas' => $asistencias->filter(function($asistencia) {
                return $asistencia->hora_entrada &&
                       Carbon::parse($asistencia->hora_entrada)->format('H:i') > '08:30';
            })->count(),
            'total_trabajadores' => $trabajadorId ? 1 : Trabajador::count(),
            'porcentaje' => 0
        ];

        // Calcular ausentes como trabajadores sin registro en el período
        if (!$trabajadorId) {
            $diasPeriodo = $fechaDesde->diffInDays($fechaHasta) + 1;
            $totalTrabajadores = Trabajador::count();
            $asistenciasEsperadas = $totalTrabajadores * $diasPeriodo;
            $resumen['ausentes'] = $asistenciasEsperadas - $asistencias->count();
            $resumen['porcentaje'] = $asistenciasEsperadas > 0 ?
                round(($asistencias->count() / $asistenciasEsperadas) * 100, 1) : 0;
        } else {
            $diasPeriodo = $fechaDesde->diffInDays($fechaHasta) + 1;
            $resumen['ausentes'] = $diasPeriodo - $asistencias->count();
            $resumen['porcentaje'] = $diasPeriodo > 0 ?
                round(($asistencias->count() / $diasPeriodo) * 100, 1) : 0;
        }

        // Preparar datos para gráficos
        $tendencia = $this->calcularTendenciaAsistencia($fechaDesde, $fechaHasta, $trabajadorId);

        // Distribución basada en datos reales de asistencia
        $presentes = $asistencias->count();
        $tardanzas = $asistencias->filter(function($asistencia) {
            return $asistencia->hora_entrada &&
                   Carbon::parse($asistencia->hora_entrada)->format('H:i') > '08:30';
        })->count();

        $distribucion = [
            'presente' => $presentes - $tardanzas, // Presentes a tiempo
            'tardanza' => $tardanzas,
            'ausente' => $resumen['ausentes'],
            'permiso' => 0, // No tenemos esta información en el modelo actual
        ];

        // Detalle para tabla
        $detalle = $asistencias->map(function($asistencia) {
            $horaEntrada = $asistencia->hora_entrada ?
                Carbon::parse($asistencia->hora_entrada)->format('H:i') : null;

            // Determinar estado basado en hora de entrada
            $estado = 'presente';
            if ($horaEntrada && $horaEntrada > '08:30') {
                $estado = 'tardanza';
            }

            return [
                'fecha' => $asistencia->fecha->format('Y-m-d'),
                'trabajador' => $asistencia->trabajador->user->name,
                'estado' => $estado,
                'hora_entrada' => $horaEntrada,
                'hora_salida' => $asistencia->hora_salida ?
                    Carbon::parse($asistencia->hora_salida)->format('H:i') : null,
                'horas_trabajadas' => $asistencia->horas_trabajadas ?? 0,
            ];
        });

        return response()->json([
            'success' => true,
            'resumen' => $resumen,
            'tendencia' => $tendencia,
            'distribucion' => $distribucion,
            'detalle' => $detalle
        ]);
        } catch (\Exception $e) {
            Log::error('Error en generarReporteAsistenciaUnificado: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar reporte de asistencia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generar reporte de productividad via AJAX
     */
    public function generarReporteProductividad(Request $request)
    {
        try {
            // Placeholder para reporte de productividad
        // Aquí se integraría con el módulo de recolecciones

        $metricas = [
            'total_recolectado' => 1250,
            'promedio_horas' => 8.5,
            'eficiencia' => 92
        ];

        $ranking = [
            ['nombre' => 'Juan Pérez', 'total_recolectado' => 150, 'eficiencia' => 95],
            ['nombre' => 'María García', 'total_recolectado' => 140, 'eficiencia' => 90],
            ['nombre' => 'Carlos López', 'total_recolectado' => 135, 'eficiencia' => 88],
        ];

        return response()->json([
            'success' => true,
            'metricas' => $metricas,
            'ranking' => $ranking
        ]);
        } catch (\Exception $e) {
            Log::error('Error en generarReporteProductividad: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar reporte de productividad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calcular nómina via AJAX
     */
    public function calcularNomina(Request $request)
    {
        try {
            $periodo = $request->periodo;
        $mes = $request->mes;

        $mesCarbon = Carbon::parse($mes . '-01');

        $trabajadores = Trabajador::with('user')
            ->whereHas('user', function($query) {
                $query->where('estado', 'activo');
            })
            ->get();

        $resumen = [
            'total' => 0,
            'trabajadores_activos' => $trabajadores->count(),
            'horas_trabajadas' => 0,
            'promedio_salario' => 0
        ];

        $nomina = [];
        $salarioBase = 1300000; // Salario base ejemplo

        foreach ($trabajadores as $trabajador) {
            // Calcular días trabajados en el mes
            $asistencias = Asistencia::where('trabajador_id', $trabajador->id)
                ->whereYear('fecha', $mesCarbon->year)
                ->whereMonth('fecha', $mesCarbon->month)
                ->count();

            $horasTotales = Asistencia::where('trabajador_id', $trabajador->id)
                ->whereYear('fecha', $mesCarbon->year)
                ->whereMonth('fecha', $mesCarbon->month)
                ->sum('horas_trabajadas') ?? 0;

            $totalPagar = $salarioBase;

            $nomina[] = [
                'nombre' => $trabajador->user->name,
                'dias_trabajados' => $asistencias,
                'horas_totales' => $horasTotales,
                'salario_base' => $salarioBase,
                'bonificaciones' => 0,
                'deducciones' => 0,
                'total_pagar' => $totalPagar
            ];

            $resumen['total'] += $totalPagar;
            $resumen['horas_trabajadas'] += $horasTotales;
        }

        $resumen['promedio_salario'] = $trabajadores->count() > 0 ?
            $resumen['total'] / $trabajadores->count() : 0;

        return response()->json([
            'success' => true,
            'resumen' => $resumen,
            'nomina' => $nomina
        ]);
        } catch (\Exception $e) {
            Log::error('Error en calcularNomina: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al calcular nómina: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método auxiliar para calcular tendencia de asistencia
     */
    private function calcularTendenciaAsistencia($fechaDesde, $fechaHasta, $trabajadorId = null)
    {
        $periodo = $fechaDesde->diffInDays($fechaHasta);
        $labels = [];
        $presentes = [];
        $ausentes = [];

        // Generar datos por día
        for ($i = 0; $i <= $periodo; $i++) {
            $fecha = $fechaDesde->copy()->addDays($i);
            $labels[] = $fecha->format('d/m');

            $query = Asistencia::whereDate('fecha', $fecha);
            if ($trabajadorId) {
                $query->where('trabajador_id', $trabajadorId);
                $totalTrabajadores = 1;
            } else {
                $totalTrabajadores = Trabajador::count();
            }

            $asistenciasDia = $query->count();
            $presentes[] = $asistenciasDia;
            $ausentes[] = $totalTrabajadores - $asistenciasDia;
        }

        return [
            'labels' => $labels,
            'presentes' => $presentes,
            'ausentes' => $ausentes
        ];
    }
}
