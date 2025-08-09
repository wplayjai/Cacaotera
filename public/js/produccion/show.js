// Archivo: public/js/produccion/show.js
// JavaScript para el módulo de detalles de producción

// Variables globales
let produccionId = null;

// Configuración de colores café
const cacaoColors = {
    primary: '#4a3728',
    secondary: '#6b4e3d',
    accent: '#8b6f47',
    light: '#a0845c',
    cream: '#f5f2ed',
    dark: '#2d1b0f',
    medium: '#5d4037'
};

// Función para inicializar datos desde el servidor
function initializeShowData(data) {
    if (typeof data === 'object' && data.id) {
        // Datos completos del objeto
        produccionId = data.id;
        window.produccionFullData = data; // Guardar datos completos
        console.log('Datos de producción inicializados:', data);
    } else {
        // Retrocompatibilidad con ID simple
        produccionId = data;
        console.log('Production ID inicializado:', data);
    }
    
    initializeEventListeners();
    initializeAnimations();
    addCustomStyles();
    populateFormData();
}

// Llenar datos del formulario basado en la información disponible
function populateFormData() {
    const fullData = window.produccionFullData;
    if (!fullData) return;
    
    // Llenar select de trabajadores si está disponible
    const selectTrabajadores = document.querySelector('select[name="trabajadores_participantes[]"]');
    if (selectTrabajadores && fullData.trabajadores) {
        selectTrabajadores.innerHTML = '';
        fullData.trabajadores.forEach(trabajador => {
            const option = document.createElement('option');
            option.value = trabajador.id;
            option.textContent = trabajador.nombre;
            selectTrabajadores.appendChild(option);
        });
    }
}

// Función para formatear números sin decimales innecesarios
function formatNumber(number, decimals = 2) {
    if (number == Math.floor(number)) {
        return Math.floor(number).toString();
    }
    return parseFloat(number).toFixed(decimals);
}

// Inicializar event listeners
function initializeEventListeners() {
    // Event listener para el formulario de recolección
    const formRecoleccion = document.getElementById('formRecoleccion');
    if (formRecoleccion) {
        formRecoleccion.addEventListener('submit', handleFormRecoleccionSubmit);
    }
}

// Manejar el envío del formulario de recolección
function handleFormRecoleccionSubmit(e) {
    const btn = document.getElementById('btnGuardarRecoleccion');
    if (btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        btn.disabled = true;
    }
    
    // Mostrar loading con SweetAlert2 si está disponible
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Procesando...',
            text: 'Guardando recolección',
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
                popup: 'swal-cafe'
            },
            willOpen: () => {
                Swal.showLoading();
            }
        });
    }
}

// Función para ver detalle de recolección
function verDetalleRecoleccion(id) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Detalle de Recolección',
            text: 'Cargando información detallada...',
            icon: 'info',
            confirmButtonColor: cacaoColors.primary,
            confirmButtonText: '<i class="fas fa-check me-1"></i>Entendido',
            customClass: {
                popup: 'swal-cafe',
                confirmButton: 'btn-professional'
            }
        });
    } else {
        console.log(`Ver detalle de recolección ID: ${id}`);
    }
}

// Exponer función globalmente
window.verDetalleRecoleccion = verDetalleRecoleccion;

