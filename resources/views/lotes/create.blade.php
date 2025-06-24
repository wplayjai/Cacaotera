{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\create.blade.php --}}
@extends('layouts.masterr')

@section('content')
<head>
     <link rel="stylesheet" href="{{ asset('css/lotes/create.css') }}">
     </head>
     <script src="{{ asset('js/lotes/create.js') }}" defer></script>
<div class="container-fluid">
    {{-- Título de la página --}}
    <h1 class="mb-4 text-start" style="color: #6f4e37; font-family: 'Arial', sans-serif;">Gestión de Lotes</h1>

    {{-- Botones de Crear Lote y Descargar PDF --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-crear-lote" data-bs-toggle="modal" data-bs-target="#crearLoteModal">
            <i class="fas fa-plus"></i> Crear Lote
        </button>
        <a href="{{ route('lotes.pdf') }}" class="btn btn-pdf">
            <i class="fas fa-file-pdf fa-lg me-2"></i> Descargar PDF
        </a>
    </div>
    
    {{-- Cuadro de listado de lotes --}}
    <div class="card shadow-lg" style="border: 2px solid #6f4e37; border-radius: 10px;">
        <div class="card-header d-flex align-items-center text-white" style="background-color: #6f4e37; font-size: 18px; font-weight: bold;">
            <span>Lotes Registrados</span>
            {{-- Botón de búsqueda alineado completamente al borde derecho --}}
           <div class="input-group" style="position: absolute; top: 10px; right: 10px; width: 300px; z-index: 999;">
    <input type="text" id="buscarVariedad" class="form-control" placeholder="Buscar..." style="border: 2px solid #6f4e37;">
    <button class="btn btn-buscar" type="button">
        <i class="fas fa-search"></i>
    </button>
</div>

        </div>
        <div class="card-body" style="max-height: 4000px; overflow-y: auto;"> {{-- Altura ajustada para mostrar más filas --}}
            <table class="table table-striped table-hover table-bordered" id="tablaLotes" style="width: 100%; table-layout: fixed; border-radius: 10px;">
                <thead style="background-color: #6f4e37; color: white; font-size: 14px; font-family: 'Arial', sans-serif;">
                    <tr>
                        <th style="width: 12%;">Nombre</th>
                        <th style="width: 8%;">Fecha Inicio</th>
                        <th style="width: 8%;">Área (m²)</th>
                        <th style="width: 8%;">Capacidad (kg)</th>
                        <th style="width: 8%;">Tipo de Cacao</th>
                        <th style="width: 8%;">Estado</th>
                        <th style="width: 8%;">Estimación Cosecha</th>
                        <th style="width: 8%;">Fecha Cosecha</th>
                        <th style="width: 15%;">Observaciones</th>
                        <th style="width: 15%;">Acciones</th>
                    </tr>
                </thead>
                <tbody style="font-size: 13px; font-family: 'Arial', sans-serif;">
                    @forelse ($lotes as $lote)
                        <tr>
                            <td>{{ $lote->nombre }}</td>
                            <td>{{ $lote->fecha_inicio }}</td>
                            <td>{{ $lote->area }}</td>
                            <td>{{ $lote->capacidad }}</td>
                            <td class="variedad-cacao">{{ $lote->tipo_cacao }}</td>
                            <td class="estado" data-estado="{{ $lote->estado }}">{{ $lote->estado }}</td>
                            <td>{{ $lote->estimacion_cosecha }}</td>
                            <td>{{ $lote->fecha_programada_cosecha }}</td>
                            <td>{{ $lote->observaciones }}</td>
                            <td>
                                {{-- Botones de Editar y Eliminar organizados --}}
                                <div class="d-flex justify-content-between">
                                    {{-- Botón para editar --}}
                                    <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editarLoteModal" 
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
                                </div>
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

    {{-- Script para cambiar el color del estado y buscar por variedad de cacao --}}
    
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
                            <select class="form-select custom-input estado-select" id="estado" name="estado" required>
                                <option value="Activo" style="color: green;">Activo</option>
                                <option value="Inactivo" style="color: red;">Inactivo</option>
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
                @method('PUT') {{-- Método PUT para actualizar --}}
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
                            <select class="form-select custom-input estado-select" id="edit_estado" name="estado" required>
                                <option value="Activo" style="color: green;">Activo</option>
                                <option value="Inactivo" style="color: red;">Inactivo</option>
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


{{-- Estilos personalizados --}}

@endsection