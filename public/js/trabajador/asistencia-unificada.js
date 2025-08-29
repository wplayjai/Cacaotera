// Asistencia Unificada JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeAsistenciaUnificada();
});

function initializeAsistenciaUnificada() {
    // Initialize select all checkbox
    initializeSelectAll();

    // Initialize form submission
    initializeFormSubmission();

    // Initialize filters
    initializeFilters();

    // Initialize DataTables if available
    if (typeof $.fn.DataTable !== 'undefined') {
        initializeDataTables();
    }
}

// Select All functionality
function initializeSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const trabajadorCheckboxes = document.querySelectorAll('.trabajador-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            trabajadorCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Update select all when individual checkboxes change
    trabajadorCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.trabajador-checkbox:checked').length;
            const totalCount = trabajadorCheckboxes.length;

            selectAllCheckbox.checked = checkedCount === totalCount;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        });
    });
}

// Form submission
function initializeFormSubmission() {
    const form = document.getElementById('formAsistencia');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const checkedWorkers = document.querySelectorAll('.trabajador-checkbox:checked');

            if (checkedWorkers.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debe seleccionar al menos un trabajador.',
                    confirmButtonColor: '#8b6f47'
                });
                return;
            }

            // Show loading
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Registrando...';
            submitBtn.disabled = true;

            // Submit form
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Asistencia registrada correctamente.',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        // Refresh the attendance list
                        refreshAttendanceList();
                        // Reset form
                        form.reset();
                        // Uncheck all
                        document.querySelectorAll('.trabajador-checkbox').forEach(cb => cb.checked = false);
                        document.getElementById('selectAll').checked = false;
                    });
                } else {
                    throw new Error(data.message || 'Error al registrar asistencia');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Ocurrió un error al registrar la asistencia.',
                    confirmButtonColor: '#dc3545'
                });
            })
            .finally(() => {
                // Restore button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
}

// Filters
function initializeFilters() {
    // Listen for filter changes
    const filterInputs = ['#fecha_desde', '#fecha_hasta', '#filtro_trabajador'];

    filterInputs.forEach(selector => {
        const element = document.querySelector(selector);
        if (element) {
            element.addEventListener('change', debounce(filtrarAsistencias, 500));
        }
    });
}

function filtrarAsistencias() {
    const fechaDesde = document.getElementById('fecha_desde')?.value;
    const fechaHasta = document.getElementById('fecha_hasta')?.value;
    const trabajadorId = document.getElementById('filtro_trabajador')?.value;

    // Show loading
    const tableContainer = document.getElementById('tablaAsistencias');
    if (tableContainer) {
        tableContainer.classList.add('loading');
    }

    // Make AJAX request
    const formData = new FormData();
    formData.append('fecha_desde', fechaDesde || '');
    formData.append('fecha_hasta', fechaHasta || '');
    formData.append('trabajador_id', trabajadorId || '');

    fetch(`/trabajadores/filtrar-asistencias`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateAttendanceTable(data.asistencias);
        }
    })
    .catch(error => {
        console.error('Error filtering attendance:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al filtrar las asistencias.',
            confirmButtonColor: '#dc3545'
        });
    })
    .finally(() => {
        if (tableContainer) {
            tableContainer.classList.remove('loading');
        }
    });
}

function updateAttendanceTable(asistencias) {
    const tbody = document.querySelector('#asistenciasTable tbody');
    if (!tbody) return;

    tbody.innerHTML = '';

    asistencias.forEach(asistencia => {
        const row = createAttendanceRow(asistencia);
        tbody.appendChild(row);
    });
}

