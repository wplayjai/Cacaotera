@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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

.stats-card-dark {
    background: linear-gradient(135deg, #424242, #212121);
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
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid var(--cacao-secondary);
    white-space: nowrap;
}

.table-professional tbody td {
    padding: 0.9rem 0.8rem;
    vertical-align: middle;
    border-color: var(--cacao-light);
    text-align: center;
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
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.badge-fertilizante {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-pesticida {
    background-color: var(--warning);
    color: var(--cacao-white);
}

.badge-optimo {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-por-vencer {
    background-color: var(--warning);
    color: var(--cacao-white);
}

.badge-restringido {
    background-color: var(--danger);
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

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Estado vacío profesional */
.empty-state {
    text-align: center;
    padding: 2rem 1.5rem;
    color: var(--cacao-muted);
}

.empty-state-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.6;
}

.empty-state h5 {
    color: var(--cacao-primary);
    margin-bottom: 0.8rem;
    font-size: 1.1rem;
}
</style>

<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title text-white mb-2">
                        <i class="fas fa-chart-bar me-2"></i>Reportes de Inventario
                    </h1>
                    <p class="main-subtitle text-white-50 mb-0">
                        Análisis completo de tu inventario de insumos cacaoteros
                    </p>
                    
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="breadcrumb-professional">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('inventario.index') }}">
                                    <i class="fas fa-boxes me-1"></i>Inventario
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-chart-line me-1"></i>Reportes
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <a href="{{ route('inventario.reporte.pdf', request()->all()) }}" 
                       class="btn btn-danger-professional">
                        <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                    </a>
                </div>
            </div>
        </div>
        <!-- Filtros profesionales -->
        <div class="filters-card fade-in-up">
            <form method="GET" action="{{ route('inventario.reporte') }}">
                <div class="row align-items-end">
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-calendar-alt"></i>Fecha Desde
                        </label>
                        <input type="date" 
                               name="fecha_desde" 
                               class="form-control-professional" 
                               value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-calendar-alt"></i>Fecha Hasta
                        </label>
                        <input type="date" 
                               name="fecha_hasta" 
                               class="form-control-professional" 
                               value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-layer-group"></i>Tipo
                        </label>
                        <select name="tipo" class="form-select-professional">
                            <option value="">Todos</option>
                            <option value="Fertilizantes" {{ request('tipo') == 'Fertilizantes' ? 'selected' : '' }}>Fertilizantes</option>
                            <option value="Pesticidas" {{ request('tipo') == 'Pesticidas' ? 'selected' : '' }}>Pesticidas</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-search"></i>Buscar Producto
                        </label>
                        <input type="text" 
                               name="search" 
                               class="form-control-professional" 
                               placeholder="Nombre del producto..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-1 col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary-professional w-100">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                    <div class="col-lg-1 col-md-3 mb-3">
                        <a href="{{ route('inventario.reporte') }}" class="btn btn-outline-professional w-100">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                    <div class="col-lg-1 col-md-6 mb-3">
                        <a href="{{ route('inventario.index') }}" class="btn btn-success-professional w-100">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Estadísticas principales - Compactas -->
        <div class="row mb-4 justify-content-center">
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="stats-card stats-card-info">
                    <div class="card-body py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number fs-3 fw-bold mb-1">{{ $totalSalidas }}</div>
                                <div class="stats-label small text-white-50">Total Salidas</div>
                            </div>
                            <div>
                                <i class="fas fa-sign-out-alt fs-2 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="stats-card stats-card-dark">
                    <div class="card-body py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number fs-3 fw-bold mb-1">${{ number_format($valorTotalSalidas, 2) }}</div>
                                <div class="stats-label small text-white-50">Valor Total</div>
                            </div>
                            <div>
                                <i class="fas fa-chart-line fs-2 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de productos -->
        @if($inventarios->count() > 0)
            <div class="section-card">
                <div class="section-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-list me-2"></i>
                        <span>Listado de Productos</span>
                    </div>
                    <span class="badge bg-white text-dark">{{ $inventarios->count() }} registros</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-professional table-hover mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                    <th><i class="fas fa-tag me-1"></i>Nombre</th>
                                    <th><i class="fas fa-layer-group me-1"></i>Tipo</th>
                                    <th><i class="fas fa-weight me-1"></i>Cantidad</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i>Precio Unit.</th>
                                    <th><i class="fas fa-calculator me-1"></i>Valor Total</th>
                                    <th><i class="fas fa-thermometer-half me-1"></i>Estado</th>
                                    <th><i class="fas fa-calendar me-1"></i>Fecha Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventarios as $producto)
                                    <tr>
                                        <td><span class="fw-bold">{{ $producto->id }}</span></td>
                                        <td>
                                            <div class="text-start">
                                                <strong class="text-dark">{{ $producto->nombre }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @if($producto->tipo == 'Fertilizantes')
                                                <span class="badge badge-fertilizante badge-professional">🌱 {{ $producto->tipo }}</span>
                                            @else
                                                <span class="badge badge-pesticida badge-professional">🛡️ {{ $producto->tipo }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $producto->cantidad }}</strong> 
                                            <small class="text-muted">{{ $producto->unidad_medida }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-medium">${{ number_format($producto->precio_unitario, 2) }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-success">${{ number_format($producto->cantidad * $producto->precio_unitario, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if($producto->estado == 'Óptimo')
                                                <span class="badge badge-optimo badge-professional">✅ {{ $producto->estado }}</span>
                                            @elseif($producto->estado == 'Por vencer')
                                                <span class="badge badge-por-vencer badge-professional">⚠️ {{ $producto->estado }}</span>
                                            @else
                                                <span class="badge badge-restringido badge-professional">🔒 {{ $producto->estado }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-medium">{{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="section-card">
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5>No se encontraron productos</h5>
                        <p>No hay productos que coincidan con los filtros aplicados.</p>
                        <a href="{{ route('inventario.reporte') }}" class="btn btn-outline-professional">
                            <i class="fas fa-undo me-2"></i>Limpiar filtros
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Sección de Salidas de Inventario -->
        <div class="section-card mt-4">
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Insumos Utilizados en Lotes</span>
                </div>
                <span class="badge bg-white text-dark">{{ $salidas->count() }} registros</span>
            </div>
            <div class="card-body">
                @if($salidas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-professional table-hover">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                    <th><i class="fas fa-seedling me-1"></i>Insumo</th>
                                    <th><i class="fas fa-map-marker-alt me-1"></i>Lote</th>
                                    <th><i class="fas fa-industry me-1"></i>Producción</th>
                                    <th><i class="fas fa-sort-amount-up me-1"></i>Cantidad</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i>Valor</th>
                                    <th><i class="fas fa-calendar me-1"></i>Fecha Salida</th>
                                    <th><i class="fas fa-user me-1"></i>Responsable</th>
                                    <th><i class="fas fa-comment me-1"></i>Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salidas as $salida)
                                    <tr>
                                        <td><span class="fw-bold">{{ $salida->id }}</span></td>
                                        <td>
                                            <div class="text-start">
                                                <strong class="text-dark">{{ $salida->insumo ? $salida->insumo->nombre : 'N/A' }}</strong>
                                                @if($salida->insumo)
                                                    <br>
                                                    @if($salida->insumo->tipo == 'Fertilizantes')
                                                        <span class="badge badge-fertilizante badge-professional">🌱 {{ $salida->insumo->tipo }}</span>
                                                    @else
                                                        <span class="badge badge-pesticida badge-professional">🛡️ {{ $salida->insumo->tipo }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($salida->lote)
                                                <div class="text-start">
                                                    <strong class="text-dark">{{ $salida->lote->nombre }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $salida->lote->tipo_cacao }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted fst-italic">No especificado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($salida->produccion)
                                                <span class="badge bg-primary">ID: {{ $salida->produccion->id }}</span>
                                                <br>
                                                <small class="text-muted">{{ $salida->produccion->estado ?? 'N/A' }}</small>
                                            @else
                                                <span class="text-muted fst-italic">No asociado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <strong class="text-dark">{{ $salida->cantidad }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $salida->unidad_medida }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <strong class="text-success">${{ number_format($salida->cantidad * $salida->precio_unitario, 2) }}</strong>
                                                <br>
                                                <small class="text-muted">${{ number_format($salida->precio_unitario, 2) }}/{{ $salida->unidad_medida }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <span class="fw-medium">{{ \Carbon\Carbon::parse($salida->fecha_salida)->format('d/m/Y') }}</span>
                                                <br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($salida->fecha_salida)->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-medium">{{ $salida->responsable ?? 'No especificado' }}</span>
                                        </td>
                                        <td>
                                            <div class="text-start">
                                                <span class="badge bg-secondary">{{ $salida->motivo ?? 'Sin motivo' }}</span>
                                                @if($salida->observaciones)
                                                    <br>
                                                    <small class="text-muted">{{ $salida->observaciones }}</small>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h5>No hay salidas registradas</h5>
                        <p>No se encontraron salidas de inventario en el período seleccionado.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-envío de formulario al cambiar los filtros select
    $('select[name="tipo"], select[name="estado"]').on('change', function() {
        $(this).closest('form').submit();
    });
    
    // Validación de fechas
    $('input[name="fecha_desde"], input[name="fecha_hasta"]').on('change', function() {
        const fechaDesde = new Date($('input[name="fecha_desde"]').val());
        const fechaHasta = new Date($('input[name="fecha_hasta"]').val());
        
        if (fechaDesde && fechaHasta && fechaDesde > fechaHasta) {
            Swal.fire({
                icon: 'warning',
                title: 'Fechas inválidas',
                text: 'La fecha desde no puede ser mayor que la fecha hasta.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
    
    // Animación de fade-in para las tarjetas de estadísticas
    $('.stats-card').each(function(index) {
        $(this).delay(index * 100).queue(function() {
            $(this).addClass('fade-in-up').dequeue();
        });
    });
});
</script>
@endsection
