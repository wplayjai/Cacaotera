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

.card-header-warning {
    background: linear-gradient(135deg, var(--warning), #e65100);
}

.card-header-info {
    background: linear-gradient(135deg, var(--info), #0d47a1);
}

.card-header-secondary {
    background: linear-gradient(135deg, #6c757d, #495057);
}

/* Formularios profesionales */
.form-label-professional {
    color: var(--cacao-primary);
    font-weight: 500;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.form-control-professional,
.form-select-professional {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.7rem 0.9rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: var(--cacao-white);
}

.form-control-professional:focus,
.form-select-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.15rem rgba(139, 111, 71, 0.15);
    outline: none;
}

.form-control-professional.is-invalid,
.form-select-professional.is-invalid {
    border-color: var(--danger);
    box-shadow: 0 0 0 0.15rem rgba(198, 40, 40, 0.15);
}

.form-control-professional.border-warning,
.form-select-professional.border-warning {
    border-color: var(--warning) !important;
    box-shadow: 0 0 0 0.15rem rgba(245, 124, 0, 0.15) !important;
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

/* Secciones de formulario */
.form-section {
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.02), rgba(139, 111, 71, 0.05));
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid var(--cacao-accent);
}

.form-section-title {
    color: var(--cacao-primary);
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--cacao-light);
    display: flex;
    align-items: center;
    gap: 0.5rem;
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

.badge-primary-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    box-shadow: 0 2px 6px rgba(74, 55, 40, 0.25);
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

/* Alertas profesionales */
.alert-professional {
    border: none;
    border-radius: 8px;
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
    font-weight: 500;
}

.alert-danger-professional {
    background: linear-gradient(135deg, rgba(198, 40, 40, 0.1), rgba(198, 40, 40, 0.05));
    color: var(--danger);
    border-left: 4px solid var(--danger);
}

.alert-warning-professional {
    background: linear-gradient(135deg, rgba(245, 124, 0, 0.1), rgba(245, 124, 0, 0.05));
    color: var(--warning);
    border-left: 4px solid var(--warning);
}

.alert-info-professional {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.1), rgba(25, 118, 210, 0.05));
    color: var(--info);
    border-left: 4px solid var(--info);
}

