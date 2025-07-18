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
                                <th>Nombre del Insumo</th>
                                <th>Cantidad</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produccion->salidaInventarios as $salida)
                                <tr>
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

            <a href="{{ route('produccion.index') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection
