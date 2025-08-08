@extends('layouts.masterr')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/produccion/show.css') }}">
@endpush

@section('content')



<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">
                        <i class="fas fa-seedling"></i>Detalles de Producción #{{ $produccion->id }}
                    </h1>
                    <p class="main-subtitle">
                        {{ $produccion->tipo_cacao }} - {{ $produccion->lote?->nombre ?? 'Sin lote' }}
                    </p>
                    
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="breadcrumb-professional">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fas fa-home me-1"></i>Inicio
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('produccion.index') }}">
                                    <i class="fas fa-seedling me-1"></i>Producción
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-eye me-1"></i>Detalles
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <a href="{{ route('produccion.edit', $produccion->id) }}" class="btn-professional btn-primary-professional">
                            <i class="fas fa-edit"></i>Editar
                        </a>
                        <a href="{{ route('produccion.index') }}" class="btn-professional btn-secondary-professional">
                            <i class="fas fa-arrow-left"></i>Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Principal -->
        <div class="card-professional fade-in-up">
            <div class="card-header-professional">
                <i class="fas fa-info-circle"></i>Información General
            </div>
            <div class="card-body-professional">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-leaf"></i>Cultivo
                        </div>
                        <div class="detail-value">{{ $produccion->tipo_cacao }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-map-marker-alt"></i>Lote Asignado
                        </div>
                        <div class="detail-value">{{ $produccion->lote?->nombre ?? 'Sin lote' }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-ruler-combined"></i>Área Asignada
                        </div>
                        <div class="detail-value">
                            {{ $produccion->area_asignada == floor($produccion->area_asignada) ? number_format($produccion->area_asignada, 0) : number_format($produccion->area_asignada, 2) }} m²
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-tasks"></i>Estado Actual
                        </div>
                        <div class="detail-value">
                            @php
                                $estadoClass = match($produccion->estado) {
                                    'completado' => 'badge-success-professional',
                                    'planificado' => 'badge-secondary-professional',
                                    'cosecha' => 'badge-warning-professional',
                                    'maduracion' => 'badge-info-professional',
                                    default => 'badge-primary-professional'
                                };
                            @endphp
                            <span class="badge-professional {{ $estadoClass }}">
                                <i class="fas fa-circle"></i>{{ ucfirst($produccion->estado) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-calendar-alt"></i>Fecha Inicio
                        </div>
                        <div class="detail-value">
                            {{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }}
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-calendar-check"></i>Fecha Fin Esperada
                        </div>
                        <div class="detail-value">
                            {{ $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Sin fecha' }}
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-calendar-plus"></i>Cosecha Programada
                        </div>
                        <div class="detail-value">
                            {{ $produccion->fecha_programada_cosecha ? $produccion->fecha_programada_cosecha->format('d/m/Y') : 'Sin fecha' }}
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-chart-line"></i>Progreso Actual
                        </div>
                        <div class="detail-value">
                            <div class="d-flex align-items-center gap-3">
                                <div class="progress progress-professional flex-grow-1" style="height: 12px;">
                                    <div class="progress-bar progress-bar-professional" 
                                         style="width: {{ $produccion->calcularProgreso() }}%;" 
                                         role="progressbar">
                                    </div>
                                </div>
                                <span class="fw-bold">{{ $produccion->calcularProgreso() }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($produccion->observaciones)
                    <div class="detail-item mt-3">
                        <div class="detail-label">
                            <i class="fas fa-sticky-note"></i>Observaciones
                        </div>
                        <div class="detail-value">{{ $produccion->observaciones }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Trabajadores Asignados -->
        <div class="card-professional fade-in-up">
            <div class="card-header-professional">
                <i class="fas fa-users"></i>Trabajadores Asignados
                <span class="ms-auto badge badge-info-professional">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Período: {{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }} - 
                    {{ $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Actual' }}
                </span>
            </div>
            <div class="card-body-professional p-0">
                @if($produccion->trabajadores->count() > 0)
                    <!-- Estadísticas resumidas -->
                    <div class="row g-0 mb-3 p-3">
                        <div class="col-md-4">
                            <div class="stats-card-show">
                                <div class="stats-number-show">{{ $produccion->trabajadores->count() }}</div>
                                <div class="stats-label-show">Trabajadores</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card-show">
                                @php
                                    $totalHorasProduccion = 0;
                                    foreach($produccion->trabajadores as $trabajador) {
                                        $fechaInicio = $produccion->fecha_inicio ?? now()->subMonths(3);
                                        $fechaFin = $produccion->fecha_fin_esperada ?? now()->addDays(7);
                                        
                                        if ($fechaInicio->lt(now()->subMonths(6))) {
                                            $fechaInicio = now()->subMonths(1);
                                        }
                                        if ($fechaFin->gt(now()->addMonths(1))) {
                                            $fechaFin = now()->addDays(7);
                                        }
                                        
                                        $horasLote = $trabajador->asistencias()
                                            ->where('lote_id', $produccion->lote_id)
                                            ->where('fecha', '>=', $fechaInicio)
                                            ->where('fecha', '<=', $fechaFin)
                                            ->sum('horas_trabajadas') ?? 0;
                                        
                                        $totalHorasProduccion += $horasLote;
                                    }
                                @endphp
                                <div class="stats-number-show">{{ $totalHorasProduccion == floor($totalHorasProduccion) ? number_format($totalHorasProduccion, 0) : number_format($totalHorasProduccion, 1) }}</div>
                                <div class="stats-label-show">Horas Totales</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card-show">
                                @php $promedio = $produccion->trabajadores->count() > 0 ? $totalHorasProduccion / $produccion->trabajadores->count() : 0; @endphp
                                <div class="stats-number-show">{{ $promedio == floor($promedio) ? number_format($promedio, 0) : number_format($promedio, 1) }}</div>
                                <div class="stats-label-show">Promedio/Trabajador</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de trabajadores -->
                    <div class="table-responsive">
                        <table class="table table-professional mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user me-1"></i>Trabajador</th>
                                    <th><i class="fas fa-user-tag me-1"></i>Rol</th>
                                    <th><i class="fas fa-clock me-1"></i>Horas Totales</th>
                                    <th><i class="fas fa-calendar-week me-1"></i>Días Trabajados</th>
                                    <th><i class="fas fa-chart-line me-1"></i>Promedio Diario</th>
                                    <th><i class="fas fa-info-circle me-1"></i>Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produccion->trabajadores as $trabajador)
                                    @php
                                        $fechaInicio = $produccion->fecha_inicio ?? now()->subMonths(3);
                                        $fechaFin = $produccion->fecha_fin_esperada ?? now()->addDays(7);
                                        
                                        if ($fechaInicio->lt(now()->subMonths(6))) {
                                            $fechaInicio = now()->subMonths(1);
                                        }
                                        if ($fechaFin->gt(now()->addMonths(1))) {
                                            $fechaFin = now()->addDays(7);
                                        }
                                        
                                        $asistenciasFiltradas = $trabajador->asistencias()
                                            ->where('lote_id', $produccion->lote_id)
                                            ->where('fecha', '>=', $fechaInicio)
                                            ->where('fecha', '<=', $fechaFin)
                                            ->orderBy('fecha', 'desc')
                                            ->get();
                                        
                                        $totalHoras = $asistenciasFiltradas->sum('horas_trabajadas') ?? 0;
                                        $diasTrabajados = $asistenciasFiltradas->count();
                                        $promedioDiario = $diasTrabajados > 0 ? $totalHoras / $diasTrabajados : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 40px; height: 40px; font-size: 0.9rem; font-weight: 600;">
                                                    {{ strtoupper(substr($trabajador->nombre ?? $trabajador->user->name ?? 'N/A', 0, 2)) }}
                                                </div>
                                                <div>
                                                    <strong class="d-block">{{ $trabajador->nombre ?? $trabajador->user->name ?? 'Sin nombre' }}</strong>
                                                    @if($trabajador->apellido)
                                                        <small class="text-muted">{{ $trabajador->apellido }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-professional badge-secondary-professional">
                                                <i class="fas fa-user-hard-hat"></i>
                                                {{ $trabajador->pivot->rol ?? 'Trabajador' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($totalHoras > 0)
                                                <span class="badge-professional badge-success-professional">
                                                    <i class="fas fa-clock"></i>
                                                    {{ $totalHoras == floor($totalHoras) ? number_format($totalHoras, 0) : number_format($totalHoras, 1) }}h
                                                </span>
                                            @else
                                                <span class="badge-professional badge-warning-professional">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Sin horas
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($diasTrabajados > 0)
                                                <span class="badge-professional badge-info-professional">
                                                    <i class="fas fa-calendar-day"></i>
                                                    {{ $diasTrabajados }} días
                                                </span>
                                            @else
                                                <span class="text-muted">0 días</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($promedioDiario > 0)
                                                <strong class="text-primary">
                                                    {{ $promedioDiario == floor($promedioDiario) ? number_format($promedioDiario, 0) : number_format($promedioDiario, 1) }}h/día
                                                </strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($asistenciasFiltradas->count() > 0)
                                                <button class="btn btn-sm btn-primary-professional" 
                                                        onclick="mostrarDetalleHoras({{ $trabajador->id }}, '{{ $trabajador->nombre ?? $trabajador->user->name }}')"
                                                        data-asistencias="{{ $asistenciasFiltradas->toJson() }}">
                                                    <i class="fas fa-eye"></i> Ver detalle
                                                </button>
                                            @else
                                                <span class="text-muted">Sin registros</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay trabajadores asignados</h5>
                        <p class="text-muted">Esta producción no tiene trabajadores asignados actualmente</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Insumos Utilizados -->
        <div class="card-professional fade-in-up">
            <div class="card-header-professional">
                <i class="fas fa-box"></i>Insumos Utilizados
                <span class="ms-auto badge badge-warning-professional">
                    <i class="fas fa-map-marker-alt me-1"></i>Lote: {{ $produccion->lote?->nombre ?? 'Sin lote' }}
                </span>
            </div>
            <div class="card-body-professional">
                @php
                    $insumosLote = $produccion->salidaInventarios->where('lote_id', $produccion->lote_id);
                    $totalValor = $insumosLote->sum(function($salida) {
                        return $salida->precio_unitario * $salida->cantidad;
                    });
                @endphp
                
                @if($insumosLote->count() > 0)
                    <!-- Estadísticas de insumos -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="stats-card-show">
                                <div class="stats-number-show">{{ $insumosLote->count() }}</div>
                                <div class="stats-label-show">Tipos de Insumos</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card-show">
                                <div class="stats-number-show">{{ $insumosLote->sum('cantidad') }}</div>
                                <div class="stats-label-show">Cantidad Total</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card-show">
                                <div class="stats-number-show">${{ number_format($totalValor, 2) }}</div>
                                <div class="stats-label-show">Valor Total</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-professional">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-box me-1"></i>Insumo</th>
                                    <th><i class="fas fa-weight-hanging me-1"></i>Cantidad</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i>Precio Unitario</th>
                                    <th><i class="fas fa-calculator me-1"></i>Valor Total</th>
                                    <th><i class="fas fa-calendar-alt me-1"></i>Fecha Uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($insumosLote as $salida)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-cube text-primary me-2"></i>
                                                <strong>{{ $salida->insumo?->nombre ?? 'Insumo eliminado' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-professional badge-info-professional">
                                                {{ $salida->cantidad }} {{ $salida->insumo?->unidad_medida ?? 'unidades' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-success fw-bold">${{ number_format($salida->precio_unitario, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge-professional badge-success-professional">
                                                <i class="fas fa-dollar-sign"></i>
                                                ${{ number_format($salida->precio_unitario * $salida->cantidad, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $salida->created_at ? $salida->created_at->format('d/m/Y') : 'Sin fecha' }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay insumos registrados</h5>
                        <p class="text-muted">No se han utilizado insumos en este lote para esta producción</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Métricas de Rendimiento -->
        <div class="card-professional fade-in-up">
            <div class="card-header-professional">
                <i class="fas fa-chart-line"></i>Métricas de Rendimiento
            </div>
            <div class="card-body-professional">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-target"></i>Estimación Producción
                        </div>
                        <div class="detail-value">
                            <span class="badge-professional badge-info-professional">
                                {{ $produccion->estimacion_produccion == floor($produccion->estimacion_produccion) ? number_format($produccion->estimacion_produccion, 0) : number_format($produccion->estimacion_produccion, 2) }} kg
                            </span>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-weight-hanging"></i>Cantidad Cosechada
                        </div>
                        <div class="detail-value">
                            @if($produccion->cantidad_cosechada)
                                <span class="badge-professional badge-success-professional">
                                    {{ $produccion->cantidad_cosechada == floor($produccion->cantidad_cosechada) ? number_format($produccion->cantidad_cosechada, 0) : number_format($produccion->cantidad_cosechada, 2) }} kg
                                </span>
                            @else
                                <span class="text-muted">Pendiente</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-percentage"></i>Rendimiento Real
                        </div>
                        <div class="detail-value">
                            @if($produccion->rendimiento_real)
                                @php
                                    $rendimiento = $produccion->rendimiento_real;
                                    $badgeClass = $rendimiento >= 90 ? 'badge-success-professional' : 
                                                ($rendimiento >= 70 ? 'badge-warning-professional' : 'badge-secondary-professional');
                                @endphp
                                <span class="badge-professional {{ $badgeClass }}">
                                    {{ $produccion->rendimiento_real == floor($produccion->rendimiento_real) ? number_format($produccion->rendimiento_real, 0) : number_format($produccion->rendimiento_real, 2) }}%
                                </span>
                            @else
                                <span class="text-muted">Por calcular</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-balance-scale"></i>Desviación Estimación
                        </div>
                        <div class="detail-value">
                            @if($produccion->desviacion_estimacion)
                                @php
                                    $desviacion = $produccion->desviacion_estimacion;
                                    $badgeClass = $desviacion >= 0 ? 'badge-success-professional' : 'badge-warning-professional';
                                @endphp
                                <span class="badge-professional {{ $badgeClass }}">
                                    @if($desviacion >= 0)+@endif{{ $produccion->desviacion_estimacion == floor($produccion->desviacion_estimacion) ? number_format($produccion->desviacion_estimacion, 0) : number_format($produccion->desviacion_estimacion, 2) }} kg
                                </span>
                            @else
                                <span class="text-muted">Sin calcular</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-calendar-check"></i>Fecha Cosecha Real
                        </div>
                        <div class="detail-value">
                            @if($produccion->fecha_cosecha_real)
                                {{ $produccion->fecha_cosecha_real->format('d/m/Y') }}
                            @else
                                <span class="text-muted">Pendiente</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-calculator"></i>Rendimiento por m²
                        </div>
                        <div class="detail-value">
                            @if($produccion->cantidad_cosechada && $produccion->area_asignada > 0)
                                @php
                                    $rendimientoM2 = $produccion->cantidad_cosechada / $produccion->area_asignada;
                                @endphp
                                <strong class="text-primary">
                                    {{ number_format($rendimientoM2, 2) }} kg/m²
                                </strong>
                            @else
                                <span class="text-muted">Por calcular</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recolecciones Diarias -->
        <div class="card-professional fade-in-up">
            <div class="card-header-professional">
                <i class="fas fa-calendar-day"></i>Recolecciones Diarias
                @if(in_array($produccion->estado, ['maduracion', 'cosecha']))
                    <button class="btn btn-sm btn-primary-professional ms-auto" data-bs-toggle="modal" data-bs-target="#modalRecoleccion">
                        <i class="fas fa-plus"></i> Nueva Recolección
                    </button>
                @endif
            </div>
            <div class="card-body-professional">
                <!-- Estadísticas de Recolección -->
                <div class="row g-3 mb-4" id="estadisticasRecoleccion">
                    <div class="col-md-3">
                        <div class="stats-card-show">
                            <div class="stats-number-show text-success" id="totalRecolectado">
                                {{ $produccion->total_recolectado == floor($produccion->total_recolectado) ? number_format($produccion->total_recolectado, 0) : number_format($produccion->total_recolectado, 2) }}
                            </div>
                            <div class="stats-label-show">kg Recolectados</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card-show">
                            <div class="stats-number-show text-info" id="porcentajeCompletado">
                                {{ $produccion->porcentaje_recoleccion_completado == floor($produccion->porcentaje_recoleccion_completado) ? number_format($produccion->porcentaje_recoleccion_completado, 0) : number_format($produccion->porcentaje_recoleccion_completado, 1) }}%
                            </div>
                            <div class="stats-label-show">Progreso</div>
                            <div class="progress progress-professional mt-2" style="height: 8px;">
                                <div class="progress-bar progress-bar-professional" style="width: {{ $produccion->porcentaje_recoleccion_completado }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card-show">
                            <div class="stats-number-show text-warning" id="cantidadPendiente">
                                {{ $produccion->cantidad_pendiente_recoleccion == floor($produccion->cantidad_pendiente_recoleccion) ? number_format($produccion->cantidad_pendiente_recoleccion, 0) : number_format($produccion->cantidad_pendiente_recoleccion, 2) }}
                            </div>
                            <div class="stats-label-show">kg Pendientes</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card-show">
                            <div class="stats-number-show text-primary" id="diasRecolectando">
                                {{ $produccion->recolecciones()->distinct('fecha_recoleccion')->count() }}
                            </div>
                            <div class="stats-label-show">Días Recolectando</div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Recolecciones -->
                <div id="listaRecolecciones">
                    @if($produccion->recolecciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-professional">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-calendar-day me-1"></i>Fecha</th>
                                        <th><i class="fas fa-weight-hanging me-1"></i>Cantidad</th>
                                        <th><i class="fas fa-seedling me-1"></i>Estado Fruto</th>
                                        <th><i class="fas fa-cloud-sun me-1"></i>Clima</th>
                                        <th><i class="fas fa-users me-1"></i>Trabajadores</th>
                                        <th><i class="fas fa-star me-1"></i>Calidad</th>
                                        <th><i class="fas fa-cogs me-1"></i>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produccion->recolecciones()->activos()->orderBy('fecha_recoleccion', 'desc')->get() as $recoleccion)
                                    <tr>
                                        <td>
                                            <strong>{{ $recoleccion->fecha_recoleccion->format('d/m/Y') }}</strong>
                                            <br><small class="text-muted">{{ $recoleccion->fecha_recoleccion->format('l') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge-professional badge-success-professional">
                                                <i class="fas fa-weight-hanging"></i>
                                                {{ $recoleccion->cantidad_recolectada == floor($recoleccion->cantidad_recolectada) ? number_format($recoleccion->cantidad_recolectada, 0) : number_format($recoleccion->cantidad_recolectada, 2) }} kg
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge-professional badge-{{ $recoleccion->badgeEstadoFruto['class'] }}-professional">
                                                <i class="fas fa-{{ $recoleccion->badgeEstadoFruto['icon'] }}"></i>
                                                {{ ucfirst($recoleccion->estado_fruto) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge-professional badge-{{ $recoleccion->badgeClima['class'] }}-professional">
                                                <i class="fas fa-{{ $recoleccion->badgeClima['icon'] }}"></i>
                                                {{ ucfirst($recoleccion->condiciones_climaticas) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge-professional badge-info-professional">
                                                <i class="fas fa-users"></i>
                                                {{ $recoleccion->trabajadoresParticipantes()->count() }} personas
                                            </span>
                                        </td>
                                        <td>
                                            @if($recoleccion->calidad_promedio)
                                                <div class="d-flex align-items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $recoleccion->calidad_promedio ? 'text-warning' : 'text-muted' }}" style="font-size: 0.9rem;"></i>
                                                    @endfor
                                                    <small class="ms-2 fw-bold">{{ $recoleccion->calidad_promedio }}/5</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Sin calificar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-primary-professional" onclick="verDetalleRecoleccion({{ $recoleccion->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('recolecciones.edit', $recoleccion->id) }}" class="btn btn-sm btn-secondary-professional">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay recolecciones registradas</h5>
                            <p class="text-muted">Comienza a registrar las recolecciones diarias de cacao</p>
                            @if(in_array($produccion->estado, ['maduracion', 'cosecha']))
                                <button class="btn btn-primary-professional" data-bs-toggle="modal" data-bs-target="#modalRecoleccion">
                                    <i class="fas fa-plus me-2"></i>Registrar Primera Recolección
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botón de navegación -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('produccion.index') }}" 
               style="text-decoration: none; color: white; background: linear-gradient(135deg, #6c757d, #495057); border: none; padding: 8px 16px; border-radius: 6px; display: inline-block; font-weight: 600; cursor: pointer; transition: all 0.2s;"
               onmouseover="this.style.background='linear-gradient(135deg, #495057, #343a40)'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.background='linear-gradient(135deg, #6c757d, #495057)'; this.style.transform='translateY(0)'">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Volver a Producción
            </a>
        </div>
    </div>
</div>

<!-- Modal para Nueva Recolección -->
<div class="modal fade" id="modalRecoleccion" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--warning), #e65100); color: white; border: none; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title"><i class="fas fa-calendar-plus me-2"></i>Registrar Nueva Recolección</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRecoleccion" action="{{ route('recolecciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="produccion_id" value="{{ $produccion->id }}">
                
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>Fecha de Recolección <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control form-control-professional" name="fecha_recoleccion" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-weight-hanging me-1"></i>Cantidad Recolectada (kg) <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control form-control-professional" name="cantidad_recolectada" 
                                       step="0.001" min="0.001" max="9999.999" required
                                       placeholder="Ej: 25.5">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-seedling me-1"></i>Estado del Fruto <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-professional" name="estado_fruto" required>
                                    <option value="">Seleccionar estado</option>
                                    <option value="maduro">🟫 Maduro</option>
                                    <option value="semi-maduro">🟡 Semi-maduro</option>
                                    <option value="verde">🟢 Verde</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-cloud-sun me-1"></i>Condiciones Climáticas <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-professional" name="condiciones_climaticas" required>
                                    <option value="">Seleccionar clima</option>
                                    <option value="soleado">☀️ Soleado</option>
                                    <option value="nublado">☁️ Nublado</option>
                                    <option value="lluvioso">🌧️ Lluvioso</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-clock me-1"></i>Hora Inicio
                                </label>
                                <input type="time" class="form-control form-control-professional" name="hora_inicio">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-clock me-1"></i>Hora Fin
                                </label>
                                <input type="time" class="form-control form-control-professional" name="hora_fin">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-users me-1"></i>Trabajadores Participantes <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-professional" name="trabajadores_participantes[]" multiple required>
                                    @foreach(\App\Models\Trabajador::activos()->get() as $trabajador)
                                        <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }} {{ $trabajador->apellido }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Mantén Ctrl presionado para seleccionar múltiples trabajadores</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">
                                    <i class="fas fa-star me-1"></i>Calidad Promedio (1-5)
                                </label>
                                <select class="form-select form-select-professional" name="calidad_promedio">
                                    <option value="">Sin calificar</option>
                                    <option value="1">⭐ 1 - Muy baja</option>
                                    <option value="2">⭐⭐ 2 - Baja</option>
                                    <option value="3">⭐⭐⭐ 3 - Regular</option>
                                    <option value="4">⭐⭐⭐⭐ 4 - Buena</option>
                                    <option value="5">⭐⭐⭐⭐⭐ 5 - Excelente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">
                            <i class="fas fa-sticky-note me-1"></i>Observaciones
                        </label>
                        <textarea class="form-control form-control-professional" name="observaciones" rows="3" 
                                  placeholder="Notas adicionales sobre la recolección..."></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="border: none; padding: 1.5rem 2rem;">
                    <button type="button" class="btn btn-secondary-professional" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-professional" id="btnGuardarRecoleccion">
                        <i class="fas fa-save me-2"></i>Guardar Recolección
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Detalle de Horas Trabajadas -->
<div class="modal fade" id="modalDetalleHoras" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--info), #0d47a1); color: white; border: none; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title">
                    <i class="fas fa-clock me-2"></i>Detalle de Horas Trabajadas - 
                    <span id="nombreTrabajadorModal"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="stats-card-show">
                            <div class="stats-number-show text-success" id="totalHorasModal">0h</div>
                            <div class="stats-label-show">Total Horas</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card-show">
                            <div class="stats-number-show text-info" id="diasTrabajadosModal">0</div>
                            <div class="stats-label-show">Días Trabajados</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card-show">
                            <div class="stats-number-show text-warning" id="promedioDiarioModal">0h</div>
                            <div class="stats-label-show">Promedio/Día</div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-professional">
                        <thead>
                            <tr>
                                <th><i class="fas fa-calendar-day me-1"></i>Fecha</th>
                                <th><i class="fas fa-clock me-1"></i>Horas</th>
                                <th><i class="fas fa-sign-in-alt me-1"></i>Entrada</th>
                                <th><i class="fas fa-sign-out-alt me-1"></i>Salida</th>
                                <th><i class="fas fa-map-marker-alt me-1"></i>Lote</th>
                                <th><i class="fas fa-clipboard me-1"></i>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDetalleHoras">
                            <!-- Se llenará dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="border: none; padding: 1.5rem 2rem;">
                <button type="button" class="btn btn-secondary-professional" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Metadatos para JavaScript -->
<meta name="produccion-id" content="{{ $produccion->id }}">
<meta name="produccion-estado" content="{{ $produccion->estado }}">
<meta name="lote-nombre" content="{{ $produccion->lote?->nombre ?? 'Sin lote' }}">

@push('scripts')
<script src="{{ asset('js/produccion/show.js') }}"></script>
<script>
// Inicialización de datos cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Datos de la producción para el JavaScript externo
    const produccionData = {
        id: {{ $produccion->id }},
        estado: '{{ $produccion->estado }}',
        lote_nombre: '{{ $produccion->lote?->nombre ?? "Sin lote" }}',
        trabajadores: @json($produccion->trabajadores->map(function($trabajador) {
            return [
                'id' => $trabajador->id,
                'nombre' => $trabajador->nombre ?? $trabajador->user->name ?? 'Sin nombre'
            ];
        })),
        routes: {
            produccion_index: '{{ route("produccion.index") }}',
            produccion_edit: '{{ route("produccion.edit", $produccion->id) }}',
            home: '{{ route("home") }}',
            recolecciones_store: '{{ route("recolecciones.store") }}'
        }
    };
    
    // Hacer disponible los datos globalmente
    window.produccionData = produccionData;
    
    // Inicializar funcionalidad externa si está disponible
    if (typeof initializeShowData === 'function') {
        initializeShowData(produccionData);
    }
});
</script>
@endpush

@endsection
