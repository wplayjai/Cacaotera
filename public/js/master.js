
let salesChart;
let productionChart;

$(document).ready(function() {
    // ===== INICIALIZACIÓN DE GRÁFICOS =====

    // Gráfico de Ventas (Versión con datos dinámicos)
    const salesCanvas = document.getElementById('salesChart');
    const salesCtx = salesCanvas?.getContext('2d');
    if (salesChart instanceof Chart) {
        salesChart.destroy();
    }
    if (salesCtx) {
        // Usar datos del dashboard si están disponibles, sino usar datos por defecto
        const fechasData = window.dashboardData?.fechas?.length > 0 ? 
                          window.dashboardData.fechas : 
                          ['01/01', '02/01', '03/01', '04/01', '05/01', '06/01', '07/01'];
        
        const montosData = window.dashboardData?.montos?.length > 0 ? 
                          window.dashboardData.montos : 
                          [2500, 1900, 3000, 5000, 2000, 3000, 4000];

        salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: fechasData,
                datasets: [
                    {
                        label: 'Ventas Diarias ($)',
                        data: montosData,
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                        borderWidth: 1,
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    }

    // Gráfico de Producción (Versión con datos dinámicos)
    const productionCanvas = document.getElementById('productionChart');
    const productionCtx = productionCanvas?.getContext('2d');
    if (productionChart instanceof Chart) {
        productionChart.destroy();
    }
    if (productionCtx) {
        // Usar datos del dashboard si están disponibles, sino usar datos por defecto
        const mesesData = window.dashboardData?.produccion?.meses?.length > 0 ? 
                         window.dashboardData.produccion.meses : 
                         ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        
        const criolloData = window.dashboardData?.produccion?.criollo?.length > 0 ? 
                           window.dashboardData.produccion.criollo : 
                           [300, 350, 400, 450, 300, 350, 400, 450, 500, 450, 400, 450];
        
        const forasteroData = window.dashboardData?.produccion?.forastero?.length > 0 ? 
                             window.dashboardData.produccion.forastero : 
                             [200, 250, 300, 350, 250, 300, 350, 300, 350, 400, 350, 300];
        
        const trinitarioData = window.dashboardData?.produccion?.trinitario?.length > 0 ? 
                              window.dashboardData.produccion.trinitario : 
                              [150, 200, 250, 300, 200, 250, 300, 250, 300, 350, 300, 250];

        productionChart = new Chart(productionCtx, {
            type: 'line',
            data: {
                labels: mesesData,
                datasets: [
                    {
                        label: 'Criollo (kg)',
                        data: criolloData,
                        backgroundColor: 'rgba(233, 30, 99, 0.1)',
                        borderColor: '#e91e63',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Forastero (kg)',
                        data: forasteroData,
                        backgroundColor: 'rgba(33, 150, 243, 0.1)',
                        borderColor: '#2196f3',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Trinitario (kg)',
                        data: trinitarioData,
                        backgroundColor: 'rgba(255, 152, 0, 0.1)',
                        borderColor: '#ff9800',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value + ' kg';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    }
    // ===== NAVEGACIÓN Y MANEJO DE CONTENIDO =====
    
    // Manejo del clic en el menú Inventario
   $('.nav-link[data-section="inventario"]').on('click', function(e) {
    e.preventDefault();

    const url = $(this).attr('href');

    // Ocultar el dashboard
    $('#dashboard-content').hide();

    // Mostrar loader en el contenedor del inventario
    $('#inventory-content').html(`
        <div class="text-center mt-5">
            <i class="fas fa-spinner fa-spin fa-3x"></i>
            <p class="mt-2">Cargando inventario...</p>
        </div>
    `).show();

    // Hacer la petición AJAX
    $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
            $('#inventory-content').html(response);

            // Activar menú
            $('.nav-sidebar .nav-link').removeClass('active');
            $('.nav-link[data-section="inventario"]').addClass('active');

            // Inicializar handlers del inventario
            if (typeof initInventoryEventHandlers === 'function') {
                initInventoryEventHandlers();
            }
        },
        error: function() {
            $('#inventory-content').html('<div class="alert alert-danger m-5">Error al cargar el inventario.</div>');
        }
    });
});

    
    // Delegación de eventos para el botón de volver al dashboard
    $(document).on('click', '.back-to-dashboard, .inventory-back-btn, [data-action="back-to-dashboard"]', function(e) {
        e.preventDefault();
        
        // Ocultar contenido de inventario
        $('#inventory-content').hide();
        
        // Mostrar contenido del dashboard
        $('.content-wrapper > .content-header, .content-wrapper > .content > .container-fluid').show();
        $('#dashboard-content').show();
        
        // Activar menú Dashboard
        $('.nav-sidebar .nav-link').removeClass('active');
        $('.nav-sidebar .nav-link').filter(function() {
            return $(this).text().trim() === 'Dashboard';
        }).addClass('active');
        
        // Actualizar datos del dashboard si es necesario
        if (typeof loadInventoryData === 'function') {
            loadInventoryData();
        }
    });
    
    // ===== FUNCIONES DE INVENTARIO =====
    
    // Función para inicializar manejadores de eventos del inventario
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
                    showMessage('success', response.message);
                    
                    // Cerrar modal y limpiar formulario
                    $('#inventoryModal').modal('hide');
                    $('#addProductForm')[0].reset();
                },
                error: function(xhr) {
                    showMessage('danger', `Error al agregar producto: ${xhr.responseJSON?.message || 'Ha ocurrido un error'}`);
                }
            });
        });

        // Actualizar Cantidad (AJAX)
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
                    
                    showMessage('success', response.message);
                },
                error: function(xhr) {
                    showMessage('danger', `Error al actualizar producto: ${xhr.responseJSON?.message || 'Ha ocurrido un error'}`);
                }
            });
        });

        // Eliminar Producto (AJAX)
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
                        row.remove();
                        const message = typeof response === 'object' ? response.message : 'Producto eliminado exitosamente';
                        showMessage('success', message);
                    },
                    error: function(xhr) {
                        showMessage('danger', `Error al eliminar producto: ${xhr.responseJSON?.message || 'Ha ocurrido un error'}`);
                    }
                });
            }
        });
    }
    
    // ===== FUNCIONES AUXILIARES =====
    
    // Función para mostrar mensajes
    function showMessage(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        $('#ajaxResponse').html(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);
        
        // Auto-hide después de 5 segundos
        setTimeout(function() {
            $('#ajaxResponse .alert').fadeOut();
        }, 5000);
    }
    
    // Función para actualizar gráficos (si es necesaria)
    function updateCharts() {
        if (salesChart) {
            salesChart.update();
        }
        if (productionChart) {
            productionChart.update();
        }
    }
    
    // Inicializar manejadores de eventos al cargar la página
    initInventoryEventHandlers();
    
    // ===== EVENTOS ADICIONALES =====
    
    // Manejo de sidebar toggle (si existe)
    $(document).on('click', '[data-widget="pushmenu"]', function() {
        $('body').toggleClass('sidebar-collapse');
    });
    
    // Manejo de modo oscuro/claro (si existe)
    $(document).on('click', '[data-widget="navbar-search"]', function() {
        $('.navbar-search-block').fadeToggle();
    });
    
    // Refrescar datos cada 5 minutos
    setInterval(function() {
        if (typeof loadInventoryData === 'function') {
            loadInventoryData();
        }
    }, 300000); // 5 minutos
});

