<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Trabajador\DashboardController as TrabajadorDashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\TrabajadoresController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas de administrador
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Rutas de trabajador
Route::prefix('trabajador')->middleware(['auth', 'role:trabajador'])->group(function () {
    Route::get('/dashboard', [TrabajadorDashboardController::class, 'index'])->name('trabajador.dashboard');
});

Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');
Route::put('/inventario/{id}', [InventarioController::class, 'update'])->name('inventario.update');
Route::delete('/inventario/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');


// Solo una ruta para la API
Route::get('/api/inventario/data', [InventarioController::class, 'getData'])->name('api.inventario.data');

// routes/web.php

    
    Route::get('/', function () {
        return view('welcome');
    });
    
    Auth::routes();
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::middleware(['auth'])->group(function () {
        // CRUD de trabajadores
        Route::resource('trabajadores', TrabajadoresController::class);
        
        // Control de asistencia
        Route::get('/asistencia', [TrabajadoresController::class, 'asistencia'])->name('trabajadores.asistencia');
        Route::post('/registrar-asistencia', [TrabajadoresController::class, 'registrarAsistencia'])->name('trabajadores.registrar-asistencia');
        Route::get('/listar-asistencias', [TrabajadoresController::class, 'listarAsistencias'])->name('trabajadores.listar-asistencias');
        
        // Reportes
        Route::get('/reportes', [TrabajadoresController::class, 'reportes'])->name('trabajadores.reportes');
        Route::get('/generar-reporte-asistencia', [TrabajadoresController::class, 'generarReporteAsistencia'])->name('trabajadores.generar-reporte-asistencia');
        Route::post('/exportar-reporte-asistencia', [TrabajadoresController::class, 'exportarReporteAsistencia'])->name('trabajadores.exportar-reporte-asistencia');
        Route::get('/panel-trabajador', [TrabajadoresController::class, 'index'])->name('panel.trabajador');
    });
    
