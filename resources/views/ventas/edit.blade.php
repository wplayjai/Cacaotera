@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- Encabezado --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4><i class="fas fa-edit me-2"></i>Editar Venta #{{ $venta->id }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('recolecciones.index') }}" class="text-decoration-none">
                                        <i class="fas fa-clipboard-list me-1"></i>Recolecciones
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('ventas.index') }}" class="text-decoration-none">
                                        <i class="fas fa-shopping-cart me-1"></i>Ventas
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('ventas.show', $venta->id) }}" class="text-decoration-none">
                                        <i class="fas fa-eye me-1"></i>Venta #{{ $venta->id }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info">
                            <i class="fas fa-eye me-2"></i>Ver Detalles
                        </a>
                        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                {{-- Formulario de Edición --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Formulario de Edición</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Errores de Validación:</h6>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form id="editVentaForm" method="POST" action="{{ route('ventas.update', $venta->id) }}">
                                @csrf
                                @method('PUT')
                                
                                {{-- Información Básica --}}
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="border-bottom pb-2 mb-3">
                                            <i class="fas fa-info-circle me-2"></i>Información Básica
                                        </h6>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_venta" class="form-label">
                                                Fecha de Venta <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control @error('fecha_venta') is-invalid @enderror" 
                                                   id="fecha_venta" name="fecha_venta" 
                                                   value="{{ old('fecha_venta', $venta->fecha_venta->format('Y-m-d')) }}" required>
                                            @error('fecha_venta')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="recoleccion_id" class="form-label">
                                                Lote/Recolección <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('recoleccion_id') is-invalid @enderror" 
                                                    id="recoleccion_id" name="recoleccion_id" required onchange="actualizarStock()">
                                                {{-- Opción actual --}}
                                                <option value="{{ $venta->recoleccion->id }}" selected>
                                                    {{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }} - 
                                                    {{ $venta->recoleccion->produccion->tipo_cacao }} 
                                                    ({{ number_format($venta->recoleccion->cantidad_disponible + $venta->cantidad_vendida, 2) }} kg disponibles)
                                                </option>
                                                {{-- Otras opciones disponibles --}}
                                                @foreach($recoleccionesDisponibles ?? [] as $recoleccion)
                                                    @if($recoleccion->id != $venta->recoleccion_id)
                                                        <option value="{{ $recoleccion->id }}" 
                                                                data-stock="{{ $recoleccion->cantidad_disponible }}"
                                                                data-tipo="{{ $recoleccion->produccion->tipo_cacao }}">
                                                            {{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }} - 
                                                            {{ $recoleccion->produccion->tipo_cacao }} 
                                                            ({{ number_format($recoleccion->cantidad_disponible, 2) }} kg disponibles)
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <small id="stockInfo" class="form-text text-success">
                                                <i class="fas fa-info-circle"></i> 
                                                Stock disponible: <strong>{{ number_format($venta->recoleccion->cantidad_disponible + $venta->cantidad_vendida, 2) }} kg</strong> 
                                                de {{ $venta->recoleccion->produccion->tipo_cacao }}
                                            </small>
                                            @error('recoleccion_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Información del Cliente --}}
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="border-bottom pb-2 mb-3">
                                            <i class="fas fa-user me-2"></i>Información del Cliente
                                        </h6>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cliente" class="form-label">
                                                Cliente <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('cliente') is-invalid @enderror" 
                                                   id="cliente" name="cliente" 
                                                   value="{{ old('cliente', $venta->cliente) }}" 
                                                   placeholder="Nombre del cliente" required>
                                            @error('cliente')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telefono_cliente" class="form-label">Teléfono Cliente</label>
                                            <input type="text" class="form-control @error('telefono_cliente') is-invalid @enderror" 
                                                   id="telefono_cliente" name="telefono_cliente" 
                                                   value="{{ old('telefono_cliente', $venta->telefono_cliente) }}" 
                                                   placeholder="Teléfono del cliente">
                                            @error('telefono_cliente')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Detalles de la Venta --}}
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="border-bottom pb-2 mb-3">
                                            <i class="fas fa-calculator me-2"></i>Detalles de la Venta
                                        </h6>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="cantidad_vendida" class="form-label">
                                                Cantidad (kg) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control @error('cantidad_vendida') is-invalid @enderror" 
                                                   id="cantidad_vendida" name="cantidad_vendida" 
                                                   value="{{ old('cantidad_vendida', $venta->cantidad_vendida) }}"
                                                   step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                                            <small class="form-text text-muted">
                                                Cantidad original: {{ number_format($venta->cantidad_vendida, 2) }} kg
                                            </small>
                                            @error('cantidad_vendida')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="precio_por_kg" class="form-label">
                                                Precio por kg ($) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control @error('precio_por_kg') is-invalid @enderror" 
                                                   id="precio_por_kg" name="precio_por_kg" 
                                                   value="{{ old('precio_por_kg', $venta->precio_por_kg) }}"
                                                   step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                                            @error('precio_por_kg')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="total_venta" class="form-label">Total ($)</label>
                                            <input type="number" class="form-control" id="total_venta" name="total_venta" 
                                                   value="{{ old('total_venta', $venta->total_venta) }}"
                                                   readonly style="background-color: #f8f9fa; font-weight: bold;">
                                        </div>
                                    </div>
                                </div>

                                {{-- Información de Pago --}}
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="border-bottom pb-2 mb-3">
                                            <i class="fas fa-credit-card me-2"></i>Información de Pago
                                        </h6>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estado_pago" class="form-label">
                                                Estado de Pago <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('estado_pago') is-invalid @enderror" 
                                                    id="estado_pago" name="estado_pago" required>
                                                <option value="pagado" {{ old('estado_pago', $venta->estado_pago) == 'pagado' ? 'selected' : '' }}>
                                                    Pagado
                                                </option>
                                                <option value="pendiente" {{ old('estado_pago', $venta->estado_pago) == 'pendiente' ? 'selected' : '' }}>
                                                    Pendiente
                                                </option>
                                            </select>
                                            @error('estado_pago')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="metodo_pago" class="form-label">
                                                Método de Pago <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('metodo_pago') is-invalid @enderror" 
                                                    id="metodo_pago" name="metodo_pago" required>
                                                <option value="efectivo" {{ old('metodo_pago', $venta->metodo_pago) == 'efectivo' ? 'selected' : '' }}>
                                                    <i class="fas fa-money-bill"></i> Efectivo
                                                </option>
                                                <option value="transferencia" {{ old('metodo_pago', $venta->metodo_pago) == 'transferencia' ? 'selected' : '' }}>
                                                    <i class="fas fa-university"></i> Transferencia
                                                </option>
                                                <option value="cheque" {{ old('metodo_pago', $venta->metodo_pago) == 'cheque' ? 'selected' : '' }}>
                                                    <i class="fas fa-money-check"></i> Cheque
                                                </option>
                                            </select>
                                            @error('metodo_pago')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Observaciones --}}
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="observaciones" class="form-label">
                                                <i class="fas fa-comment me-2"></i>Observaciones
                                            </label>
                                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                                      id="observaciones" name="observaciones" rows="3" 
                                                      placeholder="Observaciones adicionales...">{{ old('observaciones', $venta->observaciones) }}</textarea>
                                            @error('observaciones')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Botones --}}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <div class="btn-group">
                                                <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-secondary">
                                                    <i class="fas fa-times me-2"></i>Cancelar
                                                </a>
                                                <button type="button" class="btn btn-info" onclick="resetearFormulario()">
                                                    <i class="fas fa-undo me-2"></i>Resetear
                                                </button>
                                            </div>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-save me-2"></i>Actualizar Venta
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Panel de Información --}}
                <div class="col-md-4">
                    {{-- Información Actual --}}
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información Actual</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><strong>ID Venta:</strong></td>
                                    <td><span class="badge bg-primary">#{{ $venta->id }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha Original:</strong></td>
                                    <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cliente Original:</strong></td>
                                    <td>{{ $venta->cliente }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cantidad Original:</strong></td>
                                    <td>{{ number_format($venta->cantidad_vendida, 2) }} kg</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Original:</strong></td>
                                    <td><strong>${{ number_format($venta->total_venta, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }}">
                                            {{ ucfirst($venta->estado_pago) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Advertencias --}}
                    <div class="card mt-3">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Advertencias</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning mb-2">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Al cambiar la cantidad, el stock se ajustará automáticamente.
                                </small>
                            </div>
                            <div class="alert alert-info mb-2">
                                <small>
                                    <i class="fas fa-clock me-1"></i>
                                    Los cambios se registrarán con fecha y hora de modificación.
                                </small>
                            </div>
                            @if($venta->estado_pago == 'pagado')
                                <div class="alert alert-success mb-0">
                                    <small>
                                        <i class="fas fa-check-circle me-1"></i>
                                        Esta venta ya está marcada como pagada.
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Historial (si existe) --}}
                    @if($venta->updated_at != $venta->created_at)
                        <div class="card mt-3">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historial</h5>
                            </div>
                            <div class="card-body">
                                <small>
                                    <strong>Creado:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última modificación:</strong> {{ $venta->updated_at->format('d/m/Y H:i') }}<br>
                                    <em class="text-muted">{{ $venta->updated_at->diffForHumans() }}</em>
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Variables originales para comparación
const ventaOriginal = {
    cantidad: {{ $venta->cantidad_vendida }},
    precio: {{ $venta->precio_por_kg }},
    total: {{ $venta->total_venta }},
    recoleccion: {{ $venta->recoleccion_id }},
    stockDisponible: {{ $venta->recoleccion->cantidad_disponible + $venta->cantidad_vendida }}
};

