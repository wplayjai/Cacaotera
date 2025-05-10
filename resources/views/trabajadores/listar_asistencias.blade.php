@extends('layouts.masterr')

@section('styles')
<style>
    :root {
        --cocoa-dark: #3B2314;
        --cocoa-medium: #76523B;
        --cocoa-light: #C8A27C;
        --cocoa-pale: #E6D2B5;
        --cocoa-accent: #BA8C63;
        --cocoa-bg: #f9f6f3;
    }
    
    /* Estilos generales */
    body {
        background-color: var(--cocoa-bg);
    }
    
    .container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }
    
    h2 {
        color: var(--cocoa-dark);
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    
    /* Tarjetas y contenedores */
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(59, 35, 20, 0.1);
        overflow: hidden;
        margin-bottom: 1.5rem;
        background-color: white;
    }
    
    .card-header {
        background-color: var(--cocoa-medium);
        color: white;
        font-weight: 500;
        padding: 0.8rem 1.2rem;
        border-bottom: none;
    }
    
    .card-footer {
        background-color: #f8f5f2;
        border-top: 1px solid #ede4d9;
        padding: 1rem;
    }
    
    /* Formularios y controles */
    .form-control, .form-select {
        border: 1px solid #ded2c7;
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--cocoa-accent);
        box-shadow: 0 0 0 0.2rem rgba(186, 140, 99, 0.25);
    }
    
    label {
        font-weight: 500;
        color: var(--cocoa-dark);
        margin-bottom: 0.5rem;
    }
    
    /* Botones */
    .btn {
        border-radius: 6px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background-color: var(--cocoa-medium);
        border-color: var(--cocoa-medium);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: var(--cocoa-dark);
        border-color: var(--cocoa-dark);
    }
    
    .btn-secondary {
        background-color: var(--cocoa-light);
        border-color: var(--cocoa-light);
        color: var(--cocoa-dark);
    }
    
    .btn-secondary:hover {
        background-color: var(--cocoa-accent);
        border-color: var(--cocoa-accent);
        color: white;
    }
    
    .btn-success {
        background-color: #5a8a4f;
        border-color: #5a8a4f;
        color: white;
    }
    
    .btn-success:hover {
        background-color: #497641;
        border-color: #497641;
    }
    
    /* Tablas */
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        background-color: var(--cocoa-pale);
        color: var(--cocoa-dark);
        font-weight: 600;
        border-bottom: 2px solid var(--cocoa-light);
        vertical-align: middle;
        padding: 0.75rem 1rem;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(230, 210, 181, 0.15);
    }
    
    .table-striped tbody tr:hover {
        background-color: rgba(186, 140, 99, 0.1);
    }
    
    .table td {
        vertical-align: middle;
        padding: 0.75rem 1rem;
        color: #4a3622;
        border-top: 1px solid #ede4d9;
    }
    
    /* Iconos y elementos visuales */
    i.fas, i.far {
        color: var(--cocoa-accent);
    }
    
    .card-header i.fas, .card-header i.far {
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2>Listado de Asistencias</h2>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-filter me-2"></i>Filtrar</span>
            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle me-1"></i>Registrar Nueva Asistencia
            </a>
        </div>
        <div class="card-body p-3">
            <form action="{{ route('trabajadores.listar-asistencias') }}" method="GET">
                <div class="row">
                    <div class="col-md-5 mb-3 mb-md-0">
                        <label>
                            <i class="far fa-calendar-minus me-1"></i>Fecha Inicio
                        </label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ $fecha_inicio }}">
                    </div>
                    
                    <div class="col-md-5 mb-3 mb-md-0">
                        <label>
                            <i class="far fa-calendar-plus me-1"></i>Fecha Fin
                        </label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ $fecha_fin }}">
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="fas fa-search me-1"></i>Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-clipboard-list me-2"></i>Resultados 
                <span class="badge rounded-pill" style="background-color: var(--cocoa-light); color: var(--cocoa-dark);">
                    {{ $asistencias->count() }} registros
                </span>
            </span>
          
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Trabajador</th>
                            <th>Fecha</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Horas</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asistencias as $asistencia)
                            <tr>
                                <td>
                                    <span style="font-weight: 500;">{{ $asistencia->trabajador->user->name }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge" style="background-color: rgba(118, 82, 59, 0.15); color: var(--cocoa-medium); padding: 5px 8px;">
                                        <i class="fas fa-sign-in-alt me-1" style="color: inherit;"></i>
                                        {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: rgba(118, 82, 59, 0.15); color: var(--cocoa-medium); padding: 5px 8px;">
                                        <i class="fas fa-sign-out-alt me-1" style="color: inherit;"></i>
                                        {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($asistencia->hora_entrada && $asistencia->hora_salida)
                                        <span class="badge rounded-pill" style="background-color: var(--cocoa-light); color: var(--cocoa-dark); padding: 5px 10px;">
                                            <i class="far fa-clock me-1" style="color: inherit;"></i>
                                            {{ \Carbon\Carbon::parse($asistencia->hora_entrada)->diffInHours(\Carbon\Carbon::parse($asistencia->hora_salida)) }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asistencia->observaciones)
                                        <span title="{{ $asistencia->observaciones }}">
                                            {{ \Illuminate\Support\Str::limit($asistencia->observaciones, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-exclamation-circle me-2" style="color: var(--cocoa-accent); font-size: 1.25rem;"></i>
                                    No hay registros de asistencia en el periodo seleccionado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                <i class="fas fa-info-circle me-1"></i>Actualizado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </div>
            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Generar Reportes
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar colores a los elementos
        document.querySelectorAll('.card-header').forEach(header => {
            header.style.backgroundColor = '#76523B';
            header.style.color = 'white';
        });
        
        document.querySelectorAll('.btn-primary').forEach(btn => {
            btn.style.backgroundColor = '#76523B';
            btn.style.borderColor = '#76523B';
        });
        
        document.querySelectorAll('.btn-secondary').forEach(btn => {
            btn.style.backgroundColor = '#C8A27C';
            btn.style.borderColor = '#C8A27C';
            btn.style.color = '#3B2314';
        });
        
        // Añadir estilos a la tabla
        document.querySelectorAll('thead th').forEach(th => {
            th.style.backgroundColor = '#E6D2B5';
            th.style.color = '#3B2314';
        });
        
        // Mejora de accesibilidad para enlaces de la tabla
        document.querySelectorAll('.table tr').forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(186, 140, 99, 0.1)';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
        
        // Efecto hover para los botones
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                if (this.classList.contains('btn-primary')) {
                    this.style.backgroundColor = '#3B2314';
                    this.style.borderColor = '#3B2314';
                } else if (this.classList.contains('btn-secondary')) {
                    this.style.backgroundColor = '#BA8C63';
                    this.style.borderColor = '#BA8C63';
                    this.style.color = 'white';
                }
            });
            
            btn.addEventListener('mouseleave', function() {
                if (this.classList.contains('btn-primary')) {
                    this.style.backgroundColor = '#76523B';
                    this.style.borderColor = '#76523B';
                } else if (this.classList.contains('btn-secondary')) {
                    this.style.backgroundColor = '#C8A27C';
                    this.style.borderColor = '#C8A27C';
                    this.style.color = '#3B2314';
                }
            });
        });
    });
</script>
@endsection