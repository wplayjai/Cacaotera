@extends('layouts.masterr')

@section('content')
<link rel="stylesheet" href="{{ asset('css/lotes/create.css') }}">

<div class="container-fluid">
    <!-- Título simplificado sin icono -->
    <h1 class="main-title">
        Gestión de Lotes de Cacao
    </h1>

    <!-- Dashboard con diseño más limpio y menos colores -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="stats-content">
                    <div class="stats-value">{{ count($lotes ?? []) }}</div>
                    <div class="stats-label">Lotes Totales</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-success">
                <div class="stats-content">
                    <div class="stats-value">{{ collect($lotes ?? [])->where('estado', 'Activo')->count() }}</div>
                    <div class="stats-label">Lotes Activos</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="stats-content">
                    <div class="stats-value">{{ collect($lotes ?? [])->where('estado', 'Inactivo')->count() }}</div>
                    <div class="stats-label">Lotes Inactivos</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="stats-content">
                    <div class="stats-value">{{ number_format(collect($lotes ?? [])->sum('area'), 0, ',', '.') }}</div>
                    <div class="stats-label">Área Total (m²)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra de acciones simplificada -->
    <div class="actions-bar">
        <div class="actions-left">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearLoteModal">
                Crear Nuevo Lote
            </button>
            <div class="search-container">
                <input type="text" id="buscarVariedad" class="search-input" placeholder="Buscar lote...">
            </div>
        </div>
        <div class="actions-right">
            <a href="{{ route('lotes.pdf') }}" class="btn btn-secondary" target="_blank">
                Descargar PDF
            </a>
        </div>
    </div>

    <!-- Tabla con diseño más limpio -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Lotes Registrados
                <span class="badge" id="totalLotes">{{ count($lotes) }}</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="tablaLotes">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha Inicio</th>
                            <th>Área (m²)</th>
                            <th>Capacidad</th>
                            <th>Tipo Cacao</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lotes as $lote)
                            <tr>
                                <td>
                                    <div class="lote-name">{{ $lote->nombre }}</div>
                                    <small class="lote-number">Lote #{{ $loop->iteration }}</small>
                                </td>
                                <td>
                                    <div class="date-main">{{ \Carbon\Carbon::parse($lote->fecha_inicio)->format('d/m/Y') }}</div>
                                    <small class="date-sub">{{ \Carbon\Carbon::parse($lote->fecha_inicio)->locale('es')->isoFormat('MMM YYYY') }}</small>
                                </td>
                                <td>
                                    <span class="value-badge">
                                        {{ number_format($lote->area, 0, ',', '.') }} m²
                                    </span>
                                </td>
                                <td>
                                    <span class="value-badge">
                                        {{ number_format($lote->capacidad, 0, ',', '.') }} árboles
                                    </span>
                                </td>
                                <td>
                                    <div class="tipo-cacao">{{ $lote->tipo_cacao }}</div>
                                </td>
                                <td>
                                    @if($lote->estado === 'Activo')
                                        <span class="status-badge status-active">Activo</span>
                                    @else
                                        <span class="status-badge status-inactive">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lote->observaciones)
                                        <div class="observaciones" title="{{ $lote->observaciones }}">
                                            {{ $lote->observaciones }}
                                        </div>
                                    @else
                                        <span class="no-data">Sin observaciones</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editarLoteModal"
                                            onclick='cargarDatosLote({
                                                id: {{ $lote->id }},
                                                nombre: @json($lote->nombre),
                                                fecha_inicio: "{{ \Carbon\Carbon::parse($lote->fecha_inicio)->format('Y-m-d') }}",
                                                area: {{ $lote->area }},
                                                capacidad: {{ $lote->capacidad }},
                                                tipo_cacao: @json($lote->tipo_cacao),
                                                estado: @json($lote->estado),
                                                observaciones: @json($lote->observaciones)
                                            })'>
                                            Editar
                                        </button>
                                        <button type="button" class="btn-action btn-delete" onclick="verificarEliminarLote('{{ $lote->estado }}', '{{ route('lotes.destroy', $lote->id) }}')">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <div class="empty-content">
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