// Actualizar información de stock disponible
function actualizarStock() {
    const select = document.getElementById('recoleccion_id');
    const stockInfo = document.getElementById('stockInfo');
    const cantidadInput = document.getElementById('cantidad_vendida');
    
    if (select.value) {
        const option = select.options[select.selectedIndex];
        let stock;
        let tipo;
        
        // Si es la recolección original, incluir la cantidad vendida
        if (select.value == {{ $venta->recoleccion_id }}) {
            stock = ventaOriginal.stockDisponible;
            tipo = '{{ $venta->recoleccion->produccion->tipo_cacao }}';
        } else {
            stock = parseFloat(option.dataset.stock);
            tipo = option.dataset.tipo;
        }
        
        stockInfo.innerHTML = `<i class="fas fa-info-circle"></i> Stock disponible: <strong>${stock} kg</strong> de ${tipo}`;
        stockInfo.className = stock < 10 ? 'form-text text-danger' : 'form-text text-success';
        
        cantidadInput.max = stock;
        cantidadInput.placeholder = `Máximo ${stock} kg`;
        
        // Validar cantidad actual
        const cantidadActual = parseFloat(cantidadInput.value) || 0;
        if (cantidadActual > stock) {
            cantidadInput.classList.add('is-invalid');
            cantidadInput.setCustomValidity('La cantidad excede el stock disponible');
        } else {
            cantidadInput.classList.remove('is-invalid');
            cantidadInput.setCustomValidity('');
        }
    }
}

