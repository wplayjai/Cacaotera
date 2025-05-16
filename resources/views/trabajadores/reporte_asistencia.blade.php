@extends('layouts.masterr')

@section('content')
<head>
     <link rel="stylesheet" href="{{ asset('css/trabajador/reporte.css') }}">
     
</head>
<div class="container">
    <h2 class="mb-4 text-cacao">Reporte de Asistencia</h2>
    
    <div class="card cacao-card mb-4">
        <div class="card-header cacao-header d-flex justify-content-between align-items-center">
            <span><i class="far fa-calendar-alt me-2"></i>Periodo: {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</span>
            <div>
                <a href="{{ route('trabajadores.reportes') }}" class="btn cacao-btn-secondary btn-sm me-2">
                    <i class="fas fa-plus-circle me-1"></i>Nuevo Reporte
                </a>
                <form action="{{ route('trabajadores.exportar-reporte-asistencia') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="fecha_inicio" value="{{ $fecha_inicio }}">
                    <input type="hidden" name="fecha_fin" value="{{ $fecha_fin }}">
                    @if(request()->has('trabajador_id'))
                        <input type="hidden" name="trabajador_id" value="{{ request('trabajador_id') }}">
                    @endif
                    <button type="submit" class="btn cacao-btn-success btn-sm">
                        <i class="fas fa-file-pdf me-1"></i>Exportar PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card cacao-card mb-4">
        <div class="card-header cacao-header">
            <i class="fas fa-chart-bar me-2"></i>Estadísticas de Asistencia
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table cacao-table table-bordered">
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
                                <td>
                                    <div class="cacao-progress-container">
                                        <div class="cacao-progress" style="width: {{ $estadistica['porcentaje_asistencia'] }}%"></div>
                                        <span class="cacao-progress-text">{{ $estadistica['porcentaje_asistencia'] }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="cacao-hours-badge">
                                        <i class="far fa-clock me-1"></i>{{ $estadistica['horas_trabajadas'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card cacao-card">
        <div class="card-header cacao-header">
            <i class="fas fa-list-alt me-2"></i>Detalle de Asistencias 
            <span class="cacao-badge">{{ $asistencias->count() }} registros</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table cacao-table table-striped">
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
                                <td>
                                    @if($asistencia->hora_entrada)
                                        <span class="cacao-time-badge in">
                                            <i class="fas fa-sign-in-alt me-1"></i>{{ \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="cacao-na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asistencia->hora_salida)
                                        <span class="cacao-time-badge out">
                                            <i class="fas fa-sign-out-alt me-1"></i>{{ \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="cacao-na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asistencia->hora_entrada && $asistencia->hora_salida)
                                        <span class="cacao-hours-badge">
                                            <i class="far fa-clock me-1"></i>{{ \Carbon\Carbon::parse($asistencia->hora_entrada)->diffInHours(\Carbon\Carbon::parse($asistencia->hora_salida)) }}
                                        </span>
                                    @else
                                        <span class="cacao-na">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $asistencia->observaciones ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center cacao-empty-message">No hay registros de asistencia en el periodo seleccionado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection