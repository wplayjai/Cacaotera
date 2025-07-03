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

            {{-- ...dentro de tu sección de botones, reemplaza por esto... --}}
            <div class="row mb-3">
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inventoryModal">
                       <i class="fas fa-plus"></i> Crear
                    </button>
                    <a href="{{ route('inventario.salida') }}" class="btn btn-warning">Salida inventario
                        
                    </a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#listaSalidaModal">
                     Abrir Modal
                   </button>

                </div>
            </div>

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
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Tipo</th>
                                            <th class="text-center">Cantidad (por unidad)</th>
                                            <th class="text-center">Unidad de Medida</th>
                                            <th class="text-center">Precio Unitario</th>
                                            <th class="text-center">Fecha Registro</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inventarios as $producto)
                                            <tr data-id="{{ $producto->id }}">
                                                <td class="text-center">{{ $producto->id }}</td>
                                                <td class="text-center">{{ $producto->nombre }}</td>
                                                <td class="text-center">{{ $producto->tipo }}</td>
                                                <td class="text-center">{{ $producto->cantidad }}</td>
                                                <td class="text-center">{{ $producto->unidad_medida }}</td>
                                                <td class="text-center">${{ number_format($producto->precio_unitario, 2) }}</td>
                                                <td class="text-center">{{ $producto->fecha_registro }}</td>
                                                <td class="text-center">
                                                    @if($producto->estado == 'Óptimo')
                                                        ✅ Óptimo
                                                    @elseif($producto->estado == 'Por vencer')
                                                        ⚠️ Por vencer
                                                    @else
                                                        🔒 Restringido
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning btn-sm edit-producto-btn" data-id="{{ $producto->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
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
<div class="modal fade" id="inventoryModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
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
                        <label for="tipo">Tipo</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="Fertilizantes">Fertilizantes</option>
                            <option value="Pesticidas">Pesticidas</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad (por unidad)</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="unidad_medida">Unidad de Medida</label>
                        <select class="form-control" id="unidad_medida" name="unidad_medida" required>
                            <option value="">Seleccione</option>
                            <option value="kg">kg</option>
                            <option value="ml">ml</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="precio_unitario">Precio Unitario</label>
                        <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" min="0" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="Óptimo">✅ Óptimo</option>
                            <option value="Por vencer">⚠️ Por vencer</option>
                            <option value="Restringido">🔒 Restringido</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_registro">Fecha de Registro</label>
                        <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" required>
                    </div>
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal de confirmación de inventario creado -->
<div class="modal fade" id="inventarioCreadoModal" tabindex="-1" aria-labelledby="inventarioCreadoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="inventarioCreadoModalLabel">¡Inventario creado!</h5>
      </div>
      <div class="modal-body">
        El inventario se ha registrado correctamente.
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editProductForm">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Los mismos campos que el modal de crear, pero con IDs diferentes, por ejemplo: edit_nombre, edit_tipo, etc. -->
          <input type="hidden" id="edit_id" name="id">
          <div class="form-group">
            <label for="edit_nombre">Nombre</label>
            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
          </div>

          <div class="form-group">
            <label for="edit_tipo">Tipo</label>
            <select class="form-control" id="edit_tipo" name="tipo" required>
                <option value="">Seleccione un tipo</option>
                <option value="Fertilizantes">Fertilizantes</option>
                <option value="Pesticidas">Pesticidas</option>
            </select>
          </div>

          <div class="form-group">
            <label for="edit_cantidad">Cantidad (por unidad)</label>
            <input type="number" class="form-control" id="edit_cantidad" name="cantidad" min="1" required>
          </div>

          <div class="form-group">
            <label for="edit_unidad_medida">Unidad de Medida</label>
            <select class="form-control" id="edit_unidad_medida" name="unidad_medida" required>
                <option value="">Seleccione</option>
                <option value="kg">kg</option>
                <option value="ml">ml</option>
            </select>
          </div>

          <div class="form-group">
            <label for="edit_precio_unitario">Precio Unitario</label>
            <input type="number" class="form-control" id="edit_precio_unitario" name="precio_unitario" min="0" step="0.01" required>
          </div>

          <div class="form-group">
            <label for="edit_estado">Estado</label>
            <select class="form-control" id="edit_estado" name="estado" required>
                <option value="Óptimo">✅ Óptimo</option>
                <option value="Por vencer">⚠️ Por vencer</option>
                <option value="Restringido">🔒 Restringido</option>
            </select>
          </div>

          <div class="form-group">
            <label for="edit_fecha_registro">Fecha de Registro</label>
            <input type="date" class="form-control" id="edit_fecha_registro" name="fecha_registro" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Lista de Salida de Inventario -->
<div class="modal fade" id="listaSalidaModal" tabindex="-1" aria-labelledby="listaSalidaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="listaSalidaModalLabel">
          <i class="fas fa-list-alt"></i> Lista de Salida de Inventario
        </h5>
        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light">
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle" id="tablaListaSalida">
            <thead class="thead-dark">
              <tr>
                <th class="text-center">#</th>
                <<th>Nombre del Lote</th>
                <th>Tipo de Cacao</th>
                <th>Tipo</th>
                <th class="text-end">Cantidad</th>
                <th>Unidad</th>
                <th class="text-end">Precio Unitario</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Nombre del Insumo</th>

              </tr>
            </thead>
            <tbody style="background: #fff;">
              <!-- Aquí se llenará con JS -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cerrar
        </button>
      </div>
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
                        <td>${producto.tipo}</td>
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
                        <td>${producto.fecha_registro}</td>
                        <td>
                            ${
                                producto.estado === 'Óptimo' ? '✅ Óptimo' :
                                producto.estado === 'Por vencer' ? '⚠️ Por vencer' :
                                '🔒 Restringido'
                            }
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-producto-btn" data-id="${producto.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-producto-btn" data-id="${producto.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                $('#inventoryTable tbody').append(newRow);

                // Cierra el modal de registro
                $('#inventoryModal').modal('hide');
                $('#addProductForm')[0].reset();

                // Muestra el modal de confirmación
                $('#inventarioCreadoModal').modal('show');

                // Oculta el modal automáticamente después de 3 segundos
                setTimeout(function() {
                    $('#inventarioCreadoModal').modal('hide');
                }, 3000);
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

    // Llenar selects de lotes y tipo de cacao al abrir el modal de salida
    $('#salidaInventarioModal').on('show.bs.modal', function () {
        $.get('/lotes/lista', function(data) {
            let nombres = '';
            let tipos = '';
            // Evitar duplicados en tipo de cacao
            let tiposSet = new Set();
            data.forEach(function(lote) {
                nombres += `<option value="${lote.id}">${lote.nombre}</option>`;
                tiposSet.add(lote.tipo_cacao);
            });
            tiposSet.forEach(function(tipo){
                tipos += `<option value="${tipo}">${tipo}</option>`;
            });
            $('#lote_nombre').html('<option value="">Seleccione un lote</option>' + nombres);
            $('#tipo_cacao').html('<option value="">Seleccione tipo de cacao</option>' + tipos);
        });
    });

    $('#lote_nombre').on('change', function() {
        let tipo = $(this).find(':selected').data('tipo') || '';
        $('#tipo_cacao').val(tipo);
    });

    // Editar Producto - Cargar datos en el modal
    $(document).on('click', '.edit-producto-btn', function() {
        const id = $(this).data('id');
        const row = $(`tr[data-id="${id}"]`);
        $('#edit_id').val(id);
        $('#edit_nombre').val(row.find('td').eq(1).text());
        $('#edit_tipo').val(row.find('td').eq(2).text());
        $('#edit_cantidad').val(row.find('td').eq(3).find('input').val());
        $('#edit_unidad_medida').val(row.find('td').eq(4).text());
        $('#edit_precio_unitario').val(row.find('td').eq(5).text().replace('$', '').replace(',', ''));
        $('#edit_estado').val(row.find('td').eq(6).text().trim().split(' ')[0]);
        $('#edit_fecha_registro').val(row.find('td').eq(7).text());

        $('#editProductModal').modal('show');
    });

    // Actualizar Producto (AJAX) desde el modal de edición
    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#edit_id').val();
        $.ajax({
            url: `/inventario/${id}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                // Actualiza la fila en la tabla con los nuevos datos
                // O recarga la página para ver los cambios
                location.reload();
            },
            error: function(xhr) {
                alert('Error al actualizar el producto.');
            }
        });
    });

    // Mostrar lista de salida en el modal
   $('#listaSalidaModal').on('show.bs.modal', function () {
    $.ajax({
      url: '/salida-inventario/lista',
      method: 'GET',
      dataType: 'json',
      success: function (data) {
        const tbody = $('#tablaListaSalida tbody');
        tbody.empty(); // Limpiar tabla
        data.forEach((item, index) => {
 const fila = `
<tr>
  <td class="text-center">${index + 1}</td>
  <td>${item.lote_nombre || ''}</td>
  <td>${item.tipo_cacao || ''}</td>
  <td>${item.tipo || ''}</td>
  <td class="text-end">${item.cantidad || ''}</td>
  <td>${item.unidad_medida || ''}</td>
  <td class="text-end">$${item.precio_unitario || ''}</td>
  <td>${item.estado || ''}</td>
  <td>${item.fecha_registro || ''}</td>
  <td>${item.insumo_nombre || ''}</td>


</tr>`;
  tbody.append(fila);
});
      },
      error: function (xhr, status, error) {
        console.error('Error al cargar salidas:', error);
        alert('Error al cargar la lista de salidas de inventario.');
      }
    });
  });
    // Registrar Salida de Inventario (AJAX)
    $('#salidaInventarioForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '/salida-inventario',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#salidaInventarioModal').modal('hide');
                $('#salidaInventarioForm')[0].reset();
                alert(response.message);
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                let errorMessage = errors ? Object.values(errors).flat().join('\n') : 'Error al registrar la salida.';
                alert(errorMessage);
            }
        });
    });
});
</script>
@endsection



