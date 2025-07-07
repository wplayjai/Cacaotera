<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Lote;
use App\Models\Trabajador;
use App\Models\Inventario;
use App\Models\SalidaInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProduccionController extends Controller
{
    public function index()
    {
       $producciones = Produccion::with(['lote', 'trabajadores', 'insumos'])
    ->where('estado', '!=', 'eliminada') 
    ->orderBy('fecha_inicio', 'desc')
    ->paginate(10);


        $proximosCosecha = Produccion::proximosCosecha()
            ->with('lote')
            ->get();

        return view('produccion.index', compact('producciones', 'proximosCosecha'));
    }

    public function create()
    {
        $lotes = Lote::where('estado', 'activo', 'inactivo')->get();
        $trabajadores = Trabajador::with('user')->get();
        $insumos = Inventario::where('estado', 'inactivo', 'activo')
            ->where('tipo', 'insumo')
            ->get();

        return view('produccion.create', compact('lotes', 'trabajadores', 'insumos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'fecha_inicio' => 'required|date',
            'tipo_cacao' => 'required|string',
            'area_asignada' => 'required|numeric|min:0',
            'estimacion_produccion' => 'required|numeric|min:0',
            'fecha_programada_cosecha' => 'required|date|after:fecha_inicio',
            'trabajadores' => 'required|array',
            'trabajadores.*' => 'exists:trabajadors,id',
            'insumos' => 'array',
            'insumos.*.id' => 'exists:inventarios,id',
            'insumos.*.cantidad' => 'numeric|min:0',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            $produccion = Produccion::create([
                'lote_id' => $request->lote_id,
                'fecha_inicio' => $request->fecha_inicio,
                'tipo_cacao' => $request->tipo_cacao,
                'area_asignada' => $request->area_asignada,
                'estimacion_produccion' => $request->estimacion_produccion,
                'fecha_programada_cosecha' => $request->fecha_programada_cosecha,
                'estado' => 'planificado',
                'fecha_cambio_estado' => now(),
                'observaciones' => $request->observaciones,
                'personal_asignado' => $request->trabajadores,
                'insumos_utilizados' => $request->insumos ?? [],
                'activo' => true
            ]);

            // Asociar trabajadores
            $produccion->trabajadores()->attach($request->trabajadores);

            // Procesar insumos y crear salidas de inventario
            if ($request->insumos) {
                foreach ($request->insumos as $insumo) {
                    if ($insumo['cantidad'] > 0) {
                        $inventario = Inventario::find($insumo['id']);
                        
                        if ($inventario->cantidad >= $insumo['cantidad']) {
                            // Crear salida de inventario
                            SalidaInventario::create([
                                'insumo_id' => $insumo['id'],
                                'produccion_id' => $produccion->id,
                                'cantidad' => $insumo['cantidad'],
                                'motivo' => 'Uso en producción',
                                'fecha_salida' => now(),
                                'responsable' => auth()->user()->name
                            ]);

                            // Actualizar inventario
                            $inventario->decrement('cantidad', $insumo['cantidad']);
                        } else {
                            throw new \Exception("Stock insuficiente para el insumo: {$inventario->nombre}");
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('produccion.index')
                ->with('success', 'Producción creada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear la producción: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Produccion $produccion)
    {
        $produccion->load(['lote', 'trabajadores.user', 'insumos', 'salidaInventarios.inventario']);
        
        return view('produccion.show', compact('produccion'));
    }

    public function edit(Produccion $produccion)
    {
        $lotes = Lote::where('activo', true)->get();
        $trabajadores = Trabajador::with('user')->get();
        $insumos = Inventario::where('estado', 'disponible')
            ->where('tipo', 'insumo')
            ->get();

        $produccion->load(['trabajadores', 'salidaInventarios.inventario']);

        return view('produccion.edit', compact('produccion', 'lotes', 'trabajadores', 'insumos'));
    }

    public function update(Request $request, Produccion $produccion)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'fecha_inicio' => 'required|date',
            'tipo_cacao' => 'required|string',
            'area_asignada' => 'required|numeric|min:0',
            'estimacion_produccion' => 'required|numeric|min:0',
            'fecha_programada_cosecha' => 'required|date',
            'estado' => 'required|in:' . implode(',', array_keys(Produccion::ESTADOS)),
            'cantidad_cosechada' => 'nullable|numeric|min:0',
            'fecha_cosecha_real' => 'nullable|date',
            'trabajadores' => 'required|array',
            'trabajadores.*' => 'exists:trabajadors,id',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            $estadoAnterior = $produccion->estado;
            
            $produccion->update([
                'lote_id' => $request->lote_id,
                'fecha_inicio' => $request->fecha_inicio,
                'tipo_cacao' => $request->tipo_cacao,
                'area_asignada' => $request->area_asignada,
                'estimacion_produccion' => $request->estimacion_produccion,
                'fecha_programada_cosecha' => $request->fecha_programada_cosecha,
                'estado' => $request->estado,
                'cantidad_cosechada' => $request->cantidad_cosechada,
                'fecha_cosecha_real' => $request->fecha_cosecha_real,
                'observaciones' => $request->observaciones,
                'personal_asignado' => $request->trabajadores,
                'fecha_cambio_estado' => $estadoAnterior != $request->estado ? now() : $produccion->fecha_cambio_estado
            ]);

            // Calcular rendimiento y desviación si hay cantidad cosechada
            if ($request->cantidad_cosechada) {
                $produccion->calcularDesviacion();
                $produccion->rendimiento_real = $produccion->porcentajeRendimiento();
                $produccion->save();
            }

            // Actualizar trabajadores
            $produccion->trabajadores()->sync($request->trabajadores);

            DB::commit();
            return redirect()->route('produccion.index')
                ->with('success', 'Producción actualizada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar la producción: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Produccion $produccion)
    {
        DB::beginTransaction();
        try {
            // Restaurar inventario de insumos utilizados
            foreach ($produccion->salidaInventarios as $salida) {
                $salida->inventario->increment('cantidad', $salida->cantidad);
                $salida->delete();
            }

            // Desasociar trabajadores
            $produccion->trabajadores()->detach();

            // Marcar como inactivo en lugar de eliminar
            $produccion->update(['activo' => false]);

            DB::commit();
            return redirect()->route('produccion.index')
                ->with('success', 'Producción eliminada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar la producción: ' . $e->getMessage());
        }
    }

    public function cambiarEstado(Request $request, Produccion $produccion)
    {
        $request->validate([
            'estado' => 'required|in:' . implode(',', array_keys(Produccion::ESTADOS)),
            'observaciones' => 'nullable|string|max:500'
        ]);

        $produccion->update([
            'estado' => $request->estado,
            'fecha_cambio_estado' => now(),
            'observaciones' => $request->observaciones
        ]);

        return redirect()->back()
            ->with('success', 'Estado actualizado exitosamente');
    }

    public function registrarCosecha(Request $request, Produccion $produccion)
    {
        $request->validate([
            'cantidad_cosechada' => 'required|numeric|min:0',
            'fecha_cosecha_real' => 'required|date',
            'observaciones' => 'nullable|string|max:500'
        ]);

        $produccion->update([
            'cantidad_cosechada' => $request->cantidad_cosechada,
            'fecha_cosecha_real' => $request->fecha_cosecha_real,
            'estado' => 'cosecha',
            'fecha_cambio_estado' => now(),
            'observaciones' => $request->observaciones
        ]);

        // Calcular métricas
        $produccion->calcularDesviacion();
        $produccion->rendimiento_real = $produccion->porcentajeRendimiento();
        $produccion->save();

        return redirect()->back()
            ->with('success', 'Cosecha registrada exitosamente');
    }

    public function reporteRendimiento()
    {
        $producciones = Produccion::with('lote')
            ->whereNotNull('cantidad_cosechada')
            ->orderBy('fecha_cosecha_real', 'desc')
            ->get();

        $estadisticas = [
            'total_producciones' => $producciones->count(),
            'promedio_rendimiento' => $producciones->avg('rendimiento_real'),
            'mejor_rendimiento' => $producciones->max('rendimiento_real'),
            'peor_rendimiento' => $producciones->min('rendimiento_real'),
            'total_cosechado' => $producciones->sum('cantidad_cosechada'),
            'total_estimado' => $producciones->sum('estimacion_produccion')
        ];

        return view('produccion.reporte-rendimiento', compact('producciones', 'estadisticas'));
    }

    public function exportarReporte()
    {
        // Implementar exportación a Excel/PDF
        // Usar Laravel Excel o similar
    }
}