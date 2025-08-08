@extends('layouts.masterr')

@section('content')
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
    background-color: var(--cacao-bg);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--cacao-text);
}

.container-fluid {
    padding: 1.5rem;
    max-width: 100%;
    margin: 0;
}

/* Título principal */
.main-title {
    color: var(--cacao-primary);
    font-size: 1.8rem;
    font-weight: 600;
    text-align: left;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--cacao-light);
    padding-bottom: 0.75rem;
}

/* Dashboard Cards */
.stats-card {
    background: linear-gradient(135deg, var(--cacao-white) 0%, #f8f9fa 100%);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
}

.stats-card .icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.stats-card .value {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-card .label {
    font-size: 0.9rem;
    color: var(--cacao-muted);
    font-weight: 500;
}

.stats-primary .icon {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
}

.stats-success .icon {
    background: linear-gradient(135deg, var(--success), #4caf50);
    color: var(--cacao-white);
}

.stats-warning .icon {
    background: linear-gradient(135deg, var(--warning), #ff9800);
    color: var(--cacao-white);
}

.stats-info .icon {
    background: linear-gradient(135deg, var(--info), #2196f3);
    color: var(--cacao-white);
}

/* Layout simplificado - sin sidebar */
.main-layout {
    width: 100%;
    margin-top: 1.5rem;
}

.content-area {
    width: 100%;
    min-width: 0;
}

.filter-card {
    display: none;
}

.filter-title {
    display: none;
}

.filter-group {
    display: none;
}

.filter-label {
    display: none;
}

.filter-option {
    display: none;
}

.filter-badge {
    display: none;
}

.filter-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--cacao-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border-bottom: 1px solid var(--cacao-light);
    padding-bottom: 0.5rem;
}

.filter-option {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 0.8rem;
    margin: 0.2rem 0;
    border: 1px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.85rem;
    color: var(--cacao-text);
}

.filter-option:hover {
    background-color: rgba(139, 111, 71, 0.05);
    border-color: var(--cacao-light);
}

.filter-option.active {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
    border-color: var(--cacao-primary);
}

.filter-option.active .filter-badge {
    background: rgba(255, 255, 255, 0.25);
    color: var(--cacao-white);
}

.filter-badge {
    background: var(--cacao-light);
    color: var(--cacao-primary);
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 600;
    min-width: 24px;
    text-align: center;
}

/* Tabla expandida */
.table-professional {
    margin: 0;
    font-size: 0.85rem;
}

.table-professional thead th {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
    padding: 0.9rem 0.6rem;
    font-weight: 600;
    font-size: 0.8rem;
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid var(--cacao-secondary);
    white-space: nowrap;
}

.table-professional tbody td {
    padding: 0.8rem 0.6rem;
    vertical-align: middle;
    border-color: var(--cacao-light);
    text-align: center;
    font-size: 0.8rem;
}

/* Botones principales */
.btn-professional {
    border: none;
    border-radius: 6px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-crear {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
    box-shadow: 0 2px 4px rgba(74, 55, 40, 0.2);
}

.btn-crear:hover {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(74, 55, 40, 0.25);
}

.btn-reporte {
    background-color: var(--cacao-accent);
    color: var(--cacao-white);
    box-shadow: 0 2px 4px rgba(139, 111, 71, 0.2);
}

.btn-reporte:hover {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(139, 111, 71, 0.25);
}

.btn-salida {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
    box-shadow: 0 2px 4px rgba(107, 78, 61, 0.2);
}

.btn-salida:hover {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(107, 78, 61, 0.25);
}

/* Tarjeta principal */
.main-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.card-header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    padding: 1.25rem 1.5rem;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
}

.card-title-professional {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Búsqueda discreta en la parte superior */
.search-container-top {
    position: relative;
    width: 280px;
}

.search-input-top {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.5rem 2.5rem 0.5rem 1rem;
    background: var(--cacao-white);
    font-size: 0.85rem;
    transition: all 0.2s ease;
    width: 100%;
}

.search-input-top:focus {
    border-color: var(--cacao-primary);
    box-shadow: 0 0 0 0.1rem rgba(139, 111, 71, 0.1);
    outline: none;
}

.search-icon {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--cacao-muted);
    font-size: 0.85rem;
    pointer-events: none;
}

/* Tabla */
.table-professional {
    margin: 0;
    font-size: 0.9rem;
}

.table-professional thead th {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
    padding: 1rem 0.75rem;
    font-weight: 600;
    font-size: 0.85rem;
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid var(--cacao-secondary);
}

.table-professional tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-color: var(--cacao-light);
    text-align: center;
}

.table-professional tbody tr {
    transition: background-color 0.15s ease;
}

.table-professional tbody tr:hover {
    background-color: rgba(139, 111, 71, 0.05);
}

/* Badges */
.badge-professional {
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-cantidad {
    background-color: var(--info);
    color: var(--cacao-white);
}

.badge-precio {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-optimo {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-vencer {
    background-color: var(--warning);
    color: var(--cacao-white);
}

.badge-restringido {
    background-color: var(--danger);
    color: var(--cacao-white);
}

.badge-fertilizante {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-pesticida {
    background-color: var(--warning);
    color: var(--cacao-white);
}

.badge-unidad {
    background-color: var(--cacao-muted);
    color: var(--cacao-white);
}

/* Botones de acción */
.btn-action {
    border: none;
    border-radius: 4px;
    padding: 0.4rem 0.8rem;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
    margin: 0 0.2rem;
}

.btn-edit {
    background-color: var(--warning);
    color: var(--cacao-white);
}

.btn-edit:hover {
    background-color: #ef6c00;
    color: var(--cacao-white);
}

.btn-delete {
    background-color: var(--danger);
    color: var(--cacao-white);
}

.btn-delete:hover {
    background-color: #b71c1c;
    color: var(--cacao-white);
}

/* Formularios */
.form-control-professional, .form-select-professional {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: border-color 0.2s ease;
    background: var(--cacao-white);
}

.form-control-professional:focus, .form-select-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.15rem rgba(139, 111, 71, 0.15);
    outline: none;
}

.form-label {
    font-weight: 500;
    color: var(--cacao-text);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

/* Modales */
.modal-content-professional {
    border: none;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.modal-header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    border-radius: 8px 8px 0 0;
    padding: 1.25rem 1.5rem;
    border-bottom: none;
}

.modal-footer-professional {
    background-color: #f8f9fa;
    border-radius: 0 0 8px 8px;
    padding: 1.25rem 1.5rem;
    border-top: 1px solid var(--cacao-light);
}

.btn-secondary-professional {
    background-color: #6c757d;
    color: var(--cacao-white);
    border: none;
}

.btn-secondary-professional:hover {
    background-color: #5a6268;
    color: var(--cacao-white);
}

.btn-primary-professional {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
}

.btn-primary-professional:hover {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
}

/* Estados responsivos */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }

    .main-title {
        font-size: 1.5rem;
        text-align: center;
    }

    .search-container-top {
        width: 200px;
    }

    .btn-professional {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
    }

    .table-professional {
        font-size: 0.75rem;
    }

    .table-professional thead th,
    .table-professional tbody td {
        padding: 0.6rem 0.4rem;
    }

    .stats-card .value {
        font-size: 1.5rem;
    }
}

/* Mensaje sin resultados */
.no-results {
    color: var(--cacao-muted);
    font-style: italic;
}

.no-results i {
    color: var(--cacao-light);
}

/* Success modals - más discretos */
.modal-success {
    border-radius: 8px;
    background: var(--cacao-white);
}

.success-icon {
    width: 60px;
    height: 60px;
    background-color: var(--success);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.success-title {
    color: var(--cacao-primary);
    font-weight: 600;
    margin-bottom: 1rem;
}

.success-text {
    color: var(--cacao-muted);
    margin-bottom: 1.5rem;
}
</style>

<div class="container-fluid">
    <h1 class="main-title">
        <i class="fas fa-boxes me-2"></i>
        Gestión de Inventario de Insumos
    </h1>

    <!-- Dashboard de Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ count($inventarios ?? []) }}</div>
                        <div class="label">Productos Totales</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ collect($inventarios ?? [])->where('estado', 'Óptimo')->count() }}</div>
                        <div class="label">Estado Óptimo</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ collect($inventarios ?? [])->where('estado', 'Por vencer')->count() }}</div>
                        <div class="label">Por Vencer</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">${{ number_format(collect($inventarios ?? [])->sum(function($item) { return $item->cantidad * $item->precio_unitario; }), 0, ',', '.') }}</div>
                        <div class="label">Valor Total Inventario</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de Acción y Búsqueda -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-professional btn-crear" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                <i class="fas fa-plus"></i>
                Nuevo Producto
            </button>
            <!-- Búsqueda discreta -->
            <div class="search-container-top">
                <input type="text" id="searchInput" class="form-control search-input-top" placeholder="Buscar producto...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('inventario.reporte') }}" class="btn btn-professional btn-reporte">
                <i class="fas fa-chart-line"></i>
                Ver Reportes
            </a>
            <a href="{{ route('inventario.salida') }}" class="btn btn-professional btn-salida">
                <i class="fas fa-arrow-right"></i>
                Salida Inventario
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="main-layout">
        <!-- Área de Contenido Principal -->
        <div class="content-area">
            <div class="card main-card">
                <div class="card-header card-header-professional">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title-professional">
                            <i class="fas fa-list-alt"></i>
                            Productos Registrados
                            <span class="badge bg-light text-dark ms-2" id="totalProductos">{{ count($inventarios ?? []) }}</span>
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-professional" id="inventoryTable">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i> ID</th>
                                    <th><i class="fas fa-tag me-1"></i> Producto</th>
                                    <th><i class="fas fa-calendar me-1"></i> Fecha</th>
                                    <th><i class="fas fa-weight-hanging me-1"></i> Cantidad</th>
                                    <th><i class="fas fa-ruler me-1"></i> Unidad</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i> Precio Unit.</th>
                                    <th><i class="fas fa-calculator me-1"></i> Valor Total</th>
                                    <th><i class="fas fa-layer-group me-1"></i> Tipo</th>
                                    <th><i class="fas fa-info-circle me-1"></i> Estado</th>
                                    <th><i class="fas fa-cogs me-1"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                        @if(isset($inventarios) && count($inventarios) > 0)
                            @foreach($inventarios as $producto)
                                <tr data-id="{{ $producto->id }}" data-tipo="{{ $producto->tipo }}" data-estado="{{ $producto->estado }}">
                                    <td>
                                        <div class="fw-bold">{{ $producto->id }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $producto->nombre }}</div>
                                        <small class="text-muted">Reg: {{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($producto->fecha_registro)->locale('es')->isoFormat('MMM') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-professional badge-cantidad">
                                            {{ number_format($producto->cantidad, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-professional badge-unidad">
                                            @if($producto->unidad_medida == 'kg')
                                                <i class="fas fa-weight me-1"></i>{{ $producto->unidad_medida }}
                                            @else
                                                <i class="fas fa-flask me-1"></i>{{ $producto->unidad_medida }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-professional badge-precio">
                                            ${{ number_format($producto->precio_unitario, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-professional" style="background-color: var(--info); color: white;">
                                            ${{ number_format($producto->cantidad * $producto->precio_unitario, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold" style="color: var(--cacao-accent);">
                                            @if($producto->tipo == 'Fertilizantes')
                                                <i class="fas fa-seedling me-1"></i>{{ $producto->tipo }}
                                            @else
                                                <i class="fas fa-shield-alt me-1"></i>{{ $producto->tipo }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($producto->estado == 'Óptimo')
                                            <span class="badge badge-professional badge-optimo">
                                                <i class="fas fa-check-circle me-1"></i>Óptimo
                                            </span>
                                        @elseif($producto->estado == 'Por vencer')
                                            <span class="badge badge-professional badge-vencer">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Por vencer
                                            </span>
                                        @else
                                            <span class="badge badge-professional badge-restringido">
                                                <i class="fas fa-times-circle me-1"></i>Restringido
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-action btn-edit edit-producto-btn" data-id="{{ $producto->id }}" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-action btn-delete delete-producto-btn" data-id="{{ $producto->id }}" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr id="noProductsRow">
                                <td colspan="10" class="text-center py-5">
                                    <div class="no-results">
                                        <i class="fas fa-boxes fa-3x mb-3"></i>
                                        <h5>No hay productos registrados</h5>
                                        <p>Comience creando su primer producto de inventario</p>
                                        <button class="btn btn-professional btn-crear" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                                            <i class="fas fa-plus me-2"></i>Agregar Primer Producto
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Información de totales -->
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Mostrando <span id="showingCount">{{ count($inventarios ?? []) }}</span> de <span id="totalCount">{{ count($inventarios ?? []) }}</span> productos
        </small>
        <small class="text-muted">
            <i class="fas fa-sync-alt me-1"></i>
            Última actualización: <span id="lastUpdate">{{ date('d/m/Y H:i') }}</span>
        </small>
    </div>
</div>

<!-- Nuevo Producto Modal -->
<div class="modal fade" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <form id="nuevoProductoForm">
                @csrf
                <div class="modal-header modal-header-professional">
                    <h5 class="modal-title fw-bold" id="nuevoProductoModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Agregar Nuevo Producto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nombre del Producto
                            </label>
                            <select class="form-select form-select-professional" id="nombre" name="nombre" required>
                                <option value="">Seleccione un producto...</option>
                                <optgroup label="🌱 FERTILIZANTES">
                                    <option value="Urea" data-tipo="Fertilizantes" data-unidad="kg">Urea</option>
                                    <option value="Cloruro de potasio" data-tipo="Fertilizantes" data-unidad="kg">Cloruro de potasio</option>
                                    <option value="Superfosfato triple" data-tipo="Fertilizantes" data-unidad="kg">Superfosfato triple</option>
                                    <option value="Fertilizante NPK 15-15-15" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante NPK 15-15-15</option>
                                    <option value="Fertilizante foliar Masteragro" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante foliar Masteragro</option>
                                    <option value="Compost orgánico" data-tipo="Fertilizantes" data-unidad="kg">Compost orgánico</option>
                                    <option value="Humus de lombriz" data-tipo="Fertilizantes" data-unidad="kg">Humus de lombriz</option>
                                </optgroup>
                                <optgroup label="�️ PESTICIDAS">
                                    <option value="Clorpirifos" data-tipo="Pesticidas" data-unidad="ml">Clorpirifos</option>
                                    <option value="Mancozeb" data-tipo="Pesticidas" data-unidad="ml">Mancozeb</option>
                                    <option value="Cobre" data-tipo="Pesticidas" data-unidad="ml">Cobre</option>
                                    <option value="Imidacloprid" data-tipo="Pesticidas" data-unidad="ml">Imidacloprid</option>
                                    <option value="Cipermetrina" data-tipo="Pesticidas" data-unidad="ml">Cipermetrina</option>
                                    <option value="Glifosato" data-tipo="Pesticidas" data-unidad="ml">Glifosato</option>
                                    <option value="Bacillus thuringiensis" data-tipo="Pesticidas" data-unidad="ml">Bacillus thuringiensis</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">
                                <i class="fas fa-layer-group me-2"></i>Tipo de Producto
                            </label>
                            <select class="form-select form-select-professional" id="tipo" name="tipo" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="Fertilizantes">🌱 Fertilizantes</option>
                                <option value="Pesticidas">�️ Pesticidas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="cantidad" class="form-label">
                                <i class="fas fa-weight-hanging me-2"></i>Cantidad
                            </label>
                            <input type="number" class="form-control form-control-professional" id="cantidad" name="cantidad" min="1" max="99999" placeholder="100" required>
                        </div>
                        <div class="col-md-4">
                            <label for="unidad_medida" class="form-label">
                                <i class="fas fa-ruler me-2"></i>Unidad de Medida
                            </label>
                            <select class="form-select form-select-professional" id="unidad_medida" name="unidad_medida" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="kg">⚖️ Kilogramos (kg)</option>
                                <option value="ml">🧪 Mililitros (ml)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="precio_unitario" class="form-label">
                                <i class="fas fa-dollar-sign me-2"></i>Precio Unitario
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control form-control-professional" id="precio_unitario" name="precio_unitario" min="0" max="999999" step="0.01" placeholder="25,500" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Estado del Producto
                            </label>
                            <select class="form-select form-select-professional" id="estado" name="estado" required>
                                <option value="Óptimo">✅ Óptimo</option>
                                <option value="Por vencer">⚠️ Por vencer</option>
                                <option value="Restringido">🔒 Restringido</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_registro" class="form-label">
                                <i class="fas fa-calendar me-2"></i>Fecha de Registro
                            </label>
                            <input type="date" class="form-control form-control-professional" id="fecha_registro" name="fecha_registro" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-professional">
                    <button type="button" class="btn btn-professional btn-secondary-professional" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-professional btn-primary-professional">
                        <i class="fas fa-save me-2"></i>Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Editar Producto Modal -->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <form id="editarProductoForm">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-professional">
                    <h5 class="modal-title fw-bold" id="editarProductoModalLabel">
                        <i class="fas fa-edit me-2"></i>Editar Producto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <input type="hidden" id="edit_id" name="id">
                    <div id="ajaxResponseEdit"></div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="edit_nombre" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nombre del Producto
                            </label>
                            <select class="form-select form-select-professional" id="edit_nombre" name="nombre" required>
                                <option value="">Seleccione un producto...</option>
                                <optgroup label="🌱 FERTILIZANTES">
                                    <option value="Urea" data-tipo="Fertilizantes" data-unidad="kg">Urea</option>
                                    <option value="Cloruro de potasio" data-tipo="Fertilizantes" data-unidad="kg">Cloruro de potasio</option>
                                    <option value="Superfosfato triple" data-tipo="Fertilizantes" data-unidad="kg">Superfosfato triple</option>
                                    <option value="Fertilizante NPK 15-15-15" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante NPK 15-15-15</option>
                                    <option value="Fertilizante foliar Masteragro" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante foliar Masteragro</option>
                                    <option value="Compost orgánico" data-tipo="Fertilizantes" data-unidad="kg">Compost orgánico</option>
                                    <option value="Humus de lombriz" data-tipo="Fertilizantes" data-unidad="kg">Humus de lombriz</option>
                                </optgroup>
                                <optgroup label="�️ PESTICIDAS">
                                    <option value="Clorpirifos" data-tipo="Pesticidas" data-unidad="ml">Clorpirifos</option>
                                    <option value="Mancozeb" data-tipo="Pesticidas" data-unidad="ml">Mancozeb</option>
                                    <option value="Cobre" data-tipo="Pesticidas" data-unidad="ml">Cobre</option>
                                    <option value="Imidacloprid" data-tipo="Pesticidas" data-unidad="ml">Imidacloprid</option>
                                    <option value="Cipermetrina" data-tipo="Pesticidas" data-unidad="ml">Cipermetrina</option>
                                    <option value="Glifosato" data-tipo="Pesticidas" data-unidad="ml">Glifosato</option>
                                    <option value="Bacillus thuringiensis" data-tipo="Pesticidas" data-unidad="ml">Bacillus thuringiensis</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_tipo" class="form-label">
                                <i class="fas fa-layer-group me-2"></i>Tipo de Producto
                            </label>
                            <select class="form-select form-select-professional" id="edit_tipo" name="tipo" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="Fertilizantes">🌱 Fertilizantes</option>
                                <option value="Pesticidas">�️ Pesticidas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_cantidad" class="form-label">
                                <i class="fas fa-weight-hanging me-2"></i>Cantidad
                            </label>
                            <input type="number" class="form-control form-control-professional" id="edit_cantidad" name="cantidad" min="1" max="99999" placeholder="100" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_unidad_medida" class="form-label">
                                <i class="fas fa-ruler me-2"></i>Unidad de Medida
                            </label>
                            <select class="form-select form-select-professional" id="edit_unidad_medida" name="unidad_medida" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="kg">⚖️ Kilogramos (kg)</option>
                                <option value="ml">🧪 Mililitros (ml)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_precio_unitario" class="form-label">
                                <i class="fas fa-dollar-sign me-2"></i>Precio Unitario
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control form-control-professional" id="edit_precio_unitario" name="precio_unitario" min="0" max="999999" step="0.01" placeholder="25,500" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_estado" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Estado del Producto
                            </label>
                            <select class="form-select form-select-professional" id="edit_estado" name="estado" required>
                                <option value="Óptimo">✅ Óptimo</option>
                                <option value="Por vencer">⚠️ Por vencer</option>
                                <option value="Restringido">🔒 Restringido</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fecha_registro" class="form-label">
                                <i class="fas fa-calendar me-2"></i>Fecha de Registro
                            </label>
                            <input type="date" class="form-control form-control-professional" id="edit_fecha_registro" name="fecha_registro" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-professional">
                    <button type="button" class="btn btn-professional btn-secondary-professional" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-professional btn-primary-professional">
                        <i class="fas fa-save me-2"></i>Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lista de Inventario Modal (CRUD) -->
<div class="modal fade" id="listaInventarioModal" tabindex="-1" aria-labelledby="listaInventarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-brown text-white border-0">
                <h5 class="modal-title fw-bold" id="listaInventarioModalLabel">
                    <i class="fas fa-clipboard-list me-2"></i>Lista Completa de Inventario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body bg-light p-0">
                <div class="p-3 bg-white border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-0 text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Gestión completa del inventario - Editar y eliminar productos
                            </h6>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                                <i class="fas fa-plus me-1"></i>Nuevo Producto
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle" id="tablaListaInventario">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-hashtag me-1"></i>ID
                                </th>
                                <th class="fw-bold">
                                    <i class="fas fa-tag me-1"></i>Producto
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-layer-group me-1"></i>Tipo
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-weight-hanging me-1"></i>Cantidad
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-ruler me-1"></i>Unidad
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-dollar-sign me-1"></i>Precio
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-calendar me-1"></i>Fecha
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-info-circle me-1"></i>Estado
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-cogs me-1"></i>Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider bg-white">
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="emptyInventoryState" class="text-center py-5 d-none">
                    <div class="mb-3">
                        <i class="fas fa-box-open fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No hay productos en el inventario</h5>
                    <p class="text-muted">Agregue productos para comenzar a gestionar el inventario</p>
                </div>
            </div>
            <div class="modal-footer bg-brown border-0">
                <button type="button" class="btn btn-light shadow-sm btn-lg" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Eliminar -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <div class="modal-header modal-header-professional" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <h5 class="modal-title fw-bold" id="confirmarEliminarModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="padding: 2rem;">
                <div class="mb-3">
                    <i class="fas fa-trash-alt fa-3x" style="color: #dc3545;"></i>
                </div>
                <h5 class="mb-3" style="color: var(--cacao-primary);">¿Está seguro de eliminar este producto?</h5>
                <p class="text-muted mb-4">
                    <strong id="nombreProductoEliminar">Nombre del producto</strong><br>
                    Esta acción no se puede deshacer.
                </p>
                <input type="hidden" id="productoEliminar">
                <div class="alert alert-warning" style="background: #fff3cd; border: none; border-left: 4px solid #ffc107;">
                    <i class="fas fa-info-circle me-2"></i>
                    Se eliminará permanentemente del inventario
                </div>
            </div>
            <div class="modal-footer modal-footer-professional">
                <button type="button" class="btn btn-professional btn-secondary-professional" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-professional" id="confirmarEliminarBtn" style="background-color: #dc3545; color: white; border: none;">
                    <i class="fas fa-trash me-2"></i>Eliminar Producto
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Éxito para Inventario Creado -->
<div class="modal fade" id="modalExitoInventario" tabindex="-1" aria-labelledby="modalExitoInventarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-content-professional" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
      <div class="modal-body text-center p-5" style="position: relative;">
        <!-- Decoración de fondo -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 30% 20%, rgba(111, 78, 55, 0.1) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(139, 69, 19, 0.1) 0%, transparent 50%); z-index: 1; border-radius: 8px;"></div>

        <!-- Contenido -->
        <div class="position-relative" style="z-index: 2;">
          <!-- Icono principal animado -->
          <div class="mb-4" style="animation: successBounce 1s ease-out;">
            <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary)); border-radius: 50%; box-shadow: 0 10px 25px rgba(111, 78, 55, 0.4);">
              <i class="fas fa-check text-white" style="font-size: 2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
            </div>
          </div>

          <!-- Título -->
          <h4 class="fw-bold mb-3" style="color: var(--cacao-primary); animation: fadeInUp 0.8s ease-out 0.2s both;">
            ¡Inventario Actualizado Exitosamente!
          </h4>

          <!-- Descripción -->
          <p class="text-muted mb-4" style="font-size: 1.1rem; animation: fadeInUp 0.8s ease-out 0.4s both;">
            El producto ha sido registrado correctamente en el sistema.
          </p>

          <!-- Icono decorativo -->
          <div style="animation: fadeInUp 0.8s ease-out 0.6s both;">
            <i class="fas fa-boxes" style="font-size: 2.5rem; color: var(--cacao-accent);"></i>
          </div>

          <!-- Contador automático -->
          <div class="mt-3" style="animation: fadeInUp 0.8s ease-out 0.8s both;">
            <small class="text-muted">
              <i class="fas fa-clock me-1"></i>
              Recargando página en <span id="countdownInventario">3</span> segundos...
            </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Success Notification Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <div class="modal-header modal-header-professional" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); text-align: center;">
                <div class="w-100">
                    <div class="mb-2">
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                    <h5 class="modal-title fw-bold" id="successModalLabel">¡Operación Exitosa!</h5>
                </div>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-0 text-muted" id="successMessage">La operación se completó correctamente.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Color café personalizado - Color café real como en la imagen */
:root {
    --brown-color: #6F4E37;  /* Café oscuro real */
    --brown-hover: #8B4513;  /* Café medio */
    --brown-light: #A0522D;  /* Café claro */
    --brown-dark: #5D4037;   /* Café muy oscuro */
    --brown-cream: #D7CCC8;  /* Crema café */
    --brown-beige: #EFEBE9;  /* Beige café */
}

.bg-brown {
    background: linear-gradient(135deg, var(--brown-color), var(--brown-hover)) !important;
    border: none !important;
}

.text-brown {
    color: var(--brown-color) !important;
}

.border-brown {
    border-color: var(--brown-color) !important;
    border-width: 2px !important;
}

.btn-brown {
    background: linear-gradient(135deg, var(--brown-color), var(--brown-hover));
    border: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    box-shadow: 0 4px 12px rgba(111, 78, 55, 0.3);
}

.btn-brown:hover {
    background: linear-gradient(135deg, var(--brown-hover), var(--brown-light));
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(111, 78, 55, 0.4);
}

.btn-brown:focus, .btn-brown:active {
    background: linear-gradient(135deg, var(--brown-hover), var(--brown-light));
    border: none;
    color: white;
    box-shadow: 0 0 0 0.2rem rgba(111, 78, 55, 0.25);
}

/* Botones con mejor hover */
.btn {
    transition: all 0.3s ease;
    border-radius: 8px;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-lg {
    padding: 12px 30px;
    font-size: 1.1rem;
}

/* Cards con gradientes suaves */
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3) !important;
}

.bg-gradient-brown {
    background: linear-gradient(45deg, var(--brown-color), var(--brown-hover)) !important;
}

/* Alertas mejoradas */
.alert {
    border: none;
    border-left: 4px solid;
    border-radius: 12px;
}

.alert-success {
    border-left-color: #28a745;
    background-color: #d4edda;
}

.alert-warning {
    border-left-color: #ffc107;
    background-color: #fff3cd;
}

/* Formularios mejorados */
.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    padding: 12px 16px;
}

.form-control:focus, .form-select:focus {
    border-color: var(--brown-color);
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
}

.border-brown:focus {
    border-color: var(--brown-hover) !important;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25) !important;
}

/* Modales mejorados */
.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    padding: 20px 25px;
}

.modal-body {
    padding: 25px;
}

.modal-footer {
    padding: 20px 25px;
}

/* Tablas mejoradas */
.table {
    border-radius: 12px;
    overflow: hidden;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid var(--brown-color);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    padding: 15px 12px;
}

.table-hover tbody tr:hover {
    background-color: rgba(139, 69, 19, 0.05);
}

/* Input groups mejorados */
.input-group-text {
    border-radius: 8px 0 0 8px;
    border: 2px solid #e9ecef;
    border-right: none;
    font-weight: 600;
}

.input-group .form-control {
    border-radius: 0 8px 8px 0;
    border-left: none;
}

/* Badges de estado */
.badge {
    font-size: 0.8rem;
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 500;
}

/* Selectores organizados */
optgroup {
    font-weight: bold;
    padding: 8px 0;
}

optgroup option {
    font-weight: normal;
    padding-left: 15px;
}

/* Animaciones suaves */
.fade {
    transition: opacity 0.3s ease;
}

/* Sombras mejoradas */
.shadow-lg {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

.shadow-sm {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
}

/* Ocultar mensajes de error automáticamente */
.alert-danger {
    display: none !important;
}

.alert-error {
    display: none !important;
}

/* Ocultar cualquier error de validación */
.is-invalid {
    border-color: #6F4E37 !important;
}

.invalid-feedback {
    display: none !important;
}

/* Estados de carga */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Estilos para búsqueda mejorada */
#searchInput {
    transition: all 0.3s ease;
}

#searchInput:focus {
    border-color: #6F4E37 !important;
    box-shadow: 0 0 0 0.2rem rgba(111, 78, 55, 0.25) !important;
    transform: scale(1.02);
}

.search-container-top.search-focused {
    transform: scale(1.02);
}

.search-container-top.search-focused .search-icon {
    color: var(--cacao-primary) !important;
    cursor: pointer;
}

.search-highlight, mark.search-highlight {
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.08), rgba(139, 111, 71, 0.12)) !important;
    color: var(--cacao-primary) !important;
    font-weight: 500;
    padding: 1px 2px;
    border-radius: 2px;
    border: none;
    transition: all 0.2s ease;
}

.search-highlight:hover, mark.search-highlight:hover {
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.12), rgba(139, 111, 71, 0.18)) !important;
}

