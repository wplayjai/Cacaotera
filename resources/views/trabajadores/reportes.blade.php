@extends('layouts.masterr')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/trabajador/reportes.css') }}">
</head>

<div class="container-fluid" style="background: linear-gradient(135deg, #f5f3f0, white) !important; background-color: #f5f3f0 !important; min-height: 100vh; padding: 20px;">
    <!-- Header con diseño café -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4a3728, #6b4e3d) !important; background-color: #4a3728 !important;">
                <div class="card-body py-4">
                    <!-- Botones de navegación -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center" style="background: rgba(212, 196, 160, 0.2) !important; border: 2px solid #d4c4a0 !important; color: #d4c4a0 !important; border-radius: 25px !important; font-weight: 600 !important; padding: 8px 20px !important; transition: all 0.3s ease !important;">
                                <i class="fas fa-arrow-left me-2" style="color: #d4c4a0 !important; font-size: 0.9rem;"></i>
                                <span style="color: #d4c4a0 !important;">Volver a Trabajadores</span>
                            </a>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm d-flex align-items-center" style="background: rgba(160, 132, 92, 0.2) !important; border: 2px solid #a0845c !important; color: #a0845c !important; border-radius: 20px !important; font-weight: 600 !important; padding: 6px 15px !important;">
                                <i class="far fa-clock me-1" style="color: #a0845c !important; font-size: 0.8rem;"></i>
                                <span style="color: #a0845c !important; font-size: 0.9rem;">Asistencia</span>
                            </a>
                            <a href="{{ route('trabajadores.listar-asistencias') }}" class="btn btn-sm d-flex align-items-center" style="background: rgba(139, 111, 71, 0.2) !important; border: 2px solid #8b6f47 !important; color: #8b6f47 !important; border-radius: 20px !important; font-weight: 600 !important; padding: 6px 15px !important;">
                                <i class="fas fa-list me-1" style="color: #8b6f47 !important; font-size: 0.8rem;"></i>
                                <span style="color: #8b6f47 !important; font-size: 0.9rem;">Listado</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Título principal centrado -->
                    <div class="text-center">
                        <h1 class="mb-2" style="color: white !important; font-weight: 600;">
                            <i class="fas fa-file-alt me-3" style="color: #d4c4a0 !important;"></i>
                            Generación de Reportes
                        </h1>
                        <p class="mb-0" style="color: #d4c4a0 !important; font-size: 1.1rem;">
                            Genera reportes detallados de asistencias y trabajadores
                        </p>
                        <div class="mt-3">
                            <span style="color: #a0845c !important; font-size: 2rem;">📊</span>
                            <span style="color: #8b6f47 !important; margin: 0 10px;">●</span>
                            <span style="color: #6b4e3d !important; font-size: 2rem;">📈</span>
                            <span style="color: #8b6f47 !important; margin: 0 10px;">●</span>
                            <span style="color: #a0845c !important; font-size: 2rem;">📊</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm" style="background: white !important; border-radius: 15px !important;">
        <div class="card-header d-flex align-items-center" style="background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important; background-color: #6b4e3d !important; color: white !important; border-radius: 15px 15px 0 0 !important; border: none !important;">
            <i class="fas fa-file-alt me-2" style="color: #d4c4a0 !important;"></i>
            <span style="color: white !important; font-weight: 600;">Seleccione los parámetros del reporte</span>
        </div>
        <div class="card-body p-4" style="background: white !important;">
            <form action="{{ route('trabajadores.generar-reporte-asistencia') }}" method="GET">
                <div class="row">
                    <!-- Tipo de Reporte -->
                    <div class="col-md-6 mb-3">
                        <label style="color: #4a3728 !important; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-chart-bar me-1" style="color: #6b4e3d !important;"></i>
                            Tipo de Reporte
                        </label>
                        <select name="tipo_reporte" class="form-select" required style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important; padding: 12px !important; border-radius: 8px !important;">
                            <option value="asistencia">Reporte de Asistencia</option>
                            <option value="todos">Todos los Trabajadores</option>
                        </select>
                    </div>

                    <!-- Trabajador -->
                    <div class="col-md-6 mb-3">
                        <label style="color: #4a3728 !important; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-user me-1" style="color: #6b4e3d !important;"></i>
                            Trabajador (Opcional)
                        </label>
                        <select name="trabajador_id" class="form-select" style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important; padding: 12px !important; border-radius: 8px !important;">
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
                        <label style="color: #4a3728 !important; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-calendar-alt me-1" style="color: #6b4e3d !important;"></i>
                            Fecha Inicio
                        </label>
                        <div class="input-group">
                            <input type="date" name="fecha_inicio" class="form-control" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important; padding: 12px !important; border-radius: 8px 0 0 8px !important;">
                            <span class="input-group-text" style="background: linear-gradient(135deg, #a0845c, #d4c4a0) !important; background-color: #a0845c !important; border: 2px solid #d4c4a0 !important; border-left: none !important; border-radius: 0 8px 8px 0 !important;">
                                <i class="far fa-calendar" style="color: #4a3728 !important;"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Fecha Fin -->
                    <div class="col-md-6 mb-3">
                        <label style="color: #4a3728 !important; font-weight: 600; margin-bottom: 8px;">
                            <i class="fas fa-calendar-check me-1" style="color: #6b4e3d !important;"></i>
                            Fecha Fin
                        </label>
                        <div class="input-group">
                            <input type="date" name="fecha_fin" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required style="border: 2px solid #d4c4a0 !important; background: white !important; color: #4a3728 !important; padding: 12px !important; border-radius: 8px 0 0 8px !important;">
                            <span class="input-group-text" style="background: linear-gradient(135deg, #a0845c, #d4c4a0) !important; background-color: #a0845c !important; border: 2px solid #d4c4a0 !important; border-left: none !important; border-radius: 0 8px 8px 0 !important;">
                                <i class="far fa-calendar" style="color: #4a3728 !important;"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6b4e3d, #8b6f47) !important; background-color: #6b4e3d !important; color: white !important; border: none !important; padding: 15px 40px !important; border-radius: 25px !important; font-weight: 600 !important; font-size: 1.1rem !important; box-shadow: 0 4px 6px rgba(74, 55, 40, 0.3) !important;">
                        <i class="fas fa-file-export me-2" style="color: white !important;"></i>Generar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
