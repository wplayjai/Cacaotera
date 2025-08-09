/**
 * JavaScript para la vista de detalles de recolecciones
 * Archivo: public/js/recolecciones/show.js
 */

// Configuración global (se pasa desde Blade)
let recoleccionConfig = window.recoleccionConfig || {};

// Función para inicializar tooltips de Bootstrap
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Función para formatear números
function formatNumber(number, decimals = 2) {
    return new Intl.NumberFormat('es-ES', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    }).format(number);
}

// Función para imprimir la página
function imprimirDetalles() {
    window.print();
}

// Función para copiar información al portapapeles
function copiarInformacion() {
    const recoleccionId = recoleccionConfig.id || 'N/A';
    const fecha = recoleccionConfig.fecha || 'N/A';
    const cantidad = recoleccionConfig.cantidad || '0';

    const texto = `Recolección #${recoleccionId}\nFecha: ${fecha}\nCantidad: ${cantidad} kg`;

    navigator.clipboard.writeText(texto).then(function() {
        // Mostrar notificación de éxito
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Copiado',
                text: 'Información copiada al portapapeles',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            alert('Información copiada al portapapeles');
        }
    }).catch(function(err) {
        console.error('Error al copiar:', err);
        alert('No se pudo copiar la información');
    });
}

// Función para manejar el botón de volver
function volverAtras() {
    if (recoleccionConfig.indexUrl) {
        window.location.href = recoleccionConfig.indexUrl;
    } else {
        history.back();
    }
}

// Atajos de teclado
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl+P - Imprimir
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            imprimirDetalles();
        }

        // Ctrl+C - Copiar información (solo si no hay texto seleccionado)
        if (e.ctrlKey && e.key === 'c' && window.getSelection().toString() === '') {
            e.preventDefault();
            copiarInformacion();
        }

        // Escape - Volver
        if (e.key === 'Escape') {
            volverAtras();
        }
    });
}

// Función para animar elementos al cargar
function animateElements() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Función para manejar hover en badges
function initializeBadgeEffects() {
    const badges = document.querySelectorAll('.badge');
    badges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.2s ease';
        });

        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

// Función para inicializar animaciones de progreso
function initializeProgressAnimations() {
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';

        setTimeout(() => {
            bar.style.transition = 'width 1s ease-in-out';
            bar.style.width = width;
        }, 500);
    });
}

// Función para mostrar información de depuración si está habilitada
function showDebugInfo() {
    if (recoleccionConfig.debug) {
        console.log('Información de depuración:', recoleccionConfig);
    }
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('Recolecciones Show JS inicializado correctamente');

    // Inicializar componentes
    initializeTooltips();
    initializeKeyboardShortcuts();
    initializeBadgeEffects();

    // Animaciones
    setTimeout(() => {
        animateElements();
        initializeProgressAnimations();
    }, 100);

    // Debug
    showDebugInfo();

    // Agregar clase para indicar que JS está cargado
    document.body.classList.add('js-loaded');
});

// Exponer funciones globalmente si es necesario
window.imprimirDetalles = imprimirDetalles;
window.copiarInformacion = copiarInformacion;
window.volverAtras = volverAtras;
window.formatNumber = formatNumber;
