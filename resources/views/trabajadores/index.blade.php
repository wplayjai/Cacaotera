@extends('layouts.masterr')

@push('styles')
<style>
/* Variables de colores café */
:root {
    --cacao-dark: #4a3728;
    --cacao-medium: #6b4e3d;
    --cacao-light: #8b6f47;
    --cacao-accent: #a0845c;
    --cacao-cream: #f5f3f0;
    --cacao-sand: #d4c4a0;
}

/* Header específico con fondo café */
.content-header {
    background: #4a3728 !important;
    background-color: #4a3728 !important;
    border-bottom: 2px solid #a0845c !important;
}

/* Estilos generales de tarjetas */
.card {
    border: none !important;
    box-shadow: 0 4px 8px rgba(74, 55, 40, 0.15) !important;
    border-radius: 12px !important;
}

.card-header {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    border-bottom: 2px solid var(--cacao-accent) !important;
    border-radius: 12px 12px 0 0 !important;
}

.card-header h1, .card-header h3 {
    color: var(--cacao-dark) !important;
    font-weight: 600 !important;
}

/* Content header con estilo café */
.content-header {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    border-bottom: 2px solid var(--cacao-accent) !important;
}

.content-header h1 {
    color: var(--cacao-dark) !important;
}

/* Botones con estilo café */
.btn-success {
    background: linear-gradient(135deg, #27ae60, #2ecc71) !important;
    border: none !important;
    color: white !important;
}

.btn-success:hover {
    background: linear-gradient(135deg, #2ecc71, #58d68d) !important;
    transform: translateY(-1px) !important;
}

.btn-outline-secondary {
    border: 2px solid var(--cacao-medium) !important;
    color: var(--cacao-medium) !important;
    background: transparent !important;
}

.btn-outline-secondary:hover {
    background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)) !important;
    color: white !important;
    border-color: var(--cacao-medium) !important;
}

.btn-primary {
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
    border: none !important;
    color: white !important;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)) !important;
}

.btn-info {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-sand)) !important;
    border: none !important;
    color: var(--cacao-dark) !important;
}

.btn-info:hover {
    background: linear-gradient(135deg, var(--cacao-sand), var(--cacao-cream)) !important;
}

.btn-sm.btn-outline-info {
    border: 1px solid var(--cacao-accent) !important;
    color: var(--cacao-accent) !important;
}

.btn-sm.btn-outline-info:hover {
    background: var(--cacao-accent) !important;
    color: white !important;
}

.btn-sm.btn-outline-warning {
    border: 1px solid var(--cacao-accent) !important;
    color: var(--cacao-accent) !important;
}

.btn-sm.btn-outline-warning:hover {
    background: var(--cacao-accent) !important;
    color: var(--cacao-dark) !important;
}

.btn-sm.btn-outline-danger {
    border: 1px solid var(--cacao-dark) !important;
    color: var(--cacao-dark) !important;
}

.btn-sm.btn-outline-danger:hover {
    background: var(--cacao-dark) !important;
    color: white !important;
}

.btn-sm.btn-outline-success {
    border: 1px solid #27ae60 !important;
    color: #27ae60 !important;
}

.btn-sm.btn-outline-success:hover {
    background: #27ae60 !important;
    color: white !important;
}

/* Badges con estilo café */
.badge.bg-success {
    background: linear-gradient(135deg, #27ae60, #2ecc71) !important;
    color: white !important;
}

.badge.bg-warning {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-cream)) !important;
    color: var(--cacao-dark) !important;
}

.badge.bg-info {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-sand)) !important;
    color: var(--cacao-dark) !important;
}

.badge.bg-secondary {
    background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)) !important;
    color: white !important;
}

.badge.bg-danger {
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
    color: white !important;
}

/* Formularios con estilo café */
.form-control:focus, .form-select:focus {
    border-color: var(--cacao-accent) !important;
    box-shadow: 0 0 0 0.25rem rgba(160, 132, 92, 0.25) !important;
}

.form-control, .form-select {
    border: 1px solid rgba(160, 132, 92, 0.3) !important;
}

