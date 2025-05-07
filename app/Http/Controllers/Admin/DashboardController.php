<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trabajador; 

class DashboardController extends Controller
{
    public function index()
    {
        $trabajadores = Trabajador::with('user')
        ->latest() // ordena por la columna 'created_at' descendente
        ->take(5)   // limita a los últimos 5
        ->get();

    return view('admin.dashboard', compact('trabajadores'));
    }
}