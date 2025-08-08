
@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root {
    --cacao-primary: #4a3728;
    --cacao-secondary: #6b4e3d;
    --cacao-accent: #8b6f47;
    --cacao-light: #d4c4b0;
    --cacao-bg: #f8f6f4;
    --cacao-white: #ffffff;
    --cacao-text: #2c1810;
    --cacao-muted: #8d6e63;
    --success: #2e7d32;
    --warning: #f57c00;
    --danger: #c62828;
    --info: #1976d2;
}

body {
    background: var(--cacao-bg);
    color: var(--cacao-text);
}

/* Container principal */
.main-container {
    background: var(--cacao-white);
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 1rem 0;
}

/* Título principal */
.main-title {
    color: var(--cacao-primary);
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 0.3rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.main-subtitle {
    color: var(--cacao-muted);
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

/* Header con gradiente */
.header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    padding: 1.5rem;
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
}

/* Breadcrumb profesional */
.breadcrumb-professional {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    padding: 0.5rem 1rem;
    margin-top: 1rem;
}

.breadcrumb-professional .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-professional .breadcrumb-item a:hover {
    color: var(--cacao-white);
}

.breadcrumb-professional .breadcrumb-item.active {
    color: var(--cacao-white);
}

/* Formularios de filtros */
.filters-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.form-label-professional {
    color: var(--cacao-primary);
    font-weight: 500;
    font-size: 0.85rem;
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.form-control-professional,
.form-select-professional {
    border: 1px solid var(--cacao-light);
    border-radius: 5px;
    padding: 0.5rem 0.7rem;
    font-size: 0.8rem;
    transition: all 0.2s ease;
    background: var(--cacao-white);
    height: auto;
}

.form-control-professional:focus,
.form-select-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.15rem rgba(139, 111, 71, 0.15);
    outline: none;
}

/* Botones profesionales */
.btn-professional {
    border: none;
    border-radius: 5px;
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-primary-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(74, 55, 40, 0.25);
}

.btn-primary-professional:hover {
    background: linear-gradient(135deg, var(--cacao-secondary), var(--cacao-primary));
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 5px 12px rgba(74, 55, 40, 0.3);
}

.btn-outline-professional {
    background: transparent;
    color: var(--cacao-primary);
    border: 1px solid var(--cacao-light);
}

.btn-outline-professional:hover {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border-color: var(--cacao-primary);
}

.btn-success-professional {
    background: linear-gradient(135deg, var(--success), #1b5e20);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(46, 125, 50, 0.25);
}

.btn-success-professional:hover {
    background: linear-gradient(135deg, #1b5e20, var(--success));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-danger-professional {
    background: linear-gradient(135deg, var(--danger), #b71c1c);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(198, 40, 40, 0.25);
}

.btn-danger-professional:hover {
    background: linear-gradient(135deg, #b71c1c, var(--danger));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-info-professional {
    background: linear-gradient(135deg, var(--info), #0d47a1);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(25, 118, 210, 0.25);
}

.btn-info-professional:hover {
    background: linear-gradient(135deg, #0d47a1, var(--info));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-warning-professional {
    background: linear-gradient(135deg, var(--warning), #e65100);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(245, 124, 0, 0.25);
}

.btn-warning-professional:hover {
    background: linear-gradient(135deg, #e65100, var(--warning));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

/* Cards de estadísticas */
.stats-card {
    background: var(--cacao-white);
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 1rem;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stats-card-primary {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
}

.stats-card-success {
    background: linear-gradient(135deg, var(--success), #1b5e20);
}

.stats-card-warning {
    background: linear-gradient(135deg, var(--warning), #e65100);
}

.stats-card-danger {
    background: linear-gradient(135deg, var(--danger), #b71c1c);
}

.stats-card-info {
    background: linear-gradient(135deg, var(--info), #0d47a1);
}

.stats-card .card-body {
    padding: 1.2rem;
    color: var(--cacao-white);
}

.stats-number {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}

.stats-label {
    font-size: 0.8rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.stats-icon {
    font-size: 1.8rem;
    opacity: 0.7;
}

/* Tabla profesional */
.table-professional {
    margin: 0;
    font-size: 0.9rem;
    border-collapse: separate;
    border-spacing: 0;
}

.table-professional thead th {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
    padding: 1rem 0.8rem;
    font-weight: 600;
    font-size: 0.85rem;
    vertical-align: middle;
    border-bottom: 2px solid var(--cacao-secondary);
    white-space: nowrap;
}

.table-professional tbody td {
    padding: 0.9rem 0.8rem;
    vertical-align: middle;
    border-color: var(--cacao-light);
    font-size: 0.85rem;
    border-top: 1px solid var(--cacao-light);
}

.table-professional tbody tr {
    transition: all 0.2s ease;
}

.table-professional tbody tr:hover {
    background-color: rgba(139, 111, 71, 0.05);
    transform: translateY(-1px);
}

/* Mejoras para botones en tabla */
.table-professional .btn-group {
    display: flex;
    gap: 0.2rem;
    justify-content: center;
}

.table-professional .btn-sm {
    padding: 0.25rem 0.4rem;
    font-size: 0.75rem;
    border-radius: 3px;
    min-width: 30px;
}

/* Cards de secciones */
.section-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.section-header {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    padding: 0.8rem 1.2rem;
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Badges profesionales */
.badge-professional {
    padding: 0.35rem 0.7rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    display: inline-block;
    margin: 0.1rem;
}

.badge-success-professional {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-warning-professional {
    background-color: var(--warning);
    color: var(--cacao-white);
}

.badge-info-professional {
    background-color: var(--info);
    color: var(--cacao-white);
}

/* Estados responsivos */
@media (max-width: 768px) {
    .main-container {
        margin: 0.5rem;
        border-radius: 8px;
    }

    .header-professional {
        padding: 1.2rem;
        margin: -1rem -1rem 1.2rem -1rem;
    }

    .main-title {
        font-size: 1.2rem;
        text-align: center;
    }

    .filters-card {
        padding: 1rem;
    }

    .table-professional {
        font-size: 0.8rem;
    }

    .table-professional thead th,
    .table-professional tbody td {
        padding: 0.7rem 0.5rem;
    }

    .btn-professional {
        padding: 0.5rem 0.8rem;
        font-size: 0.8rem;
        margin-bottom: 0.4rem;
    }

    .stats-number {
        font-size: 1.3rem;
    }

    .stats-icon {
        font-size: 1.5rem;
    }

    .stats-card .card-body {
        padding: 1rem;
    }

    /* Hacer que en móvil los botones sean más grandes */
    .filters-card .btn-professional {
        width: 100%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .header-professional {
        padding: 1rem;
    }

    .main-title {
        font-size: 1.1rem;
    }

    .stats-card .card-body {
        padding: 0.8rem;
    }

    .stats-number {
        font-size: 1.2rem;
    }

    .stats-label {
        font-size: 0.75rem;
    }

    .form-label-professional {
        font-size: 0.8rem;
    }

    .form-control-professional,
    .form-select-professional {
        padding: 0.5rem 0.6rem;
        font-size: 0.8rem;
    }

    /* Hacer que la tabla sea horizontal scrollable en móvil */
    .table-responsive {
        border: 1px solid var(--cacao-light);
        border-radius: 8px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-professional {
        min-width: 800px;
        margin-bottom: 0;
    }

    /* Ajustar filtros en móvil */
    .filters-card .row > [class*="col-"] {
        margin-bottom: 0.8rem;
    }

    /* Modal en móvil */
    .modal-dialog {
        margin: 0.5rem;
        max-width: none;
    }

    .modal-body {
        padding: 1.5rem 1rem !important;
    }

    /* Breadcrumb en móvil */
    .breadcrumb-professional {
        padding: 0.3rem 0.7rem;
        font-size: 0.8rem;
    }

    .breadcrumb-professional .breadcrumb-item {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }
}

/* Animaciones profesionales */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.pulse-animation {
    animation: pulse 2s infinite;
}

/* Estilos para paginación */
.pagination {
    margin: 0;
}

.pagination .page-link {
    color: var(--cacao-primary);
    border-color: var(--cacao-light);
    padding: 0.5rem 0.75rem;
}

.pagination .page-link:hover {
    color: var(--cacao-white);
    background-color: var(--cacao-primary);
    border-color: var(--cacao-primary);
}

.pagination .page-item.active .page-link {
    background-color: var(--cacao-primary);
    border-color: var(--cacao-primary);
    color: var(--cacao-white);
}

/* Mejoras para formularios */
.form-control-professional.is-invalid,
.form-select-professional.is-invalid {
    border-color: var(--danger);
    box-shadow: 0 0 0 0.15rem rgba(198, 40, 40, 0.15);
}

.form-control-professional.is-valid,
.form-select-professional.is-valid {
    border-color: var(--success);
    box-shadow: 0 0 0 0.15rem rgba(46, 125, 50, 0.15);
}

/* Tooltip personalizado */
.tooltip-inner {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
    padding: 0.5rem 0.75rem;
    border-radius: 5px;
}

.tooltip.bs-tooltip-top .tooltip-arrow::before {
    border-top-color: var(--cacao-primary);
}

/* Alertas personalizadas */
.alert {
    border: none;
    border-radius: 8px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.alert .btn-close {
    padding: 0.75rem;
}

/* Estado vacío profesional */
.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--cacao-muted);
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.02), rgba(139, 111, 71, 0.05));
    border-radius: 8px;
    margin: 1rem;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
    color: var(--cacao-primary);
}

.empty-state h5 {
    color: var(--cacao-primary);
    margin-bottom: 1rem;
    font-size: 1.3rem;
    font-weight: 600;
}

.empty-state p {
    color: var(--cacao-muted);
    margin-bottom: 1.5rem;
    font-size: 1rem;
}
</style>

<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title text-white mb-2">
                        <i class="fas fa-shopping-cart me-2"></i>Gestión de Ventas
                    </h1>
                    <p class="main-subtitle text-white-50 mb-0">
                        Control integral de ventas de cacao y productos derivados
                    </p>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="breadcrumb-professional">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('recolecciones.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i>Recolecciones
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-shopping-cart me-1"></i>Ventas
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary-professional" data-bs-toggle="modal" data-bs-target="#ventaModal">
                            <i class="fas fa-plus me-2"></i>Nueva Venta
                        </button>
                        <a href="{{ route('ventas.reporte') }}" class="btn btn-info-professional">
                            <i class="fas fa-chart-bar me-2"></i>Reporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alertas profesionales -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, var(--success), #1b5e20); border: none; color: white;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, var(--danger), #b71c1c); border: none; color: white;">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Estadísticas de ventas -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card stats-card-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">{{ $ventasHoy ?? 0 }}</div>
                                <div class="stats-label">Ventas Hoy</div>
                            </div>
                            <div>
                                <i class="fas fa-shopping-cart stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card stats-card-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">${{ number_format($ingresosTotales ?? 0, 2) }}</div>
                                <div class="stats-label">Ingresos Totales</div>
                            </div>
                            <div>
                                <i class="fas fa-dollar-sign stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card stats-card-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">{{ number_format($stockTotal ?? 0, 1) }} kg</div>
                                <div class="stats-label">Stock Disponible</div>
                            </div>
                            <div>
                                <i class="fas fa-warehouse stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card stats-card-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">{{ $pagosPendientes ?? 0 }}</div>
                                <div class="stats-label">Pagos Pendientes</div>
                            </div>
                            <div>
                                <i class="fas fa-clock stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros profesionales -->
        <div class="filters-card fade-in-up">
            <form method="GET" action="{{ route('ventas.index') }}">
                <div class="row align-items-end">
                    <div class="col-lg-3 col-md-4 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-search"></i>Buscar
                        </label>
                        <input type="text"
                               name="search"
                               class="form-control-professional"
                               placeholder="Cliente o lote..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-calendar-alt"></i>Desde
                        </label>
                        <input type="date"
                               name="fecha_desde"
                               class="form-control-professional"
                               value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-calendar-alt"></i>Hasta
                        </label>
                        <input type="date"
                               name="fecha_hasta"
                               class="form-control-professional"
                               value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-credit-card"></i>Estado
                        </label>
                        <select name="estado_pago" class="form-select-professional">
                            <option value="">Todos</option>
                            <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary-professional w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="col-lg-1 col-md-3 mb-3">
                        <a href="{{ route('ventas.index') }}" class="btn btn-outline-professional w-100">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de ventas -->
        <div class="section-card">
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list me-2"></i>
                    <span>Registro de Ventas</span>
                </div>
                <span class="badge bg-white text-dark">{{ isset($ventas) ? $ventas->count() : 0 }} registros</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-professional table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 6%; padding: 0.8rem 0.5rem;"><i class="fas fa-hashtag me-1"></i>ID</th>
                                <th style="text-align: center; width: 10%; padding: 0.8rem 0.6rem;"><i class="fas fa-calendar me-1"></i>Fecha</th>
                                <th style="text-align: left; width: 18%; padding: 0.8rem 0.7rem;"><i class="fas fa-user me-1"></i>Cliente</th>
                                <th style="text-align: left; width: 18%; padding: 0.8rem 0.7rem;"><i class="fas fa-seedling me-1"></i>Lote/Producción</th>
                                <th style="text-align: center; width: 10%; padding: 0.8rem 0.8rem;"><i class="fas fa-weight me-1"></i>Cantidad</th>
                                <th style="text-align: center; width: 9%; padding: 0.8rem 0.8rem;"><i class="fas fa-dollar-sign me-1"></i>Precio/kg</th>
                                <th style="text-align: center; width: 10%; padding: 0.8rem 0.8rem;"><i class="fas fa-calculator me-1"></i>Total</th>
                                <th style="text-align: center; width: 8%; padding: 0.8rem 0.7rem;"><i class="fas fa-credit-card me-1"></i>Estado</th>
                                <th style="text-align: center; width: 8%; padding: 0.8rem 0.7rem;"><i class="fas fa-money-bill me-1"></i>Método</th>
                                <th style="text-align: center; width: 9%; padding: 0.8rem 0.8rem;"><i class="fas fa-cogs me-1"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventas ?? [] as $venta)
                                <tr>
                                    <td style="text-align: center; padding: 0.8rem 0.5rem;"><span class="fw-bold">{{ $venta->id }}</span></td>
                                    <td style="text-align: center; padding: 0.8rem 0.6rem;">
                                        <span class="fw-medium">{{ $venta->fecha_venta->format('d/m/Y') }}</span>
                                    </td>
                                    <td style="text-align: left; padding: 0.8rem 0.7rem;">
                                        <div>
                                            <strong class="text-dark">{{ $venta->cliente }}</strong>
                                            @if($venta->telefono_cliente)
                                                <br><small class="text-muted">{{ $venta->telefono_cliente }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="text-align: left; padding: 0.8rem 0.7rem;">
                                        <div>
                                            <strong class="text-dark">{{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</strong>
                                            <br><small class="text-muted">{{ $venta->recoleccion->produccion->tipo_cacao }}</small>
                                        </div>
                                    </td>
                                    <td style="text-align: center; padding: 0.8rem 0.8rem;">
                                        <span class="badge badge-info-professional">
                                            {{ number_format($venta->cantidad_vendida, 2) }} kg
                                        </span>
                                    </td>
                                    <td style="text-align: center; padding: 0.8rem 0.8rem;">
                                        <span class="fw-medium">${{ number_format($venta->precio_por_kg, 2) }}</span>
                                    </td>
                                    <td style="text-align: center; padding: 0.8rem 0.8rem;">
                                        <strong class="text-success">
                                            ${{ number_format($venta->total_venta, 2) }}
                                        </strong>
                                    </td>
                                    <td style="text-align: center; padding: 0.8rem 0.7rem;">
                                        <span class="badge badge-{{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }}-professional" style="font-size: 0.65rem; padding: 0.3rem 0.6rem;">
                                            {{ ucfirst($venta->estado_pago) }}
                                        </span>
                                    </td>
                                    <td style="text-align: center; padding: 0.8rem 0.7rem;">
                                        <div style="display: flex; justify-content: center;">
                                            @switch($venta->metodo_pago)
                                                @case('efectivo')
                                                    <span class="badge badge-success-professional" style="font-size: 0.65rem; padding: 0.3rem 0.5rem;">
                                                        <i class="fas fa-money-bill-wave me-1"></i>Efectivo
                                                    </span>
                                                    @break
                                                @case('transferencia')
                                                    <span class="badge badge-info-professional" style="font-size: 0.65rem; padding: 0.3rem 0.5rem;">
                                                        <i class="fas fa-university me-1"></i>Transfer.
                                                    </span>
                                                    @break
                                                @case('cheque')
                                                    <span class="badge badge-warning-professional" style="font-size: 0.65rem; padding: 0.3rem 0.5rem;">
                                                        <i class="fas fa-money-check me-1"></i>Cheque
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge badge-info-professional" style="font-size: 0.65rem; padding: 0.3rem 0.5rem;">
                                                        <i class="fas fa-credit-card me-1"></i>{{ ucfirst($venta->metodo_pago) }}
                                                    </span>
                                            @endswitch
                                        </div>
                                    </td>
                                    <td style="text-align: center; padding: 0.8rem 0.8rem;">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info-professional"
                                                    onclick="verDetalle({{ $venta->id }})" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning-professional"
                                                    onclick="editarVenta({{ $venta->id }})" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($venta->estado_pago == 'pendiente')
                                                <button type="button" class="btn btn-sm btn-success-professional"
                                                        onclick="marcarPagado({{ $venta->id }})" title="Marcar como pagado">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger-professional"
                                                    onclick="eliminarVenta({{ $venta->id }})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                            <h5>No hay ventas registradas</h5>
                                            <p>Comienza registrando una nueva venta</p>
                                            <button class="btn btn-primary-professional" data-bs-toggle="modal" data-bs-target="#ventaModal">
                                                <i class="fas fa-plus me-2"></i>Nueva Venta
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Paginación -->
        @if(isset($ventas) && $ventas->hasPages())
            <div class="d-flex justify-content-center">
                {{ $ventas->withQueryString()->links() }}
            </div>
        @endif

        <!-- Botón para volver -->
        <div class="mt-3 text-center">
            <a href="{{ route('recolecciones.index') }}" class="btn btn-outline-professional">
                <i class="fas fa-arrow-left me-2"></i>Volver a Recolecciones
            </a>
        </div>
    </div>
</div>

{{-- Modal para nueva venta --}}
<div class="modal fade" id="ventaModal" tabindex="-1" aria-labelledby="ventaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(74, 55, 40, 0.3);">
            <form id="ventaForm" method="POST" action="{{ route('ventas.store') }}">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary)); color: white; border-bottom: none; padding: 1.2rem 1.5rem;">
                    <h5 class="modal-title" id="ventaModalLabel" style="font-weight: 600; font-size: 1.1rem;">
                        <i class="fas fa-shopping-cart me-2"></i>Nueva Venta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="background: linear-gradient(135deg, #fafafa, #f5f5f5); padding: 1.2rem;">

                    <!-- Información General -->
                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="fecha_venta" class="form-label-professional" style="font-size: 0.8rem;">
                                    <i class="fas fa-calendar-alt text-primary"></i> Fecha <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control-professional" id="fecha_venta" name="fecha_venta"
                                       value="{{ date('Y-m-d') }}" required style="font-size: 0.85rem;">
                            </div>

                            <div class="col-6">
                                <label for="recoleccion_id" class="form-label-professional" style="font-size: 0.8rem;">
                                    <i class="fas fa-seedling text-success"></i> Recolección Disponible <span class="text-danger">*</span>
                                </label>
                                <select class="form-select-professional" id="recoleccion_id" name="recoleccion_id" required onchange="actualizarStock()" style="font-size: 0.85rem;">
                                    <option value="">-- Seleccionar Recolección --</option>
                                    @if(count($recoleccionesDisponibles ?? []) > 0)
                                        @foreach($recoleccionesDisponibles as $recoleccion)
                                            <option value="{{ $recoleccion->id }}"
                                                    data-stock="{{ $recoleccion->cantidad_disponible }}"
                                                    data-tipo="{{ $recoleccion->produccion->tipo_cacao }}">
                                                🌱 {{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }} -
                                                {{ $recoleccion->produccion->tipo_cacao }} |
                                                📅 {{ $recoleccion->fecha_recoleccion->format('d/m/Y') }} |
                                                📦 {{ number_format($recoleccion->cantidad_disponible, 2) }} kg disponibles
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay recolecciones con stock disponible</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <small id="stockInfo" class="form-text text-muted" style="font-size: 0.75rem;"></small>
                            </div>
                        </div>
                    </div>

                    <!-- Cliente -->
                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="cliente" class="form-label-professional" style="font-size: 0.8rem;">
                                    <i class="fas fa-user text-info"></i> Cliente <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control-professional" id="cliente" name="cliente"
                                       placeholder="Nombre del cliente" required style="font-size: 0.85rem;">
                            </div>

                            <div class="col-6">
                                <label for="telefono_cliente" class="form-label-professional" style="font-size: 0.8rem;">
                                    <i class="fas fa-phone text-warning"></i> Teléfono
                                </label>
                                <input type="text" class="form-control-professional" id="telefono_cliente" name="telefono_cliente"
                                       placeholder="Teléfono" style="font-size: 0.85rem;">
                            </div>
                        </div>
                    </div>

                    <!-- Detalles de Venta -->
                    <div class="mb-3" style="background: white; padding: 1rem; border-radius: 8px; border: 1px solid #e0e0e0;">
                        <h6 style="color: var(--cacao-primary); font-size: 0.9rem; margin-bottom: 0.8rem; font-weight: 600;">
                            <i class="fas fa-calculator me-2"></i>Detalles de Venta
                        </h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="cantidad_vendida" class="form-label-professional" style="font-size: 0.8rem;">
                                    <i class="fas fa-weight text-primary"></i> Cantidad (kg) <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control-professional" id="cantidad_vendida" name="cantidad_vendida"
                                       step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()" style="font-size: 0.85rem;">
                            </div>
                            <div class="col-6">
                                <label for="precio_por_kg" class="form-label-professional" style="font-size: 0.8rem;">
                                    <i class="fas fa-dollar-sign text-success"></i> Precio/kg ($) <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control-professional" id="precio_por_kg" name="precio_por_kg"
                                       step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()" style="font-size: 0.85rem;">
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-12 d-flex justify-content-center">
                                <div style="width: 70%;">
                                    <label for="total_venta" class="form-label-professional" style="font-size: 0.8rem;">
                                        <i class="fas fa-calculator text-success"></i> Total ($)
                                    </label>
                                    <input type="number" class="form-control-professional" id="total_venta" name="total_venta"
                                           readonly style="background: linear-gradient(135deg, #e8f5e8, #d4edda); font-weight: bold; color: #28a745; text-align: center; font-size: 1rem;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Pago -->
                    <div class="mb-3" style="background: white; padding: 1rem; border-radius: 8px; border: 1px solid #e0e0e0;">
                        <h6 style="color: var(--cacao-primary); font-size: 0.9rem; margin-bottom: 0.8rem; font-weight: 600; text-align: center;">
                            <i class="fas fa-credit-card me-2"></i>Información de Pago
                        </h6>
                        <div class="row g-2 justify-content-center">
                            <div class="col-5">
                                <label for="estado_pago" class="form-label-professional" style="font-size: 0.8rem;">
                                    <i class="fas fa-check-circle text-success"></i> Estado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select-professional" id="estado_pago" name="estado_pago" required style="font-size: 0.85rem;">
                                    <option value="pagado">✅ Pagado</option>
                                    <option value="pendiente">⏳ Pendiente</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="metodo_pago" class="form-label-professional" style="font-size: 0.8rem;">
                                    <i class="fas fa-money-bill text-info"></i> Método <span class="text-danger">*</span>
                                </label>
                                <select class="form-select-professional" id="metodo_pago" name="metodo_pago" required style="font-size: 0.85rem;">
                                    <option value="efectivo">💵 Efectivo</option>
                                    <option value="transferencia">🏦 Transferencia</option>
                                    <option value="cheque">📄 Cheque</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mt-2 justify-content-center">
                            <div class="col-10 text-center">
                                <label for="observaciones" class="form-label-professional" style="font-size: 0.8rem; display: block; text-align: center;">
                                    <i class="fas fa-sticky-note text-warning"></i> Observaciones
                                </label>
                                <textarea class="form-control-professional" id="observaciones" name="observaciones" rows="2"
                                          placeholder="Notas adicionales..." style="font-size: 0.8rem; resize: none; text-align: center; margin: 0 auto; max-width: 85%;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-top: 1px solid #dee2e6; padding: 0.8rem 1.2rem;">
                    <button type="button" class="btn btn-outline-professional btn-sm" data-bs-dismiss="modal" style="padding: 0.4rem 1rem; font-size: 0.85rem;">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-professional btn-sm" style="padding: 0.4rem 1.2rem; font-size: 0.85rem;">
                        <i class="fas fa-save me-1"></i>Guardar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Actualizar información de stock disponible
function actualizarStock() {
    const select = document.getElementById('recoleccion_id');
    const stockInfo = document.getElementById('stockInfo');
    const cantidadInput = document.getElementById('cantidad_vendida');

    if (select.value) {
        // Limpiar la información anterior
        stockInfo.innerHTML = '<i class="fas fa-spinner fa-spin text-primary"></i> Cargando información...';
        stockInfo.className = 'form-text text-info';
        cantidadInput.value = '';
        cantidadInput.placeholder = 'Cargando...';

        // Hacer petición AJAX para obtener detalles
        const url = `/ventas/obtener-detalle/${select.value}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const recoleccion = data.data;
                    const stock = parseFloat(recoleccion.cantidad_disponible);
                    const cantidadRecolectada = parseFloat(recoleccion.cantidad_recolectada);

                    // Mostrar información completa de la recolección
                    stockInfo.innerHTML = `
                        <div style="background: linear-gradient(135deg, #e8f5e8, #d4edda); padding: 0.8rem; border-radius: 8px; border: 2px solid #28a745; margin-top: 0.5rem;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.75rem;">
                                <div>
                                    <strong style="color: #1e7e34;">📦 Stock Disponible:</strong><br>
                                    <span style="font-size: 0.9rem; font-weight: bold; color: #155724;">${stock} kg</span>
                                </div>
                                <div>
                                    <strong style="color: #1e7e34;">🌾 Cantidad Recolectada:</strong><br>
                                    <span style="font-size: 0.9rem; font-weight: bold; color: #155724;">${cantidadRecolectada} kg</span>
                                </div>
                                <div>
                                    <strong style="color: #1e7e34;">🏷️ Lote:</strong><br>
                                    <span style="color: #155724;">${recoleccion.lote_nombre}</span>
                                </div>
                                <div>
                                    <strong style="color: #1e7e34;">🍫 Tipo de Cacao:</strong><br>
                                    <span style="color: #155724;">${recoleccion.tipo_cacao}</span>
                                </div>
                                <div style="grid-column: 1 / -1;">
                                    <strong style="color: #1e7e34;">📅 Fecha de Recolección:</strong>
                                    <span style="color: #155724; margin-left: 0.5rem;">${recoleccion.fecha_recoleccion}</span>
                                </div>
                            </div>
                        </div>
                    `;

                    // Configurar el campo de cantidad
                    cantidadInput.max = stock;
                    cantidadInput.placeholder = stock > 0 ? `Máximo ${stock} kg disponibles` : 'Sin stock disponible';

                    // Auto-llenar solo si hay stock disponible
                    if (stock > 0) {
                        // Si el stock es pequeño (≤ 50kg), auto-llenar
                        if (stock <= 50) {
                            cantidadInput.value = stock;
                            calcularTotal();

                            // Mostrar notificación discreta
                            const notification = document.createElement('div');
                            notification.innerHTML = `
                                <div style="background: #d1ecf1; color: #0c5460; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.7rem; margin-top: 0.3rem; border-left: 3px solid #17a2b8;">
                                    ✨ Cantidad auto-rellenada: ${stock} kg (stock completo)
                                </div>
                            `;
                            stockInfo.appendChild(notification.firstElementChild);

                            // Quitar la notificación después de 4 segundos
                            setTimeout(() => {
                                const notif = stockInfo.querySelector('div[style*="background: #d1ecf1"]');
                                if (notif) notif.remove();
                            }, 4000);
                        }

                        stockInfo.className = 'form-text text-success';
                    } else {
                        // Si no hay stock disponible
                        stockInfo.innerHTML += `
                            <div style="background: #f8d7da; color: #721c24; padding: 0.5rem; border-radius: 5px; margin-top: 0.5rem; border-left: 3px solid #dc3545;">
                                ⚠️ <strong>Sin stock disponible para venta</strong>
                            </div>
                        `;
                        stockInfo.className = 'form-text text-danger';
                        cantidadInput.disabled = true;
                    }
                } else {
                    stockInfo.innerHTML = `
                        <div style="background: #f8d7da; padding: 0.5rem; border-radius: 5px; border-left: 4px solid #dc3545;">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            <strong>Error:</strong> ${data.message}
                        </div>
                    `;
                    stockInfo.className = 'form-text text-danger';
                    cantidadInput.placeholder = '0.00';
                    cantidadInput.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error en la petición AJAX:', error);
                stockInfo.innerHTML = `
                    <div style="background: #f8d7da; padding: 0.5rem; border-radius: 5px; border-left: 4px solid #dc3545;">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                        <strong>Error de conexión:</strong> No se pudo cargar la información del lote
                    </div>
                `;
                stockInfo.className = 'form-text text-danger';
                cantidadInput.placeholder = '0.00';
                cantidadInput.disabled = false;
            });
    } else {
        stockInfo.innerHTML = '';
        cantidadInput.max = '';
        cantidadInput.value = '';
        cantidadInput.placeholder = '0.00';
        cantidadInput.disabled = false;
    }
}

// Calcular total de la venta
function calcularTotal() {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
    const precio = parseFloat(document.getElementById('precio_por_kg').value) || 0;
    const total = cantidad * precio;

    document.getElementById('total_venta').value = total.toFixed(2);

    // Validar que no exceda el stock
    const select = document.getElementById('recoleccion_id');
    if (select.value) {
        const option = select.options[select.selectedIndex];
        const stock = parseFloat(option.dataset.stock);

        if (cantidad > stock) {
            document.getElementById('cantidad_vendida').classList.add('is-invalid');
            document.getElementById('cantidad_vendida').setCustomValidity('La cantidad no puede exceder el stock disponible');
        } else {
            document.getElementById('cantidad_vendida').classList.remove('is-invalid');
            document.getElementById('cantidad_vendida').setCustomValidity('');
        }
    }
}

// Ver detalles de venta
function verDetalle(id) {
    // Implementar modal de detalles o redireccionar
    window.location.href = `/ventas/${id}`;
}

// Editar venta
function editarVenta(id) {
    // Implementar modal de edición o redireccionar
    window.location.href = `/ventas/${id}/edit`;
}

// Marcar como pagado
function marcarPagado(id) {
    Swal.fire({
        title: '¿Marcar como Pagado?',
        text: "Se actualizará el estado de pago de la venta",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, marcar como pagado',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/ventas/${id}/pagar`;
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Eliminar venta
function eliminarVenta(id) {
    Swal.fire({
        title: '¿Eliminar Venta?',
        text: "Esta acción no se puede deshacer. El stock se restaurará automáticamente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/ventas/${id}`;
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(csrfToken);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Auto-ocultar alertas después de 5 segundos
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(function() {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 500);
    });
}, 5000);

// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Agregar animaciones a las estadísticas
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in-up');
        }, index * 100);
    });

    // Agregar efectos hover a los botones
    const buttons = document.querySelectorAll('.btn-professional');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Función para formatear números en tiempo real
function formatearNumero(input) {
    let valor = input.value.replace(/[^\d.]/g, '');
    input.value = valor;
}

// Agregar formato a los campos numéricos
document.addEventListener('DOMContentLoaded', function() {
    const numericInputs = document.querySelectorAll('input[type="number"]');
    numericInputs.forEach(input => {
        input.addEventListener('input', function() {
            formatearNumero(this);
        });
    });
});

// Validación del formulario antes del envío
document.getElementById('ventaForm').addEventListener('submit', function(e) {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value);
    const select = document.getElementById('recoleccion_id');

    if (select.value) {
        const option = select.options[select.selectedIndex];
        const stock = parseFloat(option.dataset.stock);

        if (cantidad > stock) {
            e.preventDefault();
            Swal.fire({
                title: 'Error de Validación',
                text: `La cantidad a vender (${cantidad} kg) excede el stock disponible (${stock} kg)`,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return false;
        }
    }
});
</script>
@endpush
