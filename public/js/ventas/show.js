// Variables globales que se pasan desde la vista Blade
let ventaConfig = {};

// Marcar como pagado
function marcarPagado(id) {
    const form = document.getElementById('marcarPagadoForm');
    form.action = `/ventas/${id}/pagar`;

    const modal = new bootstrap.Modal(document.getElementById('confirmarPagoModal'));
    modal.show();
}

// Editar venta
function editarVenta(id) {
    window.location.href = `/ventas/${id}/edit`;
}

// Eliminar venta
function eliminarVenta(id) {
    Swal.fire({
        title: '¿Eliminar Venta?',
        text: "Esta acción no se puede deshacer. El stock se restaurará automáticamente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c62828',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'btn btn-danger-professional',
            cancelButton: 'btn btn-outline-professional'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/ventas/${id}`;

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
    });
}

// Imprimir venta
function imprimirVenta() {
    // Crear ventana de impresión con diseño profesional
    const ventanaImpresion = window.open('', '_blank', 'width=800,height=600');

    const contenidoImpresion = ventaConfig.contenidoImpresion;

    ventanaImpresion.document.write(contenidoImpresion);
    ventanaImpresion.document.close();

    // Esperar a que se cargue y luego imprimir
    setTimeout(() => {
        ventanaImpresion.print();
        ventanaImpresion.close();
    }, 1000);
}

// Inicializar componentes al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Agregar animaciones a los elementos
    const cards = document.querySelectorAll('.card-professional');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in-up');
        }, index * 150);
    });

    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Agregar efectos hover a los botones
    const buttons = document.querySelectorAll('.btn-professional');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Efecto especial para badges con estado pendiente
    if (ventaConfig.estadoPago === 'pendiente') {
        const badgePendiente = document.querySelector('.pulse-animation');
        if (badgePendiente) {
            setInterval(() => {
                badgePendiente.style.boxShadow = '0 0 20px rgba(245, 124, 0, 0.5)';
                setTimeout(() => {
                    badgePendiente.style.boxShadow = '0 2px 6px rgba(245, 124, 0, 0.25)';
                }, 1000);
            }, 2000);
        }
    }
});

// Detectar teclas de acceso rápido
document.addEventListener('keydown', function(e) {
    // Ctrl + P para imprimir
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        imprimirVenta();
    }

    // Escape para volver
    if (e.key === 'Escape') {
        window.location.href = ventaConfig.ventasIndexUrl;
    }
});