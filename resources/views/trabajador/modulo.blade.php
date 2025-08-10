@extends('layouts.worker')

@section('title', 'Módulo Trabajador - Cacaotera')

@section('content')
<div class="container-fluid">
    <!-- Header del módulo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-0">
                                <i class="fas fa-user-tie me-2"></i>
                                Módulo de Trabajador
                            </h2>
                            <p class="mb-0 mt-2">Bienvenido, {{ Auth::user()->name }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex justify-content-end">
                                <span class="badge bg-light text-dark fs-6">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ now()->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de resumen -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Lotes Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lotes->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-seedling fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Producciones en Curso
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $producciones->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-leaf fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Insumos Disponibles
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inventario->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Próximas Cosechas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $producciones->where('estado', 'maduracion')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-harvest fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Contenido principal -->
    <div class="row">
        <!-- Lotes activos -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-seedling me-2"></i>Lotes Activos
                    </h6>
                </div>
                <div class="card-body">
                    @if($lotes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Lote</th>
                                        <th>Área</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lotes->take(5) as $lote)
                                    <tr>
                                        <td>{{ $lote->nombre }}</td>
                                        <td>{{ $lote->area_formateada }}</td>
                                        <td>
                                            <span class="badge bg-{{ $lote->estado == 'activo' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($lote->estado ?? 'Activo') }}
                                            </span>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay lotes activos disponibles</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Producciones en curso -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-leaf me-2"></i>Producciones en Curso
                    </h6>
                </div>
                <div class="card-body">
                    @if($producciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Lote</th>
                                        <th>Estado</th>
                                        <th>Progreso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($producciones->take(5) as $produccion)
                                    <tr>
                                        <td>{{ $produccion->lote->nombre }}</td>
                                        <td>
                                            <span class="badge bg-{{ $produccion->estado == 'cosecha' ? 'warning' : 'info' }}">
                                                {{ ucfirst($produccion->estado) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $produccion->calcularProgreso() }}%">
                                                    {{ number_format($produccion->calcularProgreso(), 1) }}%
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-leaf fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay producciones en curso</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Insumos disponibles -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-boxes me-2"></i>Insumos Disponibles
                    </h6>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" id="btnFertilizantes" onclick="cargarInventarioPorTipo('Fertilizantes')">
                            <i class="fas fa-seedling me-1"></i>Fertilizantes
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="btnPesticidas" onclick="cargarInventarioPorTipo('Pesticidas')">
                            <i class="fas fa-bug me-1"></i>Pesticidas
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="mb-3">
                            <span class="badge bg-primary fs-6" id="indicadorTipo">
                                <i class="fas fa-seedling me-1"></i>Fertilizantes
                            </span>
                        </div>
                        <table class="table table-bordered" id="tablaInventario" width="100%" cellspacing="0">
                            <thead>
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
</div>

<!-- Modal para registrar cosecha -->
<div class="modal fade" id="modalCosecha" tabindex="-1" aria-labelledby="modalCosechaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCosechaLabel">
                    <i class="fas fa-harvest me-2"></i>Registrar Cosecha
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCosecha" method="POST" action="{{ route('trabajador.registrar.cosecha') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="produccion_id" id="produccion_id">
                    
                    <div class="mb-3">
                        <label for="cantidad_cosechada" class="form-label">Cantidad Cosechada (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="cantidad_cosechada" 
                               name="cantidad_cosechada" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_cosecha" class="form-label">Fecha de Cosecha</label>
                        <input type="date" class="form-control" id="fecha_cosecha" 
                               name="fecha_cosecha" value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Registrar Cosecha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function abrirModalCosecha(produccionId) {
    document.getElementById('produccion_id').value = produccionId;
    new bootstrap.Modal(document.getElementById('modalCosecha')).show();
}

// Variable global para el tipo actual
let tipoInventarioActual = 'Fertilizantes';

// Cargar datos del inventario con AJAX
function cargarInventario() {
    cargarInventarioPorTipo('Fertilizantes');
}

// Cargar inventario por tipo específico
function cargarInventarioPorTipo(tipo) {
    tipoInventarioActual = tipo;
    
    // Actualizar estado de botones
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
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Data received:', data);
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
        console.error('Error al cargar inventario:', error);
        console.error('Error details:', error.message);
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

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    // Cargar inventario al cargar la página
    cargarInventario();
    
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endsection
