@extends('layouts.masterr')

@push('styles')
<style>
/* BOOTSTRAP 5 PROFESIONAL - TEMA CAFÉ ELEGANTE */
:root {
    --cafe-principal: #6F4E37;
    --cafe-secundario: #8B4513;
    --cafe-claro: #A0522D;
    --cafe-muy-claro: #CD853F;
    --cafe-fondo: #f5f3f0;
    --cafe-texto: #2C1810;
    --blanco-cafe: #faf9f7;
}

/* Estilos globales más compactos */
body {
    font-size: 0.9rem;
    line-height: 1.4;
}

/* CSS SÚPER ESPECÍFICO PARA FORZAR TEXTO BLANCO EN SIDEBAR */
body .sidebar .sidebar-nav .nav-link,
body .sidebar .sidebar-nav .nav-link span,
body .sidebar .sidebar-nav .nav-link i,
body .sidebar .sidebar-brand h4,
html body .sidebar .sidebar-nav .nav-link,
html body .sidebar .sidebar-nav .nav-link span,
html body .sidebar .sidebar-nav .nav-link i,
html body .sidebar .sidebar-brand h4 {
    color: #ffffff !important;
    opacity: 1 !important;
    text-shadow: none !important;
}

/* Forzar color blanco en hover del sidebar */
body .sidebar .sidebar-nav .nav-link:hover,
body .sidebar .sidebar-nav .nav-link:focus,
body .sidebar .sidebar-nav .nav-link:hover span,
body .sidebar .sidebar-nav .nav-link:hover i,
html body .sidebar .sidebar-nav .nav-link:hover,
html body .sidebar .sidebar-nav .nav-link:focus,
html body .sidebar .sidebar-nav .nav-link:hover span,
html body .sidebar .sidebar-nav .nav-link:hover i {
    color: #ffffff !important;
    opacity: 1 !important;
    text-shadow: none !important;
}

/* Forzar color blanco en estado activo del sidebar */
body .sidebar .sidebar-nav .nav-link.active,
body .sidebar .sidebar-nav .nav-link.active span,
body .sidebar .sidebar-nav .nav-link.active i,
html body .sidebar .sidebar-nav .nav-link.active,
html body .sidebar .sidebar-nav .nav-link.active span,
html body .sidebar .sidebar-nav .nav-link.active i {
    color: #ffffff !important;
    opacity: 1 !important;
    text-shadow: none !important;
}

/* Eliminar cualquier color heredado específico */
.sidebar * {
    color: inherit;
}

.sidebar .sidebar-nav .nav-link * {
    color: #ffffff !important;
}

/* Estilos elegantes para las pestañas de reporte - FORZAR CAFÉ */
#reporteTabs .nav-link {
    transition: all 0.3s ease !important;
    background-color: var(--cafe-principal) !important;
    color: #ffffff !important;
    border: 1px solid var(--cafe-secundario) !important;
    font-weight: 600 !important;
    font-size: 0.85rem !important;
}

#reporteTabs .nav-link:hover {
    background-color: var(--cafe-secundario) !important;
    color: #ffffff !important;
    border: 1px solid var(--cafe-claro) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(111, 78, 55, 0.3) !important;
}

#reporteTabs .nav-link.active {
    background-color: var(--cafe-claro) !important;
    color: #ffffff !important;
    border: 1px solid var(--cafe-muy-claro) !important;
    box-shadow: 0 6px 20px rgba(111, 78, 55, 0.4) !important;
    transform: translateY(-1px) !important;
}

/* FORZAR SELECTORES MÁS ESPECÍFICOS PARA PESTAÑAS CAFÉ */
html body #reporteTabs .nav-pills .nav-link {
    background-color: var(--cafe-principal) !important;
    color: #ffffff !important;
    border: 1px solid var(--cafe-secundario) !important;
    transition: all 0.3s ease !important;
}

html body #reporteTabs .nav-pills .nav-link:hover {
    background-color: var(--cafe-secundario) !important;
    color: #ffffff !important;
    border: 1px solid var(--cafe-claro) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(111, 78, 55, 0.3) !important;
}

html body #reporteTabs .nav-pills .nav-link.active {
    background-color: var(--cafe-claro) !important;
    color: #ffffff !important;
    border: 1px solid var(--cafe-muy-claro) !important;
    box-shadow: 0 6px 20px rgba(111, 78, 55, 0.4) !important;
    transform: translateY(-1px) !important;
}

/* ELIMINAR ESTILOS DE BOOTSTRAP COMPLETAMENTE */
.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
    background-color: var(--cafe-claro) !important;
    color: #ffffff !important;
}

.nav-pills .nav-link {
    background-color: var(--cafe-principal) !important;
    color: #ffffff !important;
}

/* Forzar texto blanco en todos los elementos de las pestañas */
#reporteTabs .nav-link,
#reporteTabs .nav-link i,
#reporteTabs .nav-link span {
    color: inherit !important;
}

/* Tarjetas de métricas más elegantes */
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(111, 78, 55, 0.15) !important;
}

/* Estilos para tablas más compactas */
.table th {
    font-size: 0.8rem;
    padding: 0.6rem 0.8rem;
    background-color: var(--cafe-principal) !important;
    color: white !important;
    border: none !important;
}

.table td {
    font-size: 0.85rem;
    padding: 0.6rem 0.8rem;
    border-color: rgba(111, 78, 55, 0.1) !important;
}

/* Botones más elegantes */
.btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Formularios más elegantes */
.form-control, .form-select {
    border-radius: 6px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--cafe-principal);
    box-shadow: 0 0 0 0.2rem rgba(111, 78, 55, 0.25);
}

/* Asegurar que el contenido principal no se vea afectado */
.main-content * {
    color: inherit;
}

/* OVERRIDE COMPLETO DEL CSS DE MASTERR.CSS PARA FORZAR BLANCO */
.sidebar .sidebar-nav .nav-link {
    color: #ffffff !important;
}

.sidebar .sidebar-brand h4 {
    color: #ffffff !important;
}

/* Sobrescribir variables CSS si existen */
.sidebar {
    --sidebar-text: #ffffff !important;
}

/* Forzar con selectores más específicos aún */
html body div.sidebar ul.sidebar-nav li.nav-item a.nav-link,
html body div.sidebar ul.sidebar-nav li.nav-item a.nav-link i,
html body div.sidebar div.sidebar-brand h4 {
    color: #ffffff !important;
    opacity: 1 !important;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-3" style="background: #f5f3f0; min-height: 100vh;">
    <!-- Header Principal Profesional -->
    <div class="card shadow-sm border-0 mb-3" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 50%, #A0522D 100%); border-radius: 10px;">
        <div class="card-body p-3 text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-2" style="font-size: 1.5rem;">
                        <i class="fas fa-chart-line me-2 text-warning"></i>Sistema de Reportes Empresariales
                    </h4>
                    <p class="mb-0 opacity-75" style="font-size: 0.9rem;">Análisis integral y control de calidad para producción de cacao</p>
                </div>
                <div>
                    <button class="btn btn-warning btn-sm fw-bold px-3 py-2 shadow-sm" onclick="generarReporteGeneral()" style="border-radius: 8px;">
                        <i class="fas fa-file-pdf me-1"></i>Exportar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard de Métricas -->
    <div class="row g-2 mb-3" id="metricas-dashboard">
        <div class="col-lg col-md-6 col-sm-6">
            <div class="card h-100 border-0 text-center shadow-sm" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); border-radius: 10px;">
                <div class="card-body py-2 text-white">
                    <h5 class="fw-bold mb-1" id="total-lotes" style="font-size: 1.4rem;">{{ $metricas['total_lotes'] ?? 0 }}</h5>
                    <small class="text-uppercase fw-semibold opacity-75" style="font-size: 0.7rem;">Lotes Activos</small>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <div class="card h-100 border-0 text-center shadow-sm" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); border-radius: 10px;">
                <div class="card-body py-2 text-white">
                    <h5 class="fw-bold mb-1" id="total-produccion" style="font-size: 1.4rem;">{{ number_format($metricas['total_produccion'] ?? 0) }}kg</h5>
                    <small class="text-uppercase fw-semibold opacity-75" style="font-size: 0.7rem;">Producción</small>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <div class="card h-100 border-0 text-center shadow-sm" style="background: linear-gradient(135deg, #A0522D 0%, #CD853F 100%); border-radius: 10px;">
                <div class="card-body py-2 text-white">
                    <h5 class="fw-bold mb-1" id="total-ventas" style="font-size: 1.4rem;">${{ number_format($metricas['total_ventas'] ?? 0) }}</h5>
                    <small class="text-uppercase fw-semibold opacity-75" style="font-size: 0.7rem;">Ingresos</small>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <div class="card h-100 border-0 text-center shadow-sm" style="background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%); border-radius: 10px;">
                <div class="card-body py-2 text-white">
                    <h5 class="fw-bold mb-1" id="rentabilidad" style="font-size: 1.4rem; color: #2C1810 !important;">{{ number_format($metricas['rentabilidad'] ?? 0, 1) }}%</h5>
                    <small class="text-uppercase fw-semibold opacity-75" style="font-size: 0.7rem; color: #2C1810 !important;">Rentabilidad</small>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 col-sm-6">
            <div class="card h-100 border-0 text-center shadow-sm" style="background: linear-gradient(135deg, #8B4513 0%, #6F4E37 100%); border-radius: 10px;">
                <div class="card-body py-2 text-white">
                    <h5 class="fw-bold mb-1" id="total-trabajadores" style="font-size: 1.4rem;">{{ $metricas['total_trabajadores'] ?? 0 }}</h5>
                    <small class="text-uppercase fw-semibold opacity-75" style="font-size: 0.7rem;">Trabajadores</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas de Reportes -->
    <div class="card border-0 mb-3 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <ul class="nav nav-pills nav-fill p-2 mb-0" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 50%, #A0522D 100%); border-radius: 10px;" id="reporteTabs">
                <li class="nav-item mx-1">
                    <button class="nav-link active fw-bold px-2 py-2 rounded-3" onclick="cambiarReporte('lote')" style="font-size: 0.85rem; background-color: #A0522D !important; color: #ffffff !important; border: 1px solid #CD853F !important;">
                        <i class="fas fa-map-marked-alt me-1"></i>
                        <div class="d-flex flex-column">
                            <span>Gestión de Lotes</span>
                            <small style="font-size: 0.65rem; opacity: 0.8;">Terrenos y Cultivos</small>
                        </div>
                    </button>
                </li>
                <li class="nav-item mx-1">
                    <button class="nav-link fw-bold px-2 py-2 rounded-3" onclick="cambiarReporte('inventario')" style="font-size: 0.85rem; background-color: #6F4E37 !important; color: #ffffff !important; border: 1px solid #8B4513 !important;">
                        <i class="fas fa-boxes me-1"></i>
                        <div class="d-flex flex-column">
                            <span>Control de Inventario</span>
                            <small style="font-size: 0.65rem; opacity: 0.8;">Insumos y Materiales</small>
                        </div>
                    </button>
                </li>
                <li class="nav-item mx-1">
                    <button class="nav-link fw-bold px-2 py-2 rounded-3" onclick="cambiarReporte('ventas')" style="font-size: 0.85rem; background-color: #6F4E37 !important; color: #ffffff !important; border: 1px solid #8B4513 !important;">
                        <i class="fas fa-shopping-cart me-1"></i>
                        <div class="d-flex flex-column">
                            <span>Análisis de Ventas</span>
                            <small style="font-size: 0.65rem; opacity: 0.8;">Ingresos y Clientes</small>
                        </div>
                    </button>
                </li>
                <li class="nav-item mx-1">
                    <button class="nav-link fw-bold px-2 py-2 rounded-3" onclick="cambiarReporte('produccion')" style="font-size: 0.85rem; background-color: #6F4E37 !important; color: #ffffff !important; border: 1px solid #8B4513 !important;">
                        <i class="fas fa-seedling me-1"></i>
                        <div class="d-flex flex-column">
                            <span>Control de Producción</span>
                            <small style="font-size: 0.65rem; opacity: 0.8;">Cultivos y Rendimiento</small>
                        </div>
                    </button>
                </li>
                <li class="nav-item mx-1">
                    <button class="nav-link fw-bold px-2 py-2 rounded-3" onclick="cambiarReporte('trabajadores')" style="font-size: 0.85rem; background-color: #6F4E37 !important; color: #ffffff !important; border: 1px solid #8B4513 !important;">
                        <i class="fas fa-users me-1"></i>
                        <div class="d-flex flex-column">
                            <span>Recursos Humanos</span>
                            <small style="font-size: 0.65rem; opacity: 0.8;">Personal y Nómina</small>
                        </div>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Indicador de Módulo Activo -->
    <div class="card border-0 mb-3 shadow-sm" style="border-radius: 10px;" id="module-indicator">
        <div class="card-body p-3" style="background: linear-gradient(135deg, #A0522D 0%, #CD853F 100%); border-radius: 10px;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i id="module-icon" class="fas fa-map-marked-alt text-white" style="font-size: 2rem;"></i>
                    </div>
                    <div class="text-white">
                        <h5 class="mb-1 fw-bold" id="module-title">Gestión de Lotes</h5>
                        <p class="mb-0 opacity-75" id="module-description">Administración de terrenos y cultivos de cacao</p>
                        <small class="opacity-60" id="module-details">Control de áreas, capacidades, tipos de cacao y estado de los lotes</small>
                    </div>
                </div>
                <div class="text-center text-white">
                    <div class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-eye me-1"></i>
                        <span id="module-count">0</span> registros
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Dinámico -->
    <div id="contenido-reporte">
        <div class="d-none text-center py-5" id="loading">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted fw-semibold">Generando reporte...</p>
        </div>
        
        <!-- Contenido se carga dinámicamente aquí -->
        <div id="reporte-data"></div>
    </div>
