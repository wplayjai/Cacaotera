@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-seedling"></i> Registrar Recolección Diaria</h4>
                    @if($produccionSeleccionada)
                        <p class="mb-0 text-muted">
                            <strong>Lote:</strong> {{ $produccionSeleccionada->lote?->nombre ?? 'Sin lote' }} - 
                            <strong>Tipo:</strong> {{ $produccionSeleccionada->tipo_cacao }}
                        </p>
                    @endif
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('recolecciones.store') }}" method="POST" id="recoleccionForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="produccion_id">Lote/Producción *</label>
                                    <select class="form-control" id="produccion_id" name="produccion_id" required>
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
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_recoleccion">Fecha de Recolección *</label>
                                    <input type="date" class="form-control" id="fecha_recoleccion" 
                                           name="fecha_recoleccion" value="{{ old('fecha_recoleccion', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cantidad_recolectada">Cantidad Recolectada (kg) *</label>
                                    <input type="number" class="form-control" id="cantidad_recolectada" 
                                           name="cantidad_recolectada" min="0.001" max="9999.999" step="0.001"
                                           value="{{ old('cantidad_recolectada') }}" required>
                                    <small class="form-text text-muted">Ingresa la cantidad en kilogramos</small>
                                </div>
                                
                                <!-- Panel de información de la producción -->
                                <div id="infoProduccion" class="alert alert-info d-none">
                                    <h6><i class="fas fa-info-circle"></i> Información del Lote</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small><strong>Estimado:</strong> <span id="estimacion">0</span> kg</small>
                                        </div>
                                        <div class="col-6">
                                            <small><strong>Ya recolectado:</strong> <span id="recolectado">0</span> kg</small>
                                        </div>
                                        <div class="col-6">
                                            <small><strong>Pendiente:</strong> <span id="pendiente">0</span> kg</small>
                                        </div>
                                        <div class="col-6">
                                            <small><strong>Progreso:</strong> <span id="progreso">0</span>%</small>
                                        </div>
                                    </div>
                                    <div class="progress mt-2" style="height: 10px;">
                                        <div class="progress-bar" id="barraProgreso" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado_fruto">Estado del Fruto *</label>
                                    <select class="form-control" id="estado_fruto" name="estado_fruto" required>
                                        <option value="">Selecciona el estado...</option>
                                        <option value="maduro" {{ old('estado_fruto') == 'maduro' ? 'selected' : '' }}>Maduro</option>
                                        <option value="semi-maduro" {{ old('estado_fruto') == 'semi-maduro' ? 'selected' : '' }}>Semi-maduro</option>
                                        <option value="verde" {{ old('estado_fruto') == 'verde' ? 'selected' : '' }}>Verde</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="condiciones_climaticas">Condiciones Climáticas *</label>
                                    <select class="form-control" id="condiciones_climaticas" name="condiciones_climaticas" required>
                                        <option value="">Selecciona condiciones...</option>
                                        <option value="soleado" {{ old('condiciones_climaticas') == 'soleado' ? 'selected' : '' }}>
                                            <i class="fas fa-sun"></i> Soleado
                                        </option>
                                        <option value="nublado" {{ old('condiciones_climaticas') == 'nublado' ? 'selected' : '' }}>
                                            <i class="fas fa-cloud"></i> Nublado
                                        </option>
                                        <option value="lluvioso" {{ old('condiciones_climaticas') == 'lluvioso' ? 'selected' : '' }}>
                                            <i class="fas fa-cloud-rain"></i> Lluvioso
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_inicio">Hora de Inicio</label>
                                    <input type="time" class="form-control" id="hora_inicio" 
                                           name="hora_inicio" value="{{ old('hora_inicio', '06:00') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora_fin">Hora de Fin</label>
                                    <input type="time" class="form-control" id="hora_fin" 
                                           name="hora_fin" value="{{ old('hora_fin') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="trabajadores_participantes">Trabajadores Participantes *</label>
                            <select class="form-control" id="trabajadores_participantes" 
                                    name="trabajadores_participantes[]" multiple required>
                                @foreach($trabajadores as $trabajador)
                                    <option value="{{ $trabajador->id }}" 
                                            {{ in_array($trabajador->id, old('trabajadores_participantes', [])) ? 'selected' : '' }}>
                                        {{ $trabajador->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Mantén Ctrl presionado para seleccionar múltiples trabajadores</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="calidad_promedio">Calidad Promedio (1-5)</label>
                                    <select class="form-control" id="calidad_promedio" name="calidad_promedio">
                                        <option value="">No evaluada</option>
                                        <option value="1" {{ old('calidad_promedio') == '1' ? 'selected' : '' }}>1 - Muy Baja</option>
                                        <option value="2" {{ old('calidad_promedio') == '2' ? 'selected' : '' }}>2 - Baja</option>
                                        <option value="3" {{ old('calidad_promedio') == '3' ? 'selected' : '' }}>3 - Regular</option>
                                        <option value="4" {{ old('calidad_promedio') == '4' ? 'selected' : '' }}>4 - Buena</option>
                                        <option value="5" {{ old('calidad_promedio') == '5' ? 'selected' : '' }}>5 - Excelente</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" 
                                      rows="3" placeholder="Notas adicionales sobre la recolección...">{{ old('observaciones') }}</textarea>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Registrar Recolección
                            </button>
                            <a href="{{ route('produccion.index') }}" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Actualizar información cuando cambia la producción seleccionada
    $('#produccion_id').on('change', function() {
        const option = $(this).find('option:selected');
        const estimacion = parseFloat(option.data('estimacion')) || 0;
        const recolectado = parseFloat(option.data('recolectado')) || 0;
        
        if (estimacion > 0) {
            const pendiente = Math.max(0, estimacion - recolectado);
            const progreso = Math.min(100, (recolectado / estimacion) * 100);
            
            $('#estimacion').text(estimacion.toFixed(2));
            $('#recolectado').text(recolectado.toFixed(2));
            $('#pendiente').text(pendiente.toFixed(2));
            $('#progreso').text(progreso.toFixed(1));
            $('#barraProgreso').css('width', progreso + '%');
            
            // Cambiar color de la barra según el progreso
            $('#barraProgreso').removeClass('bg-danger bg-warning bg-success')
                .addClass(progreso < 50 ? 'bg-danger' : progreso < 80 ? 'bg-warning' : 'bg-success');
            
            $('#infoProduccion').removeClass('d-none');
        } else {
            $('#infoProduccion').addClass('d-none');
        }
    });
    
    // Validar cantidad ingresada
    $('#cantidad_recolectada').on('input', function() {
        const option = $('#produccion_id').find('option:selected');
        const estimacion = parseFloat(option.data('estimacion')) || 0;
        const recolectado = parseFloat(option.data('recolectado')) || 0;
        const cantidad = parseFloat($(this).val()) || 0;
        
        if (estimacion > 0 && cantidad > 0) {
            const nuevoTotal = recolectado + cantidad;
            const porcentaje = (nuevoTotal / estimacion) * 100;
            
            if (porcentaje > 120) {
                $(this).addClass('is-invalid');
                if (!$(this).next('.invalid-feedback').length) {
                    $(this).after('<div class="invalid-feedback">Esta cantidad excede significativamente la estimación del lote.</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        }
    });
    
    // Trigger inicial si hay producción preseleccionada
    if ($('#produccion_id').val()) {
        $('#produccion_id').trigger('change');
    }
    
    // Validación de formulario
    $('#recoleccionForm').on('submit', function(e) {
        const trabajadores = $('#trabajadores_participantes').val();
        if (!trabajadores || trabajadores.length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un trabajador participante.');
            return false;
        }
        
        const horaInicio = $('#hora_inicio').val();
        const horaFin = $('#hora_fin').val();
        
        if (horaInicio && horaFin && horaFin <= horaInicio) {
            e.preventDefault();
            alert('La hora de fin debe ser posterior a la hora de inicio.');
            return false;
        }
    });
});
</script>
@endpush
