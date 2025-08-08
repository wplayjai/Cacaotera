// Archivo: public/js/produccion/reporte.js
// JavaScript para el módulo de reportes de producción

// Variables globales que serán inicializadas desde el HTML
let rendimientoPorMes = [];
let distribucionTipos = [];

// Configuración de colores café mejorada
const cacaoColors = {
    primary: '#4a3728',
    secondary: '#6b4e3d', 
    accent: '#8b6f47',
    light: '#a0845c',
    gradient: ['#4a3728', '#6b4e3d', '#8b6f47', '#a0845c', '#c9a876', '#8b4513'],
    chart: {
        background: 'rgba(74, 55, 40, 0.1)',
        border: '#4a3728',
        hover: '#6b4e3d'
    }
};

// Función para inicializar los datos desde el servidor
function initializeReportData(rendimientoData, distribucionData) {
    rendimientoPorMes = rendimientoData || [];
    distribucionTipos = distribucionData || [];
    
    // Inicializar gráficos después de cargar los datos
    initializeCharts();
}

// Función para inicializar los gráficos
function initializeCharts() {
    initializeRendimientoChart();
    initializeTiposCacaoChart();
}

// Gráfico de Rendimiento por Mes con funcionalidad mejorada
function initializeRendimientoChart() {
    const ctxRendimiento = document.getElementById('rendimientoChart');
    if (!ctxRendimiento) return;
    
    new Chart(ctxRendimiento.getContext('2d'), {
        type: 'line',
        data: {
            labels: rendimientoPorMes.length > 0 
                ? rendimientoPorMes.map(item => item.mes) 
                : ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Rendimiento Promedio (%)',
                data: rendimientoPorMes.length > 0 
                    ? rendimientoPorMes.map(item => parseFloat(item.rendimiento_promedio))
                    : [85.2, 87.8, 91.5, 89.3, 93.1, 88.7],
                borderColor: cacaoColors.primary,
                backgroundColor: cacaoColors.chart.background,
                borderWidth: 3,
                pointBackgroundColor: cacaoColors.secondary,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: cacaoColors.accent,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Evolución del Rendimiento Mensual',
                    color: cacaoColors.primary,
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: cacaoColors.primary,
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: cacaoColors.secondary,
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return `Rendimiento: ${context.parsed.y.toFixed(1)}%`;
                        },
                        afterLabel: function(context) {
                            const value = context.parsed.y;
                            if (value >= 95) return '🟢 Excelente rendimiento';
                            if (value >= 85) return '🟡 Buen rendimiento';
                            return '🔴 Rendimiento por debajo del objetivo';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 70,
                    max: 110,
                    grid: {
                        color: 'rgba(139, 111, 71, 0.2)'
                    },
                    ticks: {
                        color: cacaoColors.primary,
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Rendimiento (%)',
                        color: cacaoColors.primary,
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(139, 111, 71, 0.1)'
                    },
                    ticks: {
                        color: cacaoColors.primary
                    },
                    title: {
                        display: true,
                        text: 'Período',
                        color: cacaoColors.primary,
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

// Gráfico de Distribución por Tipos con colores café
function initializeTiposCacaoChart() {
    const ctxTipos = document.getElementById('tiposCacaoChart');
    if (!ctxTipos) return;
    
    new Chart(ctxTipos.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: distribucionTipos.length > 0 
                ? distribucionTipos.map(item => item.tipo)
                : ['Trinitario', 'Criollo', 'Forastero'],
            datasets: [{
                data: distribucionTipos.length > 0 
                    ? distribucionTipos.map(item => parseFloat(item.cantidad))
                    : [45, 30, 25],
                backgroundColor: cacaoColors.gradient,
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 4,
                hoverBorderColor: '#ffffff',
                hoverBackgroundColor: cacaoColors.gradient.map(color => color + 'dd')
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Distribución por Tipo de Cacao',
                    color: cacaoColors.primary,
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        color: cacaoColors.primary,
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: cacaoColors.primary,
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: cacaoColors.secondary,
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed}kg (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '60%',
            animation: {
                animateRotate: true,
                animateScale: false
            }
        }
    });
}

// Funciones de utilidad
function limpiarFiltros() {
    const fechaDesde = document.getElementById('fechaDesde');
    const fechaHasta = document.getElementById('fechaHasta');
    const estadoFiltro = document.getElementById('estadoFiltro');
    const tipoCacao = document.getElementById('tipoCacao');
    const filtrosReporte = document.getElementById('filtrosReporte');
    
    if (fechaDesde) fechaDesde.value = '';
    if (fechaHasta) fechaHasta.value = '';
    if (estadoFiltro) estadoFiltro.value = '';
    if (tipoCacao) tipoCacao.value = '';
    if (filtrosReporte) filtrosReporte.submit();
}

function exportarReporte(formato) {
    // Crear URL con parámetros actuales para exportación
    const params = new URLSearchParams(window.location.search);
    params.set('formato', formato);
    
    // Mostrar mensaje de carga
    const btnExport = event.target;
    const originalText = btnExport.innerHTML;
    btnExport.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
    btnExport.disabled = true;
    
    // Obtener la ruta base desde la configuración global o meta tag
    const baseRoute = document.querySelector('meta[name="base-route"]')?.content || '/produccion/reporte-rendimiento';
    
    // Realizar exportación
    window.location.href = `${baseRoute}?${params.toString()}`;
    
    // Restaurar botón después de un momento
    setTimeout(() => {
        btnExport.innerHTML = originalText;
        btnExport.disabled = false;
    }, 3000);
}

function verRecolecciones(produccionId) {
    // Mostrar loading en el modal
    const modalBody = document.getElementById('contenidoRecolecciones');
    if (!modalBody) return;
    
    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status" style="color: var(--cacao-medium) !important;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando historial de recolecciones...</p>
        </div>`;
    
    // Mostrar modal inmediatamente
    const modal = document.getElementById('modalRecolecciones');
    if (modal && typeof bootstrap !== 'undefined') {
        new bootstrap.Modal(modal).show();
    }
    
    fetch(`/recolecciones/produccion/${produccionId}/lista`)
        .then(response => response.json())
        .then(data => {
            let html = '<div class="table-responsive">';
            
            if (data && data.length > 0) {
                // Estadísticas resumidas
                const totalRecolectado = data.reduce((sum, item) => sum + parseFloat(item.cantidad_recolectada), 0);
                const promedioCalidad = data.reduce((sum, item) => sum + (parseFloat(item.calidad_promedio) || 0), 0) / data.length;
                
                html += `
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center py-2">
                                    <h6 class="mb-1" style="color: var(--cacao-dark);">Total Recolectado</h6>
                                    <h5 class="mb-0 fw-bold" style="color: var(--cacao-medium);">${totalRecolectado.toFixed(2)} kg</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center py-2">
                                    <h6 class="mb-1" style="color: var(--cacao-dark);">Días de Recolección</h6>
                                    <h5 class="mb-0 fw-bold" style="color: var(--cacao-medium);">${data.length}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center py-2">
                                    <h6 class="mb-1" style="color: var(--cacao-dark);">Calidad Promedio</h6>
                                    <h5 class="mb-0 fw-bold" style="color: var(--cacao-medium);">${promedioCalidad.toFixed(1)}/10</h5>
                                </div>
                            </div>
                        </div>
                    </div>`;
                
                html += '<table class="table table-sm table-striped">';
                html += `<thead style="background: var(--cacao-cream); color: var(--cacao-dark);">
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad (kg)</th>
                        <th>Estado Fruto</th>
                        <th>Calidad</th>
                        <th>Duración</th>
                        <th>Trabajadores</th>
                        <th>Clima</th>
                        <th>Acciones</th>
                    </tr>
                </thead>`;
                html += '<tbody>';
                
                data.forEach(recoleccion => {
                    const fechaFormateada = new Date(recoleccion.fecha_recoleccion).toLocaleDateString('es-ES');
                    const estadoColor = recoleccion.estado_fruto === 'maduro' ? 'var(--cacao-light)' : 
                                       recoleccion.estado_fruto === 'semi-maduro' ? 'var(--cacao-accent)' : '#8b4513';
                    const climaIcon = recoleccion.condiciones_climaticas === 'soleado' ? '☀️' :
                                     recoleccion.condiciones_climaticas === 'nublado' ? '☁️' : '🌧️';
                    
                    html += `<tr style="border-color: rgba(139, 111, 71, 0.2);">
                        <td class="fw-bold">${fechaFormateada}</td>
                        <td class="fw-bold text-primary" style="color: var(--cacao-medium) !important;">
                            ${parseFloat(recoleccion.cantidad_recolectada).toFixed(2)} kg
                        </td>
                        <td>
                            <span class="badge rounded-pill" style="background-color: ${estadoColor}; color: white;">
                                ${recoleccion.estado_fruto}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress me-2" style="width: 60px; height: 6px;">
                                    <div class="progress-bar" style="background-color: var(--cacao-light); width: ${(recoleccion.calidad_promedio || 0) * 10}%"></div>
                                </div>
                                <small class="text-muted">${(recoleccion.calidad_promedio || 0).toFixed(1)}</small>
                            </div>
                        </td>
                        <td class="text-muted">
                            ${recoleccion.duracion_horas ? recoleccion.duracion_horas + 'h' : 'N/A'}
                            ${recoleccion.hora_inicio ? '<br><small>' + recoleccion.hora_inicio + '-' + (recoleccion.hora_fin || '') + '</small>' : ''}
                        </td>
                        <td>
                            <span class="badge bg-secondary">${recoleccion.trabajadores_count} trabajadores</span>
                            ${recoleccion.trabajadores_nombres ? '<br><small class="text-muted">' + recoleccion.trabajadores_nombres + '</small>' : ''}
                        </td>
                        <td class="text-center">
                            <span title="${recoleccion.condiciones_climaticas}">${climaIcon}</span>
                            <br><small class="text-muted">${recoleccion.condiciones_climaticas}</small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" onclick="verDetalleRecoleccion(${recoleccion.id})" 
                                    style="border-color: var(--cacao-light); color: var(--cacao-medium);">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>`;
                    
                    if (recoleccion.observaciones) {
                        html += `<tr style="background-color: rgba(139, 111, 71, 0.05);">
                            <td colspan="8" class="py-1">
                                <small class="text-muted">
                                    <i class="fas fa-comment-alt me-1" style="color: var(--cacao-accent);"></i>
                                    <strong>Observaciones:</strong> ${recoleccion.observaciones}
                                </small>
                            </td>
                        </tr>`;
                    }
                });
            } else {
                html += `<div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3" style="color: var(--cacao-light) !important;"></i>
                    <h5 class="text-muted">No hay recolecciones registradas</h5>
                    <p class="text-muted">Esta producción aún no tiene historial de recolecciones.</p>
                    <a href="/recolecciones/create/${produccionId}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Registrar Recolección
                    </a>
                </div>`;
            }
            
            html += '</tbody></table></div>';
            modalBody.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            modalBody.innerHTML = `
                <div class="alert alert-warning border" style="border-color: var(--cacao-accent) !important;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2" style="color: var(--cacao-accent);"></i>
                        <div>
                            <strong>Error al cargar las recolecciones</strong>
                            <br><small>Por favor, intente nuevamente o contacte al administrador.</small>
                        </div>
                    </div>
                </div>`;
        });
}

// Función para ver detalle de una recolección específica
function verDetalleRecoleccion(recoleccionId) {
    fetch(`/recolecciones/${recoleccionId}`)
        .then(response => response.json())
        .then(data => {
            // Crear modal para mostrar detalle
            const modalHtml = `
                <div class="modal fade" id="modalDetalleRecoleccion" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background: var(--cacao-cream); color: var(--cacao-dark);">
                                <h5 class="modal-title">
                                    <i class="fas fa-info-circle"></i> 
                                    Detalle de Recolección - ${new Date(data.fecha_recoleccion).toLocaleDateString('es-ES')}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 style="color: var(--cacao-dark);">Información General</h6>
                                        <table class="table table-sm">
                                            <tr><td><strong>Cantidad:</strong></td><td>${data.cantidad_recolectada} kg</td></tr>
                                            <tr><td><strong>Estado del fruto:</strong></td><td>${data.estado_fruto}</td></tr>
                                            <tr><td><strong>Calidad promedio:</strong></td><td>${data.calidad_promedio}/10</td></tr>
                                            <tr><td><strong>Condiciones climáticas:</strong></td><td>${data.condiciones_climaticas}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 style="color: var(--cacao-dark);">Horarios y Duración</h6>
                                        <table class="table table-sm">
                                            <tr><td><strong>Hora inicio:</strong></td><td>${data.hora_inicio || 'N/A'}</td></tr>
                                            <tr><td><strong>Hora fin:</strong></td><td>${data.hora_fin || 'N/A'}</td></tr>
                                            <tr><td><strong>Duración:</strong></td><td>${data.duracion_horas ? data.duracion_horas + ' horas' : 'N/A'}</td></tr>
                                        </table>
                                    </div>
                                </div>
                                ${data.trabajadores_nombres ? 
                                    `<div class="mt-3">
                                        <h6 style="color: var(--cacao-dark);">Trabajadores Participantes</h6>
                                        <p class="text-muted">${data.trabajadores_nombres}</p>
                                    </div>` : ''
                                }
                                ${data.observaciones ? 
                                    `<div class="mt-3">
                                        <h6 style="color: var(--cacao-dark);">Observaciones</h6>
                                        <div class="alert alert-light">${data.observaciones}</div>
                                    </div>` : ''
                                }
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <a href="/recolecciones/${recoleccionId}/edit" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;
            
            // Remover modal existente si existe
            const existingModal = document.getElementById('modalDetalleRecoleccion');
            if (existingModal) existingModal.remove();
            
            // Agregar nuevo modal al DOM
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Mostrar modal
            if (typeof bootstrap !== 'undefined') {
                new bootstrap.Modal(document.getElementById('modalDetalleRecoleccion')).show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar el detalle de la recolección');
        });
}

// Función para exportar historial de recolecciones
function exportarHistorialRecolecciones() {
    // Obtener el ID de producción del modal actual
    const modalTitle = document.querySelector('#modalRecolecciones .modal-title');
    if (!modalTitle) return;
    
    // Esta función se puede expandir para implementar exportación
    alert('Funcionalidad de exportación en desarrollo');
}

// Auto-actualizar cada 30 segundos
function initializeAutoRefresh() {
    setInterval(() => {
        if (document.hidden) return;
        
        const urlActual = window.location.href;
        if (urlActual.includes('reporte')) {
            // Solo refrescar si no hay modales abiertos
            if (!document.querySelector('.modal.show')) {
                location.reload();
            }
        }
    }, 30000);
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar auto-refresh
    initializeAutoRefresh();
    
    // Si hay datos disponibles globalmente, inicializar
    if (typeof window.reporteData !== 'undefined') {
        initializeReportData(window.reporteData.rendimientoPorMes, window.reporteData.distribucionTipos);
    }
});

// Exponer funciones globalmente para uso desde HTML
window.limpiarFiltros = limpiarFiltros;
window.exportarReporte = exportarReporte;
window.verRecolecciones = verRecolecciones;
window.verDetalleRecoleccion = verDetalleRecoleccion;
window.exportarHistorialRecolecciones = exportarHistorialRecolecciones;
window.initializeReportData = initializeReportData;
