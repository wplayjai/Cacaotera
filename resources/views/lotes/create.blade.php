{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\create.blade.php --}}
@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4 text-center" style="color: #6f4e37;">Gestión de Lotes</h1>

    {{-- Botón para abrir el modal --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-crear-lote" data-bs-toggle="modal" data-bs-target="#crearLoteModal">
            <i class="fas fa-plus"></i> Crear nuevo lote
        </button>
        <a href="{{ route('lotes.pdf') }}" class="btn btn-pdf" target="_blank">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
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
                        <th style="width: 15%;">Acciones</th>
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
                            <td>
                                {{-- Botón para editar --}}
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarLoteModal" 
                                    onclick="cargarDatosLote({{ $lote }})">
                                    <i class="fas fa-edit"></i> Editar
                                </button>

                                {{-- Botón para eliminar --}}
                                <form action="{{ route('lotes.destroy', $lote->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este lote?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No hay lotes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal para crear un nuevo lote --}}
<div class="modal fade" id="crearLoteModal" tabindex="-1" aria-labelledby="crearLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> {{-- Clase modal-lg para hacerlo más ancho --}}
        <div class="modal-content" style="border: 2px solid #6f4e37;">
            <form action="{{ route('lotes.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: #6f4e37;">
                    <h5 class="modal-title" id="crearLoteModalLabel">Crear Nuevo Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Campos del formulario --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control custom-input" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control custom-input" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Área (m²)</label>
                            <input type="number" class="form-control custom-input" id="area" name="area" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="capacidad" class="form-label">Capacidad (kg)</label>
                            <input type="number" class="form-control custom-input" id="capacidad" name="capacidad" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo_cacao" class="form-label">Tipo de Cacao</label>
                            <input type="text" class="form-control custom-input" id="tipo_cacao" name="tipo_cacao" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select custom-input" id="estado" name="estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="estimacion_cosecha" class="form-label">Estimación Cosecha (kg)</label>
                            <input type="number" class="form-control custom-input" id="estimacion_cosecha" name="estimacion_cosecha">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_programada_cosecha" class="form-label">Fecha Programada Cosecha</label>
                            <input type="date" class="form-control custom-input" id="fecha_programada_cosecha" name="fecha_programada_cosecha">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control custom-input" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para editar un lote --}}
<div class="modal fade" id="editarLoteModal" tabindex="-1" aria-labelledby="editarLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> {{-- Clase modal-lg para hacerlo más ancho --}}
        <div class="modal-content" style="border: 2px solid #6f4e37;">
            <form id="editarLoteForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header text-white" style="background-color: #6f4e37;">
                    <h5 class="modal-title" id="editarLoteModalLabel">Editar Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Campos del formulario --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control custom-input" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control custom-input" id="edit_fecha_inicio" name="fecha_inicio" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_area" class="form-label">Área (m²)</label>
                            <input type="number" class="form-control custom-input" id="edit_area" name="area" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_capacidad" class="form-label">Capacidad (kg)</label>
                            <input type="number" class="form-control custom-input" id="edit_capacidad" name="capacidad" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tipo_cacao" class="form-label">Tipo de Cacao</label>
                            <input type="text" class="form-control custom-input" id="edit_tipo_cacao" name="tipo_cacao" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_estado" class="form-label">Estado</label>
                            <select class="form-select custom-input" id="edit_estado" name="estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_estimacion_cosecha" class="form-label">Estimación Cosecha (kg)</label>
                            <input type="number" class="form-control custom-input" id="edit_estimacion_cosecha" name="estimacion_cosecha">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_fecha_programada_cosecha" class="form-label">Fecha Programada Cosecha</label>
                            <input type="date" class="form-control custom-input" id="edit_fecha_programada_cosecha" name="fecha_programada_cosecha">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control custom-input" id="edit_observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-guardar">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script para cargar datos en el modal de edición --}}
<script>
    function cargarDatosLote(lote) {
        document.getElementById('editarLoteForm').action = `/lotes/${lote.id}`;
        document.getElementById('edit_nombre').value = lote.nombre;
        document.getElementById('edit_fecha_inicio').value = lote.fecha_inicio;
        document.getElementById('edit_area').value = lote.area;
        document.getElementById('edit_capacidad').value = lote.capacidad;
        document.getElementById('edit_tipo_cacao').value = lote.tipo_cacao;
        document.getElementById('edit_estado').value = lote.estado;
        document.getElementById('edit_estimacion_cosecha').value = lote.estimacion_cosecha;
        document.getElementById('edit_fecha_programada_cosecha').value = lote.fecha_programada_cosecha;
        document.getElementById('edit_observaciones').value = lote.observaciones;
    }
</script>

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

    /* Estilo para los campos del formulario */
    .custom-input {
        border: 2px solid #6f4e37; /* Borde café */
        background-color: #f8f3ee; /* Fondo claro */
        color: #6f4e37; /* Texto café */
    }

    .custom-input:focus {
        border-color: #a67c52; /* Borde café más claro al enfocar */
        box-shadow: 0 0 5px #a67c52;
        outline: none;
    }

    /* Estilo para el botón Guardar */
    .btn-guardar {
        background-color: #6f4e37; /* Café oscuro */
        color: white;
        border: none;
    }

    .btn-guardar:hover {
        background-color: #a67c52; /* Café claro */
        color: white;
    }

    .btn-guardar:focus {
        background-color: #a67c52; /* Café claro */
        outline: none;
        box-shadow: 0 0 5px #a67c52;
    }

    /* Estilos personalizados para el botón PDF */
    .btn-pdf {
        background-color: #6f4e37; /* Café oscuro */
        color: white;
        border: none;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 5px;
    }

    .btn-pdf:hover {
        background-color: #a67c52; /* Café claro */
        color: white;
    }
</style>
@endsection