// Función para mostrar detalle de horas trabajadas
function mostrarDetalleHoras(trabajadorId, nombreTrabajador) {
    const boton = event.target.closest('button');
    if (!boton) return;
    
    const asistenciasDataAttr = boton.getAttribute('data-asistencias');
    if (!asistenciasDataAttr) return;
    
    let asistenciasData;
    try {
        asistenciasData = JSON.parse(asistenciasDataAttr);
    } catch (error) {
        console.error('Error parsing asistencias data:', error);
        return;
    }
    
    // Actualizar nombre del trabajador en el modal
    const nombreElement = document.getElementById('nombreTrabajadorModal');
    if (nombreElement) {
        nombreElement.textContent = nombreTrabajador;
    }
    
    // Calcular estadísticas
    const totalHoras = asistenciasData.reduce((sum, asistencia) => sum + parseFloat(asistencia.horas_trabajadas || 0), 0);
    const diasTrabajados = asistenciasData.length;
    const promedioDiario = diasTrabajados > 0 ? totalHoras / diasTrabajados : 0;
    
    // Actualizar estadísticas en el modal
    const totalHorasElement = document.getElementById('totalHorasModal');
    const diasTrabajadosElement = document.getElementById('diasTrabajadosModal');
    const promedioDiarioElement = document.getElementById('promedioDiarioModal');
    
    if (totalHorasElement) totalHorasElement.textContent = formatNumber(totalHoras, 1) + 'h';
    if (diasTrabajadosElement) diasTrabajadosElement.textContent = diasTrabajados;
    if (promedioDiarioElement) promedioDiarioElement.textContent = formatNumber(promedioDiario, 1) + 'h';
    
    // Llenar tabla de detalle
    const tbody = document.getElementById('tablaDetalleHoras');
    if (tbody) {
        tbody.innerHTML = '';
        
        if (asistenciasData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                        <br>No hay registros de asistencia para este trabajador
                    </td>
                </tr>
            `;
        } else {
            // Ordenar por fecha descendente
            asistenciasData.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
            
            asistenciasData.forEach(asistencia => {
                const fecha = new Date(asistencia.fecha);
                const fechaFormateada = fecha.toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                
                const horaEntrada = asistencia.hora_entrada || '-';
                const horaSalida = asistencia.hora_salida || '-';
                const horas = parseFloat(asistencia.horas_trabajadas || 0);
                const observaciones = asistencia.observaciones || '-';
                
                let badgeClass = 'badge-secondary-professional';
                if (horas >= 8) badgeClass = 'badge-success-professional';
                else if (horas >= 6) badgeClass = 'badge-warning-professional';
                else if (horas > 0) badgeClass = 'badge-info-professional';
                
                const row = `
                    <tr>
                        <td class="fw-bold">${fechaFormateada}</td>
                        <td>${horaEntrada}</td>
                        <td>${horaSalida}</td>
                        <td>
                            <span class="badge-professional ${badgeClass}">
                                <i class="fas fa-clock"></i>
                                ${formatNumber(horas, 1)}h
                            </span>
                        </td>
                        <td>${observaciones}</td>
                        <td>
                            <span class="badge-professional badge-info-professional">
                                <i class="fas fa-calendar-check"></i>
                                Registrada
                            </span>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }
    }
    
    // Mostrar modal
    const modal = document.getElementById('modalDetalleHoras');
    if (modal && typeof bootstrap !== 'undefined') {
        new bootstrap.Modal(modal).show();
    }
}

// Exponer función globalmente
window.mostrarDetalleHoras = mostrarDetalleHoras;

// Actualizar estadísticas de recolección
function actualizarEstadisticas() {
    if (!produccionId) return;
    
    fetch(`/recolecciones/produccion/${produccionId}/estadisticas`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const totalElement = document.getElementById('totalRecolectado');
            const porcentajeElement = document.getElementById('porcentajeCompletado');
            const pendienteElement = document.getElementById('cantidadPendiente');
            
            if (totalElement) totalElement.textContent = formatNumber(data.total_recolectado);
            if (porcentajeElement) porcentajeElement.textContent = `${formatNumber(data.porcentaje_completado, 1)}%`;
            if (pendienteElement) pendienteElement.textContent = formatNumber(data.cantidad_pendiente);
        })
        .catch(error => {
            console.log('Error al actualizar estadísticas:', error);
        });
}

// Animaciones de entrada
function initializeAnimations() {
    const elements = document.querySelectorAll('.fade-in-up');
    elements.forEach((element, index) => {
        setTimeout(() => {
            element.style.transform = 'translateY(0)';
            element.style.opacity = '1';
        }, index * 100);
    });
}

