@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4><i class="fas fa-clipboard-list me-2"></i>Historial de Recolecciones</h4>
                        <nav aria-label="breadcrumb">
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

                    {{-- Filtros --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('recolecciones.index') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Buscar por lote o cultivo..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="fecha_desde" class="form-control" 
                                               placeholder="Desde" value="{{ request('fecha_desde') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="estado_fruto" class="form-select">
                                            <option value="">Todos los estados</option>
                                            <option value="maduro" {{ request('estado_fruto') == 'maduro' ? 'selected' : '' }}>Maduro</option>
                                            <option value="semi-maduro" {{ request('estado_fruto') == 'semi-maduro' ? 'selected' : '' }}>Semi-maduro</option>
                                            <option value="verde" {{ request('estado_fruto') == 'verde' ? 'selected' : '' }}>Verde</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-secondary me-1">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                        <a href="{{ route('recolecciones.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tabla de recolecciones --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Lote/Producción</th>
                                    <th>Cantidad (kg)</th>
                                    <th>Estado Fruto</th>
                                    <th>Calidad</th>
                                    <th>Condiciones</th>
                                    <th>Trabajadores</th>
                                    <th>Acciones</th>
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
                                            <span class="badge bg-success">
                                                {{ number_format($recoleccion->cantidad_recolectada, 2) }} kg
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $recoleccion->estado_fruto == 'maduro' ? 'success' : 
                                                ($recoleccion->estado_fruto == 'semi-maduro' ? 'warning' : 'danger') }}">
                                                {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($recoleccion->calidad_promedio)
                                                <div class="text-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $recoleccion->calidad_promedio ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                    <br><small>{{ $recoleccion->calidad_promedio }}/5</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Sin evaluar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($recoleccion->condiciones_climaticas)
                                                @case('soleado')
                                                    <i class="fas fa-sun text-warning"></i> Soleado
                                                    @break
                                                @case('nublado')
                                                    <i class="fas fa-cloud text-secondary"></i> Nublado
                                                    @break
                                                @case('lluvioso')
                                                    <i class="fas fa-cloud-rain text-primary"></i> Lluvioso
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($recoleccion->trabajadores_participantes && is_array($recoleccion->trabajadores_participantes))
                                                <small>{{ count($recoleccion->trabajadores_participantes) }} trabajador(es)</small>
                                            @else
                                                <small class="text-muted">Sin datos</small>
                                            @endif
                                        </td>
                                        <td>
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
                                        <td colspan="9" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-clipboard-list fa-3x text-muted"></i>
                                                <h5 class="mt-2 text-muted">No hay recolecciones registradas</h5>
                                                <p class="text-muted">Comienza registrando una nueva recolección</p>
                                                <a href="{{ route('recolecciones.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Nueva Recolección
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    @if($recolecciones->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $recolecciones->withQueryString()->links() }}
                        </div>
                    @endif

                    {{-- Estadísticas del día --}}
                    @if($recolecciones->isNotEmpty())
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $recolecciones->sum('cantidad_recolectada') }} kg</h4>
                                                <p>Total Recolectado Hoy</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-weight fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $recolecciones->count() }}</h4>
                                                <p>Recolecciones del Día</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-list fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ number_format($recolecciones->avg('calidad_promedio') ?? 0, 1) }}</h4>
                                                <p>Calidad Promedio</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-star fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $recolecciones->groupBy('produccion_id')->count() }}</h4>
                                                <p>Lotes Trabajados</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-map-marker fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script>
function eliminarRecoleccion(id) {
    Swal.fire({
        title: '¿Eliminar Recolección?',
        text: "Esta acción no se puede deshacer",
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
            form.action = `/recolecciones/${id}`;
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
</script>
@endpush
