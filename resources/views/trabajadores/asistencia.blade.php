@extends('layouts.masterr')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/trabajador/asistencia.css') }}">
@endsection

@section('content')
<div class="container-fluid main-container">
    <!-- Header con diseño café -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm header-card">
                <div class="card-body py-4">
                    <!-- Botón de navegación -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center btn-nav-back">
                            <i class="fas fa-arrow-left me-2 icon-nav-back"></i>
                            <span class="text-nav-back">Volver a Trabajadores</span>
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('trabajadores.listar-asistencias') }}" class="btn btn-sm d-flex align-items-center" style="background: rgba(160, 132, 92, 0.2) !important; border: 2px solid #a0845c !important; color: #a0845c !important; border-radius: 20px !important; font-weight: 600 !important; padding: 6px 15px !important;">
                                <i class="fas fa-list me-1" style="color: #a0845c !important; font-size: 0.8rem;"></i>
                                <span style="color: #a0845c !important; font-size: 0.9rem;">Listado</span>
                            </a>
                            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-sm d-flex align-items-center" style="background: rgba(139, 111, 71, 0.2) !important; border: 2px solid #8b6f47 !important; color: #8b6f47 !important; border-radius: 20px !important; font-weight: 600 !important; padding: 6px 15px !important;">
                                <i class="fas fa-chart-bar me-1" style="color: #8b6f47 !important; font-size: 0.8rem;"></i>
                                <span style="color: #8b6f47 !important; font-size: 0.9rem;">Reportes</span>
                            </a>
                        </div>
                    </div>

                    <!-- Título principal centrado -->
                    <div class="text-center">
                        <h1 class="mb-2" style="color: white !important; font-weight: 600;">
                            <i class="far fa-clock me-3" style="color: #d4c4a0 !important;"></i>
                            Control de Asistencia
                        </h1>
                        <p class="mb-0" style="color: #d4c4a0 !important; font-size: 1.1rem;">
                            Gestión completa de asistencias de trabajadores
                        </p>
                        <div class="mt-3 header-decoration">
                            <span class="decoration-coffee">☕</span>
                            <span class="decoration-dot">●</span>
                            <span class="decoration-leaf">🌿</span>
                            <span class="decoration-dot">●</span>
                            <span class="decoration-coffee">☕</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center alert-success-custom">
            <i class="fas fa-check-circle me-2 alert-success-icon"></i>{{ session('success') }}
        </div>
    @endif
