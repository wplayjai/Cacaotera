@extends('layouts.masterr')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/trabajador/create.css') }}">
@endpush

@section('content')
<div class="container py-5 main-container">
    <!-- Header del formulario con estilo café -->
    <div class="form-header form-header-specific">
        <div class="d-flex align-items-center">
            <div class="cafe-circle me-3">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <h2 class="mb-0 form-header-title">Registro de Trabajadores</h2>
                <p class="mb-0 opacity-75 form-header-subtitle">Agregar nuevo trabajador al sistema</p>
            </div>
        </div>
        <div class="decoration-line mt-3"></div>
    </div>

    @if(session('success'))
        <div class="alert alert-cafe-success d-flex align-items-center mb-4">
            <i class="fas fa-check-circle me-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-container form-container-specific">
        <form action="{{ route('trabajadores.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-user me-1 form-label-icon"></i> Nombre
                    </label>
                    <input type="text" name="name" class="form-control form-control-specific" required placeholder="Ingrese el nombre">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-user-tag me-1 form-label-icon"></i> Apellidos
                    </label>
                    <input type="text" name="apellido" class="form-control form-control-specific" required placeholder="Ingrese los apellidos">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-id-card me-1 form-label-icon"></i> Identificación
                    </label>
                    <input type="text" name="identificacion" class="form-control form-control-specific" required placeholder="Número de identificación">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-envelope me-1 form-label-icon"></i> Correo Electrónico
                    </label>
                    <input type="email" name="email" class="form-control form-control-specific" required placeholder="correo@ejemplo.com">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-map-marker-alt me-1 form-label-icon"></i> Dirección
                    </label>
                    <input type="text" name="direccion" class="form-control form-control-specific" required placeholder="Dirección completa">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-phone me-1 form-label-icon"></i> Teléfono
                    </label>
                    <input type="text" name="telefono" class="form-control form-control-specific" required placeholder="Número de teléfono">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-calendar-alt me-1 form-label-icon"></i> Fecha de Contratación
                    </label>
                    <input type="date" name="fecha_contratacion" class="form-control form-control-specific" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-lock me-1 form-label-icon"></i> Contraseña
                    </label>
                    <input type="password" name="password" class="form-control form-control-specific" required placeholder="Contraseña segura">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-file-contract me-1 form-label-icon"></i> Tipo de Contrato
                    </label>
                    <select name="tipo_contrato" class="form-select form-select-specific" required>
                        <option value="">Seleccione el tipo de contrato</option>
                        <option value="Indefinido">Indefinido</option>
                        <option value="Temporal">Temporal</option>
                        <option value="Obra o labor">Obra o labor</option>
                        <option value="Prestación de servicios">Prestación de servicios</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label form-label-specific">
                        <i class="fas fa-money-bill-wave me-1 form-label-icon"></i> Forma de Pago
                    </label>
                    <select name="forma_pago" class="form-select form-select-specific" required>
                        <option value="">Seleccione la forma de pago</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Cheque">Cheque</option>
                    </select>
                </div>
            </div>

            <div class="decoration-line my-4"></div>

            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-cafe-secondary btn-cafe-secondary-specific" onclick="history.back()">
                    <i class="fas fa-arrow-left me-2"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-cafe-primary btn-cafe-primary-specific">
                    <i class="fas fa-user-plus me-2"></i>Registrar Trabajador
                </button>
            </div>
        </form>
    </div>

    <!-- Decoración café elegante -->
    <div class="text-center mt-5">
        <div class="d-flex justify-content-center align-items-center">
            <i class="fas fa-seedling cafe-decoration cafe-decoration-specific cafe-decoration-delay-0"></i>
            <i class="fas fa-coffee cafe-decoration cafe-decoration-specific cafe-decoration-delay-1"></i>
            <i class="fas fa-leaf cafe-decoration cafe-decoration-specific cafe-decoration-delay-2"></i>
        </div>
        <p class="mt-3 mb-0 decorative-text">
            "Cultivando talento, cosechando éxito"
        </p>
    </div>
</div>
@endsection
