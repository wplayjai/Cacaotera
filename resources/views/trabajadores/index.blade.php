@extends('layouts.masterr')

@section('content')

<link rel="stylesheet" href="{{ asset('css/trabajador/index.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="main-container">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-users me-2"></i>Gestión de Trabajadores
                </h1>
                <p class="page-subtitle">Control integral de trabajadores y recursos humanos</p>

                <!-- Breadcrumb simple -->
                <nav class="mt-2">
                    <small>
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                            <i class="fas fa-home me-1"></i>Inicio
                        </a>
                        <span class="text-muted mx-2">/</span>
                        <span class="text-dark">
                            <i class="fas fa-users me-1"></i>Trabajadores
                        </span>
                    </small>
                </nav>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button class="btn-simple btn-primary-simple" data-bs-toggle="modal" data-bs-target="#registrarTrabajadorModal">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Trabajador
                </button>
                <a href="{{ route('trabajadores.asistencia-unificada') }}" class="btn-simple btn-secondary-simple">
                    <i class="fas fa-clipboard-check me-2"></i>Asistencia
                </a>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="row stats-row">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-number">{{ $trabajadores->count() }}</div>
                <div class="stat-label">Total Trabajadores</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-number">{{ $trabajadores->where('user.estado', 'activo')->count() }}</div>
                <div class="stat-label">Trabajadores Activos</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card info">
                <div class="stat-number">{{ \App\Models\Asistencia::whereDate('fecha', today())->distinct('trabajador_id')->count() }}</div>
                <div class="stat-label">Asistencias Hoy</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-number">{{ $trabajadores->where('user.estado', 'inactivo')->count() }}</div>
                <div class="stat-label">Trabajadores Inactivos</div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-section">
        <form method="GET" action="{{ route('trabajadores.index') }}">
            <div class="row align-items-end">
                <div class="col-lg-4 col-md-4 mb-2">
                    <label class="form-label-simple">
                        <i class="fas fa-search me-1"></i>Buscar
                    </label>
                    <input type="text" name="search" class="form-control form-control-simple"
                           placeholder="Nombre, email o teléfono..." value="{{ request('search') }}" id="searchInput">
                </div>
                <div class="col-lg-2 col-md-3 mb-2">
                    <label class="form-label-simple">
                        <i class="fas fa-user-check me-1"></i>Estado
                    </label>
                    <select name="estado" class="form-select form-select-simple">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 mb-2">
                    <label class="form-label-simple">
                        <i class="fas fa-tools me-1"></i>Rol
                    </label>
                    <select name="role" class="form-select form-select-simple">
                        <option value="">Todos</option>
                        <option value="trabajador" {{ request('role') == 'trabajador' ? 'selected' : '' }}>Trabajador</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-8 mb-2">
                    <button type="submit" class="btn-simple btn-primary-simple me-2">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('trabajadores.index') }}" class="btn-simple btn-outline-simple me-2">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                    <a href="{{ route('trabajadores.reportes-unificados') }}" class="btn-simple btn-secondary-simple">
                        <i class="fas fa-chart-bar"></i> Reportes
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla -->
    <div class="table-section">
        <div class="table-header">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list me-2"></i>Registro de Trabajadores</span>
                <span class="badge-simple info">{{ $trabajadores->count() }} registros</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-simple">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Trabajador</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Rol</th>
                        <th>Última Asistencia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trabajadores as $trabajador)
                        <tr data-id="{{ $trabajador->id }}">
                            <td><strong>{{ $trabajador->id }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                        {{ strtoupper(substr($trabajador->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong class="nombre-trabajador">{{ $trabajador->user->name }}</strong>
                                        @if($trabajador->user->fecha_nacimiento)
                                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($trabajador->user->fecha_nacimiento)->age }} años</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="email-trabajador">
                                <div><a href="mailto:{{ $trabajador->user->email }}">{{ $trabajador->user->email }}</a></div>
                                @if($trabajador->user->email_verified_at)
                                    <small class="text-success"><i class="fas fa-check-circle"></i> Verificado</small>
                                @else
                                    <small class="text-dark"><i class="fas fa-exclamation-circle"></i> Sin verificar</small>
                                @endif
                            </td>
                            <td class="telefono-trabajador">
                                @if($trabajador->user->telefono)
                                    {{ $trabajador->user->telefono }}
                                @else
                                    <span class="text-muted">No especificado</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-simple {{ $trabajador->user->estado == 'activo' ? 'success' : 'warning' }}">
                                    {{ ucfirst($trabajador->user->estado) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-simple {{ $trabajador->user->role == 'admin' ? 'primary' : 'info' }}">
                                    {{ ucfirst($trabajador->user->role) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $ultimaAsistencia = \App\Models\Asistencia::where('trabajador_id', $trabajador->id)
                                        ->orderBy('fecha', 'desc')
                                        ->first();
                                @endphp
                                @if($ultimaAsistencia)
                                    <div>{{ $ultimaAsistencia->fecha->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $ultimaAsistencia->fecha->diffForHumans() }}</small>
                                @else
                                    <span class="text-muted">Sin registros</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-info btn-sm ver-trabajador"
                                            data-id="{{ $trabajador->id }}"
                                            title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm btn-editar"
                                            data-id="{{ $trabajador->id }}"
                                            title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar"
                                            data-id="{{ $trabajador->id }}"
                                            data-nombre="{{ $trabajador->user->name }}"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5>No hay trabajadores registrados</h5>
                                    <p>Haz clic en "Nuevo Trabajador" para comenzar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Botón de acción rápida para volver a recolecciones -->
    <div class="text-center mt-4">
        <a href="{{ route('recolecciones.index') }}" class="btn-simple btn-outline-simple">
            <i class="fas fa-arrow-left me-2"></i>Volver a Recolecciones
        </a>
    </div>
</div>

<!-- Modal para Registrar Nuevo Trabajador -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium));">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-user-edit me-2"></i> Editar Trabajador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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
                                <label for="role" class="form-label">
                                    <i class="fas fa-user-tag me-1"></i> Rol
                                </label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="trabajador">Trabajador</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modal-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary btn-modal-primary">
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
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #222, var(--cacao-light));">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-user-circle me-2"></i> Detalles del Trabajador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-5x view-icon"></i>
                    <h4 class="mt-2 view-nombre fw-bold"></h4>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-envelope fa-lg view-icon"></i>
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
                                        <i class="fas fa-phone fa-lg view-icon"></i>
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
                                        <i class="fas fa-user-tag fa-lg view-icon"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Rol</small>
                                        <p class="mb-0 view-role"></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-modal-secondary" data-bs-dismiss="modal">
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
            <div class="modal-header bg-danger text-white" style="background: linear-gradient(135deg, #dc3545, #c82333) !important;">
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
                <button type="button" class="btn btn-secondary btn-modal-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger btn-modal-danger" id="confirmarEliminar">
                    <i class="fas fa-trash me-1"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Registrar Nuevo Trabajador -->
<div class="modal fade" id="registrarTrabajadorModal" tabindex="-1" aria-labelledby="registrarTrabajadorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formRegistrarTrabajador" action="{{ route('trabajadores.store') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #8b6f47, #a0845c); color: white;">
                    <h5 class="modal-title" id="registrarTrabajadorModalLabel">
                        <i class="fas fa-user-plus me-2"></i> Registrar Nuevo Trabajador
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-user me-1 text-muted"></i> Nombre *
                            </label>
                            <input type="text" name="name" class="form-control" required placeholder="Ingrese el nombre">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-user-tag me-1 text-muted"></i> Apellidos
                            </label>
                            <input type="text" name="apellido" class="form-control" placeholder="Ingrese los apellidos">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-id-card me-1 text-muted"></i> Identificación *
                            </label>
                            <input type="text" name="identificacion" class="form-control" required placeholder="Número de identificación">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-envelope me-1 text-muted"></i> Correo Electrónico *
                            </label>
                            <input type="email" name="email" class="form-control" required placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt me-1 text-muted"></i> Dirección *
                            </label>
                            <input type="text" name="direccion" class="form-control" required placeholder="Dirección completa">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-phone me-1 text-muted"></i> Teléfono *
                            </label>
                            <input type="text" name="telefono" class="form-control" required placeholder="Número de teléfono">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-calendar-alt me-1 text-muted"></i> Fecha de Contratación *
                            </label>
                            <input type="date" name="fecha_contratacion" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-lock me-1 text-muted"></i> Contraseña *
                            </label>
                            <input type="password" name="password" class="form-control" required placeholder="Contraseña segura" minlength="6">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-file-contract me-1 text-muted"></i> Tipo de Contrato *
                            </label>
                            <select name="tipo_contrato" class="form-select" required>
                                <option value="">Seleccione el tipo de contrato</option>
                                <option value="Indefinido">Indefinido</option>
                                <option value="Temporal">Temporal</option>
                                <option value="Obra o labor">Obra o labor</option>
                                <option value="Prestación de servicios">Prestación de servicios</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave me-1 text-muted"></i> Forma de Pago *
                            </label>
                            <select name="forma_pago" class="form-select" required>
                                <option value="">Seleccione la forma de pago</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Registrar Trabajador
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Ver detalles del trabajador
    $(document).on('click', '.ver-trabajador', function() {
        const id = $(this).data('id');
        const row = $(`tr[data-id="${id}"]`);

        $('.view-nombre').text(row.find('.nombre-trabajador').text());
        $('.view-email').text(row.find('.email-trabajador a').text());
        $('.view-telefono').text(row.find('.telefono-trabajador').text());
        $('.view-role').text(row.find('td:nth-child(6) .badge-simple').text());

        $('#viewModal').modal('show');
    });

    // Editar trabajador
    $(document).on('click', '.btn-editar', function() {
        const id = $(this).data('id');
        const row = $(`tr[data-id="${id}"]`);

        $('#trabajador_id').val(id);
        $('#nombre').val(row.find('.nombre-trabajador').text().trim());
        $('#email').val(row.find('.email-trabajador a').text().trim());
        $('#telefono').val(row.find('.telefono-trabajador').text().trim());

        // Obtener el rol del badge
        const roleText = row.find('td:nth-child(6) .badge-simple').text().toLowerCase();
        $('#role').val(roleText);

        $('#errorAlert').addClass('d-none');
        $('#editModal').modal('show');
    });

    // Guardar cambios del trabajador
    $('#formEditarTrabajador').on('submit', function(e) {
        e.preventDefault();

        const id = $('#trabajador_id').val();

        $.ajax({
            url: '/trabajadores/' + id,
            method: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: $('#nombre').val(),
                email: $('#email').val(),
                telefono: $('#telefono').val(),
                role: $('#role').val()
            },
            success: function(response) {
                // Actualizar datos en la tabla
                const row = $(`tr[data-id="${id}"]`);
                row.find('.nombre-trabajador').text($('#nombre').val());
                row.find('.email-trabajador a').text($('#email').val());
                row.find('.email-trabajador a').attr('href', 'mailto:' + $('#email').val());
                row.find('.telefono-trabajador').text($('#telefono').val());

                // Actualizar rol
                const role = $('#role').val();
                const roleClass = role === 'admin' ? 'primary' : 'info';
                row.find('td:nth-child(6) .badge-simple').attr('class', 'badge-simple ' + roleClass);
                row.find('td:nth-child(6) .badge-simple').text(role.charAt(0).toUpperCase() + role.slice(1));

                // Cerrar modal y mostrar mensaje
                $('#editModal').modal('hide');

                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Trabajador actualizado correctamente',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                let errores = xhr.responseJSON ? xhr.responseJSON.errors : { error: ['Error al actualizar el trabajador'] };
                let mensajeError = '<ul class="mb-0">';

                for (const campo in errores) {
                    mensajeError += `<li>${errores[campo].join(', ')}</li>`;
                }

                mensajeError += '</ul>';

                $('#errorAlert')
                    .html(`<i class="fas fa-exclamation-triangle me-1"></i> ${mensajeError}`)
                    .removeClass('d-none');
            }
        });
    });

    // Eliminar trabajador
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');

        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar al trabajador ${nombre}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/trabajadores/' + id,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $(`tr[data-id="${id}"]`).fadeOut('slow', function() {
                            $(this).remove();
                        });

                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'Trabajador eliminado correctamente',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo eliminar el trabajador',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    // Función de búsqueda
    $('input[name="search"]').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();

        $('table tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            const found = rowText.indexOf(searchTerm) > -1;
            $(this).toggle(found);
        });
    });
});
</script>
@endsection
