@extends('layouts.masterr')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/trabajador/reportes-unificados.css') }}">
@endpush

@section('content')
<div class="container-fluid main-container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm header-card">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center btn-nav-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            <span>Volver a Trabajadores</span>
                        </a>
                    </div>

                    <div class="text-center">
                        <h1 class="mb-2 text-white">
                            <i class="fas fa-chart-line me-3"></i>
                            Centro de Reportes Unificados
                        </h1>
                        <p class="mb-0 text-white-50">
                            Análisis completo de trabajadores y asistencia
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas de reportes -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <nav>
                        <div class="nav nav-tabs nav-tabs-cafe" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-asistencia-tab" data-bs-toggle="tab" data-bs-target="#nav-asistencia" type="button" role="tab">
                                <i class="fas fa-calendar-check me-2"></i> Reporte de Asistencia
                            </button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de las pestañas -->
    <div class="tab-content" id="nav-tabContent">
        <!-- Pestaña: Reporte de Asistencia -->
        <div class="tab-pane fade show active" id="nav-asistencia" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-gradient-cafe text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-clipboard-list me-2"></i> Reporte Detallado de Asistencia
                                </h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-light btn-sm" onclick="exportarAsistenciaExcel()">
                                        <i class="fas fa-file-excel me-1"></i> Excel
                                    </button>
                                    <button class="btn btn-outline-light btn-sm" onclick="exportarAsistenciaPDF()">
                                        <i class="fas fa-file-pdf me-1"></i> PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filtros para reporte de asistencia -->
                            <form id="formFiltrosAsistencia" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Período</label>
                                        <select class="form-select" id="periodo_asistencia">
                                            <option value="semana">Esta semana</option>
                                            <option value="mes">Este mes</option>
                                            <option value="personalizado">Personalizado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="fechas-personalizadas" style="display: none;">
                                        <label class="form-label">Fecha Desde</label>
                                        <input type="date" class="form-control" id="fecha_desde_asistencia">
                                    </div>
                                    <div class="col-md-3" id="fechas-personalizadas-hasta" style="display: none;">
                                        <label class="form-label">Fecha Hasta</label>
                                        <input type="date" class="form-control" id="fecha_hasta_asistencia">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Trabajador</label>
                                        <select class="form-select" id="trabajador_asistencia">
                                            <option value="">Todos</option>
                                            @foreach($trabajadores as $trabajador)
                                                <option value="{{ $trabajador->id }}">{{ $trabajador->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary" onclick="generarReporteAsistencia()">
                                            <i class="fas fa-chart-line me-1"></i> Generar Reporte
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Resumen de asistencia -->
                            <div class="row mb-4" id="resumenAsistencia">
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4 id="total-presentes">-</h4>
                                            <p class="mb-0">Total Presentes</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h4 id="total-tardanzas">-</h4>
                                            <p class="mb-0">Tardanzas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body text-center">
                                            <h4 id="total-ausentes">-</h4>
                                            <p class="mb-0">Ausentes</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4 id="porcentaje-asistencia">-</h4>
                                            <p class="mb-0">% Asistencia</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gráfico de asistencia -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Tendencia de Asistencia</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="graficoTendenciaAsistencia"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Distribución de Estados</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="graficoDistribucionEstados"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla detallada -->
                            <div id="tablaDetalladaAsistencia">
                                <!-- Se llena dinámicamente -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/trabajador/reportes-unificados.js') }}"></script>
@endsection