/* Tabla con estilo café */
.table-light {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    color: var(--cacao-dark) !important;
}

.table-light th {
    border-bottom: 2px solid var(--cacao-accent) !important;
    color: var(--cacao-dark) !important;
    font-weight: 600 !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(160, 132, 92, 0.1) !important;
}

/* Enlaces con estilo café */
a {
    color: var(--cacao-accent) !important;
}

a:hover {
    color: var(--cacao-dark) !important;
}

/* Iconos con colores café */
.fas, .far {
    color: var(--cacao-accent) !important;
}

/* Texto con colores café */
.text-muted {
    color: var(--cacao-medium) !important;
}

/* Sombras café */
.shadow-sm {
    box-shadow: 0 2px 4px rgba(74, 55, 40, 0.1) !important;
}

/* Bordes café */
.border-3 {
    border-color: var(--cacao-accent) !important;
}

/* Modales con estilo café */
.modal-header.bg-warning {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-cream)) !important;
    color: var(--cacao-dark) !important;
}

.modal-header.bg-info {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-sand)) !important;
    color: var(--cacao-dark) !important;
}

.modal-header.bg-danger {
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
    color: white !important;
}

/* Input groups con estilo café */
.input-group-text {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    border: 1px solid rgba(160, 132, 92, 0.3) !important;
    color: var(--cacao-accent) !important;
}

/* Card footer */
.card-footer {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    border-top: 1px solid var(--cacao-accent) !important;
}

/* Estadísticas cards - Estilos más específicos */
.stats-card.stats-card-primary,
.stats-card.stats-card-success,
.stats-card.stats-card-warning,
.stats-card.stats-card-danger,
.stats-card.stats-card-info {
    border: none !important;
    border-radius: 8px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
    overflow: hidden !important;
    transition: all 0.3s ease !important;
    margin-bottom: 1rem !important;
    min-height: 100px !important;
}

.stats-card.stats-card-primary:hover,
.stats-card.stats-card-success:hover,
.stats-card.stats-card-warning:hover,
.stats-card.stats-card-danger:hover,
.stats-card.stats-card-info:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2) !important;
}

