@extends('layouts.masterr')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white">
               <center> <h3 class="mb-0">🌱 Registrar Nuevo Lote</h3></center>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('register.lote') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label">🌿 Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">📅 Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="area" class="form-label">📏 Área (ha)</label>
                        <input type="number" step="0.01" name="area" id="area" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="capacidad" class="form-label">🏭 Capacidad</label>
                        <input type="number" name="capacidad" id="capacidad" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_cacao" class="form-label">🍫 Tipo de Cacao</label>
                        <input type="text" name="tipo_cacao" id="tipo_cacao" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">📌 Estado</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="estimacion_cosecha" class="form-label">⚖️ Estimación de Cosecha (kg)</label>
                        <input type="number" step="0.01" name="estimacion_cosecha" id="estimacion_cosecha" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="fecha_programada_cosecha" class="form-label">📆 Fecha Programada de Cosecha</label>
                        <input type="date" name="fecha_programada_cosecha" id="fecha_programada_cosecha" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="observaciones" class="form-label">📝 Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        💾 Crear Lote
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
