@extends('layouts.masterr')

@push('styles')
<link href="{{ asset('css/cacao-dashboard.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="dashboard-container">

    <div class="dashboard-header fade-in">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="dashboard-title">
                    <i class="fas fa-seedling"></i>
                    Sistema de Gestión Cacaotera
                </h1>
                <p class="dashboard-subtitle">
                    Plataforma integral para el control y análisis de producción de cacao de alta calidad
                </p>
            </div>
            <button class="btn-modern btn-warning" onclick="generarReporteGeneral()">
                <i class="fas fa-file-pdf"></i>
                Exportar Reporte General
            </button>
        </div>
    </div>


    <div class="metrics-grid fade-in" id="metricas-dashboard">
        <div class="metric-card">
            <i class="metric-icon fas fa-map-marked-alt"></i>
            <span class="metric-value" id="total-lotes">{{ $metricas['total_lotes'] ?? 0 }}</span>
            <span class="metric-label">Lotes Activos</span>
        </div>

        <div class="metric-card">
            <i class="metric-icon fas fa-weight-hanging"></i>
            <span class="metric-value" id="total-produccion">{{ number_format($metricas['total_produccion'] ?? 0) }}kg</span>
            <span class="metric-label">Producción Total</span>
        </div>

        <div class="metric-card">
            <i class="metric-icon fas fa-dollar-sign"></i>
            <span class="metric-value" id="total-ventas">${{ number_format($metricas['total_ventas'] ?? 0) }}</span>
            <span class="metric-label">Ingresos Totales</span>
        </div>

        <div class="metric-card">
            <i class="metric-icon fas fa-chart-line"></i>
            <span class="metric-value" id="rentabilidad">{{ number_format($metricas['rentabilidad'] ?? 0, 1) }}%</span>
            <span class="metric-label">Rentabilidad</span>
        </div>

        <div class="metric-card">
            <i class="metric-icon fas fa-users"></i>
            <span class="metric-value" id="total-trabajadores">{{ $metricas['total_trabajadores'] ?? 0 }}</span>
            <span class="metric-label">Personal Activo</span>
        </div>
    </div>


    <div class="nav-tabs-container fade-in">
        <div class="nav-tabs-custom d-flex flex-wrap justify-content-center" id="reporteTabs">
            <button class="nav-tab-item active" onclick="cambiarReporte('lote')">
                <i class="nav-tab-icon fas fa-map-marked-alt"></i>
                <span class="nav-tab-title">Gestión de Lotes</span>
                <span class="nav-tab-subtitle">Terrenos y Cultivos</span>
            </button>

            <button class="nav-tab-item" onclick="cambiarReporte('inventario')">
                <i class="nav-tab-icon fas fa-boxes"></i>
                <span class="nav-tab-title">Control de Inventario</span>
                <span class="nav-tab-subtitle">Insumos y Materiales</span>
            </button>

            <button class="nav-tab-item" onclick="cambiarReporte('ventas')">
                <i class="nav-tab-icon fas fa-shopping-cart"></i>
                <span class="nav-tab-title">Análisis de Ventas</span>
                <span class="nav-tab-subtitle">Ingresos y Clientes</span>
            </button>

            <button class="nav-tab-item" onclick="cambiarReporte('produccion')">
                <i class="nav-tab-icon fas fa-seedling"></i>
                <span class="nav-tab-title">Control de Producción</span>
                <span class="nav-tab-subtitle">Cultivos y Rendimiento</span>
            </button>

            <button class="nav-tab-item" onclick="cambiarReporte('trabajadores')">
                <i class="nav-tab-icon fas fa-users"></i>
                <span class="nav-tab-title">Recursos Humanos</span>
                <span class="nav-tab-subtitle">Personal y Nómina</span>
            </button>
            <button class="nav-tab-item" onclick="cambiarReporte('contabilidad')">
                <i class="nav-tab-icon fas fa-coins"></i>
                <span class="nav-tab-title">Contabilidad</span>
                <span class="nav-tab-subtitle">Balance y Cuentas</span>
            </button>
        </div>
    </div>


    <div class="module-indicator fade-in" id="module-indicator">
        <div class="module-info">
            <div class="module-icon-container">
                <i id="module-icon" class="fas fa-map-marked-alt"></i>
            </div>
            <div class="module-details flex-grow-1">
                <h5 id="module-title">Gestión de Lotes</h5>
                <p id="module-description" class="mb-1">Administración de terrenos y cultivos de cacao</p>
                <small id="module-details">Control de áreas, capacidades, tipos de cacao y estado de los lotes</small>
            </div>
            <div class="module-badge">
                <i class="fas fa-database me-1"></i>
                <span id="module-count">0</span> registros
            </div>
        </div>
    </div>


    <div id="contenido-reporte">
        <div class="loading-container d-none" id="loading">
            <div class="loading-spinner"></div>
            <p class="fw-semibold">Cargando datos del módulo...</p>
        </div>


        <div id="reporte-data" class="fade-in"></div>
    </div>
</div>


<div class="modal fade" id="alertModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%); border-radius: 12px 12px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-info-circle me-2"></i>Información del Sistema
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="alertContent">
                 Contenido del modal
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn-modern btn-primary" data-bs-dismiss="modal">
                    <i class="fas fa-check me-1"></i>Entendido
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
  window.urlReporteGeneral = "{{ route('reportes.pdf.general') }}";
</script>

@push('scripts')
<script src="{{ asset('js/cacao-dashboard.js') }}"></script>
<script>
  window.cambiarReporte = cambiarReporte;
</script>
@endpush
