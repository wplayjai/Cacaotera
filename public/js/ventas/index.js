// Actualizar información de stock disponible
function actualizarStock() {
    const select = document.getElementById('recoleccion_id');
    const stockInfo = document.getElementById('stockInfo');
    const cantidadInput = document.getElementById('cantidad_vendida');

    if (select.value) {
        stockInfo.innerHTML = '<i class="fas fa-spinner fa-spin text-primary"></i> Cargando información...';
        stockInfo.className = 'form-text text-info';
        cantidadInput.value = '';
        cantidadInput.placeholder = 'Cargando...';

        // Cambia la URL si usas ventas/obtener-stock/{id}
        const url = `/ventas/obtener-stock/${select.value}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.stock_disponible !== undefined) {
                    // Mostrar información
                    stockInfo.innerHTML = `
                        <div>
                            <strong>📦 Stock Disponible:</strong> ${data.stock_disponible} kg<br>
                            <strong>🧺 Cantidad Recolectada:</strong> ${data.cantidad_recolectada} kg<br>
                            <strong>🏷️ Lote:</strong> ${data.lote}<br>
                            <strong>🍫 Tipo de Cacao:</strong> ${data.tipo_cacao}
                        </div>
                    `;
                    cantidadInput.max = data.stock_disponible;
                    cantidadInput.placeholder = data.stock_disponible > 0 ? `Máximo ${data.stock_disponible} kg disponibles` : 'Sin stock disponible';
                    cantidadInput.disabled = data.stock_disponible <= 0;
                } else {
                    stockInfo.innerHTML = `<span class="text-danger">No se pudo obtener el stock.</span>`;
                    cantidadInput.placeholder = '0.00';
                    cantidadInput.disabled = false;
                }
            })
            .catch(error => {
                stockInfo.innerHTML = `<span class="text-danger">Error de conexión.</span>`;
                cantidadInput.placeholder = '0.00';
                cantidadInput.disabled = false;
            });
    } else {
        stockInfo.innerHTML = '';
        cantidadInput.max = '';
        cantidadInput.value = '';
        cantidadInput.placeholder = '0.00';
        cantidadInput.disabled = false;
    }
}
// Calcular total de la venta
function calcularTotal() {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
    const precio = parseFloat(document.getElementById('precio_por_kg').value) || 0;
    const total = cantidad * precio;

    document.getElementById('total_venta').value = total.toFixed(2);

    // Validar que no exceda el stock
    const select = document.getElementById('recoleccion_id');
    if (select.value) {
        const option = select.options[select.selectedIndex];
        const stock = parseFloat(option.dataset.stock);

        if (cantidad > stock) {
            document.getElementById('cantidad_vendida').classList.add('is-invalid');
            document.getElementById('cantidad_vendida').setCustomValidity('La cantidad no puede exceder el stock disponible');
        } else {
            document.getElementById('cantidad_vendida').classList.remove('is-invalid');
            document.getElementById('cantidad_vendida').setCustomValidity('');
        }
    }
}

// Ver detalles de venta
function verDetalle(id) {
    // Implementar modal de detalles o redireccionar
    window.location.href = `/ventas/${id}`;
}

// Editar venta
function editarVenta(id) {
    // Implementar modal de edición o redireccionar
    window.location.href = `/ventas/${id}/edit`;
}

// Marcar como pagado
function marcarPagado(id) {
    Swal.fire({
        title: '¿Marcar como Pagado?',
        text: "Se actualizará el estado de pago de la venta",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, marcar como pagado',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/ventas/${id}/pagar`;
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

// Eliminar venta
function eliminarVenta(id) {
    Swal.fire({
        title: '¿Eliminar Venta?',
        text: "Esta acción no se puede deshacer. El stock se restaurará automáticamente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
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

// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Agregar animaciones a las estadísticas
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in-up');
        }, index * 100);
    });

    // Agregar efectos hover a los botones
    const buttons = document.querySelectorAll('.btn-professional');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
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

// Validación del formulario antes del envío
document.getElementById('ventaForm').addEventListener('submit', function(e) {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value);
    const select = document.getElementById('recoleccion_id');

    if (select.value) {
        const option = select.options[select.selectedIndex];
        const stock = parseFloat(option.dataset.stock);

        if (cantidad > stock) {
            e.preventDefault();
            Swal.fire({
                title: 'Error de Validación',
                text: `La cantidad a vender (${cantidad} kg) excede el stock disponible (${stock} kg)`,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return false;
        }
    }
});
