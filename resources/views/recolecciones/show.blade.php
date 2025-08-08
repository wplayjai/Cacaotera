@extends('layouts.masterr')

@section('content')
<style>
/* Variables de colores café */
:root {
    --cacao-dark: #4a3728;
    --cacao-medium: #6b4e3d;
    --cacao-light: #8b6f47;
    --cacao-accent: #a0845c;
    --cacao-cream: #f5f3f0;
    --cacao-sand: #d4c4a0;
}

/* Estilos generales de tarjetas */
.card {
    border: none !important;
    box-shadow: 0 4px 8px rgba(74, 55, 40, 0.15) !important;
    border-radius: 12px !important;
}

.card-header {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    border-bottom: 2px solid var(--cacao-accent) !important;
    border-radius: 12px 12px 0 0 !important;
}

.card-header h4, .card-header h5 {
    color: var(--cacao-dark) !important;
    font-weight: 600 !important;
}

.card-header i {
    color: var(--cacao-accent) !important;
}

/* Botones con estilo café */
.btn-primary {
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
    border: none !important;
    color: white !important;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)) !important;
    transform: translateY(-1px) !important;
}

.btn-secondary {
    background: linear-gradient(135deg, var(--cacao-light), var(--cacao-accent)) !important;
    border: none !important;
    color: white !important;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-sand)) !important;
    color: var(--cacao-dark) !important;
}

.btn-info {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-sand)) !important;
    border: none !important;
    color: var(--cacao-dark) !important;
}

.btn-info:hover {
    background: linear-gradient(135deg, var(--cacao-sand), var(--cacao-cream)) !important;
}

.btn-success {
    background: linear-gradient(135deg, #27ae60, #2ecc71) !important;
    border: none !important;
}

.btn-success:hover {
    background: linear-gradient(135deg, #2ecc71, #58d68d) !important;
}

/* Badges con estilo café */
.badge.bg-primary {
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
}

.badge.bg-success {
    background: linear-gradient(135deg, #27ae60, #2ecc71) !important;
}

.badge.bg-info {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-sand)) !important;
    color: var(--cacao-dark) !important;
}

.badge.bg-warning {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-cream)) !important;
    color: var(--cacao-dark) !important;
}

.badge.bg-danger {
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
}

.badge.bg-secondary {
    background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)) !important;
}

.badge.bg-light {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    color: var(--cacao-dark) !important;
}

/* Alertas con estilo café */
.alert-info {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    border: 1px solid var(--cacao-accent) !important;
    color: var(--cacao-dark) !important;
}

