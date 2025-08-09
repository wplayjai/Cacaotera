<script>
// Variables originales para comparación
const ventaOriginal = {
    cantidad: {{ $venta->cantidad_vendida }},
    precio: {{ $venta->precio_por_kg }},
    total: {{ $venta->total_venta }},
    recoleccion: {{ $venta->recoleccion_id }},
    stockDisponible: {{ $venta->recoleccion->cantidad_disponible + $venta->cantidad_vendida }}
};

// Actualizar información de stock disponible
function actualizarStock() {
    const select = document.getElementById('recoleccion_id');
    const stockInfo = document.getElementById('stockInfo');
    const cantidadInput = document.getElementById('cantidad_vendida');

    if (select.value) {
        const option = select.options[select.selectedIndex];
        let stock;
        let tipo;

        // Si es la recolección original, incluir la cantidad vendida
        if (select.value == {{ $venta->recoleccion_id }}) {
            stock = ventaOriginal.stockDisponible;
            tipo = '{{ $venta->recoleccion->produccion->tipo_cacao }}';
        } else {
            stock = parseFloat(option.dataset.stock);
            tipo = option.dataset.tipo;
        }

        stockInfo.innerHTML = `<i class="fas fa-info-circle"></i> Stock disponible: <strong>${stock} kg</strong> de ${tipo}`;
        stockInfo.className = stock < 10 ? 'form-text text-danger' : 'form-text text-success';

        cantidadInput.max = stock;
        cantidadInput.placeholder = `Máximo ${stock} kg`;

        // Validar cantidad actual
        const cantidadActual = parseFloat(cantidadInput.value) || 0;
        if (cantidadActual > stock) {
            cantidadInput.classList.add('is-invalid');
            cantidadInput.setCustomValidity('La cantidad excede el stock disponible');
        } else {
            cantidadInput.classList.remove('is-invalid');
            cantidadInput.setCustomValidity('');
        }
    }
}

// Calcular total de la venta
function calcularTotal() {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
    const precio = parseFloat(document.getElementById('precio_por_kg').value) || 0;
    const total = cantidad * precio;

    document.getElementById('total_venta').value = total.toFixed(2);

    // Validar stock
    const select = document.getElementById('recoleccion_id');
    if (select.value) {
        const option = select.options[select.selectedIndex];
        let stock;

        if (select.value == {{ $venta->recoleccion_id }}) {
            stock = ventaOriginal.stockDisponible;
        } else {
            stock = parseFloat(option.dataset.stock);
        }

        const cantidadInput = document.getElementById('cantidad_vendida');
        if (cantidad > stock) {
            cantidadInput.classList.add('is-invalid');
            cantidadInput.setCustomValidity('La cantidad no puede exceder el stock disponible');
        } else {
            cantidadInput.classList.remove('is-invalid');
            cantidadInput.setCustomValidity('');
        }
    }

    // Resaltar si hay cambios
    resaltarCambios();
}

// Resetear formulario a valores originales
function resetearFormulario() {
    Swal.fire({
        title: '¿Resetear Formulario?',
        text: "Se restaurarán todos los valores originales",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6c757d',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Sí, resetear',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'btn btn-secondary-professional',
            cancelButton: 'btn btn-outline-professional'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Resetear valores
            document.getElementById('fecha_venta').value = '{{ $venta->fecha_venta->format('Y-m-d') }}';
            document.getElementById('cliente').value = '{{ $venta->cliente }}';
            document.getElementById('telefono_cliente').value = '{{ $venta->telefono_cliente }}';
            document.getElementById('cantidad_vendida').value = '{{ $venta->cantidad_vendida }}';
            document.getElementById('precio_por_kg').value = '{{ $venta->precio_por_kg }}';
            document.getElementById('total_venta').value = '{{ $venta->total_venta }}';
            document.getElementById('estado_pago').value = '{{ $venta->estado_pago }}';
            document.getElementById('metodo_pago').value = '{{ $venta->metodo_pago }}';
            document.getElementById('observaciones').value = '{{ $venta->observaciones }}';

            // Limpiar clases de validación y cambios
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.is-valid').forEach(el => el.classList.remove('is-valid'));
            document.querySelectorAll('.border-warning').forEach(el => el.classList.remove('border-warning'));
            document.querySelectorAll('.text-warning').forEach(el => el.classList.remove('text-warning'));

            // Actualizar stock
            actualizarStock();

            Swal.fire({
                title: '¡Reseteado!',
                text: 'El formulario ha sido restaurado',
                icon: 'success',
                confirmButtonColor: '#4a3728',
                customClass: {
                    confirmButton: 'btn btn-primary-professional'
                },
                buttonsStyling: false
            });
        }
    });
}

