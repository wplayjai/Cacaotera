@extends('layouts.masterr')

@section('content')
<link rel="stylesheet" href="{{ asset('css/recolecciones/create.css') }}">

<div class="container-fluid">
    <!-- Título principal -->
    <h1 class="main-title">
        Registrar Nueva Recolección
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-seedling"></i>
                        Registro de Recolección Diaria
                    </h4>
                    @if($produccionSeleccionada)
                        <p class="card-subtitle">
                            <strong>Lote:</strong> {{ $produccionSeleccionada->lote?->nombre ?? 'Sin lote' }} -
                            <strong>Tipo:</strong> {{ $produccionSeleccionada->tipo_cacao }}
                        </p>
                    @endif
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Error en los datos:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('recolecciones.store') }}" method="POST" id="recoleccionForm">
                        @csrf

                        <!-- Sección: Información Básica -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-info-circle icon-accent"></i>
                                Información Básica
                            </h5>

                            <div class="form-grid form-grid-2">
                                <div class="form-group">
                                    <label for="produccion_id" class="form-label">
                                        <i class="fas fa-seedling icon-accent"></i>
                                        Lote/Producción *
                                    </label>
                                    <select class="form-select" id="produccion_id" name="produccion_id" required>
                                        <option value="">Selecciona un lote...</option>
                                        @foreach($producciones as $produccion)
                                            <option value="{{ $produccion->id }}"
                                                    data-estimacion="{{ $produccion->estimacion_produccion }}"
                                                    data-recolectado="{{ $produccion->total_recolectado }}"
                                                    {{ old('produccion_id', $produccionSeleccionada?->id) == $produccion->id ? 'selected' : '' }}>
                                                {{ $produccion->lote?->nombre ?? 'Sin lote' }} - {{ $produccion->tipo_cacao }}
                                                ({{ number_format($produccion->total_recolectado, 2) }}/{{ number_format($produccion->estimacion_produccion, 2) }} kg)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_recoleccion" class="form-label">
                                        <i class="fas fa-calendar icon-accent"></i>
                                        Fecha de Recolección *
                                    </label>
                                    <input type="date" class="form-control" id="fecha_recoleccion"
                                           name="fecha_recoleccion" value="{{ old('fecha_recoleccion', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <!-- Panel de información del lote -->
                            <div id="infoProduccion" class="info-panel d-none">
                                <h6 class="info-title">
                                    <i class="fas fa-chart-line"></i>
                                    Progreso del Lote
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Estimado Total</div>
                                        <div class="info-value"><span id="estimacion">0</span> kg</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Ya Recolectado</div>
                                        <div class="info-value"><span id="recolectado">0</span> kg</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Pendiente</div>
                                        <div class="info-value"><span id="pendiente">0</span> kg</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Progreso</div>
                                        <div class="info-value"><span id="progreso">0</span>%</div>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" id="barraProgreso" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Cantidad Recolectada -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-weight-hanging icon-accent"></i>
                                Cantidad Recolectada
                            </h5>

                            <div class="form-grid form-grid-2">
                                <div class="form-group">
                                    <label for="cantidad_recolectada" class="form-label">
                                        <i class="fas fa-balance-scale icon-accent"></i>
                                        Cantidad en Kilogramos *
                                    </label>
                                    <input type="number" class="form-control" id="cantidad_recolectada"
                                           name="cantidad_recolectada" value="{{ old('cantidad_recolectada') }}"
                                           min="0.001" max="99999.999" step="0.001" required
                                           placeholder="Ej: 125.500">
                                    <small class="form-text">Peso en kilogramos con hasta 3 decimales</small>
                                </div>

                                <div class="form-group">
                                    <label for="estado_fruto" class="form-label">
                                        <i class="fas fa-apple-alt icon-accent"></i>
                                        Estado del Fruto *
                                    </label>
                                    <select class="form-select" id="estado_fruto" name="estado_fruto" required>
                                        <option value="">Selecciona el estado...</option>
                                        <option value="optimo" {{ old('estado_fruto', 'optimo') == 'optimo' ? 'selected' : '' }}>
                                            Óptimo - Fruta madura ideal
                                        </option>
                                        <option value="bueno" {{ old('estado_fruto') == 'bueno' ? 'selected' : '' }}>
                                            Bueno - Fruta en buen estado
                                        </option>
                                        <option value="regular" {{ old('estado_fruto') == 'regular' ? 'selected' : '' }}>
                                            Regular - Fruta aceptable
                                        </option>
                                        <option value="deficiente" {{ old('estado_fruto') == 'deficiente' ? 'selected' : '' }}>
                                            Deficiente - Fruta de baja calidad
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid form-grid-2">
                                <div class="form-group">
                                    <label for="condiciones_climaticas" class="form-label">
                                        <i class="fas fa-cloud-sun icon-accent"></i>
                                        Condiciones Climáticas
                                    </label>
                                    <select class="form-select" id="condiciones_climaticas" name="condiciones_climaticas" required>
                                        <option value="">Selecciona...</option>
                                        <option value="soleado" {{ old('condiciones_climaticas') == 'soleado' ? 'selected' : '' }}>
                                            ☀️ Soleado
                                        </option>
                                        <option value="nublado" {{ old('condiciones_climaticas') == 'nublado' ? 'selected' : '' }}>
                                            ☁️ Nublado
                                        </option>
                                        <option value="lluvioso" {{ old('condiciones_climaticas') == 'lluvioso' ? 'selected' : '' }}>
                                            🌧️ Lluvioso
                                        </option>
                                        <option value="ventoso" {{ old('condiciones_climaticas') == 'ventoso' ? 'selected' : '' }}>
                                            💨 Ventoso
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="calidad_promedio" class="form-label">
                                        <i class="fas fa-star icon-accent"></i>
                                        Calidad Promedio
                                    </label>
                                    <select class="form-select" id="calidad_promedio" name="calidad_promedio">
                                        <option value="">Selecciona...</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('calidad_promedio') == $i ? 'selected' : '' }}>
                                                {{ $i }} - {{ $i == 1 ? 'Muy Baja' : ($i == 2 ? 'Baja' : ($i == 3 ? 'Regular' : ($i == 4 ? 'Buena' : 'Excelente'))) }}
                                            </option>
                                        @endfor
                                    </select>
                                    <small class="form-text">Calidad del cacao del 1 al 5 (1=Muy Baja, 5=Excelente)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Horarios de Trabajo -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-clock icon-accent"></i>
                                Horarios de Trabajo
                            </h5>

                            <div class="form-grid form-grid-2">
                                <div class="form-group">
                                    <label for="hora_inicio" class="form-label">
                                        <i class="fas fa-play icon-accent"></i>
                                        Hora de Inicio
                                    </label>
                                    <input type="time" class="form-control" id="hora_inicio"
                                           name="hora_inicio" value="{{ old('hora_inicio', '06:00') }}">
                                    <small class="form-text">Hora en que inició la recolección</small>
                                </div>

                                <div class="form-group">
                                    <label for="hora_fin" class="form-label">
                                        <i class="fas fa-stop icon-accent"></i>
                                        Hora de Fin
                                    </label>
                                    <input type="time" class="form-control" id="hora_fin"
                                           name="hora_fin" value="{{ old('hora_fin') }}">
                                    <small class="form-text">Hora en que finalizó la recolección</small>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Personal y Observaciones -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-users icon-accent"></i>
                                Personal y Observaciones
                            </h5>

                            <div class="form-grid form-grid-full">
                                <div class="form-group">
                                    <label for="trabajadores_participantes" class="form-label">
                                        <i class="fas fa-user-friends icon-accent"></i>
                                        Trabajadores Participantes *
                                    </label>
                                    <select class="form-select" id="trabajadores_participantes"
                                            name="trabajadores_participantes[]" multiple required>
                                        @foreach($trabajadores as $trabajador)
                                            <option value="{{ $trabajador->id }}"
                                                    {{ in_array($trabajador->id, old('trabajadores_participantes', [])) ? 'selected' : '' }}>
                                                {{ $trabajador->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="help-text">
                                        <i class="fas fa-info-circle"></i>
                                        Mantén presionado <kbd class="kbd-style">Ctrl</kbd> para seleccionar múltiples trabajadores
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="observaciones" class="form-label">
                                        <i class="fas fa-comment-alt icon-accent"></i>
                                        Observaciones
                                    </label>
                                    <textarea class="form-control" id="observaciones" name="observaciones"
                                              rows="4" placeholder="Notas adicionales sobre la recolección, condiciones especiales, incidencias, etc.">{{ old('observaciones') }}</textarea>
                                    <small class="form-text">Máximo 500 caracteres</small>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i>
                                Registrar Recolección
                            </button>
                            <a href="{{ route('produccion.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i>
                                Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Configuración para JavaScript
window.createConfig = {
    produccionSeleccionada: {{ $produccionSeleccionada ? $produccionSeleccionada->id : 'null' }},
    storeUrl: '{{ route('recolecciones.store') }}',
    indexUrl: '{{ route('produccion.index') }}'
};

// Función para actualizar información del lote
function actualizarInfoProduccion() {
    const select = document.getElementById('produccion_id');
    const infoPanel = document.getElementById('infoProduccion');
    const cantidadInput = document.getElementById('cantidad_recolectada');

    if (select.value) {
        const option = select.options[select.selectedIndex];
        const estimacion = parseFloat(option.dataset.estimacion);
        const recolectado = parseFloat(option.dataset.recolectado);
        const pendiente = estimacion - recolectado;
        const progreso = (recolectado / estimacion) * 100;

        // Actualizar valores
        document.getElementById('estimacion').textContent = estimacion.toFixed(2);
        document.getElementById('recolectado').textContent = recolectado.toFixed(2);
        document.getElementById('pendiente').textContent = pendiente.toFixed(2);
        document.getElementById('progreso').textContent = progreso.toFixed(1);

        // Actualizar límite de cantidad recolectada
        if (cantidadInput) {
            cantidadInput.max = pendiente.toFixed(3);
            cantidadInput.placeholder = `Máximo ${pendiente.toFixed(2)} kg`;
        }

        // Actualizar barra de progreso
        const barraProgreso = document.getElementById('barraProgreso');
        barraProgreso.style.width = progreso + '%';

        // Cambiar color según progreso
        if (progreso >= 90) {
            barraProgreso.style.background = 'linear-gradient(90deg, #dc3545, #c82333)';
        } else if (progreso >= 70) {
            barraProgreso.style.background = 'linear-gradient(90deg, #ffc107, #e0a800)';
        } else {
            barraProgreso.style.background = 'linear-gradient(90deg, #28a745, #20c997)';
        }

        // Mostrar panel
        infoPanel.classList.remove('d-none');
    } else {
        // Ocultar panel
        infoPanel.classList.add('d-none');

        // Resetear límite de cantidad
        if (cantidadInput) {
            cantidadInput.max = '';
            cantidadInput.placeholder = 'Cantidad en kilogramos';
        }
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const produccionSelect = document.getElementById('produccion_id');

    // Actualizar info al cambiar selección
    produccionSelect.addEventListener('change', actualizarInfoProduccion);

    // Actualizar info si hay una producción preseleccionada
    if (produccionSelect.value) {
        actualizarInfoProduccion();
    }

    // Validación de horas
    const horaInicio = document.getElementById('hora_inicio');
    const horaFin = document.getElementById('hora_fin');

    function validarHoras() {
        if (horaInicio.value && horaFin.value) {
            if (horaFin.value <= horaInicio.value) {
                horaFin.setCustomValidity('La hora de fin debe ser posterior a la hora de inicio');
            } else {
                horaFin.setCustomValidity('');
            }
        }
    }

    horaInicio.addEventListener('change', validarHoras);
    horaFin.addEventListener('change', validarHoras);

    // Validación de cantidad recolectada
    const cantidadInput = document.getElementById('cantidad_recolectada');
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function() {
            const valor = parseFloat(this.value);
            const max = parseFloat(this.max);

            if (this.value && valor <= 0) {
                this.setCustomValidity('La cantidad debe ser mayor a 0');
            } else if (this.value && max && valor > max) {
                this.setCustomValidity(`La cantidad no puede ser mayor a ${max} kg (cantidad pendiente)`);
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Validación del formulario
    document.getElementById('recoleccionForm').addEventListener('submit', function(e) {
        const trabajadores = document.getElementById('trabajadores_participantes');
        if (trabajadores.selectedOptions.length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un trabajador participante');
            trabajadores.focus();
            return false;
        }

        // Validar cantidad recolectada
        const cantidad = document.getElementById('cantidad_recolectada');
        if (cantidad && cantidad.value) {
            const valor = parseFloat(cantidad.value);
            if (valor <= 0) {
                e.preventDefault();
                alert('La cantidad recolectada debe ser mayor a 0');
                cantidad.focus();
                return false;
            }
        }
    });
});
</script>
@endsection
