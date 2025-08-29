@extends('layouts.masterr')

@section('content')
<link rel="stylesheet" href="{{ asset('css/recolecciones/show.css') }}">

<div class="container-fluid">
    <!-- Título principal -->
    <h1 class="main-title">
        Detalles de Recolección #{{ $recoleccion->id ?? 'N/A' }}
    </h1>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Header con información básica -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h4 class="card-title">
                            <i class="fas fa-clipboard-list"></i>
                            Registro de Recolección
                        </h4>
                        @if($recoleccion->fecha_recoleccion)
                            <p class="card-subtitle">
                                Fecha: {{ $recoleccion->fecha_recoleccion->format('d/m/Y') }}
                                @if($recoleccion->produccion && $recoleccion->produccion->lote)
                                    | Lote: {{ $recoleccion->produccion->lote->nombre }}
                                @endif
                            </p>
                        @endif
                    </div>
                    <a href="{{ route('recolecciones.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <!-- Grid de información principal -->
            <div class="row">
                <!-- Información General -->
                <div class="col-lg-6">
                    <div class="info-section">
                        <div class="info-header">
                            <h5 class="info-title">
                                <i class="fas fa-info-circle"></i>
                                Información General
                            </h5>
                        </div>
                        <div class="info-body">
                            <table class="info-table">
                                <tr>
                                    <td><strong>Fecha de Recolección:</strong></td>
                                    <td>
                                        @if($recoleccion->fecha_recoleccion)
                                            <span class="status-badge badge-primary">
                                                <i class="fas fa-calendar"></i>
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
                                            <span class="status-badge badge-success">
                                                <i class="fas fa-seedling"></i>
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
                                            <span class="status-badge badge-info">
                                                {{ ucfirst($recoleccion->produccion->tipo_cacao) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Tipo no especificado</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Cantidad:</strong></td>
                                    <td>
                                        <span class="status-badge badge-success">
                                            <i class="fas fa-weight-hanging"></i>
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
                                                    <span class="status-badge badge-maduro">
                                                        <i class="fas fa-check-circle"></i>Maduro
                                                    </span>
                                                    @break
                                                @case('semi-maduro')
                                                    <span class="status-badge badge-semi">
                                                        <i class="fas fa-clock"></i>Semi-maduro
                                                    </span>
                                                    @break
                                                @case('verde')
                                                    <span class="status-badge badge-verde">
                                                        <i class="fas fa-exclamation-triangle"></i>Verde
                                                    </span>
                                                    @break
                                            @endswitch
                                        @else
                                            <span class="text-muted">Estado no registrado</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Condiciones:</strong></td>
                                    <td>
                                        @if($recoleccion->condiciones_climaticas)
                                            @switch($recoleccion->condiciones_climaticas)
                                                @case('soleado')
                                                    <span class="status-badge badge-soleado">
                                                        <i class="fas fa-sun"></i>Soleado
                                                    </span>
                                                    @break
                                                @case('nublado')
                                                    <span class="status-badge badge-nublado">
                                                        <i class="fas fa-cloud"></i>Nublado
                                                    </span>
                                                    @break
                                                @case('lluvioso')
                                                    <span class="status-badge badge-lluvioso">
                                                        <i class="fas fa-cloud-rain"></i>Lluvioso
                                                    </span>
                                                    @break
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

                <!-- Calidad y Trabajadores -->
                <div class="col-lg-6">
                    <div class="info-section">
                        <div class="info-header">
                            <h5 class="info-title">
                                <i class="fas fa-users"></i>
                                Calidad y Personal
                            </h5>
                        </div>
                        <div class="info-body">
                            @if($recoleccion->calidad_promedio)
                                <div class="quality-display">
                                    <strong>Calidad Promedio</strong>
                                    <div class="stars-container">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star star {{ $i <= $recoleccion->calidad_promedio ? 'star-active' : 'star-inactive' }}"></i>
                                        @endfor
                                    </div>
                                    <div class="status-badge badge-primary">{{ $recoleccion->calidad_promedio }}/5</div>
                                    <div class="quality-label">
                                        @switch($recoleccion->calidad_promedio)
                                            @case(1) Muy Baja @break
                                            @case(2) Baja @break
                                            @case(3) Regular @break
                                            @case(4) Buena @break
                                            @case(5) Excelente @break
                                        @endswitch
                                    </div>
                                </div>
                            @endif

                            <div>
                                <strong>Trabajadores Participantes:</strong>
                                @if($recoleccion->trabajadores_participantes && is_array($recoleccion->trabajadores_participantes) && count($recoleccion->trabajadores_participantes) > 0)
                                    <div class="workers-container">
                                        @php $trabajadoresEncontrados = 0; @endphp
                                        @foreach($recoleccion->trabajadores_participantes as $trabajadorId)
                                            @php $trabajador = \App\Models\Trabajador::find($trabajadorId); @endphp
                                            @if($trabajador && $trabajador->activo)
                                                @php $trabajadoresEncontrados++; @endphp
                                                <span class="worker-badge">
                                                    <i class="fas fa-user"></i>{{ $trabajador->nombre_completo }}
                                                </span>
                                            @elseif($trabajador)
                                                @php $trabajadoresEncontrados++; @endphp
                                                <span class="worker-badge inactive" title="Trabajador inactivo">
                                                    <i class="fas fa-user-slash"></i>{{ $trabajador->nombre_completo }}
                                                </span>
                                            @endif
                                        @endforeach

                                        @if($trabajadoresEncontrados == 0)
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Los trabajadores registrados ya no están disponibles en el sistema.
                                            </div>
                                        @endif
                                    </div>

                                    <div class="workers-summary">
                                        <i class="fas fa-info-circle"></i>
                                        Total registrados: {{ count($recoleccion->trabajadores_participantes) }} |
                                        Activos encontrados: {{ $trabajadoresEncontrados }}
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-users"></i>
                                        No hay trabajadores registrados para esta recolección
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($recoleccion->observaciones)
                <div class="info-section">
                    <div class="info-header">
                        <h5 class="info-title">
                            <i class="fas fa-comment"></i>
                            Observaciones
                        </h5>
                    </div>
                    <div class="info-body">
                        <div class="observations-content">
                            {{ $recoleccion->observaciones }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Estado del Lote -->
            <div class="info-section">
                <div class="info-header">
                    <h5 class="info-title">
                        <i class="fas fa-seedling"></i>
                        Estado del Lote
                    </h5>
                </div>
                <div class="info-body">
                    <!-- Estadísticas -->
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value info">{{ $recoleccion->produccion ? number_format($recoleccion->produccion->estimacion_produccion, 2) : '0.00' }}</div>
                            <div class="stat-label">Estimación Total (kg)</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value success">{{ $recoleccion->produccion ? number_format($recoleccion->produccion->total_recolectado, 2) : '0.00' }}</div>
                            <div class="stat-label">Total Recolectado (kg)</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value warning">{{ $recoleccion->produccion ? number_format($recoleccion->produccion->cantidad_pendiente_recoleccion, 2) : '0.00' }}</div>
                            <div class="stat-label">Pendiente (kg)</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value primary">{{ $recoleccion->produccion ? number_format($recoleccion->produccion->porcentaje_recoleccion_completado, 1) : '0.0' }}%</div>
                            <div class="stat-label">Completado</div>
                        </div>
                    </div>

                    <!-- Barra de progreso -->
                    <div class="progress-container">
                        <div class="progress">
                            <div class="progress-bar {{ ($recoleccion->produccion && $recoleccion->produccion->porcentaje_recoleccion_completado >= 100) ? 'completed' : '' }}"
                                 style="width: {{ $recoleccion->produccion ? min(100, $recoleccion->produccion->porcentaje_recoleccion_completado) : 0 }}%;">
                                {{ $recoleccion->produccion ? number_format($recoleccion->produccion->porcentaje_recoleccion_completado, 1) : '0.0' }}%
                            </div>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="text-center mt-3">
                        @if($recoleccion->produccion && $recoleccion->produccion->estado == 'completado')
                            <span class="status-badge badge-success">
                                <i class="fas fa-check-circle"></i>
                                {{ ucfirst($recoleccion->produccion->estado) }}
                            </span>
                        @else
                            <span class="status-badge badge-warning">
                                <i class="fas fa-clock"></i>
                                {{ $recoleccion->produccion ? ucfirst($recoleccion->produccion->estado) : 'Sin estado' }}
                            </span>
                        @endif

                        @if($recoleccion->produccion && $recoleccion->produccion->porcentaje_recoleccion_completado >= 100)
                            <br><br>
                            <span class="status-badge badge-success">
                                <i class="fas fa-trophy"></i> Recolección Completada
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="action-buttons">
                @if($recoleccion->produccion)
                    <a href="{{ route('produccion.show', $recoleccion->produccion->id) }}" class="btn btn-info">
                        <i class="fas fa-seedling"></i> Ver Producción Completa
                    </a>
                    @if($recoleccion->produccion->porcentaje_recoleccion_completado < 100)
                        <a href="{{ route('recolecciones.create', ['produccion' => $recoleccion->produccion->id]) }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Nueva Recolección
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
@endsection
