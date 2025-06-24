<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Trabajador\DashboardController as TrabajadorDashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\TrabajadoresController;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\SalidaInventarioController;

// Página principal
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

/// Inventario
Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');
Route::put('/inventario/{id}', [InventarioController::class, 'update'])->name('inventario.update');
Route::delete('/inventario/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');

// Salida de Inventario
Route::get('/inventario/salida', [InventarioController::class, 'salida'])->name('inventario.salida');
Route::post('/inventario/salida', [InventarioController::class, 'storeSalida'])->name('inventario.salida.store');
Route::get('/salida-inventario/lista', [SalidaInventarioController::class, 'lista']);
Route::get('/salida-inventario/lista', function () {return SalidaInventarioController::with('insumo')->get();
Route::get('/salida-inventario/lista', [SalidaInventarioController::class, 'obtenerSalidas']);

});






// API inventario
Route::get('/api/inventario/data', [InventarioController::class, 'getData'])->name('api.inventario.data');

// Lotes (CRUD y utilidades)
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

    // Lotes
    Route::get('/lote/registro', [LotesController::class, 'create'])->name('register.lote.form');
    Route::post('/register-lote', [LotesController::class, 'store'])->name('register.lote');
    Route::get('/lotes', [LotesController::class, 'index'])->name('lotes.index');
    Route::post('/lotes', [LotesController::class, 'store'])->name('lotes.store');
    Route::resource('lotes', LotesController::class)->except(['show']);
    Route::get('/lotes/pdf', [LotesController::class, 'exportPdf'])->name('lotes.pdf');

    // inventario
    Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');

    // Ruta para obtener lotes en formato JSON (para selects dinámicos en inventario)
    Route::get('/lotes/lista', [LotesController::class, 'lista']);

    // Salida de inventario
    Route::post('/salida-inventario', [SalidaInventarioController::class, 'store'])->name('salida-inventario.store');
    Route::get('/salida-inventario/lista', [SalidaInventarioController::class, 'lista'])->name('salida-inventario.lista');
});


