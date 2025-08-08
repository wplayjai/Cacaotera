@extends('layouts.masterr')

@push('styles')
<style>
/* Variables de colores café consistentes */
:root {
    --cacao-dark: #4a3728;
    --cacao-medium: #6b4e3d;
    --cacao-light: #8b6f47;
    --cacao-accent: #a0845c;
    --cacao-cream: #f5f3f0;
    --cacao-sand: #d4c4a0;
}

/* Contenedor principal */
.container {
    background: linear-gradient(135deg, var(--cacao-cream), white) !important;
    border-radius: 12px !important;
    padding: 2rem !important;
    box-shadow: 0 8px 24px rgba(74, 55, 40, 0.15) !important;
}

/* Header del formulario */
.form-header {
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
    color: white !important;
    padding: 1.5rem !important;
    border-radius: 12px 12px 0 0 !important;
    margin: -2rem -2rem 2rem -2rem !important;
    border-bottom: 3px solid var(--cacao-accent) !important;
}

/* Formulario */
.form-container {
    background: white !important;
    border-radius: 12px !important;
    padding: 2rem !important;
    box-shadow: 0 4px 12px rgba(74, 55, 40, 0.1) !important;
    border-top: 4px solid var(--cacao-accent) !important;
}

/* Labels */
.form-label {
    color: var(--cacao-dark) !important;
    font-weight: 600 !important;
    margin-bottom: 0.5rem !important;
}

/* Inputs y selects */
.form-control, .form-select {
    border: 2px solid rgba(160, 132, 92, 0.3) !important;
    border-radius: 8px !important;
    padding: 0.75rem !important;
    transition: all 0.3s ease !important;
}

.form-control:focus, .form-select:focus {
    border-color: var(--cacao-accent) !important;
    box-shadow: 0 0 0 0.25rem rgba(160, 132, 92, 0.25) !important;
    background-color: var(--cacao-cream) !important;
}

.form-control:hover, .form-select:hover {
    border-color: var(--cacao-medium) !important;
}

/* Botones */
.btn-cafe-primary {
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
    border: none !important;
    color: white !important;
    padding: 0.75rem 2rem !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
}

.btn-cafe-primary:hover {
    background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(74, 55, 40, 0.3) !important;
}

.btn-cafe-secondary {
    background: transparent !important;
    border: 2px solid var(--cacao-medium) !important;
    color: var(--cacao-medium) !important;
    padding: 0.75rem 2rem !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
}

.btn-cafe-secondary:hover {
    background: linear-gradient(135deg, var(--cacao-medium), var(--cacao-light)) !important;
    color: white !important;
    transform: translateY(-2px) !important;
}

/* Alertas */
.alert-cafe-success {
    background: linear-gradient(135deg, #27ae60, #2ecc71) !important;
    color: white !important;
    border: none !important;
    border-radius: 8px !important;
    border-left: 4px solid #1e8449 !important;
}

/* Iconos */
.fas, .far {
    color: var(--cacao-accent) !important;
}

/* Decoraciones */
.decoration-line {
    height: 3px !important;
    background: linear-gradient(to right, var(--cacao-accent), var(--cacao-sand)) !important;
    border-radius: 2px !important;
    margin: 1rem 0 !important;
}

.cafe-circle {
    width: 50px !important;
    height: 50px !important;
    background: linear-gradient(135deg, var(--cacao-dark), var(--cacao-medium)) !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    box-shadow: 0 4px 12px rgba(74, 55, 40, 0.3) !important;
}

.cafe-decoration {
    color: var(--cacao-accent) !important;
    font-size: 2rem !important;
    margin: 0 1rem !important;
    animation: float 3s ease-in-out infinite !important;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(5deg); }
}
</style>
@endpush

