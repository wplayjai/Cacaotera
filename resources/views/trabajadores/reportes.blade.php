@extends('layouts.masterr')

@section('content')
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

<style>
/* Paleta de colores inspirada en cacao */
:root {
    --cacao-dark: #3E2723;
    --cacao-medium: #6D4C41;
    --cacao-light: #A1887F;
    --cacao-cream: #D7CCC8;
    --cacao-pale: #EFEBE9;
}

body {
    background-color: var(--cacao-pale);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h2.text-cacao {
    color: var(--cacao-dark);
    font-weight: 600;
    border-bottom: 2px solid var(--cacao-light);
    padding-bottom: 0.5rem;
}

.cacao-card {
    border: none;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
}

.cacao-header {
    background-color: var(--cacao-medium);
    color: white;
    font-weight: 500;
    padding: 0.75rem 1.25rem;
}

.cacao-label {
    color: var(--cacao-dark);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.cacao-select, .cacao-input {
    border: 1px solid var(--cacao-light);
    border-radius: 4px;
    padding: 0.5rem 0.75rem;
}

.cacao-select:focus, .cacao-input:focus {
    border-color: var(--cacao-medium);
    box-shadow: 0 0 0 0.2rem rgba(161, 136, 127, 0.25);
}

.date-input .cacao-icon {
    background-color: var(--cacao-medium);
    color: white;
    border: 1px solid var(--cacao-medium);
}

.cacao-btn {
    background-color: var(--cacao-medium);
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.cacao-btn:hover {
    background-color: var(--cacao-dark);
    color: white;
}

/* Importación de Font Awesome si no está ya en tu layout */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>
@endsection