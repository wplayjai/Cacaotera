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

/* Header con gradiente */
.header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    padding: 1.5rem;
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
}

/* Título principal */
.main-title {
    color: var(--cacao-white);
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.7rem;
}

.main-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    margin-bottom: 1rem;
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

/* Botones profesionales */
.btn-professional {
    border: none;
    border-radius: 6px;
    padding: 0.7rem 1.3rem;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    margin: 0.2rem;
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

.btn-outline-professional {
    background: transparent;
    color: var(--cacao-primary);
    border: 2px solid var(--cacao-light);
}

.btn-outline-professional:hover {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border-color: var(--cacao-primary);
}

/* Filtros profesionales */
.filters-section {
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.05), rgba(139, 111, 71, 0.02));
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--cacao-light);
}

.form-control-professional,
.form-select-professional {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.7rem 0.9rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: var(--cacao-white);
}

.form-control-professional:focus,
.form-select-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.15rem rgba(139, 111, 71, 0.15);
    outline: none;
}

/* Tabla profesional */
.table-card {
    background: var(--cacao-white);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

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

/* Badges profesionales */
.badge-professional {
    padding: 0.4rem 0.7rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.badge-success-professional {
    background: linear-gradient(135deg, var(--success), #1b5e20);
    color: var(--cacao-white);
}

.badge-warning-professional {
    background: linear-gradient(135deg, var(--warning), #e65100);
    color: var(--cacao-white);
}

.badge-primary-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
}

.badge-secondary-professional {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: var(--cacao-white);
}

/* Cards de estadísticas */
.stats-cards {
    margin-top: 2rem;
}

.stats-card {
    background: var(--cacao-white);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
    margin-bottom: 1rem;
    border-left: 4px solid var(--cacao-primary);
    transition: all 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stats-card.primary {
    border-left-color: var(--cacao-primary);
    background: linear-gradient(135deg, rgba(74, 55, 40, 0.05), rgba(74, 55, 40, 0.02));
}

.stats-card.warning {
    border-left-color: var(--warning);
    background: linear-gradient(135deg, rgba(245, 124, 0, 0.05), rgba(245, 124, 0, 0.02));
}

.stats-card.success {
    border-left-color: var(--success);
    background: linear-gradient(135deg, rgba(46, 125, 50, 0.05), rgba(46, 125, 50, 0.02));
}

.stats-card.info {
    border-left-color: var(--info);
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.05), rgba(25, 118, 210, 0.02));
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--cacao-primary);
    margin-bottom: 0.2rem;
}

.stats-label {
    color: var(--cacao-muted);
    font-size: 0.9rem;
    font-weight: 500;
}

.stats-icon {
    font-size: 2.5rem;
    opacity: 0.3;
}

/* Progress bar profesional */
.progress-professional {
    height: 8px;
    border-radius: 4px;
    background: var(--cacao-light);
}

.progress-bar-professional {
    background: linear-gradient(90deg, var(--cacao-accent), var(--cacao-primary));
    border-radius: 4px;
}

/* Alertas profesionales */
.alert-professional {
    border: none;
    border-radius: 8px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    font-weight: 500;
    border-left: 4px solid;
}

.alert-success-professional {
    background: linear-gradient(135deg, rgba(46, 125, 50, 0.1), rgba(46, 125, 50, 0.05));
    color: var(--success);
    border-left-color: var(--success);
}

.alert-warning-professional {
    background: linear-gradient(135deg, rgba(245, 124, 0, 0.1), rgba(245, 124, 0, 0.05));
    color: var(--warning);
    border-left-color: var(--warning);
}

/* Estado vacío profesional */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
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

/* Responsivo */
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
        font-size: 1.4rem;
        text-align: center;
    }
    
    .btn-professional {
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
        width: 100%;
        justify-content: center;
    }
    
    .stats-cards .col-md-3 {
        margin-bottom: 1rem;
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
</style>

<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">
                        <i class="fas fa-seedling"></i>Gestión de Producción
                    </h1>
                    <p class="main-subtitle">
                        Control y monitoreo del proceso productivo de cacao
                    </p>
                    
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="breadcrumb-professional">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fas fa-home me-1"></i>Inicio
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-seedling me-1"></i>Producción
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('recolecciones.index') }}" class="btn btn-success-professional">
                            <i class="fas fa-clipboard-list me-2"></i>Recolecciones
                        </a>
                        <a href="{{ route('produccion.reporte_rendimiento') }}" class="btn btn-info-professional">
                            <i class="fas fa-chart-line me-2"></i>Reporte
                        </a>
                        <a href="{{ route('produccion.create') }}" class="btn btn-primary-professional">
                            <i class="fas fa-plus me-2"></i>Nueva Producción
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mensajes de sesión -->
        @if(session('success'))
            <div class="alert alert-success-professional alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning-professional alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alertas de próximas cosechas -->
        @if($proximosCosecha->isNotEmpty())
            <div class="alert alert-warning-professional alert-dismissible fade show" role="alert">
                <i class="fas fa-calendar-alt me-2"></i><strong>Próximas Cosechas:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($proximosCosecha as $cosecha)
                        <li>
                            {{ $cosecha->tipo_cacao }} en {{ $cosecha->lote?->nombre ?? 'Sin lote' }} - 
                            Cosecha programada: {{ $cosecha->fecha_programada_cosecha->format('d/m/Y') }}
                        </li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filtros de búsqueda -->
        <div class="filters-section fade-in-up">
            <h6 class="text-primary mb-3">
                <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
            </h6>
            <form method="GET" action="{{ route('produccion.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted fw-medium">Buscar</label>
                        <input type="text" name="search" class="form-control form-control-professional" 
                               placeholder="Cultivo o lote..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted fw-medium">Estado</label>
                        <select name="estado" class="form-select form-select-professional">
                            <option value="">Todos los estados</option>
                            <option value="planificado" {{ request('estado') == 'planificado' ? 'selected' : '' }}>Planificado</option>
                            <option value="siembra" {{ request('estado') == 'siembra' ? 'selected' : '' }}>Siembra</option>
                            <option value="crecimiento" {{ request('estado') == 'crecimiento' ? 'selected' : '' }}>Crecimiento</option>
                            <option value="maduracion" {{ request('estado') == 'maduracion' ? 'selected' : '' }}>Maduración</option>
                            <option value="cosecha" {{ request('estado') == 'cosecha' ? 'selected' : '' }}>Cosecha</option>
                            <option value="secado" {{ request('estado') == 'secado' ? 'selected' : '' }}>Secado</option>
                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted fw-medium">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control form-control-professional" 
                               value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted fw-medium">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-professional">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                            <a href="{{ route('produccion.index') }}" class="btn btn-outline-professional">
                                <i class="fas fa-times me-2"></i>Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de producción -->
        <div class="table-card fade-in-up">
            <div class="table-responsive">
                <table class="table table-professional">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>ID</th>
                            <th><i class="fas fa-leaf me-1"></i>Cultivo</th>
                            <th><i class="fas fa-map-marker-alt me-1"></i>Lote</th>
                            <th><i class="fas fa-calendar-alt me-1"></i>F. Inicio</th>
                            <th><i class="fas fa-calendar-check me-1"></i>F. Fin Esperada</th>
                            <th><i class="fas fa-ruler-combined me-1"></i>Área (m²)</th>
                            <th><i class="fas fa-tasks me-1"></i>Estado</th>
                            <th><i class="fas fa-weight-hanging me-1"></i>Rendimiento</th>
                            <th><i class="fas fa-chart-line me-1"></i>Progreso</th>
                            <th><i class="fas fa-cogs me-1"></i>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($producciones as $produccion)
                            <tr>
                                <td class="fw-bold">{{ $produccion->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-seedling text-success me-2"></i>
                                        {{ $produccion->tipo_cacao }}
                                    </div>
                                </td>
                                <td>{{ $produccion->lote?->nombre ?? 'Sin lote' }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }}
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Sin fecha' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge badge-primary-professional">
                                        {{ $produccion->area_asignada == floor($produccion->area_asignada) ? number_format($produccion->area_asignada, 0) : number_format($produccion->area_asignada, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $estadoClass = match($produccion->estado) {
                                            'completado' => 'badge-success-professional',
                                            'planificado' => 'badge-secondary-professional',
                                            default => 'badge-warning-professional'
                                        };
                                    @endphp
                                    <span class="badge-professional {{ $estadoClass }}">
                                        {{ ucfirst($produccion->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-success">
                                        {{ $produccion->estimacion_produccion == floor($produccion->estimacion_produccion) ? number_format($produccion->estimacion_produccion, 0) : number_format($produccion->estimacion_produccion, 2) }} ton
                                    </strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress progress-professional me-2" style="width: 80px; height: 8px;">
                                            <div class="progress-bar progress-bar-professional" 
                                                 style="width: {{ $produccion->calcularProgreso() }}%;" 
                                                 role="progressbar">
                                            </div>
                                        </div>
                                        <small class="fw-bold">{{ $produccion->calcularProgreso() }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('produccion.show', $produccion->id) }}" 
                                           class="btn btn-sm btn-info-professional" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(in_array($produccion->estado, ['maduracion', 'cosecha']) && $produccion->porcentaje_recoleccion_completado < 100)
                                            <a href="{{ route('recolecciones.create', $produccion->id) }}" 
                                               class="btn btn-sm btn-success-professional" title="Registrar recolección">
                                                <i class="fas fa-clipboard-list"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('produccion.edit', $produccion->id) }}" 
                                           class="btn btn-sm btn-warning-professional" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($produccion->estado == 'planificado')
                                            <button type="button" class="btn btn-sm btn-success-professional" 
                                                    onclick="iniciarProduccion({{ $produccion->id }})" 
                                                    title="Iniciar producción">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        @endif
                                        @if(in_array($produccion->estado, ['siembra', 'crecimiento', 'maduracion', 'cosecha', 'secado']))
                                            <button type="button" class="btn btn-sm btn-primary-professional" 
                                                    onclick="completarProduccion({{ $produccion->id }})" 
                                                    title="Completar producción">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-professional text-danger" 
                                                onclick="eliminarProduccion({{ $produccion->id }})" 
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="fas fa-seedling empty-state-icon"></i>
                                        <h5>No hay producciones en curso</h5>
                                        <p>Comienza creando una nueva producción para gestionar tu cultivo de cacao</p>
                                        <a href="{{ route('produccion.create') }}" class="btn btn-primary-professional">
                                            <i class="fas fa-plus me-2"></i>Nueva Producción
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($producciones->hasPages())
            <div class="d-flex justify-content-center">
                {{ $producciones->withQueryString()->links() }}
            </div>
        @endif

        <!-- Estadísticas resumen -->
        <div class="stats-cards fade-in-up">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="stats-card primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">{{ $estadisticas['total'] ?? 0 }}</div>
                                <div class="stats-label">Producciones en Curso</div>
                            </div>
                            <div class="stats-icon text-primary">
                                <i class="fas fa-seedling"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number text-warning">{{ $estadisticas['en_proceso'] ?? 0 }}</div>
                                <div class="stats-label">En Proceso</div>
                            </div>
                            <div class="stats-icon text-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card success">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number text-success">{{ $estadisticas['completadas'] ?? 0 }}</div>
                                <div class="stats-label">Completadas</div>
                            </div>
                            <div class="stats-icon text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card info">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number text-info">
                                    {{ ($estadisticas['area_total'] ?? 0) == floor($estadisticas['area_total'] ?? 0) ? number_format($estadisticas['area_total'] ?? 0, 0) : number_format($estadisticas['area_total'] ?? 0, 2) }}
                                </div>
                                <div class="stats-label">m² Totales</div>
                            </div>
                            <div class="stats-icon text-info">
                                <i class="fas fa-map"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Estado --}}
<div class="modal fade" id="estadoModal" tabindex="-1" role="dialog" aria-labelledby="estadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="estadoForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="estadoModalLabel">Actualizar Estado del Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nuevoEstado">Nuevo Estado</label>
                        <select class="form-control" id="nuevoEstado" name="estado">
                            <option value="siembra">Siembra</option>
                            <option value="crecimiento">Crecimiento</option>
                            <option value="maduracion">Maduración</option>
                            <option value="cosecha">Cosecha</option>
                            <option value="secado">Secado</option>
                            <option value="completado">Completado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                    </div>
                    <div id="alertaEstado" class="alert alert-warning d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Rendimiento --}}
<div class="modal fade" id="rendimientoModal" tabindex="-1" role="dialog" aria-labelledby="rendimientoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="rendimientoForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rendimientoModalLabel">Ingresar Rendimiento Real</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rendimientoReal">Cantidad cosechada (kg)</label>
                        <input type="number" class="form-control" id="rendimientoReal" name="rendimiento_real" min="0" required>
                    </div>
                    <div id="alertaRendimiento" class="alert alert-danger d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function iniciarProduccion(id) {
    Swal.fire({
        title: '¿Iniciar Producción?',
        text: "La producción pasará al estado 'Siembra'",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'var(--cacao-primary)',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-play me-1"></i>Sí, iniciar',
        cancelButtonText: '<i class="fas fa-times me-1"></i>Cancelar',
        customClass: {
            popup: 'swal-cafe',
            confirmButton: 'btn-professional',
            cancelButton: 'btn-outline-professional'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Procesando...',
                text: 'Iniciando producción',
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-cafe'
                },
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/produccion/${id}/iniciar`;
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

function completarProduccion(id) {
    Swal.fire({
        title: '¿Completar Producción?',
        text: "La producción pasará al estado 'Completado'",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'var(--cacao-primary)',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-check me-1"></i>Sí, completar',
        cancelButtonText: '<i class="fas fa-times me-1"></i>Cancelar',
        customClass: {
            popup: 'swal-cafe',
            confirmButton: 'btn-professional',
            cancelButton: 'btn-outline-professional'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Procesando...',
                text: 'Completando producción',
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-cafe'
                },
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/produccion/${id}/completar`;
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

function eliminarProduccion(id) {
    Swal.fire({
        title: '¿Eliminar Producción?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-1"></i>Sí, eliminar',
        cancelButtonText: '<i class="fas fa-times me-1"></i>Cancelar',
        customClass: {
            popup: 'swal-cafe',
            confirmButton: 'btn-professional',
            cancelButton: 'btn-outline-professional'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Procesando...',
                text: 'Eliminando producción',
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-cafe'
                },
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/produccion/${id}`;
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

// Variables globales para los modales
let estadoId = null;
let estadoActual = '';
let rendimientoId = null;
let estimacion = 0;

function abrirEstadoModal(id, estado) {
    estadoId = id;
    estadoActual = estado;
    $('#estadoForm').attr('action', `/produccion/${id}/estado`);
    $('#nuevoEstado').val(estado);
    $('#observaciones').val('');
    $('#alertaEstado').addClass('d-none').text('');
    var modal = new bootstrap.Modal(document.getElementById('estadoModal'));
    modal.show();
}

$('#estadoForm').on('submit', function(e) {
    const nuevoEstado = $('#nuevoEstado').val();
    if (estadoActual !== 'cosecha' && nuevoEstado === 'cosecha') {
        if (!$('#observaciones').val()) {
            e.preventDefault();
            $('#alertaEstado').removeClass('d-none').text('Debe registrar observaciones para cambios a "Cosecha".');
            return false;
        }
    }
});

function abrirRendimientoModal(id, estimacionProd) {
    rendimientoId = id;
    estimacion = estimacionProd;
    $('#rendimientoForm').attr('action', `/produccion/${id}/rendimiento`);
    $('#rendimientoReal').val('');
    $('#alertaRendimiento').addClass('d-none').text('');
    var modal = new bootstrap.Modal(document.getElementById('rendimientoModal'));
    modal.show();
}

$('#rendimientoForm').on('submit', function(e) {
    const real = parseFloat($('#rendimientoReal').val());
    if (real < 0.8 * estimacion) {
        e.preventDefault();
        $('#alertaRendimiento').removeClass('d-none').text('El rendimiento real es inferior al 80% del estimado. Se generará informe de desviación.');
        return false;
    }
});

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

// Animación de entrada
document.addEventListener('DOMContentLoaded', function() {
    $('.fade-in-up').addClass('show');
});

// Estilos SweetAlert2 personalizados
const style = document.createElement('style');
style.textContent = `
    .swal-cafe {
        border-radius: 12px !important;
        font-family: inherit !important;
    }
    
    .swal-cafe .swal2-title {
        color: var(--cacao-primary) !important;
        font-weight: 600 !important;
    }
    
    .swal-cafe .swal2-content {
        color: var(--cacao-text) !important;
    }
    
    .swal-cafe .swal2-confirm.btn-professional {
        background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary)) !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 0.7rem 1.3rem !important;
        font-weight: 500 !important;
    }
    
    .swal-cafe .swal2-cancel.btn-outline-professional {
        background: transparent !important;
        color: var(--cacao-primary) !important;
        border: 2px solid var(--cacao-light) !important;
        border-radius: 6px !important;
        padding: 0.7rem 1.3rem !important;
        font-weight: 500 !important;
    }
`;
document.head.appendChild(style);
</script>
@endpush