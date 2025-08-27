@extends('layouts.masterr')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/produccion/show.css') }}">
@endpush

@section('content')
<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header limpio -->
        <div class="header-clean">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">
                        Detalles de Producción #{{ $produccion->id }}
                    </h1>
                    <p class="main-subtitle">
                        {{ $produccion->tipo_cacao }} - {{ $produccion->lote?->nombre ?? 'Sin lote' }}
                    </p>
                    
                    <!-- Breadcrumb limpio -->
                    <nav aria-label="breadcrumb" class="breadcrumb-clean">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('produccion.index') }}">Producción</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Detalles
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <a href="{{ route('produccion.edit', $produccion->id) }}" class="btn btn-primary">
                            Editar
                        </a>
                        <a href="{{ route('produccion.index') }}" class="btn btn-secondary">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Principal -->
        <div class="card-clean">
            <div class="card-header-clean">
                Información General
            </div>
            <div class="card-body-clean">
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Cultivo</div>
                        <div class="detail-value">{{ $produccion->tipo_cacao }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Lote Asignado</div>
                        <div class="detail-value">{{ $produccion->lote?->nombre ?? 'Sin lote' }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Área Asignada</div>
                        <div class="detail-value">
                            {{ $produccion->area_asignada == floor($produccion->area_asignada) ? number_format($produccion->area_asignada, 0) : number_format($produccion->area_asignada, 2) }} m²
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Estado Actual</div>
                        <div class="detail-value">
                            @php
                                $estadoClass = match($produccion->estado) {
                                    'completado' => 'badge-success',
                                    'planificado' => 'badge-secondary',
                                    'cosecha' => 'badge-warning',
                                    'maduracion' => 'badge-info',
                                    default => 'badge-primary'
                                };
                            @endphp
                            <span class="badge {{ $estadoClass }}">
                                {{ ucfirst($produccion->estado) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Fecha Inicio</div>
                        <div class="detail-value">
                            {{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }}
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Fecha Fin Esperada</div>
                        <div class="detail-value">
                            {{ $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Sin fecha' }}
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Cosecha Programada</div>
                        <div class="detail-value">
                            {{ $produccion->fecha_programada_cosecha ? $produccion->fecha_programada_cosecha->format('d/m/Y') : 'Sin fecha' }}
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Progreso Actual</div>
                        <div class="detail-value">
                            <div class="d-flex align-items-center gap-3">
                                <div class="progress-clean flex-grow-1">
                                    <div class="progress-bar-clean" 
                                         style="width: {{ $produccion->calcularProgreso() }}%;">
                                    </div>
                                </div>
                                <span class="fw-bold">{{ $produccion->calcularProgreso() }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($produccion->observaciones)
                    <div class="detail-item mt-3">
                        <div class="detail-label">Observaciones</div>
                        <div class="detail-value">{{ $produccion->observaciones }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Trabajadores Asignados -->
        <div class="card-clean">
            <div class="card-header-clean">
                Trabajadores Asignados
                <span class="ms-auto badge badge-info">
                    Período: {{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }} - 
                    {{ $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Actual' }}
                </span>
            </div>
            <div class="card-body-clean p-0">
                @if($produccion->trabajadores->count() > 0)
                    <!-- Estadísticas resumidas -->
                    <div class="row g-0 mb-3 p-3">
                        <div class="col-md-4">
                            <div class="stats-card">
                                <div class="stats-number">{{ $produccion->trabajadores->count() }}</div>
                                <div class="stats-label">Trabajadores</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
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
                                <div class="stats-number">{{ $totalHorasProduccion == floor($totalHorasProduccion) ? number_format($totalHorasProduccion, 0) : number_format($totalHorasProduccion, 1) }}</div>
                                <div class="stats-label">Horas Totales</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                @php $promedio = $produccion->trabajadores->count() > 0 ? $totalHorasProduccion / $produccion->trabajadores->count() : 0; @endphp
                                <div class="stats-number">{{ $promedio == floor($promedio) ? number_format($promedio, 0) : number_format($promedio, 1) }}</div>
                                <div class="stats-label">Promedio/Trabajador</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de trabajadores -->
                    <div class="table-responsive">
                        <table class="table table-clean mb-0">
                            <thead>
                                <tr>
                                    <th>Trabajador</th>
                                    <th>Rol</th>
                                    <th>Horas Totales</th>
                                    <th>Días Trabajados</th>
                                    <th>Promedio Diario</th>
                                    <th>Detalle</th>
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
                                            <span class="badge badge-secondary">
                                                {{ $trabajador->pivot->rol ?? 'Trabajador' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($totalHoras > 0)
                                                <span class="badge badge-success">
                                                    {{ $totalHoras == floor($totalHoras) ? number_format($totalHoras, 0) : number_format($totalHoras, 1) }}h
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    Sin horas
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($diasTrabajados > 0)
                                                <span class="badge badge-info">
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
                                                <button class="btn btn-sm btn-primary" 
                                                        onclick="mostrarDetalleHoras({{ $trabajador->id }}, '{{ $trabajador->nombre ?? $trabajador->user->name }}')"
                                                        data-asistencias="{{ $asistenciasFiltradas->toJson() }}">
                                                    Ver detalle
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
                        <h5 class="text-muted">No hay trabajadores asignados</h5>
                        <p class="text-muted">Esta producción no tiene trabajadores asignados actualmente</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Insumos Utilizados -->
        <div class="card-clean">
            <div class="card-header-clean">
                Insumos Utilizados
                <span class="ms-auto badge badge-warning">
                    Lote: {{ $produccion->lote?->nombre ?? 'Sin lote' }}
                </span>
            </div>
            <div class="card-body-clean">
                @php
                    $insumosLote = $produccion->salidaInventarios->filter(function($salida) use ($produccion) {
                        return $salida->lote_id == $produccion->lote_id;
                    });
                    $totalValor = $insumosLote->sum(function($salida) {
                        return $salida->precio_unitario * $salida->cantidad;
                    });
                @endphp
                
                @if($insumosLote->count() > 0)
                    <!-- Estadísticas de insumos -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="stats-card">
                                <div class="stats-number">{{ $insumosLote->count() }}</div>
                                <div class="stats-label">Tipos de Insumos</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <div class="stats-number">{{ $insumosLote->sum('cantidad') }}</div>
                                <div class="stats-label">Cantidad Total</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <div class="stats-number">${{ number_format($totalValor, 2) }}</div>
                                <div class="stats-label">Valor Total</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-clean">
                            <thead>
                                <tr>
                                    <th>Insumo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Valor Total</th>
                                    <th>Fecha Uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($insumosLote as $salida)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 40px; height: 40px; font-size: 0.9rem; font-weight: 600;">
                                                    {{ strtoupper(substr($salida->insumo?->nombre ?? 'IN', 0, 2)) }}
                                                </div>
                                                <strong>{{ $salida->insumo?->nombre ?? 'Insumo eliminado' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $salida->cantidad }} {{ $salida->insumo?->unidad_medida ?? 'unidades' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-success fw-bold">${{ number_format($salida->precio_unitario, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">
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
                        <h5 class="text-muted">No hay insumos registrados</h5>
                        <p class="text-muted">No se han utilizado insumos en este lote para esta producción</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Botón de navegación -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('produccion.index') }}" class="btn btn-secondary">
                Volver a Producción
            </a>
        </div>
    </div>
</div>


@push('scripts')
<script src="{{ asset('js/produccion/show.js') }}"></script>
@endpush

@endsection