.alert-success-professional {
    background: linear-gradient(135deg, rgba(46, 125, 50, 0.1), rgba(46, 125, 50, 0.05));
    color: var(--success);
    border-left: 4px solid var(--success);
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
    
    .form-section {
        padding: 1rem;
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

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Efectos especiales para campos modificados */
.field-changed {
    animation: highlightChange 0.5s ease-in-out;
}

@keyframes highlightChange {
    0% {
        background-color: rgba(245, 124, 0, 0.2);
    }
    100% {
        background-color: transparent;
    }
}
</style>
<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">
                        <i class="fas fa-edit me-2"></i>Editar Venta #{{ $venta->id }}
                    </h1>
                    <p class="main-subtitle mb-0">
                        Modificación de datos de la transacción comercial
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('ventas.show', $venta->id) }}">
                                    <i class="fas fa-eye me-1"></i>Venta #{{ $venta->id }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-edit me-1"></i>Editar
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div class="btn-group" role="group">
                        <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info-professional">
                            <i class="fas fa-eye me-2"></i>Ver Detalles
                        </a>
                        <a href="{{ route('ventas.index') }}" class="btn btn-secondary-professional">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            {{-- Formulario de Edición --}}
            <div class="col-md-8">
                <div class="card-professional fade-in-up">
                    <div class="card-header-warning">
                        <i class="fas fa-edit me-2"></i>Formulario de Edición
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger-professional fade-in-up" role="alert">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Errores de Validación:</h6>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="editVentaForm" method="POST" action="{{ route('ventas.update', $venta->id) }}">
                            @csrf
                            @method('PUT')
                            
                            {{-- Información Básica --}}
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-info-circle"></i>Información Básica
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_venta" class="form-label-professional">
                                                <i class="fas fa-calendar-alt"></i>Fecha de Venta <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" class="form-control-professional @error('fecha_venta') is-invalid @enderror" 
                                                   id="fecha_venta" name="fecha_venta" 
                                                   value="{{ old('fecha_venta', $venta->fecha_venta->format('Y-m-d')) }}" required>
                                            @error('fecha_venta')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="recoleccion_id" class="form-label-professional">
                                                <i class="fas fa-seedling"></i>Lote/Recolección <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select-professional @error('recoleccion_id') is-invalid @enderror" 
                                                    id="recoleccion_id" name="recoleccion_id" required onchange="actualizarStock()">
                                                {{-- Opción actual --}}
                                                <option value="{{ $venta->recoleccion->id }}" selected 
                                                        data-stock="{{ $venta->recoleccion->cantidad_disponible + $venta->cantidad_vendida }}"
                                                        data-tipo="{{ $venta->recoleccion->produccion->tipo_cacao }}">
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
                            </div>

                            {{-- Información del Cliente --}}
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-user"></i>Información del Cliente
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cliente" class="form-label-professional">
                                                <i class="fas fa-user-circle"></i>Cliente <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control-professional @error('cliente') is-invalid @enderror" 
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
                                            <label for="telefono_cliente" class="form-label-professional">
                                                <i class="fas fa-phone"></i>Teléfono Cliente
                                            </label>
                                            <input type="text" class="form-control-professional @error('telefono_cliente') is-invalid @enderror" 
                                                   id="telefono_cliente" name="telefono_cliente" 
                                                   value="{{ old('telefono_cliente', $venta->telefono_cliente) }}" 
                                                   placeholder="Teléfono del cliente">
                                            @error('telefono_cliente')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Detalles de la Venta --}}
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-calculator"></i>Detalles de la Venta
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="cantidad_vendida" class="form-label-professional">
                                                <i class="fas fa-weight"></i>Cantidad (kg) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control-professional @error('cantidad_vendida') is-invalid @enderror" 
                                                   id="cantidad_vendida" name="cantidad_vendida" 
                                                   value="{{ old('cantidad_vendida', $venta->cantidad_vendida) }}"
                                                   step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle"></i> Cantidad original: {{ number_format($venta->cantidad_vendida, 2) }} kg
                                            </small>
                                            @error('cantidad_vendida')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="precio_por_kg" class="form-label-professional">
                                                <i class="fas fa-dollar-sign"></i>Precio por kg ($) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control-professional @error('precio_por_kg') is-invalid @enderror" 
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
                                            <label for="total_venta" class="form-label-professional">
                                                <i class="fas fa-calculator"></i>Total ($)
                                            </label>
                                            <input type="number" class="form-control-professional" id="total_venta" name="total_venta" 
                                                   value="{{ old('total_venta', $venta->total_venta) }}"
                                                   readonly style="background: linear-gradient(135deg, rgba(139, 111, 71, 0.05), rgba(139, 111, 71, 0.1)); font-weight: bold; color: var(--cacao-primary);">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Información de Pago --}}
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-credit-card"></i>Información de Pago
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estado_pago" class="form-label-professional">
                                                <i class="fas fa-check-circle"></i>Estado de Pago <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select-professional @error('estado_pago') is-invalid @enderror" 
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
                                            <label for="metodo_pago" class="form-label-professional">
                                                <i class="fas fa-money-bill"></i>Método de Pago <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select-professional @error('metodo_pago') is-invalid @enderror" 
                                                    id="metodo_pago" name="metodo_pago" required>
                                                <option value="efectivo" {{ old('metodo_pago', $venta->metodo_pago) == 'efectivo' ? 'selected' : '' }}>
                                                    Efectivo
                                                </option>
                                                <option value="transferencia" {{ old('metodo_pago', $venta->metodo_pago) == 'transferencia' ? 'selected' : '' }}>
                                                    Transferencia
                                                </option>
                                                <option value="cheque" {{ old('metodo_pago', $venta->metodo_pago) == 'cheque' ? 'selected' : '' }}>
                                                    Cheque
                                                </option>
                                            </select>
                                            @error('metodo_pago')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Observaciones --}}
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="fas fa-comment"></i>Observaciones
                                </div>
                                
                                <div class="mb-3">
                                    <textarea class="form-control-professional @error('observaciones') is-invalid @enderror" 
                                              id="observaciones" name="observaciones" rows="3" 
                                              placeholder="Observaciones adicionales...">{{ old('observaciones', $venta->observaciones) }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Botones --}}
                            <div class="d-flex justify-content-between mt-4">
                                <div class="btn-group">
                                    <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-secondary-professional">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                    <button type="button" class="btn btn-info-professional" onclick="resetearFormulario()">
                                        <i class="fas fa-undo me-2"></i>Resetear
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-warning-professional">
                                    <i class="fas fa-save me-2"></i>Actualizar Venta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Panel de Información --}}
            <div class="col-md-4">
                {{-- Información Actual --}}
                <div class="card-professional fade-in-up">
                    <div class="card-header-info">
                        <i class="fas fa-info-circle me-2"></i>Información Actual
                    </div>
                    <div class="card-body p-3">
                        <table class="table table-professional">
                            <tr>
                                <td><strong><i class="fas fa-hashtag me-2 text-muted"></i>ID Venta:</strong></td>
                                <td><span class="badge badge-primary-professional">#{{ $venta->id }}</span></td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-calendar me-2 text-muted"></i>Fecha Original:</strong></td>
                                <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-user me-2 text-muted"></i>Cliente Original:</strong></td>
                                <td>{{ $venta->cliente }}</td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-weight me-2 text-muted"></i>Cantidad Original:</strong></td>
                                <td>{{ number_format($venta->cantidad_vendida, 2) }} kg</td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-dollar-sign me-2 text-muted"></i>Total Original:</strong></td>
                                <td><strong style="color: var(--success);">${{ number_format($venta->total_venta, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong><i class="fas fa-credit-card me-2 text-muted"></i>Estado:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }}-professional">
                                        {{ ucfirst($venta->estado_pago) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Advertencias --}}
                <div class="card-professional fade-in-up">
                    <div class="card-header-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>Advertencias
                    </div>
                    <div class="card-body p-3">
                        <div class="alert alert-warning-professional mb-2">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Al cambiar la cantidad, el stock se ajustará automáticamente.
                            </small>
                        </div>
                        <div class="alert alert-info-professional mb-2">
                            <small>
                                <i class="fas fa-clock me-1"></i>
                                Los cambios se registrarán con fecha y hora de modificación.
                            </small>
                        </div>
                        @if($venta->estado_pago == 'pagado')
                            <div class="alert alert-success-professional mb-0">
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
                    <div class="card-professional fade-in-up">
                        <div class="card-header-secondary">
                            <i class="fas fa-history me-2"></i>Historial
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-professional">
                                <tr>
                                    <td><strong><i class="fas fa-plus-circle me-2 text-success"></i>Creado:</strong></td>
                                    <td>
                                        <div>
                                            <span class="fw-medium">{{ $venta->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><i class="fas fa-edit me-2 text-warning"></i>Última modificación:</strong></td>
                                    <td>
                                        <div>
                                            <span class="fw-medium">{{ $venta->updated_at->format('d/m/Y H:i') }}</span>
                                            <br><small class="text-muted">{{ $venta->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endif
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
        cancelButtonText: 'Cancelar',
        customClass: {
            confirmButton: 'btn btn-secondary-professional',
            cancelButton: 'btn btn-outline-professional'
        },
        buttonsStyling: false
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
            
            // Limpiar clases de validación y cambios
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.is-valid').forEach(el => el.classList.remove('is-valid'));
            document.querySelectorAll('.border-warning').forEach(el => el.classList.remove('border-warning'));
            document.querySelectorAll('.text-warning').forEach(el => el.classList.remove('text-warning'));
            
            // Actualizar stock
            actualizarStock();
            
            Swal.fire({
                title: '¡Reseteado!',
                text: 'El formulario ha sido restaurado',
                icon: 'success',
                confirmButtonColor: '#4a3728',
                customClass: {
                    confirmButton: 'btn btn-primary-professional'
                },
                buttonsStyling: false
            });
        }
    });
}

// Resaltar cambios en el formulario
function resaltarCambios() {
    const cantidad = parseFloat(document.getElementById('cantidad_vendida').value) || 0;
    const precio = parseFloat(document.getElementById('precio_por_kg').value) || 0;
    const total = parseFloat(document.getElementById('total_venta').value) || 0;
    
    // Resaltar campos modificados con animación
    if (cantidad !== ventaOriginal.cantidad) {
        const element = document.getElementById('cantidad_vendida');
        element.classList.add('border-warning', 'field-changed');
        setTimeout(() => element.classList.remove('field-changed'), 500);
    } else {
        document.getElementById('cantidad_vendida').classList.remove('border-warning');
    }
    
    if (precio !== ventaOriginal.precio) {
        const element = document.getElementById('precio_por_kg');
        element.classList.add('border-warning', 'field-changed');
        setTimeout(() => element.classList.remove('field-changed'), 500);
    } else {
        document.getElementById('precio_por_kg').classList.remove('border-warning');
    }
    
    if (total !== ventaOriginal.total) {
        const element = document.getElementById('total_venta');
        element.classList.add('border-warning', 'text-warning', 'field-changed');
        setTimeout(() => element.classList.remove('field-changed'), 500);
    } else {
        const element = document.getElementById('total_venta');
        element.classList.remove('border-warning', 'text-warning');
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
                confirmButtonColor: '#c62828',
                confirmButtonText: 'Entendido',
                customClass: {
                    confirmButton: 'btn btn-outline-professional'
                },
                buttonsStyling: false
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
            confirmButtonColor: '#f57c00',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar',
            customClass: {
                confirmButton: 'btn btn-warning-professional',
                cancelButton: 'btn btn-outline-professional'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    }
});

// Inicializar componentes al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Configuración inicial
    actualizarStock();
    calcularTotal();
    
    // Agregar animaciones escalonadas a las cards
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
    
    // Detectar cambios en tiempo real para resaltar
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            resaltarCambios();
        });
        
        input.addEventListener('change', function() {
            resaltarCambios();
        });
    });
});

// Detectar teclas de acceso rápido
document.addEventListener('keydown', function(e) {
    // Ctrl + S para guardar
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        document.getElementById('editVentaForm').submit();
    }
    
    // Ctrl + R para resetear
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        resetearFormulario();
    }
    
    // Escape para cancelar
    if (e.key === 'Escape') {
        window.location.href = '{{ route("ventas.show", $venta->id) }}';
    }
});

// Función para formatear números en tiempo real
function formatearNumero(input) {
    let valor = input.value.replace(/[^\d.]/g, '');
    input.value = valor;
}

// Agregar formato a los campos numéricos
document.addEventListener('DOMContentLoaded', function() {
    const numericInputs = document.querySelectorAll('input[type="number"]');
    numericInputs.forEach(input => {
        input.addEventListener('input', function() {
            formatearNumero(this);
        });
    });
});
</script>
@endpush