/* Efecto cuando no hay resultados */
.no-results-row {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Mejorar icono de búsqueda */
.search-icon {
    transition: all 0.2s ease;
    cursor: pointer;
}

.search-icon:hover {
    color: var(--cacao-primary) !important;
    transform: scale(1.1);
}

/* Responsive */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 10px;
    }

    .btn-lg {
        padding: 10px 20px;
        font-size: 1rem;
    }

    .modal-header, .modal-body, .modal-footer {
        padding: 15px 20px;
    }
}

/* Animaciones para modal de éxito */
@keyframes successBounce {
  0% {
    transform: scale(0.3) rotate(-10deg);
    opacity: 0;
  }
  50% {
    transform: scale(1.1) rotate(5deg);
    opacity: 0.8;
  }
  70% {
    transform: scale(0.95) rotate(-2deg);
    opacity: 0.9;
  }
  100% {
    transform: scale(1) rotate(0deg);
    opacity: 1;
  }
}

@keyframes fadeInUp {
  0% {
    transform: translateY(30px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
}
</style>
    background-color: rgba(40, 167, 69, 0.1);
}

.alert-danger {
    border-left-color: #dc3545;
    background-color: rgba(220, 53, 69, 0.1);
}

/* Create product button special effect */
.btn-create-product {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24) !important;
    color: white !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 12px 30px !important;
    font-weight: 600 !important;
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4) !important;
    transition: all 0.4s ease !important;
}

