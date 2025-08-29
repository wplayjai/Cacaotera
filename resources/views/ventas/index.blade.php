@extends('layouts.masterr')

@section('content')

<link rel="stylesheet" href="{{ asset('css/ventas/index.css') }}">


<meta name="csrf-token" content="{{ csrf_token() }}">


<div class="main-container">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-shopping-cart me-2"></i>Gestión de Ventas
                </h1>
                <p class="page-subtitle">Control integral de ventas de cacao y productos derivados</p>

                <!-- Breadcrumb simple -->
                <nav class="mt-2">
                    <small>
                        <a href="{{ route('recolecciones.index') }}" class="text-muted text-decoration-none">
                            <i class="fas fa-clipboard-list me-1"></i>Recolecciones
                        </a>
                        <span class="text-muted mx-2">/</span>
                        <span class="text-dark">
                            <i class="fas fa-shopping-cart me-1"></i>Ventas
                        </span>
                    </small>
                </nav>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button class="btn-simple btn-primary-simple" data-bs-toggle="modal" data-bs-target="#ventaModal">
                    <i class="fas fa-plus me-2"></i>Nueva Venta
                </button>
                <a href="{{ route('ventas.reporte') }}" class="btn-simple btn-secondary-simple">
                    <i class="fas fa-chart-bar me-2"></i>Reporte
                </a>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="row stats-row">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-number">{{ $ventasHoy ?? 0 }}</div>
                <div class="stat-label">Ventas Hoy</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-number">${{ number_format($ingresosTotales ?? 0, 2) }}</div>
                <div class="stat-label">Ingresos Totales</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card info">
                <div class="stat-number">{{ number_format($stockTotal ?? 0, 1) }} kg</div>
                <div class="stat-label">Stock Disponible</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-number">{{ $pagosPendientes ?? 0 }}</div>
                <div class="stat-label">Pagos Pendientes</div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-section">
        <form method="GET" action="{{ route('ventas.index') }}">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-4 mb-2">
                    <label class="form-label-simple">
                        <i class="fas fa-search me-1"></i>Buscar
                    </label>
                    <input type="text" name="search" class="form-control form-control-simple"
                           placeholder="Cliente o lote..." value="{{ request('search') }}">
                </div>
                <div class="col-lg-2 col-md-3 mb-2">
                    <label class="form-label-simple">
                        <i class="fas fa-calendar-alt me-1"></i>Desde
                    </label>
                    <input type="date" name="fecha_desde" class="form-control form-control-simple"
                           value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-lg-2 col-md-3 mb-2">
                    <label class="form-label-simple">
                        <i class="fas fa-calendar-alt me-1"></i>Hasta
                    </label>
                    <input type="date" name="fecha_hasta" class="form-control form-control-simple"
                           value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-lg-2 col-md-4 mb-2">
                    <label class="form-label-simple">
                        <i class="fas fa-credit-card me-1"></i>Estado
                    </label>
                    <select name="estado_pago" class="form-select form-select-simple">
                        <option value="">Todos</option>
                        <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-8 mb-2">
                    <button type="submit" class="btn-simple btn-primary-simple me-2">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="{{ route('ventas.index') }}" class="btn-simple btn-outline-simple">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla -->
    <div class="table-section">
        <div class="table-header">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list me-2"></i>Registro de Ventas</span>
                <span class="badge-simple info">{{ isset($ventas) ? $ventas->count() : 0 }} registros</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-simple">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Lote/Producción</th>
                        <th>Cantidad</th>
                        <th>Precio/kg</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Método</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas ?? [] as $venta)
                        <tr>
                            <td><strong>{{ $venta->id }}</strong></td>
                            <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                            <td>
                                <div><strong>{{ $venta->cliente }}</strong></div>
                                @if($venta->telefono_cliente)
                                    <small class="text-muted">{{ $venta->telefono_cliente }}</small>
                                @endif
                            </td>
                            <td>
                                <div><strong>{{ $venta->recoleccion->produccion->lote?->nombre ?? 'Sin lote' }}</strong></div>
                                <small class="text-muted">{{ $venta->recoleccion->produccion->tipo_cacao }}</small>
                            </td>
                            <td>
                                <span class="badge-simple info">{{ number_format($venta->cantidad_vendida, 2) }} kg</span>
                            </td>
                            <td>${{ number_format($venta->precio_por_kg, 2) }}</td>
                            <td><strong class="text-success">${{ number_format($venta->total_venta, 2) }}</strong></td>
                            <td>
                                <span class="badge-simple {{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }}">
                                    {{ ucfirst($venta->estado_pago) }}
                                </span>
                            </td>
                            <td>
                                @switch($venta->metodo_pago)
                                    @case('efectivo')
                                        <span class="badge-simple success">Efectivo</span>
                                        @break
                                    @case('transferencia')
                                        <span class="badge-simple info">Transfer.</span>
                                        @break
                                    @case('cheque')
                                        <span class="badge-simple warning">Cheque</span>
                                        @break
                                    @default
                                        <span class="badge-simple info">{{ ucfirst($venta->metodo_pago) }}</span>
                                @endswitch
                            </td>
                            <td>
                                <button type="button" class="action-btn info"
                                        onclick="verDetalle({{ $venta->id }})" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="action-btn warning"
                                        onclick="editarVenta({{ $venta->id }})" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($venta->estado_pago == 'pendiente')
                                    <button type="button" class="action-btn success"
                                            onclick="marcarPagado({{ $venta->id }})" title="Marcar como pagado">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                                <button type="button" class="action-btn danger"
                                        onclick="eliminarVenta({{ $venta->id }})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <h5>No hay ventas registradas</h5>
                                    <p>Comienza registrando una nueva venta</p>
                                    <button class="btn-simple btn-primary-simple" data-bs-toggle="modal" data-bs-target="#ventaModal">
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

    <!-- Paginación -->
    @if(isset($ventas) && $ventas->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $ventas->withQueryString()->links() }}
        </div>
    @endif

    <!-- Botón volver -->
    <div class="text-center mt-4">
        <a href="{{ route('recolecciones.index') }}" class="btn-simple btn-outline-simple">
            <i class="fas fa-arrow-left me-2"></i>Volver a Recolecciones
        </a>
    </div>
