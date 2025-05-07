@extends('layouts.masterr')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Trabajador</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('trabajadores.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Apellidos</label>
                <input type="text" name="apellido" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Identificación</label>
                <input type="text" name="identificacion" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Dirección</label>
                <input type="text" name="direccion" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Fecha de Contratación</label>
                <input type="date" name="fecha_contratacion" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Tipo de Contrato</label>
                <select name="tipo_contrato" class="form-control" required>
                    <option value="">Seleccione</option>
                    <option value="Permanente">Permanente</option>
                    <option value="Temporal">Temporal</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Forma de Pago</label>
                <select name="forma_pago" class="form-control" required>
                    <option value="">Seleccione</option>
                    <option value="Jornal">Jornal</option>
                    <option value="Producción">Producción</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Registrar Trabajador</button>
    </form>
</div>
@endsection
