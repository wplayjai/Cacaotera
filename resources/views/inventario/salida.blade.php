@extends('layouts.masterr')

@section('content')
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header bg-light py-3 mb-3 shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0" style="color: #8B4513;"><i class="fas fa-arrow-right me-2"></i>Salida de Inventario</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-end d-flex gap-2">
                        <button class="btn text-white" style="background: #6F4E37;" data-bs-toggle="modal" data-bs-target="#verSalidasModal">
                            <i class="fas fa-list me-1"></i>Ver Salidas
                        </button>
                        <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Volver al Inventario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="ajaxResponseSalida"></div>

            <!-- Formulario de Salida de Inventario -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow border-0" style="border-radius: 15px;">
                        <div class="card-header bg-gradient text-white border-0" style="background: linear-gradient(135deg, #8B4513, #6F4E37);">
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-arrow-right me-2"></i>Registrar Salida de Inventario
                            </h5>
                        </div>

                        <form id="salidaInventarioForm">
                            @csrf
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <!-- Producto -->
                                    <div class="col-12">
                                        <label for="insumo_id" class="form-label fw-semibold text-secondary">
                                            <i class="fas fa-box me-1"></i> Seleccionar Producto/Insumo
                                        </label>
                                        <select class="form-select shadow-sm" id="insumo_id" name="insumo_id" required>
                                            <option value="">Elegir producto...</option>
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}" 
                                                        data-precio="{{ $producto->precio_unitario }}" 
                                                        data-estado="{{ $producto->estado }}" 
                                                        data-fecha="{{ $producto->fecha_registro }}"
                                                        data-unidad="{{ $producto->unidad_medida }}"
                                                        data-tipo="{{ $producto->tipo }}"
                                                        data-disponible="{{ $producto->cantidad }}">
                                                    {{ $producto->nombre }} ({{ $producto->tipo }}) - {{ $producto->cantidad }} {{ $producto->unidad_medida }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Información del Producto -->
                                    <div class="col-12" id="producto-info" style="display: none;">
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <div class="card bg-light p-2 text-center">
                                                    <small class="text-muted">Precio</small>
                                                    <span class="fw-bold text-success" id="info_precio">--</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card bg-light p-2 text-center">
                                                    <small class="text-muted">Estado</small>
                                                    <span class="fw-bold" id="info_estado">--</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card bg-light p-2 text-center">
                                                    <small class="text-muted">Tipo</small>
                                                    <span class="fw-bold" id="info_tipo">--</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card bg-light p-2 text-center">
                                                    <small class="text-muted">Disponible</small>
                                                    <span class="fw-bold text-info" id="info_disponible">--</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card bg-light p-2 text-center">
                                                    <small class="text-muted">Unidad</small>
                                                    <span class="fw-bold" id="info_unidad">--</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card bg-light p-2 text-center">
                                                    <small class="text-muted">Registro</small>
                                                    <span class="fw-bold text-primary" id="info_fecha">--</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campos principales -->
                                    <div class="col-md-6">
                                        <label for="lote_id" class="form-label fw-semibold"><i class="fas fa-seedling me-1"></i>Lote</label>
                                        <select class="form-select" id="lote_id" name="lote_id">
                                            <option value="">Sin lote específico</option>
                                            @foreach($lotes as $lote)
                                                <option value="{{ $lote->id }}">{{ $lote->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cantidad" class="form-label fw-semibold"><i class="fas fa-balance-scale me-1"></i>Cantidad</label>
                                        <input type="number" class="form-control" id="cantidad" name="cantidad" step="0.001" min="0.001" required placeholder="Ej: 10.500">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="fecha_salida" class="form-label fw-semibold"><i class="fas fa-calendar me-1"></i>Fecha</label>
                                        <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" value="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="observaciones" class="form-label fw-semibold"><i class="fas fa-sticky-note me-1"></i>Observaciones</label>
                                        <input type="text" class="form-control" id="observaciones" name="observaciones" placeholder="Motivo...">
                                    </div>

                                    <!-- Campos ocultos -->
                                    <input type="hidden" id="unidad_medida" name="unidad_medida">
                                    <input type="hidden" id="precio_unitario" name="precio_unitario">
                                    <input type="hidden" id="estado" name="estado">
                                    <input type="hidden" id="fecha_registro" name="fecha_registro">
                                    <input type="hidden" id="produccion_id" name="produccion_id">
                                </div>
                            </div>

                            <div class="card-footer border-0 bg-light text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn text-white" style="background: #8B4513;">
                                        <i class="fas fa-check me-1"></i>Registrar Salida
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Ver Salidas -->
<div class="modal fade" id="verSalidasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #6F4E37, #8B4513);">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-list me-2"></i>Lista de Salidas de Inventario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Filtros -->
                <div class="p-3 bg-light border-bottom">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="filtroProducto" placeholder="🔍 Buscar producto...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filtroTipo">
                                <option value="">Todos los tipos</option>
                                <option value="Fertilizantes">🌱 Fertilizantes</option>
                                <option value="Pesticidas">🐛 Pesticidas</option>
                                <option value="Herramientas">🔧 Herramientas</option>
                                <option value="Equipos">⚙️ Equipos</option>
                                <option value="Otros">📦 Otros</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="filtroFecha" placeholder="Fecha">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary w-100" onclick="limpiarFiltros()">
                                <i class="fas fa-eraser me-1"></i>Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="max-height: 500px;">
                    <table class="table table-hover mb-0" id="tablaSalidas">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th class="text-center"><i class="fas fa-hashtag me-1"></i>ID</th>
                                <th><i class="fas fa-box me-1"></i>Producto</th>
                                <th class="text-center"><i class="fas fa-layer-group me-1"></i>Tipo</th>
                                <th class="text-center"><i class="fas fa-balance-scale me-1"></i>Cantidad</th>
                                <th class="text-center"><i class="fas fa-ruler me-1"></i>Unidad</th>
                                <th class="text-center"><i class="fas fa-dollar-sign me-1"></i>Precio</th>
                                <th class="text-center"><i class="fas fa-seedling me-1"></i>Lote</th>
                                <th class="text-center"><i class="fas fa-calendar me-1"></i>Fecha</th>
                                <th><i class="fas fa-sticky-note me-1"></i>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTablaSalidas">
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <!-- Estado vacío -->
                <div id="estadoVacio" class="text-center py-5 d-none">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay salidas registradas</h5>
                    <p class="text-muted">Las salidas aparecerán aquí cuando se registren</p>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100">
                    <small class="text-muted align-self-center">
                        <i class="fas fa-info-circle me-1"></i>Total: <span id="totalSalidas">0</span> salidas
                    </small>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Éxito -->
<div class="modal fade" id="modalExitoSalida" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="fw-bold mb-2 text-secondary">¡Salida Registrada!</h5>
                <p class="text-muted mb-3">La salida se registró correctamente.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    <button type="button" class="btn btn-sm text-white" style="background: #8B4513;" onclick="window.location.reload()">
                        <i class="fas fa-plus me-1"></i>Nueva Salida
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root { --coffee: #8B4513; --coffee-dark: #6F4E37; }
.form-control:focus, .form-select:focus { border-color: var(--coffee); box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25); }
.btn:hover { transform: translateY(-1px); transition: all 0.2s ease; }
.card { transition: transform 0.2s ease; }
.card:hover { transform: translateY(-2px); }
.table th { font-size: 0.9rem; font-weight: 600; }
.table td { font-size: 0.9rem; }
.sticky-top { position: sticky; top: 0; z-index: 1020; }
</style>
@endpush

@section('scripts')
<script>
$(document).ready(function() {
    // Cuando se seleccione un lote, buscar la producción activa y asignar el produccion_id
    $('#lote_id').on('change', function() {
        const loteId = $(this).val();
        if (loteId) {
            // AJAX para buscar la producción activa de ese lote
            $.get('/api/lotes/' + loteId + '/produccion-activa', function(data) {
                if (data && data.produccion_id) {
                    $('#produccion_id').val(data.produccion_id);
                } else {
                    $('#produccion_id').val('');
                }
            });
        } else {
            $('#produccion_id').val('');
        }
    });
    let cantidadOriginal = 0;
    
    // Configurar producto seleccionado
    $('#insumo_id').on('change', function() {
        const option = $(this).find('option:selected');
        if (option.val()) {
            $('#producto-info').fadeIn();
            const datos = {
                precio: option.data('precio') || '--',
                estado: option.data('estado') || '--',
                tipo: option.data('tipo') || '--',
                disponible: option.data('disponible') || 0,
                unidad: option.data('unidad') || '--',
                fecha: option.data('fecha') || '--'
            };
            cantidadOriginal = parseFloat(datos.disponible);
            
            $('#info_precio').text('$' + datos.precio);
            $('#info_tipo').text(datos.tipo);
            $('#info_disponible').text(datos.disponible);
            $('#info_unidad').text(datos.unidad);
            $('#info_fecha').text(datos.fecha);
            
            const estadoColors = { 'Óptimo': 'text-success', 'Por vencer': 'text-warning', 'Restringido': 'text-danger' };
            $('#info_estado').text(datos.estado).attr('class', 'fw-bold ' + (estadoColors[datos.estado] || 'text-primary'));
            
            $('#precio_unitario').val(datos.precio);
            $('#estado').val(datos.estado);
            $('#unidad_medida').val(datos.unidad);
            $('#fecha_registro').val(datos.fecha);
            $('#cantidad').attr('max', cantidadOriginal);
        } else {
            $('#producto-info').fadeOut();
            cantidadOriginal = 0;
        }
    });

    // Validar cantidad
    $('#cantidad').on('input', function() {
        const cantidadRetirar = parseFloat($(this).val()) || 0;
        const cantidadRestante = cantidadOriginal - cantidadRetirar;
        
        if (cantidadRetirar > cantidadOriginal) {
            $('#info_disponible').text('⚠️ INSUFICIENTE').removeClass('text-info').addClass('text-danger');
            $(this).addClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true);
        } else {
            $('#info_disponible').text(cantidadRestante.toFixed(3)).removeClass('text-danger').addClass('text-info');
            $(this).removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', false);
        }
    });

    // Enviar formulario
    $('#salidaInventarioForm').on('submit', function(e) {
        e.preventDefault();
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Procesando...').prop('disabled', true);

        $.ajax({
            url: '{{ route("salida-inventario.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#salidaInventarioForm')[0].reset();
                $('#producto-info').fadeOut();
                new bootstrap.Modal(document.getElementById('modalExitoSalida')).show();
                setTimeout(() => window.location.href = '{{ route("inventario.index") }}', 1500);
            },
            error: function(xhr) {
                submitBtn.html('<i class="fas fa-check me-1"></i>Registrar Salida').prop('disabled', false);
                let errorMessage = 'Error al registrar la salida.';
                if (xhr.responseJSON?.message) errorMessage = xhr.responseJSON.message;
                
                $('#ajaxResponseSalida').html(`
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle me-2"></i>${errorMessage}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
            }
        });
    });

    // Cargar salidas en modal
    $('#verSalidasModal').on('show.bs.modal', function() {
        cargarSalidas();
    });

    // Filtros
    $('#filtroProducto, #filtroTipo, #filtroFecha').on('input change', function() {
        filtrarSalidas();
    });
});

// Cargar todas las salidas
function cargarSalidas() {
    $('#cuerpoTablaSalidas').html('<tr><td colspan="9" class="text-center py-3"><i class="fas fa-spinner fa-spin me-2"></i>Cargando salidas...</td></tr>');
    
    $.ajax({
        url: '{{ route("salida-inventario.index") }}',
        method: 'GET',
        success: function(salidas) {
            let html = '';
            if (salidas.length > 0) {
                salidas.forEach(function(salida) {
                    const tipoIcon = { 'Fertilizantes': '🌱', 'Pesticidas': '🐛', 'Herramientas': '🔧', 'Equipos': '⚙️' }[salida.tipo] || '📦';
                    
                    html += `
                        <tr>
                            <td class="text-center fw-bold">${salida.id}</td>
                            <td>${salida.producto_nombre}</td>
                            <td class="text-center">${tipoIcon} ${salida.tipo}</td>
                            <td class="text-center">
                                <span class="badge bg-primary">${salida.cantidad}</span>
                            </td>
                            <td class="text-center">${salida.unidad_medida}</td>
                            <td class="text-center">
                                <span class="badge bg-success">$${salida.precio_unitario}</span>
                            </td>
                            <td class="text-center">${salida.lote_nombre || '<small class="text-muted">Sin lote</small>'}</td>
                            <td class="text-center">
                                <small>${new Date(salida.fecha_salida).toLocaleDateString('es-ES')}</small>
                            </td>
                            <td>
                                <small>${salida.observaciones || '<span class="text-muted">Sin observaciones</span>'}</small>
                            </td>
                        </tr>
                    `;
                });
                $('#estadoVacio').addClass('d-none');
            } else {
                $('#estadoVacio').removeClass('d-none');
            }
            
            $('#cuerpoTablaSalidas').html(html);
            $('#totalSalidas').text(salidas.length);
            window.salidasData = salidas;
        },
        error: function(xhr) {
            console.error('Error al cargar salidas:', xhr);
            $('#cuerpoTablaSalidas').html('<tr><td colspan="9" class="text-center text-danger py-3"><i class="fas fa-exclamation-triangle me-2"></i>Error al cargar las salidas</td></tr>');
        }
    });
}

// Filtrar salidas
function filtrarSalidas() {
    if (!window.salidasData) return;
    
    const filtroProducto = $('#filtroProducto').val().toLowerCase();
    const filtroTipo = $('#filtroTipo').val();
    const filtroFecha = $('#filtroFecha').val();
    
    const salidasFiltradas = window.salidasData.filter(salida => {
        const matchProducto = !filtroProducto || salida.producto_nombre.toLowerCase().includes(filtroProducto);
        const matchTipo = !filtroTipo || salida.tipo === filtroTipo;
        const matchFecha = !filtroFecha || salida.fecha_salida === filtroFecha;
        
        return matchProducto && matchTipo && matchFecha;
    });
    
    let html = '';
    salidasFiltradas.forEach(function(salida) {
        const tipoIcon = { 'Fertilizantes': '🌱', 'Pesticidas': '🐛', 'Herramientas': '🔧', 'Equipos': '⚙️' }[salida.tipo] || '📦';
        html += `
            <tr>
                <td class="text-center fw-bold">${salida.id}</td>
                <td>${salida.producto_nombre}</td>
                <td class="text-center">${tipoIcon} ${salida.tipo}</td>
                <td class="text-center"><span class="badge bg-primary">${salida.cantidad}</span></td>
                <td class="text-center">${salida.unidad_medida}</td>
                <td class="text-center"><span class="badge bg-success">$${salida.precio_unitario}</span></td>
                <td class="text-center">${salida.lote_nombre || '<small class="text-muted">Sin lote</small>'}</td>
                <td class="text-center"><small>${new Date(salida.fecha_salida).toLocaleDateString('es-ES')}</small></td>
                <td><small>${salida.observaciones || '<span class="text-muted">Sin observaciones</span>'}</small></td>
            </tr>
        `;
    });
    
    $('#cuerpoTablaSalidas').html(html);
    $('#totalSalidas').text(salidasFiltradas.length);
    
    if (salidasFiltradas.length === 0 && (filtroProducto || filtroTipo || filtroFecha)) {
        $('#cuerpoTablaSalidas').html('<tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-search-minus fa-2x mb-2"></i><br>No se encontraron resultados</td></tr>');
    }
}

// Limpiar filtros
function limpiarFiltros() {
    $('#filtroProducto, #filtroTipo, #filtroFecha').val('');
    filtrarSalidas();
}
</script>
@endsection
