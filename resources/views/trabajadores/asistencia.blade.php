@extends('layouts.masterr')

@section('styles')
<head> <link rel="stylesheet" href="{{ asset('css/trabajador/asistencia.css') }}"></head>
@endsection

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #f5f3f0, white) !important; background-color: #f5f3f0 !important; min-height: 100vh; padding: 20px;">
    <!-- Header con diseño café -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4a3728, #6b4e3d) !important; background-color: #4a3728 !important;">
                <div class="card-body py-4">
                    <!-- Botón de navegación -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center" style="background: rgba(212, 196, 160, 0.2) !important; border: 2px solid #d4c4a0 !important; color: #d4c4a0 !important; border-radius: 25px !important; font-weight: 600 !important; padding: 8px 20px !important; transition: all 0.3s ease !important;">
                            <i class="fas fa-arrow-left me-2" style="color: #d4c4a0 !important; font-size: 0.9rem;"></i>
                            <span style="color: #d4c4a0 !important;">Volver a Trabajadores</span>
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
                        <div class="mt-3">
                            <span style="color: #a0845c !important; font-size: 2rem;">☕</span>
                            <span style="color: #8b6f47 !important; margin: 0 10px;">●</span>
                            <span style="color: #6b4e3d !important; font-size: 2rem;">🌿</span>
                            <span style="color: #8b6f47 !important; margin: 0 10px;">●</span>
                            <span style="color: #a0845c !important; font-size: 2rem;">☕</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" style="background: linear-gradient(135deg, #e6d2b5, #f5f3f0) !important; background-color: #e6d2b5 !important; border-left: 4px solid #6b4e3d !important; border: 1px solid #a0845c !important; color: #4a3728 !important;">
            <i class="fas fa-check-circle me-2" style="color: #6b4e3d !important;"></i>{{ session('success') }}
        </div>
    @endif
<script src="{{ asset('js/trabajador/asistencia.js') }}" defer></script>

    <div class="row">
        <!-- Formulario de Registro -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="background: white !important; border-radius: 15px !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important; background-color: #6b4e3d !important; color: white !important; border-radius: 15px 15px 0 0 !important; border: none !important;">
                    <h5 class="mb-0" style="color: white !important; font-weight: 600;">
                        <i class="far fa-clock me-2" style="color: #d4c4a0 !important;"></i>Registrar Asistencia
                    </h5>
                </div>
                <div class="card-body p-4" style="background: white !important;">
                    <form action="{{ route('trabajadores.registrar-asistencia') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <label for="trabajador_id" class="col-md-2 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="fas fa-user me-1" style="color: #6b4e3d !important;"></i> Trabajador
                            </label>
                            <div class="col-md-10">
                                <select id="trabajador_id" name="trabajador_id" class="form-select" required style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
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
                            <label for="fecha" class="col-md-2 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="far fa-calendar-alt me-1" style="color: #6b4e3d !important;"></i> Fecha
                            </label>
                            <div class="col-md-10">
                                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $fecha_actual }}" required style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lote_id" class="col-md-2 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="fas fa-map-marker-alt me-1" style="color: #6b4e3d !important;"></i> Lote
                            </label>
                            <div class="col-md-10">
                                <select id="lote_id" name="lote_id" class="form-select" required style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
                                    <option value="">Seleccione el lote donde trabajó</option>
                                    @foreach(\App\Models\Lote::activos()->orderBy('nombre')->get() as $lote)
                                        <option value="{{ $lote->id }}">
                                            {{ $lote->nombre_completo }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text" style="color: #8b6f47 !important;">
                                    <i class="fas fa-info-circle me-1" style="color: #a0845c !important;"></i>
                                    Especifique en qué lote realizó las actividades laborales
                                </small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hora_entrada" class="col-md-2 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="fas fa-sign-in-alt me-1" style="color: #6b4e3d !important;"></i> Entrada
                            </label>
                            <div class="col-md-4">
                                <input type="time" id="hora_entrada" name="hora_entrada" class="form-control" required style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
                            </div>

                            <label for="hora_salida" class="col-md-2 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="fas fa-sign-out-alt me-1" style="color: #6b4e3d !important;"></i> Salida
                            </label>
                            <div class="col-md-4">
                                <input type="time" id="hora_salida" name="hora_salida" class="form-control" required style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="observaciones" class="col-md-2 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="far fa-comment-alt me-1" style="color: #6b4e3d !important;"></i> Observaciones
                            </label>
                            <div class="col-md-10">
                                <textarea id="observaciones" name="observaciones" class="form-control" rows="3" placeholder="Ingrese comentarios adicionales aquí..." style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;"></textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important; background-color: #6b4e3d !important; color: white !important; border: none !important; padding: 12px 30px !important; border-radius: 25px !important; font-weight: 600 !important;">
                                <i class="fas fa-save me-2" style="color: white !important;"></i>Registrar Asistencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Consulta de Asistencias -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="background: white !important; border-radius: 15px !important;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important; background-color: #6b4e3d !important; color: white !important; border-radius: 15px 15px 0 0 !important; border: none !important;">
                    <span style="color: white !important; font-weight: 600;">
                        <i class="fas fa-search me-2" style="color: #d4c4a0 !important;"></i>Consulta de Asistencias
                    </span>
                    <a href="{{ route('trabajadores.listar-asistencias') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #a0845c, #d4c4a0) !important; background-color: #a0845c !important; color: #4a3728 !important; border: none !important; border-radius: 20px !important; font-weight: 600 !important;">
                        <i class="fas fa-list me-1" style="color: #4a3728 !important;"></i>Ver Todas
                    </a>
                </div>
                <div class="card-body p-4" style="background: white !important;">
                    <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                        <div class="row mb-3">
                            <label for="trabajador_consulta" class="col-md-4 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="fas fa-user me-1" style="color: #6b4e3d !important;"></i> Trabajador
                            </label>
                            <div class="col-md-8">
                                <select id="trabajador_consulta" name="trabajador_id" class="form-select" style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
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
                            <label for="lote_consulta" class="col-md-4 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="fas fa-map-marker-alt me-1" style="color: #6b4e3d !important;"></i> Lote
                            </label>
                            <div class="col-md-8">
                                <select id="lote_consulta" name="lote_id" class="form-select" style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
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
                            <label for="fecha_inicio" class="col-md-4 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="fas fa-calendar-minus me-1" style="color: #6b4e3d !important;"></i> Inicio
                            </label>
                            <div class="col-md-8">
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fecha_fin" class="col-md-4 col-form-label" style="color: #4a3728 !important; font-weight: 600;">
                                <i class="fas fa-calendar-plus me-1" style="color: #6b4e3d !important;"></i> Fin
                            </label>
                            <div class="col-md-8">
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important;">
                            </div>
                        </div>

                        <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important; background-color: #6b4e3d !important; color: white !important; border: none !important; padding: 12px !important; border-radius: 25px !important; font-weight: 600 !important;">
                            <i class="fas fa-search me-2" style="color: white !important;"></i>Buscar Registros
                        </button>
                    </form>
                </div>
            </div>

            <!-- Resumen -->
            <div class="card mt-3 border-0 shadow-sm" style="background: white !important; border-radius: 15px !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important; background-color: #6b4e3d !important; color: white !important; border-radius: 15px 15px 0 0 !important; border: none !important;">
                    <h5 class="mb-0" style="color: white !important; font-weight: 600;">
                        <i class="fas fa-info-circle me-2" style="color: #d4c4a0 !important;"></i>Resumen
                    </h5>
                </div>
                <div class="card-body p-4" style="background: white !important;">
                    <div class="stat-container d-flex mb-3 p-3" style="background: linear-gradient(135deg, #f5f3f0, #d4c4a0) !important; background-color: #f5f3f0 !important; border-radius: 10px !important; border: 2px solid #a0845c !important;">
                        <div class="stat-icon me-3" style="background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important; background-color: #6b4e3d !important; color: white !important; padding: 15px !important; border-radius: 50% !important; width: 60px !important; height: 60px !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                            <i class="fas fa-users fa-2x" style="color: white !important;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0" style="color: #4a3728 !important; font-weight: 600;">Trabajadores Activos</h6>
                            <p class="mb-0" style="color: #6b4e3d !important; font-size: 1.5rem; font-weight: bold;">{{ count($trabajadores) ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="stat-container d-flex p-3" style="background: linear-gradient(135deg, #f5f3f0, #d4c4a0) !important; background-color: #f5f3f0 !important; border-radius: 10px !important; border: 2px solid #a0845c !important;">
                        <div class="stat-icon me-3" style="background: linear-gradient(135deg, #a0845c, #d4c4a0) !important; background-color: #a0845c !important; color: #4a3728 !important; padding: 15px !important; border-radius: 50% !important; width: 60px !important; height: 60px !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                            <i class="fas fa-calendar-check fa-2x" style="color: #4a3728 !important;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0" style="color: #4a3728 !important; font-weight: 600;">Asistencias Hoy</h6>
                            <p class="mb-0" style="color: #6b4e3d !important; font-size: 1.5rem; font-weight: bold;">{{ $asistencias_hoy ?? 0 }}</p>
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
