<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Ventas - Cacaotera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --coffee-dark: #3e2723;
            --coffee-medium: #6f4e37;
            --coffee-light: #8d6e63;
            --coffee-cream: #d7ccc8;
            --coffee-bg: #f5f5f5;
        }

        body {
            background: linear-gradient(135deg, var(--coffee-bg) 0%, #ffffff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-section {
            background: linear-gradient(135deg, var(--coffee-dark) 0%, var(--coffee-medium) 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            text-align: center;
        }

        .card-coffee {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .filter-card {
            background: linear-gradient(135deg, var(--coffee-cream) 0%, #efebe9 100%);
            border: 1px solid var(--coffee-light);
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .btn-coffee {
            background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium));
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-coffee:hover {
            background: linear-gradient(135deg, var(--coffee-medium), var(--coffee-dark));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(111, 78, 55, 0.4);
            color: white;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--coffee-dark) 0%, var(--coffee-medium) 100%);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: none;
            box-shadow: 0 8px 25px rgba(111, 78, 55, 0.3);
            margin-bottom: 1rem;
        }

        .table-coffee {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .table-coffee thead {
            background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium));
            color: white;
        }

        .table-coffee tbody tr:hover {
            background-color: rgba(111, 78, 55, 0.05);
        }

        .badge-pagado {
            background: linear-gradient(135deg, #4caf50, #388e3c);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-pendiente {
            background: linear-gradient(135deg, #ff9800, #f57c00);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .form-control-coffee {
            border: 2px solid var(--coffee-cream);
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control-coffee:focus {
            border-color: var(--coffee-medium);
            box-shadow: 0 0 0 0.2rem rgba(111, 78, 55, 0.25);
        }

        .welcome-text {
            background: rgba(255,255,255,0.9);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container">
            <h1 class="display-4 fw-bold">
                <i class="fas fa-chart-line me-3"></i>Reportes de Ventas Cacaotera
            </h1>
            <p class="lead">Sistema de Gestión de Cacao - Reportes y Estadísticas</p>
        </div>
    </div>

    <div class="container-fluid" style="max-width: 1800px;">
        
        @if(isset($ventas) && $ventas->count() > 0)
            {{-- Filtros --}}
            <div class="card filter-card">
                <div class="card-body">
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-calendar-alt me-1"></i>Fecha Desde
                                </label>
                                <input type="date" 
                                       name="fecha_desde" 
                                       class="form-control form-control-coffee" 
                                       value="{{ request('fecha_desde') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-calendar-alt me-1"></i>Fecha Hasta
                                </label>
                                <input type="date" 
                                       name="fecha_hasta" 
                                       class="form-control form-control-coffee" 
                                       value="{{ request('fecha_hasta') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-credit-card me-1"></i>Estado de Pago
                                </label>
                                <select name="estado_pago" class="form-control form-control-coffee">
                                    <option value="">Todos los estados</option>
                                    <option value="pagado" {{ request('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                    <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-search me-1"></i>Buscar Cliente
                                </label>
                                <input type="text" 
                                       name="search" 
                                       class="form-control form-control-coffee" 
                                       placeholder="Nombre del cliente..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-coffee me-2">
                                    <i class="fas fa-filter me-2"></i>Filtrar
                                </button>
                                <a href="{{ url()->current() }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-undo me-2"></i>Limpiar
                                </a>
                                <a href="{{ url('test-reporte/pdf') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" class="btn btn-danger">
                                    <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Estadísticas --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="fas fa-shopping-cart fa-2x me-3"></i>
                            <div>
                                <h3 class="mb-0">{{ $totalVentas ?? 0 }}</h3>
                                <small>Total Ventas</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="fas fa-dollar-sign fa-2x me-3"></i>
                            <div>
                                <h3 class="mb-0">${{ number_format($montoTotal ?? 0, 2) }}</h3>
                                <small>Monto Total</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <h3 class="mb-0">{{ $ventasPagadas ?? 0 }}</h3>
                                <small>Ventas Pagadas</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="fas fa-clock fa-2x me-3"></i>
                            <div>
                                <h3 class="mb-0">{{ $ventasPendientes ?? 0 }}</h3>
                                <small>Pagos Pendientes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de Ventas --}}
            <div class="card card-coffee">
                <div class="card-header" style="background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>Listado de Ventas ({{ $ventas->count() }} registros)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-coffee table-hover mb-0">
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
                                            <div class="fw-bold text-dark">
                                                {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}
                                            </div>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($venta->fecha_venta)->locale('es')->isoFormat('dddd') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $venta->cliente }}</div>
                                            @if($venta->telefono_cliente)
                                                <small class="text-muted">
                                                    <i class="fas fa-phone me-1"></i>{{ $venta->telefono_cliente }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-bold" style="color: var(--coffee-medium);">
                                                {{ $venta->recoleccion->produccion->lote->nombre ?? 'Sin lote' }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $venta->recoleccion->produccion->tipo_cacao ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #2196f3, #1976d2); color: white;">
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
                                                <span class="badge badge-pagado">
                                                    <i class="fas fa-check-circle me-1"></i>Pagado
                                                </span>
                                            @else
                                                <span class="badge badge-pendiente">
                                                    <i class="fas fa-clock me-1"></i>Pendiente
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-capitalize text-muted">
                                                <i class="fas fa-{{ $venta->metodo_pago === 'efectivo' ? 'money-bill' : ($venta->metodo_pago === 'transferencia' ? 'university' : 'check') }} me-1"></i>
                                                {{ $venta->metodo_pago }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Paginación --}}
                    @if(method_exists($ventas, 'hasPages') && $ventas->hasPages())
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            {{ $ventas->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>

        @else
            {{-- Mensaje cuando no hay datos --}}
            <div class="welcome-text">
                <h2 class="text-center mb-4" style="color: var(--coffee-dark);">
                    <i class="fas fa-coffee fa-2x mb-3 d-block"></i>
                    ¡Bienvenido al Sistema de Reportes!
                </h2>
                
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <h5 class="alert-heading">Sistema Funcionando Correctamente</h5>
                                <p class="mb-0">
                                    El módulo de reportes está operativo. No se encontraron ventas en la base de datos o necesitas aplicar filtros diferentes.
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ url('test-reporte') }}?fecha_desde=2025-01-01" class="btn btn-coffee me-2">
                                <i class="fas fa-filter me-2"></i>Probar con Filtros
                            </a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-2"></i>Volver al Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        {{-- Footer informativo --}}
        <div class="card card-coffee mt-4">
            <div class="card-body text-center">
                <p class="mb-0 text-muted">
                    <i class="fas fa-seedling me-1"></i>
                    Sistema de Gestión Cacaotera | Laravel {{ app()->version() }} | 
                    <span class="fw-bold" style="color: var(--coffee-medium);">Funcionando Correctamente</span>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