// Calcular total de la venta
function calcularTotal() {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
    const precio = parseFloat(document.getElementById('precio_por_kg').value) || 0;
    const total = cantidad * precio;
    
    document.getElementById('total_venta').value = total.toFixed(2);
    
    // Validar stock
    const select = document.getElementById('recoleccion_id');
    if (select.value) {
        const option = select.options[select.selectedIndex];
        let stock;
        
        if (select.value == {{ $venta->recoleccion_id }}) {
            stock = ventaOriginal.stockDisponible;
        } else {
            stock = parseFloat(option.dataset.stock);
        }
        
        const cantidadInput = document.getElementById('cantidad_vendida');
        if (cantidad > stock) {
            cantidadInput.classList.add('is-invalid');
            cantidadInput.setCustomValidity('La cantidad no puede exceder el stock disponible');
        } else {
            cantidadInput.classList.remove('is-invalid');
            cantidadInput.setCustomValidity('');
        }
    }
    
    // Resaltar si hay cambios
    resaltarCambios();
}

// Resetear formulario a valores originales
function resetearFormulario() {
    Swal.fire({
        title: '¿Resetear Formulario?',
        text: "Se restaurarán todos los valores originales",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6c757d',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Sí, resetear',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Resetear valores
            document.getElementById('fecha_venta').value = '{{ $venta->fecha_venta->format('Y-m-d') }}';
            document.getElementById('cliente').value = '{{ $venta->cliente }}';
            document.getElementById('telefono_cliente').value = '{{ $venta->telefono_cliente }}';
            document.getElementById('cantidad_vendida').value = '{{ $venta->cantidad_vendida }}';
            document.getElementById('precio_por_kg').value = '{{ $venta->precio_por_kg }}';
            document.getElementById('total_venta').value = '{{ $venta->total_venta }}';
            document.getElementById('estado_pago').value = '{{ $venta->estado_pago }}';
            document.getElementById('metodo_pago').value = '{{ $venta->metodo_pago }}';
            document.getElementById('observaciones').value = '{{ $venta->observaciones }}';
            
            // Limpiar clases de validación
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.is-valid').forEach(el => el.classList.remove('is-valid'));
            
            // Actualizar stock
            actualizarStock();
            
            Swal.fire('¡Reseteado!', 'El formulario ha sido restaurado', 'success');
        }
    });
}

