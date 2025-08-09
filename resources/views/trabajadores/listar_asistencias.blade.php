@extends('layouts.masterr')

@section('styles')
    <!-- Múltiples fuentes de Font Awesome para asegurar carga -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="stylesheet" href="{{ asset('css/trabajador/listar.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="listar-asistencias-container listar-asistencias-container-specific">
    <div class="container-fluid">
        <!-- Header con diseño café -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm cafe-header-card cafe-header-card-specific">
                    <div class="card-body py-4">
                        <!-- Botones de navegación -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex gap-3">
                                <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center btn-nav-primary btn-nav-primary-specific">
                                    <i class="fas fa-users me-2 icon-font-size-09"></i>
                                    <span>Trabajadores</span>
                                </a>
                                <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm d-flex align-items-center btn-nav-asistencia btn-nav-asistencia-specific">
                                    <i class="fas fa-arrow-left me-2 icon-font-size-09"></i>
                                    <span>Volver a Asistencia</span>
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('trabajadores.reportes') }}" class="btn btn-sm d-flex align-items-center btn-nav-reportes btn-nav-reportes-specific">
                                    <i class="fas fa-chart-bar me-1 icon-font-size-08"></i>
                                    <span class="text-font-size-09">Reportes</span>
                                </a>
                            </div>
                        </div>

                    <!-- Título principal centrado -->
                    <div class="text-center">
                        <h1 class="mb-2 titulo-principal titulo-principal-specific">
                            <i class="fas fa-clipboard-list me-3 icono-cafe icono-cafe-specific"></i>
                            Listado de Asistencias
                        </h1>
                        <p class="mb-0 subtitulo-principal subtitulo-principal-specific">
                            Consulta y gestión de registros de asistencia
                        </p>
                        <div class="decoracion-emojis">
                            <span class="emoji-grande emoji-grande-cafe">📋</span>
                            <span class="punto-separador">●</span>
                            <span class="emoji-grande emoji-grande-medio">⏰</span>
                            <span class="punto-separador">●</span>
                            <span class="emoji-grande emoji-grande-cafe">📋</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtro -->
    <div class="card mb-4 shadow-sm border-0 card-contenido card-contenido-specific">
        <div class="card-header d-flex justify-content-between align-items-center card-header-cafe card-header-cafe-specific">
            <span class="icono-blanco icono-blanco-specific">
                <i class="fas fa-filter me-2 icono-cafe icono-cafe-specific"></i>Filtrar
            </span>
            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm btn-nuevo-reporte btn-nuevo-reporte-specific">
                <i class="fas fa-plus-circle me-1 icono-cafe-oscuro icono-cafe-oscuro-specific"></i>Registrar Nueva Asistencia
            </a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label fw-bold form-label-cafe form-label-cafe-specific">
                            <i class="far fa-calendar-minus me-1 icono-cafe-medio icono-cafe-medio-specific"></i>Fecha Inicio
                        </label>
                        <input type="date" name="fecha_inicio" class="form-control border-2 form-control-cafe form-control-cafe-specific" value="{{ $fecha_inicio }}">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label fw-bold form-label-cafe form-label-cafe-specific">
                            <i class="far fa-calendar-plus me-1 icono-cafe-medio icono-cafe-medio-specific"></i>Fecha Fin
                        </label>
                        <input type="date" name="fecha_fin" class="form-control border-2 form-control-cafe form-control-cafe-specific" value="{{ $fecha_fin }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn w-100 btn-exportar-pdf btn-exportar-pdf-specific">
                            <i class="fas fa-search me-1 icono-blanco icono-blanco-specific"></i>Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    <div class="card border-0 shadow-sm card-contenido card-contenido-specific">
        <div class="card-header d-flex justify-content-between align-items-center card-header-cafe card-header-cafe-specific">
            <span class="icono-blanco icono-blanco-specific">
                <i class="fas fa-clipboard-list me-2 icono-cafe icono-cafe-specific"></i>Resultados
                <span class="badge badge-contador badge-contador-specific">
                    {{ is_countable($asistencias) ? count($asistencias) : $asistencias->count() }} registros
                </span>
            </span>
        </div>

        <div class="card-body p-0">
            @if ((is_countable($asistencias) ? count($asistencias) : $asistencias->count()) > 0)
                <div class="table-responsive table-responsive-specific">
                    <table class="table tabla-detalle mb-0 tabla-detalle-specific">
                        <thead class="thead-cafe thead-cafe-specific">
                            <tr>
                                <th>
                                    <i class="fas fa-user me-1 icono-blanco icono-blanco-specific"></i>Trabajador
                                </th>
                                <th>
                                    <i class="far fa-calendar me-1 icono-blanco icono-blanco-specific"></i>Fecha
                                </th>
                                <th>
                                    <i class="far fa-clock me-1 icono-blanco icono-blanco-specific"></i>Hora Entrada
                                </th>
                                <th>
                                    <i class="far fa-clock me-1 icono-blanco icono-blanco-specific"></i>Hora Salida
                                </th>
                                <th>
                                    <i class="fas fa-clock me-1 icono-blanco icono-blanco-specific"></i>Horas
                                </th>
                                <th>
                                    <i class="fas fa-file-alt me-1 icono-blanco icono-blanco-specific"></i>Observaciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($asistencias as $asistencia)
                            <tr class="fila-detalle fila-detalle-specific">
                                <td>
                                    <strong class="texto-cafe-oscuro texto-cafe-oscuro-specific">
                                        <i class="fas fa-user-tie me-1 icono-cafe-medio icono-cafe-medio-specific"></i>
                                        {{ $asistencia->trabajador->user->name }}
                                    </strong>
                                </td>
                                <td class="texto-cafe-oscuro texto-cafe-oscuro-specific">
                                    <i class="far fa-calendar-alt me-1 icono-cafe-medio icono-cafe-medio-specific"></i>
                                    {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="badge badge-entrada badge-entrada-specific">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-salida badge-salida-specific">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($asistencia->hora_entrada && $asistencia->hora_salida)
                                        @php
                                            $entrada = \Carbon\Carbon::parse($asistencia->hora_entrada);
                                            $salida = \Carbon\Carbon::parse($asistencia->hora_salida);
                                            $diferencia = $entrada->diff($salida);
                                            $horas = $diferencia->h;
                                            $minutos = $diferencia->i;
                                        @endphp
                                        <span class="badge badge-horas badge-horas-specific">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $horas }}h {{ $minutos }}m
                                        </span>
                                    @else
                                        <span class="texto-no-disponible texto-no-disponible-specific">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asistencia->observaciones)
                                        <span class="texto-observaciones texto-observaciones-specific" title="{{ $asistencia->observaciones }}">
                                            <i class="fas fa-comment-alt me-1 icono-cafe-medio icono-cafe-medio-specific"></i>
                                            {{ \Illuminate\Support\Str::limit($asistencia->observaciones, 30) }}
                                        </span>
                                    @else
                                        <span class="texto-no-disponible texto-no-disponible-specific">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="mensaje-sin-datos mensaje-sin-datos-specific">
                                    <i class="fas fa-exclamation-circle me-2 icono-cafe-medio icono-cafe-medio-specific"></i>
                                    <span class="texto-cafe-oscuro fw-bold texto-cafe-oscuro-specific">No hay registros de asistencia en el periodo seleccionado.</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mensaje-sin-datos p-4 mensaje-sin-datos-specific">
                    <i class="fas fa-exclamation-circle me-2 icono-cafe-medio icono-cafe-medio-specific"></i>
                    <span class="texto-cafe-oscuro fw-bold texto-cafe-oscuro-specific">No hay registros de asistencia disponibles.</span>
                </div>
            @endif
        </div>
        <div class="card-footer footer-cafe footer-cafe-specific">
            <small class="texto-actualizado texto-actualizado-specific">
                <i class="fas fa-info-circle me-1 icono-cafe-medio icono-cafe-medio-specific"></i>
                Actualizado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </small>
            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-generar-reportes btn-generar-reportes-specific">
                <i class="fas fa-file-excel me-2 icono-blanco icono-blanco-specific"></i>Generar Reportes
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/trabajador/listar.js') }}?v={{ time() }}"></script>
@endsection
