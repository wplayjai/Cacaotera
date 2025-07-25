
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Trabajador\DashboardController as TrabajadorDashboardController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\TrabajadoresController;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\SalidaInventarioController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\RecoleccionController;
use App\Models\Inventario;
use App\Http\Controllers\VentasController;

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

// Inventario
Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');

// Salida de Inventario (DEBE IR ANTES DE LA RUTA CON {id})
Route::get('/inventario/salida', [InventarioController::class, 'salida'])->name('inventario.salida');
Route::post('/inventario/salida', [InventarioController::class, 'storeSalida'])->name('inventario.salida.store');

// Otras rutas de inventario
Route::get('/inventario/{id}', [InventarioController::class, 'show'])->name('inventario.show');
Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');
Route::put('/inventario/{id}', [InventarioController::class, 'update'])->name('inventario.update');
Route::delete('/inventario/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');

Route::get('/salida-inventario/lista', [SalidaInventarioController::class, 'lista'])->name('salida-inventario.lista');
Route::get('/salida-inventario', [SalidaInventarioController::class, 'index'])->name('salida-inventario.index');
Route::post('/salida-inventario', [SalidaInventarioController::class, 'store'])->name('salida-inventario.store');

// API inventario
Route::get('/api/inventario/data', [InventarioController::class, 'getData'])->name('api.inventario.data');

Route::middleware(['auth'])->group(function () {
    // CRUD trabajadores
    Route::resource('trabajadores', TrabajadoresController::class);

    // Asistencia
    Route::get('/asistencia', [TrabajadoresController::class, 'asistencia'])->name('trabajadores.asistencia');
    Route::post('/registrar-asistencia', [TrabajadoresController::class, 'registrarAsistencia'])->name('trabajadores.registrar-asistencia');
    Route::get('/listar-asistencias', [TrabajadoresController::class, 'listarAsistencias'])->name('trabajadores.listar-asistencias');

    // Reportes de asistencia
    Route::get('/reportes', [TrabajadoresController::class, 'reportes'])->name('trabajadores.reportes');
    Route::get('/generar-reporte-asistencia', [TrabajadoresController::class, 'generarReporteAsistencia'])->name('trabajadores.generar-reporte-asistencia');
    Route::post('/exportar-reporte-asistencia', [TrabajadoresController::class, 'exportarReporteAsistencia'])->name('trabajadores.exportar-reporte-asistencia');
    Route::get('/panel-trabajador', [TrabajadoresController::class, 'index'])->name('panel.trabajador');

    Route::post('/trabajadores/{id}/estado', [TrabajadoresController::class, 'toggleEstado'])->name('trabajadores.toggleEstado');


    // Lotes
    Route::get('/lote/registro', [LotesController::class, 'create'])->name('register.lote.form');
    Route::post('/register-lote', [LotesController::class, 'store'])->name('register.lote');
    Route::get('/lotes', [LotesController::class, 'index'])->name('lotes.index');
    Route::post('/lotes', [LotesController::class, 'store'])->name('lotes.store');
    Route::resource('lotes', LotesController::class)->except(['show']);
    Route::get('/lotes/pdf', [LotesController::class, 'exportPdf'])->name('lotes.pdf');
    Route::get('/lotes/pdf/{id}', [LotesController::class, 'exportPdfLote'])->name('lotes.pdf.individual');

    // ✅ Ruta para vista reporte
    Route::get('/reporte', function () {
        return view('lotes.reporte');
    })->name('lotes.reporte');

    // ✅ Rutas AJAX para el reporte
    Route::get('/lotes/lista', [LotesController::class, 'lista'])->name('lotes.lista');        // todos
    Route::get('/lotes/uno/{id}', [LotesController::class, 'obtenerLote'])->name('lotes.uno'); // por id
    Route::get('/lotes/api/all', [LotesController::class, 'apiGetAll'])->name('lotes.api.all'); // API para salida inventario

    // Salida de inventario
    Route::post('/salida-inventario', [SalidaInventarioController::class, 'store'])->name('salida-inventario.store');
    Route::get('/salida-inventario/lista', [SalidaInventarioController::class, 'lista'])->name('salida-inventario.lista');
});