// Resaltar cambios en el formulario
function resaltarCambios() {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
    const precio = parseFloat(document.getElementById('precio_por_kg').value) || 0;
    const total = parseFloat(document.getElementById('total_venta').value) || 0;
    
    // Resaltar campos modificados
    if (cantidad !== ventaOriginal.cantidad) {
        document.getElementById('cantidad_vendida').classList.add('border-warning');
    } else {
        document.getElementById('cantidad_vendida').classList.remove('border-warning');
    }
    
    if (precio !== ventaOriginal.precio) {
        document.getElementById('precio_por_kg').classList.add('border-warning');
    } else {
        document.getElementById('precio_por_kg').classList.remove('border-warning');
    }
    
    if (total !== ventaOriginal.total) {
        document.getElementById('total_venta').classList.add('border-warning', 'text-warning');
    } else {
        document.getElementById('total_venta').classList.remove('border-warning', 'text-warning');
    }
}

// Validación antes del envío
document.getElementById('editVentaForm').addEventListener('submit', function(e) {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value);
    const select = document.getElementById('recoleccion_id');
    
    if (select.value) {
        let stock;
        if (select.value == {{ $venta->recoleccion_id }}) {
            stock = ventaOriginal.stockDisponible;
        } else {
            const option = select.options[select.selectedIndex];
            stock = parseFloat(option.dataset.stock);
        }
        
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
    
    // Confirmar cambios importantes
    const cantidadCambiada = cantidad !== ventaOriginal.cantidad;
    const recoleccionCambiada = select.value != ventaOriginal.recoleccion;
    
    if (cantidadCambiada || recoleccionCambiada) {
        e.preventDefault();
        Swal.fire({
            title: 'Confirmar Cambios',
            text: "Los cambios en cantidad o lote afectarán el stock. ¿Continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    }
});

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    actualizarStock();
    calcularTotal();
});
</script>
@endpush