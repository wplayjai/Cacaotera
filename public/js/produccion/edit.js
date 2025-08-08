$(document).ready(function() {
    // Calcular rendimiento inicial
    calcularRendimiento();
    
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
                <strong>Área:</strong> ${area} m² (${(area / 10000).toFixed(2)} ha)<br>
                <strong>Capacidad:</strong> ${capacidad} árboles<br>
                <strong>Estado:</strong> ${estado}<br>
                <strong>Tipo de Cacao:</strong> ${tipoCacao || 'No especificado'}
            `);
        } else {
            $('#infoLote').hide();
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
        calcularRendimiento();
    });
    
    function calcularRendimiento() {
        const area = parseFloat($('#area_asignada').val()) || 0;
        const rendimiento = parseFloat($('#estimacion_produccion').val()) || 0;
        
        if (area > 0 && rendimiento > 0) {
            const rendimientoHa = (rendimiento / area).toFixed(2);
            $('#rendimientoHa').text(rendimientoHa);
        } else {
            $('#rendimientoHa').text('0');
        }
    }

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
            missingFields.push('Área Asignada');
        }
        if (!$('#estimacion_produccion').val()) {
            isValid = false;
            missingFields.push('Rendimiento Esperado');
        }
        
        // Verificar si el lote está inactivo
        if (estado !== 'Activo') {
            advertencias.push('El lote seleccionado está inactivo.');
        }
        
        if (!isValid) {
            Swal.fire({
                title: 'Campos Requeridos',
                text: 'Por favor completa los siguientes campos: ' + missingFields.join(', '),
                icon: 'warning',
                confirmButtonText: 'Entendido',
                customClass: {
                    popup: 'swal-cafe'
                }
            });
            return;
        }
        
        if (advertencias.length > 0) {
            Swal.fire({
                title: 'Advertencia',
                text: advertencias.join('\n'),
                icon: 'warning',
                confirmButtonText: 'Entendido',
                customClass: {
                    popup: 'swal-cafe'
                }
            });
            return;
        }
        
        Swal.fire({
            title: '¿Actualizar Producción?',
            text: 'Se guardarán los cambios realizados',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'var(--cacao-primary)',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'swal-cafe'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // Inicializar información del lote seleccionado al cargar la página
    $('#lote_id').trigger('change');
    
    // Calcular duración inicial
    $('#fecha_inicio').trigger('change');
});

// Funciones de navegación
function volverProduccion() {
    try {
        window.location.href = "{{ route('produccion.index') }}";
    } catch (error) {
        // Fallback en caso de error
        window.location.href = "/produccion";
    }
}

function irAInicio() {
    try {
        window.location.href = "{{ route('home') }}";
    } catch (error) {
        // Fallback en caso de error
        window.location.href = "/home";
    }
}

// Estilos SweetAlert2 personalizados para café
const style = document.createElement('style');
style.textContent = `
    .swal-cafe {
        background: var(--cacao-white);
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .swal-cafe .swal2-title {
        color: var(--cacao-text);
        font-weight: 700;
    }
    
    .swal-cafe .swal2-content {
        color: var(--cacao-muted);
    }
    
    .swal-cafe .swal2-confirm {
        background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary)) !important;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(74, 55, 40, 0.3);
    }
    
    .swal-cafe .swal2-cancel {
        background: linear-gradient(135deg, #6c757d, #495057) !important;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
`;
document.head.appendChild(style);