// Agregar estilos personalizados
function addCustomStyles() {
    const style = document.createElement('style');
    style.textContent = `
        /* Estilos SweetAlert2 personalizados para café */
        .swal-cafe {
            border-radius: 12px !important;
            font-family: inherit !important;
        }
        
        .swal-cafe .swal2-title {
            color: ${cacaoColors.primary} !important;
            font-weight: 600 !important;
        }
        
        .swal-cafe .swal2-content {
            color: ${cacaoColors.dark} !important;
        }
        
        .swal-cafe .swal2-confirm.btn-professional {
            background: linear-gradient(135deg, ${cacaoColors.primary}, ${cacaoColors.secondary}) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 0.7rem 1.5rem !important;
            font-weight: 600 !important;
            color: white !important;
        }
        
        .swal-cafe .swal2-confirm.btn-professional:hover {
            background: linear-gradient(135deg, ${cacaoColors.secondary}, ${cacaoColors.primary}) !important;
            transform: translateY(-1px) !important;
        }
        
        /* Formularios profesionales */
        .form-control-professional,
        .form-select-professional {
            border: 2px solid ${cacaoColors.light};
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .form-control-professional:focus,
        .form-select-professional:focus {
            border-color: ${cacaoColors.primary};
            box-shadow: 0 0 0 0.2rem rgba(74, 55, 40, 0.25);
            outline: none;
        }
        
        /* Animaciones */
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        /* Progress bars */
        .progress-professional {
            background-color: rgba(74, 55, 40, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .progress-bar-professional {
            background: linear-gradient(135deg, ${cacaoColors.primary}, ${cacaoColors.secondary});
            transition: width 0.6s ease;
        }
        
        /* Badges */
        .badge-professional {
            padding: 0.5rem 0.8rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .badge-success-professional {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .badge-warning-professional {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: #212529;
        }
        
        .badge-info-professional {
            background: linear-gradient(135deg, #17a2b8, #6f42c1);
            color: white;
        }
        
        .badge-secondary-professional {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }
        
        /* Botones */
        .btn-primary-professional {
            background: linear-gradient(135deg, ${cacaoColors.primary}, ${cacaoColors.secondary});
            border: none;
            border-radius: 8px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-primary-professional:hover {
            background: linear-gradient(135deg, ${cacaoColors.secondary}, ${cacaoColors.primary});
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 55, 40, 0.3);
            color: white;
        }
        
        .btn-secondary-professional {
            background: linear-gradient(135deg, ${cacaoColors.light}, ${cacaoColors.accent});
            border: none;
            border-radius: 8px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-professional:hover {
            background: linear-gradient(135deg, ${cacaoColors.accent}, ${cacaoColors.light});
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(160, 132, 92, 0.3);
            color: white;
        }
        
        /* Stats cards */
        .stats-card-show {
            background: linear-gradient(135deg, ${cacaoColors.cream}, white);
            border: 2px solid ${cacaoColors.light};
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stats-card-show:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(74, 55, 40, 0.15);
        }
        
        .stats-number-show {
            font-size: 2rem;
            font-weight: 700;
            color: ${cacaoColors.primary};
            margin-bottom: 0.5rem;
        }
        
        .stats-label-show {
            font-size: 0.9rem;
            color: ${cacaoColors.medium};
            font-weight: 500;
        }
    `;
    document.head.appendChild(style);
}

// Funciones de navegación - Disponibles inmediatamente
function volverProduccion() {
    try {
        // Intentar usar las rutas del objeto de datos
        const fullData = window.produccionFullData;
        if (fullData && fullData.routes && fullData.routes.produccion_index) {
            window.location.href = fullData.routes.produccion_index;
            return;
        }
        
        // Obtener la ruta desde un meta tag o usar ruta por defecto
        const baseRoute = document.querySelector('meta[name="produccion-index-route"]')?.content || '/produccion';
        window.location.href = baseRoute;
    } catch (error) {
        console.error('Error navegando a producción:', error);
        // Fallback
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = '/';
        }
    }
}

