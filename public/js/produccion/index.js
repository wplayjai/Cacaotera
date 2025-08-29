function iniciarProduccion(id) {
    Swal.fire({
        title: '¿Iniciar Producción?',
        text: "La producción pasará al estado 'Siembra'",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'var(--cacao-primary)',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-play me-1"></i>Sí, iniciar',
        cancelButtonText: '<i class="fas fa-times me-1"></i>Cancelar',
        customClass: {
            popup: 'swal-cafe',
            confirmButton: 'btn-professional',
            cancelButton: 'btn-outline-professional'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Procesando...',
                text: 'Iniciando producción',
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-cafe'
                },
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/produccion/${id}/iniciar`;
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function completarProduccion(id) {
    Swal.fire({
        title: '¿Completar Producción?',
        text: "La producción pasará al estado 'Completado'",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'var(--cacao-primary)',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-check me-1"></i>Sí, completar',
        cancelButtonText: '<i class="fas fa-times me-1"></i>Cancelar',
        customClass: {
            popup: 'swal-cafe',
            confirmButton: 'btn-professional',
            cancelButton: 'btn-outline-professional'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Procesando...',
                text: 'Completando producción',
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-cafe'
                },
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/produccion/${id}/completar`;
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function eliminarProduccion(id) {
    // Verificar si SweetAlert2 está disponible
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¿Eliminar Producción?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-1"></i>Sí, eliminar',
            cancelButtonText: '<i class="fas fa-times me-1"></i>Cancelar',
            customClass: {
                popup: 'swal-cafe',
                confirmButton: 'btn-professional',
                cancelButton: 'btn-outline-professional'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Eliminando producción',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal-cafe'
                    },
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                eliminarProduccionFormulario(id);
            }
        });
    } else {
        // Usar modal Bootstrap como respaldo
        mostrarModalEliminarProduccion(id);
    }
}

// Función para mostrar modal Bootstrap
function mostrarModalEliminarProduccion(id) {
    const modal = document.getElementById('modalConfirmarEliminarProduccion');
    if (modal) {
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        // Configurar el botón de confirmación
        const btnConfirmar = document.getElementById('btnConfirmarEliminarProduccion');
        btnConfirmar.onclick = function() {
            bootstrapModal.hide();
            eliminarProduccionFormulario(id);
        };
    } else {
        // Fallback usando confirm nativo del navegador
        if (confirm('¿Está seguro de eliminar esta producción? Esta acción no se puede deshacer.')) {
            eliminarProduccionFormulario(id);
        }
    }
}

// Función común para crear y enviar el formulario de eliminación
function eliminarProduccionFormulario(id) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/produccion/${id}`;
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(csrfToken);
    form.appendChild(methodInput);
    document.body.appendChild(form);
    form.submit();
}

// Variables globales para los modales
// Avanzar estado de producción
function cambiarEstadoProduccion(id, estado) {
    Swal.fire({
        title: '¿Avanzar Estado?',
        text: `¿Deseas avanzar la producción al estado '${estado.charAt(0).toUpperCase() + estado.slice(1)}'?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'var(--cacao-primary)',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-step-forward me-1"></i>Sí, avanzar',
        cancelButtonText: '<i class="fas fa-times me-1"></i>Cancelar',
        customClass: {
            popup: 'swal-cafe',
            confirmButton: 'btn-professional',
            cancelButton: 'btn-outline-professional'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                text: 'Actualizando estado de producción',
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-cafe'
                },
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/produccion/${id}/estado`;
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            const estadoInput = document.createElement('input');
            estadoInput.type = 'hidden';
            estadoInput.name = 'estado';
            estadoInput.value = estado;
            form.appendChild(estadoInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
let estadoId = null;
let estadoActual = '';
let rendimientoId = null;
let estimacion = 0;

function abrirEstadoModal(id, estado) {
    estadoId = id;
    estadoActual = estado;
    $('#estadoForm').attr('action', `/produccion/${id}/estado`);
    $('#nuevoEstado').val(estado);
    $('#observaciones').val('');
    $('#alertaEstado').addClass('d-none').text('');
    var modal = new bootstrap.Modal(document.getElementById('estadoModal'));
    modal.show();
}

$('#estadoForm').on('submit', function(e) {
    const nuevoEstado = $('#nuevoEstado').val();
    if (estadoActual !== 'cosecha' && nuevoEstado === 'cosecha') {
        if (!$('#observaciones').val()) {
            e.preventDefault();
            $('#alertaEstado').removeClass('d-none').text('Debe registrar observaciones para cambios a "Cosecha".');
            return false;
        }
    }
});

function abrirRendimientoModal(id, estimacionProd) {
    rendimientoId = id;
    estimacion = estimacionProd;
    $('#rendimientoForm').attr('action', `/produccion/${id}/rendimiento`);
    $('#rendimientoReal').val('');
    $('#alertaRendimiento').addClass('d-none').text('');
    var modal = new bootstrap.Modal(document.getElementById('rendimientoModal'));
    modal.show();
}

$('#rendimientoForm').on('submit', function(e) {
    const real = parseFloat($('#rendimientoReal').val());
    if (real < 0.8 * estimacion) {
        e.preventDefault();
        $('#alertaRendimiento').removeClass('d-none').text('El rendimiento real es inferior al 80% del estimado. Se generará informe de desviación.');
        return false;
    }
});

// Auto-ocultar alertas después de 5 segundos
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(function() {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 500);
    });
}, 5000);

// Animación de entrada
document.addEventListener('DOMContentLoaded', function() {
    $('.fade-in-up').addClass('show');
});

// Estilos SweetAlert2 personalizados
const style = document.createElement('style');
style.textContent = `
    .swal-cafe {
        border-radius: 12px !important;
        font-family: inherit !important;
    }

    .swal-cafe .swal2-title {
        color: var(--cacao-primary) !important;
        font-weight: 600 !important;
    }

    .swal-cafe .swal2-content {
        color: var(--cacao-text) !important;
    }

    .swal-cafe .swal2-confirm.btn-professional {
        background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary)) !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 0.7rem 1.3rem !important;
        font-weight: 500 !important;
    }

    .swal-cafe .swal2-cancel.btn-outline-professional {
        background: transparent !important;
        color: var(--cacao-primary) !important;
        border: 2px solid var(--cacao-light) !important;
        border-radius: 6px !important;
        padding: 0.7rem 1.3rem !important;
        font-weight: 500 !important;
    }
`;
document.head.appendChild(style);