.alert-warning {
    background: linear-gradient(135deg, #fff8e1, #ffecb3) !important;
    border: 1px solid var(--cacao-accent) !important;
    color: var(--cacao-dark) !important;
}

/* Estrellas de calidad */
.text-warning {
    color: var(--cacao-accent) !important;
}

/* Barra de progreso */
.progress-bar.bg-primary {
    background: linear-gradient(90deg, var(--cacao-dark), var(--cacao-accent)) !important;
}

.progress-bar.bg-success {
    background: linear-gradient(90deg, #27ae60, #2ecc71) !important;
}

/* Texto con colores café */
.text-muted {
    color: var(--cacao-medium) !important;
}

.text-info {
    color: var(--cacao-accent) !important;
}

.text-primary {
    color: var(--cacao-dark) !important;
}

/* Estilos adicionales para métricas */
.col-md-3 h4 {
    font-weight: bold !important;
}

.col-md-3 h4.text-info {
    color: var(--cacao-accent) !important;
}

.col-md-3 h4.text-success {
    color: #27ae60 !important;
}

.col-md-3 h4.text-warning {
    color: var(--cacao-light) !important;
}

.col-md-3 h4.text-primary {
    color: var(--cacao-dark) !important;
}

/* Estilo para la tabla */
.table-borderless td {
    border: none !important;
    padding: 0.75rem 0.5rem !important;
}

.table-borderless td strong {
    color: var(--cacao-dark) !important;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 style="color: var(--cacao-dark);"><i class="fas fa-clipboard-list" style="color: var(--cacao-accent);"></i> Detalles de Recolección #{{ $recoleccion->id ?? 'N/A' }}</h4>
                    {{-- Debug info --}}
                    @if(request()->has('debug'))
                        <small class="text-muted">
                            [Fecha: {{ $recoleccion->fecha_recoleccion ? 'OK' : 'NULL' }} | 
                            Prod: {{ $recoleccion->produccion ? 'OK' : 'NULL' }} | 
                            Lote: {{ $recoleccion->produccion && $recoleccion->produccion->lote ? 'OK' : 'NULL' }}]
                        </small>
                    @endif
                    <div>
                       
                        <a href="{{ route('recolecciones.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        {{-- Información general --}}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 style="color: var(--cacao-dark);"><i class="fas fa-info-circle" style="color: var(--cacao-accent);"></i> Información General</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Fecha de Recolección:</strong></td>
                                            <td>
                                                @if($recoleccion->fecha_recoleccion)
                                                    <span class="badge bg-primary">
                                                        {{ $recoleccion->fecha_recoleccion->format('d/m/Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Sin fecha registrada</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Lote:</strong></td>
                                            <td>
                                                @if($recoleccion->produccion && $recoleccion->produccion->lote)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-seedling me-1"></i>
                                                        {{ $recoleccion->produccion->lote->nombre }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Sin lote asignado</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tipo de Cacao:</strong></td>
                                            <td>
                                                @if($recoleccion->produccion && $recoleccion->produccion->tipo_cacao)
                                                    <span class="badge bg-info">
                                                        {{ ucfirst($recoleccion->produccion->tipo_cacao) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Tipo no especificado</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cantidad Recolectada:</strong></td>
                                            <td>
                                                <span class="badge bg-success fs-6">
                                                    <i class="fas fa-weight-hanging me-1"></i>
                                                    {{ number_format($recoleccion->cantidad_recolectada ?? 0, 2) }} kg
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Estado del Fruto:</strong></td>
                                            <td>
                                                @if($recoleccion->estado_fruto)
                                                    @switch($recoleccion->estado_fruto)
                                                        @case('maduro')
                                                            <span class="badge fs-6" style="background: linear-gradient(135deg, #27ae60, #2ecc71); color: white;">
                                                                <i class="fas fa-check-circle me-1"></i>Maduro
                                                            </span>
                                                            @break
                                                        @case('semi-maduro')
                                                            <span class="badge fs-6" style="background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-cream)); color: var(--cacao-dark);">
                                                                <i class="fas fa-clock me-1"></i>Semi-maduro
                                                            </span>
                                                            @break
                                                        @case('verde')
                                                            <span class="badge fs-6" style="background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)); color: white;">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>Verde
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="badge fs-6" style="background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)); color: white;">
                                                                {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                                            </span>
                                                    @endswitch
                                                @else
                                                    <span class="text-muted">Estado no registrado</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Condiciones Climáticas:</strong></td>
                                            <td>
                                                @if($recoleccion->condiciones_climaticas)
                                                    @switch($recoleccion->condiciones_climaticas)
                                                        @case('soleado')
                                                            <span class="badge" style="background: linear-gradient(135deg, #f39c12, #f1c40f); color: #333;">
                                                                <i class="fas fa-sun me-1"></i>Soleado
                                                            </span>
                                                            @break
                                                        @case('nublado')
                                                            <span class="badge" style="background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)); color: white;">
                                                                <i class="fas fa-cloud me-1"></i>Nublado
                                                            </span>
                                                            @break
                                                        @case('lluvioso')
                                                            <span class="badge" style="background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)); color: white;">
                                                                <i class="fas fa-cloud-rain me-1"></i>Lluvioso
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="badge" style="background: linear-gradient(135deg, var(--cacao-cream), white); color: var(--cacao-dark);">
                                                                {{ ucfirst($recoleccion->condiciones_climaticas) }}
                                                            </span>
                                                    @endswitch
                                                @else
                                                    <span class="text-muted">Condiciones no registradas</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($recoleccion->hora_inicio || $recoleccion->hora_fin)
                                        <tr>
                                            <td><strong>Horario:</strong></td>
                                            <td>
                                                @if($recoleccion->hora_inicio)
                                                    {{ date('H:i', strtotime($recoleccion->hora_inicio)) }}
                                                @endif
                                                @if($recoleccion->hora_inicio && $recoleccion->hora_fin)
                                                    -
                                                @endif
                                                @if($recoleccion->hora_fin)
                                                    {{ date('H:i', strtotime($recoleccion->hora_fin)) }}
                                                @endif
                                                @if($recoleccion->hora_inicio && $recoleccion->hora_fin)
                                                    <br><small class="text-muted">
                                                        ({{ \Carbon\Carbon::parse($recoleccion->hora_inicio)->diffInHours(\Carbon\Carbon::parse($recoleccion->hora_fin)) }} horas)
                                                    </small>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Calidad y trabajadores --}}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 style="color: var(--cacao-dark);"><i class="fas fa-users" style="color: var(--cacao-accent);"></i> Calidad y Trabajadores</h5>
                                </div>
                                <div class="card-body">
                                    @if($recoleccion->calidad_promedio)
                                        <div class="mb-3">
                                            <strong>Calidad Promedio:</strong><br>
                                            <div class="text-center my-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star fa-lg" style="color: {{ $i <= $recoleccion->calidad_promedio ? 'var(--cacao-accent)' : 'rgba(139, 111, 71, 0.3)' }};"></i>
                                                @endfor
                                            </div>
                                            <div class="text-center">
                                                <span class="badge bg-primary">{{ $recoleccion->calidad_promedio }}/5</span>
                                                @switch($recoleccion->calidad_promedio)
                                                    @case(1)
                                                        <span style="color: var(--cacao-dark); font-weight: bold;">Muy Baja</span>
                                                        @break
                                                    @case(2)
                                                        <span style="color: var(--cacao-medium); font-weight: bold;">Baja</span>
                                                        @break
                                                    @case(3)
                                                        <span style="color: var(--cacao-light); font-weight: bold;">Regular</span>
                                                        @break
                                                    @case(4)
                                                        <span style="color: var(--cacao-accent); font-weight: bold;">Buena</span>
                                                        @break
                                                    @case(5)
                                                        <span style="color: #27ae60; font-weight: bold;">Excelente</span>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Trabajadores Participantes:</strong>
                                        @if($recoleccion->trabajadores_participantes && is_array($recoleccion->trabajadores_participantes) && count($recoleccion->trabajadores_participantes) > 0)
                                            <div class="mt-2">
                                                @php
                                                    $trabajadoresEncontrados = 0;
                                                @endphp
                                                @foreach($recoleccion->trabajadores_participantes as $trabajadorId)
                                                    @php
                                                        $trabajador = \App\Models\Trabajador::find($trabajadorId);
                                                    @endphp
                                                    @if($trabajador && $trabajador->activo)
                                                        @php $trabajadoresEncontrados++; @endphp
                                                        <span class="badge bg-secondary me-1 mb-1 fs-6">
                                                            <i class="fas fa-user me-1"></i>{{ $trabajador->nombre_completo }}
                                                        </span>
                                                    @elseif($trabajador)
                                                        @php $trabajadoresEncontrados++; @endphp
                                                        <span class="badge bg-warning text-dark me-1 mb-1 fs-6" title="Trabajador inactivo">
                                                            <i class="fas fa-user-slash me-1"></i>{{ $trabajador->nombre_completo }} (Inactivo)
                                                        </span>
                                                    @endif
                                                @endforeach
                                                
                                                @if($trabajadoresEncontrados == 0)
                                                    <div class="alert alert-warning mt-2">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Los trabajadores registrados ya no están disponibles en el sistema.
                                                    </div>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Total registrados: {{ count($recoleccion->trabajadores_participantes) }} | 
                                                Activos encontrados: {{ $trabajadoresEncontrados }}
                                            </small>
                                        @else
                                            <div class="alert alert-info mt-2">
                                                <i class="fas fa-users me-1"></i>No hay trabajadores registrados para esta recolección
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    @if($recoleccion->observaciones)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 style="color: var(--cacao-dark);"><i class="fas fa-comment" style="color: var(--cacao-accent);"></i> Observaciones</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $recoleccion->observaciones }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Información del lote/producción --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 style="color: var(--cacao-dark);"><i class="fas fa-seedling" style="color: var(--cacao-accent);"></i> Estado del Lote</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-info">{{ $recoleccion->produccion ? number_format($recoleccion->produccion->estimacion_produccion, 2) : '0.00' }} kg</h4>
                                                <small class="text-muted">Estimación Total</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-success">{{ $recoleccion->produccion ? number_format($recoleccion->produccion->total_recolectado, 2) : '0.00' }} kg</h4>
                                                <small class="text-muted">Total Recolectado</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-warning">{{ $recoleccion->produccion ? number_format($recoleccion->produccion->cantidad_pendiente_recoleccion, 2) : '0.00' }} kg</h4>
                                                <small class="text-muted">Pendiente</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-primary">{{ $recoleccion->produccion ? number_format($recoleccion->produccion->porcentaje_recoleccion_completado, 1) : '0.0' }}%</h4>
                                                <small class="text-muted">Completado</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="progress mt-3" style="height: 20px;">
                                        <div class="progress-bar {{ ($recoleccion->produccion && $recoleccion->produccion->porcentaje_recoleccion_completado >= 100) ? 'bg-success' : 'bg-primary' }}" 
                                             role="progressbar" 
                                             style="width: {{ $recoleccion->produccion ? min(100, $recoleccion->produccion->porcentaje_recoleccion_completado) : 0 }}%;">
                                            {{ $recoleccion->produccion ? number_format($recoleccion->produccion->porcentaje_recoleccion_completado, 1) : '0.0' }}%
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 text-center">
                                        @if($recoleccion->produccion && $recoleccion->produccion->estado == 'completado')
                                            <span class="badge fs-6" style="background: linear-gradient(135deg, #27ae60, #2ecc71); color: white;">
                                                {{ $recoleccion->produccion ? ucfirst($recoleccion->produccion->estado) : 'Sin estado' }}
                                            </span>
                                        @else
                                            <span class="badge fs-6" style="background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-cream)); color: var(--cacao-dark);">
                                                {{ $recoleccion->produccion ? ucfirst($recoleccion->produccion->estado) : 'Sin estado' }}
                                            </span>
                                        @endif
                                        
                                        @if($recoleccion->produccion && $recoleccion->produccion->porcentaje_recoleccion_completado >= 100)
                                            <div class="mt-2">
                                                <span class="badge" style="background: linear-gradient(135deg, #27ae60, #2ecc71); color: white;">
                                                    <i class="fas fa-check-circle"></i> Recolección Completada
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            @if($recoleccion->produccion)
                                <a href="{{ route('produccion.show', $recoleccion->produccion->id) }}" class="btn btn-info">
                                    <i class="fas fa-seedling"></i> Ver Producción Completa
                                </a>
                                @if($recoleccion->produccion->porcentaje_recoleccion_completado < 100)
                                    <a href="{{ route('recolecciones.create_for_produccion', $recoleccion->produccion->id) }}" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Nueva Recolección de este Lote
                                    </a>
                                @endif
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> No se encontró información de producción asociada
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
