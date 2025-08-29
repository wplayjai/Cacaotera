@extends('layouts.masterr')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/recoleccion/index.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    {{-- Estadísticas en la parte superior --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1" style="color: var(--cacao-primary);">{{ $recolecciones->sum('cantidad_recolectada') }} kg</h3>
                            <p class="mb-0 text-muted">Total Recolectado</p>
                        </div>
                        <div>
                            <i class="fas fa-weight-hanging fa-2x" style="color: var(--cacao-primary);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card accent">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1" style="color: var(--cacao-secondary);">{{ $recolecciones->count() }}</h3>
                            <p class="mb-0 text-muted">Recolecciones del Día</p>
                        </div>
                        <div>
                            <i class="fas fa-clipboard-list fa-2x" style="color: var(--cacao-secondary);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1" style="color: var(--success);">{{ number_format($recolecciones->avg('calidad_promedio') ?? 0, 1) }}</h3>
                            <p class="mb-0 text-muted">Calidad Promedio</p>
                        </div>
                        <div>
                            <i class="fas fa-star fa-2x" style="color: var(--success);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1" style="color: var(--warning);">{{ $recolecciones->groupBy('produccion_id')->count() }}</h3>
                            <p class="mb-0 text-muted">Lotes Trabajados</p>
                        </div>
                        <div>
                            <i class="fas fa-seedling fa-2x" style="color: var(--warning);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4><i class="fas fa-clipboard-list me-2"></i>Historial de Recolecciones</h4>
                            <nav aria-label="breadcrumb" class="mt-2">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('produccion.index') }}" class="text-decoration-none">
                                            <i class="fas fa-seedling me-1"></i>Producciones
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <i class="fas fa-clipboard-list me-1"></i>Recolecciones
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('recolecciones.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nueva Recolección
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Filtros simplificados --}}
                    <div class="card mb-4 filters-section">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('recolecciones.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <i class="fas fa-search me-1"></i>Buscar
                                        </label>
                                        <input type="text" name="search" class="form-control"
                                               placeholder="Buscar por lote o cultivo..."
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <i class="fas fa-calendar me-1"></i>Fecha Desde
                                        </label>
                                        <input type="date" name="fecha_desde" class="form-control"
                                               value="{{ request('fecha_desde') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <i class="fas fa-apple-alt me-1"></i>Estado del Fruto
                                        </label>
                                        <select name="estado_fruto" class="form-select">
                                            <option value="">Todos los estados</option>
                                            <option value="maduro" {{ request('estado_fruto') == 'maduro' ? 'selected' : '' }}>Maduro</option>
                                            <option value="semi-maduro" {{ request('estado_fruto') == 'semi-maduro' ? 'selected' : '' }}>Semi-maduro</option>
                                            <option value="verde" {{ request('estado_fruto') == 'verde' ? 'selected' : '' }}>Verde</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" style="color: transparent;">Acciones</label>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary flex-fill">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <a href="{{ route('recolecciones.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tabla de recolecciones --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-table me-2"></i>Listado de Recolecciones
                                </h6>
                                <span class="badge bg-info">
                                    {{ $recolecciones->total() }} registros
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Lote/Producción</th>
                                            <th>Cantidad (kg)</th>
                                            <th>Estado Fruto</th>
                                            <th>Calidad</th>
                                            <th>Condiciones</th>
                                            <th>Trabajadores</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recolecciones as $recoleccion)
                                            <tr>
                                                <td><strong>{{ $recoleccion->id }}</strong></td>
                                                <td>{{ $recoleccion->fecha_recoleccion->format('d/m/Y') }}</td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</strong>
                                                    </div>
                                                    <small class="text-muted">{{ $recoleccion->produccion->tipo_cacao }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        {{ number_format($recoleccion->cantidad_recolectada, 2) }} kg
                                                    </span>
                                                </td>
                                                <td>
                                                    @switch($recoleccion->estado_fruto)
                                                        @case('maduro')
                                                            <span class="badge estado-maduro">Maduro</span>
                                                            @break
                                                        @case('semi-maduro')
                                                            <span class="badge estado-semi-maduro">Semi-maduro</span>
                                                            @break
                                                        @default
                                                            <span class="badge estado-verde">Verde</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if($recoleccion->calidad_promedio)
                                                        <div class="stars">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star {{ $i <= $recoleccion->calidad_promedio ? 'active' : 'inactive' }}"></i>
                                                            @endfor
                                                            <div><small class="text-muted">{{ $recoleccion->calidad_promedio }}/5</small></div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Sin evaluar</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @switch($recoleccion->condiciones_climaticas)
                                                        @case('soleado')
                                                            <span class="badge clima-soleado">
                                                                <i class="fas fa-sun me-1"></i>Soleado
                                                            </span>
                                                            @break
                                                        @case('nublado')
                                                            <span class="badge clima-nublado">
                                                                <i class="fas fa-cloud me-1"></i>Nublado
                                                            </span>
                                                            @break
                                                        @case('lluvioso')
                                                            <span class="badge clima-lluvioso">
                                                                <i class="fas fa-cloud-rain me-1"></i>Lluvioso
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="text-muted">Sin datos</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if($recoleccion->trabajadores_participantes && is_array($recoleccion->trabajadores_participantes))
                                                        <span class="badge bg-info">{{ count($recoleccion->trabajadores_participantes) }}</span>
                                                        <small class="text-muted d-block">trabajador(es)</small>
                                                    @else
                                                        <span class="text-muted">Sin datos</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('recolecciones.show', ['recoleccion' => $recoleccion->id]) }}"
                                                           class="btn btn-sm btn-info" title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('recolecciones.edit', ['recoleccion' => $recoleccion->id]) }}"
                                                           class="btn btn-sm btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="eliminarRecoleccion({{ $recoleccion->id }})"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">
                                                    <div class="empty-state">
                                                        <div class="mb-3">
                                                            <i class="fas fa-clipboard-list fa-4x"></i>
                                                        </div>
                                                        <h5 class="mb-2">No hay recolecciones registradas</h5>
                                                        <p class="mb-3">Comienza registrando una nueva recolección para este lote</p>
                                                        <a href="{{ route('recolecciones.create') }}" class="btn btn-primary">
                                                            <i class="fas fa-plus me-1"></i>Nueva Recolección
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Paginación --}}
                    @if($recolecciones->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $recolecciones->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Botón para volver al índice de producción -->
            <div class="mt-3">
                <a href="{{ route('produccion.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver a Producciones
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/recolecciones/index.js') }}" defer></script>
@endpush