function verificarEliminarLote(estado, rutaEliminar) {
    if (estado.trim().toLowerCase() === 'activo') {
        new bootstrap.Modal(document.getElementById('modalLoteActivo')).show();
    } else {
        if (confirm('¿Está seguro de que desea eliminar este lote? Esta acción no se puede deshacer.')) {
            let form = document.createElement('form');
            form.action = rutaEliminar;
            form.method = 'POST';
            form.style.display = 'none';
            let csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            let method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }
}

function cargarDatosLote(lote) {
    const form = document.getElementById('editarLoteForm');
    form.action = '/lotes/' + lote.id;
    document.getElementById('edit_nombre').value = lote.nombre || '';
    document.getElementById('edit_fecha_inicio').value = lote.fecha_inicio || '';
    document.getElementById('edit_area').value = lote.area || '';
    document.getElementById('edit_capacidad').value = lote.capacidad || '';
    document.getElementById('edit_tipo_cacao').value = lote.tipo_cacao || '';
    document.getElementById('edit_estado').value = lote.estado || '';
    document.getElementById('edit_observaciones').value = lote.observaciones || '';
}

document.addEventListener('DOMContentLoaded', function() {
    // =================================================
    // MANEJO DE ACCESIBILIDAD PARA MODALES
    // =================================================
    
    // Función para mejorar accesibilidad de modales
    function setupModalAccessibility() {
        const modales = [
            'crearLoteModal',
            'editarLoteModal', 
            'modalExitoLote',
            'modalExitoEditarLote',
            'modalLoteActivo'
        ];

        modales.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal) {
                // Remover aria-hidden cuando el modal se muestra
                modal.addEventListener('show.bs.modal', function() {
                    this.removeAttribute('aria-hidden');
                });
                
                // Agregar aria-hidden cuando el modal se oculta
                modal.addEventListener('hidden.bs.modal', function() {
                    this.setAttribute('aria-hidden', 'true');
                });
                
                // Asegurar que el modal pueda recibir foco
                modal.addEventListener('shown.bs.modal', function() {
                    this.removeAttribute('aria-hidden');
                    // Establecer foco en el primer elemento focuseable
                    const firstFocusable = this.querySelector('input, button, select, textarea, [tabindex]:not([tabindex="-1"])');
                    if (firstFocusable) {
                        firstFocusable.focus();
                    }
                });
            }
        });
    }
    
    // Inicializar mejoras de accesibilidad
    setupModalAccessibility();
    
    // =================================================
    // CONFIGURACIÓN DE MODALES EXISTENTE
    // =================================================

    const crearLoteModal = document.getElementById('crearLoteModal');
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const formCrearLote = document.getElementById('formCrearLote');

    // Configurar modal crear
    crearLoteModal.addEventListener('show.bs.modal', function() {
        formCrearLote.reset();
        const btnGuardar = document.getElementById('btnGuardarLote');
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Lote';

        // Establecer fecha actual
        const hoy = new Date();
        const year = hoy.getFullYear();
        const month = String(hoy.getMonth() + 1).padStart(2, '0');
        const day = String(hoy.getDate()).padStart(2, '0');
        fechaInicioInput.value = `${year}-${month}-${day}`;

        // Limpiar campos
        document.getElementById('nombre').value = '';
        document.getElementById('area').value = '';
        document.getElementById('capacidad').value = '';
        document.getElementById('tipo_cacao').value = '';
        document.getElementById('observaciones').value = '';
        document.getElementById('estado').value = 'Activo';
    });

    // Manejar envío de formulario crear
    formCrearLote.addEventListener('submit', function(e) {
        e.preventDefault();
        const btnGuardar = document.getElementById('btnGuardarLote');

        if (btnGuardar.disabled) return;

        btnGuardar.disabled = true;
        const textoOriginal = btnGuardar.innerHTML;
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';

        const formData = new FormData(formCrearLote);

        fetch(formCrearLote.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (response.ok) {
                bootstrap.Modal.getInstance(document.getElementById('crearLoteModal')).hide();
                const modalExito = new bootstrap.Modal(document.getElementById('modalExitoLote'));
                modalExito.show();

                let countdown = 3;
                const countdownElement = document.getElementById('countdown');
                const countdownInterval = setInterval(() => {
                    countdown--;
                    countdownElement.textContent = countdown;
                    if (countdown <= 0) clearInterval(countdownInterval);
                }, 1000);

                setTimeout(function() {
                    modalExito.hide();
                    setTimeout(function() {
                        window.location.reload();
                    }, 300);
                }, 3000);
            } else {
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = textoOriginal;
                alert('Error al crear el lote. Por favor, inténtelo de nuevo.');
            }
        })
        .catch(error => {
            btnGuardar.disabled = false;
            btnGuardar.innerHTML = textoOriginal;
            console.error('Error:', error);
            alert('Error al crear el lote. Por favor, inténtelo de nuevo.');
        });
    });

    // Manejar envío de formulario editar
    const formEditarLote = document.getElementById('editarLoteForm');
    formEditarLote.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('=== INICIANDO EDICIÓN DE LOTE ===');

        const formData = new FormData(formEditarLote);

        // Limpiar y validar datos antes del envío
        const capacidadValue = formData.get('capacidad');
        if (capacidadValue) {
            // Remover caracteres no numéricos excepto punto decimal
            const cleanCapacidad = capacidadValue.toString().replace(/[^0-9.]/g, '');
            // Convertir a número entero
            const intCapacidad = Math.floor(parseFloat(cleanCapacidad) || 0);
            formData.set('capacidad', intCapacidad.toString());
            console.log(`Capacidad original: "${capacidadValue}" -> Limpiada: "${intCapacidad}"`);
        }

        // Verificar que _method=PUT está presente
        if (!formData.has('_method')) {
            console.error('¡FALTA _method=PUT! Agregando...');
            formData.append('_method', 'PUT');
        }

        // Debug: Mostrar datos del formulario
        console.log('Form action:', formEditarLote.action);
        console.log('Datos del formulario:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // Debug: Verificar que tenemos el header X-Requested-With
        const headers = {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest' // Importante para que Laravel detecte AJAX
        };

        console.log('Headers que se enviarán:', headers);

        fetch(formEditarLote.action, {
            method: 'POST', // Laravel usa POST con _method=PUT
            body: formData,
            headers: headers
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            // Verificar si la respuesta es exitosa
            if (response.ok) {
                return response.json();
            } else if (response.status === 422) {
                // Error de validación específico
                return response.json().then(errorData => {
                    console.error('Errores de validación:', errorData);
                    let mensaje = 'Errores de validación:\n';
                    if (errorData.errors) {
                        Object.keys(errorData.errors).forEach(field => {
                            mensaje += `• ${field}: ${errorData.errors[field].join(', ')}\n`;
                        });
                    }
                    throw new Error(mensaje);
                });
            } else {
                // Si hay error, obtener el texto de respuesta para diagnóstico
                return response.text().then(text => {
                    console.error('Error response body:', text);
                    throw new Error(`HTTP ${response.status}: ${response.statusText}\nResponse: ${text}`);
                });
            }
        })
        .then(data => {
            console.log('=== RESPUESTA EXITOSA ===');
            console.log('Datos recibidos:', data);

            // Cerrar modal de edición
            bootstrap.Modal.getInstance(document.getElementById('editarLoteModal')).hide();

            // Mostrar modal de éxito
            const modalExitoEditar = new bootstrap.Modal(document.getElementById('modalExitoEditarLote'));
            modalExitoEditar.show();

            // Countdown para cerrar modal
            let countdownEdit = 3;
            const countdownEditElement = document.getElementById('countdownEdit');
            const countdownEditInterval = setInterval(() => {
                countdownEdit--;
                countdownEditElement.textContent = countdownEdit;
                if (countdownEdit <= 0) clearInterval(countdownEditInterval);
            }, 1000);

            // Recargar página después del countdown
            setTimeout(function() {
                modalExitoEditar.hide();
                setTimeout(function() {
                    console.log('Recargando página...');
                    window.location.reload();
                }, 300);
            }, 3000);
        })
        .catch(error => {
            console.error('=== ERROR EN EDICIÓN ===');
            console.error('Error completo:', error);
            alert('Error al editar el lote: ' + error.message);
        });
    });

    // Funcionalidad de búsqueda inteligente con resaltado
    const buscarInput = document.getElementById('buscarVariedad');
    const tablaLotes = document.getElementById('tablaLotes');
    const filasLotes = tablaLotes.querySelectorAll('tbody tr');
    const totalLotesElement = document.getElementById('totalLotes');

    // Función para limpiar resaltados
    function clearHighlights() {
        filasLotes.forEach(function(row) {
            row.querySelectorAll('mark.search-highlight').forEach(function(mark) {
                mark.replaceWith(document.createTextNode(mark.textContent));
            });
        });
    }

    // Función para resaltar texto encontrado
    function highlightSearchText(searchTerm) {
        if (searchTerm.length === 0) return;

        filasLotes.forEach(function(row) {
            // Buscar en el nombre del lote (primera columna)
            const nameCell = row.querySelector('td:first-child .fw-bold');
            if (nameCell) {
                const nameText = nameCell.textContent;
                if (nameText.toLowerCase().includes(searchTerm.toLowerCase())) {
                    const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                    const highlightedText = nameText.replace(regex, '<mark class="search-highlight">$1</mark>');
                    nameCell.innerHTML = highlightedText;
                }
            }

            // También resaltar en tipo de cacao (quinta columna)
            const typeCell = row.querySelector('td:nth-child(5)');
            if (typeCell) {
                const cellText = typeCell.textContent;
                if (cellText.toLowerCase().includes(searchTerm.toLowerCase())) {
                    const regex = new RegExp(`(${searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                    const highlightedText = cellText.replace(regex, '<mark class="search-highlight">$1</mark>');
                    typeCell.innerHTML = highlightedText;
                }
            }
        });
    }

    buscarInput.addEventListener('input', function() {
        const terminoBusqueda = this.value.toLowerCase().trim();
        let lotesVisibles = 0;

        // Limpiar resaltados previos
        clearHighlights();

        filasLotes.forEach(function(fila) {
            if (fila.classList.contains('mensaje-sin-resultados')) {
                fila.remove();
                return;
            }

            let coincide = false;

            if (terminoBusqueda === '') {
                coincide = true;
            } else {
                // Búsqueda inteligente en múltiples campos
                const nombre = fila.querySelector('td:first-child .fw-bold')?.textContent?.toLowerCase()?.trim() || '';
                const tipoCacao = fila.querySelector('td:nth-child(5)')?.textContent?.toLowerCase()?.trim() || '';
                const estado = fila.querySelector('td:nth-child(6)')?.textContent?.toLowerCase()?.trim() || '';
                const observaciones = fila.querySelector('td:nth-child(7)')?.textContent?.toLowerCase()?.trim() || '';

                // Búsqueda por primera letra si es un solo carácter
                if (terminoBusqueda.length === 1) {
                    coincide = nombre.startsWith(terminoBusqueda) ||
                              tipoCacao.startsWith(terminoBusqueda);
                } else {
                    // Búsqueda completa en todos los campos
                    const palabrasBusqueda = terminoBusqueda.split(' ').filter(p => p.length > 0);
                    coincide = palabrasBusqueda.every(palabra =>
                        nombre.includes(palabra) ||
                        tipoCacao.includes(palabra) ||
                        estado.includes(palabra) ||
                        observaciones.includes(palabra)
                    );

                    // También coincide si encuentra la frase completa
                    if (!coincide) {
                        coincide = nombre.includes(terminoBusqueda) ||
                                  tipoCacao.includes(terminoBusqueda) ||
                                  estado.includes(terminoBusqueda) ||
                                  observaciones.includes(terminoBusqueda);
                    }
                }
            }

            fila.style.display = coincide ? '' : 'none';
            if (coincide) lotesVisibles++;
        });

        // Aplicar resaltado si hay búsqueda
        if (terminoBusqueda.length > 0) {
            highlightSearchText(terminoBusqueda);
        }

        // Actualizar contador
        totalLotesElement.textContent = lotesVisibles;

        // Mostrar mensaje si no hay resultados
        const tbody = tablaLotes.querySelector('tbody');
        const mensajeAnterior = tbody.querySelector('.mensaje-sin-resultados');
        if (mensajeAnterior) mensajeAnterior.remove();

        if (lotesVisibles === 0 && terminoBusqueda !== '') {
            const filaMensaje = document.createElement('tr');
            filaMensaje.className = 'mensaje-sin-resultados no-results-row';
            filaMensaje.innerHTML = `
                <td colspan="8" class="text-center py-5">
                    <div class="no-results">
                        <i class="fas fa-search-minus fa-3x mb-3 text-muted"></i>
                        <h5 class="text-muted">No se encontraron lotes</h5>
                        <p class="text-muted">No hay lotes que coincidan con "<span style="color: var(--cacao-primary); font-weight: 600;">${terminoBusqueda}</span>"</p>
                        <button class="btn btn-professional btn-sm" onclick="limpiarBusqueda()">
                            <i class="fas fa-undo me-1"></i>Limpiar Búsqueda
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(filaMensaje);
        }
    });

    // Función para limpiar búsqueda
    window.limpiarBusqueda = function() {
        clearHighlights();
        buscarInput.value = '';
        buscarInput.dispatchEvent(new Event('input'));
    };

    // Enfocar automáticamente el campo de búsqueda
    buscarInput.addEventListener('focus', function() {
        this.parentElement.classList.add('search-focused');
    });

    buscarInput.addEventListener('blur', function() {
        this.parentElement.classList.remove('search-focused');
    });

    // Validación en tiempo real para campos numéricos
    const capacidadInputs = document.querySelectorAll('input[name="capacidad"]');
    capacidadInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Remover caracteres no numéricos
            this.value = this.value.replace(/[^0-9]/g, '');
            // Limitar a 5 dígitos máximo
            if (this.value.length > 5) {
                this.value = this.value.slice(0, 5);
            }
        });

        input.addEventListener('blur', function() {
            // Validar rango al perder el foco
            const value = parseInt(this.value);
            if (value < 1) {
                this.value = '1';
            } else if (value > 99999) {
                this.value = '99999';
            }
        });
    });

    const areaInputs = document.querySelectorAll('input[name="area"]');
    areaInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Permitir números y punto decimal
            this.value = this.value.replace(/[^0-9.]/g, '');
            // Prevenir múltiples puntos decimales
            const parts = this.value.split('.');
            if (parts.length > 2) {
                this.value = parts[0] + '.' + parts.slice(1).join('');
            }
        });
    });

    // ===============================================
    // MANEJO MEJORADO DE ACCESIBILIDAD PARA MODALES
    // ===============================================
    
    // Lista de modales en la página
    const modales = [
        'editarLoteModal',
        'modalExitoLote', 
        'modalExitoEditarLote',
        'crearLoteModal',
        'modalLoteActivo'
    ];

    modales.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Remover aria-hidden antes de mostrar
            modal.addEventListener('show.bs.modal', function() {
                this.removeAttribute('aria-hidden');
            });
            
            // Gestionar foco cuando se muestra
            modal.addEventListener('shown.bs.modal', function() {
                this.removeAttribute('aria-hidden');
                
                // Enfocar el primer elemento focusable
                const focusableElements = modal.querySelectorAll(
                    'input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]):not([style*="display: none"]), [tabindex]:not([tabindex="-1"])'
                );
                
                if (focusableElements.length > 0) {
                    setTimeout(() => {
                        focusableElements[0].focus();
                        if (focusableElements[0].type === 'text') {
                            focusableElements[0].select();
                        }
                    }, 150);
                }
            });

            // Limpiar al ocultar modal
            modal.addEventListener('hidden.bs.modal', function() {
                // Remover cualquier foco residual
                if (document.activeElement && this.contains(document.activeElement)) {
                    document.activeElement.blur();
                }
                
                // Asegurar que no queden atributos problemáticos
                this.setAttribute('aria-hidden', 'true');
            });

            // Manejar eventos de teclado para accesibilidad
            modal.addEventListener('keydown', function(e) {
                // Escape para cerrar
                if (e.key === 'Escape') {
                    const modalInstance = bootstrap.Modal.getInstance(this);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
                
                // Tab trapping dentro del modal
                if (e.key === 'Tab') {
                    const focusableElements = this.querySelectorAll(
                        'input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex]:not([tabindex="-1"])'
                    );
                    
                    if (focusableElements.length > 0) {
                        const firstElement = focusableElements[0];
                        const lastElement = focusableElements[focusableElements.length - 1];
                        
                        if (e.shiftKey && document.activeElement === firstElement) {
                            e.preventDefault();
                            lastElement.focus();
                        } else if (!e.shiftKey && document.activeElement === lastElement) {
                            e.preventDefault();
                            firstElement.focus();
                        }
                    }
                }
            });
        }
    });
});
