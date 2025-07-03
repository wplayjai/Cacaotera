@extends('layouts.masterr')

@section('content')
<div class="container py-5">
    <!-- Encabezado con estilo de cacao -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <div style="width: 40px; height: 40px; background-color: #5D4037; border-radius: 50%; margin-right: 15px;"></div>
                <h2 class="mb-0" style="color: #3E2723; font-family: 'Georgia', serif; font-weight: 600;">Registro de Trabajadores</h2>
            </div>
            <div class="mt-2" style="height: 3px; background: linear-gradient(to right, #8D6E63, #D7CCC8);"></div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert d-flex align-items-center" style="background-color: #A1887F; color: white; border-left: 5px solid #5D4037;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <form action="{{ route('trabajadores.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm" style="border-top: 5px solid #5D4037;">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Nombre</label>
                <input type="text" name="name" class="form-control" required style="border-color: #D7CCC8; border-radius: 0;">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Apellidos</label>
                <input type="text" name="apellido" class="form-control" required style="border-color: #D7CCC8; border-radius: 0;">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Identificación</label>
                <input type="text" name="identificacion" class="form-control" required style="border-color: #D7CCC8; border-radius: 0;">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required style="border-color: #D7CCC8; border-radius: 0;">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Dirección</label>
                <input type="text" name="direccion" class="form-control" required style="border-color: #D7CCC8; border-radius: 0;">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required style="border-color: #D7CCC8; border-radius: 0;">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Fecha de Contratación</label>
                <input type="date" name="fecha_contratacion" class="form-control" required style="border-color: #D7CCC8; border-radius: 0;">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Contraseña</label>
                <input type="password" name="password" class="form-control" required style="border-color: #D7CCC8; border-radius: 0;">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Tipo de Contrato</label>
                <select name="tipo_contrato" class="form-select" required style="border-color: #D7CCC8; border-radius: 0;">
                    <option value="">Seleccione</option>
                    <option value="Permanente">Permanente</option>
                    <option value="Temporal">Temporal</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="color: #5D4037; font-weight: 500;">Forma de Pago</label>
                <select name="forma_pago" class="form-select" required style="border-color: #D7CCC8; border-radius: 0;">
                    <option value="">Seleccione</option>
                    <option value="Jornal">Jornal</option>
                    <option value="Producción">Producción</option>
                </select>
            </div>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="btn px-4 py-2" style="background-color: #5D4037; color: white; border-radius: 0;">
                <i class="fas fa-user-plus me-2"></i>Registrar Trabajador
            </button>
        </div>
    </form>
    
    <!-- Decoración de granos de cacao -->
    <div class="text-center mt-4">
        <div style="display: inline-block; font-size: 24px; color: #8D6E63; transform: rotate(-45deg); margin: 0 10px;">❋</div>
        <div style="display: inline-block; font-size: 24px; color: #5D4037; transform: rotate(45deg); margin: 0 10px;">❋</div>
        <div style="display: inline-block; font-size: 24px; color: #8D6E63; transform: rotate(-45deg); margin: 0 10px;">❋</div>
    </div>
</div>

<!-- CSS adicional para efectos de hover y focus -->
<style>
    .form-control:focus {
        border-color: #8D6E63;
        box-shadow: 0 0 0 0.2rem rgba(141, 110, 99, 0.25);
    }

    .btn:hover {
        background-color: #8D6E63 !important;
        transition: all 0.3s ease;
    }

    .form-control:hover {
        border-color: #8D6E63;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .container {
        background-color: #EFEBE9;
        border-radius: 8px;
        padding: 30px;
    }
</style>
@endsection