</div>

{{-- Modal para nueva venta --}}
<div class="modal fade" id="ventaModal" tabindex="-1" aria-labelledby="ventaModalLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="ventaForm" method="POST" action="{{ route('ventas.store') }}">
                @csrf
                <div class="modal-header modal-header-simple">
                    <h5 class="modal-title" id="ventaModalLabel">
                        <i class="fas fa-shopping-cart me-2"></i>Nueva Venta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body modal-body-simple">
                    <!-- Información General -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="fecha_venta" class="form-label-simple">
                                <i class="fas fa-calendar-alt text-primary me-1"></i>Fecha <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control form-control-simple" id="fecha_venta" name="fecha_venta"
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label for="recoleccion_id" class="form-label-simple">
                                <i class="fas fa-seedling text-success me-1"></i>Recolección <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-simple" id="recoleccion_id" name="recoleccion_id" required onchange="actualizarStock()">
                                <option value="">-- Seleccionar Recolección --</option>
                                @if(count($recoleccionesDisponibles ?? []) > 0)
                                    @foreach($recoleccionesDisponibles as $recoleccion)
                                        <option value="{{ $recoleccion->id }}"
                                                data-stock="{{ $recoleccion->cantidad_recolectada }}"
                                                data-tipo="{{ $recoleccion->produccion->tipo_cacao }}">
                                            {{ $recoleccion->produccion->lote?->nombre ?? 'Sin lote' }} -
                                            {{ $recoleccion->produccion->tipo_cacao }} |
                                            {{ $recoleccion->fecha_recoleccion->format('d/m/Y') }} |
                                            {{ number_format($recoleccion->cantidad_recolectada, 2) }} kg
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No hay recolecciones con stock disponible</option>
                                @endif
                            </select>
                            <div id="stockInfo" class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle"></i> Selecciona una recolección para ver el stock disponible
                            </div>
                        </div>
                    </div>

                    <!-- Cliente -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="cliente" class="form-label-simple">
                                <i class="fas fa-user text-info me-1"></i>Cliente <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-simple" id="cliente" name="cliente"
                                   placeholder="Nombre del cliente" required>
                        </div>
                        <div class="col-6">
                            <label for="telefono_cliente" class="form-label-simple">
                                <i class="fas fa-phone text-warning me-1"></i>Teléfono
                            </label>
                            <input type="text" class="form-control form-control-simple" id="telefono_cliente" name="telefono_cliente"
                                   placeholder="Teléfono">
                        </div>
                    </div>

                    <!-- Detalles de Venta -->
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="cantidad_vendida" class="form-label-simple">
                                <i class="fas fa-weight text-primary me-1"></i>Cantidad (kg) <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control form-control-simple" id="cantidad_vendida" name="cantidad_vendida"
                                   step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                        </div>
                        <div class="col-4">
                            <label for="precio_por_kg" class="form-label-simple">
                                <i class="fas fa-dollar-sign text-success me-1"></i>Precio/kg ($) <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control form-control-simple" id="precio_por_kg" name="precio_por_kg"
                                   step="0.01" min="0.01" placeholder="0.00" required onchange="calcularTotal()">
                        </div>
                        <div class="col-4">
                            <label for="total_venta" class="form-label-simple">
                                <i class="fas fa-calculator text-success me-1"></i>Total ($)
                            </label>
                            <input type="number" class="form-control form-control-simple" id="total_venta" name="total_venta"
                                   readonly style="background-color: #e9ecef;">
                        </div>
                    </div>

                    <!-- Información de Pago -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="estado_pago" class="form-label-simple">
                                <i class="fas fa-check-circle text-success me-1"></i>Estado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-simple" id="estado_pago" name="estado_pago" required>
                                <option value="pagado">Pagado</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="metodo_pago" class="form-label-simple">
                                <i class="fas fa-money-bill text-info me-1"></i>Método <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-simple" id="metodo_pago" name="metodo_pago" required>
                                <option value="efectivo">Efectivo</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="mb-3">
                        <label for="observaciones" class="form-label-simple">
                            <i class="fas fa-sticky-note text-warning me-1"></i>Observaciones
                        </label>
                        <textarea class="form-control form-control-simple" id="observaciones" name="observaciones" rows="2"
                                  placeholder="Notas adicionales..."></textarea>
                    </div>
                </div>

                <div class="modal-footer modal-footer-simple">
                    <button type="button" class="btn-simple btn-outline-simple" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn-simple btn-primary-simple">
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
