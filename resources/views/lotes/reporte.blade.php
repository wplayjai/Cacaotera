@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>

<style>
:root {
    --cacao-primary: #4a3728;
    --cacao-secondary: #6b4e3d;
    --cacao-accent: #8b6f47;
    --cacao-light: #d4c4b0;
    --cacao-bg: #f8f6f4;
    --cacao-white: #ffffff;
    --cacao-text: #2c1810;
    --cacao-muted: #8d6e63;
    --success: #2e7d32;
    --warning: #f57c00;
    --danger: #c62828;
    --info: #1976d2;
}

body {
    color: var(--cacao-text);
}

.container-fluid {
    padding: 1.5rem;
    max-width: 100%;
    margin: 0;
}

/* Título principal */
.main-title {
    color: var(--cacao-primary);
    font-size: 1.8rem;
    font-weight: 600;
    text-align: left;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--cacao-light);
    padding-bottom: 0.75rem;
}

.main-container {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.header-title {
    color: var(--cacao-primary);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.selection-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

/* Reporte principal */
.report-container {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.report-title {
    color: var(--cacao-primary);
    font-weight: 600;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
    text-align: center;
    padding: 1rem 0;
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    border-radius: 8px 8px 0 0;
    margin: 0;
}

/* Tabla profesional */
.table-custom {
    margin: 0;
    font-size: 0.85rem;
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom thead th {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
    padding: 0.9rem 0.6rem;
    font-weight: 600;
    font-size: 0.8rem;
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid var(--cacao-secondary);
    white-space: nowrap;
}

.table-custom tbody td {
    padding: 0.8rem 0.6rem;
    vertical-align: middle;
    border-color: var(--cacao-light);
    text-align: center;
    font-size: 0.8rem;
    border-top: 1px solid var(--cacao-light);
}

.table-custom tbody tr {
    transition: background-color 0.15s ease;
}

.table-custom tbody tr:hover {
    background-color: rgba(139, 111, 71, 0.05);
}

/* Badges profesionales */
.badge-custom {
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-area {
    background-color: var(--info);
    color: var(--cacao-white);
}

.badge-capacidad {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-activo {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-inactivo {
    background-color: var(--danger);
    color: var(--cacao-white);
}

/* Botones profesionales */
.btn-custom {
    border: none;
    border-radius: 6px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-consultar {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
    box-shadow: 0 2px 4px rgba(74, 55, 40, 0.2);
}

.btn-consultar:hover:not(:disabled) {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(74, 55, 40, 0.25);
}

.btn-ir-lotes {
    background-color: var(--cacao-accent);
    color: var(--cacao-white);
    box-shadow: 0 2px 4px rgba(139, 111, 71, 0.2);
}

.btn-ir-lotes:hover {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(139, 111, 71, 0.25);
}

/* Formularios */
.form-select-custom {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: border-color 0.2s ease;
    background: var(--cacao-white);
}

.form-select-custom:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.15rem rgba(139, 111, 71, 0.15);
    outline: none;
}

/* Elementos destacados */
.lote-destacado {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Estados responsivos */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .main-title {
        font-size: 1.5rem;
        text-align: center;
    }
    
    .table-custom {
        font-size: 0.75rem;
    }
    
    .table-custom thead th,
    .table-custom tbody td {
        padding: 0.6rem 0.4rem;
    }
    
    .btn-custom {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
    }
    
    .badge-custom {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
    }
}

/* Spinner de carga */
.loading-spinner {
    display: none;
    color: var(--cacao-primary);
}

.loading-spinner.show {
    display: inline-block;
}

/* Responsivo adicional */
@media (max-width: 576px) {
    .container-fluid {
        padding: 0.8rem;
    }
    
    .main-container {
        padding: 1rem !important;
    }
    
    .header-title {
        font-size: 1.2rem;
        text-align: center;
    }
    
    .table-custom {
        font-size: 0.7rem;
    }
    
    .table-custom thead th,
    .table-custom tbody td {
        padding: 0.4rem !important;
    }
    
    .btn-custom {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
    
    .selection-card {
        padding: 0.8rem !important;
    }
    
    .report-title {
        font-size: 1.1rem;
        padding: 0.8rem 0;
    }
}

/* Estilos específicos para PDF */
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .main-container {
        background: white !important;
        box-shadow: none !important;
    }
    
    .table-custom {
        page-break-inside: avoid;
    }
    
    .table-custom thead th {
        background: var(--cacao-primary) !important;
        color: white !important;
    }
}

/* Animaciones profesionales */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.5s ease-out;
}

/* Efectos de hover mejorados */
.table-custom tbody tr:hover {
    background-color: rgba(139, 111, 71, 0.05);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}
</style>
</head>

<body>
    <div class="main-container">
        <div class="container-fluid p-4">
            <!-- Título principal -->
            <div class="text-center mb-4">
                <h1 class="header-title">
                    <i class="fas fa-seedling text-success me-2"></i>
                    Reporte de Información del Lote de Cacao
                </h1>
                <p class="text-muted">Consulta detallada de la información de tus lotes de cacao</p>
            </div>

            <!-- Botón de navegación -->
            <div class="text-end mb-3 no-print">
                <a href="http://127.0.0.1:8000/lotes" class="btn btn-ir-lotes btn-custom text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Ir a Gestión de Lotes
                </a>
            </div>

            <!-- Card de selección -->
            <div class="selection-card p-3 mb-4 no-print">
                <div class="row align-items-end g-3">
                    <div class="col-md-8">
                        <label for="loteSelect" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-map-marked-alt me-2 text-primary"></i>
                            Selecciona un Lote:
                        </label>
                        <select id="loteSelect" class="form-select form-select-custom">
                            <option value="all">🌱 Mostrar todos los lotes</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-consultar btn-custom w-100" id="btnGenerar" disabled>
                            <span class="loading-spinner me-2">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                            <i class="fas fa-search me-1"></i>
                            Consultar Información
                        </button>
                    </div>
                </div>
            </div>

            <!-- Contenedor del reporte -->
            <div id="reporteContainer" class="report-container p-3">
                <div id="tituloLote" class="report-title">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Reporte de Lotes
                </div>

                <div class="table-responsive">
                    <table class="table table-custom table-hover table-sm">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <i class="fas fa-tag me-1"></i>Nombre
                                </th>
                                <th scope="col">
                                    <i class="fas fa-calendar-alt me-1"></i>Fecha Inicio
                                </th>
                                <th scope="col">
                                    <i class="fas fa-expand-arrows-alt me-1"></i>Área (m²)
                                </th>
                                <th scope="col">
                                    <i class="fas fa-tree me-1"></i>Capacidad
                                </th>
                                <th scope="col">
                                    <i class="fas fa-leaf me-1"></i>Tipo de Cacao
                                </th>
                                <th scope="col">
                                    <i class="fas fa-flag me-1"></i>Estado
                                </th>
                                <th scope="col">
                                    <i class="fas fa-sticky-note me-1"></i>Observaciones
                                </th>
                            </tr>
                        </thead>
                        <tbody id="detalleLote">
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-search fa-2x text-muted mb-2"></i>
                                        <span class="text-muted">Seleccione un lote para ver la información</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botón de descarga -->
            <div class="text-center mt-3 no-print">
                <a href="{{ route('lotes.pdf') }}" id="btnDescargarPDF" class="btn btn-lg px-4 py-2" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; border: none; border-radius: 8px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3); font-weight: 600; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);" target="_blank">
                    <i class="fas fa-download me-2"></i>
                    Descargar PDF
                </a>
                <div class="mt-2">
                    <small class="text-muted" id="textoDescarga">
                        <i class="fas fa-info-circle me-1"></i>
                        Descarga el reporte completo de todos los lotes registrados
                    </small>
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
    const loadingSpinner = document.querySelector('.loading-spinner');
    const btnDescargarPDF = document.getElementById('btnDescargarPDF');
    const textoDescarga = document.getElementById('textoDescarga');

    function showLoading(show) {
        loadingSpinner.style.display = show ? 'inline-block' : 'none';
        btnGenerar.disabled = show;
    }

    function getEstadoBadge(estado) {
        if (estado === 'Activo') {
            return '<span class="badge badge-activo badge-custom">✓ Activo</span>';
        }
        if (estado === 'Inactivo') {
            return '<span class="badge badge-inactivo badge-custom">✗ Inactivo</span>';
        }
        return `<span class="badge bg-secondary badge-custom">${estado}</span>`;
    }

    function formatearNumero(numero) {
        return new Intl.NumberFormat('es-ES').format(numero);
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
    });

    btnGenerar.addEventListener('click', () => {
        const id = select.value;
        const lotes = JSON.parse(select.dataset.lotes);

        if (id === 'all') {
            detalleLote.innerHTML = '';
            tituloLote.innerHTML = `
                <i class="fas fa-list-alt me-2"></i>
                Reporte de todos los lotes
                <div class="mt-2">
                    <span class="badge bg-info">${lotes.length} lotes encontrados</span>
                </div>
            `;
            
            // Actualizar botón de descarga para todos los lotes
            btnDescargarPDF.href = "{{ route('lotes.pdf') }}";
            textoDescarga.innerHTML = `
                <i class="fas fa-info-circle me-1"></i>
                Descarga el reporte completo de todos los lotes registrados
            `;
            
            lotes.forEach((lote, index) => {
                const fechaFormateada = new Date(lote.fecha_inicio).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                
                detalleLote.innerHTML += `
                    <tr class="table-row-animated">
                        <td>
                            <strong class="text-dark">${lote.nombre}</strong>
                            <br><small class="text-muted">#${String(index + 1).padStart(3, '0')}</small>
                        </td>
                        <td>
                            <span class="fw-medium">${fechaFormateada}</span>
                        </td>
                        <td>
                            <span class="badge badge-area badge-custom">
                                ${formatearNumero(lote.area)} m²
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-capacidad badge-custom">
                                ${formatearNumero(lote.capacidad)}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-leaf text-success me-1"></i>
                                <span>${lote.tipo_cacao}</span>
                            </div>
                        </td>
                        <td>${getEstadoBadge(lote.estado)}</td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;" title="${lote.observaciones || 'Sin observaciones'}">
                                ${lote.observaciones || '<span class="text-muted fst-italic">Sin observaciones</span>'}
                            </div>
                        </td>
                    </tr>
                `;
            });
            reporteContainer.scrollIntoView({ behavior: 'smooth' });
            return;
        }

        showLoading(true);
        fetch(`/lotes/uno/${id}`)
            .then(res => res.json())
            .then(lote => {
                const fechaFormateada = new Date(lote.fecha_inicio).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                
                tituloLote.innerHTML = `
                    <i class="fas fa-info-circle me-2"></i>
                    Información del lote:
                    <div class="mt-2">
                        <span class="lote-destacado">${lote.nombre}</span>
                    </div>
                `;
                
                // Actualizar botón de descarga para lote específico
                btnDescargarPDF.href = `/lotes/pdf/${lote.id}`;
                textoDescarga.innerHTML = `
                    <i class="fas fa-info-circle me-1"></i>
                    Descarga el reporte PDF del lote: <strong>${lote.nombre}</strong>
                `;
                
                detalleLote.innerHTML = `
                    <tr class="table-row-highlighted">
                        <td>
                            <strong class="text-dark">${lote.nombre}</strong>
                            <br><small class="text-muted">Lote Principal</small>
                        </td>
                        <td>
                            <span class="fw-medium">${fechaFormateada}</span>
                        </td>
                        <td>
                            <span class="badge badge-area badge-custom">
                                ${formatearNumero(lote.area)} m²
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-capacidad badge-custom">
                                ${formatearNumero(lote.capacidad)}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-leaf text-success me-1"></i>
                                <span>${lote.tipo_cacao}</span>
                            </div>
                        </td>
                        <td>${getEstadoBadge(lote.estado)}</td>
                        <td>
                            <div class="text-start p-1" style="max-width: 200px;">
                                ${lote.observaciones || '<span class="text-muted fst-italic">Sin observaciones registradas</span>'}
                            </div>
                        </td>
                    </tr>
                `;
                reporteContainer.scrollIntoView({ behavior: 'smooth' });
            })
            .catch(error => {
                console.error('Error:', error);
                detalleLote.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-4"><i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>Error al cargar la información del lote</td></tr>`;
            })
            .finally(() => showLoading(false));
    });

});
</script>

@endsection