@extends('layouts.masterr')

@section('content')
<div class="container">
    <h2 class="mb-4">Reporte de Asistencia</h2>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Periodo: {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</span>
            <div>
                <a href="{{ route('trabajadores.reportes') }}" class="btn btn-secondary btn-sm me-2">Nuevo Reporte</a>
                <form action="{{ route('trabajadores.exportar-reporte-asistencia') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="fecha_inicio" value="{{ $fecha_inicio }}">
                    <input type="hidden" name="fecha_fin" value="{{ $fecha_fin }}">
                    @if(request()->has('trabajador_id'))
                        <input type="hidden" name="trabajador_id" value="{{ request('trabajador_id') }}">
                    @endif
                    <button type="submit" class="btn btn-success btn-sm">Exportar PDF</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            Estadísticas de Asistencia
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Trabajador</th>
                            <th>Total Asistencias</th>
                            <th>% Asistencia</th>
                            <th>Horas Trabajadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estadisticas as $estadistica)
                            <tr>
                                <td>{{ $estadistica['trabajador'] }}</td>
                                <td>{{ $estadistica['total_asistencias'] }}</td>
                                <td>{{ $estadistica['porcentaje_asistencia'] }}%</td>
                                <td>{{ $estadistica['horas_trabajadas'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            Detalle de Asistencias ({{ $asistencias->count() }} registros)
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Trabajador</th>
                            <th>Identificación</th>
                            <th>Fecha</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Horas</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asistencias as $asistencia)
                            <tr>
                                <td>{{ $asistencia->trabajador->user->name }}</td>
                                <td>{{ $asistencia->trabajador->user->identificacion }}</td>
                                <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : 'N/A' }}</td>
                                <td>{{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : 'N/A' }}</td>
                                <td>
                                    @if($asistencia->hora_entrada && $asistencia->hora_salida)
                                        {{ \Carbon\Carbon::parse($asistencia->hora_entrada)->diffInHours(\Carbon\Carbon::parse($asistencia->hora_salida)) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $asistencia->observaciones ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay registros de asistencia en el periodo seleccionado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection