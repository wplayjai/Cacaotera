@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4><i class="fas fa-shopping-cart me-2"></i>Gestión de Ventas</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('recolecciones.index') }}" class="text-decoration-none">
                                        <i class="fas fa-clipboard-list me-1"></i>Recolecciones
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-shopping-cart me-1"></i>Ventas
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ventaModal">
                        <i class="fas fa-plus me-2"></i>Nueva Venta
                    </button>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Estadísticas de ventas --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 id="totalVentas">{{ $ventasHoy ?? 0 }}</h4>
                                            <p>Ventas Hoy</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-shopping-cart fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 id="ingresosTotales">${{ number_format($ingresosTotales ?? 0, 2) }}</h4>
                                            <p>Ingresos Totales</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-dollar-sign fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 id="stockDisponible">{{ number_format($stockTotal ?? 0, 1) }} kg</h4>
                                            <p>Stock Disponible</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-warehouse fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 id="pagosPendientes">{{ $pagosPendientes ?? 0 }}</h4>
                                            <p>Pagos Pendientes</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Filtros --}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('ventas.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Buscar por cliente o lote..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="fecha_desde" class="form-control" 
                                               placeholder="Desde" value="{{ request('fecha_desde') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="fecha_hasta" class="form-control" 
                                               placeholder="Hasta" value="{{ request('fecha_hasta') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="estado_pago" class="form-select">
                                            <option value="">Todos los estados</option>
                                            <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                            <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-secondary me-1">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                        <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary me-1">
                                            <i class="fas fa-times"></i>
                                        </a>
                                       <a href="{{ route('ventas.descargarPDF', ['ventas' => $ventas->id]) }}" class="btn btn-success">
    Descargar PDF
</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tabla de ventas --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Lote/Producción</th>
                                    <th>Cantidad (kg)</th>
                                    <th>Precio/kg</th>
                                    <th>Total</th>
                                    <th>Estado Pago</th>
                                    <th>Método Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ventas ?? [] as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                                        <td>
                                            <strong>{{ $venta->cliente }}</strong>
                                            @if($venta->telefono_cliente)
                                                <br><small class="text-muted">{{ $venta->telefono_cliente }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</strong><br>
                                            <small class="text-muted">{{ $venta->recoleccion->produccion->tipo_cacao }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ number_format($venta->cantidad_vendida, 2) }} kg
                                            </span>
                                        </td>
                                        <td>${{ number_format($venta->precio_por_kg, 2) }}</td>
                                        <td>
                                            <strong class="text-success">
                                                ${{ number_format($venta->total_venta, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }}">
                                                {{ ucfirst($venta->estado_pago) }}
                                            </span>
                                        </td>
                                        <td>
                                            @switch($venta->metodo_pago)
                                                @case('efectivo')
                                                    <i class="fas fa-money-bill text-success"></i> Efectivo
                                                    @break
                                                @case('transferencia')
                                                    <i class="fas fa-university text-primary"></i> Transferencia
                                                    @break
                                                @case('cheque')
                                                    <i class="fas fa-money-check text-info"></i> Cheque
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-info" 
                                                        onclick="verDetalle({{ $venta->id }})" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning" 
                                                        onclick="editarVenta({{ $venta->id }})" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if($venta->estado_pago == 'pendiente')
                                                    <button type="button" class="btn btn-sm btn-success" 
                                                            onclick="marcarPagado({{ $venta->id }})" title="Marcar como pagado">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="eliminarVenta({{ $venta->id }})" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-shopping-cart fa-3x text-muted"></i>
                                                <h5 class="mt-2 text-muted">No hay ventas registradas</h5>
                                                <p class="text-muted">Comienza registrando una nueva venta</p>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ventaModal">
                                                    <i class="fas fa-plus"></i> Nueva Venta
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    @if(isset($ventas) && $ventas->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $ventas->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Botón para volver a recolecciones -->
            <div class="mt-3">
                <a href="{{ route('recolecciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver a Recolecciones
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal para nueva venta --}}
<div class="modal fade" id="ventaModal" tabindex="-1" aria-labelledby="ventaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="ventaForm" method="POST" action="{{ route('ventas.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="ventaModalLabel">
                        <i class="fas fa-plus me-2"></i>Registrar Nueva Venta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha_venta" class="form-label">Fecha de Venta <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="fecha_venta" name="fecha_venta" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="recoleccion_id" class="form-label">Lote Disponible <span class="text-danger">*</span></label>
                                <select class="form-select" id="recoleccion_id" name="recoleccion_id" required onchange="actualizarStock()">
                                    <option value="">-- Seleccionar Lote --</option>
                                    @foreach($recoleccionesDisponibles ?? [] as $recoleccion)
                                        <option value="{{ $recoleccion->id }}" 
                                                data-stock="{{ $recoleccion->cantidad_disponible }}"
                                                data-tipo="{{ $recoleccion->produccion->tipo_cacao }}">
                                            {{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }} - 
                                            {{ $recoleccion->produccion->tipo_cacao }} 
                                            ({{ number_format($recoleccion->cantidad_disponible, 2) }} kg disponibles)
                                        </option>
                                    @endforeach
                                </select>
                                <small id="stockInfo" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cliente" class="form-label">Cliente <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cliente" name="cliente" 
                                       placeholder="Nombre del cliente" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono_cliente" class="form-label">Teléfono Cliente</label>
                                <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente" 
                                       placeholder="Teléfono del cliente">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cantidad_vendida" class="form-label">Cantidad (kg) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="cantidad_vendida" name="cantidad_vendida" 
                                       step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="precio_por_kg" class="form-label">Precio por kg ($) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="precio_por_kg" name="precio_por_kg" 
                                       step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="total_venta" class="form-label">Total ($)</label>
                                <input type="number" class="form-control" id="total_venta" name="total_venta" 
                                       readonly style="background-color: #f8f9fa;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="estado_pago" class="form-label">Estado de Pago <span class="text-danger">*</span></label>
                                <select class="form-select" id="estado_pago" name="estado_pago" required>
                                    <option value="pagado">Pagado</option>
                                    <option value="pendiente">Pendiente</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="metodo_pago" class="form-label">Método de Pago <span class="text-danger">*</span></label>
                                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" 
                                  placeholder="Observaciones adicionales..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Actualizar información de stock disponible
function actualizarStock() {
    const select = document.getElementById('recoleccion_id');
    const stockInfo = document.getElementById('stockInfo');
    const cantidadInput = document.getElementById('cantidad_vendida');
    
    if (select.value) {
        const option = select.options[select.selectedIndex];
        const stock = parseFloat(option.dataset.stock);
        const tipo = option.dataset.tipo;
        
        stockInfo.innerHTML = `<i class="fas fa-info-circle"></i> Stock disponible: <strong>${stock} kg</strong> de ${tipo}`;
        stockInfo.className = stock < 10 ? 'form-text text-danger' : 'form-text text-success';
        
        cantidadInput.max = stock;
        cantidadInput.placeholder = `Máximo ${stock} kg`;
    } else {
        stockInfo.innerHTML = '';
        cantidadInput.max = '';
        cantidadInput.placeholder = '0.00';
    }
}

// Calcular total de la venta
function calcularTotal() {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
    const precio = parseFloat(document.getElementById('precio_por_kg').value) || 0;
    const total = cantidad * precio;
    
    document.getElementById('total_venta').value = total.toFixed(2);
    
    // Validar que no exceda el stock
    const select = document.getElementById('recoleccion_id');
    if (select.value) {
        const option = select.options[select.selectedIndex];
        const stock = parseFloat(option.dataset.stock);
        
        if (cantidad > stock) {
            document.getElementById('cantidad_vendida').classList.add('is-invalid');
            document.getElementById('cantidad_vendida').setCustomValidity('La cantidad no puede exceder el stock disponible');
        } else {
            document.getElementById('cantidad_vendida').classList.remove('is-invalid');
            document.getElementById('cantidad_vendida').setCustomValidity('');
        }
    }
}

// Ver detalles de venta
function verDetalle(id) {
    // Implementar modal de detalles o redireccionar
    window.location.href = `/ventas/${id}`;
}

// Editar venta
function editarVenta(id) {
    // Implementar modal de edición o redireccionar
    window.location.href = `/ventas/${id}/edit`;
}

// Marcar como pagado
function marcarPagado(id) {
    Swal.fire({
        title: '¿Marcar como Pagado?',
        text: "Se actualizará el estado de pago de la venta",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, marcar como pagado',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/ventas/${id}/pagar`;
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Eliminar venta
function eliminarVenta(id) {
    Swal.fire({
        title: '¿Eliminar Venta?',
        text: "Esta acción no se puede deshacer. El stock se restaurará automáticamente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/ventas/${id}`;
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(csrfToken);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Generar reporte
function generarReporte() {
    const fechaDesde = document.querySelector('input[name="fecha_desde"]').value;
    const fechaHasta = document.querySelector('input[name="fecha_hasta"]').value;
    const estadoPago = document.querySelector('select[name="estado_pago"]').value;
    
    let url = '/ventas/reporte?';
    const params = new URLSearchParams();
    
    if (fechaDesde) params.append('fecha_desde', fechaDesde);
    if (fechaHasta) params.append('fecha_hasta', fechaHasta);
    if (estadoPago) params.append('estado_pago', estadoPago);
    
    window.open(url + params.toString(), '_blank');
}

// Auto-ocultar alertas después de 5 segundos
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(function() {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 500);
    });
}, 5000);

// Validación del formulario antes del envío
document.getElementById('ventaForm').addEventListener('submit', function(e) {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value);
    const select = document.getElementById('recoleccion_id');
    
    if (select.value) {
        const option = select.options[select.selectedIndex];
        const stock = parseFloat(option.dataset.stock);
        
        if (cantidad > stock) {
            e.preventDefault();
            Swal.fire({
                title: 'Error de Validación',
                text: `La cantidad a vender (${cantidad} kg) excede el stock disponible (${stock} kg)`,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return false;
        }
    }
});
</script>
@endpush