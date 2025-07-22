
@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-edit"></i> Editar Recolección #{{ $recoleccion->id }}</h4>
                    <a href="{{ route('recolecciones.show', ['recoleccione' => $recoleccion->id]) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('recolecciones.update', ['recoleccione' => $recoleccion->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="produccion_id" class="form-label">Producción/Lote</label>
                            <select name="produccion_id" id="produccion_id" class="form-select" required>
                                @foreach($producciones as $produccion)
                                    <option value="{{ $produccion->id }}" {{ $recoleccion->produccion_id == $produccion->id ? 'selected' : '' }}>
                                        Lote: {{ $produccion->lote?->nombre ?? 'Sin lote' }} | Cacao: {{ $produccion->tipo_cacao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_recoleccion" class="form-label">Fecha de Recolección</label>
                            <input type="date" name="fecha_recoleccion" id="fecha_recoleccion" class="form-control" value="{{ $recoleccion->fecha_recoleccion->format('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad_recolectada" class="form-label">Cantidad Recolectada (kg)</label>
                            <input type="number" name="cantidad_recolectada" id="cantidad_recolectada" class="form-control" step="0.001" min="0.001" max="9999.999" value="{{ $recoleccion->cantidad_recolectada }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="estado_fruto" class="form-label">Estado del Fruto</label>
                            <select name="estado_fruto" id="estado_fruto" class="form-select" required>
                                <option value="maduro" {{ $recoleccion->estado_fruto == 'maduro' ? 'selected' : '' }}>Maduro</option>
                                <option value="semi-maduro" {{ $recoleccion->estado_fruto == 'semi-maduro' ? 'selected' : '' }}>Semi-maduro</option>
                                <option value="verde" {{ $recoleccion->estado_fruto == 'verde' ? 'selected' : '' }}>Verde</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="condiciones_climaticas" class="form-label">Condiciones Climáticas</label>
                            <select name="condiciones_climaticas" id="condiciones_climaticas" class="form-select" required>
                                <option value="soleado" {{ $recoleccion->condiciones_climaticas == 'soleado' ? 'selected' : '' }}>Soleado</option>
                                <option value="nublado" {{ $recoleccion->condiciones_climaticas == 'nublado' ? 'selected' : '' }}>Nublado</option>
                                <option value="lluvioso" {{ $recoleccion->condiciones_climaticas == 'lluvioso' ? 'selected' : '' }}>Lluvioso</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="trabajadores_participantes" class="form-label">Trabajadores Participantes</label>
                            <select name="trabajadores_participantes[]" id="trabajadores_participantes" class="form-select" multiple required>
                                @foreach($trabajadores as $trabajador)
                                    <option value="{{ $trabajador->id }}" {{ in_array($trabajador->id, (array)$recoleccion->trabajadores_participantes) ? 'selected' : '' }}>
                                        {{ $trabajador->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Mantén Ctrl presionado para seleccionar múltiples trabajadores</small>
                        </div>

                        <div class="mb-3">
                            <label for="calidad_promedio" class="form-label">Calidad Promedio (1-5)</label>
                            <select name="calidad_promedio" id="calidad_promedio" class="form-select">
                                <option value="">Sin calificar</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $recoleccion->calidad_promedio == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hora_inicio" class="form-label">Hora Inicio</label>
                                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ $recoleccion->hora_inicio }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hora_fin" class="form-label">Hora Fin</label>
                                <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ $recoleccion->hora_fin }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" rows="2">{{ $recoleccion->observaciones }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