</div>

<!-- Modal de Alertas -->
<div class="modal fade" id="alertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-info-circle me-2"></i>Información del Sistema
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="alertContent">
                <!-- Contenido del modal -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let reporteActual = 'lote';

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    cargarReporte('lote');
});

function establecerFechasPorDefecto() {
    const hoy = new Date();
    // Establecer por defecto el último año para capturar toda la actividad
    const unAñoAtras = new Date(hoy.getFullYear() - 1, hoy.getMonth(), hoy.getDate());
    
    // Establecer fecha actual como "hasta"
    document.getElementById('fechaHasta').value = hoy.toISOString().split('T')[0];
    // Establecer un año atrás como "desde" para capturar toda la actividad
    document.getElementById('fechaDesde').value = unAñoAtras.toISOString().split('T')[0];
    
    // Establecer período por defecto como "año" para mostrar toda la actividad
    document.getElementById('periodo').value = 'año';
    
    // Actualizar filtros activos
    filtrosActivos = { 
        periodo: 'año', 
        fechaDesde: document.getElementById('fechaDesde').value, 
        fechaHasta: document.getElementById('fechaHasta').value 
    };
}

function validarRangoFechas() {
    const fechaDesde = new Date(document.getElementById('fechaDesde').value);
    const fechaHasta = new Date(document.getElementById('fechaHasta').value);
    const hoy = new Date();
    const unAñoAtras = new Date(hoy.getFullYear() - 1, hoy.getMonth(), hoy.getDate());
    
    // Ajustar si excede el límite de 1 año
    if (fechaDesde < unAñoAtras) {
        document.getElementById('fechaDesde').value = unAñoAtras.toISOString().split('T')[0];
        mostrarAlerta('⚠️ Período máximo: 1 año. Fecha ajustada automáticamente.');
    }
    
    // Ajustar si la fecha "hasta" es futura
    if (fechaHasta > hoy) {
        document.getElementById('fechaHasta').value = hoy.toISOString().split('T')[0];
        mostrarAlerta('⚠️ No se permiten fechas futuras. Fecha ajustada a hoy.');
    }
}

function cambiarReporte(tipo) {
    // Actualizar pestañas removiendo la clase active
    document.querySelectorAll('#reporteTabs .nav-link').forEach(link => {
        link.classList.remove('active');
        // Aplicar estilo inactivo café
        link.style.backgroundColor = '#6F4E37';
        link.style.color = '#ffffff';
        link.style.border = '1px solid #8B4513';
    });
    // Agregar clase active al botón clickeado y aplicar estilo activo café
    event.target.closest('.nav-link').classList.add('active');
    event.target.closest('.nav-link').style.backgroundColor = '#A0522D';
    event.target.closest('.nav-link').style.color = '#ffffff';
    event.target.closest('.nav-link').style.border = '1px solid #CD853F';
    
    // Actualizar indicador de módulo
    actualizarIndicadorModulo(tipo);
    
    reporteActual = tipo;
    cargarReporte(tipo);
}

function actualizarIndicadorModulo(tipo) {
    const moduleInfo = {
        'lote': {
            icon: 'fas fa-map-marked-alt',
            title: 'Gestión de Lotes',
            description: 'Administración de terrenos y cultivos de cacao',
            details: 'Control de áreas, capacidades, tipos de cacao y estado de los lotes',
            gradient: 'linear-gradient(135deg, #A0522D 0%, #CD853F 100%)'
        },
        'inventario': {
            icon: 'fas fa-boxes',
            title: 'Control de Inventario',
            description: 'Gestión de insumos y materiales agrícolas',
            details: 'Seguimiento de fertilizantes, pesticidas, herramientas y semillas',
            gradient: 'linear-gradient(135deg, #8B4513 0%, #A0522D 100%)'
        },
        'ventas': {
            icon: 'fas fa-shopping-cart',
            title: 'Análisis de Ventas',
            description: 'Control de ingresos y relaciones comerciales',
            details: 'Monitoreo de ventas, clientes, precios y métodos de pago',
            gradient: 'linear-gradient(135deg, #6F4E37 0%, #8B4513 100%)'
        },
        'produccion': {
            icon: 'fas fa-seedling',
            title: 'Control de Producción',
            description: 'Supervisión de cultivos y rendimiento',
            details: 'Seguimiento de ciclos productivos, rendimiento y progreso de cultivos',
            gradient: 'linear-gradient(135deg, #5D4037 0%, #6F4E37 100%)'
        },
        'trabajadores': {
            icon: 'fas fa-users',
            title: 'Recursos Humanos',
            description: 'Administración de personal y nómina',
            details: 'Control de trabajadores, contratos, asistencia y métodos de pago',
            gradient: 'linear-gradient(135deg, #4E342E 0%, #5D4037 100%)'
        }
    };
    
    const info = moduleInfo[tipo];
    if (info) {
        document.getElementById('module-icon').className = info.icon + ' text-white';
        document.getElementById('module-title').textContent = info.title;
        document.getElementById('module-description').textContent = info.description;
        document.getElementById('module-details').textContent = info.details;
        document.querySelector('#module-indicator .card-body').style.background = info.gradient;
    }
}

