<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\Produccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos existentes de trabajadores
        $trabajadores = Trabajador::with('user')
                                ->latest()
                                ->take(5)
                                ->get();

        // Agregar datos del inventario
        $inventarios = Inventario::select('nombre', 'tipo', 'cantidad', 'unidad_medida', 'estado')
                                ->orderBy('nombre')
                                ->get();

        // Datos estadísticos adicionales (opcionales)
        $totalProductos = Inventario::count();
        $productosOptimos = Inventario::where('estado', 'Óptimo')->count();
        $productosPorVencer = Inventario::where('estado', 'Por vencer')->count();
        $productosRestringidos = Inventario::where('estado', 'Restringido')->count();

        // === ESTADÍSTICAS DE VENTAS ===
        $fechaInicio = Carbon::now()->subDays(30);
        $fechaFin = Carbon::now();

        // 1. Ventas Totales (últimos 30 días)
        $ventasTotales = Venta::whereBetween('fecha_venta', [$fechaInicio, $fechaFin])
                            ->sum('total_venta');

        // 2. Producción Total (último mes)
        $produccionTotal = Produccion::whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                                   ->sum('cantidad_cosechada');

        // 3. Clientes Activos (últimos 90 días)
        $clientesActivos = Venta::where('fecha_venta', '>=', Carbon::now()->subDays(90))
                               ->distinct('cliente')
                               ->count('cliente');

        // 4. Cálculo de Rentabilidad
        $ventasUltimos30 = Venta::whereBetween('fecha_venta', [$fechaInicio, $fechaFin])
                                ->sum('total_venta');
        
        $costosProduccion = Produccion::whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                                    ->sum('estimacion_produccion') * 0.7; // Estimación de costos al 70%
        
        $rentabilidad = $ventasUltimos30 > 0 ? (($ventasUltimos30 - $costosProduccion) / $ventasUltimos30) * 100 : 0;

        // === DATOS PARA GRÁFICO DE VENTAS ===
        $ventasPorDia = Venta::whereBetween('fecha_venta', [$fechaInicio, $fechaFin])
                            ->selectRaw('DATE(fecha_venta) as fecha, SUM(total_venta) as total')
                            ->groupBy('fecha')
                            ->orderBy('fecha')
                            ->get();

        // Formatear datos para Chart.js
        $fechasGrafico = $ventasPorDia->pluck('fecha')->map(function($fecha) {
            return Carbon::parse($fecha)->format('d/m');
        });
        $montosGrafico = $ventasPorDia->pluck('total');

        // === DATOS PARA GRÁFICO DE PRODUCCIÓN MENSUAL ===
        $inicioAno = Carbon::now()->startOfYear();
        $finAno = Carbon::now()->endOfYear();

        // Producción por mes del año actual, agrupada por tipo de cacao
        $produccionPorMes = Produccion::whereBetween('fecha_inicio', [$inicioAno, $finAno])
                                    ->selectRaw('MONTH(fecha_inicio) as mes, tipo_cacao, SUM(cantidad_cosechada) as total')
                                    ->whereNotNull('cantidad_cosechada')
                                    ->groupBy('mes', 'tipo_cacao')
                                    ->orderBy('mes')
                                    ->get()
                                    ->groupBy('tipo_cacao');

        // Crear arrays para cada tipo de cacao
        $mesesLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $criolloData = array_fill(0, 12, 0);
        $forasteroData = array_fill(0, 12, 0);
        $trinitarioData = array_fill(0, 12, 0);

        // Llenar datos reales
        foreach ($produccionPorMes as $tipo => $meses) {
            foreach ($meses as $mes) {
                $mesIndex = $mes->mes - 1; // Convertir a index (0-11)
                
                if (stripos($tipo, 'criollo') !== false) {
                    $criolloData[$mesIndex] = $mes->total;
                } elseif (stripos($tipo, 'forastero') !== false) {
                    $forasteroData[$mesIndex] = $mes->total;
                } elseif (stripos($tipo, 'trinitario') !== false) {
                    $trinitarioData[$mesIndex] = $mes->total;
                } else {
                    // Si no coincide con ninguno, agregarlo a criollo por defecto
                    $criolloData[$mesIndex] += $mes->total;
                }
            }
        }

        return view('admin.dashboard', compact(
            'trabajadores',
            'inventarios',
            'totalProductos',
            'productosOptimos',
            'productosPorVencer',
            'productosRestringidos',
            'ventasTotales',
            'produccionTotal',
            'clientesActivos',
            'rentabilidad',
            'fechasGrafico',
            'montosGrafico',
            'mesesLabels',
            'criolloData',
            'forasteroData',
            'trinitarioData'
        ));
    }
}