@extends('layouts.masterr')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/produccion/index.css') }}">
@endpush

@section('content')

<div class="container-fluid">
    <div class="main-container">
        <!-- Header limpio -->
        <div class="header-clean">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="main-title">Gestión de Producción</h1>
                    <p class="main-subtitle">Control y monitoreo del proceso productivo de cacao</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('recolecciones.index') }}" class="btn btn-outline-clean">
                        Recolecciones
                    </a>
                    <a href="{{ route('produccion.reporte_rendimiento') }}" class="btn btn-outline-clean">
                        Reporte
                    </a>
                    <a href="{{ route('produccion.create') }}" class="btn btn-primary-clean">
                        Nueva Producción
                    </a>
                </div>
            </div>
        </div>

        <!-- Mensajes de sesión -->
        @if(session('success'))
            <div class="alert alert-success-clean" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning-clean" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alertas de próximas cosechas -->
        @if($proximosCosecha->isNotEmpty())
            <div class="alert alert-warning-clean" role="alert">
                <strong>Próximas Cosechas:</strong>
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

        <!-- Cards de estadísticas -->
        <div class="stats-grid">
            <div class="stats-card">
                <div class="stats-number">{{ $estadisticas['total'] ?? 0 }}</div>
                <div class="stats-label">Producciones en Curso</div>
            </div>
            <div class="stats-card">
                <div class="stats-number">{{ $estadisticas['en_proceso'] ?? 0 }}</div>
                <div class="stats-label">En Proceso</div>
            </div>
            <div class="stats-card">
                <div class="stats-number">{{ $estadisticas['completadas'] ?? 0 }}</div>
                <div class="stats-label">Completadas</div>
            </div>
            <div class="stats-card">
                <div class="stats-number">
                    {{ ($estadisticas['area_total'] ?? 0) == floor($estadisticas['area_total'] ?? 0) ? number_format($estadisticas['area_total'] ?? 0, 0) : number_format($estadisticas['area_total'] ?? 0, 2) }}
                </div>
                <div class="stats-label">m² Totales</div>
            </div>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="filters-section">
            <h6 class="filter-title">Filtros de Búsqueda</h6>
            <form method="GET" action="{{ route('produccion.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" id="search" name="search" class="form-control-clean" 
                               placeholder="Cultivo o lote..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select id="estado" name="estado" class="form-control-clean">
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
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control-clean" 
                               value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-clean">
                                Buscar
                            </button>
                            <a href="{{ route('produccion.index') }}" class="btn btn-outline-clean">
                                Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de producción -->
        <div class="table-container">
            <div class="table-header">
                <h6>Producciones Registradas</h6>
                <span class="table-count">{{ $producciones->count() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table-clean">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cultivo</th>
                            <th>Lote</th>
                            <th>F. Inicio</th>
                            <th>F. Fin Esperada</th>
                            <th>Área (m²)</th>
                            <th>Estado</th>
                            <th>Rendimiento</th>
                            <th>Progreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($producciones as $produccion)
                            <tr>
                                <td class="fw-bold">{{ $produccion->id }}</td>
                                <td>{{ $produccion->tipo_cacao }}</td>
                                <td>{{ $produccion->lote?->nombre ?? 'Sin lote' }}</td>
                                <td>
                                    {{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }}
                                </td>
                                <td>
                                    {{ $produccion->fecha_programada_cosecha ? $produccion->fecha_programada_cosecha->format('d/m/Y') : 'Sin fecha' }}
                                </td>
                                <td>
                                    {{ $produccion->area_asignada == floor($produccion->area_asignada) ? number_format($produccion->area_asignada, 0) : number_format($produccion->area_asignada, 2) }}
                                </td>
                                <td>
                                    @php
                                        $estadoClass = match($produccion->estado) {
                                            'completado' => 'badge-success',
                                            'planificado' => 'badge-secondary',
                                            default => 'badge-warning'
                                        };
                                    @endphp
                                    <span class="badge-clean {{ $estadoClass }}">
                                        {{ ucfirst($produccion->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-success">
                                        {{ $produccion->estimacion_produccion == floor($produccion->estimacion_produccion) ? number_format($produccion->estimacion_produccion, 0) : number_format($produccion->estimacion_produccion, 2) }} kg
                                    </strong>
                                </td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: {{ $produccion->calcularProgreso() }}%;"></div>
                                        <span class="progress-text">{{ $produccion->calcularProgreso() }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group-clean">
                                        <a href="{{ route('produccion.show', $produccion->id) }}" 
                                           class="btn-action" title="Ver detalles">
                                            Ver
                                        </a>
                                        @if(in_array($produccion->estado, ['maduracion', 'cosecha']) && $produccion->porcentaje_recoleccion_completado < 100)
                                            <a href="{{ route('recolecciones.create', $produccion->id) }}"
                                               class="btn btn-sm btn-success-professional" title="Registrar recolección">
                                                <i class="fas fa-clipboard-list"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('produccion.edit', $produccion->id) }}" 
                                           class="btn-action" title="Editar">
                                            Editar
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
                                        <button type="button" class="btn-action danger" 
                                                onclick="eliminarProduccion({{ $produccion->id }})" 
                                                title="Eliminar">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <h5>No hay producciones en curso</h5>
                                        <p>Comienza creando una nueva producción para gestionar tu cultivo de cacao</p>
                                        <a href="{{ route('produccion.create') }}" class="btn btn-primary-clean">
                                            Nueva Producción
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
                        <select class="form-control-clean" id="nuevoEstado" name="estado">
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
                        <textarea class="form-control-clean" id="observaciones" name="observaciones" rows="2"></textarea>
                    </div>
                    <div id="alertaEstado" class="alert alert-warning-clean d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-clean" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-clean">Actualizar</button>
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
                        <input type="number" class="form-control-clean" id="rendimientoReal" name="rendimiento_real" min="0" required>
                    </div>
                    <div id="alertaRendimiento" class="alert alert-warning-clean d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-clean" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-clean">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/produccion/index.js') }}" defer></script>
@endpush
