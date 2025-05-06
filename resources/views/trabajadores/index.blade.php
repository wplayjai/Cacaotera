@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Trabajadores</h2>
        <div>
            <a href="{{ route('trabajadores.create') }}" class="btn btn-success">Registrar Trabajador</a>
            <a href="{{ route('trabajadores.asistencia') }}" class="btn btn-primary ms-2">Control de Asistencia</a>
            <a href="{{ route('trabajadores.reportes') }}" class="btn btn-info ms-2">Reportes</a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card">
        <div class="card-header">
            Listado de Trabajadores
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                           
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Tipo Contrato</th>
                            <th>Forma Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trabajadores as $trabajador)
                            <tr data-id="{{ $trabajador->id }}">
                                <td>{{ $trabajador->id }}</td>
                                <td class="nombre-trabajador">{{ $trabajador->user->name }}</td>
                                <td class="direccion-trabajador">{{ $trabajador->direccion }}</td>
                               
                                <td class="email-trabajador">{{ $trabajador->user->email }}</td>
                                <td class="telefono-trabajador">{{ $trabajador->telefono }}</td>
                                <td class="contrato-trabajador">{{ $trabajador->tipo_contrato }}</td>
                                <td class="pago-trabajador">{{ $trabajador->forma_pago }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        <a href="{{ route('trabajadores.show', $trabajador->id) }}" class="btn btn-sm btn-info">Ver</a>
                                        <button type="button" class="btn btn-sm btn-warning btn-editar" 
                                            data-id="{{ $trabajador->id }}">Editar</button>
                                        <button type="button" class="btn btn-sm btn-danger btn-eliminar" 
                                            data-id="{{ $trabajador->id }}" 
                                            data-nombre="{{ $trabajador->user->name }}">Eliminar</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No hay trabajadores registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Trabajador -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Trabajador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none"></div>
                <form id="formEditarTrabajador">
                    <input type="hidden" id="trabajador_id" name="trabajador_id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                       
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
                            <select class="form-select" id="tipo_contrato" name="tipo_contrato" required>
                                <option value="Indefinido">Indefinido</option>
                                <option value="Temporal">Temporal</option>
                                <option value="Obra o labor">Obra o labor</option>
                                <option value="Prestación de servicios">Prestación de servicios</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="forma_pago" class="form-label">Forma de Pago</label>
                            <select class="form-select" id="forma_pago" name="forma_pago" required>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/trabajadores.js') }}"></script>
@endsection