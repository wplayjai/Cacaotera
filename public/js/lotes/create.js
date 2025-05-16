
        document.addEventListener('DOMContentLoaded', function () {
            // Cambiar color del estado
            const estados = document.querySelectorAll('.estado');
            estados.forEach(estado => {
                if (estado.dataset.estado === 'Activo') {
                    estado.style.color = 'green'; // Color verde para Activo
                    estado.style.fontWeight = 'bold';
                } else if (estado.dataset.estado === 'Inactivo') {
                    estado.style.color = 'red'; // Color rojo para Inactivo
                    estado.style.fontWeight = 'bold';
                }
            });

            // Buscar por variedad de cacao
            const buscarVariedadInput = document.getElementById('buscarVariedad');
            const tablaLotes = document.getElementById('tablaLotes');
            const filas = tablaLotes.querySelectorAll('tbody tr');

            buscarVariedadInput.addEventListener('input', function () {
                const filtro = buscarVariedadInput.value.toLowerCase();
                filas.forEach(fila => {
                    const variedadCacao = fila.querySelector('.variedad-cacao').textContent.toLowerCase();
                    if (variedadCacao.includes(filtro)) {
                        fila.style.display = ''; // Mostrar fila
                    } else {
                        fila.style.display = 'none'; // Ocultar fila
                    }
                });
            });
        });
    
    function cargarDatosLote(lote) {
        // Configurar la acción del formulario
        document.getElementById('editarLoteForm').action = `/lotes/${lote.id}`;
        
        // Rellenar los campos con los datos del lote
        document.getElementById('edit_nombre').value = lote.nombre;
        document.getElementById('edit_fecha_inicio').value = lote.fecha_inicio;
        document.getElementById('edit_area').value = lote.area;
        document.getElementById('edit_capacidad').value = lote.capacidad;
        document.getElementById('edit_tipo_cacao').value = lote.tipo_cacao;
        document.getElementById('edit_estado').value = lote.estado;
        document.getElementById('edit_estimacion_cosecha').value = lote.estimacion_cosecha;
        document.getElementById('edit_fecha_programada_cosecha').value = lote.fecha_programada_cosecha;
        document.getElementById('edit_observaciones').value = lote.observaciones;
    }
