@extends('layouts.masterr')

@section('styles')
<head>
    <link rel="stylesheet" href="{{ asset('css/trabajador/listar.css') }}">
</head>
@endsection

@section('content')
<script src="{{ asset('js/trabajador/listar.js') }}" defer></script>

<div class="container">
    <h2 class="mb-4">Listado de Asistencias</h2>
    
    <!-- Filtro -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-filter me-2"></i>Filtrar</span>
            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle me-1"></i>Registrar Nueva Asistencia
            </a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label><i class="far fa-calendar-minus me-1"></i>Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ $fecha_inicio }}">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label><i class="far fa-calendar-plus me-1"></i>Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ $fecha_fin }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="fas fa-search me-1"></i>Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-clipboard-list me-2"></i>Resultados 
                <span class="badge rounded-pill" style="background-color: var(--cocoa-light); color: var(--cocoa-dark);">
                    {{ $asistencias->count() }} registros
                </span>
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
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
                                <td><strong>{{ $asistencia->trabajador->user->name }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($asistencia->hora_entrada && $asistencia->hora_salida)
                                        <span class="badge bg-warning text-dark rounded-pill">
                                            <i class="far fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($asistencia->hora_entrada)->diffInHours(\Carbon\Carbon::parse($asistencia->hora_salida)) }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asistencia->observaciones)
                                        <span title="{{ $asistencia->observaciones }}">
                                            {{ \Illuminate\Support\Str::limit($asistencia->observaciones, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-exclamation-circle me-2 text-warning"></i>
                                    No hay registros de asistencia en el periodo seleccionado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>Actualizado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </small>
            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Generar Reportes
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
