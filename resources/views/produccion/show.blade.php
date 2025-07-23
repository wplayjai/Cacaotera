@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-seedling"></i> Detalles de Producción</h4>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Cultivo</dt>
                        <dd class="col-sm-8">{{ $produccion->tipo_cacao }}</dd>

                        <dt class="col-sm-4">Lote</dt>
                        <dd class="col-sm-8">{{ $produccion->lote?->nombre ?? 'Sin lote' }}</dd>

                        <dt class="col-sm-4">Área Asignada (m²)</dt>
                        <dd class="col-sm-8">{{ $produccion->area_asignada == floor($produccion->area_asignada) ? number_format($produccion->area_asignada, 0) : number_format($produccion->area_asignada, 2) }}</dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-{{ $produccion->estado == 'completado' ? 'success' : ($produccion->estado == 'planificado' ? 'secondary' : 'warning') }}">
                                {{ ucfirst($produccion->estado) }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Fecha Inicio</dt>
                        <dd class="col-sm-8">{{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }}</dd>

                        <dt class="col-sm-4">Fecha Fin Esperada</dt>
                        <dd class="col-sm-8">{{ $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Sin fecha' }}</dd>

                        <dt class="col-sm-4">Fecha Programada Cosecha</dt>
                        <dd class="col-sm-8">{{ $produccion->fecha_programada_cosecha ? $produccion->fecha_programada_cosecha->format('d/m/Y') : 'Sin fecha' }}</dd>

                        <dt class="col-sm-4">Observaciones</dt>
                        <dd class="col-sm-8">{{ $produccion->observaciones ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-users"></i> Trabajadores Asignados</h5>
                    <small class="text-light">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Período: {{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha' }} - 
                        {{ $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Actual' }}
                        <br>
                        <small class="opacity-75">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Lote: {{ $produccion->lote?->nombre ?? 'Sin lote especificado' }}
                            <br>
                            <i class="fas fa-info-circle me-1"></i>
                            Mostrando horas trabajadas en este lote durante el período de producción
                            <br>
                            @php
                                $debugFechaInicio = $produccion->fecha_inicio ?? now()->subMonths(3);
                                $debugFechaFin = $produccion->fecha_fin_esperada ?? now()->addDays(7);
                                if ($debugFechaInicio->lt(now()->subMonths(6))) {
                                    $debugFechaInicio = now()->subMonths(1);
                                }
                                if ($debugFechaFin->gt(now()->addMonths(1))) {
                                    $debugFechaFin = now()->addDays(7);
                                }
                            @endphp
                            <small class="text-warning">
                                <i class="fas fa-search me-1"></i>
                                Buscando asistencias desde: {{ $debugFechaInicio->format('d/m/Y') }} hasta: {{ $debugFechaFin->format('d/m/Y') }}
                            </small>
                        </small>
                    </small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0 table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="fas fa-user me-1"></i> Nombre</th>
                                    <th><i class="fas fa-user-tag me-1"></i> Rol</th>
                                    <th><i class="fas fa-clock me-1"></i> Horas Totales</th>
                                    <th><i class="fas fa-calendar-week me-1"></i> Días Trabajados</th>
                                    <th><i class="fas fa-chart-line me-1"></i> Promedio Diario</th>
                                    <th><i class="fas fa-info-circle me-1"></i> Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produccion->trabajadores as $trabajador)
                                    @php
                                        // Usar un rango de fechas más amplio para capturar todas las asistencias recientes
                                        $fechaInicio = $produccion->fecha_inicio ?? now()->subMonths(3);
                                        $fechaFin = $produccion->fecha_fin_esperada ?? now()->addDays(7);
                                        
                                        // Si la fecha de inicio es muy antigua o futura, usar un rango más práctico
                                        if ($fechaInicio->lt(now()->subMonths(6))) {
                                            $fechaInicio = now()->subMonths(1); // Último mes
                                        }
                                        if ($fechaFin->gt(now()->addMonths(1))) {
                                            $fechaFin = now()->addDays(7); // Próxima semana
                                        }
                                        
                                        // Obtener asistencias del trabajador en el lote específico con rango de fechas flexible
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
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                    {{ strtoupper(substr($trabajador->nombre ?? $trabajador->user->name ?? 'N/A', 0, 2)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $trabajador->nombre ?? $trabajador->user->name ?? 'Sin nombre' }}</strong>
                                                    @if($trabajador->apellido)
                                                        <br><small class="text-muted">{{ $trabajador->apellido }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $trabajador->pivot->rol ?? 'Trabajador' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($totalHoras > 0)
                                                <span class="badge bg-success fs-6">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $totalHoras == floor($totalHoras) ? number_format($totalHoras, 0) : number_format($totalHoras, 1) }}h
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Sin horas
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($diasTrabajados > 0)
                                                <span class="badge bg-info">
                                                    <i class="fas fa-calendar-day me-1"></i>
                                                    {{ $diasTrabajados }} días
                                                </span>
                                            @else
                                                <span class="text-muted">0 días</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($promedioDiario > 0)
                                                <span class="text-primary fw-bold">
                                                    {{ $promedioDiario == floor($promedioDiario) ? number_format($promedioDiario, 0) : number_format($promedioDiario, 1) }}h/día
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($asistenciasFiltradas->count() > 0)
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        onclick="mostrarDetalleHoras({{ $trabajador->id }}, '{{ $trabajador->nombre ?? $trabajador->user->name }}')"
                                                        data-asistencias="{{ $asistenciasFiltradas->toJson() }}">
                                                    <i class="fas fa-eye"></i> Ver detalle
                                                </button>
                                            @else
                                                <span class="text-muted">Sin registros</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-2x mb-2"></i>
                                                <p class="mb-0">Sin trabajadores asignados a esta producción</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($produccion->trabajadores->count() > 0)
                        <div class="card-footer bg-light">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <small class="text-muted">Total Trabajadores</small>
                                    <div class="fw-bold text-primary">{{ $produccion->trabajadores->count() }}</div>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Horas Acumuladas</small>
                                    @php
                                        $totalHorasProduccion = 0;
                                        foreach($produccion->trabajadores as $trabajador) {
                                            // Usar el mismo rango de fechas flexible
                                            $fechaInicio = $produccion->fecha_inicio ?? now()->subMonths(3);
                                            $fechaFin = $produccion->fecha_fin_esperada ?? now()->addDays(7);
                                            
                                            if ($fechaInicio->lt(now()->subMonths(6))) {
                                                $fechaInicio = now()->subMonths(1);
                                            }
                                            if ($fechaFin->gt(now()->addMonths(1))) {
                                                $fechaFin = now()->addDays(7);
                                            }
                                            
                                            // Filtrar por lote específico y rango de fechas
                                            $horasLote = $trabajador->asistencias()
                                                ->where('lote_id', $produccion->lote_id)
                                                ->where('fecha', '>=', $fechaInicio)
                                                ->where('fecha', '<=', $fechaFin)
                                                ->sum('horas_trabajadas') ?? 0;
                                            
                                            $totalHorasProduccion += $horasLote;
                                        }
                                    @endphp
                                    <div class="fw-bold text-success">{{ $totalHorasProduccion == floor($totalHorasProduccion) ? number_format($totalHorasProduccion, 0) : number_format($totalHorasProduccion, 1) }}h</div>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Promedio por Trabajador</small>
                                    <div class="fw-bold text-info">
                                        @php $promedio = $produccion->trabajadores->count() > 0 ? $totalHorasProduccion / $produccion->trabajadores->count() : 0; @endphp
                                        {{ $promedio == floor($promedio) ? number_format($promedio, 0) : number_format($promedio, 1) }}h
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5><i class="fas fa-box"></i> Insumos Utilizados</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Salidas de inventario para el lote: {{ $produccion->lote?->nombre ?? '-' }}</strong></p>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Insumo</th>
                                    <th>Cantidad</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $insumosLote = $produccion->salidaInventarios->where('lote_id', $produccion->lote_id);
                                @endphp
                                @forelse($insumosLote as $salida)
                                    <tr>
                                        <td>{{ $salida->insumo?->nombre ?? '-' }}</td>
                                        <td>{{ $salida->cantidad }}</td>
                                        <td>${{ number_format($salida->precio_unitario * $salida->cantidad, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">Sin insumos registrados para este lote</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-chart-line"></i> Métricas de Rendimiento</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Estimación Producción</dt>
                        <dd class="col-sm-8">{{ $produccion->estimacion_produccion == floor($produccion->estimacion_produccion) ? number_format($produccion->estimacion_produccion, 0) : number_format($produccion->estimacion_produccion, 2) }} kg</dd>

                        <dt class="col-sm-4">Cantidad Cosechada</dt>
                        <dd class="col-sm-8">{{ $produccion->cantidad_cosechada ? ($produccion->cantidad_cosechada == floor($produccion->cantidad_cosechada) ? number_format($produccion->cantidad_cosechada, 0) : number_format($produccion->cantidad_cosechada, 2)) : '-' }} kg</dd>

                        <dt class="col-sm-4">Rendimiento Real</dt>
                        <dd class="col-sm-8">{{ $produccion->rendimiento_real ? ($produccion->rendimiento_real == floor($produccion->rendimiento_real) ? number_format($produccion->rendimiento_real, 0) : number_format($produccion->rendimiento_real, 2)) : '-' }} %</dd>

                        <dt class="col-sm-4">Desviación Estimación</dt>
                        <dd class="col-sm-8">{{ $produccion->desviacion_estimacion ? ($produccion->desviacion_estimacion == floor($produccion->desviacion_estimacion) ? number_format($produccion->desviacion_estimacion, 0) : number_format($produccion->desviacion_estimacion, 2)) : '-' }} kg</dd>

                        <dt class="col-sm-4">Fecha Cosecha Real</dt>
                        <dd class="col-sm-8">{{ $produccion->fecha_cosecha_real ? $produccion->fecha_cosecha_real->format('d/m/Y') : '-' }}</dd>
                    </dl>
                </div>
            </div>

            <!-- Sección de Recolecciones Diarias -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-calendar-day"></i> Recolecciones Diarias</h5>
                    @if(in_array($produccion->estado, ['maduracion', 'cosecha']))
                        <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalRecoleccion">
                            <i class="fas fa-plus"></i> Nueva Recolección
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Estadísticas de Recolección -->
                    <div class="row mb-3" id="estadisticasRecoleccion">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Total Recolectado</h6>
                                <h4 class="text-success" id="totalRecolectado">{{ $produccion->total_recolectado == floor($produccion->total_recolectado) ? number_format($produccion->total_recolectado, 0) : number_format($produccion->total_recolectado, 2) }} kg</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Progreso</h6>
                                <h4 class="text-info" id="porcentajeCompletado">{{ $produccion->porcentaje_recoleccion_completado == floor($produccion->porcentaje_recoleccion_completado) ? number_format($produccion->porcentaje_recoleccion_completado, 0) : number_format($produccion->porcentaje_recoleccion_completado, 1) }}%</h4>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: {{ $produccion->porcentaje_recoleccion_completado }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Cantidad Pendiente</h6>
                                <h4 class="text-warning" id="cantidadPendiente">{{ $produccion->cantidad_pendiente_recoleccion == floor($produccion->cantidad_pendiente_recoleccion) ? number_format($produccion->cantidad_pendiente_recoleccion, 0) : number_format($produccion->cantidad_pendiente_recoleccion, 2) }} kg</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Días Recolectando</h6>
                                <h4 class="text-primary" id="diasRecolectando">{{ $produccion->recolecciones()->distinct('fecha_recoleccion')->count() }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Recolecciones -->
                    <div id="listaRecolecciones">
                        @if($produccion->recolecciones->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Cantidad (kg)</th>
                                            <th>Estado Fruto</th>
                                            <th>Clima</th>
                                            <th>Trabajadores</th>
                                            <th>Calidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($produccion->recolecciones()->activos()->orderBy('fecha_recoleccion', 'desc')->get() as $recoleccion)
                                        <tr>
                                            <td>{{ $recoleccion->fecha_recoleccion->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ $recoleccion->cantidad_recolectada == floor($recoleccion->cantidad_recolectada) ? number_format($recoleccion->cantidad_recolectada, 0) : number_format($recoleccion->cantidad_recolectada, 2) }} kg</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $recoleccion->badgeEstadoFruto['class'] }}">
                                                    <i class="fas fa-{{ $recoleccion->badgeEstadoFruto['icon'] }}"></i>
                                                    {{ ucfirst($recoleccion->estado_fruto) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $recoleccion->badgeClima['class'] }}">
                                                    <i class="fas fa-{{ $recoleccion->badgeClima['icon'] }}"></i>
                                                    {{ ucfirst($recoleccion->condiciones_climaticas) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $recoleccion->trabajadoresParticipantes()->count() }} trabajadores</small>
                                            </td>
                                            <td>
                                                @if($recoleccion->calidad_promedio)
                                                    <div class="d-flex align-items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $recoleccion->calidad_promedio ? 'text-warning' : 'text-muted' }}" style="font-size: 0.8rem;"></i>
                                                        @endfor
                                                    </div>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-info" onclick="verDetalleRecoleccion({{ $recoleccion->id }})">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="{{ route('recolecciones.edit', $recoleccion->id) }}" class="btn btn-sm btn-outline-warning">
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
                            <div class="text-center py-4">
                                <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay recolecciones registradas</h5>
                                <p class="text-muted">Comienza a registrar las recolecciones diarias de cacao</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ route('produccion.index') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>

<!-- Modal para Nueva Recolección -->
<div class="modal fade" id="modalRecoleccion" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-calendar-plus"></i> Registrar Nueva Recolección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRecoleccion" action="{{ route('recolecciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="produccion_id" value="{{ $produccion->id }}">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de Recolección <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="fecha_recoleccion" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cantidad Recolectada (kg) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="cantidad_recolectada" 
                                       step="0.001" min="0.001" max="9999.999" required
                                       placeholder="Ej: 25.5">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Estado del Fruto <span class="text-danger">*</span></label>
                                <select class="form-select" name="estado_fruto" required>
                                    <option value="">Seleccionar estado</option>
                                    <option value="maduro">Maduro</option>
                                    <option value="semi-maduro">Semi-maduro</option>
                                    <option value="verde">Verde</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Condiciones Climáticas <span class="text-danger">*</span></label>
                                <select class="form-select" name="condiciones_climaticas" required>
                                    <option value="">Seleccionar clima</option>
                                    <option value="soleado">Soleado</option>
                                    <option value="nublado">Nublado</option>
                                    <option value="lluvioso">Lluvioso</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Hora Inicio</label>
                                <input type="time" class="form-control" name="hora_inicio">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Hora Fin</label>
                                <input type="time" class="form-control" name="hora_fin">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Trabajadores Participantes <span class="text-danger">*</span></label>
                                <select class="form-select" name="trabajadores_participantes[]" multiple required>
                                    @foreach(\App\Models\Trabajador::activos()->get() as $trabajador)
                                        <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }} {{ $trabajador->apellido }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Mantén Ctrl presionado para seleccionar múltiples trabajadores</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Calidad Promedio (1-5)</label>
                                <select class="form-select" name="calidad_promedio">
                                    <option value="">Sin calificar</option>
                                    <option value="1">1 - Muy baja</option>
                                    <option value="2">2 - Baja</option>
                                    <option value="3">3 - Regular</option>
                                    <option value="4">4 - Buena</option>
                                    <option value="5">5 - Excelente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" name="observaciones" rows="3" 
                                  placeholder="Notas adicionales sobre la recolección..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning" id="btnGuardarRecoleccion">
                        <i class="fas fa-save"></i> Guardar Recolección
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Detalle de Horas Trabajadas -->
<div class="modal fade" id="modalDetalleHoras" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-clock"></i> Detalle de Horas Trabajadas - 
                    <span id="nombreTrabajadorModal"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-1">Total Horas</h6>
                                <h4 class="text-success mb-0" id="totalHorasModal">0h</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-1">Días Trabajados</h6>
                                <h4 class="text-info mb-0" id="diasTrabajadosModal">0</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-1">Promedio/Día</h6>
                                <h4 class="text-warning mb-0" id="promedioDiarioModal">0h</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-calendar-day"></i> Fecha</th>
                                <th><i class="fas fa-clock"></i> Horas</th>
                                <th><i class="fas fa-sign-in-alt"></i> Entrada</th>
                                <th><i class="fas fa-sign-out-alt"></i> Salida</th>
                                <th><i class="fas fa-map-marker-alt"></i> Lote</th>
                                <th><i class="fas fa-clipboard"></i> Observaciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDetalleHoras">
                            <!-- Se llenará dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
// Función para formatear números sin decimales innecesarios
function formatNumber(number, decimals = 2) {
    if (number == Math.floor(number)) {
        return Math.floor(number).toString();
    }
    return parseFloat(number).toFixed(decimals);
}

// Script para manejar el formulario de recolección
document.getElementById('formRecoleccion').addEventListener('submit', function(e) {
    const btn = document.getElementById('btnGuardarRecoleccion');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    btn.disabled = true;
});

// Función para ver detalle de recolección
function verDetalleRecoleccion(id) {
    // Aquí puedes implementar un modal de detalle o redireccionar
    window.location.href = `/recolecciones/${id}`;
}

// Función para mostrar detalle de horas trabajadas
function mostrarDetalleHoras(trabajadorId, nombreTrabajador) {
    // Obtener el botón que se presionó para acceder a los datos
    const boton = event.target.closest('button');
    const asistenciasData = JSON.parse(boton.getAttribute('data-asistencias'));
    
    // Actualizar el título del modal
    document.getElementById('nombreTrabajadorModal').textContent = nombreTrabajador;
    
    // Calcular estadísticas
    const totalHoras = asistenciasData.reduce((sum, asistencia) => sum + parseFloat(asistencia.horas_trabajadas || 0), 0);
    const diasTrabajados = asistenciasData.length;
    const promedioDiario = diasTrabajados > 0 ? totalHoras / diasTrabajados : 0;
    
    // Actualizar estadísticas en el modal con formato mejorado
    document.getElementById('totalHorasModal').textContent = formatNumber(totalHoras, 1) + 'h';
    document.getElementById('diasTrabajadosModal').textContent = diasTrabajados;
    document.getElementById('promedioDiarioModal').textContent = formatNumber(promedioDiario, 1) + 'h';
    
    // Llenar la tabla de detalle
    const tbody = document.getElementById('tablaDetalleHoras');
    tbody.innerHTML = '';
    
    if (asistenciasData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                    <i class="fas fa-calendar-times fa-2x mb-2"></i>
                    <p class="mb-0">No hay registros de asistencia en este período</p>
                </td>
            </tr>
        `;
    } else {
        // Ordenar por fecha descendente
        asistenciasData.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));
        
        asistenciasData.forEach(asistencia => {
            const fecha = new Date(asistencia.fecha);
            const fechaFormateada = fecha.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            
            const horaEntrada = asistencia.hora_entrada || '-';
            const horaSalida = asistencia.hora_salida || '-';
            const horas = parseFloat(asistencia.horas_trabajadas || 0);
            const observaciones = asistencia.observaciones || '-';
            
            // Determinar color según las horas trabajadas
            let badgeClass = 'bg-secondary';
            if (horas >= 8) badgeClass = 'bg-success';
            else if (horas >= 6) badgeClass = 'bg-warning';
            else if (horas > 0) badgeClass = 'bg-info';
            
            const row = `
                <tr>
                    <td>
                        <span class="fw-bold">${fechaFormateada}</span>
                        <br><small class="text-muted">${fecha.toLocaleDateString('es-ES', { weekday: 'long' })}</small>
                    </td>
                    <td>
                        <span class="badge ${badgeClass}">
                            <i class="fas fa-clock me-1"></i>
                            ${formatNumber(horas, 1)}h
                        </span>
                    </td>
                    <td>
                        <span class="text-success">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            ${horaEntrada}
                        </span>
                    </td>
                    <td>
                        <span class="text-danger">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            ${horaSalida}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-primary">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $produccion->lote?->nombre ?? 'Sin lote' }}
                        </span>
                    </td>
                    <td>
                        <small class="text-muted">${observaciones}</small>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalDetalleHoras'));
    modal.show();
}

// Actualizar estadísticas cada vez que se registra una nueva recolección
function actualizarEstadisticas() {
    fetch(`/recolecciones/produccion/{{ $produccion->id }}/estadisticas`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalRecolectado').textContent = `${formatNumber(data.total_recolectado)} kg`;
            document.getElementById('porcentajeCompletado').textContent = `${formatNumber(data.porcentaje_completado, 1)}%`;
            document.getElementById('cantidadPendiente').textContent = `${formatNumber(data.cantidad_pendiente)} kg`;
            document.getElementById('diasRecolectando').textContent = data.dias_recolectando;
            
            // Actualizar barra de progreso
            const progressBar = document.querySelector('.progress-bar');
            progressBar.style.width = `${data.porcentaje_completado}%`;
        });
}

// Función para formatear fechas
function formatearFecha(fecha) {
    const opciones = { 
        year: 'numeric', 
        month: '2-digit', 
        day: '2-digit' 
    };
    return new Date(fecha).toLocaleDateString('es-ES', opciones);
}

// Función para formatear horas
function formatearHora(hora) {
    if (!hora) return '-';
    return hora.substring(0, 5); // Solo HH:MM
}
</script>
@endsection
