{{-- resources/views/produccion/index.blade.php --}}
@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-seedling"></i> Gestión de Producción</h4>
                    <div>
                        <a href="" class="btn btn-info">
                            <i class="fas fa-chart-line"></i> Reporte Rendimiento
                        </a>
                        <a href="{{ route('produccion.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nueva Producción
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    {{-- Mensajes de sesión --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Filtros de búsqueda --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('produccion.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Buscar por cultivo o lote..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="estado" class="form-control">
                                            <option value="">Todos los estados</option>
                                            <option value="planificada" {{ request('estado') == 'planificada' ? 'selected' : '' }}>Planificada</option>
                                            <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                            <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                                            <option value="suspendida" {{ request('estado') == 'suspendida' ? 'selected' : '' }}>Suspendida</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="fecha_inicio" class="form-control" 
                                               value="{{ request('fecha_inicio') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                        <a href="{{ route('produccion.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> Limpiar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tabla de producción --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cultivo</th>
                                    <th>Lote</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin Esperada</th>
                                    <th>Área (ha)</th>
                                    <th>Estado</th>
                                    <th>Rendimiento Esperado</th>
                                    <th>Rendimiento Real</th>
                                    <th>Progreso</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($producciones as $produccion)
                                    <tr>
                                        <td>{{ $produccion->id }}</td>
                                        <td>
                                           <strong>{{ $produccion->lote?->nombre ?? 'Sin nombre' }}</strong>
                                    <small class="text-muted">{{ $produccion->lote?->variedad ?? 'Sin variedad' }}</small>
                                        </td>
                                        <td>{{ $produccion->lote?->nombre ?? 'Sin lote' }}</td>
                                        <td> {{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }}</td>
                                        <td>  {{ $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Sin fecha' }}</td>
                                        <td>{{ number_format($produccion->area_hectareas, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $produccion->estado == 'completada' ? 'success' : 
                                                ($produccion->estado == 'en_proceso' ? 'warning' : 
                                                ($produccion->estado == 'suspendida' ? 'danger' : 'secondary')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $produccion->estado)) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($produccion->rendimiento_esperado, 2) }} ton</td>
                                        <td>
                                            {{ $produccion->rendimiento_real ? number_format($produccion->rendimiento_real, 2) . ' ton' : 'N/A' }}
                                        </td>
                                        <td>
                                            @php
                                                $progreso = $produccion->calcularProgreso();
                                            @endphp
                                            <div class="progress" style="width: 100px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $progreso }}%;" 
                                                     aria-valuenow="{{ $progreso }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $progreso }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('produccion.show', $produccion->id) }}" 
                                                   class="btn btn-sm btn-info" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('produccion.edit', $produccion->id) }}" 
                                                   class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($produccion->estado == 'planificada')
                                                    <button type="button" class="btn btn-sm btn-success" 
                                                            onclick="iniciarProduccion({{ $produccion->id }})" 
                                                            title="Iniciar producción">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                @endif
                                                @if($produccion->estado == 'en_proceso')
                                                    <button type="button" class="btn btn-sm btn-primary" 
                                                            onclick="completarProduccion({{ $produccion->id }})" 
                                                            title="Completar producción">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="eliminarProduccion({{ $produccion->id }})" 
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-seedling fa-3x text-muted"></i>
                                                <h5 class="mt-2 text-muted">No hay producciones registradas</h5>
                                                <p class="text-muted">Comienza creando una nueva producción</p>
                                                <a href="{{ route('produccion.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Nueva Producción
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    @if($producciones->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $producciones->withQueryString()->links() }}
                        </div>
                    @endif

                    {{-- Estadísticas resumen --}}
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $estadisticas['total'] ?? 0 }}</h4>
                                            <p>Total Producciones</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-seedling fa-2x"></i>
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
                                            <h4>{{ $estadisticas['en_proceso'] ?? 0 }}</h4>
                                            <p>En Proceso</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $estadisticas['completadas'] ?? 0 }}</h4>
                                            <p>Completadas</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-check-circle fa-2x"></i>
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
                                            <h4>{{ number_format($estadisticas['area_total'] ?? 0, 2) }}</h4>
                                            <p>Hectáreas Totales</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-map fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modales y Scripts --}}
@push('scripts')
<script>
function iniciarProduccion(id) {
    Swal.fire({
        title: '¿Iniciar Producción?',
        text: "La producción pasará al estado 'En Proceso'",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, iniciar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario dinámico para enviar POST
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
        text: "La producción pasará al estado 'Completada'",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, completar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario dinámico para enviar POST
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
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario dinámico para enviar DELETE
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

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 5000);
</script>
@endpush
@endsection