function aplicarFiltros() {
    const periodo = document.getElementById('periodo').value;
    const fechaDesde = document.getElementById('fechaDesde').value;
    const fechaHasta = document.getElementById('fechaHasta').value;
    
    const hoy = new Date();
    const fechaHastaDate = new Date(fechaHasta);
    const fechaDesdeDate = new Date(fechaDesde);
    
    // Validar que no sea más de 1 año
    const unAñoAtras = new Date(hoy.getFullYear() - 1, hoy.getMonth(), hoy.getDate());
    
    if (fechaDesdeDate < unAñoAtras) {
        mostrarAlerta('⚠️ El período máximo permitido es de 1 año. La fecha "Desde" se ha ajustado automáticamente.');
        document.getElementById('fechaDesde').value = unAñoAtras.toISOString().split('T')[0];
        return;
    }
    
    if (fechaHastaDate > hoy) {
        mostrarAlerta('⚠️ La fecha "Hasta" no puede ser futura. Se ha ajustado a la fecha actual.');
        document.getElementById('fechaHasta').value = hoy.toISOString().split('T')[0];
        return;
    }
    
    if (periodo === 'personalizado' && (!fechaDesde || !fechaHasta)) {
        mostrarAlerta('Por favor selecciona ambas fechas para el período personalizado.');
        return;
    }
    
    if (fechaDesdeDate >= fechaHastaDate) {
        mostrarAlerta('La fecha "Desde" debe ser anterior a la fecha "Hasta".');
        return;
    }
    
    // Actualizar fechas según el período seleccionado
    actualizarFechasPorPeriodo(periodo);
    
    filtrosActivos = { 
        periodo, 
        fechaDesde: document.getElementById('fechaDesde').value, 
        fechaHasta: document.getElementById('fechaHasta').value 
    };
    cargarReporte(reporteActual);
    actualizarMetricas();
}

function actualizarFechasPorPeriodo(periodo) {
    const hoy = new Date();
    let fechaDesde, fechaHasta;
    
    switch(periodo) {
        case 'mes':
            // HACE 1 MES: Solo el mes anterior completo
            // Si estamos en agosto 2025, mostrar solo julio 2025
            const mesAnterior = new Date(hoy.getFullYear(), hoy.getMonth() - 1, 1);
            const ultimoDiaMesAnterior = new Date(hoy.getFullYear(), hoy.getMonth(), 0);
            fechaDesde = mesAnterior.toISOString().split('T')[0];
            fechaHasta = ultimoDiaMesAnterior.toISOString().split('T')[0];
            break;
        case 'trimestre':
            // HACE 3 MESES: Los últimos 3 meses completos
            // Si estamos en agosto 2025, mostrar mayo, junio, julio 2025
            const tresMesesAtras = new Date(hoy.getFullYear(), hoy.getMonth() - 3, 1);
            const finTrimestre = new Date(hoy.getFullYear(), hoy.getMonth(), 0); // Último día del mes anterior
            fechaDesde = tresMesesAtras.toISOString().split('T')[0];
            fechaHasta = finTrimestre.toISOString().split('T')[0];
            break;
        case '6meses':
            // HACE 6 MESES: Los últimos 6 meses completos
            const seisMesesAtras = new Date(hoy.getFullYear(), hoy.getMonth() - 6, 1);
            const finSeisMeses = new Date(hoy.getFullYear(), hoy.getMonth(), 0); // Último día del mes anterior
            fechaDesde = seisMesesAtras.toISOString().split('T')[0];
            fechaHasta = finSeisMeses.toISOString().split('T')[0];
            break;
        case 'año':
            // Todo el período disponible (1 año hacia atrás)
            fechaDesde = new Date(hoy.getFullYear() - 1, 0, 1).toISOString().split('T')[0];
            fechaHasta = hoy.toISOString().split('T')[0];
            break;
        case 'personalizado':
            return; // No actualizar fechas en modo personalizado
    }
    
    document.getElementById('fechaDesde').value = fechaDesde;
    document.getElementById('fechaHasta').value = fechaHasta;
}

