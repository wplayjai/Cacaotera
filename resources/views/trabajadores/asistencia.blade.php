@extends('layouts.masterr')

@section('styles')
<head> <link rel="stylesheet" href="{{ asset('css/asistencia.css') }}"></head>
@endsection

@section('content')
<div class="container">
    <h2>Control de Asistencia</h2>
    
    @if(session('success'))
        <div class="alert alert-success" style="background-color: #e6d2b5; border-left: 4px solid #ba8c63; color: #3b2314; padding: 10px 15px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    
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
                            <div class="col-md-2">
                                <label for="trabajador_id">
                                    <i class="fas fa-user me-1"></i> Trabajador
                                </label>
                            </div>
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
                            <div class="col-md-2">
                                <label for="fecha">
                                    <i class="far fa-calendar-alt me-1"></i> Fecha
                                </label>
                            </div>
                            <div class="col-md-10">
                                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $fecha_actual }}" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="hora_entrada">
                                    <i class="fas fa-sign-in-alt me-1"></i> Hora de Entrada
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="time" id="hora_entrada" name="hora_entrada" class="form-control" required>
                            </div>
                            
                            <div class="col-md-2">
                                <label for="hora_salida">
                                    <i class="fas fa-sign-out-alt me-1"></i> Hora de Salida
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="time" id="hora_salida" name="hora_salida" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="observaciones">
                                    <i class="far fa-comment-alt me-1"></i> Observaciones
                                </label>
                            </div>
                            <div class="col-md-10">
                                <textarea id="observaciones" name="observaciones" class="form-control" rows="3" placeholder="Ingrese comentarios adicionales aquí..."></textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Registrar Asistencia
                                </button>
                            </div>
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
                            <div class="col-md-4">
                                <label for="fecha_inicio">
                                    <i class="fas fa-calendar-minus me-1"></i> Fecha Inicio
                                </label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" 
                                    value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="fecha_fin">
                                    <i class="fas fa-calendar-plus me-1"></i> Fecha Fin
                                </label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" 
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>Buscar Registros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Resumen
                </div>
                <div class="card-body p-3">
                    <div class="stat-container">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h6>Trabajadores Activos</h6>
                            <p>{{ count($trabajadores) ?? 0 }}</p>
                        </div>
                    </div>
                    
                    <div class="stat-container">
                        <div class="stat-icon" style="background-color: var(--cocoa-accent);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h6>Asistencias Hoy</h6>
                            <p>{{ $asistencias_hoy ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Establecer hora actual en el campo de entrada
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('hora_entrada').value = `${hours}:${minutes}`;
        
        // Añadir clases adicionales para mejorar la interfaz
        const labels = document.querySelectorAll('label');
        labels.forEach(label => {
            label.style.fontWeight = '500';
            label.style.color = '#3B2314';
        });
        
        // Añadir color a los encabezados
        document.querySelectorAll('.card-header').forEach(header => {
            header.style.backgroundColor = '#76523B';
            header.style.color = 'white';
        });
        
        // Estilizar los botones
        document.querySelectorAll('.btn-primary').forEach(btn => {
            btn.style.backgroundColor = '#76523B';
            btn.style.borderColor = '#76523B';
        });
        
        document.querySelectorAll('.btn-info').forEach(btn => {
            btn.style.backgroundColor = '#C8A27C';
            btn.style.borderColor = '#C8A27C';
            btn.style.color = '#3B2314';
        });
        
        // Añadir fondo general
        document.body.style.backgroundColor = '#f9f6f3';
        
        // Estilizar los inputs cuando reciben foco
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#BA8C63';
                this.style.boxShadow = '0 0 0 0.2rem rgba(186, 140, 99, 0.25)';
            });
            
            input.addEventListener('blur', function() {
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
@endsection