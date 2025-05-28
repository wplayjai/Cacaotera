@extends('layouts.masterr')

@section('content')
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gestión de Inventario</h1>
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
                            <h3 class="card-title">Listado de Inventarios</h3>
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
                                            <th>Unidad de Medida</th>
                                            <th>Precio Unitario</th>
                                            <th>Fecha Registro</th>
                                            <th>Fecha Actualización</th>
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
                                            <td>{{ $producto->unidad_medida }}</td>
                                            <td>${{ number_format($producto->precio_unitario, 2) }}</td>
                                            <td>{{ $producto->created_at ? $producto->created_at->format('d/m/Y') : '' }}</td>
                                            <td>{{ $producto->updated_at ? $producto->updated_at->format('d/m/Y') : '' }}</td>
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

            <div class="row mb-3">
                <div class="col-12">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#inventoryModal">
                        <i class="fas fa-plus"></i> Crear
                    </button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
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
                        <label for="tipo_insumo">Tipo</label>
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

                    <div class="form-group">
                        <label for="unidad_medida">Unidad de Medida</label>
                        <select class="form-control" id="unidad_medida" name="unidad_medida" required>
                            <option value="">Seleccione</option>
                            <option value="kg">kg</option>
                            <option value="l">l</option>
                            <option value="unidad">unidad</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="precio_unitario">Precio Unitario</label>
                        <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" min="0" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="Óptimo">Óptimo</option>
                            <option value="Bajo">Bajo</option>
                        </select>
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
                const producto = response.producto;
                const newRow = `
                    <tr data-id="${producto.id}">
                        <td>${producto.id}</td>
                        <td>${producto.nombre}</td>
                        <td>${producto.tipo_insumo}</td>
                        <td>
                            <div class="input-group input-group-sm">
                                <input type="number" class="form-control cantidad-input" value="${producto.cantidad}" data-id="${producto.id}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary update-cantidad-btn" data-id="${producto.id}">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>${producto.unidad_medida}</td>
                        <td>$${parseFloat(producto.precio_unitario).toFixed(2)}</td>
                        <td>${producto.created_at ? producto.created_at.split(' ')[0].split('-').reverse().join('/') : ''}</td>
                        <td>${producto.updated_at ? producto.updated_at.split(' ')[0].split('-').reverse().join('/') : ''}</td>
                        <td>
                            <span class="badge ${producto.estado === 'Óptimo' ? 'badge-success' : 'badge-warning'}">
                                ${producto.estado}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-producto-btn" data-id="${producto.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                $('#inventoryTable tbody').append(newRow);
                
                $('#ajaxResponse').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${response.message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
                $('#inventoryModal').modal('hide');
                $('#addProductForm')[0].reset();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                let errorMessage = errors ? Object.values(errors).flat().join('<br>') : 'Error al guardar el producto.';
                $('#ajaxResponse').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${errorMessage}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
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
        const cantidad = $(`input.cantidad-input[data-id="${id}"]`).val();

        $.ajax({
            url: `/inventario/${id}`,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                cantidad: cantidad
            },
            success: function(response) {
                $('#ajaxResponse').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${response.message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            },
            error: function(xhr) {
                $('#ajaxResponse').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al actualizar cantidad.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            }
        });
    });

    // Eliminar Producto (AJAX)
    $(document).on('click', '.delete-producto-btn', function() {
        if (!confirm("¿Está seguro que desea eliminar este producto?")) return;

        const id = $(this).data('id');

        $.ajax({
            url: `/inventario/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $(`tr[data-id="${id}"]`).remove();
                $('#ajaxResponse').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${response.message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            },
            error: function(xhr) {
                $('#ajaxResponse').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al eliminar producto.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            }
        });
    });

    // Búsqueda rápida en la tabla
    $('input[name="table_search"]').on('keyup', function() {
        const term = $(this).val().toLowerCase();
        $('#inventoryTable tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.indexOf(term) > -1);
        });
    });
});
</script>
@endsection