// Resaltar cambios en el formulario
function resaltarCambios() {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
    const precio = parseFloat(document.getElementById('precio_por_kg').value) || 0;
    const total = parseFloat(document.getElementById('total_venta').value) || 0;

    // Resaltar campos modificados con animación
    if (cantidad !== ventaOriginal.cantidad) {
        const element = document.getElementById('cantidad_vendida');
        element.classList.add('border-warning', 'field-changed');
        setTimeout(() => element.classList.remove('field-changed'), 500);
    } else {
        document.getElementById('cantidad_vendida').classList.remove('border-warning');
    }

    if (precio !== ventaOriginal.precio) {
        const element = document.getElementById('precio_por_kg');
        element.classList.add('border-warning', 'field-changed');
        setTimeout(() => element.classList.remove('field-changed'), 500);
    } else {
        document.getElementById('precio_por_kg').classList.remove('border-warning');
    }

    if (total !== ventaOriginal.total) {
        const element = document.getElementById('total_venta');
        element.classList.add('border-warning', 'text-warning', 'field-changed');
        setTimeout(() => element.classList.remove('field-changed'), 500);
    } else {
        const element = document.getElementById('total_venta');
        element.classList.remove('border-warning', 'text-warning');
    }
}

// Validación antes del envío
document.getElementById('editVentaForm').addEventListener('submit', function(e) {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value);
    const select = document.getElementById('recoleccion_id');

    if (select.value) {
        let stock;
        if (select.value == {{ $venta->recoleccion_id }}) {
            stock = ventaOriginal.stockDisponible;
        } else {
            const option = select.options[select.selectedIndex];
            stock = parseFloat(option.dataset.stock);
        }

        if (cantidad > stock) {
            e.preventDefault();
            Swal.fire({
                title: 'Error de Validación',
                text: `La cantidad a vender (${cantidad} kg) excede el stock disponible (${stock} kg)`,
                icon: 'error',
                confirmButtonColor: '#c62828',
                confirmButtonText: 'Entendido',
                customClass: {
                    confirmButton: 'btn btn-outline-professional'
                },
                buttonsStyling: false
            });
            return false;
        }
    }

    // Confirmar cambios importantes
    const cantidadCambiada = cantidad !== ventaOriginal.cantidad;
    const recoleccionCambiada = select.value != ventaOriginal.recoleccion;

    if (cantidadCambiada || recoleccionCambiada) {
        e.preventDefault();
        Swal.fire({
            title: 'Confirmar Cambios',
            text: "Los cambios en cantidad o lote afectarán el stock. ¿Continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f57c00',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar',
            customClass: {
                confirmButton: 'btn btn-warning-professional',
                cancelButton: 'btn btn-outline-professional'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    }
});

// Inicializar componentes al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Configuración inicial
    actualizarStock();
    calcularTotal();

    // Agregar animaciones escalonadas a las cards
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

    // Detectar cambios en tiempo real para resaltar
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            resaltarCambios();
        });

        input.addEventListener('change', function() {
            resaltarCambios();
        });
    });
});

// Detectar teclas de acceso rápido
document.addEventListener('keydown', function(e) {
    // Ctrl + S para guardar
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        document.getElementById('editVentaForm').submit();
    }

    // Ctrl + R para resetear
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        resetearFormulario();
    }

    // Escape para cancelar
    if (e.key === 'Escape') {
        window.location.href = '{{ route("ventas.show", $venta->id) }}';
    }
});

// Función para formatear números en tiempo real
function formatearNumero(input) {
    let valor = input.value.replace(/[^\d.]/g, '');
    input.value = valor;
}

// Agregar formato a los campos numéricos
document.addEventListener('DOMContentLoaded', function() {
    const numericInputs = document.querySelectorAll('input[type="number"]');
    numericInputs.forEach(input => {
        input.addEventListener('input', function() {
            formatearNumero(this);
        });
    });
});
</script>
