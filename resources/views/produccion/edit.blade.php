{{-- resources/views/produccion/edit-clean.blade.php --}}
@extends('layouts.masterr')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/produccion/edit.css') }}">
@endpush

@section('content')

<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header limpio -->
        <div class="header-clean">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">Editar Producción</h1>
                    <p class="main-subtitle">Modifica los datos de la producción de cacao</p>
                    
                    <!-- Breadcrumb limpio -->
                    <nav aria-label="breadcrumb" class="breadcrumb-clean">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('produccion.index') }}">Producción</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('produccion.index') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            {{-- Mensajes de error --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Mostrar todos los errores de validación --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Formulario --}}
            <form action="{{ route('produccion.update', $produccion->id) }}" method="POST" id="produccionForm">
                @csrf
                @method('PUT')

                {{-- Información del Cultivo --}}
                <div class="card-clean mb-4">
                    <div class="card-header-clean">Información del Cultivo</div>
                    <div class="card-body-clean">
                        <div class="row">
                            {{-- Lote --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lote_id" class="form-label">Lote *</label>
                                    <select name="lote_id" id="lote_id" class="form-select @error('lote_id') is-invalid @enderror" required>
                                        <option value="">Seleccionar Lote</option>
                                        @foreach($lotes as $lote)
                                            <option value="{{ $lote->id }}" 
                                                    {{ old('lote_id', $produccion->lote_id) == $lote->id ? 'selected' : '' }}
                                                    data-area="{{ $lote->area }}"
                                                    data-capacidad="{{ $lote->capacidad }}"
                                                    data-estado="{{ $lote->estado }}"
                                                    data-tipo-cacao="{{ $lote->tipo_cacao }}">
                                                {{ $lote->nombre }} - {{ $lote->area }} m²
                                                @if($lote->estado !== 'Activo')
                                                    (Lote Inactivo)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="advertenciaLote" class="alert alert-warning mt-2 d-none"></div>
                                    @error('lote_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tipo de Cacao --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo_cacao" class="form-label">Tipo de Cacao *</label>
                                    <select name="tipo_cacao" id="tipo_cacao" class="form-select @error('tipo_cacao') is-invalid @enderror" required>
                                        <option value="">Seleccionar Tipo</option>
                                        <option value="CCN-51" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'CCN-51' ? 'selected' : '' }}>CCN-51</option>
                                        <option value="ICS-95" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'ICS-95' ? 'selected' : '' }}>ICS-95</option>
                                        <option value="TCS-13" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'TCS-13' ? 'selected' : '' }}>TCS-13</option>
                                        <option value="EET-96" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'EET-96' ? 'selected' : '' }}>EET-96</option>
                                        <option value="CC-137" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'CC-137' ? 'selected' : '' }}>CC-137</option>
                                    </select>
                                    @error('tipo_cacao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Trabajadores asignados --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trabajadores" class="form-label">Trabajadores Asignados *</label>
                                    <select name="trabajadores[]" id="trabajadores" class="form-select @error('trabajadores') is-invalid @enderror" multiple required>
                                        @foreach($trabajadores as $trabajador)
                                            <option value="{{ $trabajador->id }}" 
                                                    {{ in_array($trabajador->id, old('trabajadores', $produccion->trabajadores->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $trabajador->user->name }} {{ $trabajador->user->apellido ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('trabajadores')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Info lote dinámica --}}
                        <div id="infoLote" class="alert alert-info" style="display: none;">
                            <strong>Información del Lote:</strong>
                            <div id="loteDetails" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                {{-- Programación de Producción --}}
                <div class="card-clean mb-4">
                    <div class="card-header-clean">Programación de Producción</div>
                    <div class="card-body-clean">
                        <div class="row">
                            {{-- Fecha Inicio --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fecha_inicio" class="form-label">Fecha Inicio *</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                                           class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                           value="{{ old('fecha_inicio', $produccion->fecha_inicio ? $produccion->fecha_inicio->format('Y-m-d') : '') }}" required>
                                    @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Fecha Fin Esperada --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fecha_fin_esperada" class="form-label">Fecha Fin Esperada *</label>
                                    <input type="date" name="fecha_fin_esperada" id="fecha_fin_esperada" 
                                           class="form-control @error('fecha_fin_esperada') is-invalid @enderror" 
                                           value="{{ old('fecha_fin_esperada', $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('Y-m-d') : '') }}" required>
                                    @error('fecha_fin_esperada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Fecha Cosecha --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fecha_programada_cosecha" class="form-label">Fecha Programada Cosecha</label>
                                    <input type="date" name="fecha_programada_cosecha" id="fecha_programada_cosecha" 
                                           class="form-control @error('fecha_programada_cosecha') is-invalid @enderror" 
                                           value="{{ old('fecha_programada_cosecha', $produccion->fecha_programada_cosecha ? $produccion->fecha_programada_cosecha->format('Y-m-d') : '') }}">
                                    @error('fecha_programada_cosecha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Duración estimada --}}
                        <div class="alert alert-info" id="duracionInfo" style="display: none;">
                            <strong>Duración estimada:</strong> <span id="duracionTexto"></span>
                        </div>
                    </div>
                </div>

                {{-- Datos de Producción --}}
                <div class="card-clean mb-4">
                    <div class="card-header-clean">Datos de Producción</div>
                    <div class="card-body-clean">
                        <div class="row">
                            {{-- Área Asignada --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="area_asignada" class="form-label">Área Asignada (hectáreas) *</label>
                                    <input type="number" step="0.01" name="area_asignada" id="area_asignada" 
                                           class="form-control @error('area_asignada') is-invalid @enderror" 
                                           value="{{ old('area_asignada', $produccion->area_asignada) }}" required>
                                    @error('area_asignada')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Ingrese el área en hectáreas que se asignará para esta producción
                                    </small>
                                </div>
                            </div>

                            {{-- Rendimiento Esperado --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estimacion_produccion" class="form-label">Rendimiento Esperado (toneladas) *</label>
                                    <input type="number" step="0.01" name="estimacion_produccion" id="estimacion_produccion" 
                                           class="form-control @error('estimacion_produccion') is-invalid @enderror" 
                                           value="{{ old('estimacion_produccion', $produccion->estimacion_produccion) }}" required>
                                    @error('estimacion_produccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Rendimiento por hectárea: <span id="rendimientoHa" class="fw-bold text-primary">0</span> ton/ha
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Estado --}}
                <div class="card-clean mb-4">
                    <div class="card-header-clean">Estado de la Producción</div>
                    <div class="card-body-clean">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado *</label>
                                    <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                        <option value="planificado" {{ old('estado', $produccion->estado) == 'planificado' ? 'selected' : '' }}>Planificado</option>
                                        <option value="siembra" {{ old('estado', $produccion->estado) == 'siembra' ? 'selected' : '' }}>Siembra</option>
                                        <option value="crecimiento" {{ old('estado', $produccion->estado) == 'crecimiento' ? 'selected' : '' }}>Crecimiento</option>
                                        <option value="maduracion" {{ old('estado', $produccion->estado) == 'maduracion' ? 'selected' : '' }}>Maduración</option>
                                        <option value="cosecha" {{ old('estado', $produccion->estado) == 'cosecha' ? 'selected' : '' }}>Cosecha</option>
                                        <option value="secado" {{ old('estado', $produccion->estado) == 'secado' ? 'selected' : '' }}>Secado</option>
                                        <option value="completado" {{ old('estado', $produccion->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Información Adicional --}}
                <div class="card-clean mb-4">
                    <div class="card-header-clean">Información Adicional</div>
                    <div class="card-body-clean">
                        <div class="row">
                            {{-- Costo --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="costo_total" class="form-label">Costo Estimado (COP)</label>
                                    <input type="number" step="0.01" name="costo_total" id="costo_total" 
                                           class="form-control @error('costo_total') is-invalid @enderror" 
                                           value="{{ old('costo_total', $produccion->costo_total) }}">
                                    @error('costo_total')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tipo de Siembra --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo_siembra" class="form-label">Tipo de Siembra</label>
                                    <select name="tipo_siembra" id="tipo_siembra" class="form-select @error('tipo_siembra') is-invalid @enderror">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="directa" {{ old('tipo_siembra', $produccion->tipo_siembra) == 'directa' ? 'selected' : '' }}>Directa</option>
                                        <option value="transplante" {{ old('tipo_siembra', $produccion->tipo_siembra) == 'transplante' ? 'selected' : '' }}>Transplante</option>
                                        <option value="injerto" {{ old('tipo_siembra', $produccion->tipo_siembra) == 'injerto' ? 'selected' : '' }}>Injerto</option>
                                    </select>
                                    @error('tipo_siembra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" 
                                      class="form-control @error('observaciones') is-invalid @enderror" 
                                      rows="3" placeholder="Ingrese cualquier observación relevante...">{{ old('observaciones', $produccion->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                                
                {{-- Botones de acción --}}
                <div class="card-clean">
                    <div class="card-body-clean">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg me-3">Actualizar Producción</button>
                                <a href="{{ route('produccion.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/produccion/edit.js') }}" defer></script>
@endpush
@endsection
