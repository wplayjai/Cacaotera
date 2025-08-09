/**
 * JavaScript para la vista de creación de recolecciones
 * Archivo: public/js/recolecciones/create.js
 */

// Configuración global (se pasa desde Blade)
let createConfig = window.createConfig || {};

$(document).ready(function() {
    // Actualizar información cuando cambia la producción seleccionada
    $('#produccion_id').on('change', function() {
        const option = $(this).find('option:selected');
        const estimacion = parseFloat(option.data('estimacion')) || 0;
        const recolectado = parseFloat(option.data('recolectado')) || 0;

        if (estimacion > 0) {
            const pendiente = Math.max(0, estimacion - recolectado);
            const progreso = Math.min(100, (recolectado / estimacion) * 100);

            $('#estimacion').text(estimacion.toFixed(2));
            $('#recolectado').text(recolectado.toFixed(2));
            $('#pendiente').text(pendiente.toFixed(2));
            $('#progreso').text(progreso.toFixed(1));
            $('#barraProgreso').css('width', progreso + '%');

            // Cambiar color de la barra según el progreso
            $('#barraProgreso').removeClass('bg-danger bg-warning bg-success')
                .addClass(progreso < 50 ? 'bg-danger' : progreso < 80 ? 'bg-warning' : 'bg-success');

            $('#infoProduccion').removeClass('d-none');
        } else {
            $('#infoProduccion').addClass('d-none');
        }
    });

    // Validar cantidad ingresada
    $('#cantidad_recolectada').on('input', function() {
        const option = $('#produccion_id').find('option:selected');
        const estimacion = parseFloat(option.data('estimacion')) || 0;
        const recolectado = parseFloat(option.data('recolectado')) || 0;
        const cantidad = parseFloat($(this).val()) || 0;

        if (estimacion > 0 && cantidad > 0) {
            const nuevoTotal = recolectado + cantidad;
            const porcentaje = (nuevoTotal / estimacion) * 100;

            if (porcentaje > 120) {
                $(this).addClass('is-invalid');
                if (!$(this).next('.invalid-feedback').length) {
                    $(this).after('<div class="invalid-feedback">Esta cantidad excede significativamente la estimación del lote.</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        }
    });

    // Trigger inicial si hay producción preseleccionada
    if ($('#produccion_id').val()) {
        $('#produccion_id').trigger('change');
    }

    // Validación de formulario
    $('#recoleccionForm').on('submit', function(e) {
        const trabajadores = $('#trabajadores_participantes').val();
        if (!trabajadores || trabajadores.length === 0) {
            e.preventDefault();

            // Usar SweetAlert2 si está disponible, sino alert normal
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Trabajadores requeridos',
                    text: 'Debe seleccionar al menos un trabajador participante.',
                    confirmButtonColor: '#4a3728'
                });
            } else {
                alert('Debe seleccionar al menos un trabajador participante.');
            }
            return false;
        }

        const horaInicio = $('#hora_inicio').val();
        const horaFin = $('#hora_fin').val();

        if (horaInicio && horaFin && horaFin <= horaInicio) {
            e.preventDefault();

            // Usar SweetAlert2 si está disponible, sino alert normal
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en horarios',
                    text: 'La hora de fin debe ser posterior a la hora de inicio.',
                    confirmButtonColor: '#4a3728'
                });
            } else {
                alert('La hora de fin debe ser posterior a la hora de inicio.');
            }
            return false;
        }
    });

    // Auto-resize del textarea de observaciones
    $('#observaciones').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Validación en tiempo real para mejor UX
    $('.form-control, .form-select').on('input change', function() {
        if (this.checkValidity()) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
        }
    });

    // Efectos visuales adicionales
    $('.form-control, .form-select').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
});