function editarProduccion() {
    try {
        // Intentar usar las rutas del objeto de datos
        const fullData = window.produccionFullData;
        if (fullData && fullData.routes && fullData.routes.produccion_edit) {
            window.location.href = fullData.routes.produccion_edit;
            return;
        }
        
        // Obtener ID desde los metadatos si no está en produccionId
        let idProduccion = produccionId;
        if (!idProduccion) {
            const produccionIdMeta = document.querySelector('meta[name="produccion-id"]');
            if (produccionIdMeta) {
                idProduccion = produccionIdMeta.content;
            }
        }
        
        if (idProduccion) {
            const baseRoute = document.querySelector('meta[name="produccion-edit-route"]')?.content || '/produccion';
            window.location.href = `${baseRoute}/${idProduccion}/edit`;
        } else {
            console.error('No se pudo obtener el ID de producción');
        }
    } catch (error) {
        console.error('Error navegando a editar producción:', error);
    }
}

function irAInicio() {
    try {
        // Intentar usar las rutas del objeto de datos
        const fullData = window.produccionFullData;
        if (fullData && fullData.routes && fullData.routes.home) {
            window.location.href = fullData.routes.home;
            return;
        }
        
        const homeRoute = document.querySelector('meta[name="home-route"]')?.content || '/';
        window.location.href = homeRoute;
    } catch (error) {
        console.error('Error navegando al inicio:', error);
        window.location.href = '/';
    }
}

// Exponer funciones globalmente de inmediato
window.volverProduccion = volverProduccion;
window.editarProduccion = editarProduccion;
window.irAInicio = irAInicio;

// Función para refrescar datos de recolecciones
function refrescarRecolecciones() {
    if (produccionId) {
        actualizarEstadisticas();
        // Recargar la sección de recolecciones si es necesario
        setTimeout(() => {
            const listaRecolecciones = document.getElementById('listaRecolecciones');
            if (listaRecolecciones) {
                // Aquí podrías hacer una petición AJAX para actualizar solo esa sección
                console.log('Refrescando lista de recolecciones...');
            }
        }, 1000);
    }
}

// Función para cargar trabajadores disponibles (si es necesario)
function cargarTrabajadoresDisponibles() {
    const selectTrabajadores = document.querySelector('select[name="trabajadores_participantes[]"]');
    if (selectTrabajadores && produccionId) {
        fetch(`/produccion/${produccionId}/trabajadores-disponibles`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(trabajadores => {
                selectTrabajadores.innerHTML = '';
                trabajadores.forEach(trabajador => {
                    const option = document.createElement('option');
                    option.value = trabajador.id;
                    option.textContent = `${trabajador.nombre || trabajador.user_name || 'Sin nombre'}`;
                    selectTrabajadores.appendChild(option);
                });
            })
            .catch(error => {
                console.warn('Error cargando trabajadores (esto es normal si no hay select de trabajadores en esta página):', error.message);
            });
    }
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('Show JS inicializado correctamente');
    
    // Obtener ID de producción desde un atributo data o meta tag
    const produccionIdMeta = document.querySelector('meta[name="produccion-id"]');
    if (produccionIdMeta) {
        const prodId = produccionIdMeta.content;
        initializeShowData(prodId);
    }
    
    // Solo cargar trabajadores disponibles si existe el select correspondiente
    const selectTrabajadores = document.querySelector('select[name="trabajadores_participantes[]"]');
    if (selectTrabajadores) {
        cargarTrabajadoresDisponibles();
    }
});

// Exponer funciones adicionales globalmente para uso desde HTML
window.formatNumber = formatNumber;
window.actualizarEstadisticas = actualizarEstadisticas;
window.refrescarRecolecciones = refrescarRecolecciones;
window.initializeShowData = initializeShowData;
