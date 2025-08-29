function eliminarRecoleccion(id) {
    Swal.fire({
        title: '¿Eliminar Recolección?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4a3728',
        cancelButtonColor: '#6b4e3d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/recolecciones/${id}`;
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

// ========================================
// FUNCIONES DEL MODAL DE EDICIÓN
// ========================================

function openEditModal(recoleccionId) {
    // Mostrar el modal con loading
    const modal = document.getElementById('editModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Cargar datos de la recolección
    fetch(`/api/recolecciones/${recoleccionId}/edit-data`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar los datos');
            }
            return response.json();
        })
        .then(data => {
            populateEditForm(data);
        })
        .catch(error => {
            console.error('Error:', error);
            showModalAlert('Error al cargar los datos de la recolección', 'danger');
        });
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';

    // Limpiar formulario y alertas
    document.getElementById('editForm').reset();
    hideModalAlert();
}

function populateEditForm(data) {
    const form = document.getElementById('editForm');
    const recoleccion = data.recoleccion;

    // Establecer la URL de actualización
    form.action = data.update_url;

    // Llenar opciones de producción
    const produccionSelect = document.getElementById('edit_produccion_id');
    produccionSelect.innerHTML = '<option value="">Seleccionar producción...</option>';
    data.producciones.forEach(produccion => {
        const option = document.createElement('option');
        option.value = produccion.id;
        option.textContent = produccion.display_name;
        option.selected = produccion.id == recoleccion.produccion_id;
        produccionSelect.appendChild(option);
    });

    // Llenar opciones de trabajadores
    const trabajadoresSelect = document.getElementById('edit_trabajadores_participantes');
    trabajadoresSelect.innerHTML = '';
    data.trabajadores.forEach(trabajador => {
        const option = document.createElement('option');
        option.value = trabajador.id;
        option.textContent = trabajador.nombre_completo;
        option.selected = recoleccion.trabajadores_participantes.includes(trabajador.id);
        trabajadoresSelect.appendChild(option);
    });

    // Llenar campos del formulario
    document.getElementById('edit_cantidad_recolectada').value = recoleccion.cantidad_recolectada;
    document.getElementById('edit_estado_fruto').value = recoleccion.estado_fruto;
    document.getElementById('edit_fecha_recoleccion').value = recoleccion.fecha_recoleccion;
    document.getElementById('edit_condiciones_climaticas').value = recoleccion.condiciones_climaticas;
    document.getElementById('edit_calidad_promedio').value = recoleccion.calidad_promedio || '';
    document.getElementById('edit_observaciones').value = recoleccion.observaciones || '';
}

function showModalAlert(message, type = 'danger') {
    const alertsContainer = document.getElementById('modalAlerts');
    alertsContainer.innerHTML = `
        <div class="alert alert-${type}">
            <h6 class="mb-0">${message}</h6>
        </div>
    `;
    alertsContainer.style.display = 'block';
}

function hideModalAlert() {
    const alertsContainer = document.getElementById('modalAlerts');
    alertsContainer.style.display = 'none';
    alertsContainer.innerHTML = '';
}

// Manejar envío del formulario de edición
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    // Deshabilitar botón de envío
    const submitBtn = form.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Guardando...';
    submitBtn.disabled = true;

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.ok) {
            // Si la actualización fue exitosa, recargar la página
            window.location.reload();
        } else {
            return response.json().then(data => {
                throw new Error(data.message || 'Error al actualizar la recolección');
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showModalAlert(error.message || 'Error al actualizar la recolección', 'danger');

        // Rehabilitar botón de envío
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// Cerrar modal al hacer clic fuera de él
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('editModal');
        if (modal.style.display === 'flex') {
            closeEditModal();
        }
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