async function cargarReporte(tipo) {
    mostrarCarga(true);
    
    try {
        // Intentar cargar datos reales desde el servidor
        const response = await fetch(`/reportes/data/${tipo}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({}) // Sin filtros por ahora
        });
        
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            renderizarReporte(tipo, data.data);
        } else {
            console.warn('Error en respuesta del servidor:', data.message);
            mostrarAlerta('Error al cargar datos del servidor: ' + data.message + '. Mostrando datos de ejemplo...');
            cargarDatosEjemplo(tipo);
        }
    } catch (error) {
        console.error('Error al cargar reporte:', error);
        mostrarAlerta('Error de conexión. Mostrando datos de ejemplo...');
        cargarDatosEjemplo(tipo);
    } finally {
        mostrarCarga(false);
    }
}

function cargarDatosEjemplo(tipo) {
    const datosEjemplo = {
        lote: {
            items: [
                { nombre: 'Norte a', fecha_inicio: '2025-07-15', area: 50000.00, capacidad: '2500 plantas', tipo_cacao: 'Trinitario', estado: 'Activo', observaciones: 'Lote principal en excelente estado - Actividad Julio' },
                { nombre: 'Sur', fecha_inicio: '2025-07-20', area: 30000.00, capacidad: '1500 plantas', tipo_cacao: 'Forastero', estado: 'Activo', observaciones: 'Requiere mantenimiento de drenaje - Creado en Julio' },
                { nombre: 'Este', fecha_inicio: '2025-07-10', area: 40000.00, capacidad: '2000 plantas', tipo_cacao: 'Criollo', estado: 'Activo', observaciones: 'Producción orgánica certificada - Julio 2025' },
                { nombre: 'Oeste', fecha_inicio: '2025-07-08', area: 35000.00, capacidad: '1800 plantas', tipo_cacao: 'Trinitario', estado: 'En desarrollo', observaciones: 'Nuevas plantaciones - Iniciado en Julio' },
                { nombre: 'Central', fecha_inicio: '2025-07-25', area: 45000.00, capacidad: '2200 plantas', tipo_cacao: 'Nacional Fino', estado: 'Activo', observaciones: 'Lote experimental - Última actividad Julio 2025' },
                { nombre: 'Norte B', fecha_inicio: '2025-05-15', area: 25000.00, capacidad: '1200 plantas', tipo_cacao: 'Trinitario', estado: 'Activo', observaciones: 'Lote secundario - Mayo 2025' },
                { nombre: 'Sur B', fecha_inicio: '2025-06-10', area: 20000.00, capacidad: '1000 plantas', tipo_cacao: 'Forastero', estado: 'Activo', observaciones: 'Expansión - Junio 2025' }
            ]
        },
        inventario: {
            items: [
                { id: 1, producto: 'Superfosfato triple', fecha: '2025-07-21', cantidad: 5, unidad: 'kg', precio_unitario: 5220.00, valor_total: 26100, tipo: 'Fertilizantes', estado: 'Óptimo' },
                { id: 2, producto: 'Clorpirifos', fecha: '2025-07-29', cantidad: 16, unidad: 'ml', precio_unitario: 350000.00, valor_total: 5600000, tipo: 'Pesticidas', estado: 'Restringido' },
                { id: 3, producto: 'Herramientas Manuales', fecha: '2025-07-15', cantidad: 25, unidad: 'unidad', precio_unitario: 45000.00, valor_total: 1125000, tipo: 'Herramientas', estado: 'Disponible' },
                { id: 4, producto: 'Abono Orgánico', fecha: '2025-07-12', cantidad: 50, unidad: 'kg', precio_unitario: 8500.00, valor_total: 425000, tipo: 'Fertilizantes', estado: 'Óptimo' },
                { id: 5, producto: 'Semillas CCN-51', fecha: '2025-06-20', cantidad: 100, unidad: 'unidad', precio_unitario: 2500.00, valor_total: 250000, tipo: 'Semillas', estado: 'Óptimo' },
                { id: 6, producto: 'Fungicida', fecha: '2025-05-30', cantidad: 8, unidad: 'litro', precio_unitario: 45000.00, valor_total: 360000, tipo: 'Pesticidas', estado: 'Disponible' }
            ]
        },
        ventas: {
            items: [
                { id: 1, fecha: '2025-07-25', cliente: 'Juan Pérez', lote_produccion: 'Norte a', cantidad: 1.00, precio_kg: 20000.00, total: 20000.00, estado: 'pendiente', metodo: 'transferencia' },
                { id: 2, fecha: '2025-07-20', cliente: 'Distribuidora XYZ', lote_produccion: 'Sur', cantidad: 800, precio_kg: 12500, total: 10000000, estado: 'pagado', metodo: 'efectivo' },
                { id: 3, fecha: '2025-07-15', cliente: 'Chocolatera DEF', lote_produccion: 'Este', cantidad: 300, precio_kg: 18000, total: 5400000, estado: 'pagado', metodo: 'cheque' },
                { id: 4, fecha: '2025-07-28', cliente: 'Exportadora ABC', lote_produccion: 'Central', cantidad: 150, precio_kg: 22000, total: 3300000, estado: 'pagado', metodo: 'transferencia' },
                { id: 5, fecha: '2025-06-15', cliente: 'Comercializadora 123', lote_produccion: 'Norte B', cantidad: 200, precio_kg: 15000, total: 3000000, estado: 'pagado', metodo: 'efectivo' },
                { id: 6, fecha: '2025-05-22', cliente: 'Procesadora Local', lote_produccion: 'Sur B', cantidad: 180, precio_kg: 16500, total: 2970000, estado: 'pagado', metodo: 'cheque' }
            ]
        },
        produccion: {
            items: [
                { id: 1, cultivo: 'Ccn-51', lote: 'Norte a', fecha_inicio: '2025-07-18', fecha_fin_esperada: '2025-08-09', area: 5.00, estado: 'completado', rendimiento: 0.85, progreso: 100 },
                { id: 2, cultivo: 'Ccn-51', lote: 'Norte a', fecha_inicio: '2025-07-18', fecha_fin_esperada: '2025-08-07', area: 5.00, estado: 'completado', rendimiento: 0.40, progreso: 100 },
                { id: 3, cultivo: 'Ccn-51', lote: 'Sur', fecha_inicio: '2025-07-21', fecha_fin_esperada: '2025-08-09', area: 5.00, estado: 'en_progreso', rendimiento: 0.30, progreso: 63 },
                { id: 4, cultivo: 'Trinitario', lote: 'Este', fecha_inicio: '2025-07-25', fecha_fin_esperada: '2025-08-15', area: 8.00, estado: 'planificado', rendimiento: 0.00, progreso: 25 },
                { id: 5, cultivo: 'Forastero', lote: 'Norte B', fecha_inicio: '2025-06-10', fecha_fin_esperada: '2025-07-01', area: 4.00, estado: 'completado', rendimiento: 0.65, progreso: 100 },
                { id: 6, cultivo: 'Trinitario', lote: 'Sur B', fecha_inicio: '2025-05-25', fecha_fin_esperada: '2025-06-15', area: 3.50, estado: 'completado', rendimiento: 0.70, progreso: 100 }
            ]
        },
        trabajadores: {
            items: [
                { id: 1, nombre: 'Juan David Cangrejo Quintero', direccion: 'calle32#16-35', email: 'cangrejiito23@gmail.com', telefono: '3043667236', contrato: 'Permanente', estado: 'Activo', pago: 'Jornal' },
                { id: 2, nombre: 'María González', direccion: 'Calle 45 #12-30', email: 'maria.gonzalez@email.com', telefono: '3012345678', contrato: 'Temporal', estado: 'Activo', pago: 'Quincenal' },
                { id: 3, nombre: 'Carlos Rodríguez', direccion: 'Carrera 15 #8-25', email: 'carlos.rodriguez@email.com', telefono: '3109876543', contrato: 'Permanente', estado: 'Activo', pago: 'Mensual' },
                { id: 4, nombre: 'Ana López', direccion: 'Avenida 20 #15-40', email: 'ana.lopez@email.com', telefono: '3156789012', contrato: 'Temporal', estado: 'Activo', pago: 'Jornal' }
            ]
        }
    };
    
    // Mostrar todos los datos sin filtrar por fechas
    renderizarReporte(tipo, datosEjemplo[tipo] || { items: [] });
}

function renderizarReporte(tipo, data) {
    const container = document.getElementById('reporte-data');
    let html = '';
    
    // Actualizar contador de registros
    const count = data.items ? data.items.length : 0;
    document.getElementById('module-count').textContent = count;
    
    // Si no hay datos, mostrar mensaje de "Sin datos"
    if (!data.items || data.items.length === 0) {
        html = `
            <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-search text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-muted mb-2">Sin datos disponibles</h5>
                    <p class="text-muted mb-3">No hay registros de <strong>${getTipoLabel(tipo)}</strong> disponibles.</p>
                    <div class="alert alert-warning d-inline-block">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Módulo:</strong> ${getTipoLabel(tipo)} | <strong>Estado:</strong> Sin registros
                    </div>
                </div>
            </div>
        `;
        container.innerHTML = html;
        return;
    }
    
    switch (tipo) {
        case 'lote':
            html = `
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
                    <div class="card-header text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); border-radius: 10px 10px 0 0;">
                        <div>
                            <h5 class="mb-1 fw-bold" style="font-size: 1.1rem;">
                                <i class="fas fa-map-marked-alt me-2"></i>📋 MÓDULO: GESTIÓN DE LOTES
                            </h5>
                            <small class="opacity-75">Administración de terrenos y cultivos | Total: ${data.items.length} lotes registrados</small>
                        </div>
                        <button class="btn btn-warning btn-sm fw-bold px-3 py-2" onclick="descargarPDF('lote')" style="border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-download me-1"></i>Exportar PDF
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead style="background: linear-gradient(135deg, #8B4513 0%, #6F4E37 100%);">
                                    <tr>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🏞️ Nombre del Lote</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📅 Fecha Inicio</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📐 Área (m²)</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🌱 Capacidad</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🍫 Tipo Cacao</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">⚡ Estado</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📝 Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.items.map((item, index) => `
                                        <tr>
                                            <td class="py-2 px-3 fw-semibold" style="color: #6F4E37; font-size: 0.85rem;">
                                                <span class="badge bg-secondary me-2">#${index + 1}</span>${item.nombre}
                                            </td>
                                            <td class="py-2 px-3" style="font-size: 0.85rem;">${item.fecha_inicio}</td>
                                            <td class="py-2 px-3 fw-semibold" style="font-size: 0.85rem;">${item.area.toLocaleString()} m²</td>
                                            <td class="py-2 px-3" style="font-size: 0.85rem;">${item.capacidad}</td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%); color: #2C1810; font-size: 0.75rem;">
                                                    ${item.tipo_cacao}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge bg-${item.estado === 'Activo' ? 'success' : item.estado === 'En desarrollo' ? 'warning' : 'secondary'} px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                                    ${item.estado === 'Activo' ? '✅' : item.estado === 'En desarrollo' ? '🚧' : '⏸️'} ${item.estado}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3 text-muted" style="font-size: 0.85rem;">${item.observaciones}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-light py-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>MÓDULO LOTES:</strong> Mostrando ${data.items.length} registros de terrenos y cultivos de cacao
                            </small>
                        </div>
                    </div>
                </div>
            `;
            break;
            
        case 'inventario':
            html = `
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
                    <div class="card-header text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); border-radius: 10px 10px 0 0;">
                        <div>
                            <h5 class="mb-1 fw-bold" style="font-size: 1.1rem;">
                                <i class="fas fa-boxes me-2"></i>📦 MÓDULO: CONTROL DE INVENTARIO
                            </h5>
                            <small class="opacity-75">Insumos y materiales | Total: ${data.items.length} productos en stock</small>
                        </div>
                        <button class="btn btn-warning btn-sm fw-bold px-3 py-2" onclick="descargarPDF('inventario')" style="border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-download me-1"></i>Exportar PDF
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead style="background: linear-gradient(135deg, #8B4513 0%, #6F4E37 100%);">
                                    <tr>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🆔 ID</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📦 Producto</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📅 Fecha</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📊 Cantidad</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📏 Unidad</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">💰 Precio Unit.</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">💵 Valor Total</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🏷️ Tipo</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">⚡ Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.items.map((item, index) => `
                                        <tr>
                                            <td class="py-2 px-3 fw-semibold" style="color: #6F4E37; font-size: 0.85rem;">
                                                <span class="badge bg-secondary me-2">#${item.id}</span>
                                            </td>
                                            <td class="py-2 px-3 fw-semibold" style="font-size: 0.85rem; color: #2C1810;">
                                                <i class="fas fa-box-open me-1"></i>${item.producto}
                                            </td>
                                            <td class="py-2 px-3" style="font-size: 0.85rem;">${item.fecha}</td>
                                            <td class="py-2 px-3 fw-semibold" style="font-size: 0.85rem; color: #8B4513;">${item.cantidad.toLocaleString()}</td>
                                            <td class="py-2 px-3" style="font-size: 0.85rem;">${item.unidad}</td>
                                            <td class="py-2 px-3 fw-bold" style="font-size: 0.85rem; color: #2C7A2C;">$${Number(item.precio_unitario).toLocaleString()}</td>
                                            <td class="py-2 px-3 fw-bold" style="color: #6F4E37; font-size: 0.85rem;">$${Number(item.valor_total).toLocaleString()}</td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%); color: #2C1810; font-size: 0.75rem;">
                                                    📋 ${item.tipo}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill ${item.estado === 'Óptimo' ? 'bg-success' : item.estado === 'Restringido' ? 'bg-warning' : 'bg-secondary'}" style="font-size: 0.75rem;">
                                                    ${item.estado === 'Óptimo' ? '✅' : item.estado === 'Restringido' ? '⚠️' : '❓'} ${item.estado}
                                                </span>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-light py-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>MÓDULO INVENTARIO:</strong> Mostrando ${data.items.length} productos con control de stock y precios
                            </small>
                        </div>
                    </div>
                </div>
            `;
            break;
            
        case 'ventas':
            html = `
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
                    <div class="card-header text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); border-radius: 10px 10px 0 0;">
                        <div>
                            <h5 class="mb-1 fw-bold" style="font-size: 1.1rem;">
                                <i class="fas fa-shopping-cart me-2"></i>💰 MÓDULO: ANÁLISIS DE VENTAS
                            </h5>
                            <small class="opacity-75">Ingresos y clientes | Total: ${data.items.length} transacciones registradas</small>
                        </div>
                        <button class="btn btn-warning btn-sm fw-bold px-3 py-2" onclick="descargarPDF('ventas')" style="border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-download me-1"></i>Exportar PDF
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead style="background: linear-gradient(135deg, #8B4513 0%, #6F4E37 100%);">
                                    <tr>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🆔 ID</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📅 Fecha</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">👤 Cliente</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📦 Lote/Producción</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">⚖️ Cantidad</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">💰 Precio/kg</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">💵 Total</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">⚡ Estado</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">💳 Método Pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.items.map((item, index) => `
                                        <tr>
                                            <td class="py-2 px-3 fw-semibold" style="color: #6F4E37; font-size: 0.85rem;">
                                                <span class="badge bg-secondary me-2">#${item.id}</span>
                                            </td>
                                            <td class="py-2 px-3" style="font-size: 0.85rem;">${item.fecha}</td>
                                            <td class="py-2 px-3 fw-semibold" style="font-size: 0.85rem; color: #2C1810;">
                                                <i class="fas fa-user-tie me-1"></i>${item.cliente}
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%); color: #2C1810; font-size: 0.75rem;">
                                                    📋 ${item.lote_produccion}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3 fw-semibold" style="font-size: 0.85rem; color: #8B4513;">
                                                <i class="fas fa-weight-hanging me-1"></i>${Number(item.cantidad).toLocaleString()} kg
                                            </td>
                                            <td class="py-2 px-3 fw-bold" style="font-size: 0.85rem; color: #2C7A2C;">$${Number(item.precio_kg).toLocaleString()}</td>
                                            <td class="py-2 px-3 fw-bold" style="color: #6F4E37; font-size: 0.85rem; font-weight: 900;">$${Number(item.total).toLocaleString()}</td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill ${item.estado === 'pagado' ? 'bg-success' : item.estado === 'pendiente' ? 'bg-warning' : 'bg-danger'}" style="font-size: 0.75rem;">
                                                    ${item.estado === 'pagado' ? '✅' : item.estado === 'pendiente' ? '⏳' : '❌'} ${item.estado}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge bg-info text-dark px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                                    💳 ${item.metodo}
                                                </span>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-light py-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>MÓDULO VENTAS:</strong> Mostrando ${data.items.length} transacciones comerciales y análisis de ingresos
                            </small>
                        </div>
                    </div>
                </div>
            `;
            break;
        
        case 'produccion':
            html = `
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
                    <div class="card-header text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); border-radius: 10px 10px 0 0;">
                        <div>
                            <h5 class="mb-1 fw-bold" style="font-size: 1.1rem;">
                                <i class="fas fa-seedling me-2"></i>🌱 MÓDULO: CONTROL DE PRODUCCIÓN
                            </h5>
                            <small class="opacity-75">Cultivos y rendimiento | Total: ${data.items.length} procesos productivos</small>
                        </div>
                        <button class="btn btn-warning btn-sm fw-bold px-3 py-2" onclick="descargarPDF('produccion')" style="border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-download me-1"></i>Exportar PDF
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead style="background: linear-gradient(135deg, #8B4513 0%, #6F4E37 100%);">
                                    <tr>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🆔 ID</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🌾 Cultivo</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🏞️ Lote</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🚀 F. Inicio</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🎯 F. Fin Esperada</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📐 Área (m²)</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">⚡ Estado</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📊 Rendimiento</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📈 Progreso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.items.map((item, index) => `
                                        <tr>
                                            <td class="py-2 px-3 fw-semibold" style="color: #6F4E37; font-size: 0.85rem;">
                                                <span class="badge bg-secondary me-2">#${item.id}</span>
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%); color: #2C1810; font-size: 0.75rem;">
                                                    🌱 ${item.cultivo}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3 fw-semibold" style="font-size: 0.85rem; color: #2C1810;">
                                                <i class="fas fa-map-marker-alt me-1"></i>${item.lote}
                                            </td>
                                            <td class="py-2 px-3" style="font-size: 0.85rem;">${item.fecha_inicio}</td>
                                            <td class="py-2 px-3" style="font-size: 0.85rem;">${item.fecha_fin_esperada}</td>
                                            <td class="py-2 px-3 fw-semibold" style="font-size: 0.85rem; color: #8B4513;">
                                                <i class="fas fa-ruler-combined me-1"></i>${Number(item.area).toLocaleString()} m²
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill ${item.estado === 'completado' ? 'bg-success' : item.estado === 'en_progreso' ? 'bg-warning' : item.estado === 'planificado' ? 'bg-info' : 'bg-secondary'}" style="font-size: 0.75rem;">
                                                    ${item.estado === 'completado' ? '✅ Completado' : item.estado === 'en_progreso' ? '🚧 En Progreso' : item.estado === 'planificado' ? '📋 Planificado' : '⏸️ ' + item.estado}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3 fw-bold" style="color: #6F4E37; font-size: 0.85rem;">
                                                <i class="fas fa-chart-line me-1"></i>${Number(item.rendimiento).toFixed(2)} kg/m²
                                            </td>
                                            <td class="py-2 px-3" style="min-width: 120px;">
                                                <div class="progress" style="height: 18px; background-color: #f0f0f0; border-radius: 9px;">
                                                    <div class="progress-bar progress-bar-striped" 
                                                         style="background: linear-gradient(135deg, #8B4513 0%, #6F4E37 100%); width: ${item.progreso}%; color: white; font-size: 0.75rem; font-weight: bold; border-radius: 9px;" 
                                                         role="progressbar" 
                                                         aria-valuenow="${item.progreso}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                        📊 ${item.progreso}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-light py-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>MÓDULO PRODUCCIÓN:</strong> Mostrando ${data.items.length} procesos de cultivo con seguimiento de rendimiento y progreso
                            </small>
                        </div>
                    </div>
                </div>
            `;
            break;
            
        case 'trabajadores':
            html = `
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 10px;">
                    <div class="card-header text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); border-radius: 10px 10px 0 0;">
                        <div>
                            <h5 class="mb-1 fw-bold" style="font-size: 1.1rem;">
                                <i class="fas fa-users me-2"></i>👥 MÓDULO: RECURSOS HUMANOS
                            </h5>
                            <small class="opacity-75">Personal y nómina | Total: ${data.items.length} trabajadores registrados</small>
                        </div>
                        <button class="btn btn-warning btn-sm fw-bold px-3 py-2" onclick="descargarPDF('trabajadores')" style="border-radius: 6px; font-size: 0.8rem;">
                            <i class="fas fa-download me-1"></i>Exportar PDF
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead style="background: linear-gradient(135deg, #8B4513 0%, #6F4E37 100%);">
                                    <tr>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🆔 ID</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">👤 Nombre Completo</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">🏠 Dirección</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📧 Email</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📱 Teléfono</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">📝 Tipo Contrato</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">⚡ Estado</th>
                                        <th class="py-2 px-3 fw-bold text-white" style="font-size: 0.8rem; border: none;">💰 Forma Pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.items.map((item, index) => `
                                        <tr>
                                            <td class="py-2 px-3 fw-semibold" style="color: #6F4E37; font-size: 0.85rem;">
                                                <span class="badge bg-secondary me-2">#${item.id}</span>
                                            </td>
                                            <td class="py-2 px-3 fw-semibold" style="font-size: 0.85rem; color: #2C1810;">${item.nombre}</td>
                                            <td class="py-2 px-3" style="font-size: 0.85rem;">${item.direccion}</td>
                                            <td class="py-2 px-3">
                                                <a href="mailto:${item.email}" class="text-decoration-none" style="color: #6F4E37; font-size: 0.85rem;">
                                                    <i class="fas fa-envelope me-1"></i>${item.email}
                                                </a>
                                            </td>
                                            <td class="py-2 px-3">
                                                <a href="tel:${item.telefono}" class="text-decoration-none" style="color: #6F4E37; font-size: 0.85rem;">
                                                    <i class="fas fa-phone me-1"></i>${item.telefono}
                                                </a>
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%); color: #2C1810; font-size: 0.75rem;">
                                                    📋 ${item.contrato}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge px-2 py-1 rounded-pill ${item.estado === 'Activo' ? 'bg-success' : 'bg-warning'}" style="font-size: 0.75rem;">
                                                    ${item.estado === 'Activo' ? '✅' : '⚠️'} ${item.estado}
                                                </span>
                                            </td>
                                            <td class="py-2 px-3">
                                                <span class="badge bg-info text-dark px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                                    💳 ${item.pago}
                                                </span>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-light py-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>MÓDULO RECURSOS HUMANOS:</strong> Mostrando ${data.items.length} trabajadores con información de contacto y contratos
                            </small>
                        </div>
                    </div>
                </div>
            `;
            break;
    }
    
    container.innerHTML = html;
}

