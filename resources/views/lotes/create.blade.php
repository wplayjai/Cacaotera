{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\create.blade.php --}}
@extends('layouts.masterr')

@section('content')
<style>
:root {
    --cacao-primary: #4a3728;
    --cacao-secondary: #6b4e3d;
    --cacao-accent: #8b6f47;
    --cacao-light: #d4c4b0;
    --cacao-bg: #f8f6f4;
    --cacao-white: #ffffff;
    --cacao-text: #2c1810;
    --cacao-muted: #8d6e63;
    --success: #2e7d32;
    --warning: #f57c00;
    --danger: #c62828;
    --info: #1976d2;
}

body {
    color: var(--cacao-text);
}

.container-fluid {
    padding: 1.5rem;
    max-width: 100%;
    margin: 0;
}

/* Título principal */
.main-title {
    color: var(--cacao-primary);
    font-size: 1.8rem;
    font-weight: 600;
    text-align: left;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--cacao-light);
    padding-bottom: 0.75rem;
}

/* Dashboard Cards */
.stats-card {
    background: linear-gradient(135deg, var(--cacao-white) 0%, #f8f9fa 100%);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
}

.stats-card .icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.stats-card .value {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-card .label {
    font-size: 0.9rem;
    color: var(--cacao-muted);
    font-weight: 500;
}

.stats-primary .icon {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
}

.stats-success .icon {
    background: linear-gradient(135deg, var(--success), #4caf50);
    color: var(--cacao-white);
}

.stats-warning .icon {
    background: linear-gradient(135deg, var(--warning), #ff9800);
    color: var(--cacao-white);
}

.stats-info .icon {
    background: linear-gradient(135deg, var(--info), #2196f3);
    color: var(--cacao-white);
}

/* Búsqueda discreta en la parte superior */
.search-container-top {
    position: relative;
    width: 280px;
}

.search-input-top {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.5rem 2.5rem 0.5rem 1rem;
    background: var(--cacao-white);
    font-size: 0.85rem;
    transition: all 0.2s ease;
    width: 100%;
}

.search-input-top:focus {
    border-color: var(--cacao-primary);
    box-shadow: 0 0 0 0.1rem rgba(139, 111, 71, 0.1);
    outline: none;
}

.search-icon {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--cacao-muted);
    font-size: 0.85rem;
    pointer-events: none;
}

/* Botones principales */
.btn-professional {
    border: none;
    border-radius: 6px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-crear {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
    box-shadow: 0 2px 4px rgba(74, 55, 40, 0.2);
}

.btn-crear:hover {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(74, 55, 40, 0.25);
}

.btn-reporte {
    background-color: var(--cacao-accent);
    color: var(--cacao-white);
    box-shadow: 0 2px 4px rgba(139, 111, 71, 0.2);
}

.btn-reporte:hover {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(139, 111, 71, 0.25);
}

/* Tarjeta principal */
.main-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.card-header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    padding: 1.25rem 1.5rem;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
}

.card-title-professional {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Tabla expandida */
.table-professional {
    margin: 0;
    font-size: 0.85rem;
}

.table-professional thead th {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
    padding: 0.9rem 0.6rem;
    font-weight: 600;
    font-size: 0.8rem;
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid var(--cacao-secondary);
    white-space: nowrap;
}

.table-professional tbody td {
    padding: 0.8rem 0.6rem;
    vertical-align: middle;
    border-color: var(--cacao-light);
    text-align: center;
    font-size: 0.8rem;
}

.table-professional tbody tr {
    transition: background-color 0.15s ease;
}

.table-professional tbody tr:hover {
    background-color: rgba(139, 111, 71, 0.05);
}

/* Badges */
.badge-professional {
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-area {
    background-color: var(--info);
    color: var(--cacao-white);
}

.badge-capacidad {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-activo {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-inactivo {
    background-color: var(--danger);
    color: var(--cacao-white);
}

/* Botones de acción */
.btn-action {
    border: none;
    border-radius: 4px;
    padding: 0.4rem 0.8rem;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
    margin: 0 0.2rem;
}

.btn-edit {
    background-color: var(--warning);
    color: var(--cacao-white);
}

.btn-edit:hover {
    background-color: #ef6c00;
    color: var(--cacao-white);
}

.btn-delete {
    background-color: var(--danger);
    color: var(--cacao-white);
}

.btn-delete:hover {
    background-color: #b71c1c;
    color: var(--cacao-white);
}

/* Formularios */
.form-control-professional, .form-select-professional {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: border-color 0.2s ease;
    background: var(--cacao-white);
}

.form-control-professional:focus, .form-select-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.15rem rgba(139, 111, 71, 0.15);
    outline: none;
}

.form-label {
    font-weight: 500;
    color: var(--cacao-text);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

/* Modales */
.modal-content-professional {
    border: none;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.modal-header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    border-radius: 8px 8px 0 0;
    padding: 1.25rem 1.5rem;
    border-bottom: none;
}

.modal-footer-professional {
    background-color: #f8f9fa;
    border-radius: 0 0 8px 8px;
    padding: 1.25rem 1.5rem;
    border-top: 1px solid var(--cacao-light);
}

.btn-secondary-professional {
    background-color: #6c757d;
    color: var(--cacao-white);
    border: none;
}

.btn-secondary-professional:hover {
    background-color: #5a6268;
    color: var(--cacao-white);
}

.btn-primary-professional {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
}

.btn-primary-professional:hover {
    background-color: var(--cacao-secondary);
    color: var(--cacao-white);
}

/* Estados responsivos */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .main-title {
        font-size: 1.5rem;
        text-align: center;
    }
    
    .search-container-top {
        width: 200px;
    }
    
    .btn-professional {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
    }
    
    .table-professional {
        font-size: 0.75rem;
    }
    
    .table-professional thead th,
    .table-professional tbody td {
        padding: 0.6rem 0.4rem;
    }
    
    .stats-card .value {
        font-size: 1.5rem;
    }
}

/* Mensaje sin resultados */
.no-results {
    color: var(--cacao-muted);
    font-style: italic;
}

.no-results i {
    color: var(--cacao-light);
}

/* Success modals - más discretos */
.modal-success {
    border-radius: 8px;
    background: var(--cacao-white);
}

.success-icon {
    width: 60px;
    height: 60px;
    background-color: var(--success);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.success-title {
    color: var(--cacao-primary);
    font-weight: 600;
    margin-bottom: 1rem;
}

.success-text {
    color: var(--cacao-muted);
    margin-bottom: 1.5rem;
}
</style>

<div class="container-fluid">
    <h1 class="main-title">
        <i class="fas fa-seedling me-2"></i>
        Gestión de Lotes de Cacao
    </h1>

    <!-- Dashboard de Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ count($lotes ?? []) }}</div>
                        <div class="label">Lotes Totales</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ collect($lotes ?? [])->where('estado', 'Activo')->count() }}</div>
                        <div class="label">Lotes Activos</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ collect($lotes ?? [])->where('estado', 'Inactivo')->count() }}</div>
                        <div class="label">Lotes Inactivos</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ number_format(collect($lotes ?? [])->sum('area'), 0, ',', '.') }}</div>
                        <div class="label">Área Total (m²)</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Botones de Acción y Búsqueda -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-professional btn-crear" data-bs-toggle="modal" data-bs-target="#crearLoteModal">
                <i class="fas fa-plus"></i>
                Crear Nuevo Lote
            </button>
            <!-- Búsqueda discreta -->
            <div class="search-container-top">
                <input type="text" id="buscarVariedad" class="form-control search-input-top" placeholder="Buscar lote...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url('/reporte') }}" class="btn btn-professional btn-reporte">
                <i class="fas fa-chart-line"></i>
                Ver Reportes
            </a>
        </div>
    </div>
    
    <div class="card main-card">
        <div class="card-header card-header-professional">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title-professional">
                    <i class="fas fa-list-alt"></i>
                    Lotes Registrados
                    <span class="badge bg-light text-dark ms-2" id="totalLotes">{{ count($lotes) }}</span>
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-professional btn-sm" onclick="exportarTabla()">
                        <i class="fas fa-download me-1"></i>Exportar
                    </button>
                    <button class="btn btn-professional btn-sm" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Imprimir
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-professional" id="tablaLotes">
                    <thead>
                        <tr>
                            <th><i class="fas fa-tag me-1"></i> Nombre</th>
                            <th><i class="fas fa-calendar me-1"></i> Fecha Inicio</th>
                            <th><i class="fas fa-expand-arrows-alt me-1"></i> Área (m²)</th>
                            <th><i class="fas fa-tree me-1"></i> Capacidad</th>
                            <th><i class="fas fa-leaf me-1"></i> Tipo Cacao</th>
                            <th><i class="fas fa-toggle-on me-1"></i> Estado</th>
                            <th><i class="fas fa-sticky-note me-1"></i> Observaciones</th>
                            <th><i class="fas fa-cogs me-1"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lotes as $lote)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $lote->nombre }}</div>
                                    <small class="text-muted">Lote #{{ $loop->iteration }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ \Carbon\Carbon::parse($lote->fecha_inicio)->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($lote->fecha_inicio)->locale('es')->isoFormat('MMM YYYY') }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-professional badge-area">
                                        {{ number_format($lote->area, 0, ',', '.') }} m²
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-professional badge-capacidad">
                                        {{ number_format($lote->capacidad, 0, ',', '.') }} árboles
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold" style="color: var(--cacao-accent);">
                                        <i class="fas fa-seedling me-1"></i>{{ $lote->tipo_cacao }}
                                    </div>
                                </td>
                                <td>
                                    @if($lote->estado === 'Activo')
                                        <span class="badge badge-professional badge-activo">
                                            <i class="fas fa-check-circle me-1"></i>Activo
                                        </span>
                                    @else
                                        <span class="badge badge-professional badge-inactivo">
                                            <i class="fas fa-times-circle me-1"></i>Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($lote->observaciones)
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $lote->observaciones }}">
                                            {{ $lote->observaciones }}
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">Sin observaciones</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editarLoteModal" onclick="cargarDatosLote({{ $lote }})">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </button>
                                        <button type="button" class="btn btn-action btn-delete" onclick="verificarEliminarLote('{{ $lote->estado }}', '{{ route('lotes.destroy', $lote->id) }}')">
                                            <i class="fas fa-trash me-1"></i>Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="no-results">
                                        <i class="fas fa-seedling fa-3x mb-3"></i>
                                        <h5>No hay lotes registrados</h5>
                                        <p>Comience creando su primer lote de cacao</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Crear Lote --}}