function createAttendanceRow(asistencia) {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${formatDate(asistencia.fecha)}</td>
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar-sm bg-gradient-cafe text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                    ${asistencia.trabajador.user.name.charAt(0)}
                </div>
                ${asistencia.trabajador.user.name}
            </div>
        </td>
        <td>${asistencia.hora_entrada || '-'}</td>
        <td>${asistencia.hora_salida || '-'}</td>
        <td>
            <span class="badge bg-${getStatusColor(asistencia.hora_entrada)}">
                ${getStatusText(asistencia.hora_entrada)}
            </span>
        </td>
        <td>${asistencia.horas_trabajadas ? asistencia.horas_trabajadas + 'h' : '-'}</td>
        <td>${asistencia.observaciones || '-'}</td>
        <td class="text-center">
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" onclick="editarAsistencia(${asistencia.id})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-outline-danger" onclick="eliminarAsistencia(${asistencia.id})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    `;
    return row;
}

// Charts initialization
// Edit attendance
function editarAsistencia(id) {
    Swal.fire({
        icon: 'info',
        title: 'Función no disponible',
        text: 'La edición de asistencias será implementada próximamente.',
        confirmButtonColor: '#007bff'
    });

    /* TODO: Implementar cuando se agreguen las rutas al backend
    fetch(`/trabajadores/asistencias/${id}/edit`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            populateEditModal(data.asistencia);
            const modal = new bootstrap.Modal(document.getElementById('editarAsistenciaModal'));
            modal.show();
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cargar los datos de asistencia.',
            confirmButtonColor: '#dc3545'
        });
    });
    */
}

function populateEditModal(asistencia) {
    document.getElementById('edit_asistencia_id').value = asistencia.id;
    document.getElementById('edit_hora_entrada').value = asistencia.hora_entrada;
    document.getElementById('edit_hora_salida').value = asistencia.hora_salida;
    // Calcular estado basado en hora de entrada
    const estado = getStatusText(asistencia.hora_entrada).toLowerCase();
    if(document.getElementById('edit_estado')) {
        document.getElementById('edit_estado').value = estado;
    }
    document.getElementById('edit_observaciones').value = asistencia.observaciones || '';
}

// Delete attendance
function eliminarAsistencia(id) {
    Swal.fire({
        title: '¿Confirmar eliminación?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'info',
                title: 'Función no disponible',
                text: 'La eliminación de asistencias será implementada próximamente.',
                confirmButtonColor: '#007bff'
            });

            /* TODO: Implementar cuando se agreguen las rutas al backend
            fetch(`/trabajadores/asistencias/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: 'Asistencia eliminada correctamente.',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        refreshAttendanceList();
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al eliminar la asistencia.',
                    confirmButtonColor: '#dc3545'
                });
            });
            */
        }
    });
}

// Export functions
function exportarExcel() {
    const params = getFilterParams();
    window.open(`/trabajadores/asistencia/export/excel?${params}`, '_blank');
}

function exportarPDF() {
    const params = getFilterParams();
    window.open(`/trabajadores/asistencia/export/pdf?${params}`, '_blank');
}

function getFilterParams() {
    const fechaDesde = document.getElementById('fecha_desde')?.value;
    const fechaHasta = document.getElementById('fecha_hasta')?.value;
    const trabajadorId = document.getElementById('filtro_trabajador')?.value;

    return new URLSearchParams({
        fecha_desde: fechaDesde || '',
        fecha_hasta: fechaHasta || '',
        trabajador_id: trabajadorId || ''
    }).toString();
}

// Utility functions
function refreshAttendanceList() {
    filtrarAsistencias();
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
    const diff = (end - start) / (1000 * 60 * 60); // Convert to hours

    return diff > 0 ? `${diff.toFixed(1)}h` : '-';
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function initializeDataTables() {
    $('#asistenciasTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 25,
        responsive: true,
        order: [[0, 'desc']], // Order by date descending
        columnDefs: [
            { orderable: false, targets: -1 } // Disable ordering on actions column
        ]
    });
}

// Función auxiliar para obtener el color del estado basado en la hora
function getStatusColor(horaEntrada) {
    if (!horaEntrada) return 'secondary';

    const hora = horaEntrada.split(':');
    const minutos = parseInt(hora[0]) * 60 + parseInt(hora[1]);
    const horaLimite = 8 * 60 + 30; // 08:30 en minutos

    return minutos > horaLimite ? 'warning' : 'success';
}

// Función auxiliar para obtener el texto del estado basado en la hora
function getStatusText(horaEntrada) {
    if (!horaEntrada) return 'Sin registro';

    const hora = horaEntrada.split(':');
    const minutos = parseInt(hora[0]) * 60 + parseInt(hora[1]);
    const horaLimite = 8 * 60 + 30; // 08:30 en minutos

    return minutos > horaLimite ? 'Tardanza' : 'Presente';
}
