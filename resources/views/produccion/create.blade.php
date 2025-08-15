
@extends('layouts.masterr')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/produccion/create.css') }}">
@endpush

@section('content')



<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">
                        <i class="fas fa-plus-circle"></i>Registrar Nueva Producción
                    </h1>
                    <p class="main-subtitle">
                        Crea una nueva producción de cacao con todos los detalles necesarios
                    </p>

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="breadcrumb-professional">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="#" onclick="irAInicio(); return false;">
                                    <i class="fas fa-home me-1"></i>Inicio
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#" onclick="volverProduccion(); return false;">
                                    <i class="fas fa-seedling me-1"></i>Producción
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-plus me-1"></i>Crear
                            </li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>

                <div class="card-body">
                    {{-- Mensajes de error --}}
                    @if(session('error'))
                        <div class="alert alert-danger-professional alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Mostrar todos los errores de validación --}}
                    @if($errors->any())
                        <div class="alert alert-danger-professional alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
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
                    <form action="{{ route('produccion.store') }}" method="POST" id="produccionForm">
                        @csrf

                        {{-- Información del Cultivo --}}
                        <div class="card-professional mb-4 fade-in-up">
                            <div class="card-header-professional">
                                <i class="fas fa-seedling"></i>Información del Cultivo
                            </div>
                            <div class="card-body-professional">
                                <div class="row">
                                    {{-- Lote --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lote_id" class="form-label-professional">
                                                <i class="fas fa-map-marker-alt"></i>Lote *
                                            </label>
                                            <select name="lote_id" id="lote_id" class="form-select form-select-professional @error('lote_id') is-invalid @enderror" required>
                                                <option value="">Seleccionar Lote</option>
                                                @foreach($lotes as $lote)
                                                    <option value="{{ $lote->id }}"
                                                            {{ old('lote_id') == $lote->id ? 'selected' : '' }}
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
                                            <div id="advertenciaLote" class="alert alert-warning-professional mt-2 d-none"></div>
                                            @error('lote_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tipo de Cacao --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tipo_cacao" class="form-label-professional">
                                                <i class="fas fa-leaf"></i>Tipo de Cacao *
                                            </label>
                                            <select name="tipo_cacao" id="tipo_cacao" class="form-select form-select-professional @error('tipo_cacao') is-invalid @enderror" required>
                                                <option value="">Seleccionar Tipo</option>
                                                <option value="CCN-51" {{ old('tipo_cacao') == 'CCN-51' ? 'selected' : '' }}>🌱 CCN-51</option>
                                                <option value="ICS-95" {{ old('tipo_cacao') == 'ICS-95' ? 'selected' : '' }}>🌱 ICS-95</option>
                                                <option value="TCS-13" {{ old('tipo_cacao') == 'TCS-13' ? 'selected' : '' }}>🌱 TCS-13</option>
                                                <option value="EET-96" {{ old('tipo_cacao') == 'EET-96' ? 'selected' : '' }}>🌱 EET-96</option>
                                                <option value="CC-137" {{ old('tipo_cacao') == 'CC-137' ? 'selected' : '' }}>🌱 CC-137</option>
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
                                            <label for="trabajadores" class="form-label-professional">
                                                <i class="fas fa-users"></i>Trabajadores Asignados *
                                            </label>
                                            <select name="trabajadores[]" id="trabajadores" class="form-select form-select-professional @error('trabajadores') is-invalid @enderror" multiple required>
                                                @foreach($trabajadores as $trabajador)
                                                    <option value="{{ $trabajador->id }}"
                                                            {{ in_array($trabajador->id, old('trabajadores', [])) ? 'selected' : '' }}>
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
                                <div id="infoLote" class="alert alert-info-professional" style="display: none;">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Información del Lote:</strong>
                                    <div id="loteDetails" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Programación de Producción --}}
                        <div class="card-professional mb-4 fade-in-up">
                            <div class="card-header-professional">
                                <i class="fas fa-calendar-alt"></i>Programación de Producción
                            </div>
                            <div class="card-body-professional">
                                <div class="row">
                                    {{-- Fecha Inicio --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="fecha_inicio" class="form-label-professional">
                                                <i class="fas fa-calendar-plus"></i>Fecha Inicio *
                                            </label>
                                            <input type="date" name="fecha_inicio" id="fecha_inicio"
                                                   class="form-control form-control-professional @error('fecha_inicio') is-invalid @enderror"
                                                   value="{{ old('fecha_inicio') }}" required>
                                            @error('fecha_inicio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Fecha Fin Esperada --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="fecha_fin_esperada" class="form-label-professional">
                                                <i class="fas fa-calendar-check"></i>Fecha Fin Esperada *
                                            </label>
                                            <input type="date" name="fecha_fin_esperada" id="fecha_fin_esperada"
                                                   class="form-control form-control-professional @error('fecha_fin_esperada') is-invalid @enderror"
                                                   value="{{ old('fecha_fin_esperada') }}" required>
                                            @error('fecha_fin_esperada')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Fecha Cosecha --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="fecha_programada_cosecha" class="form-label-professional">
                                                <i class="fas fa-calendar-week"></i>Fecha Programada Cosecha
                                            </label>
                                            <input type="date" name="fecha_programada_cosecha" id="fecha_programada_cosecha"
                                                   class="form-control form-control-professional @error('fecha_programada_cosecha') is-invalid @enderror"
                                                   value="{{ old('fecha_programada_cosecha') }}">
                                            @error('fecha_programada_cosecha')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Duración estimada --}}
                                <div class="alert alert-info-professional" id="duracionInfo" style="display: none;">
                                    <i class="fas fa-clock me-2"></i>
                                    <strong>Duración estimada:</strong> <span id="duracionTexto"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Datos de Producción --}}
                        <div class="card-professional mb-4 fade-in-up">
                            <div class="card-header-professional">
                                <i class="fas fa-chart-bar"></i>Datos de Producción
                            </div>
                            <div class="card-body-professional">
                                <div class="row">
                                    {{-- Área Asignada --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="area_asignada" class="form-label-professional">
                                                <i class="fas fa-ruler-combined"></i>Área (m²) *
                                            </label>
                                            <input type="number" step="1" name="area_asignada" id="area_asignada"
                                                   class="form-control form-control-professional @error('area_asignada') is-invalid @enderror"
                                                   value="{{ old('area_asignada') }}" required>
                                            @error('area_asignada')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Área máxima disponible: <span id="areaMaxima" class="fw-bold text-primary">0</span> m²
                                            </small>
                                        </div>
                                    </div>

                                    {{-- Rendimiento Esperado --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estimacion_produccion" class="form-label-professional">
                                                <i class="fas fa-weight-hanging"></i>Rendimiento Esperado (toneladas) *
                                            </label>
                                            <input type="number" step="0.01" name="estimacion_produccion" id="estimacion_produccion"
                                                   class="form-control form-control-professional @error('estimacion_produccion') is-invalid @enderror"
                                                   value="{{ old('estimacion_produccion') }}" required>
                                            @error('estimacion_produccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="fas fa-calculator me-1"></i>
                                                Rendimiento por hectárea: <span id="rendimientoHa" class="fw-bold text-success">0</span> ton/ha
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Estado --}}
                        <div class="card-professional mb-4 fade-in-up">
                            <div class="card-header-professional">
                                <i class="fas fa-tasks"></i>Estado de la Producción
                            </div>
                            <div class="card-body-professional">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estado" class="form-label-professional">
                                                <i class="fas fa-flag"></i>Estado *
                                            </label>
                                            <select name="estado" id="estado" class="form-select form-select-professional @error('estado') is-invalid @enderror" required>
                                                <option value="planificado" {{ old('estado', 'planificado') == 'planificado' ? 'selected' : '' }}>📋 Planificado</option>
                                                <option value="siembra" {{ old('estado') == 'siembra' ? 'selected' : '' }}>🌱 Siembra</option>
                                                <option value="crecimiento" {{ old('estado') == 'crecimiento' ? 'selected' : '' }}>🌿 Crecimiento</option>
                                                <option value="maduracion" {{ old('estado') == 'maduracion' ? 'selected' : '' }}>🌳 Maduración</option>
                                                <option value="cosecha" {{ old('estado') == 'cosecha' ? 'selected' : '' }}>🍫 Cosecha</option>
                                                <option value="secado" {{ old('estado') == 'secado' ? 'selected' : '' }}>☀️ Secado</option>
                                                <option value="completado" {{ old('estado') == 'completado' ? 'selected' : '' }}>✅ Completado</option>
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
                        <div class="card-professional mb-4 fade-in-up">
                            <div class="card-header-professional">
                                <i class="fas fa-info-circle"></i>Información Adicional
                            </div>
                            <div class="card-body-professional">
                                <div class="row">
                                    {{-- Costo --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="costo_total" class="form-label-professional">
                                                <i class="fas fa-dollar-sign"></i>Costo Estimado (COP)
                                            </label>
                                            <input type="number" step="0.01" name="costo_total" id="costo_total"
                                                   class="form-control form-control-professional @error('costo_total') is-invalid @enderror"
                                                   value="{{ old('costo_total') }}">
                                            @error('costo_total')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tipo de Siembra --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tipo_siembra" class="form-label-professional">
                                                <i class="fas fa-seedling"></i>Tipo de Siembra
                                            </label>
                                            <select name="tipo_siembra" id="tipo_siembra" class="form-select form-select-professional @error('tipo_siembra') is-invalid @enderror">
                                                <option value="">Seleccionar tipo</option>
                                                <option value="directa" {{ old('tipo_siembra') == 'directa' ? 'selected' : '' }}>🌱 Directa</option>
                                                <option value="transplante" {{ old('tipo_siembra') == 'transplante' ? 'selected' : '' }}>🌿 Transplante</option>
                                                <option value="injerto" {{ old('tipo_siembra') == 'injerto' ? 'selected' : '' }}>🌳 Injerto</option>
                                            </select>
                                            @error('tipo_siembra')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="observaciones" class="form-label-professional">
                                        <i class="fas fa-sticky-note"></i>Observaciones
                                    </label>
                                    <textarea name="observaciones" id="observaciones"
                                              class="form-control form-control-professional @error('observaciones') is-invalid @enderror"
                                              rows="3" placeholder="Ingrese cualquier observación relevante...">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="card-professional fade-in-up">
                            <div class="card-body-professional">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success-professional btn-lg me-3">
                                            <i class="fas fa-save me-2"></i>Registrar Producción
                                        </button>
                                        <button type="button" onclick="volverProduccion()" class="btn btn-secondary-professional btn-lg">
                                            <i class="fas fa-times me-2"></i>Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- La función volverProduccion se define en create.js -->

@push('scripts')
<script src="{{ asset('js/produccion/create.js') }}" defer></script>
@endpush
@endsection
