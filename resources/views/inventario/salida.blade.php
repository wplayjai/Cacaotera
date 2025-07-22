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
                    <div class="float-sm-end">
                        <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver al Inventario
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

                                    <!-- Información del Producto en Celdas -->
                                    <div class="col-12" id="producto-info" style="display: none;">
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body p-2 text-center">
                                                        <i class="fas fa-dollar-sign text-success mb-1"></i>
                                                        <small class="d-block text-muted">Precio</small>
                                                        <span class="fw-bold text-success" id="info_precio">--</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body p-2 text-center">
                                                        <i class="fas fa-flag mb-1" id="icon_estado"></i>
                                                        <small class="d-block text-muted">Estado</small>
                                                        <span class="fw-bold" id="info_estado">--</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body p-2 text-center">
                                                        <i class="fas fa-tags text-purple mb-1"></i>
                                                        <small class="d-block text-muted">Tipo</small>
                                                        <span class="fw-bold text-purple" id="info_tipo">--</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body p-2 text-center">
                                                        <i class="fas fa-warehouse text-info mb-1"></i>
                                                        <small class="d-block text-muted">Disponible</small>
                                                        <span class="fw-bold text-info" id="info_disponible">--</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body p-2 text-center">
                                                        <i class="fas fa-ruler text-secondary mb-1"></i>
                                                        <small class="d-block text-muted">Unidad</small>
                                                        <span class="fw-bold text-secondary" id="info_unidad">--</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body p-2 text-center">
                                                        <i class="fas fa-calendar text-primary mb-1"></i>
                                                        <small class="d-block text-muted">Registro</small>
                                                        <span class="fw-bold text-primary" id="info_fecha">--</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lote y Cantidad -->
                                    <div class="col-md-6">
                                        <label for="lote_id" class="form-label fw-semibold text-secondary">
                                            <i class="fas fa-seedling me-1"></i> Lote (Opcional)
                                        </label>
                                        <select class="form-select shadow-sm" id="lote_id" name="lote_id">
                                            <option value="">Sin lote específico</option>
                                            @foreach($lotes as $lote)
                                                <option value="{{ $lote->id }}">{{ $lote->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cantidad" class="form-label fw-semibold text-secondary">
                                            <i class="fas fa-balance-scale me-1"></i> Cantidad a Retirar
                                        </label>
                                        <input type="number" class="form-control shadow-sm" id="cantidad" name="cantidad" 
                                               step="0.001" min="0.001" required placeholder="Ej: 10.500">
                                    </div>

                                    <!-- Fecha y Observaciones -->
                                    <div class="col-md-6">
                                        <label for="fecha_salida" class="form-label fw-semibold text-secondary">
                                            <i class="fas fa-calendar-alt me-1"></i> Fecha de Salida
                                        </label>
                                        <input type="date" class="form-control shadow-sm" id="fecha_salida" name="fecha_salida" 
                                               value="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="observaciones" class="form-label fw-semibold text-secondary">
                                            <i class="fas fa-sticky-note me-1"></i> Observaciones
                                        </label>
                                        <input type="text" class="form-control shadow-sm" id="observaciones" name="observaciones" 
                                               placeholder="Motivo de la salida...">
                                    </div>

                                    <!-- Campos ocultos -->
                                    <input type="hidden" id="unidad_medida" name="unidad_medida">
                                    <input type="hidden" id="precio_unitario" name="precio_unitario">
                                    <input type="hidden" id="estado" name="estado">
                                    <input type="hidden" id="fecha_registro" name="fecha_registro">
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
.form-control:focus, .form-select:focus {
    border-color: #8B4513;
    box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
}
.btn:hover { transform: translateY(-1px); transition: all 0.2s ease; }
.card { transition: transform 0.2s ease; }
.card:hover { transform: translateY(-2px); }
.shadow-sm { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important; }
.text-purple { color: #8e44ad !important; }
.fa-tags.text-purple { color: #8e44ad !important; }
</style>
@endpush

@section('scripts')
<script>
$(document).ready(function() {
    let cantidadOriginal = 0;
    
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
            const colorClass = estadoColors[datos.estado] || 'text-primary';
            $('#info_estado').text(datos.estado).attr('class', 'fw-bold ' + colorClass);
            $('#icon_estado').attr('class', 'fas fa-flag mb-1 ' + colorClass);

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

    $('#cantidad').on('input', function() {
        const cantidadRetirar = parseFloat($(this).val()) || 0;
        const cantidadRestante = cantidadOriginal - cantidadRetirar;
        
        if (cantidadRetirar > cantidadOriginal) {
            $('#info_disponible').text('⚠️ NO HAY SUFICIENTE').removeClass('text-info').addClass('text-danger');
            $(this).addClass('is-invalid');
            $('button[type="submit"]').prop('disabled', true);
        } else {
            $('#info_disponible').text(cantidadRestante.toFixed(3)).removeClass('text-danger').addClass('text-info');
            $(this).removeClass('is-invalid');
            $('button[type="submit"]').prop('disabled', false);
        }
    });

    $('#salidaInventarioForm').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Procesando...').prop('disabled', true);

        $.ajax({
            url: '{{ route("salida-inventario.store") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                insumo_id: $('#insumo_id').val(),
                lote_id: $('#lote_id').val() || null,
                cantidad: $('#cantidad').val(),
                unidad_medida: $('#unidad_medida').val(),
                precio_unitario: $('#precio_unitario').val(),
                estado: $('#estado').val(),
                fecha_registro: $('#fecha_registro').val(),
                fecha_salida: $('#fecha_salida').val(),
                observaciones: $('#observaciones').val()
            },
            success: function(response) {
                $('#salidaInventarioForm')[0].reset();
                $('#producto-info').fadeOut();
                new bootstrap.Modal(document.getElementById('modalExitoSalida')).show();
                setTimeout(() => window.location.href = '{{ route("inventario.index") }}', 1500);
            },
            error: function(xhr) {
                console.log('Error details:', xhr.responseJSON); // Para debugging
                submitBtn.html('<i class="fas fa-check me-1"></i>Registrar Salida').prop('disabled', false);
                
                let errorMessage = 'Error al registrar la salida.';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    // Errores de validación específicos
                    const errorDetails = Object.entries(xhr.responseJSON.errors)
                        .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                        .join('<br>');
                    errorMessage = `Error de validación:<br>${errorDetails}`;
                } else if (xhr.responseJSON?.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                $('#ajaxResponseSalida').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>${errorMessage}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
            }
        });
    });
});
</script>
@endsection
