@extends('layouts.masterr')

@section('content')
<link rel="stylesheet" href="{{ asset('css/recolecciones/index.css') }}">

<div class="container-fluid">
    <!-- Título simplificado -->
    <h1 class="main-title">
        Gestión de Recolecciones de Cacao
    </h1>

    <!-- Dashboard con estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="stats-content">
                    <div class="stats-value">{{ number_format($recolecciones->sum('cantidad_recolectada'), 2) }}</div>
                    <div class="stats-label">Total Recolectado (KG)</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-success">
                <div class="stats-content">
                    <div class="stats-value">{{ $recolecciones->count() }}</div>
                    <div class="stats-label">Recolecciones del Día</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="stats-content">
                    <div class="stats-value">{{ number_format($recolecciones->avg('calidad_promedio') ?? 0, 1) }}</div>
                    <div class="stats-label">Calidad Promedio</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card">
                <div class="stats-content">
                    <div class="stats-value">{{ $recolecciones->groupBy('produccion_id')->count() }}</div>
                    <div class="stats-label">Lotes Trabajados</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra de acciones simplificada -->
    <div class="actions-bar">
        <div class="actions-left">
            <a href="{{ route('recolecciones.create') }}" class="btn btn-primary">
                Nueva Recolección
            </a>
            <div class="search-container">
                <input type="text" id="buscarRecoleccion" class="search-input" placeholder="Buscar recolección...">
            </div>
        </div>
        <div class="actions-right">
            <a href="{{ route('produccion.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>

    <!-- Tabla con diseño más limpio -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Recolecciones Registradas
                <span class="badge" id="totalRecolecciones">{{ $recolecciones->total() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table" id="tablaRecolecciones">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Lote/Producción</th>
                            <th>Cantidad (kg)</th>
                            <th>Estado Fruto</th>
                            <th>Calidad</th>
                            <th>Condición</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recolecciones as $recoleccion)
                            <tr>
                                <td>
                                    <div class="lote-name">#{{ $recoleccion->id }}</div>
                                    <small class="lote-number">Reg. {{ $loop->iteration }}</small>
                                </td>
                                <td>
                                    <div class="date-main">{{ $recoleccion->fecha_recoleccion->format('d/m/Y') }}</div>
                                    <small class="date-sub">{{ $recoleccion->fecha_recoleccion->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="tipo-cacao">{{ $recoleccion->produccion->lote?->nombre ?? 'N/A' }}</div>
                                    <small class="date-sub">{{ $recoleccion->produccion->tipo_cacao ?? 'CCN-51' }}</small>
                                </td>
                                <td>
                                    <span class="value-badge">
                                        {{ number_format($recoleccion->cantidad_recolectada, 2) }} kg
                                    </span>
                                </td>
                                <td>
                                    @switch($recoleccion->estado_fruto)
                                        @case('maduro')
                                            <span class="status-badge status-active">Maduro</span>
                                            @break
                                        @case('semi-maduro')
                                            <span class="status-badge" style="background: #fff3cd; color: #856404;">Semi-maduro</span>
                                            @break
                                        @default
                                            <span class="status-badge status-inactive">Verde</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="value-badge">
                                        {{ number_format($recoleccion->calidad_promedio ?? 0, 1) }}/5
                                    </span>
                                </td>
                                <td>
                                    <div class="tipo-cacao">{{ ucfirst($recoleccion->condiciones_climaticas ?? 'N/A') }}</div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editarRecoleccionModal"
                                            onclick='cargarDatosRecoleccion({
                                                id: {{ $recoleccion->id }},
                                                produccion_id: {{ $recoleccion->produccion_id }},
                                                cantidad_recolectada: {{ $recoleccion->cantidad_recolectada }},
                                                estado_fruto: @json($recoleccion->estado_fruto),
                                                fecha_recoleccion: "{{ $recoleccion->fecha_recoleccion->format('Y-m-d') }}",
                                                condiciones_climaticas: @json($recoleccion->condiciones_climaticas),
                                                calidad_promedio: {{ $recoleccion->calidad_promedio ?? 0 }},
                                                trabajadores_participantes: @json($recoleccion->trabajadores_participantes),
                                                observaciones: @json($recoleccion->observaciones)
                                            })'>
                                            Editar
                                        </button>
                                        <a href="{{ route('recolecciones.show', $recoleccion->id) }}" class="btn-action btn-edit" style="background: #d1ecf1; color: #0c5460;">
                                            Ver
                                        </a>
                                        <button type="button" class="btn-action btn-delete" onclick="confirmarEliminarRecoleccion('{{ route('recolecciones.destroy', $recoleccion->id) }}')">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <div class="empty-content">
                                        <h5>No hay recolecciones registradas</h5>
                                        <p>Comience creando su primera recolección</p>
                                        <a href="{{ route('recolecciones.create') }}" class="btn btn-primary">
                                            Nueva Recolección
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($recolecciones->hasPages())
                <div class="pagination-wrapper mt-3">
                    {{ $recolecciones->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modales con diseño simplificado --}}
{{-- Modal Editar Recolección --}}
<div class="modal fade" id="editarRecoleccionModal" tabindex="-1" aria-labelledby="editarRecoleccionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editarRecoleccionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editarRecoleccionModalLabel">Editar Recolección</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="edit_produccion_id" class="form-label">Producción/Lote</label>
                            <select class="form-select" id="edit_produccion_id" name="produccion_id" required>
                                <option value="">Seleccionar producción...</option>
                                @foreach($producciones ?? [] as $produccion)
                                    <option value="{{ $produccion->id }}">{{ $produccion->lote?->nombre ?? 'Lote N/A' }} - {{ $produccion->tipo_cacao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_cantidad_recolectada" class="form-label">Cantidad (kg)</label>
                            <input type="number" class="form-control" id="edit_cantidad_recolectada" name="cantidad_recolectada" step="0.001" min="0.001" max="9999.999" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_estado_fruto" class="form-label">Estado del Fruto</label>
                            <select class="form-select" id="edit_estado_fruto" name="estado_fruto" required>
                                <option value="">Seleccionar estado...</option>
                                <option value="maduro">Maduro</option>
                                <option value="semi-maduro">Semi-maduro</option>
                                <option value="verde">Verde</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fecha_recoleccion" class="form-label">Fecha de Recolección</label>
                            <input type="date" class="form-control" id="edit_fecha_recoleccion" name="fecha_recoleccion" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_condiciones_climaticas" class="form-label">Condiciones Climáticas</label>
                            <select class="form-select" id="edit_condiciones_climaticas" name="condiciones_climaticas" required>
                                <option value="">Seleccionar condición...</option>
                                <option value="soleado">Soleado</option>
                                <option value="nublado">Nublado</option>
                                <option value="lluvioso">Lluvioso</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_calidad_promedio" class="form-label">Calidad (1-5)</label>
                            <input type="number" class="form-control" id="edit_calidad_promedio" name="calidad_promedio" min="1" max="5" step="0.1">
                        </div>
                        <div class="col-12">
                            <label for="edit_trabajadores_participantes" class="form-label">Trabajadores Participantes</label>
                            <select class="form-select" id="edit_trabajadores_participantes" name="trabajadores_participantes[]" multiple>
                                @foreach($trabajadores ?? [] as $trabajador)
                                    <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }} {{ $trabajador->apellido }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Mantén presionado Ctrl para seleccionar múltiples trabajadores</small>
                        </div>
                        <div class="col-12">
                            <label for="edit_observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="edit_observaciones" name="observaciones" rows="3" maxlength="500"></textarea>
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

{{-- Modal Éxito Editar --}}
<div class="modal fade" id="modalExitoEditarRecoleccion" tabindex="-1" aria-labelledby="modalExitoEditarRecoleccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="m18.5 2.5 a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <h4 class="success-title">Recolección Actualizada Correctamente</h4>
                <p class="success-text">Los cambios han sido guardados exitosamente en el sistema.</p>
                <small class="countdown-text">
                    Cerrando automáticamente en <span id="countdownEditRecoleccion">3</span> segundos...
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Modal Confirmar Eliminación --}}
<div class="modal fade" id="modalConfirmarEliminarRecoleccion" tabindex="-1" aria-labelledby="modalConfirmarEliminarRecoleccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header danger-header">
                <h5 class="modal-title" id="modalConfirmarEliminarRecoleccionLabel">Confirmar Eliminación</h5>
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
                <h5 class="danger-title">¿Está seguro de que desea eliminar esta recolección?</h5>
                <p class="danger-text">
                    Esta acción no se puede deshacer.<br>
                    La recolección será eliminada permanentemente.
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminarRecoleccion">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
// Función para cargar datos en el modal de edición
function cargarDatosRecoleccion(recoleccion) {
    // Cargar datos en el formulario
    document.getElementById('edit_produccion_id').value = recoleccion.produccion_id;
    document.getElementById('edit_cantidad_recolectada').value = recoleccion.cantidad_recolectada;
    document.getElementById('edit_estado_fruto').value = recoleccion.estado_fruto;
    document.getElementById('edit_fecha_recoleccion').value = recoleccion.fecha_recoleccion;
    document.getElementById('edit_condiciones_climaticas').value = recoleccion.condiciones_climaticas;
    document.getElementById('edit_calidad_promedio').value = recoleccion.calidad_promedio;
    document.getElementById('edit_observaciones').value = recoleccion.observaciones || '';

    // Cargar trabajadores participantes
    const trabajadoresSelect = document.getElementById('edit_trabajadores_participantes');
    if (recoleccion.trabajadores_participantes && Array.isArray(recoleccion.trabajadores_participantes)) {
        Array.from(trabajadoresSelect.options).forEach(option => {
            option.selected = recoleccion.trabajadores_participantes.includes(parseInt(option.value));
        });
    }

    // Configurar la URL del formulario
    document.getElementById('editarRecoleccionForm').action = `/recolecciones/${recoleccion.id}`;
}

// Manejar envío del formulario de edición
document.getElementById('editarRecoleccionForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const actionUrl = this.action;

    fetch(actionUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar modal de edición
            bootstrap.Modal.getInstance(document.getElementById('editarRecoleccionModal')).hide();

            // Mostrar modal de éxito
            const modalExito = new bootstrap.Modal(document.getElementById('modalExitoEditarRecoleccion'));
            modalExito.show();

            // Countdown y redirección
            let countdown = 3;
            const countdownElement = document.getElementById('countdownEditRecoleccion');
            const interval = setInterval(() => {
                countdown--;
                countdownElement.textContent = countdown;
                if (countdown <= 0) {
                    clearInterval(interval);
                    modalExito.hide();
                    window.location.reload();
                }
            }, 1000);
        } else {
            alert('Error al actualizar la recolección: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar la recolección');
    });
});

// Función para confirmar eliminación
function confirmarEliminarRecoleccion(deleteUrl) {
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminarRecoleccion'));
    modal.show();

    document.getElementById('btnConfirmarEliminarRecoleccion').onclick = function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    };
}

// Función de búsqueda en tiempo real
document.getElementById('buscarRecoleccion').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.getElementById('tablaRecolecciones');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const text = row.textContent.toLowerCase();

        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});
</script>
@endsection
