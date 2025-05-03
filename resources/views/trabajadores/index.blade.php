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
                            <th>Identificación</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Tipo Contrato</th>
                            <th>Forma Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trabajadores as $trabajador)
                            <tr>
                                <td>{{ $trabajador->id }}</td>
                                <td>{{ $trabajador->user->name }}</td>
                                <td>{{ $trabajador->user->identificacion }}</td>
                                <td>{{ $trabajador->user->email }}</td>
                                <td>{{ $trabajador->telefono }}</td>
                                <td>{{ $trabajador->tipo_contrato }}</td>
                                <td>{{ $trabajador->forma_pago }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Acciones">
                                        <a href="{{ route('trabajadores.show', $trabajador->id) }}" class="btn btn-sm btn-info">Ver</a>
                                        <a href="{{ route('trabajadores.edit', $trabajador->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('trabajadores.destroy', $trabajador->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro que desea eliminar este trabajador?')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay trabajadores registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection