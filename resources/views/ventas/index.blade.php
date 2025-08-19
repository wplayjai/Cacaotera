@extends('layouts.masterr')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/ventas/index.css') }}">

<div class="main-container p-4">
    <!-- Header profesional -->
    <div class="header-professional">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div class="flex-grow-1">
                <h1 class="main-title text-white mb-2">
                    <i class="fas fa-shopping-cart me-2"></i>Gestión de Ventas
                </h1>
                <p class="main-subtitle text-white-50 mb-0">
                    Control integral de ventas de cacao y productos derivados
                </p>

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="breadcrumb-professional">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('recolecciones.index') }}">
                                <i class="fas fa-clipboard-list me-1"></i>Recolecciones
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fas fa-shopping-cart me-1"></i>Ventas
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary-professional" data-bs-toggle="modal" data-bs-target="#ventaModal">
                        <i class="fas fa-plus me-2"></i>Nueva Venta
                    </button>
                    <a href="{{ route('ventas.reporte') }}" class="btn btn-info-professional">
                        <i class="fas fa-chart-bar me-2"></i>Reporte
                    </a>
                </div>
            </div>
        </div>
    </div>
        <!-- Alertas profesionales -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Estadísticas de ventas -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card stats-card-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">{{ $ventasHoy ?? 0 }}</div>
                                <div class="stats-label">Ventas Hoy</div>
                            </div>
                            <div>
                                <i class="fas fa-shopping-cart stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card stats-card-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">${{ number_format($ingresosTotales ?? 0, 2) }}</div>
                                <div class="stats-label">Ingresos Totales</div>
                            </div>
                            <div>
                                <i class="fas fa-dollar-sign stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card stats-card-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">{{ number_format($stockTotal ?? 0, 1) }} kg</div>
                                <div class="stats-label">Stock Disponible</div>
                            </div>
                            <div>
                                <i class="fas fa-warehouse stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card stats-card-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stats-number">{{ $pagosPendientes ?? 0 }}</div>
                                <div class="stats-label">Pagos Pendientes</div>
                            </div>
                            <div>
                                <i class="fas fa-clock stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros profesionales -->
        <div class="filters-card fade-in-up">
            <form method="GET" action="{{ route('ventas.index') }}">
                <div class="row align-items-end">
                    <div class="col-lg-3 col-md-4 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-search"></i>Buscar
                        </label>
                        <input type="text"
                               name="search"
                               class="form-control-professional"
                               placeholder="Cliente o lote..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-calendar-alt"></i>Desde
                        </label>
                        <input type="date"
                               name="fecha_desde"
                               class="form-control-professional"
                               value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-calendar-alt"></i>Hasta
                        </label>
                        <input type="date"
                               name="fecha_hasta"
                               class="form-control-professional"
                               value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="form-label-professional">
                            <i class="fas fa-credit-card"></i>Estado
                        </label>
                        <select name="estado_pago" class="form-select-professional">
                            <option value="">Todos</option>
                            <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary-professional w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="col-lg-1 col-md-3 mb-3">
                        <a href="{{ route('ventas.index') }}" class="btn btn-outline-professional w-100">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de ventas -->
        <div class="section-card">
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list me-2"></i>
                    <span>Registro de Ventas</span>
                </div>
                <span class="badge bg-white text-dark">{{ isset($ventas) ? $ventas->count() : 0 }} registros</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-professional table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                <th><i class="fas fa-calendar me-1"></i>Fecha</th>
                                <th><i class="fas fa-user me-1"></i>Cliente</th>
                                <th><i class="fas fa-seedling me-1"></i>Lote/Producción</th>
                                <th><i class="fas fa-weight me-1"></i>Cantidad</th>
                                <th><i class="fas fa-dollar-sign me-1"></i>Precio/kg</th>
                                <th><i class="fas fa-calculator me-1"></i>Total</th>
                                <th><i class="fas fa-credit-card me-1"></i>Estado</th>
                                <th><i class="fas fa-money-bill me-1"></i>Método</th>
                                <th><i class="fas fa-cogs me-1"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventas ?? [] as $venta)
                                <tr>
                                    <td class="text-center"><span class="fw-bold">{{ $venta->id }}</span></td>
                                    <td class="text-center">
                                        <span class="fw-medium">{{ $venta->fecha_venta->format('d/m/Y') }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong class="text-dark">{{ $venta->cliente }}</strong>
                                            @if($venta->telefono_cliente)
                                                <br><small class="text-muted">{{ $venta->telefono_cliente }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong class="text-dark">{{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</strong>
                                            <br><small class="text-muted">{{ $venta->recoleccion->produccion->tipo_cacao }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info-professional">
                                            {{ number_format($venta->cantidad_vendida, 2) }} kg
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-medium">${{ number_format($venta->precio_por_kg, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-success">
                                            ${{ number_format($venta->total_venta, 2) }}
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }}-professional badge-small">
                                            {{ ucfirst($venta->estado_pago) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            @switch($venta->metodo_pago)
                                                @case('efectivo')
                                                    <span class="badge badge-success-professional badge-small">
                                                        <i class="fas fa-money-bill-wave me-1"></i>Efectivo
                                                    </span>
                                                    @break
                                                @case('transferencia')
                                                    <span class="badge badge-info-professional badge-small">
                                                        <i class="fas fa-university me-1"></i>Transfer.
                                                    </span>
                                                    @break
                                                @case('cheque')
                                                    <span class="badge badge-warning-professional badge-small">
                                                        <i class="fas fa-money-check me-1"></i>Cheque
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge badge-info-professional badge-small">
                                                        <i class="fas fa-credit-card me-1"></i>{{ ucfirst($venta->metodo_pago) }}
                                                    </span>
                                            @endswitch
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info-professional"
                                                    onclick="verDetalle({{ $venta->id }})" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning-professional"
                                                    onclick="editarVenta({{ $venta->id }})" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($venta->estado_pago == 'pendiente')
                                                <button type="button" class="btn btn-sm btn-success-professional"
                                                        onclick="marcarPagado({{ $venta->id }})" title="Marcar como pagado">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger-professional"
                                                    onclick="eliminarVenta({{ $venta->id }})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                            <h5>No hay ventas registradas</h5>
                                            <p>Comienza registrando una nueva venta</p>
                                            <button class="btn btn-primary-professional" data-bs-toggle="modal" data-bs-target="#ventaModal">
                                                <i class="fas fa-plus me-2"></i>Nueva Venta
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Paginación -->
        @if(isset($ventas) && $ventas->hasPages())
            <div class="d-flex justify-content-center">
                {{ $ventas->withQueryString()->links() }}
            </div>
        @endif

        <!-- Botón para volver -->
        <div class="mt-3 text-center">
            <a href="{{ route('recolecciones.index') }}" class="btn btn-outline-professional">
                <i class="fas fa-arrow-left me-2"></i>Volver a Recolecciones
            </a>
        </div>
</div>

{{-- Modal para nueva venta --}}
<div class="modal fade" id="ventaModal" tabindex="-1" aria-labelledby="ventaModalLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content modal-cacao">
            <form id="ventaForm" method="POST" action="{{ route('ventas.store') }}">
                @csrf
                <div class="modal-header modal-header-cacao">
                    <h5 class="modal-title" id="ventaModalLabel">
                        <i class="fas fa-shopping-cart me-2"></i>Nueva Venta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body modal-body-cacao">

                    <!-- Información General -->
                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="fecha_venta" class="form-label-professional form-label-small">
                                    <i class="fas fa-calendar-alt text-primary"></i> Fecha <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control-professional form-control-small" id="fecha_venta" name="fecha_venta"
                                       value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-6">
                                <label for="recoleccion_id" class="form-label-professional form-label-small">
                                    <i class="fas fa-seedling text-success"></i> Recolección Disponible <span class="text-danger">*</span>
                                </label>
                                <select class="form-select-professional form-control-small" id="recoleccion_id" name="recoleccion_id" required onchange="actualizarStock()">
                                    <option value="">-- Seleccionar Recolección --</option>
                                    @if(count($recoleccionesDisponibles ?? []) > 0)
                                        @foreach($recoleccionesDisponibles as $recoleccion)
                                            <option value="{{ $recoleccion->id }}"
                                                    data-stock="{{ $recoleccion->cantidad_recolectada }}"
                                                    data-tipo="{{ $recoleccion->produccion->tipo_cacao }}">
                                                🌱 {{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }} -
                                                {{ $recoleccion->produccion->tipo_cacao }} |
                                                📅 {{ $recoleccion->fecha_recoleccion->format('d/m/Y') }} |
                                                📦 {{ number_format($recoleccion->cantidad_recolectada, 2) }} kg recolectados
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay recolecciones con stock disponible</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <small id="stockInfo" class="form-text text-muted stock-info-text"></small>
                            </div>
                        </div>
                    </div>

                    <!-- Cliente -->
                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="cliente" class="form-label-professional form-label-small">
                                    <i class="fas fa-user text-info"></i> Cliente <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control-professional form-control-small" id="cliente" name="cliente"
                                       placeholder="Nombre del cliente" required>
                            </div>

                            <div class="col-6">
                                <label for="telefono_cliente" class="form-label-professional form-label-small">
                                    <i class="fas fa-phone text-warning"></i> Teléfono
                                </label>
                                <input type="text" class="form-control-professional form-control-small" id="telefono_cliente" name="telefono_cliente"
                                       placeholder="Teléfono">
                            </div>
                        </div>
                    </div>

                    <!-- Detalles de Venta -->
                    <div class="mb-3 detalle-venta-section">
                        <h6 class="detalle-venta-title">
                            <i class="fas fa-calculator me-2"></i>Detalles de Venta
                        </h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="cantidad_vendida" class="form-label-professional form-label-small">
                                    <i class="fas fa-weight text-primary"></i> Cantidad (kg) <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control-professional form-control-small" id="cantidad_vendida" name="cantidad_vendida"
                                       step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                            </div>
                            <div class="col-6">
                                <label for="precio_por_kg" class="form-label-professional form-label-small">
                                    <i class="fas fa-dollar-sign text-success"></i> Precio/kg ($) <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control-professional form-control-small" id="precio_por_kg" name="precio_por_kg"
                                       step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="total-venta-container">
                                    <label for="total_venta" class="form-label-professional form-label-small">
                                        <i class="fas fa-calculator text-success"></i> Total ($)
                                    </label>
                                    <input type="number" class="form-control-professional total-venta-input" id="total_venta" name="total_venta" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Pago -->
                    <div class="mb-3 pago-info-section">
                        <h6 class="pago-info-title">
                            <i class="fas fa-credit-card me-2"></i>Información de Pago
                        </h6>
                        <div class="row g-2 justify-content-center">
                            <div class="col-5">
                                <label for="estado_pago" class="form-label-professional form-label-small">
                                    <i class="fas fa-check-circle text-success"></i> Estado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select-professional form-control-small" id="estado_pago" name="estado_pago" required>
                                    <option value="pagado">✅ Pagado</option>
                                    <option value="pendiente">⏳ Pendiente</option>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="metodo_pago" class="form-label-professional form-label-small">
                                    <i class="fas fa-money-bill text-info"></i> Método <span class="text-danger">*</span>
                                </label>
                                <select class="form-select-professional form-control-small" id="metodo_pago" name="metodo_pago" required>
                                    <option value="efectivo">💵 Efectivo</option>
                                    <option value="transferencia">🏦 Transferencia</option>
                                    <option value="cheque">📄 Cheque</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2 mt-2 justify-content-center">
                            <div class="col-10 text-center">
                                <label for="observaciones" class="form-label-professional form-label-small observaciones-label">
                                    <i class="fas fa-sticky-note text-warning"></i> Observaciones
                                </label>
                                <textarea class="form-control-professional observaciones-textarea" id="observaciones" name="observaciones" rows="2"
                                          placeholder="Notas adicionales..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer modal-footer-cacao">
                    <button type="button" class="btn btn-outline-professional btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary-professional btn-sm">
                        <i class="fas fa-save me-1"></i>Guardar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/ventas/index.js') }}"></script>
@endpush
