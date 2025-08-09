@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="{{ asset('css/ventas/edit.css') }}">

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
// Configuración inicial para el JavaScript externo
window.ventaConfig = {
    cantidad: {{ $venta->cantidad_vendida }},
    precio: {{ $venta->precio_por_kg }},
    total: {{ $venta->total_venta }},
    recoleccion: {{ $venta->recoleccion_id }},
    stockDisponible: {{ $venta->recoleccion->cantidad_disponible + $venta->cantidad_vendida }},
    tipoCacao: '{{ $venta->recoleccion->produccion->tipo_cacao }}',
    fechaVenta: '{{ $venta->fecha_venta->format('Y-m-d') }}',
    cliente: '{{ addslashes($venta->cliente) }}',
    telefono: '{{ $venta->telefono_cliente }}',
    estadoPago: '{{ $venta->estado_pago }}',
    metodoPago: '{{ $venta->metodo_pago }}',
    observaciones: `{{ addslashes($venta->observaciones) }}`,
    showRoute: '{{ route("ventas.show", $venta->id) }}'
};
</script>
<script src="{{ asset('js/ventas/edit.js') }}"></script>
@endpush
