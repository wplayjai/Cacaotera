@extends('layouts.masterr')

@section('content')
<div class="container">
    <h2 class="mb-4">Control de Asistencia</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            Registrar Asistencia
        </div>
        <div class="card-body">
            <form action="{{ route('trabajadores.registrar-asistencia') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Trabajador</label>
                        <select name="trabajador_id" class="form-control" required>
                            <option value="">Seleccione un trabajador</option>
                            @foreach($trabajadores as $trabajador)
                                <option value="{{ $trabajador->id }}">{{ $trabajador->user->name }} - {{ $trabajador->user->identificacion }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ $fecha_actual }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Hora de Entrada</label>
                        <input type="time" name="hora_entrada" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Hora de Salida</label>
                        <input type="time" name="hora_salida" class="form-control" required>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Registrar Asistencia</button>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Consulta de Asistencias</span>
            <a href="{{ route('trabajadores.listar-asistencias') }}" class="btn btn-info btn-sm">Ver Todas</a>
        </div>
        <div class="card-body">
            <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <label>Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}">
                    </div>
                    
                    <div class="col-md-5">
                        <label>Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection