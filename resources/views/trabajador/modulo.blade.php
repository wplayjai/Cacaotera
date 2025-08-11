@extends('layouts.worker')

@section('title', 'Módulo Trabajador - Cacaotera')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);
        color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 24px rgba(78,84,200,0.15);
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
    }
    .dashboard-header h2 {
        font-weight: 700;
        letter-spacing: 1px;
    }
    .dashboard-header .badge {
        font-size: 1.1rem;
        background: rgba(255,255,255,0.2);
        color: #fff;
        border-radius: 1rem;
        padding: 0.7rem 1.5rem;
    }
    .summary-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 2px 16px rgba(78,84,200,0.08);
        transition: transform 0.2s;
        background: #fff;
    }
    .summary-card:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 8px 32px rgba(78,84,200,0.18);
    }
    .summary-icon {
        font-size: 2.5rem;
        border-radius: 50%;
        padding: 1rem;
        margin-right: 1rem;
        background: linear-gradient(135deg, #8f94fb 0%, #4e54c8 100%);
        color: #fff;
        box-shadow: 0 2px 8px rgba(78,84,200,0.12);
    }
    .table-card {
        border-radius: 1rem;
        box-shadow: 0 2px 16px rgba(78,84,200,0.08);
        border: none;
        background: #fff;
    }
    .table thead {
        background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);
        color: #fff;
    }
    .btn-outline-primary.active, .btn-outline-primary:active {
        background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%) !important;
        color: #fff !important;
        border: none;
    }
    .badge.bg-success, .badge.bg-warning {
        font-size: 1rem;
        padding: 0.5em 1em;
        border-radius: 1rem;
    }
</style>

