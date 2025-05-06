/*
 * Gestión de Trabajadores
 * Script para manejar las operaciones AJAX de la gestión de trabajadores
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM cargado - trabajadores.js iniciado");
    
    // Variable para almacenar el modal
    let editModal;
    
    // Inicializar el modal cuando se carga la página
    if (document.getElementById('editModal')) {
        editModal = new bootstrap.Modal(document.getElementById('editModal'));
        console.log("Modal inicializado");
    }
    
    // Verificamos que jQuery esté disponible
    if (typeof $ === 'undefined') {
        console.error("jQuery no está cargado. Asegúrate de incluir jQuery antes de este script.");
        return;
    }
    
    // Token CSRF para todas las solicitudes AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    console.log("CSRF token configurado para AJAX");
    
    // ===== ELIMINAR TRABAJADOR =====
    $(document).on('click', '.btn-eliminar', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const nombreTrabajador = $(this).data('nombre');
        
        console.log(`Botón eliminar clickeado para ID: ${id}, nombre: ${nombreTrabajador}`);
        
        if (confirm(`¿Está seguro que desea eliminar al trabajador ${nombreTrabajador}?`)) {
            eliminarTrabajador(id);
        }
    });
    
    function eliminarTrabajador(id) {
        console.log(`Enviando solicitud DELETE para trabajador ID: ${id}`);
        
        $.ajax({
            url: `/trabajadores/${id}`,
            type: 'DELETE',
            success: function(response) {
                console.log("Respuesta de eliminación:", response);
                
                // Eliminar la fila de la tabla
                $(`tr[data-id="${id}"]`).fadeOut('slow', function() {
                    $(this).remove();
                    
                    // Verificar si no hay más trabajadores y mostrar mensaje
                    if ($('table tbody tr').length === 0) {
                        $('table tbody').append('<tr><td colspan="9" class="text-center">No hay trabajadores registrados</td></tr>');
                    }
                });
                
                // Mostrar mensaje de éxito
                mostrarAlerta('success', 'Trabajador eliminado correctamente');
            },
            error: function(xhr) {
                console.error("Error en eliminación:", xhr.responseText);
                mostrarAlerta('danger', 'Error al eliminar el trabajador');
            }
        });
    }
    
    // ===== EDITAR TRABAJADOR =====
    $(document).on('click', '.btn-editar', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        
        console.log(`Botón editar clickeado para ID: ${id}`);
        
        // Cargar datos del trabajador para editar
        $.ajax({
            url: `/trabajadores/${id}/edit`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log("Datos del trabajador recibidos:", response);
                
                // Llenar el formulario en el modal con los datos del trabajador
                $('#trabajador_id').val(response.id);
                $('#nombre').val(response.user.name);
                $('#direccion').val(response.direccion);
                $('#identificacion').val(response.user.identificacion);
                $('#email').val(response.user.email);
                $('#telefono').val(response.telefono);
                $('#tipo_contrato').val(response.tipo_contrato);
                $('#forma_pago').val(response.forma_pago);
                
                // Limpiar cualquier mensaje de error previo
                $('#editModal .alert-danger').addClass('d-none').html('');
                
                // Mostrar el modal
                if (editModal) {
                    editModal.show();
                } else {
                    console.error("El modal no está inicializado correctamente");
                    alert("Error al mostrar el formulario de edición");
                }
            },
            error: function(xhr) {
                console.error("Error al cargar datos:", xhr.responseText);
                alert('Error al cargar los datos del trabajador');
            }
        });
    });
    
    // ===== ENVIAR FORMULARIO DE EDICIÓN =====
    $('#formEditarTrabajador').on('submit', function(e) {
        e.preventDefault();
        const id = $('#trabajador_id').val();
        
        console.log(`Enviando formulario de edición para ID: ${id}`);
        
        $.ajax({
            url: `/trabajadores/${id}`,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                console.log("Respuesta de actualización:", response);
                
                if (response.success) {
                    // Actualizar los datos en la tabla
                    const trabajador = response.trabajador;
                    const fila = $(`tr[data-id="${id}"]`);
                    
                    fila.find('.nombre-trabajador').text(trabajador.user.name);
                    fila.find('.direccion-trabajador').text(trabajador.direccion);
                    fila.find('.identificacion-trabajador').text(trabajador.user.identificacion);
                    fila.find('.email-trabajador').text(trabajador.user.email);
                    fila.find('.telefono-trabajador').text(trabajador.telefono);
                    fila.find('.contrato-trabajador').text(trabajador.tipo_contrato);
                    fila.find('.pago-trabajador').text(trabajador.forma_pago);
                    
                    // Cerrar el modal
                    if (editModal) {
                        editModal.hide();
                    }
                    
                    // Mostrar mensaje de éxito
                    mostrarAlerta('success', 'Trabajador actualizado correctamente');
                }
            },
            error: function(xhr) {
                console.error("Error en actualización:", xhr.responseText);
                
                // Mostrar errores de validación
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errores = xhr.responseJSON.errors;
                    let mensajeError = '<ul>';
                    
                    for (const campo in errores) {
                        mensajeError += `<li>${errores[campo][0]}</li>`;
                    }
                    
                    mensajeError += '</ul>';
                    $('#editModal .alert-danger').html(mensajeError).removeClass('d-none');
                } else {
                    $('#editModal .alert-danger').html('Error al actualizar el trabajador').removeClass('d-none');
                }
            }
        });
    });
    
    // ===== FUNCIÓN PARA MOSTRAR ALERTAS =====
    function mostrarAlerta(tipo, mensaje) {
        const alertaHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Agregar la alerta al principio del contenedor
        $('.container').prepend(alertaHTML);
        
        // Remover automáticamente después de 5 segundos
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }
});