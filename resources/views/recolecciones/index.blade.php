@extends('layouts.masterr')

@push('styles')

<link rel="stylesheet" href="{{ asset('css/recoleccion/index.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    {{-- Estadísticas en la parte superior --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #8b6f47 0%, #a0845c 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $recolecciones->sum('cantidad_recolectada') }} kg</h4>
                            <p class="mb-0">Total Recolectado</p>
                        </div>
                        <div>
                            <i class="fas fa-weight-hanging fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #6b4e3d 0%, #8b6f47 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $recolecciones->count() }}</h4>
                            <p class="mb-0">Recolecciones del Día</p>
                        </div>
                        <div>
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #a0845c 0%, #c9a876 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ number_format($recolecciones->avg('calidad_promedio') ?? 0, 1) }}</h4>
                            <p class="mb-0">Calidad Promedio</p>
                        </div>
                        <div>
                            <i class="fas fa-star fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(135deg, #4a3728 0%, #6b4e3d 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $recolecciones->groupBy('produccion_id')->count() }}</h4>
                            <p class="mb-0">Lotes Trabajados</p>
                        </div>
                        <div>
                            <i class="fas fa-seedling fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 style="color: var(--cacao-dark);"><i class="fas fa-clipboard-list me-2" style="color: var(--cacao-accent);"></i>Historial de Recolecciones</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('produccion.index') }}" class="text-decoration-none" style="color: var(--cacao-medium);">
                                        <i class="fas fa-seedling me-1" style="color: var(--cacao-accent);"></i>Producciones
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page" style="color: var(--cacao-dark);">
                                    <i class="fas fa-clipboard-list me-1" style="color: var(--cacao-accent);"></i>Recolecciones
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('recolecciones.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nueva Recolección
                    </a>
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

                    {{-- Filtros mejorados --}}
                    <div class="card mb-3" style="border: none; box-shadow: 0 2px 4px rgba(74, 55, 40, 0.1);">
                        <div class="card-header" style="background: linear-gradient(135deg, var(--cacao-cream), white); border-bottom: 2px solid var(--cacao-accent);">
                            <h6 class="mb-0" style="color: var(--cacao-dark);">
                                <i class="fas fa-filter me-2" style="color: var(--cacao-accent);"></i>Filtros de Búsqueda
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('recolecciones.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" style="color: var(--cacao-dark); font-weight: 600;">
                                            <i class="fas fa-search me-1" style="color: var(--cacao-accent);"></i>Buscar
                                        </label>
                                        <input type="text" name="search" class="form-control"
                                               placeholder="Buscar por lote o cultivo..."
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" style="color: var(--cacao-dark); font-weight: 600;">
                                            <i class="fas fa-calendar me-1" style="color: var(--cacao-accent);"></i>Fecha Desde
                                        </label>
                                        <input type="date" name="fecha_desde" class="form-control"
                                               value="{{ request('fecha_desde') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" style="color: var(--cacao-dark); font-weight: 600;">
                                            <i class="fas fa-apple-alt me-1" style="color: var(--cacao-accent);"></i>Estado del Fruto
                                        </label>
                                        <select name="estado_fruto" class="form-select">
                                            <option value="">Todos los estados</option>
                                            <option value="maduro" {{ request('estado_fruto') == 'maduro' ? 'selected' : '' }}>🟢 Maduro</option>
                                            <option value="semi-maduro" {{ request('estado_fruto') == 'semi-maduro' ? 'selected' : '' }}>🟡 Semi-maduro</option>
                                            <option value="verde" {{ request('estado_fruto') == 'verde' ? 'selected' : '' }}>🔴 Verde</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" style="color: transparent;">Acciones</label>
                                        <div class="d-flex gap-1">
                                            <button type="submit" class="btn btn-secondary flex-fill">
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
                    <div class="card" style="border: none; box-shadow: 0 4px 6px rgba(74, 55, 40, 0.1);">
                        <div class="card-header" style="background: linear-gradient(135deg, var(--cacao-cream), white); border-bottom: 2px solid var(--cacao-accent);">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0" style="color: var(--cacao-dark);">
                                    <i class="fas fa-table me-2" style="color: var(--cacao-accent);"></i>Listado de Recolecciones
                                </h6>
                                <span class="badge" style="background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-cream)); color: var(--cacao-dark);">
                                    {{ $recolecciones->total() }} registros
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead style="background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)); color: white;">
                                        <tr>
                                            <th style="border: none;">#</th>
                                            <th style="border: none;">Fecha</th>
                                            <th style="border: none;">Lote/Producción</th>
                                            <th style="border: none;">Cantidad (kg)</th>
                                            <th style="border: none;">Estado Fruto</th>
                                            <th style="border: none;">Calidad</th>
                                            <th style="border: none;">Condiciones</th>
                                            <th style="border: none;">Trabajadores</th>
                                            <th style="border: none; text-align: center;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @forelse($recolecciones as $recoleccion)
                                    <tr>
                                        <td>{{ $recoleccion->id }}</td>
                                        <td>{{ $recoleccion->fecha_recoleccion->format('d/m/Y') }}</td>
                                        <td>
                                            <strong>{{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</strong><br>
                                            <small class="text-muted">{{ $recoleccion->produccion->tipo_cacao }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success" style="background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-cream)) !important; color: #333 !important;">
                                                {{ number_format($recoleccion->cantidad_recolectada, 2) }} kg
                                            </span>
                                        </td>
                                        <td>
                                            @if($recoleccion->estado_fruto == 'maduro')
                                                <span class="badge" style="background: linear-gradient(135deg, #27ae60, #2ecc71); color: white;">
                                                    {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                                </span>
                                            @elseif($recoleccion->estado_fruto == 'semi-maduro')
                                                <span class="badge" style="background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-cream)); color: #333;">
                                                    {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                                </span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)); color: white;">
                                                    {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($recoleccion->calidad_promedio)
                                                <div class="text-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $recoleccion->calidad_promedio ? 'text-warning' : 'text-muted' }}"
                                                           style="color: {{ $i <= $recoleccion->calidad_promedio ? 'var(--cacao-accent)' : 'rgba(139, 111, 71, 0.3)' }} !important;"></i>
                                                    @endfor
                                                    <br><small style="color: var(--cacao-medium);">{{ $recoleccion->calidad_promedio }}/5</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Sin evaluar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($recoleccion->condiciones_climaticas)
                                                @case('soleado')
                                                    <span class="badge" style="background: linear-gradient(135deg, #f39c12, #f1c40f); color: #333;">
                                                        <i class="fas fa-sun me-1"></i>Soleado
                                                    </span>
                                                    @break
                                                @case('nublado')
                                                    <span class="badge" style="background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)); color: white;">
                                                        <i class="fas fa-cloud me-1"></i>Nublado
                                                    </span>
                                                    @break
                                                @case('lluvioso')
                                                    <span class="badge" style="background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)); color: white;">
                                                        <i class="fas fa-cloud-rain me-1"></i>Lluvioso
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="text-muted">Sin datos</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($recoleccion->trabajadores_participantes && is_array($recoleccion->trabajadores_participantes))
                                                <small>{{ count($recoleccion->trabajadores_participantes) }} trabajador(es)</small>
                                            @else
                                                <small class="text-muted">Sin datos</small>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
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
                                        <td colspan="9" class="text-center py-5">
                                            <div class="py-4">
                                                <div class="mb-3">
                                                    <i class="fas fa-clipboard-list fa-4x" style="color: var(--cacao-accent); opacity: 0.5;"></i>
                                                </div>
                                                <h5 class="text-muted mb-2">No hay recolecciones registradas</h5>
                                                <p class="text-muted mb-3">Comienza registrando una nueva recolección para este lote</p>
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
