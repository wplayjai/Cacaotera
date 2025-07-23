@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-clipboard-list"></i> Detalles de Recolección #{{ $recoleccion->id ?? 'N/A' }}</h4>
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
                                    <h5><i class="fas fa-info-circle"></i> Información General</h5>
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
                                                    <span class="badge bg-{{ $recoleccion->estado_fruto == 'maduro' ? 'success' : 
                                                        ($recoleccion->estado_fruto == 'semi-maduro' ? 'warning' : 'danger') }} fs-6">
                                                        @switch($recoleccion->estado_fruto)
                                                            @case('maduro')
                                                                <i class="fas fa-check-circle me-1"></i>Maduro
                                                                @break
                                                            @case('semi-maduro')
                                                                <i class="fas fa-clock me-1"></i>Semi-maduro
                                                                @break
                                                            @case('verde')
                                                                <i class="fas fa-exclamation-triangle me-1"></i>Verde
                                                                @break
                                                            @default
                                                                {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                                        @endswitch
                                                    </span>
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
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="fas fa-sun me-1"></i>Soleado
                                                            </span>
                                                            @break
                                                        @case('nublado')
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-cloud me-1"></i>Nublado
                                                            </span>
                                                            @break
                                                        @case('lluvioso')
                                                            <span class="badge bg-primary">
                                                                <i class="fas fa-cloud-rain me-1"></i>Lluvioso
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-light text-dark">
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
                                    <h5><i class="fas fa-users"></i> Calidad y Trabajadores</h5>
                                </div>
                                <div class="card-body">
                                    @if($recoleccion->calidad_promedio)
                                        <div class="mb-3">
                                            <strong>Calidad Promedio:</strong><br>
                                            <div class="text-center my-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star fa-lg {{ $i <= $recoleccion->calidad_promedio ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <div class="text-center">
                                                <span class="badge bg-primary">{{ $recoleccion->calidad_promedio }}/5</span>
                                                @switch($recoleccion->calidad_promedio)
                                                    @case(1)
                                                        <span class="text-danger">Muy Baja</span>
                                                        @break
                                                    @case(2)
                                                        <span class="text-warning">Baja</span>
                                                        @break
                                                    @case(3)
                                                        <span class="text-info">Regular</span>
                                                        @break
                                                    @case(4)
                                                        <span class="text-primary">Buena</span>
                                                        @break
                                                    @case(5)
                                                        <span class="text-success">Excelente</span>
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
                                        <h5><i class="fas fa-comment"></i> Observaciones</h5>
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
                                    <h5><i class="fas fa-seedling"></i> Estado del Lote</h5>
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
                                        <span class="badge bg-{{ ($recoleccion->produccion && $recoleccion->produccion->estado == 'completado') ? 'success' : 'warning' }} fs-6">
                                            {{ $recoleccion->produccion ? ucfirst($recoleccion->produccion->estado) : 'Sin estado' }}
                                        </span>
                                        
                                        @if($recoleccion->produccion && $recoleccion->produccion->porcentaje_recoleccion_completado >= 100)
                                            <div class="mt-2">
                                                <span class="badge bg-success">
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
