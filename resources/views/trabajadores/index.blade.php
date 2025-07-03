@extends('layouts.masterr')

@section('content')
 <script src="{{ asset('js/trabajador/indextra.js') }}" defer></script>
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header bg-light py-3 mb-3 shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0" style="color: #6F4F37;"><i class="fas fa-users me-2"></i>Gestión de Trabajadores</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-end">
                        <button class="btn btn-outline-secondary trabajadores-back-btn">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </button>
                        <a href="{{ route('trabajadores.create') }}" class="btn btn-success">
                            <i class="fas fa-user-plus me-1"></i> Registrar Trabajador
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="container-fluid mb-3">
    <div class="card border-top border-3 shadow-sm" style="border-color: #6F4F37 !important;">
        <div class="card-body py-2">
            <div class="d-flex justify-content-end align-items-center">
                <span class="fw-bold me-3">
                    <i class="fas fa-cogs me-1"></i> Acciones Rápidas:
                </span>
                <div class="btn-group">
                    <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-clipboard-check me-1"></i> Control de Asistencia
                    </a>
                    <a href="{{ route('trabajadores.reportes') }}" class="btn btn-sm btn-info">
                        <i class="fas fa-chart-bar me-1"></i> Reportes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="ajaxResponse"></div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="ajaxResponse"></div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-top border-3 shadow-sm" style="border-color: #6F4F37 !important;">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title fw-bold">
                                <i class="fas fa-list me-1"></i> Listado de Trabajadores
                            </h3>
                            <div class="card-tools">
                                <div class="input-group">
                                    <input type="text" name="table_search" class="form-control" placeholder="Buscar trabajador...">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="trabajadoresTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="5%">ID</th>
                                        <th width="20%">Nombre</th>
                                        <th width="20%">Dirección</th>
                                        <th width="15%">Email</th>
                                        <th width="10%">Teléfono</th>
                                        <th width="10%">Contrato</th>
                                        <th width="10%">Pago</th>
                                        <th class="text-center" width="10%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($trabajadores as $trabajador)
                                        <tr data-id="{{ $trabajador->id }}">
                                            <td class="text-center">{{ $trabajador->id }}</td>
                                            <td class="nombre-trabajador fw-bold">{{ $trabajador->user->name }}</td>
                                            <td class="direccion-trabajador">{{ $trabajador->direccion }}</td>
                                            <td class="email-trabajador">
                                                <a href="mailto:{{ $trabajador->user->email }}">{{ $trabajador->user->email }}</a>
                                            </td>
                                            <td class="telefono-trabajador">{{ $trabajador->telefono }}</td>
                                            <td class="contrato-trabajador">
                                                <span class="badge bg-{{ $trabajador->tipo_contrato == 'Indefinido' ? 'success' : 
                                                    ($trabajador->tipo_contrato == 'Temporal' ? 'warning' : 
                                                    ($trabajador->tipo_contrato == 'Obra o labor' ? 'info' : 'secondary')) }}">
                                                    {{ $trabajador->tipo_contrato }}
                                                </span>
                                            </td>
                                            <td class="pago-trabajador">
                                                <i class="fas {{ $trabajador->forma_pago == 'Transferencia' ? 'fa-university' : 
                                                    ($trabajador->forma_pago == 'Efectivo' ? 'fa-money-bill-wave' : 'fa-money-check') }} me-1"></i>
                                                {{ $trabajador->forma_pago }}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-info ver-trabajador" 
                                                            data-id="{{ $trabajador->id }}" data-bs-toggle="tooltip" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-editar" 
                                                            data-id="{{ $trabajador->id }}" data-bs-toggle="tooltip" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar" 
                                                            data-id="{{ $trabajador->id }}" data-nombre="{{ $trabajador->user->name }}"
                                                            data-bs-toggle="tooltip" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No hay trabajadores registrados</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted">Total: <strong>{{ count($trabajadores) }}</strong> trabajadores</span>
                            </div>
                            <!-- Aquí iría la paginación si se implementa -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

            
            

<!-- Modal para Editar Trabajador (Bootstrap 5) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-user-edit me-2"></i> Editar Trabajador
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form id="formEditarTrabajador">
                @csrf
                <input type="hidden" id="trabajador_id" name="trabajador_id">
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="errorAlert"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">
                                    <i class="fas fa-user me-1"></i> Nombre
                                </label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">
                                    <i class="fas fa-phone me-1"></i> Teléfono
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="direccion" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i> Dirección
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo_contrato" class="form-label">
                                    <i class="fas fa-file-contract me-1"></i> Tipo de Contrato
                                </label>
                                <select class="form-select" id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="Indefinido">Indefinido</option>
                                    <option value="Temporal">Temporal</option>
                                    <option value="Obra o labor">Obra o labor</option>
                                    <option value="Prestación de servicios">Prestación de servicios</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="forma_pago" class="form-label">
                                    <i class="fas fa-money-bill-wave me-1"></i> Forma de Pago
                                </label>
                                <select class="form-select" id="forma_pago" name="forma_pago" required>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal para Ver Trabajador (Bootstrap 5) -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-user-circle me-2"></i> Detalles del Trabajador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-5x text-info"></i>
                    <h4 class="mt-2 view-nombre fw-bold"></h4>
                </div>
                
                <div class="card">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-envelope text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Email</small>
                                        <p class="mb-0 view-email"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-phone text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Teléfono</small>
                                        <p class="mb-0 view-telefono"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-map-marker-alt text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Dirección</small>
                                        <p class="mb-0 view-direccion"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-file-contract text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Tipo de Contrato</small>
                                        <p class="mb-0">
                                            <span class="badge bg-info view-contrato"></span>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-money-bill-wave text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Forma de Pago</small>
                                        <p class="mb-0 view-pago"></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal de confirmación para eliminar (Bootstrap 5) -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body text-center">
                <i class="fas fa-user-times fa-4x text-danger mb-3"></i>
                <p>¿Está seguro de eliminar al trabajador <strong id="delete-nombre"></strong>?</p>
                <p class="text-muted small">Esta acción no se puede deshacer.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmarEliminar">
                    <i class="fas fa-trash me-1"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection