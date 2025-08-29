@extends('layouts.masterr')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/trabajador/asistencia-unificada.css') }}">
@endpush

@section('content')
<div class="container-fluid main-container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm header-card">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <a href="{{ route('trabajadores.index') }}" class="btn btn-sm d-flex align-items-center btn-nav-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            <span>Volver a Trabajadores</span>
                        </a>
                    </div>

                    <div class="text-center">
                        <h1 class="mb-2 text-white">
                            <i class="fas fa-users-cog me-3"></i>
                            Gestión Integral de Asistencia
                        </h1>
                        <p class="mb-0 text-white-50">
                            Control y seguimiento completo de asistencias
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <nav>
                        <div class="nav nav-tabs nav-tabs-cafe" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-registro-tab" data-bs-toggle="tab" data-bs-target="#nav-registro" type="button" role="tab">
                                <i class="fas fa-plus-circle me-2"></i> Registrar Asistencia
                            </button>
                            <button class="nav-link" id="nav-listado-tab" data-bs-toggle="tab" data-bs-target="#nav-listado" type="button" role="tab">
                                <i class="fas fa-list me-2"></i> Historial de Asistencias
                            </button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de las pestañas -->
    <div class="tab-content" id="nav-tabContent">
        <!-- Pestaña: Registrar Asistencia -->
        <div class="tab-pane fade show active" id="nav-registro" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-gradient-cafe text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-clipboard-check me-2"></i> Registro de Asistencia del Día
                            </h5>
                            <small class="text-white-50">{{ now()->format('l, j \\de F \\de Y') }}</small>
                        </div>
                        <div class="card-body">
                            <form id="formAsistencia" action="{{ route('trabajadores.registrar-asistencia') }}" method="POST">
                                @csrf
                                <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">

                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <i class="fas fa-calendar-day me-1"></i> Fecha
                                        </label>
                                        <input type="date" name="fecha_registro" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt me-1"></i> Lote
                                        </label>
                                        <select name="lote_id" class="form-select" required>
                                            <option value="">Seleccionar lote</option>
                                            @foreach($lotes as $lote)
                                                <option value="{{ $lote->id }}">{{ $lote->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <i class="fas fa-clock me-1"></i> Hora de Entrada
                                        </label>
                                        <input type="time" name="hora_entrada" class="form-control" value="{{ date('H:i') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <i class="fas fa-clock me-1"></i> Hora de Salida
                                        </label>
                                        <input type="time" name="hora_salida" class="form-control">
                                    </div>
                                </div>

                                <!-- Lista de trabajadores -->
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-3">
                                            <i class="fas fa-users me-2"></i> Seleccionar Trabajadores
                                        </h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="5%">
                                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                                        </th>
                                                        <th>Trabajador</th>
                                                        <th>Estado</th>
                                                        <th width="15%">Asistió</th>
                                                        <th width="20%">Observaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($trabajadores as $trabajador)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="trabajadores[]" value="{{ $trabajador->id }}"
                                                                   class="form-check-input trabajador-checkbox">
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm bg-gradient-cafe text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                    {{ substr($trabajador->user->name, 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <strong>{{ $trabajador->user->name }}</strong><br>
                                                                    <small class="text-muted">{{ $trabajador->user->email }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $trabajador->user->estado === 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                                                {{ ucfirst($trabajador->user->estado) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <select name="estado_asistencia[{{ $trabajador->id }}]" class="form-select form-select-sm">
                                                                <option value="presente">Presente</option>
                                                                <option value="tardanza">Tardanza</option>
                                                                <option value="ausente">Ausente</option>
                                                                <option value="permiso">Permiso</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea name="observaciones[{{ $trabajador->id }}]"
                                                                    class="form-control form-control-sm"
                                                                    rows="1" placeholder="Observaciones..."></textarea>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save me-2"></i> Registrar Asistencia
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pestaña: Listado de Asistencias -->
        <div class="tab-pane fade" id="nav-listado" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-gradient-cafe text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-history me-2"></i> Historial de Asistencias
                                </h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-light btn-sm" onclick="exportarExcel()">
                                        <i class="fas fa-file-excel me-1"></i> Excel
                                    </button>
                                    <button class="btn btn-outline-light btn-sm" onclick="exportarPDF()">
                                        <i class="fas fa-file-pdf me-1"></i> PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filtros -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label">Fecha Desde</label>
                                    <input type="date" class="form-control" id="fecha_desde" value="{{ date('Y-m-01') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Fecha Hasta</label>
                                    <input type="date" class="form-control" id="fecha_hasta" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Trabajador</label>
                                    <select class="form-select" id="filtro_trabajador">
                                        <option value="">Todos los trabajadores</option>
                                        @foreach($trabajadores as $trabajador)
                                            <option value="{{ $trabajador->id }}">{{ $trabajador->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary" onclick="filtrarAsistencias()">
                                        <i class="fas fa-search me-1"></i> Filtrar
                                    </button>
                                </div>
                            </div>

                            <!-- Tabla de asistencias -->
                            <div id="tablaAsistencias">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="asistenciasTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Trabajador</th>
                                                <th>Hora Entrada</th>
                                                <th>Hora Salida</th>
                                                <th>Estado</th>
                                                <th>Horas Trabajadas</th>
                                                <th>Observaciones</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($asistencias as $asistencia)
                                            <tr>
                                                <td>{{ $asistencia->fecha->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-gradient-cafe text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            {{ substr($asistencia->trabajador->user->name, 0, 1) }}
                                                        </div>
                                                        {{ $asistencia->trabajador->user->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : '-' }}</td>
                                                <td>{{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '-' }}</td>
                                                <td>
                                                    @php
                                                        $estado = 'presente';
                                                        if($asistencia->hora_entrada) {
                                                            $horaEntrada = \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i');
                                                            if($horaEntrada > '08:30') {
                                                                $estado = 'tardanza';
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="badge bg-{{
                                                        $estado == 'presente' ? 'success' : 'warning'
                                                    }}">
                                                        {{ ucfirst($estado) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $asistencia->horas_trabajadas ? number_format($asistencia->horas_trabajadas, 1) . 'h' : '-' }}
                                                </td>
                                                <td>{{ $asistencia->observaciones ?? '-' }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary" onclick="editarAsistencia({{ $asistencia->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger" onclick="eliminarAsistencia({{ $asistencia->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal para editar asistencia -->
<div class="modal fade" id="editarAsistenciaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditarAsistencia">
                <div class="modal-header bg-gradient-cafe text-white">
                    <h5 class="modal-title">Editar Asistencia</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_asistencia_id">
                    <div class="mb-3">
                        <label class="form-label">Hora de Entrada</label>
                        <input type="time" class="form-control" id="edit_hora_entrada">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hora de Salida</label>
                        <input type="time" class="form-control" id="edit_hora_salida">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="edit_estado">
                            <option value="presente">Presente</option>
                            <option value="tardanza">Tardanza</option>
                            <option value="ausente">Ausente</option>
                            <option value="permiso">Permiso</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" id="edit_observaciones" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/trabajador/asistencia-unificada.js') }}"></script>
@endsection
