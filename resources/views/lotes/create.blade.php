{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\create.blade.php --}}
@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4 text-center" style="color: #6f4e37;">Gestión de Lotes</h1>

    {{-- Botón para abrir el modal --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-crear-lote" data-bs-toggle="modal" data-bs-target="#crearLoteModal">
            Crear nuevo lote
        </button>
    </div>

    {{-- Tabla para mostrar los lotes existentes --}}
    <div class="card" style="border: 2px solid #6f4e37; max-width: 100%; overflow-x: auto;">
        <div class="card-header text-white" style="background-color: #6f4e37;">Lotes Registrados</div>
        <div class="card-body">
            <table class="table table-striped table-bordered" style="width: 100%; table-layout: fixed;">
                <thead style="background-color: #6f4e37; color: white;">
                    <tr>
                        <th style="width: 15%;">Nombre</th>
                        <th style="width: 10%;">Fecha Inicio</th>
                        <th style="width: 10%;">Área (m²)</th>
                        <th style="width: 10%;">Capacidad (kg)</th>
                        <th style="width: 10%;">Tipo de Cacao</th>
                        <th style="width: 10%;">Estado</th>
                        <th style="width: 10%;">Estimación Cosecha (kg)</th>
                        <th style="width: 10%;">Fecha Programada Cosecha</th>
                        <th style="width: 15%;">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lotes as $lote)
                        <tr>
                            <td>{{ $lote->nombre }}</td>
                            <td>{{ $lote->fecha_inicio }}</td>
                            <td>{{ $lote->area }}</td>
                            <td>{{ $lote->capacidad }}</td>
                            <td>{{ $lote->tipo_cacao }}</td>
                            <td>{{ $lote->estado }}</td>
                            <td>{{ $lote->estimacion_cosecha }}</td>
                            <td>{{ $lote->fecha_programada_cosecha }}</td>
                            <td>{{ $lote->observaciones }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay lotes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal para crear un nuevo lote --}}
<div class="modal fade" id="crearLoteModal" tabindex="-1" aria-labelledby="crearLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 2px solid #6f4e37;">
            <form action="{{ route('lotes.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: #6f4e37;">
                    <h5 class="modal-title" id="crearLoteModalLabel">Crear Nuevo Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Campos del formulario --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="area" class="form-label">Área (m²)</label>
                        <input type="number" class="form-control" id="area" name="area" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad (kg)</label>
                        <input type="number" class="form-control" id="capacidad" name="capacidad" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_cacao" class="form-label">Tipo de Cacao</label>
                        <input type="text" class="form-control" id="tipo_cacao" name="tipo_cacao" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="estimacion_cosecha" class="form-label">Estimación Cosecha (kg)</label>
                        <input type="number" class="form-control" id="estimacion_cosecha" name="estimacion_cosecha">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_programada_cosecha" class="form-label">Fecha Programada Cosecha</label>
                        <input type="date" class="form-control" id="fecha_programada_cosecha" name="fecha_programada_cosecha">
                    </div>
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Estilo para el hover en los enlaces y botones --}}
<style>
    .btn-crear-lote {
        background-color: #6f4e37; /* Café */
        color: white;
    }

    .btn-crear-lote:hover {
        background-color: #a67c52; /* Café más claro */
        color: white;
    }

    .nav-link:hover {
        background-color: #a67c52; /* Café más claro */
        color: white; /* Texto blanco */
    }
</style>
@endsection