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

                        <dt class="col-sm-4">Área Asignada (ha)</dt>
                        <dd class="col-sm-8">{{ number_format($produccion->area_asignada, 2) }}</dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-{{ $produccion->estado == 'completado' ? 'success' : ($produccion->estado == 'planificado' ? 'secondary' : 'warning') }}">
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
                <div class="card-header bg-info text-white">
                    <h5><i class="fas fa-users"></i> Trabajadores Asignados</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th>Horas Trabajadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produccion->trabajadores as $trabajador)
                                <tr>
                                    <td>{{ $trabajador->user->name ?? $trabajador->nombre }}</td>
                                    <td>{{ $trabajador->pivot->rol ?? '-' }}</td>
                                    <td>{{ $trabajador->pivot->horas_trabajadas ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">Sin trabajadores asignados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5><i class="fas fa-box"></i> Insumos Utilizados</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Lote</th>
                                <th>Insumo</th>
                                <th>Cantidad</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produccion->salidaInventarios as $salida)
                                <tr>
                                    <td>{{ $salida->lote?->nombre ?? '-' }}</td>
                                    <td>{{ $salida->insumo?->nombre ?? '-' }}</td>
                                    <td>{{ $salida->cantidad }}</td>
                                    <td>${{ number_format($salida->precio_unitario * $salida->cantidad, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">Sin insumos registrados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-chart-line"></i> Métricas de Rendimiento</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Estimación Producción</dt>
                        <dd class="col-sm-8">{{ number_format($produccion->estimacion_produccion, 2) }} kg</dd>

                        <dt class="col-sm-4">Cantidad Cosechada</dt>
                        <dd class="col-sm-8">{{ number_format($produccion->cantidad_cosechada, 2) ?? '-' }} kg</dd>

                        <dt class="col-sm-4">Rendimiento Real</dt>
                        <dd class="col-sm-8">{{ number_format($produccion->rendimiento_real, 2) ?? '-' }} %</dd>

                        <dt class="col-sm-4">Desviación Estimación</dt>
                        <dd class="col-sm-8">{{ number_format($produccion->desviacion_estimacion, 2) ?? '-' }} kg</dd>

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
                                <h4 class="text-success" id="totalRecolectado">{{ number_format($produccion->total_recolectado, 2) }} kg</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Progreso</h6>
                                <h4 class="text-info" id="porcentajeCompletado">{{ $produccion->porcentaje_recoleccion_completado }}%</h4>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: {{ $produccion->porcentaje_recoleccion_completado }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h6 class="text-muted">Cantidad Pendiente</h6>
                                <h4 class="text-warning" id="cantidadPendiente">{{ number_format($produccion->cantidad_pendiente_recoleccion, 2) }} kg</h4>
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
                                                <span class="badge bg-success">{{ number_format($recoleccion->cantidad_recolectada, 2) }} kg</span>
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

<script>
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

// Actualizar estadísticas cada vez que se registra una nueva recolección
function actualizarEstadisticas() {
    fetch(`/recolecciones/produccion/{{ $produccion->id }}/estadisticas`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalRecolectado').textContent = `${data.total_recolectado} kg`;
            document.getElementById('porcentajeCompletado').textContent = `${data.porcentaje_completado}%`;
            document.getElementById('cantidadPendiente').textContent = `${data.cantidad_pendiente} kg`;
            document.getElementById('diasRecolectando').textContent = data.dias_recolectando;
            
            // Actualizar barra de progreso
            const progressBar = document.querySelector('.progress-bar');
            progressBar.style.width = `${data.porcentaje_completado}%`;
        });
}
</script>
@endsection
