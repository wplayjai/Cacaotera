$(document).ready(function() {
    // Actualizar información del lote cuando se selecciona
    $('#lote_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        const area = selectedOption.data('area');
        const capacidad = selectedOption.data('capacidad');
        const estado = selectedOption.data('estado');
        const tipoCacao = selectedOption.data('tipo-cacao');

        // Establecer automáticamente el tipo de cacao del lote seleccionado
        if (tipoCacao && $(this).val() !== '') {
            $('#tipo_cacao').val(tipoCacao);
        }

        // Mostrar advertencia si el lote está inactivo
        if (estado !== 'Activo') {
            $('#advertenciaLote').removeClass('d-none').text('Advertencia: El lote seleccionado está inactivo. Considere seleccionar un lote activo.');
        } else {
            $('#advertenciaLote').addClass('d-none').text('');
        }

        if (area && $(this).val() !== '') {
            $('#infoLote').show();
            $('#loteDetails').html(`
                <strong>Área:</strong> ${area} m²<br>
                <strong>Capacidad:</strong> ${capacidad} árboles<br>
                <strong>Estado:</strong> ${estado}<br>
                <strong>Tipo de Cacao:</strong> ${tipoCacao || 'No especificado'}
            `);

            // Mostrar área máxima disponible
            $('#areaMaxima').text(area);

            // Auto-llenar área asignada con el área del lote
            if (!$('#area_asignada').val()) {
                $('#area_asignada').val(area);
            }
        } else {
            $('#infoLote').hide();
            $('#areaMaxima').text('0');
        }
    });

    // Calcular duración entre fechas
    $('#fecha_inicio, #fecha_fin_esperada').change(function() {
        const fechaInicio = $('#fecha_inicio').val();
        const fechaFin = $('#fecha_fin_esperada').val();

        if (fechaInicio && fechaFin) {
            const inicio = new Date(fechaInicio);
            const fin = new Date(fechaFin);
            const diferencia = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));

            if (diferencia > 0) {
                $('#duracionInfo').show();
                $('#duracionTexto').text(`${diferencia} días (${Math.round(diferencia / 30)} meses aproximadamente)`);
            } else {
                $('#duracionInfo').hide();
            }
        } else {
            $('#duracionInfo').hide();
        }
    });

    // Calcular rendimiento por hectárea
    $('#area_asignada, #estimacion_produccion').on('input', function() {
        const area = parseFloat($('#area_asignada').val()) || 0;
        const rendimiento = parseFloat($('#estimacion_produccion').val()) || 0;

        if (area > 0 && rendimiento > 0) {
            // Convertir m² a hectáreas para el cálculo (1 hectárea = 10,000 m²)
            const areaHa = area / 10000;
            const rendimientoHa = (rendimiento / areaHa).toFixed(2);
            $('#rendimientoHa').text(rendimientoHa);
        } else {
            $('#rendimientoHa').text('0');
        }
    });

    // Validar área máxima
    $('#area_asignada').on('input', function() {
        const areaIngresada = parseFloat($(this).val()) || 0;
        const areaMaxima = parseFloat($('#areaMaxima').text()) || 0;

        // Limpiar validaciones anteriores
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback:not([data-error="area"])').remove();

        if (areaIngresada > areaMaxima && areaMaxima > 0) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback[data-error="area"]').length) {
                $(this).after('<div class="invalid-feedback" data-error="area">El área no puede exceder el área del lote (' + areaMaxima + ' m²)</div>');
            }
        }
    });

    // Validación de fechas
    $('#fecha_fin_esperada').change(function() {
        const fechaInicio = new Date($('#fecha_inicio').val());
        const fechaFin = new Date($(this).val());

        if (fechaInicio && fechaFin && fechaFin <= fechaInicio) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">La fecha fin debe ser posterior a la fecha inicio</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // Validación del formulario antes de enviar
    $('#produccionForm').submit(function(e) {
        e.preventDefault();
        let isValid = true;
        let missingFields = [];
        let advertencias = [];
        const selectedOption = $('#lote_id').find('option:selected');
        const estado = selectedOption.data('estado');

        if (!$('#lote_id').val()) {
            isValid = false;
            missingFields.push('Lote');
        }
        if (!$('#tipo_cacao').val()) {
            isValid = false;
            missingFields.push('Tipo de Cacao');
        }
        if (!$('#trabajadores').val()) {
            isValid = false;
            missingFields.push('Trabajadores');
        }
        if (!$('#fecha_inicio').val()) {
            isValid = false;
            missingFields.push('Fecha de Inicio');
        }
        if (!$('#fecha_fin_esperada').val()) {
            isValid = false;
            missingFields.push('Fecha Fin Esperada');
        }
        if (!$('#area_asignada').val()) {
            isValid = false;
            missingFields.push('Área');
        }
        if (!$('#estimacion_produccion').val()) {
            isValid = false;
            missingFields.push('Estimación de Producción');
        }

        // Si falta algo, mostrar error y no enviar
        if (!isValid) {
            alert('Por favor completa todos los campos requeridos: ' + missingFields.join(', '));
            return false;
        }

        // Si todo está bien, enviar el formulario
        this.submit();
    });
});

// Función para volver a la lista de producciones
function volverProduccion() {
    try {
        Swal.fire({
            title: '¿Cancelar registro?',
            text: 'Se perderán todos los datos ingresados',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'Continuar editando'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("produccion.index") }}';
            }
        });
    } catch (error) {
        console.warn('SweetAlert2 no disponible, redirigiendo directamente');
        if (confirm('¿Cancelar registro? Se perderán todos los datos ingresados.')) {
            window.location.href = '{{ route("produccion.index") }}';
        }
    }
}

function irAInicio() {
    window.location.href = '{{ route("home") }}';
}

// Función para calcular automáticamente valores
function calcularAutomatico() {
    const cantidad = parseFloat(document.getElementById('estimacion_produccion')?.value) || 0;
    const area = parseFloat(document.getElementById('area_asignada')?.value) || 0;

    if (cantidad > 0 && area > 0) {
        const rendimiento = cantidad / area;
        const costoEstimado = cantidad * 2500; // Precio estimado por kg

        const costoField = document.getElementById('costo_total');
        if (costoField) {
            costoField.value = costoEstimado.toFixed(2);
        }
    }
}
