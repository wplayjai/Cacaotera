<?php
// 1. ACTUALIZAR TU DashboardController EXISTENTE
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trabajador;
use App\Models\Inventario; // Agregar esta línea

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

        return view('admin.dashboard', compact(
            'trabajadores',
            'inventarios',
            'totalProductos',
            'productosOptimos',
            'productosPorVencer',
            'productosRestringidos'
        ));
    }
}