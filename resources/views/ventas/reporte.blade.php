@extends('layouts.masterr')

@section('content')

<link rel="stylesheet" href="{{ asset('css/ventas/reportes.css') }}">


<div class="container-fluid">
    <div class="main-container">
        <!-- Header simple y limpio -->
        <div class="header-clean">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">Reportes de Ventas</h1>
                    <p class="page-subtitle">Análisis completo de las ventas de nuestros cacaoteros</p>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb custom-breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('ventas.index') }}">Ventas</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Reportes</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('ventas.reporte.pdf', request()->all()) }}"
                       class="btn btn-success btn-clean">
                        <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros minimalistas -->
        <div class="filters-section">
            <form method="GET" action="{{ route('ventas.reporte') }}">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Fecha Desde</label>
                        <input type="date"
                               name="fecha_desde"
                               class="form-control form-control-clean"
                               value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Fecha Hasta</label>
                        <input type="date"
                               name="fecha_hasta"
                               class="form-control form-control-clean"
                               value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Estado de Pago</label>
                        <select name="estado_pago" class="form-select form-control-clean">
                            <option value="">Todos</option>
                            <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Buscar Cliente</label>
                        <input type="text"
                               name="search"
                               class="form-control form-control-clean"
                               placeholder="Nombre del cliente..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-clean">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                    <a href="{{ route('ventas.reporte') }}" class="btn btn-outline btn-clean">
                        Limpiar
                    </a>
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-clean">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </form>
        </div>

        <!-- Estadísticas resumidas -->
        <div class="stats-summary">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-number">{{ $ventas->count() }}</div>
                        <div class="stats-label">Total Ventas</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-number">${{ number_format($ventas->sum('total_venta'), 2) }}</div>
                        <div class="stats-label">Valor Total</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de ventas -->
        <div class="table-section">
            <h5 class="section-title">Listado de Ventas</h5>

            @if($ventas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-clean">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Lote</th>
                                <th>Cantidad</th>
                                <th>Precio Unit.</th>
                                <th>Valor Total</th>
                                <th>Estado</th>
                                <th>Fecha Venta</th>
                                <th>Método Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventas as $index => $venta)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="client-info">
                                            <div class="client-name">{{ $venta->cliente }}</div>
                                            @if($venta->telefono_cliente)
                                                <div class="client-phone">{{ $venta->telefono_cliente }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="lot-info">
                                            <div class="lot-name">{{ $venta->recoleccion->produccion->lote->nombre ?? 'Sin lote' }}</div>
                                            <div class="cacao-type">{{ $venta->recoleccion->produccion->tipo_cacao ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="quantity-badge">{{ number_format($venta->cantidad_vendida, 2) }} kg</span>
                                    </td>
                                    <td>${{ number_format($venta->precio_por_kg, 2) }}</td>
                                    <td class="total-value">${{ number_format($venta->total_venta, 2) }}</td>
                                    <td>
                                        @if($venta->estado_pago === 'pagado')
                                            <span class="badge badge-success">Pagado</span>
                                        @else
                                            <span class="badge badge-warning">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="payment-method">
                                            @switch($venta->metodo_pago)
                                                @case('efectivo')
                                                    <i class="fas fa-money-bill text-success"></i>
                                                    <span>Efectivo</span>
                                                    @break
                                                @case('transferencia')
                                                    <i class="fas fa-university text-primary"></i>
                                                    <span>Transferencia</span>
                                                    @break
                                                @case('cheque')
                                                    <i class="fas fa-money-check text-info"></i>
                                                    <span>Cheque</span>
                                                    @break
                                            @endswitch
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($ventas->hasPages())
                    <div class="pagination-wrapper">
                        {{ $ventas->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5>No hay ventas para mostrar</h5>
                    <p>Ajusta los filtros para ver resultados diferentes o verifica que existan ventas registradas en el sistema.</p>
                    <a href="{{ route('ventas.index') }}" class="btn btn-primary btn-clean">
                        <i class="fas fa-plus me-2"></i>Crear Nueva Venta
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/ventas/reportes.js') }}"></script>
@endpush
