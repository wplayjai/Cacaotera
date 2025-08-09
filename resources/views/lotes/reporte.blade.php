@extends('layouts.masterr')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/lotes/reportes.css') }}">
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
<script src="{{ asset('js/lotes/reportes.js') }}"></script>
@endsection
