@extends('layouts.master')

@section('content')
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gestión de Inventario</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                    <button class="btn btn-secondary inventory-back-btn">
                           <i class="fas fa-arrow-left"></i> Volver al Dashboard
                            </button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#inventoryModal">
                            <i class="fas fa-plus mr-1"></i> Agregar Producto
                        </button>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Listado de Productos</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped" id="inventoryTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Cantidad (kg)</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productos as $producto)
                                        <tr data-id="{{ $producto->id }}">
                                            <td>{{ $producto->id }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->tipo_insumo }}</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" class="form-control cantidad-input" value="{{ $producto->cantidad }}" data-id="{{ $producto->id }}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary update-cantidad-btn" data-id="{{ $producto->id }}">
                                                            <i class="fas fa-save"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $producto->estado == 'Óptimo' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $producto->estado }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm delete-producto-btn" data-id="{{ $producto->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Inventory Modal -->
<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="inventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inventoryModalLabel">Agregar Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProductForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                <label for="tipo_insumo">Tipo de Insumo</label>
                    <select class="form-control" id="tipo_insumo" name="tipo_insumo" required>
                      <option value="">Seleccione un tipo</option>
                      <option value="Cacao">Cacao</option>
                      <option value="Derivado">Derivado</option>
                      <option value="Insumo">Insumo</option>
                      <option value="Otros">Otros</option>
                  </select>
                </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad (kg)</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Agregar Producto (AJAX)
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("inventario.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Agregar nueva fila a la tabla
                const newRow = `
                    <tr data-id="${response.producto.id}">
                        <td>${response.producto.id}</td>
                        <td>${response.producto.nombre}</td>
                        <td>${response.producto.tipo}</td>
                        <td>
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control cantidad-input" value="${response.producto.cantidad}" data-id="${response.producto.id}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary update-cantidad-btn" data-id="${response.producto.id}">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge ${response.producto.estado === 'Óptimo' ? 'badge-success' : 'badge-warning'}">
                                ${response.producto.estado}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-producto-btn" data-id="${response.producto.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                $('#inventoryTable tbody').append(newRow);
                
                // Mostrar mensaje de éxito
                $('#ajaxResponse').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${response.message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
                
                // Cerrar modal
                $('#inventoryModal').modal('hide');
                
                // Limpiar formulario
                $('#addProductForm')[0].reset();
            },
            error: function(xhr) {
                // Manejar errores
                $('#ajaxResponse').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al agregar producto: ${xhr.responseJSON.message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            }
        });
    });

    // Actualizar Cantidad (AJAX)
    $(document).on('click', '.update-cantidad-btn', function() {
        const id = $(this).data('id');
        const cantidad = $(this).closest('td').find('.cantidad-input').val();
        const row = $(this).closest('tr');
        
        $.ajax({
            url: `/inventario/${id}`,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                cantidad: cantidad
            },
            success: function(response) {
                // Actualizar estado
                const badge = row.find('.badge');
                badge.removeClass('badge-success badge-warning')
                     .addClass(response.producto.estado === 'Óptimo' ? 'badge-success' : 'badge-warning')
                     .text(response.producto.estado);
                
                // Mostrar mensaje de éxito
                $('#ajaxResponse').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${response.message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            },
            error: function(xhr) {
                // Manejar errores
                $('#ajaxResponse').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al actualizar producto: ${xhr.responseJSON.message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            }
        });
    });

    // Eliminar Producto (AJAX)
    $(document).on('click', '.delete-producto-btn', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        if(confirm('¿Estás seguro de eliminar este producto?')) {
            $.ajax({
                url: `/inventario/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Eliminar fila de la tabla
                    row.remove();
                    
                    // Mostrar mensaje de éxito
                    $('#ajaxResponse').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                },
                error: function(xhr) {
                    // Manejar errores
                    $('#ajaxResponse').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error al eliminar producto: ${xhr.responseJSON.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }
            });
        }
    });
});
</script>
@endsection