Route::middleware(['auth'])->group(function () {
    // Rutas para el módulo de producción
    Route::resource('produccion', ProduccionController::class);
Route::get('produccion/{produccion}', [ProduccionController::class, 'show'])->name('produccion.show');
    // Acciones para iniciar y completar producción
    Route::post('produccion/{produccion}/iniciar', [ProduccionController::class, 'iniciarProduccion'])->name('produccion.iniciar');
    Route::post('produccion/{produccion}/completar', [ProduccionController::class, 'completarProduccion'])->name('produccion.completar');

    // Rutas para actualizar estado y registrar rendimiento real
    Route::post('produccion/{produccion}/estado', [ProduccionController::class, 'cambiarEstado'])->name('produccion.estado');
    Route::post('produccion/{produccion}/rendimiento', [ProduccionController::class, 'registrarCosecha'])->name('produccion.rendimiento');

    // Rutas adicionales específicas
    Route::put('produccion/{produccion}/estado', [ProduccionController::class, 'actualizarEstado'])
        ->name('produccion.actualizar_estado');
    Route::post('produccion/{produccion}/registrar-rendimiento', [ProduccionController::class, 'registrarRendimiento'])
        ->name('produccion.registrar_rendimiento');
    Route::get('produccion/cosecha/proximos', [ProduccionController::class, 'proximosCosecha'])
        ->name('produccion.proximos_cosecha');

    // Rutas adicionales para reportes y estadísticas
    Route::get('produccion/reportes/general', [ProduccionController::class, 'reporteGeneral'])
        ->name('produccion.reporte_general');
    Route::get('produccion/reportes/rendimiento', [ProduccionController::class, 'reporteRendimiento'])
        ->name('produccion.reporte_rendimiento');
    Route::get('produccion/{produccion}/historial', [ProduccionController::class, 'historial'])
        ->name('produccion.historial');
    Route::post('produccion/{produccion}/notas', [ProduccionController::class, 'agregarNota'])
        ->name('produccion.agregar_nota');

    // Rutas para el módulo de recolecciones
Route::resource('recolecciones', RecoleccionController::class, ['parameters' => ['recolecciones' => 'recoleccion']]);

// Rutas específicas para recolecciones
Route::get('recolecciones/create/{produccionId?}', [RecoleccionController::class, 'create'])
    ->name('recolecciones.create_for_produccion');

Route::get('recolecciones/produccion/{produccion}/estadisticas', [RecoleccionController::class, 'estadisticas'])
    ->name('recolecciones.estadisticas');

Route::get('recolecciones/produccion/{produccion}/lista', [RecoleccionController::class, 'porProduccion'])
    ->name('recolecciones.por_produccion');

});

// API Routes para AJAX (opcional)
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('produccion/dashboard', [ProduccionController::class, 'dashboardData'])
        ->name('api.produccion.dashboard');
    
    Route::get('produccion/estadisticas', [ProduccionController::class, 'estadisticas'])
        ->name('api.produccion.estadisticas');
    
    Route::get('produccion/calendario', [ProduccionController::class, 'calendarioActividades'])
        ->name('api.produccion.calendario');
    
    Route::post('produccion/validar', [ProduccionController::class, 'validarDatos'])
        ->name('api.produccion.validar');
    
    Route::get('produccion/buscar', [ProduccionController::class, 'buscar'])
        ->name('api.produccion.buscar');
    
    Route::get('produccion/exportar/{formato}', [ProduccionController::class, 'exportar'])
        ->name('api.produccion.exportar')
        ->where('formato', 'excel|pdf|csv');
    
    Route::post('produccion/importar', [ProduccionController::class, 'importar'])
        ->name('api.produccion.importar');
    
    Route::get('produccion/{produccion}/timeline', [ProduccionController::class, 'timeline'])
        ->name('api.produccion.timeline');
});

// Rutas para notificaciones y alertas
Route::middleware(['auth'])->prefix('produccion')->group(function () {
    Route::get('notificaciones', [ProduccionController::class, 'notificaciones'])
        ->name('produccion.notificaciones');
    
    Route::post('notificaciones/{id}/marcar-leida', [ProduccionController::class, 'marcarNotificacionLeida'])
        ->name('produccion.marcar_notificacion_leida');
    
    Route::get('alertas/vencimientos', [ProduccionController::class, 'alertasVencimientos'])
        ->name('produccion.alertas_vencimientos');
});

Route::get('/inventario/reporte', function () {
    return view('inventario.reporte');
})->name('inventario.reporte');

Route::get('/inventario/lista', function () {
    return response()->json(Inventario::all());
});

Route::get('/', function () {
    return view('welcome');
});

// Ruta para la vista principal del módulo de ventas
Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
// Rutas para Ventas
Route::resource('ventas', VentasController::class);

// Rutas adicionales para ventas
Route::post('ventas/{venta}/pagar', [VentasController::class, 'marcarPagado'])->name('ventas.pagar');
Route::get('ventas/reporte', [VentasController::class, 'reporte'])->name('ventas.reporte');
Route::get('api/recolecciones/{id}/stock', [VentasController::class, 'obtenerStock'])->name('api.recolecciones.stock');
Route::post('/ventas/{venta}/pagar', [VentasController::class, 'marcarPagado'])->name('ventas.pagar');
Route::get('/ventas/{venta}/descargar-pdf', [VentasController::class, 'descargarPDF'])->name('ventas.descargarPDF');


