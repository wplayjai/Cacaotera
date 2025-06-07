@extends('layouts.masterr')

@section('content')
<head>
<link rel="stylesheet" href="{{ asset('css/trabajador/reportes.css') }}">
</head>
<div class="container">
    <h2 class="mb-4 text-cacao">Generación de Reportes</h2>
    
    <div class="card cacao-card">
        <div class="card-header cacao-header">
            <i class="fas fa-file-alt me-2"></i> Seleccione los parámetros del reporte
        </div>
        <div class="card-body">
            <form action="{{ route('trabajadores.generar-reporte-asistencia') }}" method="GET">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="cacao-label">Tipo de Reporte</label>
                        <select name="tipo_reporte" class="form-control cacao-select" required>
                            <option value="asistencia">Reporte de Asistencia</option>
                            <option value="todos">Todos los Trabajadores</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="cacao-label">Trabajador (Opcional)</label>
                        <select name="trabajador_id" class="form-control cacao-select">
                            <option value="">Todos los trabajadores</option>
                            @foreach(\App\Models\Trabajador::with('user')->get() as $trabajador)
                                <option value="{{ $trabajador->id }}">{{ $trabajador->user->name }} - {{ $trabajador->user->identificacion }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="cacao-label">Fecha Inicio</label>
                        <div class="input-group date-input">
                            <input type="date" name="fecha_inicio" class="form-control cacao-input" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required>
                            <span class="input-group-text cacao-icon"><i class="far fa-calendar"></i></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="cacao-label">Fecha Fin</label>
                        <div class="input-group date-input">
                            <input type="date" name="fecha_fin" class="form-control cacao-input" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                            <span class="input-group-text cacao-icon"><i class="far fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn cacao-btn">
                    <i class="fas fa-file-export me-2"></i>Generar Reporte
                </button>
            </form>
        </div>
    </div>
</div>


@endsection