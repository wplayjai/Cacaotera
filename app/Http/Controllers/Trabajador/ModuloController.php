<?php

namespace App\Http\Controllers\Trabajador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lote;
use App\Models\Inventario;
use App\Models\Produccion;
use App\Models\SalidaInventario;
use App\Models\Recoleccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModuloController extends Controller
{
    public function index()
    {
        // Obtener lotes activos asignados al trabajador
        $lotes = Lote::activos()->get();
        
        // Obtener inventario disponible
        $inventario = Inventario::where('estado', 'activo')
                               ->where('cantidad', '>', 0)
                               ->get();
        
        // Obtener producciones en curso
        $producciones = Produccion::whereIn('estado', ['siembra', 'crecimiento', 'maduracion', 'cosecha'])
                                 ->with('lote')
                                 ->get();
        
        return view('trabajador.modulo', compact('lotes', 'inventario', 'producciones'));
    }

    // Gestión de Lotes
    public function lotes()
    {
        // Solo lotes activos
        $lotes = Lote::where('estado', 'activo')
                    ->with(['producciones' => function($query) {
                        $query->whereIn('estado', ['siembra', 'crecimiento', 'maduracion', 'cosecha']);
                    }])
                    ->get();
        
        return view('trabajador.lotes.index', compact('lotes'));
    }

    // Historial de trabajo del trabajador
    public function historialTrabajo()
    {
        $trabajador_id = Auth::id();
        
        $historial = SalidaInventario::with(['insumo', 'lote'])
                                   ->where('trabajador_id', $trabajador_id)
                                   ->orderBy('fecha_salida', 'desc')
                                   ->get();
        
        return view('trabajador.historial.index', compact('historial'));
    }

    public function loteDetalle($id)
    {
        $lote = Lote::with(['producciones', 'salidaInventarios.insumo'])->findOrFail($id);
        return view('trabajador.lotes.detalle', compact('lote'));
    }

    // Gestión de Inventario
    public function inventario()
    {
        // Solo inventarios disponibles (pesticidas y fertilizantes)
        $inventario = Inventario::where('estado', 'activo')
                               ->where('cantidad', '>', 0)
                               ->whereIn('tipo', ['pesticida', 'fertilizante'])
                               ->orderBy('nombre')
                               ->get();
        
        // Obtener lotes activos para selección
        $lotes = Lote::where('estado', 'activo')->get();
        
        return view('trabajador.inventario.index', compact('inventario', 'lotes'));
    }

    public function retirarInsumo(Request $request)
    {
        $request->validate([
            'insumo_id' => 'required|exists:inventarios,id',
            'cantidad' => 'required|numeric|min:0.01',
            'lote_id' => 'required|exists:lotes,id',
            'motivo' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $insumo = Inventario::findOrFail($request->insumo_id);
            
            if ($insumo->cantidad < $request->cantidad) {
                return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible']);
            }

            // Crear salida de inventario
            SalidaInventario::create([
                'insumo_id' => $request->insumo_id,
                'lote_id' => $request->lote_id,
                'cantidad' => $request->cantidad,
                'motivo' => $request->motivo,
                'fecha_salida' => now(),
                'trabajador_id' => Auth::id(),
            ]);

            // Actualizar cantidad en inventario
            $insumo->cantidad -= $request->cantidad;
            $insumo->save();

            DB::commit();
            return back()->with('success', 'Insumo retirado correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al retirar insumo']);
        }
    }

    // Gestión de Producción
    public function produccion()
    {
        $producciones = Produccion::whereIn('estado', ['siembra', 'crecimiento', 'maduracion', 'cosecha'])
                                 ->with(['lote', 'recolecciones'])
                                 ->orderBy('fecha_programada_cosecha')
                                 ->get();
        
        return view('trabajador.produccion.index', compact('producciones'));
    }

    public function registrarCosecha(Request $request)
    {
        $request->validate([
            'produccion_id' => 'required|exists:producciones,id',
            'cantidad_cosechada' => 'required|numeric|min:0.01',
            'fecha_cosecha' => 'required|date',
            'observaciones' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $produccion = Produccion::findOrFail($request->produccion_id);
            
            // Crear registro de recolección
            Recoleccion::create([
                'produccion_id' => $request->produccion_id,
                'cantidad_recolectada' => $request->cantidad_cosechada,
                'fecha_recoleccion' => $request->fecha_cosecha,
                'trabajador_id' => Auth::id(),
                'observaciones' => $request->observaciones,
            ]);

            // Actualizar producción
            $produccion->cantidad_cosechada += $request->cantidad_cosechada;
            $produccion->fecha_cosecha_real = $request->fecha_cosecha;
            
            // Verificar si la cosecha está completa
            if ($produccion->cantidad_cosechada >= $produccion->estimacion_produccion) {
                $produccion->estado = 'completado';
            }
            
            $produccion->save();

            DB::commit();
            return back()->with('success', 'Cosecha registrada correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al registrar cosecha']);
        }
    }

    public function actualizarEstadoProduccion(Request $request)
    {
        $request->validate([
            'produccion_id' => 'required|exists:producciones,id',
            'nuevo_estado' => 'required|in:siembra,crecimiento,maduracion,cosecha,secado',
        ]);

        $produccion = Produccion::findOrFail($request->produccion_id);
        $produccion->estado = $request->nuevo_estado;
        $produccion->fecha_cambio_estado = now();
        $produccion->save();

        return back()->with('success', 'Estado de producción actualizado');
    }

    // Reportes del trabajador
    public function reportes()
    {
        $trabajador_id = Auth::id();
        
        // Estadísticas del trabajador
        $totalCosechas = Recoleccion::where('trabajador_id', $trabajador_id)->sum('cantidad_recolectada');
        $totalInsumosRetirados = SalidaInventario::where('trabajador_id', $trabajador_id)->count();
        $lotesTrabajados = SalidaInventario::where('trabajador_id', $trabajador_id)
                                          ->distinct('lote_id')
                                          ->count('lote_id');
        
        // Actividad reciente
        $cosechasRecientes = Recoleccion::where('trabajador_id', $trabajador_id)
                                       ->with('produccion.lote')
                                       ->orderBy('fecha_recoleccion', 'desc')
                                       ->limit(10)
                                       ->get();
        
        $insumosRecientes = SalidaInventario::where('trabajador_id', $trabajador_id)
                                           ->with(['insumo', 'lote'])
                                           ->orderBy('fecha_salida', 'desc')
                                           ->limit(10)
                                           ->get();

        return view('trabajador.reportes.index', compact(
            'totalCosechas', 
            'totalInsumosRetirados', 
            'lotesTrabajados',
            'cosechasRecientes',
            'insumosRecientes'
        ));
    }
}


