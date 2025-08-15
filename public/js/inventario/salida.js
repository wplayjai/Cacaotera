$(document).ready(function() {
    // Mostrar mensaje de carga JS
    console.log('%cCAMBIO JS: salida.js cargado correctamente', 'color: green; font-weight: bold; font-size: 16px');

    // Limpiar filtros al hacer clic en el botón Limpiar
    window.limpiarFiltros = function() {
        $('#filtroProducto').val('');
        $('#filtroTipo').val('');
        $('#filtroFecha').val('');
        $('#filtroProducto').trigger('input');
        $('#filtroTipo').trigger('change');
        $('#filtroFecha').trigger('input');
    };

    // Limpiar el campo de búsqueda al hacer clic en él
    $('#filtroProducto').on('click', function() {
        $(this).val('');
        $(this).trigger('input');
    });

    // Limpiar todos los filtros al hacer clic en cualquier parte de la página (excepto en los filtros)
    $(document).on('click', function(e) {
        if (!$(e.target).is('#filtroProducto, #filtroTipo, #filtroFecha, .btn-outline-secondary')) {
            $('#filtroProducto').val('');
            $('#filtroTipo').val('');
            $('#filtroFecha').val('');
            $('#filtroProducto').trigger('input');
            $('#filtroTipo').trigger('change');
            $('#filtroFecha').trigger('input');
        }
    });

    // Mostrar el modal de ver salidas al hacer clic en el botón 'Ver Salidas' del modal de éxito
    $(document).on('click', '#modalExitoSalida a[href], #modalExitoSalida button.btn-outline-secondary', function(e) {
        e.preventDefault();
        $('#modalExitoSalida').modal('hide');
        setTimeout(function() {
            new bootstrap.Modal(document.getElementById('verSalidasModal')).show();
        }, 400);
    });
    // Función para formatear fechas
    function formatearFecha(fecha) {
        if (!fecha) return '--';
        const date = new Date(fecha);
        return date.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    // Función para formatear moneda
    function formatearMoneda(valor) {
        if (!valor || valor === 0) return '$0.00';
        return '$' + parseFloat(valor).toLocaleString('es-ES', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Manejar cambio en la selección de producto
    $('#insumo_id').change(function() {
        const selectedOption = $(this).find('option:selected');

        if (selectedOption.val()) {
            // Mostrar información del producto con animación suave
            $('#producto-info').slideDown(300);

            // Actualizar información del producto
            $('#info_precio').text(formatearMoneda(selectedOption.data('precio')));
            $('#info_estado').text(selectedOption.data('estado') || '--');
            $('#info_tipo').text(selectedOption.data('tipo') || '--');
            $('#info_disponible').text(
                (selectedOption.data('disponible') || 0) + ' ' +
                (selectedOption.data('unidad') || '')
            );
            $('#info_unidad').text(selectedOption.data('unidad') || '--');
            $('#info_fecha').text(formatearFecha(selectedOption.data('fecha')));

            // Agregar clase de estado para colorear
            const estado = selectedOption.data('estado');
            $('#info_estado').removeClass('text-success text-warning text-danger');
            if (estado === 'Disponible') {
                $('#info_estado').addClass('text-success');
            } else if (estado === 'Agotado') {
                $('#info_estado').addClass('text-danger');
            } else {
                $('#info_estado').addClass('text-warning');
            }

            // Llenar campos ocultos
            $('#unidad_medida').val(selectedOption.data('unidad'));
            $('#precio_unitario').val(selectedOption.data('precio'));
            $('#estado').val(selectedOption.data('estado'));
            $('#fecha_registro').val(selectedOption.data('fecha'));

            // Configurar cantidad máxima
            const cantidadDisponible = selectedOption.data('disponible');
            $('#cantidad').attr('max', cantidadDisponible);
            $('#cantidad').attr('placeholder', `Máximo: ${cantidadDisponible}`);

        } else {
            // Ocultar información del producto
            $('#producto-info').slideUp(300);

            // Limpiar campos ocultos
            $('#unidad_medida, #precio_unitario, #estado, #fecha_registro').val('');
            $('#cantidad').removeAttr('max').attr('placeholder', 'Ej: 10.500');
        }
    });

    // Validación en tiempo real de cantidad
    $('#cantidad').on('input', function() {
        const cantidadIngresada = parseFloat($(this).val());
        const cantidadMaxima = parseFloat($(this).attr('max'));

        if (cantidadIngresada > cantidadMaxima) {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after(`<div class="invalid-feedback">
                    La cantidad no puede exceder ${cantidadMaxima}
                </div>`);
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    // Manejar envío del formulario
    $('#salidaInventarioForm').on('submit', function(e) {
        e.preventDefault();

        // Validaciones adicionales
        const cantidadIngresada = parseFloat($('#cantidad').val());
        const cantidadMaxima = parseFloat($('#cantidad').attr('max'));

        if (cantidadIngresada > cantidadMaxima) {
            Swal.fire({
                icon: 'error',
                title: 'Cantidad Inválida',
                text: `La cantidad no puede exceder ${cantidadMaxima}`,
                confirmButtonColor: 'var(--cacao-primary)'
            });
            return;
        }

        // Confirmar acción
        Swal.fire({
            title: '¿Confirmar Salida?',
            text: `Se registrará la salida de ${cantidadIngresada} unidades del producto seleccionado.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'var(--cacao-primary)',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check"></i> Sí, registrar',
            cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
            customClass: {
                popup: 'swal-cafe',
                confirmButton: 'btn-professional',
                cancelButton: 'btn-outline-professional'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                registrarSalida();
            }
        });
    });

    // Función para registrar la salida
   function registrarSalida() {
    const formData = new FormData($('#salidaInventarioForm')[0]);

    // ⬇️ Aquí es donde agregas la validación
    if (!$('#produccion_id').val() && $('#lote_id').val()) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo obtener la producción activa para el lote seleccionado.',
        });
        return; // detener el envío
    }

    // Debug: mostrar todos los datos del formulario
    console.log('=== DEBUG FORMULARIO ===');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    console.log('========================');

    // Mostrar loading
    Swal.fire({
        title: 'Procesando...',
        text: 'Registrando salida de inventario',
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: {
            popup: 'swal-cafe'
        },
        willOpen: () => {
            Swal.showLoading();
        }
    });

    console.log('URL para AJAX:', window.inventarioRoutes.salidaStore);

    $.ajax({
        url: window.inventarioRoutes.salidaStore,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Salida de inventario registrada correctamente',
                confirmButtonColor: 'var(--cacao-primary)',
                customClass: {
                    popup: 'swal-cafe',
                    confirmButton: 'btn-professional'
                }
            }).then(() => {
                $('#salidaInventarioForm')[0].reset();
                $('#producto-info').slideUp(300);
                $('#cantidad').removeClass('is-invalid').next('.invalid-feedback').remove();
            });
        },
    }).catch((error) => {
        console.error('Error en la solicitud AJAX:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo registrar la salida de inventario.',
            confirmButtonColor: 'var(--cacao-primary)',
            customClass: {
                popup: 'swal-cafe',
                confirmButton: 'btn-professional'
            }
        });
    });
}

    // Cuando se seleccione un lote, buscar la producción activa y asignar el produccion_id
    $('#lote_id').on('change', function() {
        const loteId = $(this).val();
        if (loteId) {
            // AJAX para buscar la producción activa de ese lote
            $.get('/api/lotes/' + loteId + '/produccion-activa', function(data) {
                if (data && data.success && data.produccion && data.produccion.id) {
                    $('#produccion_id').val(data.produccion.id);
                } else {
                    $('#produccion_id').val('');
                }
            });
        } else {
            $('#produccion_id').val('');
        }
    });

    // Animación de entrada
    $('.fade-in-up').addClass('show');

    // Cargar salidas en modal
    $('#verSalidasModal').on('show.bs.modal', function() {
        cargarSalidas();
    });

    // Filtros de búsqueda
    $('#filtroProducto, #filtroTipo, #filtroFecha').on('input change', function() {
        filtrarSalidas();
    });
});

// Cargar todas las salidas
function cargarSalidas() {
    $('#cuerpoTablaSalidas').html('<tr><td colspan="9" class="text-center py-3"><i class="fas fa-spinner fa-spin me-2"></i>Cargando salidas...</td></tr>');

    $.ajax({
        url: window.inventarioRoutes.salidaIndex,
        method: 'GET',
        success: function(salidas) {
            let html = '';
            if (salidas.length > 0) {
                salidas.forEach(function(salida) {
                    const tipoIcon = {
                        'Fertilizantes': '🌱',
                        'Pesticidas': '🐛',
                        'Herramientas': '🔧',
                        'Equipos': '⚙️'
                    }[salida.tipo] || '📦';

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
        const tipoIcon = {
            'Fertilizantes': '🌱',
            'Pesticidas': '🐛',
            'Herramientas': '🔧',
            'Equipos': '⚙️'
        }[salida.tipo] || '📦';

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

// Manejo de accesibilidad para modales
$(document).ready(function() {
    // Cuando se abre el modal de ver salidas
    $('#verSalidasModal').on('shown.bs.modal', function() {
        cargarSalidas();
        // Enfocar el primer elemento focusable
        $(this).find('input, button').first().focus();
    });

    // Cuando se cierra cualquier modal, asegurar que el foco regrese correctamente
    $('.modal').on('hidden.bs.modal', function() {
        // Remover cualquier foco residual
        $(document.activeElement).blur();
        // Enfocar el body para evitar problemas de accesibilidad
        $('body').focus();
    });

    // Prevenir problemas de foco en el cierre del modal
    $('[data-bs-dismiss="modal"]').on('click', function() {
        const modal = $(this).closest('.modal');
        modal.modal('hide');
    });
});