.btn-create-product:hover {
    background: linear-gradient(135deg, #ee5a24, #e55039) !important;
    box-shadow: 0 12px 35px rgba(255, 107, 107, 0.6) !important;
    transform: translateY(-3px) scale(1.05) !important;
    color: white !important;
}

/* Modales mejorados */
.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    border-bottom: none;
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(0,0,0,0.1);
    padding: 1.5rem;
}

/* Estilo para badges de estado */
.badge {
    font-size: 0.8em;
    padding: 0.375rem 0.75rem;
}

/* Animaciones suaves */
.table tr {
    transition: all 0.2s ease;
}

.table tr:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Animaciones para actualizaciones en tiempo real */
.table-warning {
    background-color: rgba(255, 193, 7, 0.15) !important;
    transition: all 0.3s ease !important;
}

.table-success {
    background-color: rgba(25, 135, 84, 0.15) !important;
    transition: all 0.3s ease !important;
}

.updating-row {
    animation: updatePulse 1s ease-in-out;
}

@keyframes updatePulse {
    0% { background-color: transparent; }
    50% { background-color: rgba(111, 78, 55, 0.1); }
    100% { background-color: transparent; }
}

/* Efecto de actualización en tiempo real */
.real-time-update {
    position: relative;
    overflow: hidden;
}

