
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Trabajador\DashboardController as TrabajadorDashboardController;
use App\Http\Controllers\Trabajador\ModuloController as TrabajadorModuloController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\TrabajadoresController;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\SalidaInventarioController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\RecoleccionController;
use App\Models\Inventario;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ContabilidadController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PerfilController;

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

    // Módulo principal del trabajador
    Route::get('/modulo', [TrabajadorModuloController::class, 'index'])->name('trabajador.modulo');

    // Gestión de lotes
    Route::get('/lotes', [TrabajadorModuloController::class, 'lotes'])->name('trabajador.lotes');
    Route::get('/lotes/{id}', [TrabajadorModuloController::class, 'loteDetalle'])->name('trabajador.lote.detalle');

    Route::get('/api/lotes/{id}/produccion-activa', [LotesController::class, 'produccionActiva']);

    // Gestión de inventario
    Route::get('/inventario', [TrabajadorModuloController::class, 'inventario'])->name('trabajador.inventario');
    Route::post('/retirar-insumo', [TrabajadorModuloController::class, 'retirarInsumo'])->name('trabajador.retirar.insumo');

    // Gestión de producción
    Route::get('/produccion', [TrabajadorModuloController::class, 'produccion'])->name('trabajador.produccion');
    Route::post('/registrar-cosecha', [TrabajadorModuloController::class, 'registrarCosecha'])->name('trabajador.registrar.cosecha');
    Route::post('/actualizar-estado', [TrabajadorModuloController::class, 'actualizarEstadoProduccion'])->name('trabajador.actualizar.estado');

    // Reportes
                    Route::get('/reportes', [TrabajadorModuloController::class, 'reportes'])->name('trabajador.reportes');
                Route::get('/historial', [TrabajadorModuloController::class, 'historialTrabajo'])->name('trabajador.historial');
});

