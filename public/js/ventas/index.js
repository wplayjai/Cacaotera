// Actualizar información de stock disponible
function actualizarStock() {
    const select = document.getElementById('recoleccion_id');
    const stockInfo = document.getElementById('stockInfo');
    const cantidadInput = document.getElementById('cantidad_vendida');

    if (select.value) {
        // Limpiar la información anterior
        stockInfo.innerHTML = '<i class="fas fa-spinner fa-spin text-primary"></i> Cargando información...';
        stockInfo.className = 'form-text text-info';
        cantidadInput.value = '';
        cantidadInput.placeholder = 'Cargando...';

        // Hacer petición AJAX para obtener detalles
        const url = `/ventas/obtener-detalle/${select.value}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const recoleccion = data.data;
                    const stock = parseFloat(recoleccion.cantidad_disponible);
                    const cantidadRecolectada = parseFloat(recoleccion.cantidad_recolectada);

                    // Mostrar información completa de la recolección
                    stockInfo.innerHTML = `
                        <div style="background: linear-gradient(135deg, #e8f5e8, #d4edda); padding: 0.8rem; border-radius: 8px; border: 2px solid #28a745; margin-top: 0.5rem;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.75rem;">
                                <div>
                                    <strong style="color: #1e7e34;">📦 Stock Disponible:</strong><br>
                                    <span style="font-size: 0.9rem; font-weight: bold; color: #155724;">${stock} kg</span>
                                </div>
                                <div>
                                    <strong style="color: #1e7e34;">🌾 Cantidad Recolectada:</strong><br>
                                    <span style="font-size: 0.9rem; font-weight: bold; color: #155724;">${cantidadRecolectada} kg</span>
                                </div>
                                <div>
                                    <strong style="color: #1e7e34;">🏷️ Lote:</strong><br>
                                    <span style="color: #155724;">${recoleccion.lote_nombre}</span>
                                </div>
                                <div>
                                    <strong style="color: #1e7e34;">🍫 Tipo de Cacao:</strong><br>
                                    <span style="color: #155724;">${recoleccion.tipo_cacao}</span>
                                </div>
                                <div style="grid-column: 1 / -1;">
                                    <strong style="color: #1e7e34;">📅 Fecha de Recolección:</strong>
                                    <span style="color: #155724; margin-left: 0.5rem;">${recoleccion.fecha_recoleccion}</span>
                                </div>
                            </div>
                        </div>
                    `;

                    // Configurar el campo de cantidad
                    cantidadInput.max = stock;
                    cantidadInput.placeholder = stock > 0 ? `Máximo ${stock} kg disponibles` : 'Sin stock disponible';

                    // Auto-llenar solo si hay stock disponible
                    if (stock > 0) {
                        // Si el stock es pequeño (≤ 50kg), auto-llenar
                        if (stock <= 50) {
                            cantidadInput.value = stock;
                            calcularTotal();

                            // Mostrar notificación discreta
                            const notification = document.createElement('div');
                            notification.innerHTML = `
                                <div style="background: #d1ecf1; color: #0c5460; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.7rem; margin-top: 0.3rem; border-left: 3px solid #17a2b8;">
                                    ✨ Cantidad auto-rellenada: ${stock} kg (stock completo)
                                </div>
                            `;
                            stockInfo.appendChild(notification.firstElementChild);

                            // Quitar la notificación después de 4 segundos
                            setTimeout(() => {
                                const notif = stockInfo.querySelector('div[style*="background: #d1ecf1"]');
                                if (notif) notif.remove();
                            }, 4000);
                        }

                        stockInfo.className = 'form-text text-success';
                    } else {
                        // Si no hay stock disponible
                        stockInfo.innerHTML += `
                            <div style="background: #f8d7da; color: #721c24; padding: 0.5rem; border-radius: 5px; margin-top: 0.5rem; border-left: 3px solid #dc3545;">
                                ⚠️ <strong>Sin stock disponible para venta</strong>
                            </div>
                        `;
                        stockInfo.className = 'form-text text-danger';
                        cantidadInput.disabled = true;
                    }
                } else {
                    stockInfo.innerHTML = `
                        <div style="background: #f8d7da; padding: 0.5rem; border-radius: 5px; border-left: 4px solid #dc3545;">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            <strong>Error:</strong> ${data.message}
                        </div>
                    `;
                    stockInfo.className = 'form-text text-danger';
                    cantidadInput.placeholder = '0.00';
                    cantidadInput.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error en la petición AJAX:', error);
                stockInfo.innerHTML = `
                    <div style="background: #f8d7da; padding: 0.5rem; border-radius: 5px; border-left: 4px solid #dc3545;">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                        <strong>Error de conexión:</strong> No se pudo cargar la información del lote
                    </div>
                `;
                stockInfo.className = 'form-text text-danger';
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
