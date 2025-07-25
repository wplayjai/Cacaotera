@extends('layouts.masterr')

@section('content')
<div class="container-fluid">`
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4><i class="fas fa-chart-line me-2"></i>Reportes de Ventas</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('ventas.index') }}" class="text-decoration-none">
                                        <i class="fas fa-shopping-cart me-1"></i>Ventas
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-chart-line me-1"></i>Reportes
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('ventas.reporte.pdf', request()->all()) }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                    </a>
                </div>

                <div class="card-body">
                    {{-- Filtros --}}
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('ventas.reporte') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt me-1"></i>Fecha Desde
                                        </label>
                                        <input type="date" 
                                               name="fecha_desde" 
                                               class="form-control" 
                                               value="{{ request('fecha_desde') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt me-1"></i>Fecha Hasta
                                        </label>
                                        <input type="date" 
                                               name="fecha_hasta" 
                                               class="form-control" 
                                               value="{{ request('fecha_hasta') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-credit-card me-1"></i>Estado de Pago
                                        </label>
                                        <select name="estado_pago" class="form-select">
                                            <option value="">Todos los estados</option>
                                            <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                            <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-search me-1"></i>Buscar Cliente
                                        </label>
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Nombre del cliente..." 
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-filter me-2"></i>Filtrar
                                        </button>
                                        <a href="{{ route('ventas.reporte') }}" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-undo me-2"></i>Limpiar
                                        </a>
                                        <a href="{{ route('ventas.index') }}" class="btn btn-success">
                                            <i class="fas fa-arrow-left me-2"></i>Volver a Ventas
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Estadísticas --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $totalVentas }}</h4>
                                            <p>Total Ventas</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-shopping-cart fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>${{ number_format($montoTotal, 2) }}</h4>
                                            <p>Monto Total</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-dollar-sign fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $ventasPagadas }}</h4>
                                            <p>Ventas Pagadas</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $ventasPendientes }}</h4>
                                            <p>Pagos Pendientes</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tabla de Ventas --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list me-2"></i>Listado de Ventas ({{ $ventas->count() }} registros)
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if($ventas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead class="table-dark">
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
                                                        <strong>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</strong>
                                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($venta->fecha_venta)->locale('es')->isoFormat('dddd') }}</small>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $venta->cliente }}</strong>
                                                        @if($venta->telefono_cliente)
                                                            <br><small class="text-muted">
                                                                <i class="fas fa-phone me-1"></i>{{ $venta->telefono_cliente }}
                                                            </small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $venta->recoleccion->produccion->lote->nombre ?? 'Sin lote' }}</strong>
                                                        <br><small class="text-muted">{{ $venta->recoleccion->produccion->tipo_cacao ?? 'N/A' }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            {{ number_format($venta->cantidad_vendida, 2) }} kg
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">
                                                            ${{ number_format($venta->precio_por_kg, 2) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-primary" style="font-size: 1.1rem;">
                                                            ${{ number_format($venta->total_venta, 2) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($venta->estado_pago === 'pagado')
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle me-1"></i>Pagado
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-clock me-1"></i>Pendiente
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @switch($venta->metodo_pago)
                                                            @case('efectivo')
                                                                <i class="fas fa-money-bill text-success"></i> Efectivo
                                                                @break
                                                            @case('transferencia')
                                                                <i class="fas fa-university text-primary"></i> Transferencia
                                                                @break
                                                            @case('cheque')
                                                                <i class="fas fa-money-check text-info"></i> Cheque
                                                                @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                {{-- Paginación --}}
                                @if($ventas->hasPages())
                                    <div class="d-flex justify-content-center mt-4 mb-3">
                                        {{ $ventas->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                                        <h5>No hay ventas para mostrar</h5>
                                        <p>Ajusta los filtros para ver resultados diferentes</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