Route::middleware(['auth'])->group(function () {
    // CRUD trabajadores
    Route::prefix('trabajadores')->name('trabajadores.')->group(function () {
        // Rutas específicas ANTES del resource para evitar conflictos
        Route::get('/asistencia', [TrabajadoresController::class, 'asistencia'])->name('asistencia');
        Route::post('/registrar-asistencia', [TrabajadoresController::class, 'registrarAsistencia'])->name('registrar-asistencia');
        Route::get('/listar-asistencias', [TrabajadoresController::class, 'listarAsistencias'])->name('listar-asistencias');

        // Reportes de asistencia
        Route::get('/reportes', [TrabajadoresController::class, 'reportes'])->name('reportes');
        Route::get('/generar-reporte-asistencia', [TrabajadoresController::class, 'generarReporteAsistencia'])->name('generar-reporte-asistencia');
        Route::get('/exportar-reporte-asistencia', [TrabajadoresController::class, 'exportarReporteAsistencia'])->name('exportar-reporte-asistencia');

        // NUEVAS RUTAS PARA VISTAS UNIFICADAS
        Route::get('/asistencia-unificada', [TrabajadoresController::class, 'asistenciaUnificada'])->name('asistencia-unificada');
        Route::get('/reportes-unificados', [TrabajadoresController::class, 'reportesUnificados'])->name('reportes-unificados');

        // Rutas AJAX para vistas unificadas
        Route::post('/filtrar-asistencias', [TrabajadoresController::class, 'filtrarAsistencias'])->name('filtrar-asistencias');
        Route::post('/generar-reporte-asistencia-unificado', [TrabajadoresController::class, 'generarReporteAsistenciaUnificado'])->name('generar-reporte-asistencia-unificado');
        Route::post('/generar-reporte-productividad', [TrabajadoresController::class, 'generarReporteProductividad'])->name('generar-reporte-productividad');
        Route::post('/calcular-nomina', [TrabajadoresController::class, 'calcularNomina'])->name('calcular-nomina');

        Route::post('/{id}/estado', [TrabajadoresController::class, 'toggleEstado'])->name('toggleEstado');

        // Resource routes al final
        Route::resource('/', TrabajadoresController::class)->parameters(['' => 'trabajador']);
    });

    Route::get('/panel-trabajador', [TrabajadoresController::class, 'index'])->name('panel.trabajador');


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
    Route::post('/reportes/data/{tipo}', [App\Http\Controllers\ReporteController::class, 'obtenerData'])->name('reportes.data');
    Route::get('/lotes/lista', [LotesController::class, 'lista'])->name('lotes.lista');        // todos
    Route::get('/lotes/uno/{id}', [LotesController::class, 'obtenerLote'])->name('lotes.uno'); // por id
    Route::get('/lotes/api/all', [LotesController::class, 'apiGetAll'])->name('lotes.api.all'); // API para salida inventario

    // Inventario
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');

    // Salida de Inventario (DEBE IR ANTES de las rutas con {id})
    Route::get('/inventario/salida', [InventarioController::class, 'salida'])->name('inventario.salida');
    Route::post('/inventario/salida', [InventarioController::class, 'storeSalida'])->name('inventario.salida.store');

    // Reportes de Inventario (ANTES de las rutas con {id})
    Route::get('/inventario/reporte', [InventarioController::class, 'reporte'])->name('inventario.reporte');
    Route::get('/inventario/reporte/pdf', [InventarioController::class, 'reportePdf'])->name('inventario.reporte.pdf');

    // Otras rutas de inventario
    Route::get('/inventario/{id}', [InventarioController::class, 'show'])->name('inventario.show');
    Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');
    Route::put('/inventario/{id}', [InventarioController::class, 'update'])->name('inventario.update');
    Route::delete('/inventario/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');

    // Salida de inventario (otras rutas)
    Route::get('/salida-inventario/lista', [SalidaInventarioController::class, 'lista'])->name('salida-inventario.lista');
    Route::get('/salida-inventario', [SalidaInventarioController::class, 'index'])->name('salida-inventario.index');
    Route::post('/salida-inventario', [SalidaInventarioController::class, 'store'])->name('salida.store');

    // API inventario
    Route::get('/api/inventario/data', [InventarioController::class, 'getData'])->name('api.inventario.data');

    // Rutas para el módulo de producción
    Route::resource('produccion', ProduccionController::class);
    Route::get('produccion/{produccion}', [ProduccionController::class, 'show'])->name('produccion.show');

    // Ruta para obtener trabajadores disponibles
    Route::get('produccion/{produccion}/trabajadores-disponibles', [ProduccionController::class, 'trabajadoresDisponibles'])->name('produccion.trabajadores-disponibles');

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

    // Ruta API para obtener datos de recolección para edición
    Route::get('api/recolecciones/{recoleccion}/edit-data', [RecoleccionController::class, 'getEditData'])
        ->name('api.recolecciones.edit_data');
    // API Routes para AJAX
    Route::prefix('api')->group(function () {
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

Route::get('/inventario/lista', function () {
    return response()->json(Inventario::all());
});

Route::get('/', function () {
    return view('welcome');
});

// Ruta para la vista principal del módulo de ventas
Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');

// Rutas específicas de ventas (antes del resource)
Route::get('ventas/reporte', [VentasController::class, 'reporte'])->name('ventas.reporte');
Route::get('ventas/reporte/pdf', [VentasController::class, 'reportePdf'])->name('ventas.reporte.pdf');
Route::post('ventas/{venta}/pagar', [VentasController::class, 'marcarPagado'])->name('ventas.pagar');
Route::get('ventas/obtener-detalle/{recoleccion_id}', [VentasController::class, 'obtenerDetalleRecoleccion'])->name('ventas.obtener-detalle');
Route::get('ventas/{venta}/descargar-pdf', [VentasController::class, 'descargarPDF'])->name('ventas.descargarPDF');

// Rutas para Ventas (resource)
Route::resource('ventas', VentasController::class);

// API y rutas temporales de prueba
Route::get('api/recolecciones/{id}/stock', [VentasController::class, 'obtenerStock'])->name('api.recolecciones.stock');
Route::get('/test-reporte', [VentasController::class, 'reporteSimple']);
Route::get('/test-reporte/pdf', [VentasController::class, 'reportePdf']);
Route::get('/ventas/obtener-stock/{id}', [VentasController::class, 'obtenerStock']);

// Descontar insumo
use Illuminate\Http\Request;

Route::post('/inventario/descontar', function(Request $request) {
    $insumo = \App\Models\Inventario::find($request->insumo_id);
    if (!$insumo) {
        return response()->json(['success' => false, 'message' => 'Insumo no encontrado']);
    }
    if ($insumo->cantidad < $request->cantidad_usar) {
        return response()->json(['success' => false, 'message' => 'No hay suficiente insumo disponible']);
    }
    $insumo->cantidad -= $request->cantidad_usar;
    $insumo->save();
    return response()->json(['success' => true, 'nueva_cantidad' => $insumo->cantidad]);
});

// 📊 SISTEMA DE REPORTES OPTIMIZADO
Route::middleware(['auth'])->prefix('reportes')->name('reportes.')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('index');
    Route::post('/data/{tipo}', [ReporteController::class, 'obtenerData'])->name('data');
    Route::post('/metricas', [ReporteController::class, 'obtenerMetricasAjax'])->name('metricas');
    Route::get('/pdf/{tipo}', [ReporteController::class, 'exportarPdfIndividual'])->name('pdf');

    Route::get('/pdf-general', [ReporteController::class, 'generarReporteGeneral'])->name('pdf.general');

    Route::get('/preview-general', [ReporteController::class, 'previsualizarReporte'])->name('preview.general');

    Route::get('/test-pdf', [ReporteController::class, 'testPdf'])->name('test.pdf');
});



// Mantener las rutas originales por compatibilidad
Route::get('/produccion/lote/{loteId}/activa', [ProduccionController::class, 'obtenerProduccionActivaPorLote'])
    ->name('produccion.obtener-activa-por-lote');

Route::get('/produccion/lote/{loteId}/activas', [ProduccionController::class, 'obtenerProduccionesActivasPorLote'])
    ->name('produccion.obtener-activas-por-lote');

// Contabilidad
Route::get('/contabilidad/salidas', [SalidaInventarioController::class, 'index'])->name('contabilidad.salidas');
Route::post('/contabilidad/lotes', [ContabilidadController::class, 'contabilidadPorLotes'])->name('contabilidad.lotes');
Route::get('/contabilidad/pdf/rentabilidad', [ContabilidadController::class, 'generarPdfRentabilidad'])->name('contabilidad.pdf.rentabilidad');
Route::get('/reporte/pdf/general', [ReporteController::class, 'generarReporteGeneral'])->name('reporte.pdf.general');



Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');
    Route::post('/perfil/cambiar-password', [PerfilController::class, 'cambiarPassword'])->name('perfil.cambiarPassword');


Route::post('/perfil/actualizar-datos', [App\Http\Controllers\PerfilController::class, 'actualizarDatos'])->name('perfil.actualizarDatos');
});
