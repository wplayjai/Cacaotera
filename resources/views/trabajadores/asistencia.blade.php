@extends('layouts.masterr')

@section('styles')
<head> <link rel="stylesheet" href="{{ asset('css/trabajador/asistencia.css') }}"></head>
@endsection

@section('content')
<div class="container">
    <h2>Control de Asistencia</h2>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" style="background-color: #e6d2b5; border-left: 4px solid #ba8c63; color: #3b2314;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <script src="{{ asset('js/trabajador/asistencia.js') }}" defer></script>

    <div class="row">
        <!-- Formulario de Registro -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <i class="far fa-clock me-2"></i>Registrar Asistencia
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('trabajadores.registrar-asistencia') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <label for="trabajador_id" class="col-md-2 col-form-label">
                                <i class="fas fa-user me-1"></i> Trabajador
                            </label>
                            <div class="col-md-10">
                                <select id="trabajador_id" name="trabajador_id" class="form-select" required>
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
                            <label for="fecha" class="col-md-2 col-form-label">
                                <i class="far fa-calendar-alt me-1"></i> Fecha
                            </label>
                            <div class="col-md-10">
                                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $fecha_actual }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hora_entrada" class="col-md-2 col-form-label">
                                <i class="fas fa-sign-in-alt me-1"></i> Entrada
                            </label>
                            <div class="col-md-4">
                                <input type="time" id="hora_entrada" name="hora_entrada" class="form-control" required>
                            </div>

                            <label for="hora_salida" class="col-md-2 col-form-label">
                                <i class="fas fa-sign-out-alt me-1"></i> Salida
                            </label>
                            <div class="col-md-4">
                                <input type="time" id="hora_salida" name="hora_salida" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="observaciones" class="col-md-2 col-form-label">
                                <i class="far fa-comment-alt me-1"></i> Observaciones
                            </label>
                            <div class="col-md-10">
                                <textarea id="observaciones" name="observaciones" class="form-control" rows="3" placeholder="Ingrese comentarios adicionales aquí..."></textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Registrar Asistencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Consulta de Asistencias -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-search me-2"></i>Consulta de Asistencias</span>
                    <a href="{{ route('trabajadores.listar-asistencias') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-list me-1"></i>Ver Todas
                    </a>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                        <div class="row mb-3">
                            <label for="fecha_inicio" class="col-md-4 col-form-label">
                                <i class="fas fa-calendar-minus me-1"></i> Inicio
                            </label>
                            <div class="col-md-8">
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fecha_fin" class="col-md-4 col-form-label">
                                <i class="fas fa-calendar-plus me-1"></i> Fin
                            </label>
                            <div class="col-md-8">
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Buscar Registros
                        </button>
                    </form>
                </div>
            </div>

            <!-- Resumen -->
            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Resumen
                </div>
                <div class="card-body p-3">
                    <div class="stat-container d-flex mb-3">
                        <div class="stat-icon me-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Trabajadores Activos</h6>
                            <p class="mb-0">{{ count($trabajadores) ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="stat-container d-flex">
                        <div class="stat-icon me-3" style="background-color: var(--cocoa-accent);">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Asistencias Hoy</h6>
                            <p class="mb-0">{{ $asistencias_hoy ?? 0 }}</p>
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
