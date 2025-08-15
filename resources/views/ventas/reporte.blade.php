@extends('layouts.masterr')

@section('content')


<link rel="stylesheet" href="{{ asset('css/ventas/reportes.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="main-container">
                <!-- Header profesional -->
                <div class="header-professional">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="main-title">
                                <i class="fas fa-chart-line"></i>
                                Reportes de Ventas
                            </h1>
                            <p class="main-subtitle">
                                Análisis detallado y estadísticas de ventas del sistema
                            </p>

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-professional mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('ventas.index') }}">
                                            <i class="fas fa-shopping-cart me-1"></i>Ventas
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <i class="fas fa-chart-line me-1"></i>Reportes
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('ventas.reporte.pdf', request()->all()) }}"
                               class="btn btn-danger-professional">
                                <i class="fas fa-file-pdf"></i>
                                Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sección de Filtros -->
                <div class="filters-card fade-in-up">
                    <h5 class="section-title text-primary mb-3">
                        <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                    </h5>

                    <form method="GET" action="{{ route('ventas.reporte') }}">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-professional">
                                    <i class="fas fa-calendar-alt"></i>
                                    Fecha Desde
                                </label>
                                <input type="date"
                                       name="fecha_desde"
                                       class="form-control form-control-professional"
                                       value="{{ request('fecha_desde') }}">
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-professional">
                                    <i class="fas fa-calendar-alt"></i>
                                    Fecha Hasta
                                </label>
                                <input type="date"
                                       name="fecha_hasta"
                                       class="form-control form-control-professional"
                                       value="{{ request('fecha_hasta') }}">
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-professional">
                                    <i class="fas fa-credit-card"></i>
                                    Estado de Pago
                                </label>
                                <select name="estado_pago" class="form-select form-select-professional">
                                    <option value="">Todos los estados</option>
                                    <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                    <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-professional">
                                    <i class="fas fa-search"></i>
                                    Buscar Cliente
                                </label>
                                <input type="text"
                                       name="search"
                                       class="form-control form-control-professional"
                                       placeholder="Nombre del cliente..."
                                       value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary-professional">
                                        <i class="fas fa-filter"></i>
                                        Filtrar
                                    </button>
                                    <a href="{{ route('ventas.reporte') }}" class="btn btn-outline-professional">
                                        <i class="fas fa-undo"></i>
                                        Limpiar
                                    </a>
                                    <a href="{{ route('ventas.index') }}" class="btn btn-success-professional">
                                        <i class="fas fa-arrow-left"></i>
                                        Volver a Ventas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabla de Ventas -->
                <div class="section-card fade-in-up">
                    <div class="section-header">
                        <span>
                            <i class="fas fa-list me-2"></i>
                            Listado de Ventas ({{ $ventas->count() }} registros)
                        </span>
                    </div>
                    <div class="p-0">
                        @if($ventas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-professional mb-0">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-calendar me-1"></i>Fecha</th>
                                            <th><i class="fas fa-user me-1"></i>Cliente</th>
                                            <th><i class="fas fa-seedling me-1"></i>Lote</th>
                                            <th><i class="fas fa-weight me-1"></i>Cantidad (kg)</th>
                                            <th><i class="fas fa-dollar-sign me-1"></i>Precio/kg</th>
                                            <th><i class="fas fa-calculator me-1"></i>Total</th>
                                            <th><i class="fas fa-credit-card me-1"></i>Estado</th>
                                            <th><i class="fas fa-money-bill me-1"></i>Método</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ventas as $venta)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <strong class="text-primary">
                                                            {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}
                                                        </strong>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($venta->fecha_venta)->locale('es')->isoFormat('dddd') }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <strong class="text-dark">{{ $venta->cliente }}</strong>
                                                        @if($venta->telefono_cliente)
                                                            <small class="text-muted">
                                                                <i class="fas fa-phone me-1"></i>{{ $venta->telefono_cliente }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <strong class="text-success">
                                                            {{ $venta->recoleccion->produccion->lote->nombre ?? 'Sin lote' }}
                                                        </strong>
                                                        <small class="text-muted">
                                                            {{ $venta->recoleccion->produccion->tipo_cacao ?? 'N/A' }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info-professional">
                                                        {{ number_format($venta->cantidad_vendida, 2) }} kg
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-success fs-6">
                                                        ${{ number_format($venta->precio_por_kg, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-primary fs-5">
                                                        ${{ number_format($venta->total_venta, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($venta->estado_pago === 'pagado')
                                                        <span class="badge badge-success-professional">
                                                            <i class="fas fa-check-circle me-1"></i>Pagado
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning-professional">
                                                            <i class="fas fa-clock me-1"></i>Pendiente
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @switch($venta->metodo_pago)
                                                        @case('efectivo')
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-money-bill text-success me-2"></i>
                                                                <span class="small">Efectivo</span>
                                                            </div>
                                                            @break
                                                        @case('transferencia')
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-university text-primary me-2"></i>
                                                                <span class="small">Transferencia</span>
                                                            </div>
                                                            @break
                                                        @case('cheque')
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="fas fa-money-check text-info me-2"></i>
                                                                <span class="small">Cheque</span>
                                                            </div>
                                                            @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($ventas->hasPages())
                                <div class="d-flex justify-content-center py-4">
                                    {{ $ventas->appends(request()->query())->links() }}
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5>No hay ventas para mostrar</h5>
                                <p>Ajusta los filtros para ver resultados diferentes o<br>
                                   verifica que existan ventas registradas en el sistema.</p>
                                <a href="{{ route('ventas.index') }}" class="btn btn-primary-professional">
                                    <i class="fas fa-plus me-2"></i>Crear Nueva Venta
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="{{ asset('js/ventas/reportes.js') }}"></script>
@endpush