<script src="{{ asset('js/trabajador/asistencia.js') }}" defer></script>

    <div class="row">
        <!-- Formulario de Registro -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm form-card-registro">
                <div class="card-header form-card-registro-header">
                    <h5 class="mb-0 form-card-registro-title">
                        <i class="far fa-clock me-2 form-card-registro-icon"></i>Registrar Asistencia
                    </h5>
                </div>
                <div class="card-body p-4 form-card-registro-body">
                    <form action="{{ route('trabajadores.registrar-asistencia') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <label for="trabajador_id" class="col-md-2 col-form-label form-label-trabajador">
                                <i class="fas fa-user me-1 form-label-trabajador-icon"></i> Trabajador
                            </label>
                            <div class="col-md-10">
                                <select id="trabajador_id" name="trabajador_id" class="form-select form-select-trabajador" required>
                                    <option value="">Seleccione un trabajador</option>
                                    @foreach($trabajadores as $trabajador)
                                        <option value="{{ $trabajador->id }}">
                                            {{ $trabajador->user->name }} - {{ $trabajador->user->identificacion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fecha" class="col-md-2 col-form-label form-label-fecha">
                                <i class="far fa-calendar-alt me-1 form-label-fecha-icon"></i> Fecha
                            </label>
                            <div class="col-md-10">
                                <input type="date" id="fecha" name="fecha" class="form-control form-control-fecha" value="{{ $fecha_actual }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lote_id" class="col-md-2 col-form-label form-label-lote">
                                <i class="fas fa-map-marker-alt me-1 form-label-lote-icon"></i> Lote
                            </label>
                            <div class="col-md-10">
                                <select id="lote_id" name="lote_id" class="form-select form-select-lote" required>
                                    <option value="">Seleccione el lote donde trabajó</option>
                                    @foreach(\App\Models\Lote::activos()->orderBy('nombre')->get() as $lote)
                                        <option value="{{ $lote->id }}">
                                            {{ $lote->nombre_completo }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text form-help-lote">
                                    <i class="fas fa-info-circle me-1 form-help-lote-icon"></i>
                                    Especifique en qué lote realizó las actividades laborales
                                </small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hora_entrada" class="col-md-2 col-form-label form-label-entrada">
                                <i class="fas fa-sign-in-alt me-1 form-label-entrada-icon"></i> Entrada
                            </label>
                            <div class="col-md-4">
                                <input type="time" id="hora_entrada" name="hora_entrada" class="form-control form-control-hora" required>
                            </div>

                            <label for="hora_salida" class="col-md-2 col-form-label form-label-salida">
                                <i class="fas fa-sign-out-alt me-1 form-label-salida-icon"></i> Salida
                            </label>
                            <div class="col-md-4">
                                <input type="time" id="hora_salida" name="hora_salida" class="form-control form-control-hora" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="observaciones" class="col-md-2 col-form-label form-label-observaciones">
                                <i class="far fa-comment-alt me-1 form-label-observaciones-icon"></i> Observaciones
                            </label>
                            <div class="col-md-10">
                                <textarea id="observaciones" name="observaciones" class="form-control form-textarea-observaciones" rows="3" placeholder="Ingrese comentarios adicionales aquí..."></textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-form-submit">
                                <i class="fas fa-save me-2 btn-form-submit-icon"></i>Registrar Asistencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Consulta de Asistencias -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm form-card-consulta">
                <div class="card-header d-flex justify-content-between align-items-center form-card-consulta-header">
                    <span class="form-card-consulta-title">
                        <i class="fas fa-search me-2 form-card-consulta-icon"></i>Consulta de Asistencias
                    </span>
                    <a href="{{ route('trabajadores.listar-asistencias') }}" class="btn btn-sm btn-consulta-all">
                        <i class="fas fa-list me-1 btn-consulta-all-icon"></i>Ver Todas
                    </a>
                </div>
                <div class="card-body p-4 form-card-consulta-body">
                    <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                        <div class="row mb-3">
                            <label for="trabajador_consulta" class="col-md-4 col-form-label form-label-consulta">
                                <i class="fas fa-user me-1 form-label-consulta-icon"></i> Trabajador
                            </label>
                            <div class="col-md-8">
                                <select id="trabajador_consulta" name="trabajador_id" class="form-select form-select-consulta">
                                    <option value="">Todos los trabajadores</option>
                                    @foreach($trabajadores as $trabajador)
                                        <option value="{{ $trabajador->id }}">
                                            {{ $trabajador->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lote_consulta" class="col-md-4 col-form-label form-label-consulta">
                                <i class="fas fa-map-marker-alt me-1 form-label-consulta-icon"></i> Lote
                            </label>
                            <div class="col-md-8">
                                <select id="lote_consulta" name="lote_id" class="form-select form-select-consulta">
                                    <option value="">Todos los lotes</option>
                                    @foreach(\App\Models\Lote::activos()->orderBy('nombre')->get() as $lote)
                                        <option value="{{ $lote->id }}">
                                            {{ $lote->nombre_completo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fecha_inicio" class="col-md-4 col-form-label form-label-consulta">
                                <i class="fas fa-calendar-minus me-1 form-label-consulta-icon"></i> Inicio
                            </label>
                            <div class="col-md-8">
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control form-control-consulta" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fecha_fin" class="col-md-4 col-form-label form-label-consulta">
                                <i class="fas fa-calendar-plus me-1 form-label-consulta-icon"></i> Fin
                            </label>
                            <div class="col-md-8">
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control form-control-consulta" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 btn-consulta-search">
                            <i class="fas fa-search me-2 btn-consulta-search-icon"></i>Buscar Registros
                        </button>
                    </form>
                </div>
            </div>

            <!-- Resumen -->
            <div class="card mt-3 border-0 shadow-sm stat-container">
                <div class="card-header stat-header">
                    <h5 class="mb-0 stat-title">
                        <i class="fas fa-info-circle me-2 stat-icon"></i>Resumen
                    </h5>
                </div>
                <div class="card-body p-4 stat-body">
                    <div class="stat-item-container d-flex mb-3 p-3">
                        <div class="stat-item-icon me-3 stat-item-icon-primary">
                            <i class="fas fa-users fa-2x stat-item-icon-users"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 stat-item-title">Trabajadores Activos</h6>
                            <p class="mb-0 stat-item-value">{{ count($trabajadores) ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="stat-item-container d-flex p-3">
                        <div class="stat-item-icon me-3 stat-item-icon-secondary">
                            <i class="fas fa-calendar-check fa-2x stat-item-icon-calendar"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 stat-item-title">Asistencias Hoy</h6>
                            <p class="mb-0 stat-item-value">{{ $asistencias_hoy ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Fin row -->
</div>
@endsection

@section('scripts')
<!-- Puedes agregar scripts específicos aquí si lo deseas -->
@endsection
