@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>

<style>
    :root {
        --cacao-dark: #3e2723;
        --cacao-medium: #5d4037;
        --cacao-light: #8d6e63;
        --cacao-cream: #efebe9;
        --cacao-beige: #d7ccc8;
        --cacao-accent: #a1887f;
    }

    body {
        background: linear-gradient(135deg, var(--cacao-cream) 0%, var(--cacao-beige) 100%);
        min-height: 100vh;
    }

    .main-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(62, 39, 35, 0.1);
        backdrop-filter: blur(10px);
    }

    .header-title {
        color: var(--cacao-dark);
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .header-title i {
        color: var(--cacao-medium);
        margin-right: 10px;
    }

    .selection-card {
        background: linear-gradient(145deg, #ffffff, var(--cacao-cream));
        border: 2px solid var(--cacao-beige);
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(62, 39, 35, 0.08);
        transition: all 0.3s ease;
    }

    .selection-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(62, 39, 35, 0.12);
    }

    .form-label {
        color: var(--cacao-dark);
        font-weight: 600;
        margin-bottom: 0.8rem;
    }

    .form-select {
        border: 2px solid var(--cacao-beige);
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .form-select:focus {
        border-color: var(--cacao-medium);
        box-shadow: 0 0 0 0.2rem rgba(93, 64, 55, 0.25);
        background-color: #fff;
    }

    .btn-consultar {
        background: linear-gradient(145deg, var(--cacao-medium), var(--cacao-dark));
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(62, 39, 35, 0.3);
    }

    .btn-consultar:hover:not(:disabled) {
        background: linear-gradient(145deg, var(--cacao-dark), var(--cacao-medium));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(62, 39, 35, 0.4);
        color: white;
    }

    .btn-consultar:disabled {
        background: var(--cacao-accent);
        opacity: 0.6;
        cursor: not-allowed;
    }

    .report-container {
        background: linear-gradient(145deg, #ffffff, var(--cacao-cream));
        border: 2px solid var(--cacao-beige);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(62, 39, 35, 0.1);
        margin-top: 2rem;
    }

    .report-title {
        color: var(--cacao-dark);
        font-weight: 700;
        padding: 1rem 0;
        border-bottom: 3px solid var(--cacao-beige);
        margin-bottom: 1.5rem;
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .table-header {
        background: linear-gradient(145deg, var(--cacao-dark), var(--cacao-medium));
        color: white;
    }

    .table-header th {
        border: none;
        padding: 15px 12px;
        font-weight: 600;
        text-align: center;
        font-size: 0.9rem;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: var(--cacao-cream);
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 12px;
        vertical-align: middle;
        border-color: var(--cacao-beige);
        text-align: center;
    }

    .table tbody tr:nth-child(even) {
        background-color: rgba(239, 235, 233, 0.3);
    }

    .btn-pdf {
        background: linear-gradient(145deg, #d32f2f, #b71c1c);
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
    }

    .btn-pdf:hover:not(:disabled) {
        background: linear-gradient(145deg, #b71c1c, #d32f2f);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
        color: white;
    }

    .btn-pdf:disabled {
        background: #ccc;
        opacity: 0.6;
        cursor: not-allowed;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .loading-spinner {
        display: none;
        color: var(--cacao-medium);
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.8rem;
        }
        
        .header-title {
            font-size: 1.5rem;
        }
        
        .btn-consultar, .btn-pdf {
            width: 100%;
            margin-top: 1rem;
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <div class="main-container p-4 p-md-5">
                
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="header-title">
                        <i class="fas fa-seedling"></i>
                        Reporte de Información del Lote de Cacao
                    </h1>
                    <p class="text-muted">Consulta detallada de la información de tus lotes de cacao</p>
                </div>

                <!-- Formulario de Selección -->
                <div class="selection-card p-4 mb-4">
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label for="loteSelect" class="form-label">
                                <i class="fas fa-map-marked-alt me-2"></i>
                                Selecciona un Lote:
                            </label>
                            <select id="loteSelect" class="form-select">
                                <option disabled selected>-- Selecciona un lote --</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-consultar w-100" id="btnGenerar" disabled>
                                <span class="loading-spinner me-2">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </span>
                                <i class="fas fa-search me-2"></i>
                                Consultar Información
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Contenedor del Reporte -->
                <div id="reporteContainer" class="report-container p-4">
                    <h3 id="tituloLote" class="report-title text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Información del lote
                    </h3>

                    <div class="table-responsive">
                        <table class="table table-bordered mb-4">
                            <thead class="table-header">
                                <tr>
                                    <th><i class="fas fa-tag me-1"></i>Nombre</th>
                                    <th><i class="fas fa-calendar-alt me-1"></i>Fecha Inicio</th>
                                    <th><i class="fas fa-expand-arrows-alt me-1"></i>Área (m²)</th>
                                    <th><i class="fas fa-weight-hanging me-1"></i>Capacidad (kg)</th>
                                    <th><i class="fas fa-leaf me-1"></i>Tipo de Cacao</th>
                                    <th><i class="fas fa-flag me-1"></i>Estado</th>
                                    <th><i class="fas fa-clock me-1"></i>Est. Cosecha</th>
                                    <th><i class="fas fa-calendar-check me-1"></i>Fecha Cosecha</th>
                                    <th><i class="fas fa-sticky-note me-1"></i>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody id="detalleLote">
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                        <br>
                                        <span class="text-muted">Seleccione un lote para ver la información</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end">
                        <button id="btnDescargar" class="btn btn-pdf" disabled>
                            <i class="fas fa-file-pdf me-2"></i>
                            Descargar PDF
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('loteSelect');
    const btnGenerar = document.getElementById('btnGenerar');
    const reporteContainer = document.getElementById('reporteContainer');
    const tituloLote = document.getElementById('tituloLote');
    const detalleLote = document.getElementById('detalleLote');
    const btnDescargar = document.getElementById('btnDescargar');
    const loadingSpinner = document.querySelector('.loading-spinner');

    // Función para mostrar loading
    function showLoading(show) {
        if (show) {
            loadingSpinner.style.display = 'inline-block';
            btnGenerar.disabled = true;
        } else {
            loadingSpinner.style.display = 'none';
            btnGenerar.disabled = select.value === '';
        }
    }

    // Función para obtener el estado con estilo
    function getEstadoBadge(estado) {
        const estados = {
            'Activo': 'bg-success',
            'Inactivo': 'bg-secondary',
            'En Cosecha': 'bg-warning text-dark',
            'Cosechado': 'bg-info',
            'Mantenimiento': 'bg-danger'
        };
        const badgeClass = estados[estado] || 'bg-secondary';
        return `<span class="badge ${badgeClass} status-badge">${estado}</span>`;
    }

    // Cargar lotes en el select
    showLoading(true);
    fetch('/lotes/lista')
        .then(res => {
            if (!res.ok) throw new Error('Error al cargar lotes');
            return res.json();
        })
        .then(data => {
            data.forEach(lote => {
                let option = document.createElement('option');
                option.value = lote.id;
                option.textContent = `${lote.nombre} - ${lote.area}m²`;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los lotes. Por favor, recarga la página.');
        })
        .finally(() => {
            showLoading(false);
        });

    // Activar botón al seleccionar
    select.addEventListener('change', () => {
        btnGenerar.disabled = select.value === '';
        btnDescargar.disabled = true;
    });

    // Consultar lote
    btnGenerar.addEventListener('click', () => {
        const id = select.value;
        if (!id) return;

        showLoading(true);
        
        fetch(`/lotes/uno/${id}`)
            .then(res => {
                if (!res.ok) throw new Error('Error al consultar lote');
                return res.json();
            })
            .then(lote => {
                tituloLote.innerHTML = `
                    <i class="fas fa-info-circle me-2"></i>
                    Información del lote: <span style="color: var(--cacao-medium);">${lote.nombre}</span>
                `;
                
                detalleLote.innerHTML = `
                    <tr class="fade-in">
                        <td><strong>${lote.nombre}</strong></td>
                        <td>${new Date(lote.fecha_inicio).toLocaleDateString('es-ES')}</td>
                        <td><span class="badge bg-primary">${lote.area} m²</span></td>
                        <td><span class="badge bg-success">${lote.capacidad} kg</span></td>
                        <td><i class="fas fa-leaf me-1" style="color: var(--cacao-medium);"></i>${lote.tipo_cacao}</td>
                        <td>${getEstadoBadge(lote.estado)}</td>
                        <td>${lote.estimacion_cosecha ? new Date(lote.estimacion_cosecha).toLocaleDateString('es-ES') : '<span class="text-muted">No definida</span>'}</td>
                        <td>${lote.fecha_programada_cosecha ? new Date(lote.fecha_programada_cosecha).toLocaleDateString('es-ES') : '<span class="text-muted">No programada</span>'}</td>
                        <td>${lote.observaciones || '<span class="text-muted">Sin observaciones</span>'}</td>
                    </tr>
                `;

                btnDescargar.disabled = false;
                
                // Scroll suave al reporte
                reporteContainer.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al consultar la información del lote.');
                detalleLote.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center text-danger py-4">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <br>
                            Error al cargar la información del lote
                        </td>
                    </tr>
                `;
            })
            .finally(() => {
                showLoading(false);
            });
    });

    // Descargar PDF
    btnDescargar.addEventListener('click', () => {
        const element = document.getElementById('reporteContainer');
        const loteNombre = select.options[select.selectedIndex].text.split(' - ')[0];
        const fecha = new Date().toLocaleDateString('es-ES');
        
        const opt = {
            margin: 1,
            filename: `reporte_lote_${loteNombre}_${fecha}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save();
    });

    // Permitir consulta con Enter
    select.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !btnGenerar.disabled) {
            btnGenerar.click();
        }
    });
});
</script>

@endsection