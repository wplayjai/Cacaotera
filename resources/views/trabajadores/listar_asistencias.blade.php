@extends('layouts.masterr')
@section('styles')
@endsection
@section('content')
<head>
     <link rel="stylesheet" href="{{ asset('css/trabajador/listar.css') }}">
</head>
<script src="{{ asset('js/trabajador/listar.js') }}" defer></script>
<div class="container">
    <h2>Listado de Asistencias</h2>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-filter me-2"></i>Filtrar</span>
            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle me-1"></i>Registrar Nueva Asistencia
            </a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                <div class="row">
                    <div class="col-md-5 mb-3 mb-md-0">
                        <label>
                            <i class="far fa-calendar-minus me-1"></i>Fecha Inicio
                        </label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ $fecha_inicio }}">
                    </div>
                    
                    <div class="col-md-5 mb-3 mb-md-0">
                        <label>
                            <i class="far fa-calendar-plus me-1"></i>Fecha Fin
                        </label>
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
    
    <div class="card">
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
                                <td>
                                    <span style="font-weight: 500;">{{ $asistencia->trabajador->user->name }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge" style="background-color: rgba(118, 82, 59, 0.15); color: var(--cocoa-medium); padding: 5px 8px;">
                                        <i class="fas fa-sign-in-alt me-1" style="color: inherit;"></i>
                                        {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: rgba(118, 82, 59, 0.15); color: var(--cocoa-medium); padding: 5px 8px;">
                                        <i class="fas fa-sign-out-alt me-1" style="color: inherit;"></i>
                                        {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($asistencia->hora_entrada && $asistencia->hora_salida)
                                        <span class="badge rounded-pill" style="background-color: var(--cocoa-light); color: var(--cocoa-dark); padding: 5px 10px;">
                                            <i class="far fa-clock me-1" style="color: inherit;"></i>
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
                                    <i class="fas fa-exclamation-circle me-2" style="color: var(--cocoa-accent); font-size: 1.25rem;"></i>
                                    No hay registros de asistencia en el periodo seleccionado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                <i class="fas fa-info-circle me-1"></i>Actualizado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </div>
            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Generar Reportes
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection