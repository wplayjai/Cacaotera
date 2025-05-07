@extends('layouts.masterr')

@section('content')
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header bg-light py-3 mb-3 shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary"><i class="fas fa-users mr-2"></i>Gestión de Trabajadores</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <button class="btn btn-outline-secondary trabajadores-back-btn">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </button>
                        <a href="{{ route('trabajadores.create') }}" class="btn btn-success">
                            <i class="fas fa-user-plus mr-1"></i> Registrar Trabajador
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title text-bold">
                                    <i class="fas fa-list mr-1"></i> Listado de Trabajadores
                                </h3>
                                <div class="card-tools">
                                    <div class="input-group input-group">
                                        <input type="text" name="table_search" class="form-control" 
                                               placeholder="Buscar trabajador...">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="trabajadoresTable">
                                    <thead class="thead-light">
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
                                                <td class="nombre-trabajador font-weight-bold">{{ $trabajador->user->name }}</td>
                                                <td class="direccion-trabajador">{{ $trabajador->direccion }}</td>
                                                <td class="email-trabajador">
                                                    <a href="mailto:{{ $trabajador->user->email }}">
                                                        {{ $trabajador->user->email }}
                                                    </a>
                                                </td>
                                                <td class="telefono-trabajador">{{ $trabajador->telefono }}</td>
                                                <td class="contrato-trabajador">
                                                    <span class="badge badge-{{ $trabajador->tipo_contrato == 'Indefinido' ? 'success' : 
                                                        ($trabajador->tipo_contrato == 'Temporal' ? 'warning' : 
                                                        ($trabajador->tipo_contrato == 'Obra o labor' ? 'info' : 'secondary')) }}">
                                                        {{ $trabajador->tipo_contrato }}
                                                    </span>
                                                </td>
                                                <td class="pago-trabajador">
                                                    <i class="fas {{ $trabajador->forma_pago == 'Transferencia' ? 'fa-university' : 
                                                        ($trabajador->forma_pago == 'Efectivo' ? 'fa-money-bill-wave' : 'fa-money-check') }} mr-1"></i>
                                                    {{ $trabajador->forma_pago }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-info ver-trabajador" 
                                                                data-id="{{ $trabajador->id }}" data-toggle="tooltip" title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-warning btn-editar" 
                                                                data-id="{{ $trabajador->id }}" data-toggle="tooltip" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar" 
                                                                data-id="{{ $trabajador->id }}" data-nombre="{{ $trabajador->user->name }}"
                                                                data-toggle="tooltip" title="Eliminar">
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
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="card-title text-bold">
                                <i class="fas fa-cogs mr-1"></i> Acciones Adicionales
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-lg btn-primary mx-2">
                                    <i class="fas fa-clipboard-check fa-2x d-block mb-2"></i> Control de Asistencia
                                </a>
                                <a href="{{ route('trabajadores.reportes') }}" class="btn btn-lg btn-info mx-2">
                                    <i class="fas fa-chart-bar fa-2x d-block mb-2"></i> Reportes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Editar Trabajador -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-user-edit mr-2"></i> Editar Trabajador
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarTrabajador">
                @csrf
                <input type="hidden" id="trabajador_id" name="trabajador_id">
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="errorAlert"></div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre"><i class="fas fa-user mr-1"></i> Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope mr-1"></i> Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono"><i class="fas fa-phone mr-1"></i> Teléfono</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion"><i class="fas fa-map-marker-alt mr-1"></i> Dirección</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_contrato"><i class="fas fa-file-contract mr-1"></i> Tipo de Contrato</label>
                                <select class="form-control" id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="Indefinido">Indefinido</option>
                                    <option value="Temporal">Temporal</option>
                                    <option value="Obra o labor">Obra o labor</option>
                                    <option value="Prestación de servicios">Prestación de servicios</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="forma_pago"><i class="fas fa-money-bill-wave mr-1"></i> Forma de Pago</label>
                                <select class="form-control" id="forma_pago" name="forma_pago" required>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Ver Trabajador -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-user-circle mr-2"></i> Detalles del Trabajador
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-5x text-info"></i>
                    <h4 class="mt-2 view-nombre font-weight-bold"></h4>
                </div>
                
                <div class="card">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="mr-3">
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
                                    <div class="mr-3">
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
                                    <div class="mr-3">
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
                                    <div class="mr-3">
                                        <i class="fas fa-file-contract text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Tipo de Contrato</small>
                                        <p class="mb-0">
                                            <span class="badge badge-info view-contrato"></span>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="mr-3">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-user-times fa-4x text-danger mb-3"></i>
                <p>¿Está seguro de eliminar al trabajador <strong id="delete-nombre"></strong>?</p>
                <p class="text-muted small">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmarEliminar">
                    <i class="fas fa-trash mr-1"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Ver detalles del trabajador
    $(document).on('click', '.ver-trabajador', function() {
        const id = $(this).data('id');
        const row = $(`tr[data-id="${id}"]`);
        
        $('.view-nombre').text(row.find('.nombre-trabajador').text());
        $('.view-email').text(row.find('.email-trabajador').text());
        $('.view-telefono').text(row.find('.telefono-trabajador').text());
        $('.view-direccion').text(row.find('.direccion-trabajador').text());
        $('.view-contrato').text(row.find('.contrato-trabajador').text());
        $('.view-pago').text(row.find('.pago-trabajador').text());
        
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
        $('#direccion').val(row.find('.direccion-trabajador').text().trim());
        $('#tipo_contrato').val(row.find('.contrato-trabajador').text().trim());
        $('#forma_pago').val(row.find('.pago-trabajador').text().trim().replace(/^\S+\s+/, ''));
        
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
                nombre: $('#nombre').val(),
                email: $('#email').val(),
                telefono: $('#telefono').val(),
                direccion: $('#direccion').val(),
                tipo_contrato: $('#tipo_contrato').val(),
                forma_pago: $('#forma_pago').val()
            },
            success: function(response) {
                // Actualizar datos en la tabla
                const row = $(`tr[data-id="${id}"]`);
                row.find('.nombre-trabajador').text($('#nombre').val());
                row.find('.email-trabajador a').text($('#email').val());
                row.find('.email-trabajador a').attr('href', 'mailto:' + $('#email').val());
                row.find('.telefono-trabajador').text($('#telefono').val());
                row.find('.direccion-trabajador').text($('#direccion').val());
                
                // Actualizar tipo de contrato con el badge correcto
                const tipoContrato = $('#tipo_contrato').val();
                let badgeClass = 'badge-secondary';
                
                if (tipoContrato === 'Indefinido') badgeClass = 'badge-success';
                else if (tipoContrato === 'Temporal') badgeClass = 'badge-warning';
                else if (tipoContrato === 'Obra o labor') badgeClass = 'badge-info';
                
                row.find('.contrato-trabajador span').attr('class', 'badge ' + badgeClass);
                row.find('.contrato-trabajador span').text(tipoContrato);
                
                // Actualizar forma de pago con el icono correcto
                const formaPago = $('#forma_pago').val();
                let iconClass = 'fa-money-check';
                
                if (formaPago === 'Transferencia') iconClass = 'fa-university';
                else if (formaPago === 'Efectivo') iconClass = 'fa-money-bill-wave';
                
                row.find('.pago-trabajador i').attr('class', 'fas ' + iconClass + ' mr-1');
                row.find('.pago-trabajador').html(`<i class="fas ${iconClass} mr-1"></i> ${formaPago}`);
                
                // Cerrar modal y mostrar mensaje
                $('#editModal').modal('hide');
                
                $('#ajaxResponse').html(
                    `<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-1"></i> Trabajador actualizado exitosamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`
                );
                
                // Ocultar alerta después de 3 segundos
                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 3000);
            },
            error: function(xhr) {
                // Mostrar errores
                let errores = xhr.responseJSON ? xhr.responseJSON.errors : { error: ['Error al actualizar el trabajador'] };
                let mensajeError = '<ul class="mb-0">';
                
                for (const campo in errores) {
                    mensajeError += `<li>${errores[campo].join(', ')}</li>`;
                }
                
                mensajeError += '</ul>';
                
                $('#errorAlert')
                    .html(`<i class="fas fa-exclamation-triangle mr-1"></i> ${mensajeError}`)
                    .removeClass('d-none');
            }
        });
    });
    
    // Mostrar modal de confirmación para eliminar
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        
        $('#delete-nombre').text(nombre);
        $('#confirmarEliminar').data('id', id);
        $('#deleteModal').modal('show');
    });
    
    // Eliminar trabajador
    $('#confirmarEliminar').on('click', function() {
        const id = $(this).data('id');
        
        $.ajax({
            url: '/trabajadores/' + id,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Eliminar fila de la tabla
                $(`tr[data-id="${id}"]`).fadeOut('slow', function() {
                    $(this).remove();
                    
                    // Si no hay más trabajadores, mostrar mensaje
                    if ($('#trabajadoresTable tbody tr').length === 0) {
                        $('#trabajadoresTable tbody').html(`
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay trabajadores registrados</p>
                                </td>
                            </tr>
                        `);
                    }
                });
                
                // Cerrar modal
                $('#deleteModal').modal('hide');
                
                // Mostrar mensaje
                $('#ajaxResponse').html(
                    `<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-1"></i> Trabajador eliminado exitosamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`
                );
                
                // Actualizar contador de trabajadores
                const totalTrabajadores = $('#trabajadoresTable tbody tr').length - 1;
                $('.text-muted strong').text(totalTrabajadores);
                
                // Ocultar alerta después de 3 segundos
                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 3000);
            },
            error: function(xhr) {
                // Cerrar modal
                $('#deleteModal').modal('hide');
                
                // Mostrar error
                $('#ajaxResponse').html(
                    `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Error al eliminar el trabajador.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`
                );
            }
        });
    });
    
    // Búsqueda en tabla con resaltado
    $('input[name="table_search"]').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $('#trabajadoresTable tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            const found = rowText.indexOf(searchTerm) > -1;
            
            $(this).toggle(found);
            
            // Remover resaltado anterior
            $(this).find('td').each(function() {
                const text = $(this).text();
                $(this).html($(this).html().replace(/<mark>|<\/mark>/gi, ''));
            });
            
            // Si se encuentra, resaltar coincidencias
            if (found && searchTerm.length > 0) {
                $(this).find('td').each(function() {
                    const regex = new RegExp(searchTerm, 'gi');
                    const text = $(this).text();
                    
                    if (!$(this).hasClass('text-center') && text.toLowerCase().indexOf(searchTerm) > -1) {
                        $(this).html(text.replace(regex, function(match) {
                            return '<mark>' + match + '</mark>';
                        }));
                    }
                });
            }
        });
    });
    
    // Redirigir al dashboard del admin
    $('.trabajadores-back-btn').on('click', function() {
        window.location.href = 'http://127.0.0.1:8000/admin/dashboard';
    });
});
</script>
@endsection