@section('content')
<div class="container py-5" style="background: linear-gradient(135deg, #f5f3f0, white) !important; background-color: #f5f3f0 !important; border-radius: 12px !important; padding: 2rem !important; box-shadow: 0 8px 24px rgba(74, 55, 40, 0.15) !important;">
    <!-- Header del formulario con estilo café -->
    <div class="form-header" style="background: linear-gradient(135deg, #4a3728, #6b4e3d) !important; background-color: #4a3728 !important; color: white !important; padding: 1.5rem !important; border-radius: 12px 12px 0 0 !important; margin: -2rem -2rem 2rem -2rem !important; border-bottom: 3px solid #a0845c !important;">
        <div class="d-flex align-items-center">
            <div class="cafe-circle me-3" style="width: 50px !important; height: 50px !important; background: linear-gradient(135deg, #4a3728, #6b4e3d) !important; background-color: #4a3728 !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 4px 12px rgba(74, 55, 40, 0.3) !important;">
                <i class="fas fa-user-plus" style="color: white !important; font-size: 1.5rem;"></i>
            </div>
            <div>
                <h2 class="mb-0" style="color: white !important; font-weight: 700;">Registro de Trabajadores</h2>
                <p class="mb-0 opacity-75" style="color: #f5f3f0 !important;">Agregar nuevo trabajador al sistema</p>
            </div>
        </div>
        <div class="decoration-line mt-3" style="height: 3px !important; background: linear-gradient(to right, #a0845c, #d4c4a0) !important; border-radius: 2px !important; margin: 1rem 0 !important;"></div>
    </div>

    @if(session('success'))
        <div class="alert alert-cafe-success d-flex align-items-center mb-4" style="background: linear-gradient(135deg, #27ae60, #2ecc71) !important; background-color: #27ae60 !important; color: white !important; border: none !important; border-radius: 8px !important; border-left: 4px solid #1e8449 !important;">
            <i class="fas fa-check-circle me-2" style="color: white !important;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="form-container" style="background: white !important; background-color: white !important; border-radius: 12px !important; padding: 2rem !important; box-shadow: 0 4px 12px rgba(74, 55, 40, 0.1) !important; border-top: 4px solid #a0845c !important;">
        <form action="{{ route('trabajadores.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-user me-1" style="color: #a0845c !important;"></i> Nombre
                    </label>
                    <input type="text" name="name" class="form-control" required placeholder="Ingrese el nombre" style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-user-tag me-1" style="color: #a0845c !important;"></i> Apellidos
                    </label>
                    <input type="text" name="apellido" class="form-control" required placeholder="Ingrese los apellidos" style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-id-card me-1" style="color: #a0845c !important;"></i> Identificación
                    </label>
                    <input type="text" name="identificacion" class="form-control" required placeholder="Número de identificación" style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-envelope me-1" style="color: #a0845c !important;"></i> Correo Electrónico
                    </label>
                    <input type="email" name="email" class="form-control" required placeholder="correo@ejemplo.com" style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-map-marker-alt me-1" style="color: #a0845c !important;"></i> Dirección
                    </label>
                    <input type="text" name="direccion" class="form-control" required placeholder="Dirección completa" style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-phone me-1" style="color: #a0845c !important;"></i> Teléfono
                    </label>
                    <input type="text" name="telefono" class="form-control" required placeholder="Número de teléfono" style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-calendar-alt me-1" style="color: #a0845c !important;"></i> Fecha de Contratación
                    </label>
                    <input type="date" name="fecha_contratacion" class="form-control" required style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-lock me-1" style="color: #a0845c !important;"></i> Contraseña
                    </label>
                    <input type="password" name="password" class="form-control" required placeholder="Contraseña segura" style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-file-contract me-1" style="color: #a0845c !important;"></i> Tipo de Contrato
                    </label>
                    <select name="tipo_contrato" class="form-select" required style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                        <option value="">Seleccione el tipo de contrato</option>
                        <option value="Indefinido">Indefinido</option>
                        <option value="Temporal">Temporal</option>
                        <option value="Obra o labor">Obra o labor</option>
                        <option value="Prestación de servicios">Prestación de servicios</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" style="color: #4a3728 !important; font-weight: 600 !important; margin-bottom: 0.5rem !important;">
                        <i class="fas fa-money-bill-wave me-1" style="color: #a0845c !important;"></i> Forma de Pago
                    </label>
                    <select name="forma_pago" class="form-select" required style="border: 2px solid rgba(160, 132, 92, 0.3) !important; border-radius: 8px !important; padding: 0.75rem !important;">
                        <option value="">Seleccione la forma de pago</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Cheque">Cheque</option>
                    </select>
                </div>
            </div>

            <div class="decoration-line my-4" style="height: 3px !important; background: linear-gradient(to right, #a0845c, #d4c4a0) !important; border-radius: 2px !important; margin: 1rem 0 !important;"></div>

            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-cafe-secondary" onclick="history.back()" style="background: transparent !important; border: 2px solid #6b4e3d !important; color: #6b4e3d !important; padding: 0.75rem 2rem !important; border-radius: 8px !important; font-weight: 600 !important;">
                    <i class="fas fa-arrow-left me-2"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-cafe-primary" style="background: linear-gradient(135deg, #4a3728, #6b4e3d) !important; background-color: #4a3728 !important; border: none !important; color: white !important; padding: 0.75rem 2rem !important; border-radius: 8px !important; font-weight: 600 !important;">
                    <i class="fas fa-user-plus me-2"></i>Registrar Trabajador
                </button>
            </div>
        </form>
    </div>
    
    <!-- Decoración café elegante -->
    <div class="text-center mt-5">
        <div class="d-flex justify-content-center align-items-center">
            <i class="fas fa-seedling cafe-decoration" style="color: #a0845c !important; font-size: 2rem !important; margin: 0 1rem !important; animation: float 3s ease-in-out infinite !important; animation-delay: 0s;"></i>
            <i class="fas fa-coffee cafe-decoration" style="color: #a0845c !important; font-size: 2rem !important; margin: 0 1rem !important; animation: float 3s ease-in-out infinite !important; animation-delay: 1s;"></i>
            <i class="fas fa-leaf cafe-decoration" style="color: #a0845c !important; font-size: 2rem !important; margin: 0 1rem !important; animation: float 3s ease-in-out infinite !important; animation-delay: 2s;"></i>
        </div>
        <p class="mt-3 mb-0" style="color: #6b4e3d !important; font-style: italic;">
            "Cultivando talento, cosechando éxito"
        </p>
    </div>
</div>
@endsection
