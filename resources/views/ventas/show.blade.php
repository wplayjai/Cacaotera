@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="{{ asset('css/ventas/show.css') }}">
<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">
                        <i class="fas fa-eye me-2"></i>Detalle de Venta #{{ $venta->id }}
                    </h1>
                    <p class="main-subtitle mb-0">
                        Información completa de la transacción comercial realizada
                    </p>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="breadcrumb-professional">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('recolecciones.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i>Recolecciones
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('ventas.index') }}">
                                    <i class="fas fa-shopping-cart me-1"></i>Ventas
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-eye me-1"></i>Detalle #{{ $venta->id }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div class="btn-group" role="group">
                        @if($venta->estado_pago == 'pendiente')
                            <button type="button" class="btn btn-success-professional" onclick="marcarPagado({{ $venta->id }})">
                                <i class="fas fa-check me-2"></i>Marcar Pagado
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            {{-- Información Principal de la Venta --}}
            <div class="col-md-8">
                <div class="card-professional fade-in-up">
                    <div class="card-header-professional">
                        <i class="fas fa-info-circle me-2"></i>Información de la Venta
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-professional">
                                    <tr>
                                        <td><strong><i class="fas fa-hashtag me-2 text-muted"></i>ID de Venta:</strong></td>
                                        <td>
                                            <span class="badge badge-primary-professional fs-6">#{{ $venta->id }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-calendar me-2 text-muted"></i>Fecha de Venta:</strong></td>
                                        <td>
                                            <div>
                                                <span class="fw-medium">{{ $venta->fecha_venta->format('d/m/Y') }}</span>
                                                <br><small class="text-muted">({{ $venta->fecha_venta->diffForHumans() }})</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-user me-2 text-muted"></i>Cliente:</strong></td>
                                        <td>
                                            <span class="fw-medium text-dark">{{ $venta->cliente }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-phone me-2 text-muted"></i>Teléfono:</strong></td>
                                        <td>
                                            @if($venta->telefono_cliente)
                                                <a href="tel:{{ $venta->telefono_cliente }}" class="link-professional">
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
                                <table class="table table-professional">
                                    <tr>
                                        <td><strong><i class="fas fa-credit-card me-2 text-muted"></i>Estado de Pago:</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }}-professional fs-6 {{ $venta->estado_pago == 'pendiente' ? 'pulse-animation' : '' }}">
                                                <i class="fas fa-{{ $venta->estado_pago == 'pagado' ? 'check-circle' : 'clock' }} me-1"></i>
                                                {{ ucfirst($venta->estado_pago) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-money-bill me-2 text-muted"></i>Método de Pago:</strong></td>
                                        <td>
                                            @switch($venta->metodo_pago)
                                                @case('efectivo')
                                                    <span class="badge badge-success-professional">
                                                        <i class="fas fa-money-bill-wave me-1"></i>Efectivo
                                                    </span>
                                                    @break
                                                @case('transferencia')
                                                    <span class="badge badge-info-professional">
                                                        <i class="fas fa-university me-1"></i>Transferencia
                                                    </span>
                                                    @break
                                                @case('cheque')
                                                    <span class="badge badge-warning-professional">
                                                        <i class="fas fa-money-check me-1"></i>Cheque
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge badge-info-professional">
                                                        <i class="fas fa-credit-card me-1"></i>{{ ucfirst($venta->metodo_pago) }}
                                                    </span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-clock me-2 text-muted"></i>Registrado:</strong></td>
                                        <td>
                                            <span class="fw-medium">{{ $venta->created_at->format('d/m/Y H:i') }}</span>
                                        </td>
                                    </tr>
                                    @if($venta->updated_at != $venta->created_at)
                                        <tr>
                                            <td><strong><i class="fas fa-edit me-2 text-muted"></i>Última Actualización:</strong></td>
                                            <td>
                                                <span class="fw-medium">{{ $venta->updated_at->format('d/m/Y H:i') }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        @if($venta->observaciones)
                            <hr style="border-color: var(--cacao-light);">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-comment me-2"></i>Observaciones:
                                    </h6>
                                    <div class="alert alert-info-professional">
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
                <div class="card-professional fade-in-up">
                    <div class="card-header-success">
                        <i class="fas fa-calculator me-2"></i>Resumen Financiero
                    </div>
                    <div class="card-body p-4">
                        <div class="financial-highlight">
                            <div class="financial-value info">
                                <i class="fas fa-weight me-2"></i>{{ number_format($venta->cantidad_vendida, 2) }} kg
                            </div>
                            <div class="financial-label">Cantidad Vendida</div>
                        </div>

                        <div class="financial-highlight">
                            <div class="financial-value primary">
                                <i class="fas fa-dollar-sign me-1"></i>{{ number_format($venta->precio_por_kg, 2) }}
                            </div>
                            <div class="financial-label">Precio por Kilogramo</div>
                        </div>

                        <div class="financial-highlight" style="background: linear-gradient(135deg, rgba(46, 125, 50, 0.1), rgba(46, 125, 50, 0.05)); border: 2px solid var(--success); border-radius: 8px;">
                            <div class="financial-value success" style="font-size: 2.5rem;">
                                <i class="fas fa-dollar-sign me-1"></i>{{ number_format($venta->total_venta, 2) }}
                            </div>
                            <div class="financial-label" style="color: var(--success); font-weight: 600;">Total de la Venta</div>
                        </div>
                    </div>
                </div>

                {{-- Información del Lote --}}
                <div class="card-professional fade-in-up">
                    <div class="card-header-info">
                        <i class="fas fa-seedling me-2"></i>Información del Lote
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-professional">
                            <tr>
                                <td><strong><i class="fas fa-tag me-2 text-muted"></i>Lote:</strong></td>
                                <td>
                                    <span class="badge badge-secondary-professional">
                                        {{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-coffee me-2 text-muted"></i>Tipo de Cacao:</strong></td>
                                <td>
                                    <span class="badge badge-primary-professional">
                                        {{ $venta->recoleccion->produccion->tipo_cacao }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-calendar-check me-2 text-muted"></i>Fecha de Recolección:</strong></td>
                                <td>
                                    <span class="fw-medium">{{ $venta->recoleccion->fecha_recoleccion->format('d/m/Y') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-weight-hanging me-2 text-muted"></i>Cantidad Original:</strong></td>
                                <td>
                                    <span class="fw-medium">{{ number_format($venta->recoleccion->cantidad_recolectada, 2) }} kg</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-warehouse me-2 text-muted"></i>Stock Actual:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $venta->recoleccion->cantidad_disponible > 10 ? 'success' : 'warning' }}-professional">
                                        {{ number_format($venta->recoleccion->cantidad_disponible, 2) }} kg
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <div class="text-center mt-3">
                            <a href="{{ route('recolecciones.show', $venta->recoleccion->id) }}"
                               class="btn btn-outline-professional">
                                <i class="fas fa-eye me-2"></i>Ver Recolección
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card-professional fade-in-up">
                    <div class="card-body text-center p-4">
                        <div class="btn-group" role="group">
                            <a href="{{ route('ventas.index') }}" class="btn btn-secondary-professional">
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

{{-- Modal de Confirmación para Marcar como Pagado --}}
<div class="modal fade" id="confirmarPagoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content-professional">
            <div class="modal-header modal-header-professional">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>Confirmar Pago
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modal-body-professional">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-question-circle fa-3x text-warning"></i>
                    </div>
                    <p class="fs-5 mb-3">¿Está seguro de marcar esta venta como <strong>PAGADA</strong>?</p>
                    <div class="alert alert-info-professional">
                        <i class="fas fa-info-circle me-2"></i>
                        Esta acción actualizará el estado de pago y no se puede deshacer fácilmente.
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-footer-professional">
                <button type="button" class="btn btn-outline-professional" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form id="marcarPagadoForm" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success-professional">
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
// Configuración para el archivo JavaScript externo
window.ventaConfig = {
    estadoPago: '{{ $venta->estado_pago }}',
    ventasIndexUrl: '{{ route("ventas.index") }}',
    contenidoImpresion: `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Comprobante de Venta #{{ $venta->id }}</title>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    margin: 20px;
                    color: #2c1810;
                    line-height: 1.6;
                }
                .header {
                    text-align: center;
                    border-bottom: 3px solid #4a3728;
                    padding-bottom: 15px;
                    margin-bottom: 30px;
                    background: linear-gradient(135deg, #4a3728, #6b4e3d);
                    color: white;
                    padding: 20px;
                    border-radius: 8px;
                }
                .header h1 {
                    margin: 0;
                    font-size: 24px;
                    font-weight: 600;
                }
                .header p {
                    margin: 5px 0 0 0;
                    opacity: 0.9;
                }
                .info-section {
                    margin: 25px 0;
                    background: #f8f6f4;
                    padding: 15px;
                    border-radius: 6px;
                    border-left: 4px solid #8b6f47;
                }
                .info-section h3 {
                    color: #4a3728;
                    margin-top: 0;
                    font-size: 16px;
                    font-weight: 600;
                }
                .info-row {
                    display: flex;
                    justify-content: space-between;
                    margin: 8px 0;
                    padding: 5px 0;
                    border-bottom: 1px dotted #d4c4b0;
                }
                .info-row:last-child {
                    border-bottom: none;
                }
                .info-row strong {
                    color: #4a3728;
                }
                .total {
                    font-size: 20px;
                    font-weight: bold;
                    text-align: center;
                    margin: 30px 0;
                    background: linear-gradient(135deg, #2e7d32, #1b5e20);
                    color: white;
                    padding: 20px;
                    border-radius: 8px;
                }
                .footer {
                    margin-top: 40px;
                    text-align: center;
                    font-size: 12px;
                    color: #8d6e63;
                    border-top: 2px solid #d4c4b0;
                    padding-top: 15px;
                }
                .badge {
                    background: #8b6f47;
                    color: white;
                    padding: 3px 8px;
                    border-radius: 4px;
                    font-size: 11px;
                    text-transform: uppercase;
                }
                .empresa-info {
                    text-align: center;
                    margin-bottom: 20px;
                    font-size: 14px;
                    color: #6b4e3d;
                }
            </style>
        </head>
        <body>
            <div class="empresa-info">
                <strong>Sistema de Gestión de Cacao</strong><br>
                Plataforma Integral para el Control de Producción y Ventas
            </div>

            <div class="header">
                <h1>COMPROBANTE DE VENTA</h1>
                <p>Venta #{{ $venta->id }} - {{ $venta->fecha_venta->format('d/m/Y') }}</p>
            </div>

            <div class="info-section">
                <h3>📋 Información del Cliente</h3>
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
                <div class="info-row">
                    <span><strong>Fecha de Venta:</strong></span>
                    <span>{{ $venta->fecha_venta->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="info-section">
                <h3>🌱 Detalles del Producto</h3>
                <div class="info-row">
                    <span><strong>Lote:</strong></span>
                    <span class="badge">{{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Tipo de Cacao:</strong></span>
                    <span class="badge">{{ $venta->recoleccion->produccion->tipo_cacao }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Cantidad Vendida:</strong></span>
                    <span><strong>{{ number_format($venta->cantidad_vendida, 2) }} kg</strong></span>
                </div>
                <div class="info-row">
                    <span><strong>Precio por Kilogramo:</strong></span>
                    <span><strong>${{ number_format($venta->precio_por_kg, 2) }}</strong></span>
                </div>
            </div>

            <div class="info-section">
                <h3>💳 Información de Pago</h3>
                <div class="info-row">
                    <span><strong>Método de Pago:</strong></span>
                    <span class="badge">{{ ucfirst($venta->metodo_pago) }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Estado del Pago:</strong></span>
                    <span class="badge">{{ ucfirst($venta->estado_pago) }}</span>
                </div>
            </div>

            <div class="total">
                💰 TOTAL A PAGAR: ${{ number_format($venta->total_venta, 2) }}
            </div>

            @if($venta->observaciones)
            <div class="info-section">
                <h3>📝 Observaciones</h3>
                <p style="margin: 0; font-style: italic;">{{ $venta->observaciones }}</p>
            </div>
            @endif

            <div class="footer">
                <p><strong>Comprobante generado el {{ now()->format('d/m/Y H:i') }}</strong></p>
                <p>Este documento es un comprobante válido de la transacción realizada</p>
                <p>Sistema de Gestión de Cacao - Plataforma Profesional</p>
            </div>
        </body>
        </html>
    `
};
</script>
<script src="{{ asset('js/ventas/show.js') }}"></script>
@endpush
