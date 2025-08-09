/**
 * JavaScript para la vista de edición de recolecciones
 * Archivo: public/js/recolecciones/edit.js
 */

// Configuración global (se pasa desde Blade)
let editConfig = window.editConfig || {};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editForm');
    const inputs = form.querySelectorAll('input, select, textarea');

    // Validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            validateField(this);
        });

        input.addEventListener('blur', function() {
            validateField(this);
        });
    });

    // Validación de campos individuales
    function validateField(field) {
        const isValid = field.checkValidity();
        field.classList.toggle('is-valid', isValid && field.value.trim() !== '');
        field.classList.toggle('is-invalid', !isValid && field.value.trim() !== '');
    }

    // Validación del formulario completo
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();

            // Mostrar alerta
            Swal.fire({
                icon: 'error',
                title: 'Formulario incompleto',
                text: 'Por favor completa todos los campos obligatorios.',
                confirmButtonColor: '#4a3728'
            });
        } else {
            // Confirmar guardado
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: '¿Guardar cambios?',
                text: 'Se actualizará la información de esta recolección.',
                showCancelButton: true,
                confirmButtonColor: '#27ae60',
                cancelButtonColor: '#6b4e3d',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        form.classList.add('was-validated');
    });

    // Validación de horas
    const horaInicio = document.getElementById('hora_inicio');
    const horaFin = document.getElementById('hora_fin');

    function validarHoras() {
        if (horaInicio.value && horaFin.value) {
            if (horaInicio.value >= horaFin.value) {
                horaFin.setCustomValidity('La hora de fin debe ser posterior a la hora de inicio');
            } else {
                horaFin.setCustomValidity('');
            }
        }
    }

    horaInicio.addEventListener('change', validarHoras);
    horaFin.addEventListener('change', validarHoras);

    // Auto-resize del textarea
    const observaciones = document.getElementById('observaciones');
    observaciones.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});

// Función para restablecer el formulario
function resetForm() {
    Swal.fire({
        icon: 'warning',
        title: '¿Restablecer formulario?',
        text: 'Se perderán todos los cambios no guardados.',
        showCancelButton: true,
        confirmButtonColor: '#a0845c',
        cancelButtonColor: '#6b4e3d',
        confirmButtonText: 'Sí, restablecer',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editForm').reset();
            document.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                el.classList.remove('is-valid', 'is-invalid');
            });
        }
    });
}

// Exponer funciones globalmente
window.resetForm = resetForm;
