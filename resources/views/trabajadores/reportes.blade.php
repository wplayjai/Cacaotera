@extends('layouts.masterr')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/trabajador/reportes.css') }}">
</head>


<div class="container">
    <h2 class="mb-4 text-cacao">Generación de Reportes</h2>
    
    <div class="card cacao-card shadow-sm">
        <div class="card-header cacao-header d-flex align-items-center">
            <i class="fas fa-file-alt me-2"></i>
            <span>Seleccione los parámetros del reporte</span>
        </div>
        <div class="card-body">
            <form action="{{ route('trabajadores.generar-reporte-asistencia') }}" method="GET">
                <div class="row">
                    <!-- Tipo de Reporte -->
                    <div class="col-md-6 mb-3">
                        <label class="cacao-label">Tipo de Reporte</label>
                        <select name="tipo_reporte" class="form-select cacao-select" required>
                            <option value="asistencia">Reporte de Asistencia</option>
                            <option value="todos">Todos los Trabajadores</option>
                        </select>
                    </div>

                    <!-- Trabajador -->
                    <div class="col-md-6 mb-3">
                        <label class="cacao-label">Trabajador (Opcional)</label>
                        <select name="trabajador_id" class="form-select cacao-select">
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
                        <label class="cacao-label">Fecha Inicio</label>
                        <div class="input-group">
                            <input type="date" name="fecha_inicio" class="form-control cacao-input" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required>
                            <span class="input-group-text cacao-icon"><i class="far fa-calendar"></i></span>
                        </div>
                    </div>

                    <!-- Fecha Fin -->
                    <div class="col-md-6 mb-3">
                        <label class="cacao-label">Fecha Fin</label>
                        <div class="input-group">
                            <input type="date" name="fecha_fin" class="form-control cacao-input" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                            <span class="input-group-text cacao-icon"><i class="far fa-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn cacao-btn">
                        <i class="fas fa-file-export me-2"></i>Generar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
