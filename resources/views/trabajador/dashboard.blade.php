@extends('layouts.worker')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-tie me-2"></i>
                        Panel de Trabajador
                    </h4>
                </div>

                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-seedling fa-4x text-primary mb-3"></i>
                        <h3>¡Bienvenido al Sistema de Cacaotera!</h3>
                        <p class="text-muted">Accede a tu módulo de trabajo para gestionar lotes, inventario y producción.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('trabajador.modulo') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-tools me-2"></i>
                                Ir al Módulo de Trabajo
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('trabajador.reportes') }}" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-chart-bar me-2"></i>
                                Ver Mis Reportes
                            </a>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <i class="fas fa-seedling fa-2x text-success mb-2"></i>
                                <h5>Gestionar Lotes</h5>
                                <small class="text-muted">Ver y trabajar en lotes asignados</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <i class="fas fa-boxes fa-2x text-warning mb-2"></i>
                                <h5>Retirar Insumos</h5>
                                <small class="text-muted">Acceder al inventario disponible</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <i class="fas fa-harvest fa-2x text-info mb-2"></i>
                                <h5>Registrar Cosecha</h5>
                                <small class="text-muted">Documentar producción obtenida</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-4">
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-outline-danger">
            <i class="fas fa-sign-out-alt me-2"></i>
            Cerrar sesión
        </button>
    </form>
</div>
@endsection
