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
        font-size: 0.95rem;
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
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
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
    }

    .form-label {
        font-size: 0.9rem;
        color: var(--cacao-dark);
    }

    .form-select {
        font-size: 0.9rem;
        background-color: white;
        border: 2px solid var(--cacao-beige);
        border-radius: 10px;
    }

    .btn-consultar,
    .btn-pdf,
    .btn-ir-lotes {
        font-size: 0.9rem;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 10px;
        border: none;
    }

    .btn-consultar {
        background: linear-gradient(145deg, var(--cacao-medium), var(--cacao-dark));
        color: white;
    }

    .btn-consultar:hover:not(:disabled) {
        background: linear-gradient(145deg, var(--cacao-dark), var(--cacao-medium));
        color: white;
    }

    .btn-pdf {
        background: linear-gradient(145deg, #d32f2f, #b71c1c);
        color: white;
    }

    .btn-pdf:hover:not(:disabled) {
        background: linear-gradient(145deg, #b71c1c, #d32f2f);
        color: white;
    }

    .btn-ir-lotes {
        background: linear-gradient(145deg, #007bff, #0056b3);
        color: white;
    }

    .btn-ir-lotes:hover {
        background: linear-gradient(145deg, #0056b3, #007bff);
    }

    .table-header {
        background: linear-gradient(145deg, var(--cacao-dark), var(--cacao-medium));
        color: white;
    }

    .table-header th,
    .table tbody td {
        font-size: 0.85rem;
        text-align: center;
        vertical-align: middle;
    }

    .highlighted-name {
        background-color: #000;
        padding: 4px 10px;
        border-radius: 6px;
        color: white;
        font-weight: bold;
    }

    .badge-activo {
        background-color: #28a745;
    }

    .badge-inactivo {
        background-color: #dc3545;
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="main-container p-4">
                <div class="text-center mb-4">
                    <h1 class="header-title">
                        <i class="fas fa-seedling"></i>
                        Reporte de Información del Lote de Cacao
                    </h1>
                    <p class="text-muted">Consulta detallada de la información de tus lotes de cacao</p>
                </div>

                <div class="text-end mb-3 no-print">
                    <a href="http://127.0.0.1:8000/lotes" class="btn btn-ir-lotes">
                        <i class="fas fa-arrow-left me-2"></i> Ir a Gestión de Lotes
                    </a>
                </div>

                <div class="selection-card p-4 mb-4 no-print">
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label for="loteSelect" class="form-label">
                                <i class="fas fa-map-marked-alt me-2"></i>
                                Selecciona un Lote:
                            </label>
                            <select id="loteSelect" class="form-select">
                                <option value="all">-- Mostrar todos los lotes --</option>
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

                <div id="reporteContainer" class="report-container p-4">
                    <h3 id="tituloLote" class="report-title text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Reporte de Lotes
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
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-search fa-2x text-muted mb-2"></i><br>
                                        <span class="text-muted">Seleccione un lote para ver la información</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-end no-print">
                    <button id="btnDescargar" class="btn btn-pdf" disabled>
                        <i class="fas fa-file-pdf me-2"></i>
                        Descargar PDF
                    </button>
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

    function showLoading(show) {
        loadingSpinner.style.display = show ? 'inline-block' : 'none';
        btnGenerar.disabled = show;
    }

    function getEstadoBadge(estado) {
        if (estado === 'Activo') return '<span class="badge badge-activo">Activo</span>';
        if (estado === 'Inactivo') return '<span class="badge badge-inactivo">Inactivo</span>';
        return `<span class="badge bg-secondary status-badge">${estado}</span>`;
    }

    showLoading(true);
    fetch('/lotes/lista')
        .then(res => res.json())
        .then(data => {
            data.forEach(lote => {
                const option = document.createElement('option');
                option.value = lote.id;
                option.textContent = lote.nombre;
                select.appendChild(option);
            });
            select.dataset.lotes = JSON.stringify(data);
        })
        .catch(err => console.error('Error al cargar lotes:', err))
        .finally(() => showLoading(false));

    select.addEventListener('change', () => {
        btnGenerar.disabled = false;
        btnDescargar.disabled = true;
    });

    btnGenerar.addEventListener('click', () => {
        const id = select.value;
        const lotes = JSON.parse(select.dataset.lotes);

        if (id === 'all') {
            detalleLote.innerHTML = '';
            tituloLote.innerHTML = `<i class="fas fa-info-circle me-2"></i>Reporte de todos los lotes:`;
            lotes.forEach(lote => {
                detalleLote.innerHTML += `
                    <tr>
                        <td><strong>${lote.nombre}</strong></td>
                        <td>${new Date(lote.fecha_inicio).toLocaleDateString('es-ES')}</td>
                        <td><span class="badge bg-primary">${lote.area} m²</span></td>
                        <td><span class="badge bg-success">${lote.capacidad} kg</span></td>
                        <td><i class="fas fa-leaf me-1"></i>${lote.tipo_cacao}</td>
                        <td>${getEstadoBadge(lote.estado)}</td>
                        <td>${lote.estimacion_cosecha ? lote.estimacion_cosecha + ' kg' : '<span class="text-muted">No definida</span>'}</td>
                        <td>${lote.fecha_programada_cosecha ? new Date(lote.fecha_programada_cosecha).toLocaleDateString('es-ES') : '<span class="text-muted">No programada</span>'}</td>
                        <td>${lote.observaciones || '<span class="text-muted">Sin observaciones</span>'}</td>
                    </tr>
                `;
            });
            btnDescargar.disabled = false;
            reporteContainer.scrollIntoView({ behavior: 'smooth' });
            return;
        }

        showLoading(true);
        fetch(`/lotes/uno/${id}`)
            .then(res => res.json())
            .then(lote => {
                tituloLote.innerHTML = `<i class="fas fa-info-circle me-2"></i>Información del lote: <span class="highlighted-name">${lote.nombre}</span>`;
                detalleLote.innerHTML = `
                    <tr>
                        <td><strong>${lote.nombre}</strong></td>
                        <td>${new Date(lote.fecha_inicio).toLocaleDateString('es-ES')}</td>
                        <td><span class="badge bg-primary">${lote.area} m²</span></td>
                        <td><span class="badge bg-success">${lote.capacidad} kg</span></td>
                        <td><i class="fas fa-leaf me-1"></i>${lote.tipo_cacao}</td>
                        <td>${getEstadoBadge(lote.estado)}</td>
                        <td>${lote.estimacion_cosecha ? lote.estimacion_cosecha + ' kg' : '<span class="text-muted">No definida</span>'}</td>
                        <td>${lote.fecha_programada_cosecha ? new Date(lote.fecha_programada_cosecha).toLocaleDateString('es-ES') : '<span class="text-muted">No programada</span>'}</td>
                        <td>${lote.observaciones || '<span class="text-muted">Sin observaciones</span>'}</td>
                    </tr>
                `;
                btnDescargar.disabled = false;
                reporteContainer.scrollIntoView({ behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error:', error);
                detalleLote.innerHTML = `<tr><td colspan="9" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>Error al cargar la información del lote</td></tr>`;
            })
            .finally(() => showLoading(false));
    });

    btnDescargar.addEventListener('click', () => {
        const element = document.getElementById('reporteContainer');
        const fecha = new Date().toLocaleDateString('es-ES').replaceAll('/', '-');

        const opt = {
            margin: 0.5,
            filename: `reporte_lotes_${fecha}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a3', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save();
    });
});
</script>

@endsection