{{-- Modales con diseño simplificado --}}
{{-- Modal Crear Lote --}}
<div class="modal fade" id="crearLoteModal" tabindex="-1" aria-labelledby="crearLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formCrearLote" action="{{ route('lotes.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="crearLoteModalLabel">Crear Nuevo Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre del Lote</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej. Lote Norte A">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="area" class="form-label">Área (m²)</label>
                            <input type="number" class="form-control" id="area" name="area" required placeholder="Ej. 5000">
                        </div>
                        <div class="col-md-6">
                            <label for="capacidad" class="form-label">Capacidad (árboles)</label>
                            <input type="number" class="form-control" id="capacidad" name="capacidad" required min="1" max="99999" maxlength="5" placeholder="Ej. 200" oninput="if(this.value.length>5)this.value=this.value.slice(0,5);">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_cacao" class="form-label">Tipo de Cacao</label>
                            <select class="form-select" id="tipo_cacao" name="tipo_cacao" required>
                                <option value="">Seleccione el tipo...</option>
                                <option value="CCN-51">CCN-51</option>
                                <option value="ICS-95">ICS-95</option>
                                <option value="TCS-13">TCS-13</option>
                                <option value="EET-96">EET-96</option>
                                <option value="CC-137">CC-137</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Ingrese observaciones adicionales..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardarLote" class="btn btn-primary">Guardar Lote</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Editar Lote --}}
<div class="modal fade" id="editarLoteModal" tabindex="-1" aria-labelledby="editarLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editarLoteForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editarLoteModalLabel">Editar Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="edit_nombre" class="form-label">Nombre del Lote</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="edit_fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_area" class="form-label">Área (m²)</label>
                            <input type="number" class="form-control" id="edit_area" name="area" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_capacidad" class="form-label">Capacidad (árboles)</label>
                            <input type="number" class="form-control" id="edit_capacidad" name="capacidad" required min="1" max="99999" maxlength="5" oninput="if(this.value.length>5)this.value=this.value.slice(0,5);">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_tipo_cacao" class="form-label">Tipo de Cacao</label>
                            <select class="form-select" id="edit_tipo_cacao" name="tipo_cacao" required>
                                <option value="">Seleccione el tipo...</option>
                                <option value="CCN-51">CCN-51</option>
                                <option value="ICS-95">ICS-95</option>
                                <option value="TCS-13">TCS-13</option>
                                <option value="EET-96">EET-96</option>
                                <option value="CC-137">CC-137</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_estado" class="form-label">Estado</label>
                            <select class="form-select" id="edit_estado" name="estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="edit_observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="edit_observaciones" name="observaciones" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Modal Éxito Crear --}}
<div class="modal fade" id="modalExitoLote" tabindex="-1" aria-labelledby="modalExitoLoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                </div>
                <h4 class="success-title">Lote Creado Exitosamente</h4>
                <p class="success-text">El nuevo lote de cacao ha sido registrado correctamente en el sistema.</p>
                <small class="countdown-text">
                    Cerrando automáticamente en <span id="countdown">3</span> segundos...
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Modal Éxito Editar --}}
<div class="modal fade" id="modalExitoEditarLote" tabindex="-1" aria-labelledby="modalExitoEditarLoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="m18.5 2.5 a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <h4 class="success-title">Lote Actualizado Correctamente</h4>
                <p class="success-text">Los cambios han sido guardados exitosamente en el sistema.</p>
                <small class="countdown-text">
                    Cerrando automáticamente en <span id="countdownEdit">3</span> segundos...
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Modal Lote Activo --}}
<div class="modal fade" id="modalLoteActivo" tabindex="-1" aria-labelledby="modalLoteActivoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header warning-header">
                <h5 class="modal-title" id="modalLoteActivoLabel">Lote Activo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="warning-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                        <path d="M12 9v4"/>
                        <path d="m12 17 .01 0"/>
                    </svg>
                </div>
                <h5 class="warning-title">Este lote está ACTIVO y no se puede eliminar</h5>
                <p class="warning-text">
                    Los lotes activos están siendo utilizados en el sistema y no pueden eliminarse por seguridad.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Confirmar Eliminación --}}
<div class="modal fade" id="modalConfirmarEliminarLote" tabindex="-1" aria-labelledby="modalConfirmarEliminarLoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header danger-header">
                <h5 class="modal-title" id="modalConfirmarEliminarLoteLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="danger-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18"/>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    </svg>
                </div>
                <h5 class="danger-title">¿Está seguro de que desea eliminar este lote?</h5>
                <p class="danger-text">
                    Esta acción no se puede deshacer.<br>
                    El lote será eliminado permanentemente.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminarLote">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/lotes/create.js') }}"></script>
@endsection
