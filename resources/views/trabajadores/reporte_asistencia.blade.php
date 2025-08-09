@extends('layouts.masterr')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/trabajador/reporte.css') }}?v={{ time() }}">
@endsection

@section('content')

<div class="container-fluid reporte-container">
    <!-- Header con diseño café -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm cafe-header-card">
                <div class="card-body py-4">
                    <!-- Botones de navegación -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center btn-nav-primary">
                                <i class="fas fa-arrow-left me-2 icono-cafe" style="font-size: 0.9rem;"></i>
                                <span>Volver a Trabajadores</span>
                            </a>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm d-flex align-items-center btn-nav-asistencia">
                                <i class="far fa-clock me-1" style="font-size: 0.8rem;"></i>
                                <span style="font-size: 0.9rem;">Asistencia</span>
                            </a>
                            <a href="{{ route('trabajadores.listar-asistencias') }}" class="btn btn-sm d-flex align-items-center btn-nav-listado">
                                <i class="fas fa-list me-1" style="font-size: 0.8rem;"></i>
                                <span style="font-size: 0.9rem;">Listado</span>
                            </a>
                            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-sm d-flex align-items-center btn-nav-reportes {{ request()->routeIs('trabajadores.reporte-asistencia') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar me-1" style="font-size: 0.8rem;"></i>
                                <span style="font-size: 0.9rem;">Reportes</span>
                            </a>

                    <!-- Título principal centrado -->
                    <div class="text-center">
                        <h1 class="mb-2 titulo-principal">
                            <i class="fas fa-chart-line me-3 icono-cafe"></i>
                            Reporte de Asistencia
                        </h1>
                        <p class="mb-0 subtitulo-principal">
                            Análisis detallado de asistencias y estadísticas
                        </p>
                        <div class="decoracion-emojis">
                            <span class="emoji-grande" style="color: #a0845c;">📊</span>
                            <span class="punto-separador">●</span>
                            <span class="emoji-grande" style="color: #6b4e3d;">📈</span>
                            <span class="punto-separador">●</span>
                            <span class="emoji-grande" style="color: #a0845c;">📋</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cabecera del reporte -->
    <div class="card border-0 shadow-sm mb-4 card-contenido">
        <div class="card-header d-flex justify-content-between align-items-center card-header-cafe">
            <span class="icono-blanco" style="font-weight: 600;">
                <i class="far fa-calendar-alt me-2 icono-cafe"></i>
                @if(isset($fecha_inicio) && isset($fecha_fin))
                    Periodo: {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}
                @else
                    Periodo no definido
                @endif
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('trabajadores.reportes') }}" class="btn btn-sm btn-nuevo-reporte">
                    <i class="fas fa-plus-circle me-1 icono-cafe-oscuro"></i>Nuevo Reporte
                </a>
                @if(isset($fecha_inicio) && isset($fecha_fin))
                    <form action="{{ route('trabajadores.exportar-reporte-asistencia') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="fecha_inicio" value="{{ $fecha_inicio }}">
                        <input type="hidden" name="fecha_fin" value="{{ $fecha_fin }}">
                        @if(request()->has('trabajador_id'))
                            <input type="hidden" name="trabajador_id" value="{{ request('trabajador_id') }}">
                        @endif
                        <button type="submit" class="btn btn-sm btn-exportar-pdf">
                            <i class="fas fa-file-pdf me-1 icono-blanco"></i>Exportar PDF
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    @if(isset($estadisticas) && count($estadisticas) > 0)
        <div class="card border-0 shadow-sm mb-4 card-contenido">
            <div class="card-header card-header-cafe">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2 icono-cafe"></i>Estadísticas de Asistencia
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 tabla-estadisticas">
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
                                    <td class="nombre-trabajador">{{ $estadistica['trabajador'] }}</td>
                                    <td class="dato-numerico">
                                        <span class="badge badge-asistencias">
                                            {{ $estadistica['total_asistencias'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress-bar-custom">
                                            <div class="progress-fill-custom" style="width: {{ $estadistica['porcentaje_asistencia'] }}%;"></div>
                                            <span class="progress-text-custom">{{ $estadistica['porcentaje_asistencia'] }}%</span>
                                        </div>
                                    </td>
                                    <td class="dato-numerico">
                                        <span class="badge badge-horas">
                                            <i class="far fa-clock me-1 icono-blanco"></i>{{ $estadistica['horas_trabajadas'] }}h
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm mb-4 card-contenido">
            <div class="card-body sin-datos">
                <i class="fas fa-chart-bar icono me-2"></i>
                <span class="mensaje">No hay datos estadísticos disponibles para el periodo seleccionado.</span>
            </div>
        </div>
    @endif

    <!-- Detalle de asistencias -->
    <div class="card border-0 shadow-sm card-contenido">
        <div class="card-header d-flex justify-content-between align-items-center card-header-cafe">
            <span class="icono-blanco" style="font-weight: 600;">
                <i class="fas fa-list-alt me-2 icono-cafe"></i>Detalle de Asistencias
            </span>
            <span class="badge badge-contador">{{ is_countable($asistencias) ? count($asistencias) : $asistencias->count() }} registros</span>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped mb-0 tabla-detalle">
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
                                <td class="nombre-trabajador">{{ $asistencia->trabajador->user->name }}</td>
                                <td class="identificacion">{{ $asistencia->trabajador->user->identificacion }}</td>
                                <td class="fecha">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                <td>
                                    @if($asistencia->hora_entrada)
                                        <span class="badge badge-hora-entrada">
                                            <i class="fas fa-sign-in-alt me-1 icono-cafe-medio"></i>{{ \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="texto-na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asistencia->hora_salida)
                                        <span class="badge badge-hora-salida">
                                            <i class="fas fa-sign-out-alt me-1 icono-cafe-medio"></i>{{ \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="texto-na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asistencia->hora_entrada && $asistencia->hora_salida)
                                        @php
                                            $entrada = \Carbon\Carbon::parse($asistencia->hora_entrada);
                                            $salida = \Carbon\Carbon::parse($asistencia->hora_salida);
                                            $horas = $entrada->diffInHours($salida);
                                            $minutos = $entrada->diffInMinutes($salida) % 60;
                                        @endphp
                                        <span class="badge badge-horas-calculadas">
                                            <i class="far fa-clock me-1 icono-cafe-oscuro"></i>{{ $horas }}h{{ $minutos > 0 ? ' '.$minutos.'m' : '' }}
                                        </span>
                                    @else
                                        <span class="texto-na">N/A</span>
                                    @endif
                                </td>
                                <td class="observaciones">{{ $asistencia->observaciones ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 sin-datos">
                                    <i class="fas fa-exclamation-circle me-2 icono"></i>
                                    <span class="mensaje">No hay registros de asistencia en el periodo seleccionado</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
