
        // Sales Chart
        var salesCtx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ventas',
                    data: [2500, 9500, 3000, 5000, 2000, 3000, 4000, 5000, 3000, 2000, 5000, 4000],
                    backgroundColor: '#28a745',
                    borderColor: '#28a745',
                    borderWidth: 1
                }, {
                    label: 'Producción',
                    data: [1500, 2000, 2500, 3000, 1500, 2000, 3000, 2500, 3500, 3000, 2000, 3000],
                    backgroundColor: '#fd7e14',
                    borderColor: '#fd7e14',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Production Chart
        var productionCtx = document.getElementById('productionChart').getContext('2d');
        var productionChart = new Chart(productionCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Criollo',
                    data: [300, 350, 400, 450, 300, 350, 400, 450, 500, 450, 400, 450],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: true
                }, {
                    label: 'Forastero',
                    data: [200, 250, 300, 350, 250, 300, 350, 300, 350, 400, 350, 300],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: true
                }, {
                    label: 'Trinitario',
                    data: [150, 200, 250, 300, 200, 250, 300, 250, 300, 350, 300, 250],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    fill: true
                }, {
                    label: 'Orgánico',
                    data: [100, 150, 200, 250, 150, 200, 250, 200, 250, 300, 250, 200],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
       
   
   $(document).ready(function() {
    // Handle click on Inventory menu item
    $('.nav-link, .nav-sidebar .nav-link').filter(function() {
        return $(this).text().trim() === 'Inventario';
    }).on('click', function(e) {
        e.preventDefault();
        
        // Hide dashboard content
        $('.content-wrapper > .content-header, .content-wrapper > .content > .container-fluid').hide();
        $('#dashboard-content').hide();
        
        // Show inventory content container and load it via AJAX
        $('#inventory-content').show().html('<div class="text-center mt-5"><i class="fas fa-spinner fa-spin fa-3x"></i><p class="mt-2">Cargando inventario...</p></div>');
        
        $.ajax({
            url: $(this).attr('href'),
            method: 'GET',
            success: function(response) {
                // Extract only the content part from the response
                const contentMatch = /<div class="content-wrapper">([\s\S]*?)<footer class="main-footer">/i.exec(response);
                
                if (contentMatch && contentMatch[1]) {
                    // Insert just the content portion
                    $('#inventory-content').html(contentMatch[1]);
                } else {
                    // If extraction fails, insert the complete response
                    $('#inventory-content').html(response);
                }
                
                // Activate the corresponding menu item
                $('.nav-sidebar .nav-link').removeClass('active');
                $('.nav-sidebar .nav-link').filter(function() {
                    return $(this).text().trim() === 'Inventario';
                }).addClass('active');
                
                // Initialize inventory event handlers
                initInventoryEventHandlers();
            },
            error: function() {
                $('#inventory-content').html('<div class="alert alert-danger m-5">Error al cargar el inventario.</div>');
            }
        });
    });
    
    // Event delegation for the back to dashboard button
    $(document).on('click', '.back-to-dashboard, .inventory-back-btn, [data-action="back-to-dashboard"]', function(e) {
        e.preventDefault();
        
        // Hide inventory content
        $('#inventory-content').hide();
        
        // Show dashboard content
        $('.content-wrapper > .content-header, .content-wrapper > .content > .container-fluid').show();
        $('#dashboard-content').show();
        
        // Activate Dashboard menu
        $('.nav-sidebar .nav-link').removeClass('active');
        $('.nav-sidebar .nav-link').filter(function() {
            return $(this).text().trim() === 'Dashboard';
        }).addClass('active');
        
        // Update dashboard data if needed
        if (typeof loadInventoryData === 'function') {
            loadInventoryData();
        }
    });
    
    // Function to initialize inventory event handlers
    function initInventoryEventHandlers() {
        // Agregar Producto (AJAX)
        $('#addProductForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $('#addProductForm').attr('action') || '/inventario',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Agregar nueva fila a la tabla
                    const newRow = `
                        <tr data-id="${response.producto.id}">
                            <td>${response.producto.id}</td>
                            <td>${response.producto.nombre}</td>
                            <td>${response.producto.tipo_insumo}</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="number" class="form-control cantidad-input" value="${response.producto.cantidad}" data-id="${response.producto.id}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary update-cantidad-btn" data-id="${response.producto.id}">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge ${response.producto.estado === 'Óptimo' ? 'badge-success' : 'badge-warning'}">
                                    ${response.producto.estado}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-producto-btn" data-id="${response.producto.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    $('#inventoryTable tbody').append(newRow);
                    
                    // Mostrar mensaje de éxito
                    $('#ajaxResponse').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                    
                    // Cerrar modal
                    $('#inventoryModal').modal('hide');
                    
                    // Limpiar formulario
                    $('#addProductForm')[0].reset();
                },
                error: function(xhr) {
                    // Manejar errores
                    $('#ajaxResponse').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error al agregar producto: ${xhr.responseJSON.message || 'Ha ocurrido un error'}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }
            });
        });

        // Actualizar Cantidad (AJAX) - usando delegación de eventos
        $(document).off('click', '.update-cantidad-btn').on('click', '.update-cantidad-btn', function() {
            const id = $(this).data('id');
            const cantidad = $(this).closest('td').find('.cantidad-input').val();
            const row = $(this).closest('tr');
            
            $.ajax({
                url: `/inventario/${id}`,
                method: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    cantidad: cantidad
                },
                success: function(response) {
                    // Actualizar estado
                    const badge = row.find('.badge');
                    badge.removeClass('badge-success badge-warning')
                         .addClass(response.producto.estado === 'Óptimo' ? 'badge-success' : 'badge-warning')
                         .text(response.producto.estado);
                    
                    // Mostrar mensaje de éxito
                    $('#ajaxResponse').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                },
                error: function(xhr) {
                    // Manejar errores
                    $('#ajaxResponse').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error al actualizar producto: ${xhr.responseJSON ? xhr.responseJSON.message : 'Ha ocurrido un error'}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `);
                }
            });
        });

        // Eliminar Producto (AJAX) - usando delegación de eventos
        $(document).off('click', '.delete-producto-btn').on('click', '.delete-producto-btn', function() {
            const id = $(this).data('id');
            const row = $(this).closest('tr');
            
            if(confirm('¿Estás seguro de eliminar este producto?')) {
                $.ajax({
                    url: `/inventario/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Eliminar fila de la tabla
                        row.remove();
                        
                        // Mostrar mensaje de éxito (asumiendo que la respuesta es JSON)
                        let message = typeof response === 'object' ? response.message : 'Producto eliminado exitosamente';
                        
                        $('#ajaxResponse').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);
                    },
                    error: function(xhr) {
                        // Manejar errores
                        $('#ajaxResponse').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Error al eliminar producto: ${xhr.responseJSON ? xhr.responseJSON.message : 'Ha ocurrido un error'}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);
                    }
                });
            }
        });
    }
    
    // Initialize on page load for direct access
    initInventoryEventHandlers();
});


