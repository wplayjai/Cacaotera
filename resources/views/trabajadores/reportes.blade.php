@extends('layouts.masterr')

@section('content')
<div class="container">
    <h2 class="mb-4">Generación de Reportes</h2>
    
    <div class="card">
        <div class="card-header">
            Seleccione los parámetros del reporte
        </div>
        <div class="card-body">
            <form action="{{ route('trabajadores.generar-reporte-asistencia') }}" method="GET">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tipo de Reporte</label>
                        <select name="tipo_reporte" class="form-control" required>
                            <option value="asistencia">Reporte de Asistencia</option>
                            <option value="todos">Todos los Trabajadores</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Trabajador (Opcional)</label>
                        <select name="trabajador_id" class="form-control">
                            <option value="">Todos los trabajadores</option>
                            @foreach(\App\Models\Trabajador::with('user')->get() as $trabajador)
                                <option value="{{ $trabajador->id }}">{{ $trabajador->user->name }} - {{ $trabajador->user->identificacion }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Generar Reporte</button>
            </form>
        </div>
    </div>
</div>
@endsection