// ===== FUNCIONES GLOBALES =====

// Función para redimensionar gráficos al cambiar tamaño de ventana
$(window).resize(function() {
    if (typeof salesChart !== 'undefined') {
        salesChart.resize();
    }
    if (typeof productionChart !== 'undefined') {
        productionChart.resize();
    }
});

// Función para exportar datos (ejemplo)
function exportData(type) {
    console.log(`Exportando datos de tipo: ${type}`);
    // Implementar lógica de exportación aquí
}

// Función para filtrar datos (ejemplo)
function filterData(criteria) {
    console.log(`Filtrando datos con criterio: ${criteria}`);
    // Implementar lógica de filtrado aquí
}

 
 // ===== CARGA DE DASHBOARD DE INVENTARION =====
document.addEventListener('DOMContentLoaded', function() {
    // Si prefieres cargar con AJAX
    function loadInventoryDashboard() {
        fetch('/api/inventario/dashboard')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#dashboard-inventory-table tbody');
                tbody.innerHTML = '';
                
                data.forEach(producto => {
                    let estadoBadge = '';
                    
                    if (producto.estado === 'Óptimo') {
                        estadoBadge = '<span class="badge bg-success">✅ Óptimo</span>';
                    } else if (producto.estado === 'Por vencer') {
                        estadoBadge = '<span class="badge bg-warning text-dark">⚠️ Por vencer</span>';
                    } else {
                        estadoBadge = '<span class="badge bg-danger">🔒 Restringido</span>';
                    }
                    
                    const row = `
                        <tr>
                            <td>${producto.nombre}</td>
                            <td>${producto.tipo}</td>
                            <td>${producto.cantidad} ${producto.unidad_medida}</td>
                            <td>${estadoBadge}</td>
                        </tr>
                    `;
                    
                    tbody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error('Error al cargar inventario:', error);
                document.querySelector('#dashboard-inventory-table tbody').innerHTML = 
                    '<tr><td colspan="4" class="text-center text-muted">Error al cargar datos</td></tr>';
            });
    }
    
    // Llamar la función si quieres carga AJAX
    // loadInventoryDashboard();
    
    // Actualizar cada 30 segundos (opcional)
    // setInterval(loadInventoryDashboard, 30000);
});

  
   
        