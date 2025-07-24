@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{-- Encabezado --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4><i class="fas fa-eye me-2"></i>Detalle de Venta #{{ $venta->id }}</h4>
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
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-eye me-1"></i>Detalle #{{ $venta->id }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="btn-group">
                       
                        @if($venta->estado_pago == 'pendiente')
                            <button type="button" class="btn btn-success" onclick="marcarPagado({{ $venta->id }})">
                                <i class="fas fa-check me-2"></i>Marcar Pagado
                            </button>
                        @endif
                       
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                {{-- Información Principal de la Venta --}}
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información de la Venta</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>ID de Venta:</strong></td>
                                            <td>
                                                <span class="badge bg-primary fs-6">#{{ $venta->id }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fecha de Venta:</strong></td>
                                            <td>
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $venta->fecha_venta->format('d/m/Y') }}
                                                <small class="text-muted">({{ $venta->fecha_venta->diffForHumans() }})</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cliente:</strong></td>
                                            <td>
                                                <i class="fas fa-user me-1"></i>
                                                {{ $venta->cliente }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Teléfono:</strong></td>
                                            <td>
                                                @if($venta->telefono_cliente)
                                                    <i class="fas fa-phone me-1"></i>
                                                    <a href="tel:{{ $venta->telefono_cliente }}" class="text-decoration-none">
                                                        {{ $venta->telefono_cliente }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">No registrado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Estado de Pago:</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }} fs-6">
                                                    <i class="fas fa-{{ $venta->estado_pago == 'pagado' ? 'check-circle' : 'clock' }} me-1"></i>
                                                    {{ ucfirst($venta->estado_pago) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Método de Pago:</strong></td>
                                            <td>
                                                @switch($venta->metodo_pago)
                                                    @case('efectivo')
                                                        <i class="fas fa-money-bill text-success me-1"></i> Efectivo
                                                        @break
                                                    @case('transferencia')
                                                        <i class="fas fa-university text-primary me-1"></i> Transferencia
                                                        @break
                                                    @case('cheque')
                                                        <i class="fas fa-money-check text-info me-1"></i> Cheque
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Registrado:</strong></td>
                                            <td>
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $venta->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                        @if($venta->updated_at != $venta->created_at)
                                            <tr>
                                                <td><strong>Última Actualización:</strong></td>
                                                <td>
                                                    <i class="fas fa-edit me-1"></i>
                                                    {{ $venta->updated_at->format('d/m/Y H:i') }}
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            @if($venta->observaciones)
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <h6><i class="fas fa-comment me-2"></i>Observaciones:</h6>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            {{ $venta->observaciones }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Resumen Financiero --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Resumen Financiero</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <h6 class="text-muted">Cantidad Vendida</h6>
                                <h3 class="text-info">
                                    <i class="fas fa-weight me-1"></i>
                                    {{ number_format($venta->cantidad_vendida, 2) }} kg
                                </h3>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <h6 class="text-muted">Precio por Kilogramo</h6>
                                <h4 class="text-primary">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    {{ number_format($venta->precio_por_kg, 2) }}
                                </h4>
                            </div>
                            <hr>
                            <div class="mb-0">
                                <h6 class="text-muted">Total de la Venta</h6>
                                <h2 class="text-success">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    {{ number_format($venta->total_venta, 2) }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    {{-- Información del Lote --}}
                    <div class="card mt-3">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-seedling me-2"></i>Información del Lote</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><strong>Lote:</strong></td>
                                    <td>{{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tipo de Cacao:</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $venta->recoleccion->produccion->tipo_cacao }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha de Recolección:</strong></td>
                                    <td>{{ $venta->recoleccion->fecha_recoleccion->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cantidad Original:</strong></td>
                                    <td>{{ number_format($venta->recoleccion->cantidad_recolectada, 2) }} kg</td>
                                </tr>
                                <tr>
                                    <td><strong>Stock Actual:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $venta->recoleccion->cantidad_disponible > 10 ? 'success' : 'warning' }}">
                                            {{ number_format($venta->recoleccion->cantidad_disponible, 2) }} kg
                                        </span>
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center mt-2">
                                <a href="{{ route('recolecciones.show', $venta->recoleccion->id) }}" 
                                   class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye me-1"></i>Ver Recolección
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Volver a Ventas
                                </a>
                                @if($venta->estado_pago == 'pendiente')
                                    
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Confirmación para Marcar como Pagado --}}
<div class="modal fade" id="confirmarPagoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>Confirmar Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de marcar esta venta como <strong>PAGADA</strong>?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Esta acción actualizará el estado de pago y no se puede deshacer fácilmente.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form id="marcarPagadoForm" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Sí, Marcar como Pagado
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Marcar como pagado
function marcarPagado(id) {
    const form = document.getElementById('marcarPagadoForm');
    form.action = `/ventas/${id}/pagar`;
    
    const modal = new bootstrap.Modal(document.getElementById('confirmarPagoModal'));
    modal.show();
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

// Imprimir venta
function imprimirVenta() {
    // Crear ventana de impresión
    const ventanaImpresion = window.open('', '_blank', 'width=800,height=600');
    
    const contenidoImpresion = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Comprobante de Venta #{{ $venta->id }}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
                .info-section { margin: 20px 0; }
                .info-row { display: flex; justify-content: space-between; margin: 5px 0; }
                .total { font-size: 18px; font-weight: bold; text-align: right; margin-top: 20px; }
                .footer { margin-top: 30px; text-align: center; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>COMPROBANTE DE VENTA</h2>
                <p>Venta #{{ $venta->id }} - {{ $venta->fecha_venta->format('d/m/Y') }}</p>
            </div>
            
            <div class="info-section">
                <h3>Información del Cliente</h3>
                <div class="info-row">
                    <span><strong>Cliente:</strong></span>
                    <span>{{ $venta->cliente }}</span>
                </div>
                @if($venta->telefono_cliente)
                <div class="info-row">
                    <span><strong>Teléfono:</strong></span>
                    <span>{{ $venta->telefono_cliente }}</span>
                </div>
                @endif
            </div>
            
            <div class="info-section">
                <h3>Detalles del Producto</h3>
                <div class="info-row">
                    <span><strong>Lote:</strong></span>
                    <span>{{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Tipo de Cacao:</strong></span>
                    <span>{{ $venta->recoleccion->produccion->tipo_cacao }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Cantidad:</strong></span>
                    <span>{{ number_format($venta->cantidad_vendida, 2) }} kg</span>
                </div>
                <div class="info-row">
                    <span><strong>Precio por kg:</strong></span>
                    <span>${{ number_format($venta->precio_por_kg, 2) }}</span>
                </div>
            </div>
            
            <div class="info-section">
                <h3>Información de Pago</h3>
                <div class="info-row">
                    <span><strong>Método de Pago:</strong></span>
                    <span>{{ ucfirst($venta->metodo_pago) }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Estado:</strong></span>
                    <span>{{ ucfirst($venta->estado_pago) }}</span>
                </div>
            </div>
            
            <div class="total">
                TOTAL: ${{ number_format($venta->total_venta, 2) }}
            </div>
            
            @if($venta->observaciones)
            <div class="info-section">
                <h3>Observaciones</h3>
                <p>{{ $venta->observaciones }}</p>
            </div>
            @endif
            
            <div class="footer">
                <p>Comprobante generado el {{ now()->format('d/m/Y H:i') }}</p>
                <p>Sistema de Gestión de Cacao</p>
            </div>
        </body>
        </html>
    `;
    
    ventanaImpresion.document.write(contenidoImpresion);
    ventanaImpresion.document.close();
    
    setTimeout(() => {
        ventanaImpresion.print();
        ventanaImpresion.close();
    }, 500);
}

// Auto-focus en elementos importantes al cargar
document.addEventListener('DOMContentLoaded', function() {
    // Resaltar estado de pago si está pendiente
    @if($venta->estado_pago == 'pendiente')
        const badge = document.querySelector('.badge.bg-warning');
        if (badge) {
            badge.classList.add('animate__animated', 'animate__pulse', 'animate__infinite');
        }
    @endif
});
</script>

{{-- Animate.css para animaciones (opcional) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

@endpush