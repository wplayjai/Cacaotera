@extends('layouts.masterr')

@section('content')
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

<style>
/* Paleta de colores inspirada en cacao */
:root {
    --cacao-dark: #3E2723;
    --cacao-medium: #6D4C41;
    --cacao-light: #A1887F;
    --cacao-cream: #D7CCC8;
    --cacao-pale: #EFEBE9;
    --cacao-accent: #795548;
    --cacao-green: #4E6E41;
    --cacao-light-green: #85A878;
}

body {
    background-color: var(--cacao-pale);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h2.text-cacao {
    color: var(--cacao-dark);
    font-weight: 600;
    border-bottom: 2px solid var(--cacao-light);
    padding-bottom: 0.5rem;
}

.cacao-card {
    border: none;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.cacao-header {
    background-color: var(--cacao-medium);
    color: white;
    font-weight: 500;
    padding: 0.75rem 1.25rem;
}

.cacao-btn-secondary {
    background-color: var(--cacao-light);
    border: none;
    color: white;
    transition: all 0.2s ease;
}

.cacao-btn-secondary:hover {
    background-color: var(--cacao-accent);
    color: white;
}

.cacao-btn-success {
    background-color: var(--cacao-green);
    border: none;
    color: white;
    transition: all 0.2s ease;
}

.cacao-btn-success:hover {
    background-color: var(--cacao-light-green);
    color: white;
}

.cacao-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

.cacao-table thead th {
    background-color: var(--cacao-medium);
    color: white;
    border-color: var(--cacao-light);
    font-weight: 500;
    padding: 0.75rem;
}

.cacao-table tbody tr:nth-child(odd) {
    background-color: var(--cacao-pale);
}

.cacao-table tbody tr:nth-child(even) {
    background-color: white;
}

.cacao-table td {
    padding: 0.75rem;
    vertical-align: middle;
    border-color: var(--cacao-cream);
}

.cacao-progress-container {
    position: relative;
    background-color: var(--cacao-cream);
    height: 24px;
    border-radius: 12px;
    overflow: hidden;
}

.cacao-progress {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    background-color: var(--cacao-accent);
    transition: width 0.3s ease;
}

.cacao-progress-text {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--cacao-dark);
    font-weight: 500;
    font-size: 0.875rem;
}

.cacao-hours-badge {
    background-color: var(--cacao-medium);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
}

.cacao-time-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
}

.cacao-time-badge.in {
    background-color: var(--cacao-accent);
    color: white;
}

.cacao-time-badge.out {
    background-color: var(--cacao-light);
    color: white;
}

.cacao-na {
    color: var(--cacao-light);
    font-style: italic;
}

.cacao-badge {
    background-color: var(--cacao-cream);
    color: var(--cacao-dark);
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-size: 0.75rem;
    margin-left: 0.5rem;
}

.cacao-empty-message {
    color: var(--cacao-medium);
    font-style: italic;
    padding: 1rem;
}

/* Importación de Font Awesome si no está ya en tu layout */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>
@endsection