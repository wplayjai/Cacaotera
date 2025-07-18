@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" defer></script>

<style>
    :root {
        --cacao-dark: #6d4e36;
        --cacao-medium: #8b5a3c;
        --cacao-light: #a0674b;
        --cacao-cream: #efebe9;
        --cacao-beige: #d7ccc8;
        --cacao-accent: #a1887f;
        --cacao-gold: #d4af37;
    }

    body {
        background: linear-gradient(135deg, var(--cacao-cream) 0%, var(--cacao-beige) 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(62, 39, 35, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(111, 78, 55, 0.1);
    }

    .header-title {
        color: var(--cacao-dark);
        font-weight: 700;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
        font-size: 1.5rem;
        position: relative;
    }

    .header-title::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, var(--cacao-medium), var(--cacao-dark));
        border-radius: 2px;
    }

    .selection-card {
        background: linear-gradient(145deg, #ffffff, #fafafa);
        border: 2px solid var(--cacao-beige);
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(62, 39, 35, 0.08);
        transition: all 0.3s ease;
    }

    .selection-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(62, 39, 35, 0.12);
    }

    /* Estilos mejorados para la tabla usando Bootstrap 5 */
    .report-container {
        background: #ffffff !important;
        border: 2px solid var(--cacao-medium);
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
    }

    .report-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--cacao-dark), var(--cacao-medium), var(--cacao-light));
    }

    .report-title {
        color: var(--cacao-dark) !important;
        font-weight: 600;
        margin-bottom: 1.5rem;
        font-size: 1.4rem;
        text-align: center;
        padding: 1rem 0;
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
        border-radius: 8px;
        margin: 0.8rem 0 1.5rem 0;
        border: 2px dashed var(--cacao-beige);
    }

    /* Tabla estilo Bootstrap 5 mejorada */
    .table-custom {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        background: white;
    }

    .table-custom thead th {
        background: linear-gradient(145deg, var(--cacao-dark), var(--cacao-medium)) !important;
        color: white !important;
        padding: 0.7rem 0.5rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.8rem;
        border: none;
        position: relative;
    }

    .table-custom thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, rgba(255,255,255,0.3), transparent, rgba(255,255,255,0.3));
    }

    .table-custom tbody td {
        padding: 0.7rem 0.5rem;
        text-align: center;
        border-top: 1px solid #dee2e6;
        vertical-align: middle;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(111, 78, 55, 0.04);
        transform: scale(1.005);
    }

    .table-custom tbody tr:nth-child(even) {
        background-color: rgba(248, 249, 250, 0.6);
    }

    /* Badges mejorados con Bootstrap 5 */
    .badge-custom {
        font-size: 0.65rem;
        padding: 0.35rem 0.6rem;
        border-radius: 15px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.12);
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }

    .badge-area {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }

    .badge-capacidad {
        background: linear-gradient(135deg, #28a745, #1e7e34);
        color: white;
    }

    .badge-activo {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border-color: #20c997;
    }

    .badge-inactivo {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border-color: #c82333;
    }

    .badge-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    /* Botones mejorados */
    .btn-custom {
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .btn-consultar {
        background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(93, 64, 55, 0.25);
    }

    .btn-consultar:hover:not(:disabled) {
        background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium));
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(93, 64, 55, 0.3);
    }

    .btn-ir-lotes {
        background: linear-gradient(135deg, var(--cacao-light), var(--cacao-medium));
        color: white;
        box-shadow: 0 2px 8px rgba(141, 110, 99, 0.25);
    }

    .btn-ir-lotes:hover {
        background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-dark));
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(141, 110, 99, 0.3);
    }

    /* Botón PDF Completo */
    .btn-info-custom {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
        box-shadow: 0 2px 8px rgba(23, 162, 184, 0.25);
    }

    .btn-info-custom:hover {
        background: linear-gradient(135deg, #138496, #117a8b);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }

    /* Spinner de carga */
    .loading-spinner {
        display: none;
    }

    /* Select mejorado */
    .form-select-custom {
        border: 2px solid var(--cacao-beige);
        border-radius: 8px;
        padding: 0.6rem 0.8rem;
        font-size: 0.85rem;
        background: white;
        transition: all 0.3s ease;
    }

    .form-select-custom:focus {
        border-color: var(--cacao-medium);
        box-shadow: 0 0 0 0.2rem rgba(93, 64, 55, 0.2);
    }

    /* Texto destacado del lote */
    .lote-destacado {
        background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium));
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        border: 1px solid rgba(255,255,255,0.2);
        font-size: 0.9rem;
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
            background: #6f4e37 !important;
            color: white !important;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-title {
            font-size: 1.2rem;
        }
        
        .table-custom {
            font-size: 0.7rem;
        }
        
        .badge-custom {
            font-size: 0.6rem;
            padding: 0.2rem 0.4rem;
        }
        
        .report-container {
            padding: 0.8rem !important;
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

    /* Animaciones adicionales */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
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

    .table-row-animated {
        animation: slideIn 0.5s ease-out;
    }

    .table-row-highlighted {
        animation: fadeInUp 0.6s ease-out;
        background: linear-gradient(145deg, #fff, #f8f9fa) !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .badge-custom:hover {
        animation: pulse 0.3s ease-in-out;
    }

    /* Mejoras visuales adicionales */
    .table-custom tbody tr {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .table-custom tbody tr:hover {
        border-left: 4px solid var(--cacao-medium);
        background: linear-gradient(90deg, rgba(111, 78, 55, 0.05), transparent) !important;
    }

    .selection-card {
        position: relative;
        overflow: hidden;
    }

    .selection-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s;
    }

    .selection-card:hover::before {
        left: 100%;
    }

    .loading-animation {
        animation: pulse 1.5s infinite;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <div class="main-container p-4 p-md-5">
                <!-- Header -->
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