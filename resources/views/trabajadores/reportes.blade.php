@extends('layouts.masterr')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/trabajador/reportes.css') }}?v={{ time() }}">
@endsection

@section('content')

<div class="container-fluid reportes-container">
    <!-- Header con diseño café -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm reportes-header-card">
                <div class="card-body py-4">
                    <!-- Botones de navegación -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center btn-nav-volver">
                                <i class="fas fa-arrow-left me-2"></i>
                                <span>Volver a Trabajadores</span>
                            </a>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm d-flex align-items-center btn-nav-asistencia">
                                <i class="far fa-clock me-1"></i>
                                <span>Asistencia</span>
                            </a>
                            <a href="{{ route('trabajadores.listar-asistencias') }}" class="btn btn-sm d-flex align-items-center btn-nav-listado">
                                <i class="fas fa-list me-1"></i>
                                <span>Listado</span>
                            </a>
                        </div>
                    </div>

                    <!-- Título principal centrado -->
                    <div class="text-center">
                        <h1 class="mb-2 titulo-reportes">
                            <i class="fas fa-file-alt me-3"></i>
                            Generación de Reportes
                        </h1>
                        <p class="mb-0 subtitulo-reportes">
                            Genera reportes detallados de asistencias y trabajadores
                        </p>
                        <div class="mt-3 decoracion-reportes">
                            <span class="emoji-principal">📊</span>
                            <span class="punto-separador">●</span>
                            <span class="emoji-secundario">📈</span>
                            <span class="punto-separador">●</span>
                            <span class="emoji-principal">📊</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm reportes-main-card">
        <div class="card-header d-flex align-items-center reportes-card-header">
            <i class="fas fa-file-alt me-2"></i>
            <span>Seleccione los parámetros del reporte</span>
        </div>
        <div class="card-body p-4 reportes-card-body">
            <form action="{{ route('trabajadores.generar-reporte-asistencia') }}" method="GET">
                <div class="row">
                    <!-- Tipo de Reporte -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label-reportes">
                            <i class="fas fa-chart-bar me-1"></i>
                            Tipo de Reporte
                        </label>
                        <select name="tipo_reporte" class="form-select form-select-reportes" required>
                            <option value="asistencia">Reporte de Asistencia</option>
                            <option value="todos">Todos los Trabajadores</option>
                        </select>
                    </div>

                    <!-- Trabajador -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label-reportes">
                            <i class="fas fa-user me-1"></i>
                            Trabajador (Opcional)
                        </label>
                        <select name="trabajador_id" class="form-select form-select-reportes">
                            <option value="">Todos los trabajadores</option>
                            @foreach(\App\Models\Trabajador::with('user')->get() as $trabajador)
                                <option value="{{ $trabajador->id }}">
                                    {{ $trabajador->user->name }} - {{ $trabajador->user->identificacion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fecha Inicio -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label-reportes">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Fecha Inicio
                        </label>
                        <div class="input-group">
                            <input type="date" name="fecha_inicio" class="form-control form-control-reportes" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required>
                            <span class="input-group-text input-group-text-reportes">
                                <i class="far fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Fecha Fin -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label-reportes">
                            <i class="fas fa-calendar-check me-1"></i>
                            Fecha Fin
                        </label>
                        <div class="input-group">
                            <input type="date" name="fecha_fin" class="form-control form-control-reportes" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                            <span class="input-group-text input-group-text-reportes">
                                <i class="far fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-generar-reporte">
                        <i class="fas fa-file-export me-2"></i>Generar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
