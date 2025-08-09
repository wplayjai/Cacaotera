{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\create.blade.php --}}
@extends('layouts.masterr')

@section('content')
<link rel="stylesheet" href="{{ asset('css/lotes/create.css') }}">
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
            <a href="{{ route('lotes.pdf') }}" class="btn btn-professional btn-reporte" target="_blank">
                <i class="fas fa-file-pdf me-2"></i>
                Descargar PDF
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

<script src="{{ asset('js/lotes/create.js') }}"></script>
@endsection
