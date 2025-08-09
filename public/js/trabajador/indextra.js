$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Ver detalles del trabajador
    $(document).on('click', '.ver-trabajador', function() {
        const id = $(this).data('id');
        const row = $(`tr[data-id="${id}"]`);

        $('.view-nombre').text(row.find('.nombre-trabajador').text());
        $('.view-email').text(row.find('.email-trabajador').text());
        $('.view-telefono').text(row.find('.telefono-trabajador').text());
        $('.view-direccion').text(row.find('.direccion-trabajador').text());
        $('.view-contrato').text(row.find('.contrato-trabajador').text());
        $('.view-pago').text(row.find('.pago-trabajador').text());

        $('#viewModal').modal('show');
    });

    // Editar trabajador
    $(document).on('click', '.btn-editar', function() {
        const id = $(this).data('id');
        const row = $(`tr[data-id="${id}"]`);

        $('#trabajador_id').val(id);
        $('#nombre').val(row.find('.nombre-trabajador').text().trim());
        $('#email').val(row.find('.email-trabajador a').text().trim());
        $('#telefono').val(row.find('.telefono-trabajador').text().trim());
        $('#direccion').val(row.find('.direccion-trabajador').text().trim());
        $('#tipo_contrato').val(row.find('.contrato-trabajador').text().trim());
        $('#forma_pago').val(row.find('.pago-trabajador').text().trim().replace(/^\S+\s+/, ''));

        $('#errorAlert').addClass('d-none');
        $('#editModal').modal('show');
    });

    // Guardar cambios del trabajador
    $('#formEditarTrabajador').on('submit', function(e) {
        e.preventDefault();

        const id = $('#trabajador_id').val();

        $.ajax({
            url: '/trabajadores/' + id,
            method: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                nombre: $('#nombre').val(),
                email: $('#email').val(),
                telefono: $('#telefono').val(),
                direccion: $('#direccion').val(),
                tipo_contrato: $('#tipo_contrato').val(),
                forma_pago: $('#forma_pago').val()
            },
            success: function(response) {
                // Actualizar datos en la tabla
                const row = $(`tr[data-id="${id}"]`);
                row.find('.nombre-trabajador').text($('#nombre').val());
                row.find('.email-trabajador a').text($('#email').val());
                row.find('.email-trabajador a').attr('href', 'mailto:' + $('#email').val());
                row.find('.telefono-trabajador').text($('#telefono').val());
                row.find('.direccion-trabajador').text($('#direccion').val());

                // Actualizar tipo de contrato con el badge correcto
                const tipoContrato = $('#tipo_contrato').val();
                let badgeClass = 'badge-secondary';

                if (tipoContrato === 'Indefinido') badgeClass = 'badge-success';
                else if (tipoContrato === 'Temporal') badgeClass = 'badge-warning';
                else if (tipoContrato === 'Obra o labor') badgeClass = 'badge-info';

                row.find('.contrato-trabajador span').attr('class', 'badge ' + badgeClass);
                row.find('.contrato-trabajador span').text(tipoContrato);

                // Actualizar forma de pago con el icono correcto
                const formaPago = $('#forma_pago').val();
                let iconClass = 'fa-money-check';

                if (formaPago === 'Transferencia') iconClass = 'fa-university';
                else if (formaPago === 'Efectivo') iconClass = 'fa-money-bill-wave';

                row.find('.pago-trabajador i').attr('class', 'fas ' + iconClass + ' mr-1');
                row.find('.pago-trabajador').html(`<i class="fas ${iconClass} mr-1"></i> ${formaPago}`);

                // Cerrar modal y mostrar mensaje
                $('#editModal').modal('hide');

                $('#ajaxResponse').html(
                    `<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-1"></i> Trabajador actualizado exitosamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`
                );

                // Ocultar alerta después de 3 segundos
                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 3000);
            },
            error: function(xhr) {
                // Mostrar errores
                let errores = xhr.responseJSON ? xhr.responseJSON.errors : { error: ['Error al actualizar el trabajador'] };
                let mensajeError = '<ul class="mb-0">';

                for (const campo in errores) {
                    mensajeError += `<li>${errores[campo].join(', ')}</li>`;
                }

                mensajeError += '</ul>';

                $('#errorAlert')
                    .html(`<i class="fas fa-exclamation-triangle mr-1"></i> ${mensajeError}`)
                    .removeClass('d-none');
            }
        });
    });

    // Mostrar modal de confirmación para eliminar
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');

        $('#delete-nombre').text(nombre);
        $('#confirmarEliminar').data('id', id);
        $('#deleteModal').modal('show');
    });

    // Eliminar trabajador
    $('#confirmarEliminar').on('click', function() {
        const id = $(this).data('id');

        $.ajax({
            url: '/trabajadores/' + id,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Eliminar fila de la tabla
                $(`tr[data-id="${id}"]`).fadeOut('slow', function() {
                    $(this).remove();

                    // Si no hay más trabajadores, mostrar mensaje
                    if ($('#trabajadoresTable tbody tr').length === 0) {
                        $('#trabajadoresTable tbody').html(`
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay trabajadores registrados</p>
                                </td>
                            </tr>
                        `);
                    }
                });

                // Cerrar modal
                $('#deleteModal').modal('hide');

                // Mostrar mensaje
                $('#ajaxResponse').html(
                    `<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-1"></i> Trabajador eliminado exitosamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`
                );

                // Actualizar contador de trabajadores
                const totalTrabajadores = $('#trabajadoresTable tbody tr').length - 1;
                $('.text-muted strong').text(totalTrabajadores);

                // Ocultar alerta después de 3 segundos
                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 3000);
            },
            error: function(xhr) {
                // Cerrar modal
                $('#deleteModal').modal('hide');

                // Mostrar error
                $('#ajaxResponse').html(
                    `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Error al eliminar el trabajador.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`
                );
            }
        });
    });

    // Búsqueda en tabla con resaltado
    $('input[name="table_search"]').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();

        $('#trabajadoresTable tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            const found = rowText.indexOf(searchTerm) > -1;

            $(this).toggle(found);

            // Remover resaltado anterior
            $(this).find('td').each(function() {
                const text = $(this).text();
                $(this).html($(this).html().replace(/<mark>|<\/mark>/gi, ''));
            });

            // Si se encuentra, resaltar coincidencias
            if (found && searchTerm.length > 0) {
                $(this).find('td').each(function() {
                    const regex = new RegExp(searchTerm, 'gi');
                    const text = $(this).text();

                    if (!$(this).hasClass('text-center') && text.toLowerCase().indexOf(searchTerm) > -1) {
                        $(this).html(text.replace(regex, function(match) {
                            return '<mark class="search-highlight">' + match + '</mark>';
                        }));
                    }
                });
            }
        });

        // Actualizar contador de resultados
        updateSearchCounter(searchTerm);
    });

    // Funcionalidad adicional para el botón de búsqueda
    $('#searchButton').on('click', function() {
        const searchValue = $('#searchInput').val();
        if (searchValue.trim() !== '') {
            $('input[name="table_search"]').val(searchValue).trigger('keyup');
        }
    });

    // Botón para limpiar búsqueda
    $('#clearSearch').on('click', function() {
        $('#searchInput').val('');
        $('input[name="table_search"]').val('').trigger('keyup');
        $(this).hide();
    });

    // Mostrar/ocultar botón de limpiar según el contenido del input
    $('#searchInput').on('input', function() {
        const value = $(this).val();
        if (value.length > 0) {
            $('#clearSearch').show();
        } else {
            $('#clearSearch').hide();
        }

        // Sincronizar con el input original
        $('input[name="table_search"]').val(value).trigger('keyup');
    });

    // Búsqueda con Enter
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            $('#searchButton').click();
        }
    });

    // Función para actualizar contador de resultados
    function updateSearchCounter(searchTerm) {
        const $visibleRows = $('#trabajadoresTable tbody tr:visible');
        const totalRows = $('#trabajadoresTable tbody tr').length;
        const visibleCount = $visibleRows.length;

        // Actualizar el contador en el footer
        const $footerText = $('.card-footer .text-muted');
        if (searchTerm && searchTerm.length > 0) {
            $footerText.html(`Mostrando <strong>${visibleCount}</strong> de <strong>${totalRows}</strong> trabajadores <small class="text-info">(filtrado por: "${searchTerm}")</small>`);
        } else {
            $footerText.html(`Total: <strong>${totalRows}</strong> trabajadores`);
        }

        // Mostrar mensaje si no hay resultados
        if (visibleCount === 0 && searchTerm && searchTerm.length > 0) {
            if ($('#no-results-message').length === 0) {
                const noResultsRow = `
                    <tr id="no-results-message">
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No se encontraron trabajadores que coincidan con "<strong>${searchTerm}</strong>"</p>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearSearch()">
                                <i class="fas fa-times me-1"></i> Limpiar búsqueda
                            </button>
                        </td>
                    </tr>
                `;
                $('#trabajadoresTable tbody').append(noResultsRow);
            }
        } else {
            $('#no-results-message').remove();
        }
    }

    // Función global para limpiar búsqueda
    window.clearSearch = function() {
        $('#searchInput').val('');
        $('#clearSearch').click();
    };

    // Inicializar estado del botón limpiar
    $('#clearSearch').hide();

    // Redirigir al dashboard del admin
    $('.trabajadores-back-btn').on('click', function() {
        window.location.href = 'http://127.0.0.1:8000/admin/dashboard';
    });
});
