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