<div class="modal fade" id="crearLoteModal" tabindex="-1" aria-labelledby="crearLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <form id="formCrearLote" action="{{ route('lotes.store') }}" method="POST">
                @csrf
                <div class="modal-header modal-header-professional">
                    <h5 class="modal-title fw-bold" id="crearLoteModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Lote
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nombre del Lote
                            </label>
                            <input type="text" class="form-control form-control-professional" id="nombre" name="nombre" required placeholder="Ej. Lote Norte A">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>Fecha de Inicio
                            </label>
                            <input type="date" class="form-control form-control-professional" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="area" class="form-label">
                                <i class="fas fa-expand-arrows-alt me-2"></i>Área (m²)
                            </label>
                            <input type="number" class="form-control form-control-professional" id="area" name="area" required placeholder="Ej. 5000">
                        </div>
                        <div class="col-md-6">
                            <label for="capacidad" class="form-label">
                                <i class="fas fa-tree me-2"></i>Capacidad (árboles)
                            </label>
                            <input type="number" class="form-control form-control-professional" id="capacidad" name="capacidad" required min="1" max="99999" maxlength="5" placeholder="Ej. 200" oninput="if(this.value.length>5)this.value=this.value.slice(0,5);">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_cacao" class="form-label">
                                <i class="fas fa-seedling me-2"></i>Tipo de Cacao
                            </label>
                            <select class="form-select form-select-professional" id="tipo_cacao" name="tipo_cacao" required>
                                <option value="">Seleccione el tipo...</option>
                                <option value="CCN-51">CCN-51</option>
                                <option value="ICS-95">ICS-95</option>
                                <option value="TCS-13">TCS-13</option>
                                <option value="EET-96">EET-96</option>
                                <option value="CC-137">CC-137</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">
                                <i class="fas fa-toggle-on me-2"></i>Estado
                            </label>
                            <select class="form-select form-select-professional" id="estado" name="estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="observaciones" class="form-label">
                                <i class="fas fa-sticky-note me-2"></i>Observaciones
                            </label>
                            <textarea class="form-control form-control-professional" id="observaciones" name="observaciones" rows="3" placeholder="Ingrese observaciones adicionales..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-professional">
                    <button type="button" class="btn btn-professional btn-secondary-professional" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" id="btnGuardarLote" class="btn btn-professional btn-primary-professional">
                        <i class="fas fa-save me-2"></i>Guardar Lote
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Editar Lote --}}
<div class="modal fade" id="editarLoteModal" tabindex="-1" aria-labelledby="editarLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <form id="editarLoteForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-professional">
                    <h5 class="modal-title fw-bold" id="editarLoteModalLabel">
                        <i class="fas fa-edit me-2"></i>Editar Lote
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="edit_nombre" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nombre del Lote
                            </label>
                            <input type="text" class="form-control form-control-professional" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fecha_inicio" class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>Fecha de Inicio
                            </label>
                            <input type="date" class="form-control form-control-professional" id="edit_fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_area" class="form-label">
                                <i class="fas fa-expand-arrows-alt me-2"></i>Área (m²)
                            </label>
                            <input type="number" class="form-control form-control-professional" id="edit_area" name="area" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_capacidad" class="form-label">
                                <i class="fas fa-tree me-2"></i>Capacidad (árboles)
                            </label>
                            <input type="number" class="form-control form-control-professional" id="edit_capacidad" name="capacidad" required min="1" max="99999" maxlength="5" oninput="if(this.value.length>5)this.value=this.value.slice(0,5);">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_tipo_cacao" class="form-label">
                                <i class="fas fa-seedling me-2"></i>Tipo de Cacao
                            </label>
                            <select class="form-select form-select-professional" id="edit_tipo_cacao" name="tipo_cacao" required>
                                <option value="">Seleccione el tipo...</option>
                                <option value="CCN-51">CCN-51</option>
                                <option value="ICS-95">ICS-95</option>
                                <option value="TCS-13">TCS-13</option>
                                <option value="EET-96">EET-96</option>
                                <option value="CC-137">CC-137</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_estado" class="form-label">
                                <i class="fas fa-toggle-on me-2"></i>Estado
                            </label>
                            <select class="form-select form-select-professional" id="edit_estado" name="estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="edit_observaciones" class="form-label">
                                <i class="fas fa-sticky-note me-2"></i>Observaciones
                            </label>
                            <textarea class="form-control form-control-professional" id="edit_observaciones" name="observaciones" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-professional">
                    <button type="button" class="btn btn-professional btn-secondary-professional" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-professional btn-primary-professional">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Éxito Crear --}}
