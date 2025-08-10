@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">
                        <i class="bi bi-speedometer2 text-primary me-2"></i>
                        Panel de Control
                    </h2>
                    
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ $ventasTotales ?? 0 }}</h4>
                                            <small>Ventas (30 días)</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-cart fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ $produccionTotal ?? 0 }}</h4>
                                            <small>Producción (30 días)</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-leaf fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ $clientesActivos ?? 0 }}</h4>
                                            <small>Clientes Activos</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-people fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0">{{ number_format($rentabilidad ?? 0, 1) }}%</h4>
                                            <small>Rentabilidad</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="bi bi-graph-up fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="bi bi-people text-primary me-2"></i>
                                        Trabajadores Recientes
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @forelse($trabajadores ?? [] as $trabajador)
                                        @if($trabajador->user)
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3">
                                                <div class="rounded-circle bg-light text-primary fw-bold d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                    {{ strtoupper(substr($trabajador->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $trabajador->user->name ?? 'Sin nombre' }}</div>
                                                <div class="text-muted small">{{ $trabajador->tipo_contrato ?? 'Sin contrato' }}</div>
                                            </div>
                                        </div>
                                        @endif
                                    @empty
                                        <p class="text-muted">No hay trabajadores registrados</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="bi bi-boxes text-primary me-2"></i>
                                        Estado del Inventario
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="text-success">
                                                <h4>{{ $productosOptimos ?? 0 }}</h4>
                                                <small>Óptimo</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-warning">
                                                <h4>{{ $productosPorVencer ?? 0 }}</h4>
                                                <small>Por Vencer</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-danger">
                                                <h4>{{ $productosRestringidos ?? 0 }}</h4>
                                                <small>Restringido</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

