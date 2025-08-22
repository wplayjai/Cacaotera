@extends('layouts.masterr')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/produccion/index.css') }}">
@endpush

@section('content')

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
               <label for="search" class="form-label text-muted fw-medium">Buscar</label>
               <input type="text" id="search" name="search" class="form-control form-control-professional" 
                   placeholder="Cultivo o lote..." 
                   value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="estado" class="form-label text-muted fw-medium">Estado</label>
                        <select id="estado" name="estado" class="form-select form-select-professional">
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
               <label for="fecha_inicio" class="form-label text-muted fw-medium">Fecha Inicio</label>
               <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control form-control-professional" 
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
                                        {{ $produccion->fecha_programada_cosecha ? $produccion->fecha_programada_cosecha->format('d/m/Y') : 'Sin fecha' }}
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
                                        {{ $produccion->estimacion_produccion == floor($produccion->estimacion_produccion) ? number_format($produccion->estimacion_produccion, 0) : number_format($produccion->estimacion_produccion, 2) }} kg
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
                                        @php
                                            $estados = ['planificado','siembra','crecimiento','maduracion','cosecha','secado','completado'];
                                            $actual = $produccion->estado;
                                            $actualIndex = array_search($actual, $estados);
                                            $siguienteIndex = $actualIndex !== false ? $actualIndex + 1 : false;
                                            $siguienteEstado = $siguienteIndex !== false && isset($estados[$siguienteIndex]) ? $estados[$siguienteIndex] : null;
                                        @endphp
                                        @if($siguienteEstado && $actual != 'completado')
                                            @if($siguienteEstado != 'completado')
                                                <button type="button" class="btn btn-sm btn-success-professional" 
                                                        onclick="cambiarEstadoProduccion({{ $produccion->id }}, '{{ $siguienteEstado }}')" 
                                                        title="Avanzar a {{ ucfirst($siguienteEstado) }}">
                                                    <i class="fas fa-step-forward"></i>
                                                </button>
                                            @endif
                                        @endif
                                        @if(in_array($produccion->estado, ['siembra', 'crecimiento', 'maduracion', 'cosecha', 'secado']))
                                            @if($produccion->estado == 'secado')
                                                <button type="button" class="btn btn-sm btn-primary-professional" 
                                                        onclick="completarProduccion({{ $produccion->id }})" 
                                                        title="Completar producción">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
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
<script src="{{ asset('js/produccion/index.js') }}" defer></script>
@endpush