async function actualizarMetricas() {
    try {
        const response = await fetch('/reportes/metricas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(filtrosActivos)
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('total-lotes').textContent = data.metricas.total_lotes;
            document.getElementById('total-produccion').textContent = data.metricas.total_produccion.toLocaleString() + 'kg';
            document.getElementById('total-ventas').textContent = '$' + data.metricas.total_ventas.toLocaleString();
            document.getElementById('rentabilidad').textContent = data.metricas.rentabilidad.toFixed(1) + '%';
            document.getElementById('calidad-promedio').textContent = data.metricas.calidad_promedio.toFixed(1);
            document.getElementById('total-trabajadores').textContent = data.metricas.total_trabajadores;
        }
    } catch (error) {
        console.error('Error al actualizar métricas:', error);
    }
}

function descargarPDF(tipo) {
    try {
        // Construir URL correcta para descarga PDF individual
        const url = `/reportes/pdf/${tipo}`;
        
        // Abrir en nueva ventana para descarga
        const link = document.createElement('a');
        link.href = url;
        link.target = '_blank';
        link.click();
        
        console.log(`Descargando PDF para tipo: ${tipo}`);
    } catch (error) {
        console.error('Error al descargar PDF:', error);
        mostrarAlerta('Error al descargar el PDF. Por favor, intente nuevamente.');
    }
}

