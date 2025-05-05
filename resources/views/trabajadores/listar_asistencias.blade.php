@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Listado de Asistencias</h2>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Filtrar</span>
            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-primary btn-sm">Registrar Nueva Asistencia</a>
        </div>
        <div class="card-body">
            <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <label>Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ $fecha_inicio }}">
                    </div>
                    
                    <div class="col-md-5">
                        <label>Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ $fecha_fin }}">
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            Resultados ({{ $asistencias->count() }} registros)
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Trabajador</th>
                           
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
        <div class="card-footer">
            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-success">Generar Reportes</a>
        </div>
    </div>
</div>
@endsection