<div class="container-fluid">

    <!-- Tarjetas de resumen -->
    <div class="row mb-4 g-4 justify-content-center">
        <div class="col-xl-6 col-md-6">
            <div class="card summary-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="summary-icon bg-primary">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-primary fw-bold small mb-1">
                            Lotes Activos
                        </div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ $lotes->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card summary-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="summary-icon bg-info">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-info fw-bold small mb-1">
                            Insumos Disponibles
                        </div>
                        <div class="h4 mb-0 fw-bold text-dark">{{ $inventario->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lotes activos (primero) -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card table-card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient-primary text-white rounded-top" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%) !important;">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-seedling me-2"></i>Lotes Activos
                    </h6>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <!-- Filtros de búsqueda -->
                    <form class="row g-3 mb-3" id="filtroLotesForm">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="filtroNombreLote" placeholder="Filtrar por nombre de lote">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="filtroTipoCacao" placeholder="Filtrar por tipo de cacao">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="filtroAreaLote" placeholder="Filtrar por área">
                        </div>
                    </form>
                    @if($lotes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="tablaLotes">
                                <thead class="table-light">
                                    <tr>
                                        <th>Lote</th>
                                        <th>Tipo de Cacao</th>
                                        <th>Área</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lotes->take(5) as $lote)
                                    <tr data-lote='@json($lote)'>
                                        <td class="fw-semibold">{{ $lote->nombre }}</td>
                                        <td>{{ $lote->tipo_cacao ?? 'N/A' }}</td>
                                        <td>
                                            {{ $lote->area_formateada ?? $lote->area ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $lote->estado == 'activo' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($lote->estado ?? 'Activo') }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary btn-trabajar-lote" data-bs-toggle="modal" data-bs-target="#modalTrabajoLote">
                                                <i class="fas fa-briefcase"></i> Trabajar
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No hay lotes activos disponibles</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Insumos disponibles (debajo de lotes) -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card table-card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient-primary text-white rounded-top d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%) !important;">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-boxes me-2"></i>Insumos Disponibles
                    </h6>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-light active" id="btnFertilizantes" onclick="cargarInventarioPorTipo('Fertilizantes')">
                            <i class="fas fa-seedling me-1"></i>Fertilizantes
                        </button>
                        <button type="button" class="btn btn-outline-light" id="btnPesticidas" onclick="cargarInventarioPorTipo('Pesticidas')">
                            <i class="fas fa-bug me-1"></i>Pesticidas
                        </button>
                    </div>
                </div>
                <div class="card-body bg-white rounded-bottom">
                    <div class="table-responsive">
                        <div class="mb-3">
                            <span class="badge bg-primary fs-6" id="indicadorTipo">
                                <i class="fas fa-seedling me-1"></i>Fertilizantes
                            </span>
                        </div>
                        <table class="table table-bordered align-middle" id="tablaInventario" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyInventario">
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Trabajo en Lote -->
    <div class="modal fade" id="modalTrabajoLote" tabindex="-1" aria-labelledby="modalTrabajoLoteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formTrabajoLote">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTrabajoLoteLabel">
                            <i class="fas fa-briefcase me-2"></i>Trabajo en Lote
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Info del lote -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nombre del Lote</label>
                                <input type="text" class="form-control" id="modalLoteNombre" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tipo de Cacao</label>
                                <input type="text" class="form-control" id="modalLoteTipoCacao" readonly>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">Área</label>
                                <input type="text" class="form-control" id="modalLoteArea" readonly>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">Estado</label>
                                <input type="text" class="form-control" id="modalLoteEstado" readonly>
                            </div>
                        </div>
                        <hr>
                        <!-- Inventario para trabajar -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tipo</label>
                                <select class="form-select" id="tipoInsumoTrabajo">
                                    <option value="Fertilizantes">Fertilizantes</option>
                                    <option value="Pesticidas">Pesticidas</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Insumo</label>
                                <select class="form-select" id="insumoTrabajo" required>
                                    <option value="">Seleccione un insumo</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">Cantidad disponible</label>
                                <input type="number" min="0" class="form-control" id="cantidadTrabajo" readonly>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">Unidad</label>
                                <input type="text" class="form-control" id="unidadTrabajo" readonly>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">Cantidad a usar</label>
                                <input type="number" min="1" class="form-control" id="cantidadAUsar" name="cantidad_a_usar" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">Fecha de uso</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="fechaUso"
                                    name="fecha_uso"
                                    value="{{ date('Y-m-d') }}"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Observaciones</label>
                                <textarea class="form-control" id="observacionesTrabajo" name="observaciones" rows="2" placeholder="Ingrese observaciones..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Registrar Trabajo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Listado de trabajos por lote -->
    <div class="modal fade" id="modalListadoTrabajos" tabindex="-1" aria-labelledby="modalListadoTrabajosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalListadoTrabajosLabel">
                        <i class="fas fa-list me-2"></i>Listado de Trabajos del Lote
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div id="tablaTrabajosLoteContainer">
                        <!-- Aquí se carga el listado de trabajos por JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
let tipoInventarioActual = 'Fertilizantes';
let inventario = @json($inventario);

// Filtro de lotes por nombre, tipo de cacao y área
document.addEventListener('DOMContentLoaded', function() {
    cargarInventario();

    // Filtro en tabla de lotes
    const filtroNombre = document.getElementById('filtroNombreLote');
    const filtroTipo = document.getElementById('filtroTipoCacao');
    const filtroArea = document.getElementById('filtroAreaLote');
    const tablaLotes = document.getElementById('tablaLotes');
    if (tablaLotes) {
        [filtroNombre, filtroTipo, filtroArea].forEach(input => {
            input.addEventListener('input', function() {
                const nombre = filtroNombre.value.toLowerCase();
                const tipo = filtroTipo.value.toLowerCase();
                const area = filtroArea.value.toLowerCase();
                Array.from(tablaLotes.tBodies[0].rows).forEach(row => {
                    const celdaNombre = row.cells[0].textContent.toLowerCase();
                    const celdaTipo = row.cells[1].textContent.toLowerCase();
                    const celdaArea = row.cells[2].textContent.toLowerCase();
                    if (
                        celdaNombre.includes(nombre) &&
                        celdaTipo.includes(tipo) &&
                        celdaArea.includes(area)
                    ) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    }

    // Botón "Trabajar" en cada lote
    document.querySelectorAll('.btn-trabajar-lote').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = btn.closest('tr');
            const lote = JSON.parse(row.getAttribute('data-lote'));
            document.getElementById('modalLoteNombre').value = lote.nombre;
            document.getElementById('modalLoteTipoCacao').value = lote.tipo_cacao || 'N/A';
            document.getElementById('modalLoteArea').value = lote.area_formateada || lote.area || 'N/A';
            document.getElementById('modalLoteEstado').value = lote.estado;
            document.getElementById('tipoInsumoTrabajo').value = 'Fertilizantes';
            cargarInsumosTrabajoAjax('Fertilizantes');
            document.getElementById('cantidadTrabajo').value = '';
            document.getElementById('unidadTrabajo').value = '';
        });
    });

    // Cambiar tipo en el modal de trabajo y filtrar insumos por AJAX
    document.getElementById('tipoInsumoTrabajo').addEventListener('change', function() {
        cargarInsumosTrabajoAjax(this.value);
    });

    // Cambiar insumo seleccionado en el modal de trabajo
    document.getElementById('insumoTrabajo').addEventListener('change', function() {
        const insumoId = this.value;
        const insumo = this.options[this.selectedIndex].dataset;
        document.getElementById('unidadTrabajo').value = insumo.unidad || '';
        document.getElementById('cantidadTrabajo').value = insumo.cantidad || '';
    });

    // Filtrar insumos según tipo seleccionado usando AJAX
    function cargarInsumosTrabajoAjax(tipo) {
        const select = document.getElementById('insumoTrabajo');
        select.innerHTML = '<option value="">Cargando...</option>';
        document.getElementById('unidadTrabajo').value = '';
        document.getElementById('cantidadTrabajo').value = '';

        fetch(`/api/inventario?tipo=${encodeURIComponent(tipo)}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            select.innerHTML = '<option value="">Seleccione un insumo</option>';
            if (data.success && data.data && data.data.length > 0) {
                data.data.forEach(i => {
                    select.innerHTML += `<option value="${i.id}" data-unidad="${i.unidad_medida}" data-cantidad="${i.cantidad}">${i.nombre}</option>`;
                });
            } else {
                select.innerHTML = '<option value="">No hay insumos disponibles</option>';
            }
            document.getElementById('unidadTrabajo').value = '';
            document.getElementById('cantidadTrabajo').value = '';
        })
        .catch(() => {
            select.innerHTML = '<option value="">Error al cargar insumos</option>';
            document.getElementById('unidadTrabajo').value = '';
            document.getElementById('cantidadTrabajo').value = '';
        });
    }

    // Mostrar listado de trabajos (simulado)
    // Puedes reemplazar esto por una petición AJAX real si tienes los datos en BD
    window.mostrarListadoTrabajos = function() {
        // Simulación de trabajos
        const trabajos = [
            { fecha: '2025-08-10', insumo: 'Fertilizante A', cantidad: 10, unidad: 'kg', responsable: 'Trabajador 1' },
            { fecha: '2025-08-09', insumo: 'Pesticida X', cantidad: 2, unidad: 'L', responsable: 'Trabajador 2' }
        ];
        let html = `<table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Insumo</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                ${trabajos.map(t => `<tr>
                    <td>${t.fecha}</td>
                    <td>${t.insumo}</td>
                    <td>${t.cantidad}</td>
                    <td>${t.unit}</td>
                    <td>${t.responsable}</td>
                </tr>`).join('')}
            </tbody>
        </table>`;
        document.getElementById('tablaTrabajosLoteContainer').innerHTML = html;
        new bootstrap.Modal(document.getElementById('modalListadoTrabajos')).show();
    };

    // Mostrar modal de listado de trabajos (puedes poner un botón donde lo necesites)
    // Ejemplo: <button onclick="mostrarListadoTrabajos()" ...>Ver trabajos</button>
});

// Cargar insumos en el modal de trabajo según tipo
function cargarInsumosTrabajo(tipo) {
    const select = document.getElementById('insumoTrabajo');
    select.innerHTML = '<option value="">Seleccione un insumo</option>';
    inventario.filter(i => i.tipo === tipo).forEach(i => {
        select.innerHTML += `<option value="${i.id}">${i.nombre}</option>`;
    });
    document.getElementById('unidadTrabajo').value = '';
}

// Filtro de lotes por nombre y tipo de cacao
document.addEventListener('DOMContentLoaded', function() {
    cargarInventario();

    // Filtro en tabla de lotes
    const filtroNombre = document.getElementById('filtroNombreLote');
    const filtroTipo = document.getElementById('filtroTipoCacao');
    const tablaLotes = document.getElementById('tablaLotes');
    if (tablaLotes) {
        [filtroNombre, filtroTipo].forEach(input => {
            input.addEventListener('input', function() {
                const nombre = filtroNombre.value.toLowerCase();
                const tipo = filtroTipo.value.toLowerCase();
                Array.from(tablaLotes.tBodies[0].rows).forEach(row => {
                    const celdaNombre = row.cells[0].textContent.toLowerCase();
                    const celdaTipo = row.cells[1].textContent.toLowerCase();
                    if (
                        celdaNombre.includes(nombre) &&
                        celdaTipo.includes(tipo)
                    ) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    }

    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});

function cargarInventario() {
    cargarInventarioPorTipo('Fertilizantes');
}

function cargarInventarioPorTipo(tipo) {
    tipoInventarioActual = tipo;

    document.getElementById('btnFertilizantes').classList.remove('active');
    document.getElementById('btnPesticidas').classList.remove('active');

    if (tipo === 'Fertilizantes') {
        document.getElementById('btnFertilizantes').classList.add('active');
        document.getElementById('indicadorTipo').innerHTML = '<i class="fas fa-seedling me-1"></i>Fertilizantes';
        document.getElementById('indicadorTipo').className = 'badge bg-success fs-6';
    } else {
        document.getElementById('btnPesticidas').classList.add('active');
        document.getElementById('indicadorTipo').innerHTML = '<i class="fas fa-bug me-1"></i>Pesticidas';
        document.getElementById('indicadorTipo').className = 'badge bg-warning fs-6';
    }

    fetch(`/api/inventario?tipo=${tipo}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const tbody = document.getElementById('tbodyInventario');
        tbody.innerHTML = '';

        if (!data.success || !data.data || data.data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        <i class="fas fa-boxes fa-3x mb-3"></i>
                        <p>No hay insumos disponibles</p>
                    </td>
                </tr>
            `;
            return;
        }

        data.data.forEach(item => {
            const estadoClass = item.estado === 'Óptimo' ? 'success' :
                               item.estado === 'Por vencer' ? 'warning' : 'danger';

            const fechaActual = new Date().toLocaleDateString('es-ES');

            const row = `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nombre}</td>
                    <td>
                        <span class="badge bg-${item.tipo === 'Fertilizantes' ? 'success' : 'warning'}">
                            ${item.tipo}
                        </span>
                    </td>
                    <td>${item.cantidad}</td>
                    <td>${item.unidad_medida}</td>
                    <td>$${parseFloat(item.precio_unitario).toFixed(2)}</td>
                    <td>
                        <span class="badge bg-${estadoClass}">
                            ${item.estado}
                        </span>
                    </td>
                    <td>${fechaActual}</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    })
    .catch(error => {
        document.getElementById('tbodyInventario').innerHTML = `
            <tr>
                <td colspan="8" class="text-center text-danger">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <p>Error al cargar los datos del inventario</p>
                    <small class="text-muted">${error.message}</small>
                </td>
            </tr>
        `;
    });
}

// Elimina mensaje anterior
let msg = document.getElementById('msgCantidadInsuficiente');
if (msg) msg.remove();

document.getElementById('formTrabajoLote').addEventListener('submit', function(e) {
    e.preventDefault();

    const cantidadDisponible = parseFloat(document.getElementById('cantidadTrabajo').value) || 0;
    const cantidadAUsar = parseFloat(document.getElementById('cantidadAUsar').value) || 0;
    const insumoId = document.getElementById('insumoTrabajo').value;


    if (cantidadAUsar > cantidadDisponible) {
        // Muestra mensaje de error
        const inputDiv = document.getElementById('cantidadAUsar').parentElement;
        const errorMsg = document.createElement('div');
        errorMsg.id = 'msgCantidadInsuficiente';
        errorMsg.className = 'text-danger mt-2';
        errorMsg.innerText = 'No hay suficiente insumo disponible.';
        inputDiv.appendChild(errorMsg);
        return;
    }

    // AJAX para descontar en BD
    fetch('/inventario/descontar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            insumo_id: insumoId,
            cantidad_usar: cantidadAUsar
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cantidadTrabajo').value = data.nueva_cantidad;
            actualizarTablaInventario(insumoId, data.nueva_cantidad);
            document.getElementById('cantidadAUsar').value = '';
            bootstrap.Modal.getInstance(document.getElementById('modalTrabajoLote')).hide();

            // ALERTA BONITA
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Se ha guardado el trabajo correctamente',
                confirmButtonColor: '#4e54c8'
            });
        } else {
            // Muestra mensaje de error
            const inputDiv = document.getElementById('cantidadAUsar').parentElement;
            const errorMsg = document.createElement('div');
            errorMsg.id = 'msgCantidadInsuficiente';
            errorMsg.className = 'text-danger mt-2';
            errorMsg.innerText = data.message || 'Error al descontar insumo.';
            inputDiv.appendChild(errorMsg);
        }
    })
    .catch(() => {
        alert('Error al registrar el trabajo.');
    });
});

// Actualiza la tabla de inventario visualmente
function actualizarTablaInventario(insumoId, nuevaCantidad) {
    const tabla = document.getElementById('tablaInventario');
    if (!tabla) return;
    Array.from(tabla.tBodies[0].rows).forEach(row => {
        if (row.cells[0] && row.cells[0].textContent == insumoId) {
            row.cells[3].textContent = nuevaCantidad;
        }
    });
}
</script>
@endsection
