
@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-edit me-2"></i> Editar Recolección #{{ $recoleccion->id }}</h4>
                    <div>
                        <a href="{{ url('recolecciones/' . $recoleccion->id) }}" class="btn btn-outline-dark">
                            <i class="fas fa-eye me-1"></i> Ver Detalles
                        </a>
                        <a href="{{ route('recolecciones.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    {{-- Información actual --}}
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <strong><i class="fas fa-calendar me-1"></i> Fecha Original:</strong><br>
                                <span class="badge bg-primary">{{ $recoleccion->fecha_recoleccion ? $recoleccion->fecha_recoleccion->format('d/m/Y') : 'Sin fecha' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong><i class="fas fa-weight-hanging me-1"></i> Cantidad Actual:</strong><br>
                                <span class="badge bg-success">{{ number_format($recoleccion->cantidad_recolectada, 2) }} kg</span>
                            </div>
                            <div class="col-md-3">
                                <strong><i class="fas fa-seedling me-1"></i> Lote:</strong><br>
                                <span class="badge bg-info">{{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong><i class="fas fa-leaf me-1"></i> Estado:</strong><br>
                                <span class="badge bg-{{ $recoleccion->estado_fruto == 'maduro' ? 'success' : ($recoleccion->estado_fruto == 'semi-maduro' ? 'warning' : 'danger') }}">
                                    {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle me-1"></i> Errores encontrados:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('recolecciones/' . $recoleccion->id) }}" id="editForm" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Columna izquierda --}}
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-info-circle me-1"></i> Información Básica</h6>
                                    </div>
                                    <div class="card-body">
                                        {{-- Producción/Lote --}}
                                        <div class="mb-3">
                                            <label for="produccion_id" class="form-label fw-bold">
                                                <i class="fas fa-seedling text-success me-1"></i> Producción/Lote
                                            </label>
                                            <select name="produccion_id" id="produccion_id" class="form-select" required>
                                                @foreach($producciones as $produccion)
                                                    <option value="{{ $produccion->id }}" {{ $recoleccion->produccion_id == $produccion->id ? 'selected' : '' }}>
                                                        🌱 {{ $produccion->lote?->nombre ?? 'Sin lote' }} | 🍫 {{ ucfirst($produccion->tipo_cacao) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor selecciona una producción.
                                            </div>
                                        </div>

                                        {{-- Fecha --}}
                                        <div class="mb-3">
                                            <label for="fecha_recoleccion" class="form-label fw-bold">
                                                <i class="fas fa-calendar text-primary me-1"></i> Fecha de Recolección
                                            </label>
                                            <input type="date" name="fecha_recoleccion" id="fecha_recoleccion" 
                                                   class="form-control" 
                                                   value="{{ $recoleccion->fecha_recoleccion ? $recoleccion->fecha_recoleccion->format('Y-m-d') : '' }}" 
                                                   required>
                                            <div class="invalid-feedback">
                                                La fecha de recolección es obligatoria.
                                            </div>
                                        </div>

                                        {{-- Cantidad --}}
                                        <div class="mb-3">
                                            <label for="cantidad_recolectada" class="form-label fw-bold">
                                                <i class="fas fa-weight-hanging text-success me-1"></i> Cantidad Recolectada
                                            </label>
                                            <div class="input-group">
                                                <input type="number" name="cantidad_recolectada" id="cantidad_recolectada" 
                                                       class="form-control" step="0.001" min="0.001" max="9999.999" 
                                                       value="{{ $recoleccion->cantidad_recolectada }}" required>
                                                <span class="input-group-text">kg</span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Ingresa una cantidad válida entre 0.001 y 9999.999 kg.
                                            </div>
                                        </div>

                                        {{-- Horarios --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="hora_inicio" class="form-label fw-bold">
                                                    <i class="fas fa-clock text-info me-1"></i> Hora Inicio
                                                </label>
                                                <input type="time" name="hora_inicio" id="hora_inicio" 
                                                       class="form-control" value="{{ $recoleccion->hora_inicio }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hora_fin" class="form-label fw-bold">
                                                    <i class="fas fa-clock text-warning me-1"></i> Hora Fin
                                                </label>
                                                <input type="time" name="hora_fin" id="hora_fin" 
                                                       class="form-control" value="{{ $recoleccion->hora_fin }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Columna derecha --}}
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-star me-1"></i> Calidad y Condiciones</h6>
                                    </div>
                                    <div class="card-body">
                                        {{-- Estado del fruto --}}
                                        <div class="mb-3">
                                            <label for="estado_fruto" class="form-label fw-bold">
                                                <i class="fas fa-apple-alt text-danger me-1"></i> Estado del Fruto
                                            </label>
                                            <select name="estado_fruto" id="estado_fruto" class="form-select" required>
                                                <option value="maduro" {{ $recoleccion->estado_fruto == 'maduro' ? 'selected' : '' }}>
                                                    🟢 Maduro
                                                </option>
                                                <option value="semi-maduro" {{ $recoleccion->estado_fruto == 'semi-maduro' ? 'selected' : '' }}>
                                                    🟡 Semi-maduro
                                                </option>
                                                <option value="verde" {{ $recoleccion->estado_fruto == 'verde' ? 'selected' : '' }}>
                                                    🔴 Verde
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Selecciona el estado del fruto.
                                            </div>
                                        </div>

                                        {{-- Condiciones climáticas --}}
                                        <div class="mb-3">
                                            <label for="condiciones_climaticas" class="form-label fw-bold">
                                                <i class="fas fa-cloud text-secondary me-1"></i> Condiciones Climáticas
                                            </label>
                                            <select name="condiciones_climaticas" id="condiciones_climaticas" class="form-select" required>
                                                <option value="soleado" {{ $recoleccion->condiciones_climaticas == 'soleado' ? 'selected' : '' }}>
                                                    ☀️ Soleado
                                                </option>
                                                <option value="nublado" {{ $recoleccion->condiciones_climaticas == 'nublado' ? 'selected' : '' }}>
                                                    ☁️ Nublado
                                                </option>
                                                <option value="lluvioso" {{ $recoleccion->condiciones_climaticas == 'lluvioso' ? 'selected' : '' }}>
                                                    🌧️ Lluvioso
                                                </option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Selecciona las condiciones climáticas.
                                            </div>
                                        </div>

                                        {{-- Calidad --}}
                                        <div class="mb-3">
                                            <label for="calidad_promedio" class="form-label fw-bold">
                                                <i class="fas fa-star text-warning me-1"></i> Calidad Promedio
                                            </label>
                                            <select name="calidad_promedio" id="calidad_promedio" class="form-select">
                                                <option value="">🚫 Sin calificar</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ $recoleccion->calidad_promedio == $i ? 'selected' : '' }}>
                                                        {{ str_repeat('⭐', $i) }} {{ $i }} de 5
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        {{-- Trabajadores --}}
                                        <div class="mb-3">
                                            <label for="trabajadores_participantes" class="form-label fw-bold">
                                                <i class="fas fa-users text-primary me-1"></i> Trabajadores Participantes
                                            </label>
                                            <select name="trabajadores_participantes[]" id="trabajadores_participantes" 
                                                    class="form-select" multiple required size="4">
                                                @foreach($trabajadores as $trabajador)
                                                    <option value="{{ $trabajador->id }}" 
                                                            {{ in_array($trabajador->id, (array)$recoleccion->trabajadores_participantes) ? 'selected' : '' }}>
                                                        👤 {{ $trabajador->nombre_completo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Mantén <kbd>Ctrl</kbd> presionado para seleccionar múltiples trabajadores
                                            </small>
                                            <div class="invalid-feedback">
                                                Selecciona al menos un trabajador.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Observaciones --}}
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-comment-alt me-1"></i> Observaciones Adicionales</h6>
                            </div>
                            <div class="card-body">
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="3" 
                                          placeholder="Escribe aquí cualquier observación adicional sobre esta recolección...">{{ $recoleccion->observaciones }}</textarea>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Campo opcional. Puedes agregar notas sobre condiciones especiales, problemas encontrados, etc.
                                </small>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Última modificación: {{ $recoleccion->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                                    <i class="fas fa-undo me-1"></i> Restablecer
                                </button>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript para validación y UX mejorada --}}
<script>
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
                confirmButtonColor: '#dc3545'
            });
        } else {
            // Confirmar guardado
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: '¿Guardar cambios?',
                text: 'Se actualizará la información de esta recolección.',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
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
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
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
</script>

<style>
.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn {
    border-radius: 8px;
}

.badge {
    font-size: 0.8em;
}

kbd {
    background-color: #212529;
    color: #fff;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.8em;
}

.form-select[multiple] {
    background-image: none;
}

.alert {
    border-radius: 10px;
}
</style>
@endsection
