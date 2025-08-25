@extends('layouts.worker')

@section('content')
<style>
    body {
        background: linear-gradient(90deg, #a67c52 0%, #5a3a1b 100%);
    }
    .card-cafe {
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(90,58,27,0.18);
        border: none;
        background: #fff;
        animation: fadeInUp 1s cubic-bezier(.39,.575,.56,1.000);
    }
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(60px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* Animación rebote para el ícono principal */
    .icon-bounce {
        animation: bounce 1.5s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0);}
        20% { transform: translateY(-18px);}
        40% { transform: translateY(-8px);}
        60% { transform: translateY(-18px);}
        80% { transform: translateY(-4px);}
    }
    .card-header-cafe {
        background: linear-gradient(90deg, #5a3a1b 0%, #a67c52 100%) !important;
        color: #fff !important;
        border-top-left-radius: 1.5rem !important;
        border-top-right-radius: 1.5rem !important;
        min-height: 2.5rem;
        border-bottom: none;
    }
    .btn-cafe {
        background: linear-gradient(90deg, #5a3a1b 0%, #a67c52 100%);
        color: #fff !important;
        border: none;
        border-radius: 1rem;
        font-size: 1.5rem;
        padding: 1rem 0;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(90,58,27,0.12);
        transition: background 0.2s, transform 0.2s;
        animation: none;
    }
    .btn-cafe:hover {
        background: linear-gradient(90deg, #a67c52 0%, #5a3a1b 100%);
        color: #fff !important;
        transform: scale(1.04);
        animation: pulse 0.7s;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(90,58,27,0.3);}
        70% { box-shadow: 0 0 0 12px rgba(90,58,27,0);}
        100% { box-shadow: 0 0 0 0 rgba(90,58,27,0);}
    }
    /* Animación de entrada para las tarjetas pequeñas */
    .slide-in-left {
        animation: slideInLeft 1s cubic-bezier(.39,.575,.56,1.000);
    }
    .slide-in-right {
        animation: slideInRight 1s cubic-bezier(.39,.575,.56,1.000);
    }
    @keyframes slideInLeft {
        0% { opacity: 0; transform: translateX(-80px);}
        100% { opacity: 1; transform: translateX(0);}
    }
    @keyframes slideInRight {
        0% { opacity: 0; transform: translateX(80px);}
        100% { opacity: 1; transform: translateX(0);}
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center align-items-start" style="min-height: 80vh;">
        <div class="col-12 col-lg-10 col-xl-9 mt-4">
            <div class="card card-cafe shadow-lg" style="font-size: 1.25rem;">
                <div class="card-header card-header-cafe">
                    <!-- Sin título -->
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-5">
                        <i class="fas fa-seedling fa-5x mb-4 icon-bounce" style="color: #5a3a1b;"></i>
                        <h2 class="fw-bold mb-3" style="color: #5a3a1b;">¡Bienvenido al Sistema de Cacaotera!</h2>
                        <p class="text-muted fs-5">Accede a tu módulo de trabajo para gestionar lotes, inventario y producción.</p>
                    </div>

                    <div class="row justify-content-center mb-5">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('trabajador.modulo') }}" class="btn btn-cafe btn-lg w-100 py-3">
                                <i class="fas fa-tools me-2"></i>
                                Ir al Módulo de Trabajo
                            </a>
                        </div>
                        
                    </div>

                    <hr class="my-5">

                    <div class="row text-center">
                        <div class="col-md-6 mb-4">
                            <div class="border rounded p-4 h-100 slide-in-left">
                                <i class="fas fa-seedling fa-2x mb-2" style="color: #a67c52;"></i>
                                <h4 class="fw-bold" style="color: #5a3a1b;">Gestionar Lotes</h4>
                                <small class="text-muted">Ver y trabajar en lotes asignados</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="border rounded p-4 h-100 slide-in-right">
                                <i class="fas fa-boxes fa-2x mb-2" style="color: #a67c52;"></i>
                                <h4 class="fw-bold" style="color: #5a3a1b;">Retirar Insumos</h4>
                                <small class="text-muted">Acceder al inventario disponible</small>
                            </div>
                        </div>
                        <!-- Se eliminó Registrar Cosecha -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