<div class="modal fade" id="modalExitoLote" tabindex="-1" aria-labelledby="modalExitoLoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-success">
            <div class="modal-body text-center p-5">
                <div class="success-icon">
                    <i class="fas fa-check text-white" style="font-size: 1.5rem;"></i>
                </div>
                <h4 class="success-title">Lote Creado Exitosamente</h4>
                <p class="success-text">El nuevo lote de cacao ha sido registrado correctamente en el sistema.</p>
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Cerrando automáticamente en <span id="countdown">3</span> segundos...
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Modal Éxito Editar --}}
<div class="modal fade" id="modalExitoEditarLote" tabindex="-1" aria-labelledby="modalExitoEditarLoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-success">
            <div class="modal-body text-center p-5">
                <div class="success-icon">
                    <i class="fas fa-edit text-white" style="font-size: 1.5rem;"></i>
                </div>
                <h4 class="success-title">Lote Actualizado Correctamente</h4>
                <p class="success-text">Los cambios han sido guardados exitosamente en el sistema.</p>
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>Cerrando automáticamente en <span id="countdownEdit">3</span> segundos...
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Modal Lote Activo --}}
<div class="modal fade" id="modalLoteActivo" tabindex="-1" aria-labelledby="modalLoteActivoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <div class="modal-header" style="background-color: var(--warning); color: var(--cacao-white);">
                <h5 class="modal-title fw-bold" id="modalLoteActivoLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Lote Activo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-3x" style="color: var(--warning);"></i>
                </div>
                <h5 class="fw-bold mb-3" style="color: var(--cacao-text);">
                    Este lote está <span style="color: var(--success);">ACTIVO</span> y no se puede eliminar
                </h5>
                <p class="text-muted">
                    Los lotes activos están siendo utilizados en el sistema y no pueden eliminarse por seguridad.
                </p>
            </div>
            <div class="modal-footer modal-footer-professional justify-content-center">
                <button type="button" class="btn btn-professional btn-primary-professional" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>Entendido
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function verificarEliminarLote(estado, rutaEliminar) {
    if (estado.trim().toLowerCase() === 'activo') {
        new bootstrap.Modal(document.getElementById('modalLoteActivo')).show();
    } else {
        if (confirm('¿Está seguro de que desea eliminar este lote? Esta acción no se puede deshacer.')) {
            let form = document.createElement('form');
            form.action = rutaEliminar;
            form.method = 'POST';
            form.style.display = 'none';
            let csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            let method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }
}

function cargarDatosLote(lote) {
    const form = document.getElementById('editarLoteForm');
    form.action = '/lotes/' + lote.id;
    document.getElementById('edit_nombre').value = lote.nombre || '';
    document.getElementById('edit_fecha_inicio').value = lote.fecha_inicio || '';
    document.getElementById('edit_area').value = lote.area || '';
    document.getElementById('edit_capacidad').value = lote.capacidad || '';
    document.getElementById('edit_tipo_cacao').value = lote.tipo_cacao || '';
    document.getElementById('edit_estado').value = lote.estado || '';
    document.getElementById('edit_observaciones').value = lote.observaciones || '';
}

document.addEventListener('DOMContentLoaded', function() {
    const crearLoteModal = document.getElementById('crearLoteModal');
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const formCrearLote = document.getElementById('formCrearLote');
    
    // Configurar modal crear
    crearLoteModal.addEventListener('show.bs.modal', function() {
        formCrearLote.reset();
        const btnGuardar = document.getElementById('btnGuardarLote');
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Lote';
        
        // Establecer fecha actual
        const hoy = new Date();
        const year = hoy.getFullYear();
        const month = String(hoy.getMonth() + 1).padStart(2, '0');
        const day = String(hoy.getDate()).padStart(2, '0');
        fechaInicioInput.value = `${year}-${month}-${day}`;
        
        // Limpiar campos
        document.getElementById('nombre').value = '';
        document.getElementById('area').value = '';
        document.getElementById('capacidad').value = '';
        document.getElementById('tipo_cacao').value = '';
        document.getElementById('observaciones').value = '';
        document.getElementById('estado').value = 'Activo';
    });

    // Manejar envío de formulario crear
    formCrearLote.addEventListener('submit', function(e) {
        e.preventDefault();
        const btnGuardar = document.getElementById('btnGuardarLote');
        
        if (btnGuardar.disabled) return;
        
        btnGuardar.disabled = true;
        const textoOriginal = btnGuardar.innerHTML;
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        
        const formData = new FormData(formCrearLote);
        
        fetch(formCrearLote.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (response.ok) {
                bootstrap.Modal.getInstance(document.getElementById('crearLoteModal')).hide();
                const modalExito = new bootstrap.Modal(document.getElementById('modalExitoLote'));
                modalExito.show();
                
                let countdown = 3;
                const countdownElement = document.getElementById('countdown');
                const countdownInterval = setInterval(() => {
                    countdown--;
                    countdownElement.textContent = countdown;
                    if (countdown <= 0) clearInterval(countdownInterval);
                }, 1000);
                
                setTimeout(function() {
                    modalExito.hide();
                    setTimeout(function() {
                        window.location.reload();
                    }, 300);
                }, 3000);
            } else {
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = textoOriginal;
                alert('Error al crear el lote. Por favor, inténtelo de nuevo.');
            }
        })
        .catch(error => {
            btnGuardar.disabled = false;
            btnGuardar.innerHTML = textoOriginal;
            console.error('Error:', error);
            alert('Error al crear el lote. Por favor, inténtelo de nuevo.');
        });
    });

    // Manejar envío de formulario editar
    const formEditarLote = document.getElementById('editarLoteForm');
    formEditarLote.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formEditarLote);
        
        fetch(formEditarLote.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (response.ok) {
                bootstrap.Modal.getInstance(document.getElementById('editarLoteModal')).hide();
                const modalExitoEditar = new bootstrap.Modal(document.getElementById('modalExitoEditarLote'));
                modalExitoEditar.show();
                
                let countdownEdit = 3;
                const countdownEditElement = document.getElementById('countdownEdit');
                const countdownEditInterval = setInterval(() => {
                    countdownEdit--;
                    countdownEditElement.textContent = countdownEdit;
                    if (countdownEdit <= 0) clearInterval(countdownEditInterval);
                }, 1000);
                
                setTimeout(function() {
                    modalExitoEditar.hide();
                    setTimeout(function() {
                        window.location.reload();
                    }, 300);
                }, 3000);
            } else {
                alert('Error al editar el lote. Por favor, inténtelo de nuevo.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al editar el lote. Por favor, inténtelo de nuevo.');
        });
    });

    // Funcionalidad de búsqueda simplificada
    const buscarInput = document.getElementById('buscarVariedad');
    const tablaLotes = document.getElementById('tablaLotes');
    const filasLotes = tablaLotes.querySelectorAll('tbody tr');
    const totalLotesElement = document.getElementById('totalLotes');
    
    // Función para exportar tabla
    window.exportarTabla = function() {
        let csv = 'Nombre,Fecha Inicio,Área,Capacidad,Tipo Cacao,Estado,Observaciones\n';
        
        const filasVisibles = Array.from(filasLotes).filter(fila => fila.style.display !== 'none' && !fila.classList.contains('mensaje-sin-resultados'));
        
        if (filasVisibles.length === 0) {
            alert('No hay datos para exportar');
            return;
        }
        
        filasVisibles.forEach(function(fila) {
            const celdas = fila.querySelectorAll('td');
            if (celdas.length > 0) {
                const datos = [
                    celdas[0].querySelector('.fw-bold')?.textContent?.trim() || '',
                    celdas[1].querySelector('.fw-medium')?.textContent?.trim() || '',
                    celdas[2].textContent.trim(),
                    celdas[3].textContent.trim(),
                    celdas[4].textContent.trim(),
                    celdas[5].textContent.trim(),
                    celdas[6].textContent.trim()
                ];
                csv += datos.map(campo => `"${campo}"`).join(',') + '\n';
            }
        });
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `lotes_${new Date().toISOString().split('T')[0]}.csv`;
        link.click();
        window.URL.revokeObjectURL(url);
    };
    
    buscarInput.addEventListener('input', function() {
        const terminoBusqueda = this.value.toLowerCase().trim();
        let lotesVisibles = 0;
        
        filasLotes.forEach(function(fila) {
            if (fila.classList.contains('mensaje-sin-resultados')) {
                fila.remove();
                return;
            }
            
            const nombreCelda = fila.querySelector('td:first-child');
            if (nombreCelda) {
                const nombreCompleto = nombreCelda.querySelector('.fw-bold')?.textContent?.toLowerCase()?.trim() || '';
                let coincide = false;
                
                if (terminoBusqueda === '') {
                    coincide = true;
                } else if (terminoBusqueda.length === 1) {
                    coincide = nombreCompleto.startsWith(terminoBusqueda);
                } else {
                    coincide = nombreCompleto.includes(terminoBusqueda);
                }
                
                fila.style.display = coincide ? '' : 'none';
                if (coincide) lotesVisibles++;
            }
        });
        
        // Actualizar contador
        totalLotesElement.textContent = lotesVisibles;
        
        // Mostrar mensaje si no hay resultados
        const tbody = tablaLotes.querySelector('tbody');
        const mensajeAnterior = tbody.querySelector('.mensaje-sin-resultados');
        if (mensajeAnterior) mensajeAnterior.remove();
        
        if (lotesVisibles === 0 && terminoBusqueda !== '') {
            const filaMensaje = document.createElement('tr');
            filaMensaje.className = 'mensaje-sin-resultados';
            filaMensaje.innerHTML = `
                <td colspan="8" class="text-center py-5">
                    <div class="no-results">
                        <i class="fas fa-search-minus fa-3x mb-3 text-muted"></i>
                        <h5 class="text-muted">No se encontraron lotes</h5>
                        <p class="text-muted">No hay lotes que coincidan con "${terminoBusqueda}"</p>
                        <button class="btn btn-professional btn-sm" onclick="limpiarBusqueda()">
                            <i class="fas fa-undo me-1"></i>Limpiar Búsqueda
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(filaMensaje);
        }
    });
    
    // Función para limpiar búsqueda
    window.limpiarBusqueda = function() {
        buscarInput.value = '';
        buscarInput.dispatchEvent(new Event('input'));
    };
});
</script>
@endsection