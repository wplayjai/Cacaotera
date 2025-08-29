// Reportes Unificados JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeReportesUnificados();
});

function initializeReportesUnificados() {
    // Initialize period change listeners
    initializePeriodListeners();

    // Initialize tab change listeners
    initializeTabListeners();

    // Initialize charts
    initializeAllCharts();

    // Load initial data
    loadInitialData();
}

// Period listeners
function initializePeriodListeners() {
    const periodoAsistencia = document.getElementById('periodo_asistencia');
    if (periodoAsistencia) {
        periodoAsistencia.addEventListener('change', function() {
            toggleCustomDates(this.value);
        });
    }
}

function toggleCustomDates(periodo) {
    const customDates = document.getElementById('fechas-personalizadas');
    const customDatesHasta = document.getElementById('fechas-personalizadas-hasta');

    if (periodo === 'personalizado') {
        customDates.style.display = 'block';
        customDatesHasta.style.display = 'block';
    } else {
        customDates.style.display = 'none';
        customDatesHasta.style.display = 'none';
    }
}

// Tab listeners
function initializeTabListeners() {
    // Listen for tab changes to initialize specific content
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            const targetId = e.target.getAttribute('data-bs-target');

            switch(targetId) {
                case '#nav-asistencia':
                    loadAsistenciaReport();
                    break;
            }
        });
    });
}

// Generate attendance report
function generarReporteAsistencia() {
    const periodo = document.getElementById('periodo_asistencia').value;
    const fechaDesde = document.getElementById('fecha_desde_asistencia').value;
    const fechaHasta = document.getElementById('fecha_hasta_asistencia').value;
    const trabajadorId = document.getElementById('trabajador_asistencia').value;

    // Show loading
    showLoading('resumenAsistencia');

    const formData = new FormData();
    formData.append('periodo', periodo);
    formData.append('fecha_desde', fechaDesde);
    formData.append('fecha_hasta', fechaHasta);
    formData.append('trabajador_id', trabajadorId);

    fetch('/trabajadores/generar-reporte-asistencia-unificado', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateAsistenciaReport(data);
        } else {
            throw new Error(data.message || 'Error al generar reporte');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al generar el reporte de asistencia.',
            confirmButtonColor: '#dc3545'
        });
    })
    .finally(() => {
        hideLoading('resumenAsistencia');
    });
}

function updateAsistenciaReport(data) {
    // Update summary cards
    document.getElementById('total-presentes').textContent = data.resumen.presentes || 0;
    document.getElementById('total-tardanzas').textContent = data.resumen.tardanzas || 0;
    document.getElementById('total-ausentes').textContent = data.resumen.ausentes || 0;
    document.getElementById('porcentaje-asistencia').textContent = `${data.resumen.porcentaje || 0}%`;

    // Update charts
    updateTendenciaAsistenciaChart(data.tendencia);
    updateDistribucionEstadosChart(data.distribucion);

    // Update detailed table
    updateTablaDetalladaAsistencia(data.detalle);
}

// Charts initialization
function initializeAllCharts() {
    // Charts will be initialized when tabs are activated
}

function updateTendenciaAsistenciaChart(data) {
    const ctx = document.getElementById('graficoTendenciaAsistencia');
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (window.tendenciaChart) {
        window.tendenciaChart.destroy();
    }

    window.tendenciaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels || [],
            datasets: [{
                label: 'Presentes',
                data: data.presentes || [],
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 2,
                fill: true
            }, {
                label: 'Ausentes',
                data: data.ausentes || [],
                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function updateDistribucionEstadosChart(data) {
    const ctx = document.getElementById('graficoDistribucionEstados');
    if (!ctx) return;

    if (window.distribucionChart) {
        window.distribucionChart.destroy();
    }

    window.distribucionChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Presente', 'Tardanza', 'Ausente', 'Permiso'],
            datasets: [{
                data: [
                    data.presente || 0,
                    data.tardanza || 0,
                    data.ausente || 0,
                    data.permiso || 0
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(23, 162, 184, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function updateTablaDetalladaAsistencia(detalle) {
    const container = document.getElementById('tablaDetalladaAsistencia');
    if (!container) return;

    let html = `
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Trabajador</th>
                        <th>Estado</th>
                        <th>Hora Entrada</th>
                        <th>Hora Salida</th>
                        <th>Horas</th>
                    </tr>
                </thead>
                <tbody>
    `;

    detalle.forEach(item => {
        html += `
            <tr>
                <td>${formatDate(item.fecha)}</td>
                <td>${item.trabajador}</td>
                <td>
                    <span class="badge bg-${getStatusColor(item.estado)}">
                        ${capitalizeFirst(item.estado)}
                    </span>
                </td>
                <td>${item.hora_entrada || '-'}</td>
                <td>${item.hora_salida || '-'}</td>
                <td>${calculateHours(item.hora_entrada, item.hora_salida)}</td>
            </tr>
        `;
    });

    html += `
                </tbody>
            </table>
        </div>
    `;

    container.innerHTML = html;
}

// Export functions
function exportarAsistenciaExcel() {
    const params = getAsistenciaParams();
    const url = `/trabajadores/exportar-reporte-asistencia?${params}&formato=excel`;
    window.open(url, '_blank');
}

function exportarAsistenciaPDF() {
    const params = getAsistenciaParams();
    const url = `/trabajadores/exportar-reporte-asistencia?${params}&formato=pdf`;
    window.open(url, '_blank');
}

function getAsistenciaParams() {
    const periodo = document.getElementById('periodo_asistencia')?.value;
    const fechaDesde = document.getElementById('fecha_desde_asistencia')?.value;
    const fechaHasta = document.getElementById('fecha_hasta_asistencia')?.value;
    const trabajadorId = document.getElementById('trabajador_asistencia')?.value;

    return new URLSearchParams({
        periodo: periodo || '',
        fecha_desde: fechaDesde || '',
        fecha_hasta: fechaHasta || '',
        trabajador_id: trabajadorId || ''
    }).toString();
}

// Load initial data
function loadInitialData() {
    // Load current tab data
    const activeTab = document.querySelector('.nav-tabs .nav-link.active');
    if (activeTab) {
        const targetId = activeTab.getAttribute('data-bs-target');
        if (targetId === '#nav-asistencia') {
            loadAsistenciaReport();
        }
    }
}

function loadAsistenciaReport() {
    // Auto-generate report with default parameters
    if (document.getElementById('nav-asistencia').classList.contains('active')) {
        generarReporteAsistencia();
    }
}

// Utility functions
function showLoading(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.classList.add('loading');
    }
}

function hideLoading(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.classList.remove('loading');
    }
}

function formatNumber(num) {
    return new Intl.NumberFormat('es-CO').format(num);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES');
}

function getStatusColor(status) {
    const colors = {
        'presente': 'success',
        'tardanza': 'warning',
        'ausente': 'danger',
        'permiso': 'info'
    };
    return colors[status] || 'secondary';
}

function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function calculateHours(entrada, salida) {
    if (!entrada || !salida) return '-';

    const start = new Date(`1970-01-01T${entrada}:00`);
    const end = new Date(`1970-01-01T${salida}:00`);
    const diff = (end - start) / (1000 * 60 * 60);

    return diff > 0 ? `${diff.toFixed(1)}h` : '-';
}