.real-time-update::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(111, 78, 55, 0.3), transparent);
    animation: realTimeShine 2s ease-in-out;
}

@keyframes realTimeShine {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Estilos específicos para modal estilo café/lotes */
.modal-cafe .form-control:focus,
.modal-cafe .form-select:focus {
    border-color: #8B4513 !important;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25) !important;
}

.modal-cafe .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.modal-cafe .form-control:disabled,
.modal-cafe .form-select:disabled,
.modal-cafe .form-control:read-only,
.modal-cafe .form-select:read-only,
.modal-cafe textarea:disabled {
    background-color: #f8f9fa !important;
    border-color: #D7CCC8 !important;
    color: #6c757d !important;
    cursor: not-allowed !important;
}

.modal-cafe .btn-cafe-primary {
    background: linear-gradient(135deg, #6F4E37, #8B4513);
    color: white;
    border: none;
    transition: all 0.3s ease;
}

.modal-cafe .btn-cafe-primary:hover {
    background: linear-gradient(135deg, #8B4513, #A0522D);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(111, 78, 55, 0.4);
}
</style>
@endpush

@section('scripts')
<script>
// Configurar CSRF token para AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

$(document).ready(function() {
    // Limpiar errores
    function limpiarErrores() { $('.alert-danger, .alert-error, .invalid-feedback').hide().remove(); $('.is-invalid').removeClass('is-invalid'); $('#ajaxResponse, #ajaxResponseEdit').empty(); }
    limpiarErrores(); $('.modal').on('show.bs.modal', limpiarErrores); setInterval(limpiarErrores, 2000);

    // Fecha actual
    const hoy = new Date().toISOString().split('T')[0];
    function setFecha() { $('#fecha_registro, #edit_fecha_registro').val(hoy); }
    setFecha(); $('#nuevoProductoModal, #editarProductoModal').on('show.bs.modal', setFecha);

    // Limpieza de modales
    $('#nuevoProductoModal').on('hidden.bs.modal', function() { $(this).find('form')[0].reset(); $(this).find('.is-invalid').removeClass('is-invalid'); $('#ajaxResponse').empty(); });
    $('#editarProductoModal').on('hidden.bs.modal', function() { $(this).find('.is-invalid').removeClass('is-invalid'); $('#ajaxResponseEdit').empty(); });
    $('#confirmarEliminarModal').on('hidden.bs.modal', function() { $('#productoEliminar').val(''); $('#nombreProductoEliminar').text(''); });
    $('.modal').on('hide.bs.modal', function() { $('body').removeClass('modal-open'); $('.modal-backdrop').remove(); });

    // Auto-asignación tipo/unidad
    function configurarAutoasignacion(nombre, tipo, unidad) {
        $(nombre).on('change', function() {
            const option = $(this).find('option:selected');
            const tipoVal = option.data('tipo'), unidadVal = option.data('unidad');
            if (tipoVal && unidadVal) {
                $(tipo).prop('disabled', false).val(tipoVal).prop('disabled', true);
                $(unidad).prop('disabled', false).val(unidadVal).prop('disabled', true);
            }
        });
    }
    configurarAutoasignacion('#nombre', '#tipo', '#unidad_medida');
    configurarAutoasignacion('#edit_nombre', '#edit_tipo', '#edit_unidad_medida');

    // Validaciones y funciones auxiliares
    $('#cantidad, #edit_cantidad').on('input', function() { if ($(this).val().length > 5) $(this).val($(this).val().slice(0, 5)); });
    $('#precio_unitario, #edit_precio_unitario').on('input', function() { if ($(this).val().length > 6) $(this).val($(this).val().slice(0, 6)); });

    function mostrarModalExito() { $('.modal-backdrop').remove(); $('body').removeClass('modal-open'); new bootstrap.Modal(document.getElementById('modalExitoInventario')).show(); setTimeout(() => window.location.reload(), 1500); }
    window.actualizarTiempoReal = function() { const ahora = new Date(); $('#lastUpdate').text(ahora.toLocaleDateString('es-ES') + ' ' + ahora.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})); };
    setInterval(window.actualizarTiempoReal, 30000);

    // Editar producto
    $(document).on('click', '.edit-producto-btn', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const btn = $(this);
        const originalText = btn.html();

        btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
        limpiarErrores();

        $.ajax({
            url: `{{ url('/inventario') }}/${id}`,
            type: 'GET',
            success: function(producto) {
                $('#edit_id').val(producto.id);
                $('#edit_nombre').val(producto.nombre);
                $('#edit_cantidad').val(producto.cantidad);
                $('#edit_precio_unitario').val(producto.precio_unitario);
                $('#edit_estado').val(producto.estado);
                $('#edit_fecha_registro').val(producto.fecha_registro);

                const option = $(`#edit_nombre option[value="${producto.nombre}"]`);
                const tipo = option.data('tipo') || producto.tipo;
                const unidad = option.data('unidad') || producto.unidad_medida;

                if (tipo && unidad) {
                    $('#edit_tipo').prop('disabled', false).val(tipo).prop('disabled', true);
                    $('#edit_unidad_medida').prop('disabled', false).val(unidad).prop('disabled', true);
                }

                btn.html(originalText).prop('disabled', false);
                new bootstrap.Modal(document.getElementById('editarProductoModal')).show();
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                btn.html(originalText).prop('disabled', false);
                alert('Error al cargar los datos del producto. Intente nuevamente.');
            }
        });
    });

    // Guardar edición
    $('#editarProductoForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const id = $('#edit_id').val();
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();

        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Actualizando...').prop('disabled', true);

        // Habilitar campos para enviar
        $('#edit_tipo, #edit_unidad_medida').prop('disabled', false);

        $.ajax({
            url: `{{ url('/inventario') }}/${id}`,
            method: 'PUT',
            data: form.serialize(),
            success: function(response) {
                submitBtn.html(originalText).prop('disabled', false);
                bootstrap.Modal.getInstance(document.getElementById('editarProductoModal')).hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                mostrarModalExito();
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                submitBtn.html(originalText).prop('disabled', false);
                $('#edit_tipo, #edit_unidad_medida').prop('disabled', true);
                alert('Error al actualizar el producto. Verifique los datos e intente nuevamente.');
            }
        });
    });

    // Eliminar producto
    $(document).on('click', '.delete-producto-btn', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        const nombre = row.find('td').eq(0).text().trim();

        $('#productoEliminar').val(id);
        $('#nombreProductoEliminar').text(nombre);
        new bootstrap.Modal(document.getElementById('confirmarEliminarModal')).show();
    });

    $('#confirmarEliminarBtn').on('click', function() {
        const id = $('#productoEliminar').val();
        const btn = $(this);
        const originalText = btn.html();

        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Eliminando...').prop('disabled', true);

        $.ajax({
            url: `{{ url('/inventario') }}/${id}`,
            method: 'DELETE',
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('confirmarEliminarModal')).hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                btn.html(originalText).prop('disabled', false);
                mostrarModalExito();
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                bootstrap.Modal.getInstance(document.getElementById('confirmarEliminarModal')).hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                btn.html(originalText).prop('disabled', false);
                alert('Error al eliminar el producto. Intente nuevamente.');
            }
        });
    });

    // Agregar producto
    $('#nuevoProductoForm').on('submit', function(e) {
        e.preventDefault(); const form = $(this), submitBtn = form.find('button[type="submit"]'), originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Guardando...').prop('disabled', true); $('#tipo, #unidad_medida').prop('disabled', false);
        $.ajax({
            url: '{{ route("inventario.store") }}', method: 'POST', data: form.serialize(),
            success: function() { submitBtn.html(originalText).prop('disabled', false); $('#tipo, #unidad_medida').prop('disabled', true);
                bootstrap.Modal.getInstance(document.getElementById('nuevoProductoModal')).hide(); form[0].reset(); mostrarModalExito(); },
            error: function() { submitBtn.html(originalText).prop('disabled', false); $('#tipo, #unidad_medida').prop('disabled', true); setTimeout(() => window.location.reload(), 1000); }
        });
    });

    // Variables globales para búsqueda simple
    let searchTerm = '';

    // Función para filtrar tabla - solo búsqueda
    function filtrarTablaSimple() {
        let visibleCount = 0;
        const rows = $('#inventoryTable tbody tr[data-id]');

        rows.each(function() {
            const row = $(this);
            const texto = row.text().toLowerCase();

            const mostrar = !searchTerm || texto.includes(searchTerm.toLowerCase());

            if (mostrar) {
                row.show();
                visibleCount++;
            } else {
                row.hide();
            }
        });

        // Actualizar contador
        const totalCount = rows.length;
        $('#totalProductos').text(visibleCount);

        // Mostrar mensaje si no hay resultados
        $('#noResultsMessage').remove();
        if (visibleCount === 0 && totalCount > 0 && searchTerm) {
            $('#inventoryTable tbody').append(`
                <tr id="noResultsMessage">
                    <td colspan="10" class="text-center py-5">
                        <div class="no-results">
                            <i class="fas fa-search-minus fa-3x mb-3 text-muted"></i>
                            <h5 class="text-muted">No se encontraron productos</h5>
                            <p class="text-muted">No hay productos que coincidan con "${searchTerm}"</p>
                            <button class="btn btn-professional btn-sm" onclick="limpiarBusqueda()">
                                <i class="fas fa-undo me-1"></i>Limpiar Búsqueda
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        }
    }

    // Búsqueda simple
    $('#searchInput').on('input', function() {
        searchTerm = $(this).val();
        filtrarTablaSimple();
    });

    // Limpiar búsqueda
    window.limpiarBusqueda = function() {
        searchTerm = '';
        $('#searchInput').val('');
        $('#noResultsMessage').remove();
        filtrarTablaSimple();
    };

    // Exportar tabla - solo productos visibles
    window.exportarTabla = function() {
        let csv = 'ID,Producto,Fecha,Cantidad,Unidad,Precio,Valor Total,Tipo,Estado\n';

        $('#inventoryTable tbody tr[data-id]:visible').each(function() {
            const cells = $(this).find('td');
            const row = [
                cells.eq(0).text().trim(),
                cells.eq(1).text().trim().replace(/\n/g, ' '),
                cells.eq(2).text().trim().replace(/\n/g, ' '),
                cells.eq(3).text().trim(),
                cells.eq(4).text().trim(),
                cells.eq(5).text().trim(),
                cells.eq(6).text().trim(),
                cells.eq(7).text().trim(),
                cells.eq(8).text().trim()
            ];
            csv += row.map(cell => `"${cell}"`).join(',') + '\n';
        });

        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `inventario_${new Date().toISOString().split('T')[0]}.csv`;
        link.click();
        window.URL.revokeObjectURL(url);
    };

    // Búsqueda simple original (comentado para usar la nueva)
    // $('#searchInput').on('input', function() {
    //     const term = $(this).val().toLowerCase(); $('#noResultsMessage').remove(); let visibleCount = 0;
    //     $('#inventoryTable tbody tr[data-id]').each(function() {
    //         const row = $(this), text = row.text().toLowerCase(), matches = text.includes(term) || term === '';
    //         row.toggle(matches); if (matches) visibleCount++;
    //     });
    //     if (visibleCount === 0 && term !== '') {
    //         $('#inventoryTable tbody').append(`<tr id="noResultsMessage"><td colspan="8" class="text-center py-4"><i class="fas fa-search-minus fa-2x text-muted mb-2"></i><h6 class="text-muted">No se encontraron productos</h6><button class="btn btn-sm btn-brown" onclick="$('#searchInput').val('').trigger('input')">Limpiar</button></td></tr>`);
    //     }
    //     const total = $('#inventoryTable tbody tr[data-id]').length; $('#totalProductos').text(term === '' ? total : `${visibleCount} de ${total}`);
    // });

    // Funcionalidad de búsqueda mejorada - Búsqueda inteligente por cualquier parte del texto
    $('#searchInput').on('input keyup', function() {
        const searchTerm = $(this).val().toLowerCase().trim();
        let visibleCount = 0;
        let foundResults = false;

        // Limpiar mensajes anteriores
        $('#noResultsMessage').remove();

        // Si no hay texto de búsqueda, mostrar todas las filas
        if (searchTerm === '') {
            $('#inventoryTable tbody tr[data-id]').show();
            const totalRows = $('#inventoryTable tbody tr[data-id]').length;
            $('#totalProductos').text(totalRows);
            $('#showingCount').text(totalRows);
            $('#totalCount').text(totalRows);
            return;
        }

        // Filtrar filas basado en el texto de búsqueda
        $('#inventoryTable tbody tr[data-id]').each(function() {
            const row = $(this);

            // Obtener texto de las columnas principales para búsqueda
            const productName = row.find('td:nth-child(2) .fw-bold').text().toLowerCase();
            const productType = row.find('td:nth-child(8)').text().toLowerCase();
            const productState = row.find('td:nth-child(9)').text().toLowerCase();
            const productId = row.find('td:nth-child(1)').text().toLowerCase();

            // Búsqueda inteligente: buscar en cualquier parte del texto
            const searchInName = productName.includes(searchTerm);
            const searchInType = productType.includes(searchTerm);
            const searchInState = productState.includes(searchTerm);
            const searchInId = productId.includes(searchTerm);

            // También buscar por palabras separadas
            const nameWords = productName.split(' ');
            const searchInWords = nameWords.some(word => word.startsWith(searchTerm) || word.includes(searchTerm));

            if (searchInName || searchInType || searchInState || searchInId || searchInWords) {
                row.show();
                visibleCount++;
                foundResults = true;

                // Resaltar el texto coincidente
                highlightSearchText(row, searchTerm);
            } else {
                row.hide();
            }
        });

        // Mostrar mensaje si no hay resultados
        if (!foundResults && searchTerm !== '') {
            const noResultsRow = `
                <tr id="noResultsMessage" class="no-results-row">
                    <td colspan="10" class="text-center py-5">
                        <div class="no-results">
                            <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                            <h5 class="text-muted">No se encontraron productos</h5>
                            <p class="text-muted mb-3">No hay productos que coincidan con "<strong>${searchTerm}</strong>"</p>
                            <small class="text-muted mb-3">
                                💡 <strong>Sugerencias:</strong><br>
                                • Intente con menos letras<br>
                                • Busque por tipo: "fertilizante" o "pesticida"<br>
                                • Busque por estado: "óptimo", "vencer", "restringido"
                            </small><br>
                            <button class="btn btn-professional btn-sm" onclick="$('#searchInput').val('').trigger('input')">
                                <i class="fas fa-times me-1"></i>Limpiar búsqueda
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            $('#inventoryTable tbody').append(noResultsRow);
        }

        // Actualizar contadores
        const totalRows = $('#inventoryTable tbody tr[data-id]').length;
        $('#totalProductos').text(`${visibleCount} de ${totalRows}`);
        $('#showingCount').text(visibleCount);
        $('#totalCount').text(totalRows);
    });

    // Función para resaltar texto coincidente - mejorada
    function highlightSearchText(row, searchTerm) {
        // Limpiar resaltados anteriores
        row.find('mark.search-highlight').each(function() {
            $(this).replaceWith($(this).text());
        });

        row.find('td').each(function() {
            const cell = $(this);

            // Resaltar en el nombre del producto (columna principal)
            const nameCell = cell.find('.fw-bold');
            if (nameCell.length > 0) {
                let nameText = nameCell.text();
                const regex = new RegExp(`(${searchTerm})`, 'gi');

                if (nameText.toLowerCase().includes(searchTerm)) {
                    const highlightedText = nameText.replace(regex, '<mark class="search-highlight">$1</mark>');
                    nameCell.html(highlightedText);
                }
            }

            // Resaltar en otras celdas de texto
            const cellText = cell.text();
            if (cellText.toLowerCase().includes(searchTerm) && !cell.find('.fw-bold').length && !cell.find('.badge').length) {
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                const highlightedText = cellText.replace(regex, '<mark class="search-highlight">$1</mark>');
                cell.html(highlightedText);
            }
        });
    }

    // Limpiar búsqueda con clic en icono
    $('.search-icon').on('click', function() {
        $('#searchInput').val('').trigger('input').focus();
    });

    // Atajos de teclado para búsqueda
    $(document).on('keydown', function(e) {
        // Ctrl + F para enfocar búsqueda
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            $('#searchInput').focus().select();
        }

        // Escape para limpiar búsqueda
        if (e.key === 'Escape' && $('#searchInput').is(':focus')) {
            $('#searchInput').val('').trigger('input');
        }
    });

    // Mejorar experiencia visual del campo de búsqueda
    $('#searchInput').on('focus', function() {
        $(this).parent('.search-container-top').addClass('search-focused');
        $(this).attr('placeholder', 'Escriba para buscar...');
    }).on('blur', function() {
        $(this).parent('.search-container-top').removeClass('search-focused');
        $(this).attr('placeholder', 'Buscar producto...');
    });

    // Botón búsqueda
    $('#searchBtn').on('click', function() { const input = $('#searchInput'); input.val() === '' ? input.focus() : input.val('').trigger('input').focus(); });

    // Limpiar modales
    $('.modal').on('hidden.bs.modal', function() { $(this).find('form')[0]?.reset(); $(this).find('.is-invalid').removeClass('is-invalid'); $('.modal-backdrop').remove(); $('body').removeClass('modal-open'); });
});
</script>
@endsection
