@extends('layouts.masterr')

@section('content')

<link rel="stylesheet" href="{{ asset('css/inventario/reportes.css') }}">

<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header limpio -->
        <div class="header-clean">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title mb-2">Reportes de Inventario</h1>
                    <p class="main-subtitle mb-3">Análisis completo de tu inventario de insumos cacaoteros</p>

                    <!-- Breadcrumb limpio -->
                    <nav aria-label="breadcrumb" class="breadcrumb-clean">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('inventario.index') }}">Inventario</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Reportes</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <a href="{{ route('inventario.reporte.pdf', request()->all()) }}" class="btn btn-primary">
                        Descargar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros limpios -->
        <div class="filters-card">
            <form method="GET" action="{{ route('inventario.reporte') }}">
                <div class="row align-items-end">
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label">Fecha Desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-lg-2 col-md-3 mb-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select">
                            <option value="">Todos</option>
                            <option value="Fertilizantes" {{ request('tipo') == 'Fertilizantes' ? 'selected' : '' }}>Fertilizantes</option>
                            <option value="Pesticidas" {{ request('tipo') == 'Pesticidas' ? 'selected' : '' }}>Pesticidas</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="form-label">Buscar Producto</label>
                        <input type="text" name="search" class="form-control" placeholder="Nombre del producto..." value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-1 col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                    <div class="col-lg-1 col-md-3 mb-3">
                        <a href="{{ route('inventario.reporte') }}" class="btn btn-outline w-100">Limpiar</a>
                    </div>
                    <div class="col-lg-1 col-md-6 mb-3">
                        <a href="{{ route('inventario.index') }}" class="btn btn-secondary w-100">Volver</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Estadísticas limpias -->
        <div class="row mb-4 justify-content-center">
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="stats-card">
                    <div class="card-body">
                        <div class="stats-number">{{ $totalSalidas }}</div>
                        <div class="stats-label">Total Salidas</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="stats-card">
                    <div class="card-body">
                        <div class="stats-number">${{ number_format($valorTotalSalidas, 2) }}</div>
                        <div class="stats-label">Valor Total</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de productos -->
        @if($inventarios->count() > 0)
            <div class="section-card">
                <div class="section-header">
                    <span>Listado de Productos</span>
                    <span class="badge">{{ $inventarios->count() }} registros</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-clean mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Valor Total</th>
                                    <th>Estado</th>
                                    <th>Fecha Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventarios as $producto)
                                    <tr>
                                        <td><span class="fw-bold">{{ $producto->id }}</span></td>
                                        <td>
                                            <strong>{{ $producto->nombre }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-type">{{ $producto->tipo }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $producto->cantidad }}</strong>
                                            <small class="text-muted">{{ $producto->unidad_medida }}</small>
                                        </td>
                                        <td>${{ number_format($producto->precio_unitario, 2) }}</td>
                                        <td>
                                            <strong class="text-success">${{ number_format($producto->cantidad * $producto->precio_unitario, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if($producto->estado == 'Óptimo')
                                                <span class="badge badge-success">{{ $producto->estado }}</span>
                                            @elseif($producto->estado == 'Por vencer')
                                                <span class="badge badge-warning">{{ $producto->estado }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $producto->estado }}</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="section-card">
                <div class="card-body">
                    <div class="empty-state">
                        <h5>No se encontraron productos</h5>
                        <p>No hay productos que coincidan con los filtros aplicados.</p>
                        <a href="{{ route('inventario.reporte') }}" class="btn btn-outline">Limpiar filtros</a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Sección de Salidas de Inventario -->
        <div class="section-card mt-4">
            <div class="section-header">
                <span>Insumos Utilizados en Lotes</span>
                <span class="badge">{{ $salidas->count() }} registros</span>
            </div>
            <div class="card-body">
                @if($salidas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-clean">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Insumo</th>
                                    <th>Lote</th>
                                    <th>Producción</th>
                                    <th>Cantidad</th>
                                    <th>Valor</th>
                                    <th>Fecha Salida</th>
                                    <th>Responsable</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salidas as $salida)
                                    <tr>
                                        <td><span class="fw-bold">{{ $salida->id }}</span></td>
                                        <td>
                                            <strong>{{ $salida->insumo ? $salida->insumo->nombre : 'N/A' }}</strong>
                                            @if($salida->insumo)
                                                <br>
                                                <span class="badge badge-type">{{ $salida->insumo->tipo }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($salida->lote)
                                                <strong>{{ $salida->lote->nombre }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $salida->lote->tipo_cacao }}</small>
                                            @else
                                                <span class="text-muted">No especificado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($salida->produccion)
                                                <span class="badge badge-primary">ID: {{ $salida->produccion->id }}</span>
                                                <br>
                                                <small class="text-muted">{{ $salida->produccion->estado ?? 'N/A' }}</small>
                                            @else
                                                <span class="text-muted">No asociado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $salida->cantidad }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $salida->unidad_medida }}</small>
                                        </td>
                                        <td>
                                            <strong class="text-success">${{ number_format($salida->cantidad * $salida->precio_unitario, 2) }}</strong>
                                            <br>
                                            <small class="text-muted">${{ number_format($salida->precio_unitario, 2) }}/{{ $salida->unidad_medida }}</small>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($salida->fecha_salida)->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($salida->fecha_salida)->format('H:i') }}</small>
                                        </td>
                                        <td>{{ $salida->responsable ?? 'No especificado' }}</td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $salida->motivo ?? 'Sin motivo' }}</span>
                                            @if($salida->observaciones)
                                                <br>
                                                <small class="text-muted">{{ $salida->observaciones }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <h5>No hay salidas registradas</h5>
                        <p>No se encontraron salidas de inventario en el período seleccionado.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-envío de formulario al cambiar los filtros select
    $('select[name="tipo"], select[name="estado"]').on('change', function() {
        $(this).closest('form').submit();
    });

    // Validación de fechas
    $('input[name="fecha_desde"], input[name="fecha_hasta"]').on('change', function() {
        const fechaDesde = new Date($('input[name="fecha_desde"]').val());
        const fechaHasta = new Date($('input[name="fecha_hasta"]').val());

        if (fechaDesde && fechaHasta && fechaDesde > fechaHasta) {
            Swal.fire({
                icon: 'warning',
                title: 'Fechas inválidas',
                text: 'La fecha desde no puede ser mayor que la fecha hasta.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
});
</script>
@endsection
