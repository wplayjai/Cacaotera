@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    background: var(--cacao-bg);
    color: var(--cacao-text);
}

/* Container principal */
.main-container {
    background: var(--cacao-white);
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 1rem 0;
}

/* Header con gradiente */
.header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    padding: 1.5rem;
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
}

/* Título principal */
.main-title {
    color: var(--cacao-white);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.main-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

/* Breadcrumb profesional */
.breadcrumb-professional {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    padding: 0.5rem 1rem;
    margin-top: 1rem;
}

.breadcrumb-professional .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-professional .breadcrumb-item a:hover {
    color: var(--cacao-white);
}

.breadcrumb-professional .breadcrumb-item.active {
    color: var(--cacao-white);
}

/* Cards profesionales */
.card-professional {
    background: var(--cacao-white);
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card-professional:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.card-header-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    padding: 1rem 1.5rem;
    border-bottom: none;
    font-weight: 600;
    font-size: 1rem;
}

.card-header-success {
    background: linear-gradient(135deg, var(--success), #1b5e20);
}

.card-header-info {
    background: linear-gradient(135deg, var(--info), #0d47a1);
}

.card-header-warning {
    background: linear-gradient(135deg, var(--warning), #e65100);
}

/* Badges profesionales */
.badge-professional {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-weight: 500;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.badge-success-professional {
    background: linear-gradient(135deg, var(--success), #1b5e20);
    color: var(--cacao-white);
    box-shadow: 0 2px 6px rgba(46, 125, 50, 0.25);
}

.badge-warning-professional {
    background: linear-gradient(135deg, var(--warning), #e65100);
    color: var(--cacao-white);
    box-shadow: 0 2px 6px rgba(245, 124, 0, 0.25);
}

.badge-primary-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    box-shadow: 0 2px 6px rgba(74, 55, 40, 0.25);
}

.badge-info-professional {
    background: linear-gradient(135deg, var(--info), #0d47a1);
    color: var(--cacao-white);
    box-shadow: 0 2px 6px rgba(25, 118, 210, 0.25);
}

.badge-secondary-professional {
    background: linear-gradient(135deg, var(--cacao-accent), var(--cacao-muted));
    color: var(--cacao-white);
    box-shadow: 0 2px 6px rgba(139, 111, 71, 0.25);
}

/* Botones profesionales */
.btn-professional {
    border: none;
    border-radius: 6px;
    padding: 0.7rem 1.3rem;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-primary-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(74, 55, 40, 0.25);
}

.btn-primary-professional:hover {
    background: linear-gradient(135deg, var(--cacao-secondary), var(--cacao-primary));
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 5px 12px rgba(74, 55, 40, 0.3);
}

.btn-success-professional {
    background: linear-gradient(135deg, var(--success), #1b5e20);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(46, 125, 50, 0.25);
}

.btn-success-professional:hover {
    background: linear-gradient(135deg, #1b5e20, var(--success));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-secondary-professional {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(108, 117, 125, 0.25);
}

.btn-secondary-professional:hover {
    background: linear-gradient(135deg, #495057, #6c757d);
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-outline-professional {
    background: transparent;
    color: var(--cacao-primary);
    border: 2px solid var(--cacao-light);
}

.btn-outline-professional:hover {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border-color: var(--cacao-primary);
}

.btn-danger-professional {
    background: linear-gradient(135deg, var(--danger), #b71c1c);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(198, 40, 40, 0.25);
}

.btn-danger-professional:hover {
    background: linear-gradient(135deg, #b71c1c, var(--danger));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-warning-professional {
    background: linear-gradient(135deg, var(--warning), #e65100);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(245, 124, 0, 0.25);
}

.btn-warning-professional:hover {
    background: linear-gradient(135deg, #e65100, var(--warning));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-info-professional {
    background: linear-gradient(135deg, var(--info), #0d47a1);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(25, 118, 210, 0.25);
}

.btn-info-professional:hover {
    background: linear-gradient(135deg, #0d47a1, var(--info));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

/* Tablas profesionales */
.table-professional {
    margin: 0;
    font-size: 0.9rem;
}

.table-professional td {
    padding: 0.8rem;
    vertical-align: middle;
    border: none;
    color: var(--cacao-text);
}

.table-professional tr {
    border-bottom: 1px solid rgba(139, 111, 71, 0.1);
}

.table-professional tr:last-child {
    border-bottom: none;
}

/* Sección de resumen financiero */
.financial-highlight {
    text-align: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.05), rgba(139, 111, 71, 0.1));
    border-radius: 8px;
    margin-bottom: 1rem;
}

.financial-value {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}

.financial-label {
    font-size: 0.9rem;
    color: var(--cacao-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

.financial-value.primary {
    color: var(--cacao-primary);
}

.financial-value.success {
    color: var(--success);
}

.financial-value.info {
    color: var(--info);
}

/* Alertas profesionales */
.alert-professional {
    border: none;
    border-radius: 8px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.alert-info-professional {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.1), rgba(25, 118, 210, 0.05));
    color: var(--info);
    border-left: 4px solid var(--info);
}

/* Estados responsivos */
@media (max-width: 768px) {
    .main-container {
        margin: 0.5rem;
        border-radius: 8px;
    }
    
    .header-professional {
        padding: 1.2rem;
        margin: -1rem -1rem 1.2rem -1rem;
    }
    
    .main-title {
        font-size: 1.3rem;
        text-align: center;
    }
    
    .btn-professional {
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    .financial-value {
        font-size: 1.7rem;
    }
    
    .card-professional {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .header-professional {
        padding: 1rem;
    }
    
    .main-title {
        font-size: 1.2rem;
    }
    
    .financial-value {
        font-size: 1.5rem;
    }
    
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn-professional {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}

/* Animaciones profesionales */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.02);
    }
    100% {
        transform: scale(1);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.pulse-animation {
    animation: pulse 2s infinite;
}

/* Enlaces profesionales */
.link-professional {
    color: var(--cacao-primary);
    text-decoration: none;
    transition: color 0.2s ease;
}

.link-professional:hover {
    color: var(--cacao-secondary);
    text-decoration: underline;
}

/* Modal profesional */
.modal-content-professional {
    border: none;
    border-radius: 8px;
    overflow: hidden;
}

.modal-header-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    border-bottom: none;
}

.modal-body-professional {
    background: var(--cacao-bg);
    padding: 2rem;
}

.modal-footer-professional {
    background: var(--cacao-bg);
    border-top: 1px solid var(--cacao-light);
    padding: 1rem 2rem;
}
</style>
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
// Marcar como pagado
function marcarPagado(id) {
    const form = document.getElementById('marcarPagadoForm');
    form.action = `/ventas/${id}/pagar`;
    
    const modal = new bootstrap.Modal(document.getElementById('confirmarPagoModal'));
    modal.show();
}

// Editar venta
function editarVenta(id) {
    window.location.href = `/ventas/${id}/edit`;
}

// Eliminar venta
function eliminarVenta(id) {
    Swal.fire({
        title: '¿Eliminar Venta?',
        text: "Esta acción no se puede deshacer. El stock se restaurará automáticamente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c62828',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'btn btn-danger-professional',
            cancelButton: 'btn btn-outline-professional'
        },
        buttonsStyling: false
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
    // Crear ventana de impresión con diseño profesional
    const ventanaImpresion = window.open('', '_blank', 'width=800,height=600');
    
    const contenidoImpresion = `
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
    `;
    
    ventanaImpresion.document.write(contenidoImpresion);
    ventanaImpresion.document.close();
    
    // Esperar a que se cargue y luego imprimir
    setTimeout(() => {
        ventanaImpresion.print();
        ventanaImpresion.close();
    }, 1000);
}

// Inicializar componentes al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Agregar animaciones a los elementos
    const cards = document.querySelectorAll('.card-professional');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in-up');
        }, index * 150);
    });
    
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Agregar efectos hover a los botones
    const buttons = document.querySelectorAll('.btn-professional');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Efecto especial para badges con estado pendiente
    @if($venta->estado_pago == 'pendiente')
        const badgePendiente = document.querySelector('.pulse-animation');
        if (badgePendiente) {
            setInterval(() => {
                badgePendiente.style.boxShadow = '0 0 20px rgba(245, 124, 0, 0.5)';
                setTimeout(() => {
                    badgePendiente.style.boxShadow = '0 2px 6px rgba(245, 124, 0, 0.25)';
                }, 1000);
            }, 2000);
        }
    @endif
});

// Detectar teclas de acceso rápido
document.addEventListener('keydown', function(e) {
    // Ctrl + P para imprimir
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        imprimirVenta();
    }
    
    // Escape para volver
    if (e.key === 'Escape') {
        window.location.href = '{{ route("ventas.index") }}';
    }
});
</script>
@endpush