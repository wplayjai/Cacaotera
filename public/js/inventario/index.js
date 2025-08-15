// Configurar CSRF token para AJAX
// Configurar CSRF token para AJAX usando el meta tag
const metaCsrf = document.querySelector('meta[name="csrf-token"]');
if (metaCsrf) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': metaCsrf.getAttribute('content')
        }
    });
}

$(document).ready(function() {
    // Limpiar errores
    function limpiarErrores() { $('.alert-danger, .alert-error, .invalid-feedback').hide().remove(); $('.is-invalid').removeClass('is-invalid'); $('#ajaxResponse, #ajaxResponseEdit').empty(); }
    limpiarErrores(); $('.modal').on('show.bs.modal', limpiarErrores); setInterval(limpiarErrores, 2000);

    // Fecha actual
    const hoy = new Date().toISOString().split('T')[0];
    function setFecha() { $('#fecha_registro, #edit_fecha_registro').val(hoy); }
    setFecha(); $('#nuevoProductoModal, #editarProductoModal').on('show.bs.modal', setFecha);

    // Limpieza de modales
    $('#nuevoProductoModal').on('hidden.bs.modal', function() { $(this).find('form')[0].reset(); $(this).find('.is-invalid').removeClass('is-invalid'); $('#ajaxResponse').empty(); });
    $('#editarProductoModal').on('hidden.bs.modal', function() { $(this).find('.is-invalid').removeClass('is-invalid'); $('#ajaxResponseEdit').empty(); });
    $('#confirmarEliminarModal').on('hidden.bs.modal', function() { $('#productoEliminar').val(''); $('#nombreProductoEliminar').text(''); });
    $('.modal').on('hide.bs.modal', function() { $('body').removeClass('modal-open'); $('.modal-backdrop').remove(); });

    // Auto-asignación tipo/unidad
    function configurarAutoasignacion(nombre, tipo, unidad) {
        $(nombre).on('change', function() {
            const option = $(this).find('option:selected');
            const tipoVal = option.data('tipo'), unidadVal = option.data('unidad');
            if (tipoVal && unidadVal) {
                $(tipo).prop('disabled', false).val(tipoVal).prop('disabled', true);
                $(unidad).prop('disabled', false).val(unidadVal).prop('disabled', true);
            }
        });
    }
    configurarAutoasignacion('#nombre', '#tipo', '#unidad_medida');
    configurarAutoasignacion('#edit_nombre', '#edit_tipo', '#edit_unidad_medida');

    // Validaciones y funciones auxiliares
    $('#cantidad, #edit_cantidad').on('input', function() { if ($(this).val().length > 5) $(this).val($(this).val().slice(0, 5)); });
    $('#precio_unitario, #edit_precio_unitario').on('input', function() { if ($(this).val().length > 6) $(this).val($(this).val().slice(0, 6)); });

    function mostrarModalExito() { $('.modal-backdrop').remove(); $('body').removeClass('modal-open'); new bootstrap.Modal(document.getElementById('modalExitoInventario')).show(); setTimeout(() => window.location.reload(), 1500); }
    window.actualizarTiempoReal = function() { const ahora = new Date(); $('#lastUpdate').text(ahora.toLocaleDateString('es-ES') + ' ' + ahora.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})); };
    setInterval(window.actualizarTiempoReal, 30000);

    // Editar producto
    $(document).on('click', '.edit-producto-btn', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const btn = $(this);
        const originalText = btn.html();

        btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
        limpiarErrores();

        $.ajax({
            url: `${RUTA_INVENTARIO}/${id}`,

            type: 'GET',
            success: function(producto) {
                $('#edit_id').val(producto.id);
                $('#edit_nombre').val(producto.nombre);
                $('#edit_cantidad').val(producto.cantidad);
                $('#edit_precio_unitario').val(producto.precio_unitario);
                $('#edit_estado').val(producto.estado);
                $('#edit_fecha_registro').val(producto.fecha_registro);

                const option = $(`#edit_nombre option[value="${producto.nombre}"]`);
                const tipo = option.data('tipo') || producto.tipo;
                const unidad = option.data('unidad') || producto.unidad_medida;

                if (tipo && unidad) {
                    $('#edit_tipo').prop('disabled', false).val(tipo).prop('disabled', true);
                    $('#edit_unidad_medida').prop('disabled', false).val(unidad).prop('disabled', true);
                }

                btn.html(originalText).prop('disabled', false);
                new bootstrap.Modal(document.getElementById('editarProductoModal')).show();
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                btn.html(originalText).prop('disabled', false);
                alert('Error al cargar los datos del producto. Intente nuevamente.');
            }
        });
    });

    // Guardar edición
    $('#editarProductoForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const id = $('#edit_id').val();
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();

        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Actualizando...').prop('disabled', true);

        // Habilitar campos para enviar
        $('#edit_tipo, #edit_unidad_medida').prop('disabled', false);

        $.ajax({
             url: `${RUTA_INVENTARIO}/${id}`,
            method: 'PUT',
            data: form.serialize(),
            success: function(response) {
                submitBtn.html(originalText).prop('disabled', false);
                bootstrap.Modal.getInstance(document.getElementById('editarProductoModal')).hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                mostrarModalExito();
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                submitBtn.html(originalText).prop('disabled', false);
                $('#edit_tipo, #edit_unidad_medida').prop('disabled', true);
                alert('Error al actualizar el producto. Verifique los datos e intente nuevamente.');
            }
        });
    });

    // Eliminar producto
    $(document).on('click', '.delete-producto-btn', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        const nombre = row.find('td').eq(0).text().trim();

        $('#productoEliminar').val(id);
        $('#nombreProductoEliminar').text(nombre);
        new bootstrap.Modal(document.getElementById('confirmarEliminarModal')).show();
    });

    $('#confirmarEliminarBtn').on('click', function() {
        const id = $('#productoEliminar').val();
        const btn = $(this);
        const originalText = btn.html();

        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Eliminando...').prop('disabled', true);

        $.ajax({
             url: `${RUTA_INVENTARIO}/${id}`,
            method: 'DELETE',
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('confirmarEliminarModal')).hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                btn.html(originalText).prop('disabled', false);
                mostrarModalExito();
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                bootstrap.Modal.getInstance(document.getElementById('confirmarEliminarModal')).hide();
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                btn.html(originalText).prop('disabled', false);
                alert('Error al eliminar el producto. Intente nuevamente.');
            }
        });
    });

    // Agregar producto
    $('#nuevoProductoForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this), submitBtn = form.find('button[type="submit"]'), originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Guardando...').prop('disabled', true);
        $('#tipo, #unidad_medida').prop('disabled', false);
        $.ajax({
            url: typeof RUTA_INVENTARIO !== 'undefined' ? RUTA_INVENTARIO : '/inventario',
            method: 'POST',
            data: form.serialize(),
            success: function() {
                submitBtn.html(originalText).prop('disabled', false);
                $('#tipo, #unidad_medida').prop('disabled', true);
                bootstrap.Modal.getInstance(document.getElementById('nuevoProductoModal')).hide();
                form[0].reset();
                mostrarModalExito();
            },
            error: function() {
                submitBtn.html(originalText).prop('disabled', false);
                $('#tipo, #unidad_medida').prop('disabled', true);
                setTimeout(() => window.location.reload(), 1000);
            }
        });
    });

    // Variables globales para búsqueda simple
    let searchTerm = '';

    // Función para filtrar tabla - solo búsqueda
    function filtrarTablaSimple() {
        let visibleCount = 0;
        const rows = $('#inventoryTable tbody tr[data-id]');

        rows.each(function() {
            const row = $(this);
            const texto = row.text().toLowerCase();

            const mostrar = !searchTerm || texto.includes(searchTerm.toLowerCase());

            if (mostrar) {
                row.show();
                visibleCount++;
            } else {
                row.hide();
            }
        });

        // Actualizar contador
        const totalCount = rows.length;
        $('#totalProductos').text(visibleCount);

        // Mostrar mensaje si no hay resultados
        $('#noResultsMessage').remove();
        if (visibleCount === 0 && totalCount > 0 && searchTerm) {
            $('#inventoryTable tbody').append(`
                <tr id="noResultsMessage">
                    <td colspan="10" class="text-center py-5">
                        <div class="no-results">
                            <i class="fas fa-search-minus fa-3x mb-3 text-muted"></i>
                            <h5 class="text-muted">No se encontraron productos</h5>
                            <p class="text-muted">No hay productos que coincidan con "${searchTerm}"</p>
                            <button class="btn btn-professional btn-sm" onclick="limpiarBusqueda()">
                                <i class="fas fa-undo me-1"></i>Limpiar Búsqueda
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        }
    }

    // Búsqueda simple
    $('#searchInput').on('input', function() {
        searchTerm = $(this).val();
        filtrarTablaSimple();
    });

    // Limpiar búsqueda
    window.limpiarBusqueda = function() {
        searchTerm = '';
        $('#searchInput').val('');
        $('#noResultsMessage').remove();
        filtrarTablaSimple();
    };

    // Exportar tabla - solo productos visibles
    window.exportarTabla = function() {
        let csv = 'ID,Producto,Fecha,Cantidad,Unidad,Precio,Valor Total,Tipo,Estado\n';

        $('#inventoryTable tbody tr[data-id]:visible').each(function() {
            const cells = $(this).find('td');
            const row = [
                cells.eq(0).text().trim(),
                cells.eq(1).text().trim().replace(/\n/g, ' '),
                cells.eq(2).text().trim().replace(/\n/g, ' '),
                cells.eq(3).text().trim(),
                cells.eq(4).text().trim(),
                cells.eq(5).text().trim(),
                cells.eq(6).text().trim(),
                cells.eq(7).text().trim(),
                cells.eq(8).text().trim()
            ];
            csv += row.map(cell => `"${cell}"`).join(',') + '\n';
        });

        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `inventario_${new Date().toISOString().split('T')[0]}.csv`;
        link.click();
        window.URL.revokeObjectURL(url);
    };

    // Búsqueda simple original (comentado para usar la nueva)
    // $('#searchInput').on('input', function() {
    //     const term = $(this).val().toLowerCase(); $('#noResultsMessage').remove(); let visibleCount = 0;
    //     $('#inventoryTable tbody tr[data-id]').each(function() {
    //         const row = $(this), text = row.text().toLowerCase(), matches = text.includes(term) || term === '';
    //         row.toggle(matches); if (matches) visibleCount++;
    //     });
    //     if (visibleCount === 0 && term !== '') {
    //         $('#inventoryTable tbody').append(`<tr id="noResultsMessage"><td colspan="8" class="text-center py-4"><i class="fas fa-search-minus fa-2x text-muted mb-2"></i><h6 class="text-muted">No se encontraron productos</h6><button class="btn btn-sm btn-brown" onclick="$('#searchInput').val('').trigger('input')">Limpiar</button></td></tr>`);
    //     }
    //     const total = $('#inventoryTable tbody tr[data-id]').length; $('#totalProductos').text(term === '' ? total : `${visibleCount} de ${total}`);
    // });

    // Funcionalidad de búsqueda mejorada - Búsqueda inteligente por cualquier parte del texto
    $('#searchInput').on('input keyup', function() {
        const searchTerm = $(this).val().toLowerCase().trim();
        let visibleCount = 0;
        let foundResults = false;

        // Limpiar mensajes anteriores
        $('#noResultsMessage').remove();

        // Si no hay texto de búsqueda, mostrar todas las filas
        if (searchTerm === '') {
            $('#inventoryTable tbody tr[data-id]').show();
            const totalRows = $('#inventoryTable tbody tr[data-id]').length;
            $('#totalProductos').text(totalRows);
            $('#showingCount').text(totalRows);
            $('#totalCount').text(totalRows);
            return;
        }

        // Filtrar filas basado en el texto de búsqueda
        $('#inventoryTable tbody tr[data-id]').each(function() {
            const row = $(this);

            // Obtener texto de las columnas principales para búsqueda
            const productName = row.find('td:nth-child(2) .fw-bold').text().toLowerCase();
            const productType = row.find('td:nth-child(8)').text().toLowerCase();
            const productState = row.find('td:nth-child(9)').text().toLowerCase();
            const productId = row.find('td:nth-child(1)').text().toLowerCase();

            // Búsqueda inteligente: buscar en cualquier parte del texto
            const searchInName = productName.includes(searchTerm);
            const searchInType = productType.includes(searchTerm);
            const searchInState = productState.includes(searchTerm);
            const searchInId = productId.includes(searchTerm);

            // También buscar por palabras separadas
            const nameWords = productName.split(' ');
            const searchInWords = nameWords.some(word => word.startsWith(searchTerm) || word.includes(searchTerm));

            if (searchInName || searchInType || searchInState || searchInId || searchInWords) {
                row.show();
                visibleCount++;
                foundResults = true;

                // Resaltar el texto coincidente
                highlightSearchText(row, searchTerm);
            } else {
                row.hide();
            }
        });

        // Mostrar mensaje si no hay resultados
        if (!foundResults && searchTerm !== '') {
            const noResultsRow = `
                <tr id="noResultsMessage" class="no-results-row">
                    <td colspan="10" class="text-center py-5">
                        <div class="no-results">
                            <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                            <h5 class="text-muted">No se encontraron productos</h5>
                            <p class="text-muted mb-3">No hay productos que coincidan con "<strong>${searchTerm}</strong>"</p>
                            <small class="text-muted mb-3">
                                💡 <strong>Sugerencias:</strong><br>
                                • Intente con menos letras<br>
                                • Busque por tipo: "fertilizante" o "pesticida"<br>
                                • Busque por estado: "óptimo", "vencer", "restringido"
                            </small><br>
                            <button class="btn btn-professional btn-sm" onclick="$('#searchInput').val('').trigger('input')">
                                <i class="fas fa-times me-1"></i>Limpiar búsqueda
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            $('#inventoryTable tbody').append(noResultsRow);
        }

        // Actualizar contadores
        const totalRows = $('#inventoryTable tbody tr[data-id]').length;
        $('#totalProductos').text(`${visibleCount} de ${totalRows}`);
        $('#showingCount').text(visibleCount);
        $('#totalCount').text(totalRows);
    });

    // Función para resaltar texto coincidente - mejorada
    function highlightSearchText(row, searchTerm) {
        // Limpiar resaltados anteriores
        row.find('mark.search-highlight').each(function() {
            $(this).replaceWith($(this).text());
        });

        row.find('td').each(function() {
            const cell = $(this);

            // Resaltar en el nombre del producto (columna principal)
            const nameCell = cell.find('.fw-bold');
            if (nameCell.length > 0) {
                let nameText = nameCell.text();
                const regex = new RegExp(`(${searchTerm})`, 'gi');

                if (nameText.toLowerCase().includes(searchTerm)) {
                    const highlightedText = nameText.replace(regex, '<mark class="search-highlight">$1</mark>');
                    nameCell.html(highlightedText);
                }
            }

            // Resaltar en otras celdas de texto
            const cellText = cell.text();
            if (cellText.toLowerCase().includes(searchTerm) && !cell.find('.fw-bold').length && !cell.find('.badge').length) {
                const regex = new RegExp(`(${searchTerm})`, 'gi');
                const highlightedText = cellText.replace(regex, '<mark class="search-highlight">$1</mark>');
                cell.html(highlightedText);
            }
        });
    }

    // Limpiar búsqueda con clic en icono
    $('.search-icon').on('click', function() {
        $('#searchInput').val('').trigger('input').focus();
    });

    // Atajos de teclado para búsqueda
    $(document).on('keydown', function(e) {
        // Ctrl + F para enfocar búsqueda
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            $('#searchInput').focus().select();
        }

        // Escape para limpiar búsqueda
        if (e.key === 'Escape' && $('#searchInput').is(':focus')) {
            $('#searchInput').val('').trigger('input');
        }
    });

    // Mejorar experiencia visual del campo de búsqueda
    $('#searchInput').on('focus', function() {
        $(this).parent('.search-container-top').addClass('search-focused');
        $(this).attr('placeholder', 'Escriba para buscar...');
    }).on('blur', function() {
        $(this).parent('.search-container-top').removeClass('search-focused');
        $(this).attr('placeholder', 'Buscar producto...');
    });

    // Botón búsqueda
    $('#searchBtn').on('click', function() { const input = $('#searchInput'); input.val() === '' ? input.focus() : input.val('').trigger('input').focus(); });

    // Limpiar modales
    $('.modal').on('hidden.bs.modal', function() { $(this).find('form')[0]?.reset(); $(this).find('.is-invalid').removeClass('is-invalid'); $('.modal-backdrop').remove(); $('body').removeClass('modal-open'); });
});