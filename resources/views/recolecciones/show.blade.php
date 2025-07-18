@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-clipboard-list"></i> Detalles de Recolección #{{ $recoleccion->id }}</h4>
                    <div>
                        <a href="{{ route('recolecciones.edit', $recoleccion->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
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
                                            <td>{{ $recoleccion->fecha_recoleccion->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Lote:</strong></td>
                                            <td>{{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tipo de Cacao:</strong></td>
                                            <td>{{ $recoleccion->produccion->tipo_cacao }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cantidad Recolectada:</strong></td>
                                            <td><span class="badge badge-success badge-lg">{{ number_format($recoleccion->cantidad_recolectada, 2) }} kg</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Estado del Fruto:</strong></td>
                                            <td>
                                                <span class="badge badge-{{ $recoleccion->estado_fruto == 'maduro' ? 'success' : 
                                                    ($recoleccion->estado_fruto == 'semi-maduro' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst(str_replace('-', ' ', $recoleccion->estado_fruto)) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Condiciones Climáticas:</strong></td>
                                            <td>
                                                @switch($recoleccion->condiciones_climaticas)
                                                    @case('soleado')
                                                        <i class="fas fa-sun text-warning"></i> Soleado
                                                        @break
                                                    @case('nublado')
                                                        <i class="fas fa-cloud text-secondary"></i> Nublado
                                                        @break
                                                    @case('lluvioso')
                                                        <i class="fas fa-cloud-rain text-primary"></i> Lluvioso
                                                        @break
                                                @endswitch
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
                                                <span class="badge badge-primary">{{ $recoleccion->calidad_promedio }}/5</span>
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
                                        @if($recoleccion->trabajadores_participantes && is_array($recoleccion->trabajadores_participantes))
                                            <div class="mt-2">
                                                @foreach($recoleccion->trabajadores_participantes as $trabajadorId)
                                                    @php
                                                        $trabajador = \App\Models\Trabajador::find($trabajadorId);
                                                    @endphp
                                                    @if($trabajador)
                                                        <span class="badge badge-secondary mr-1 mb-1">
                                                            <i class="fas fa-user"></i> {{ $trabajador->nombre_completo }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <small class="text-muted">Total: {{ count($recoleccion->trabajadores_participantes) }} trabajador(es)</small>
                                        @else
                                            <p class="text-muted">Sin trabajadores registrados</p>
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
                                                <h4 class="text-info">{{ number_format($recoleccion->produccion->estimacion_produccion, 2) }} kg</h4>
                                                <small class="text-muted">Estimación Total</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-success">{{ number_format($recoleccion->produccion->total_recolectado, 2) }} kg</h4>
                                                <small class="text-muted">Total Recolectado</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-warning">{{ number_format($recoleccion->produccion->cantidad_pendiente_recoleccion, 2) }} kg</h4>
                                                <small class="text-muted">Pendiente</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-primary">{{ number_format($recoleccion->produccion->porcentaje_recoleccion_completado, 1) }}%</h4>
                                                <small class="text-muted">Completado</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="progress mt-3" style="height: 20px;">
                                        <div class="progress-bar {{ $recoleccion->produccion->porcentaje_recoleccion_completado >= 100 ? 'bg-success' : 'bg-primary' }}" 
                                             role="progressbar" 
                                             style="width: {{ min(100, $recoleccion->produccion->porcentaje_recoleccion_completado) }}%;">
                                            {{ number_format($recoleccion->produccion->porcentaje_recoleccion_completado, 1) }}%
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 text-center">
                                        <span class="badge badge-{{ $recoleccion->produccion->estado == 'completado' ? 'success' : 'warning' }} badge-lg">
                                            {{ ucfirst($recoleccion->produccion->estado) }}
                                        </span>
                                        
                                        @if($recoleccion->produccion->porcentaje_recoleccion_completado >= 100)
                                            <div class="mt-2">
                                                <span class="badge badge-success">
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
                            <a href="{{ route('produccion.show', $recoleccion->produccion->id) }}" class="btn btn-info">
                                <i class="fas fa-seedling"></i> Ver Producción Completa
                            </a>
                            @if($recoleccion->produccion->porcentaje_recoleccion_completado < 100)
                                <a href="{{ route('recolecciones.create', ['produccion' => $recoleccion->produccion->id]) }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Nueva Recolección de este Lote
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