/* Colores específicos para cada tarjeta */
.stats-card.stats-card-primary {
    background: linear-gradient(135deg, #4a3728, #6b4e3d) !important;
    background-color: #4a3728 !important;
}

.stats-card.stats-card-success {
    background: linear-gradient(135deg, #2e7d32, #1b5e20) !important;
    background-color: #2e7d32 !important;
}

.stats-card.stats-card-warning {
    background: linear-gradient(135deg, #f57c00, #e65100) !important;
    background-color: #f57c00 !important;
}

.stats-card.stats-card-danger {
    background: linear-gradient(135deg, #c62828, #b71c1c) !important;
    background-color: #c62828 !important;
}

.stats-card.stats-card-info {
    background: linear-gradient(135deg, #1976d2, #0d47a1) !important;
    background-color: #1976d2 !important;
}

/* Contenido de las tarjetas */
.stats-card .card-body {
    padding: 1.5rem !important;
    color: white !important;
    background: transparent !important;
}

.stats-card .stats-number {
    font-size: 2rem !important;
    font-weight: 700 !important;
    margin-bottom: 0.5rem !important;
    color: white !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
}

.stats-card .stats-label {
    font-size: 0.9rem !important;
    opacity: 0.95 !important;
    margin-bottom: 0 !important;
    color: white !important;
    font-weight: 500 !important;
}

.stats-card .stats-icon {
    font-size: 2.5rem !important;
    opacity: 0.8 !important;
    color: white !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
}
</style>
@endpush

@section('content')
 <script src="{{ asset('js/trabajador/indextra.js') }}" defer></script>
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header py-3 mb-3 shadow-sm" style="background: #4a3728 !important; background-color: #4a3728 !important; border-bottom: 2px solid #a0845c !important;">
        <div class="container-fluid" style="background: transparent !important;">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0" style="color: white !important; text-shadow: 0 1px 2px rgba(0,0,0,0.5) !important;"><i class="fas fa-users me-2" style="color: #f5f3f0 !important;"></i>Gestión de Trabajadores</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-end">
                        <button class="btn btn-outline-light trabajadores-back-btn" style="border: 2px solid white !important; color: white !important; background: transparent !important;">
                            <i class="fas fa-arrow-left me-1" style="color: white !important;"></i> Volver
                        </button>
                        <a href="{{ route('trabajadores.create') }}" class="btn btn-success" style="background: linear-gradient(135deg, #27ae60, #2ecc71) !important; background-color: #27ae60 !important; border: none !important; color: white !important;">
                            <i class="fas fa-user-plus me-1" style="color: white !important;"></i> Registrar Trabajador
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="container-fluid mb-3">
    <div class="card border-top border-3 shadow-sm">
        <div class="card-body py-2">
            <div class="d-flex justify-content-end align-items-center">
                <span class="fw-bold me-3" style="color: var(--cacao-dark);">
                    <i class="fas fa-cogs me-1" style="color: var(--cacao-accent);"></i> Acciones Rápidas:
                </span>
                <div class="btn-group">
                    <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-sm btn-primary" style="background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)); border: none; color: black !important;">
                        <i class="fas fa-clipboard-check me-1" style="color: black !important;"></i> Control de Asistencia
                    </a>
                    <a href="{{ route('trabajadores.reportes') }}" class="btn btn-sm btn-info" style="background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-light)); border: none;">
                        <i class="fas fa-chart-bar me-1" style="color: var(--cacao-dark);"></i> Reportes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tarjetas de Estadísticas -->
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="stats-card stats-card-primary" style="background: linear-gradient(135deg, #4a3728, #6b4e3d) !important; border: none !important; border-radius: 8px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important; min-height: 120px !important;">
                <div class="card-body" style="padding: 1.5rem !important; color: white !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number" style="font-size: 2rem !important; font-weight: 700 !important; color: white !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;">{{ count($trabajadores) }}</div>
                            <div class="stats-label" style="font-size: 0.9rem !important; color: white !important; font-weight: 500 !important;">Total Trabajadores</div>
                        </div>
                        <div>
                            <i class="fas fa-users stats-icon" style="font-size: 2.5rem !important; color: white !important; opacity: 0.8 !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stats-card stats-card-success" style="background: linear-gradient(135deg, #2e7d32, #1b5e20) !important; border: none !important; border-radius: 8px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important; min-height: 120px !important;">
                <div class="card-body" style="padding: 1.5rem !important; color: white !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number" style="font-size: 2rem !important; font-weight: 700 !important; color: white !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;">{{ $trabajadores->where('user.estado', 'activo')->count() }}</div>
                            <div class="stats-label" style="font-size: 0.9rem !important; color: white !important; font-weight: 500 !important;">Activos</div>
                        </div>
                        <div>
                            <i class="fas fa-user-check stats-icon" style="font-size: 2.5rem !important; color: white !important; opacity: 0.8 !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stats-card stats-card-info" style="background: linear-gradient(135deg, #1976d2, #0d47a1) !important; border: none !important; border-radius: 8px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important; min-height: 120px !important;">
                <div class="card-body" style="padding: 1.5rem !important; color: white !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number" style="font-size: 2rem !important; font-weight: 700 !important; color: white !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;">{{ $trabajadores->where('tipo_contrato', 'Indefinido')->count() }}</div>
                            <div class="stats-label" style="font-size: 0.9rem !important; color: white !important; font-weight: 500 !important;">Contrato Indefinido</div>
                        </div>
                        <div>
                            <i class="fas fa-file-contract stats-icon" style="font-size: 2.5rem !important; color: white !important; opacity: 0.8 !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stats-card stats-card-warning" style="background: linear-gradient(135deg, #f57c00, #e65100) !important; border: none !important; border-radius: 8px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important; min-height: 120px !important;">
                <div class="card-body" style="padding: 1.5rem !important; color: white !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number" style="font-size: 2rem !important; font-weight: 700 !important; color: white !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;">{{ $trabajadores->where('tipo_contrato', 'Temporal')->count() }}</div>
                            <div class="stats-label" style="font-size: 0.9rem !important; color: white !important; font-weight: 500 !important;">Contratos Temporales</div>
                        </div>
                        <div>
                            <i class="fas fa-chart-bar stats-icon" style="font-size: 2.5rem !important; color: white !important; opacity: 0.8 !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="ajaxResponse"></div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="ajaxResponse"></div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-top border-3 shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title fw-bold" style="color: var(--cacao-dark);">
                                <i class="fas fa-list me-1" style="color: var(--cacao-accent);"></i> Listado de Trabajadores
                            </h3>
                            <div class="card-tools">
                                <div class="input-group">
                                    <input type="text" name="table_search" class="form-control" placeholder="Buscar trabajador...">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search" style="color: var(--cacao-medium);"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="trabajadoresTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="5%">ID</th>
                                        <th width="20%">Nombre</th>
                                        <th width="20%">Dirección</th>
                                        <th width="15%">Email</th>
                                        <th width="10%">Teléfono</th>
                                        <th width="10%">Contrato</th>
                                        <th width="10%">Estado</th>
                                        <th width="10%">Pago</th>
                                        <th class="text-center" width="10%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                @forelse($trabajadores as $trabajador)
                    <tr data-id="{{ $trabajador->id }}">
                        <td class="text-center">{{ $trabajador->id }}</td>
                        <td class="nombre-trabajador fw-bold">{{ $trabajador->user->name }}</td>
                        <td class="direccion-trabajador">{{ $trabajador->direccion }}</td>
                        <td class="email-trabajador">
                            <a href="mailto:{{ $trabajador->user->email }}">{{ $trabajador->user->email }}</a>
                        </td>
                        <td class="telefono-trabajador">{{ $trabajador->telefono }}</td>
                        <td class="contrato-trabajador">
                            <span class="badge bg-{{ 
                                $trabajador->tipo_contrato == 'Indefinido' ? 'success' : 
                                ($trabajador->tipo_contrato == 'Temporal' ? 'warning' : 
                                ($trabajador->tipo_contrato == 'Obra o labor' ? 'info' : 'secondary')) 
                            }}">
                                {{ $trabajador->tipo_contrato }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $trabajador->user->estado === 'activo' ? 'success' : 'secondary' }}" 
                                  style="background: {{ $trabajador->user->estado === 'activo' ? 'linear-gradient(135deg, #27ae60, #2ecc71)' : 'linear-gradient(135deg, var(--cacao-medium), var(--cacao-light))' }}; 
                                         color: white; 
                                         padding: 6px 12px; 
                                         border-radius: 15px; 
                                         font-size: 0.85em;">
                                {{ ucfirst($trabajador->user->estado) }}
                            </span>
                        </td>
                        <td class="pago-trabajador">
                            <i class="fas {{ 
                                $trabajador->forma_pago == 'Transferencia' ? 'fa-university' : 
                                ($trabajador->forma_pago == 'Efectivo' ? 'fa-money-bill-wave' : 'fa-money-check') 
                            }} me-1" style="color: var(--cacao-accent);"></i>
                            {{ $trabajador->forma_pago }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <!-- Ver -->
                                <button type="button" class="btn btn-sm btn-outline-info ver-trabajador" 
                                        data-id="{{ $trabajador->id }}" 
                                        data-bs-toggle="tooltip" 
                                        title="Ver detalles">
                                    <i class="fas fa-eye" style="color: var(--cacao-accent);"></i>
                                </button>

                                <!-- Editar -->
                                <button type="button" class="btn btn-sm btn-outline-warning btn-editar" 
                                        data-id="{{ $trabajador->id }}" 
                                        data-bs-toggle="tooltip" 
                                        title="Editar">
                                    <i class="fas fa-edit" style="color: var(--cacao-accent);"></i>
                                </button>

                                <!-- Eliminar -->
                                <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar" 
                                        data-id="{{ $trabajador->id }}" 
                                        data-nombre="{{ $trabajador->user->name }}"
                                        data-bs-toggle="tooltip" 
                                        title="Eliminar">
                                    <i class="fas fa-trash" style="color: var(--cacao-dark);"></i>
                                </button>

                                <!-- Activar/Desactivar -->
                                <form method="POST" action="{{ route('trabajadores.toggleEstado', $trabajador->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $trabajador->user->estado === 'activo' ? 'btn-outline-secondary' : 'btn-outline-success' }}" 
                                            title="{{ $trabajador->user->estado === 'activo' ? 'Desactivar' : 'Activar' }}">
                                        <i class="fas {{ $trabajador->user->estado === 'activo' ? 'fa-user-slash' : 'fa-user-check' }}" 
                                           style="color: {{ $trabajador->user->estado === 'activo' ? 'var(--cacao-medium)' : '#27ae60' }};"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
               
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No hay trabajadores registrados</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted">Total: <strong>{{ count($trabajadores) }}</strong> trabajadores</span>
                            </div>
                            <!-- Aquí iría la paginación si se implementa -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

            
            

<!-- Modal para Editar Trabajador (Bootstrap 5) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium));">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-user-edit me-2"></i> Editar Trabajador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form id="formEditarTrabajador">
                @csrf
                <input type="hidden" id="trabajador_id" name="trabajador_id">
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="errorAlert"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">
                                    <i class="fas fa-user me-1"></i> Nombre
                                </label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">
                                    <i class="fas fa-phone me-1"></i> Teléfono
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="direccion" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i> Dirección
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo_contrato" class="form-label">
                                    <i class="fas fa-file-contract me-1"></i> Tipo de Contrato
                                </label>
                                <select class="form-select" id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="Indefinido">Indefinido</option>
                                    <option value="Temporal">Temporal</option>
                                    <option value="Obra o labor">Obra o labor</option>
                                    <option value="Prestación de servicios">Prestación de servicios</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="forma_pago" class="form-label">
                                    <i class="fas fa-money-bill-wave me-1"></i> Forma de Pago
                                </label>
                                <select class="form-select" id="forma_pago" name="forma_pago" required>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: linear-gradient(135deg, #6c757d, #5a6268); border: none;">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-accent)); border: none;">
                        <i class="fas fa-save me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal para Ver Trabajador (Bootstrap 5) -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-light));">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-user-circle me-2"></i> Detalles del Trabajador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-5x" style="color: var(--cacao-accent);"></i>
                    <h4 class="mt-2 view-nombre fw-bold"></h4>
                </div>
                
                <div class="card">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-envelope fa-lg" style="color: var(--cacao-accent);"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Email</small>
                                        <p class="mb-0 view-email"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-phone fa-lg" style="color: var(--cacao-accent);"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Teléfono</small>
                                        <p class="mb-0 view-telefono"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-map-marker-alt fa-lg" style="color: var(--cacao-accent);"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Dirección</small>
                                        <p class="mb-0 view-direccion"></p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-file-contract fa-lg" style="color: var(--cacao-accent);"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Tipo de Contrato</small>
                                        <p class="mb-0">
                                            <span class="badge view-contrato" style="background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-accent)); color: white;"></span>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-money-bill-wave fa-lg" style="color: var(--cacao-accent);"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Forma de Pago</small>
                                        <p class="mb-0 view-pago"></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: linear-gradient(135deg, #6c757d, #5a6268); border: none;">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal de confirmación para eliminar (Bootstrap 5) -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white" style="background: linear-gradient(135deg, #dc3545, #c82333) !important;">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body text-center">
                <i class="fas fa-user-times fa-4x text-danger mb-3"></i>
                <p>¿Está seguro de eliminar al trabajador <strong id="delete-nombre"></strong>?</p>
                <p class="text-muted small">Esta acción no se puede deshacer.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: linear-gradient(135deg, #6c757d, #5a6268); border: none;">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmarEliminar" style="background: linear-gradient(135deg, #dc3545, #c82333); border: none;">
                    <i class="fas fa-trash me-1"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')

@endsection