
@extends('layouts.masterr')

@section('content')

{{-- CSS externo específico para edit --}}
<link rel="stylesheet" href="{{ asset('css/recoleccion/edit.css') }}">

@push('scripts')
<script>
    // Configuración para JavaScript
    window.editConfig = {
        recoleccionId: {{ $recoleccion->id }},
        indexUrl: '{{ route('recolecciones.index') }}',
        showUrl: '{{ url('recolecciones/' . $recoleccion->id) }}'
    };
</script>
<script src="{{ asset('js/recolecciones/edit.js') }}"></script>
@endpush
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title"><i class="fas fa-edit me-2 accent-icon"></i> Editar Recolección #{{ $recoleccion->id }}</h4>
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
                                <strong><i class="fas fa-calendar me-1 accent-icon"></i> Fecha Original:</strong><br>
                                <span class="badge bg-primary">{{ $recoleccion->fecha_recoleccion ? $recoleccion->fecha_recoleccion->format('d/m/Y') : 'Sin fecha' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong><i class="fas fa-weight-hanging me-1 accent-icon"></i> Cantidad Actual:</strong><br>
                                <span class="badge bg-success">{{ number_format($recoleccion->cantidad_recolectada, 2) }} kg</span>
                            </div>
                            <div class="col-md-3">
                                <strong><i class="fas fa-seedling me-1 accent-icon"></i> Lote:</strong><br>
                                <span class="badge bg-info">{{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong><i class="fas fa-leaf me-1 accent-icon"></i> Estado:</strong><br>
                                @if($recoleccion->estado_fruto == 'maduro')
                                    <span class="badge badge-maduro">
                                        {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                    </span>
                                @elseif($recoleccion->estado_fruto == 'semi-maduro')
                                    <span class="badge badge-semi-maduro">
                                        {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                    </span>
                                @else
                                    <span class="badge badge-verde">
                                        {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                    </span>
                                @endif
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
                                        <h6 class="mb-0 section-header"><i class="fas fa-info-circle me-1 accent-icon"></i> Información Básica</h6>
                                    </div>
                                    <div class="card-body">
                                        {{-- Producción/Lote --}}
                                        <div class="mb-3">
                                            <label for="produccion_id" class="form-label fw-bold">
                                                <i class="fas fa-seedling me-1 accent-icon"></i> Producción/Lote
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
                                                <i class="fas fa-calendar me-1 accent-icon"></i> Fecha de Recolección
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
                                                <i class="fas fa-weight-hanging me-1 accent-icon"></i> Cantidad Recolectada
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
                                                    <i class="fas fa-clock me-1 accent-icon"></i> Hora Inicio
                                                </label>
                                                <input type="time" name="hora_inicio" id="hora_inicio" 
                                                       class="form-control" value="{{ $recoleccion->hora_inicio }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="hora_fin" class="form-label fw-bold">
                                                    <i class="fas fa-clock me-1 accent-icon"></i> Hora Fin
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
                                        <h6 class="mb-0 section-header"><i class="fas fa-star me-1 accent-icon"></i> Calidad y Condiciones</h6>
                                    </div>
                                    <div class="card-body">
                                        {{-- Estado del fruto --}}
                                        <div class="mb-3">
                                            <label for="estado_fruto" class="form-label fw-bold">
                                                <i class="fas fa-apple-alt me-1 accent-icon"></i> Estado del Fruto
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
                                                <i class="fas fa-cloud me-1 accent-icon"></i> Condiciones Climáticas
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
                                                <i class="fas fa-star me-1 accent-icon"></i> Calidad Promedio
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
                                                <i class="fas fa-users me-1 accent-icon"></i> Trabajadores Participantes
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
                                <h6 class="mb-0 section-header"><i class="fas fa-comment-alt me-1 accent-icon"></i> Observaciones Adicionales</h6>
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
@endsection