function generarReporteGeneral() {
    try {
        // Construir URL correcta para descarga PDF general
        const url = `/reportes/pdf-general`;
        
        // Crear enlace de descarga directa
        const link = document.createElement('a');
        link.href = url;
        link.download = `reporte_general_${new Date().toISOString().split('T')[0]}.pdf`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        console.log('Descargando PDF general');
    } catch (error) {
        console.error('Error al generar reporte general:', error);
        mostrarAlerta('Error al generar el reporte general. Por favor, intente nuevamente.');
    }
}

function mostrarCarga(mostrar) {
    const loading = document.getElementById('loading');
    const content = document.getElementById('reporte-data');
    
    if (mostrar) {
        loading.classList.remove('d-none');
        content.classList.add('d-none');
    } else {
        loading.classList.add('d-none');
        content.classList.remove('d-none');
    }
}

function mostrarAlerta(mensaje) {
    document.getElementById('alertContent').textContent = mensaje;
    new bootstrap.Modal(document.getElementById('alertModal')).show();
}

function getTipoLabel(tipo) {
    const labels = {
        'lote': 'Lotes',
        'inventario': 'Inventario', 
        'ventas': 'Ventas',
        'produccion': 'Producción',
        'trabajadores': 'Trabajadores'
    };
    return labels[tipo] || tipo;
}

// Manejo de errores globales
window.addEventListener('error', function(e) {
    console.error('Error global:', e.error);
    mostrarAlerta('Ocurrió un error inesperado. Por favor, recarga la página.');
});
</script>
@endpush
@endsection
