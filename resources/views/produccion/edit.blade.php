{{-- resources/views/produccion/edit.blade.php --}}
@extends('layouts.masterr')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root {
    --cacao-primary: #4a3728;
    --cacao-secondary: #6b4e3d;
    --cacao-accent: #8b6f47;
    --cacao-light: #d4c4b0;
    --cacao-bg: #f8f6f4;
    --cacao-white: #ffffff;
    --cacao-text: #2c1810;
    --cacao-muted: #8d6e63;
    --success: #2e7d32;
    --warning: #f57c00;
    --danger: #c62828;
    --info: #1976d2;
}

body {
    background: var(--cacao-bg);
    color: var(--cacao-text);
}

/* Container principal */
.main-container {
    background: var(--cacao-white);
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 1rem 0;
}

/* Header con gradiente */
.header-professional {
    background: linear-gradient(135deg, var(--cacao-primary) 0%, var(--cacao-secondary) 100%);
    color: var(--cacao-white);
    padding: 2rem;
    margin: -1.5rem -1.5rem 2rem -1.5rem;
    position: relative;
}

.header-professional::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.08)"/><circle cx="40" cy="70" r="1" fill="rgba(255,255,255,0.06)"/><circle cx="70" cy="15" r="1.2" fill="rgba(255,255,255,0.07)"/><circle cx="15" cy="85" r="0.8" fill="rgba(255,255,255,0.05)"/></svg>');
    opacity: 0.3;
}

/* Título principal */
.main-title {
    color: var(--cacao-white);
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    z-index: 1;
}

.main-subtitle {
    color: rgba(255, 255, 255, 0.85);
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 1;
}

/* Breadcrumb profesional */
.breadcrumb-professional {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    padding: 0.8rem 1.2rem;
    margin-top: 1.5rem;
    position: relative;
    z-index: 1;
    backdrop-filter: blur(10px);
}

.breadcrumb-professional .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.2s ease;
    font-weight: 500;
}

.breadcrumb-professional .breadcrumb-item a:hover {
    color: var(--cacao-white);
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
}

.breadcrumb-professional .breadcrumb-item.active {
    color: var(--cacao-white);
    font-weight: 600;
}

/* Cards profesionales */
.card-professional {
    background: var(--cacao-white);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(139, 111, 71, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.card-professional:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.card-header-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    padding: 1.2rem 1.5rem;
    border: none;
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.card-body-professional {
    padding: 1.8rem;
}

/* Botones profesionales */
.btn-professional {
    border: none;
    border-radius: 8px;
    padding: 0.7rem 1.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.2rem;
    position: relative;
    overflow: hidden;
}

.btn-professional::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-professional:hover::before {
    left: 100%;
}

.btn-primary-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    box-shadow: 0 4px 12px rgba(74, 55, 40, 0.3);
}

.btn-primary-professional:hover {
    background: linear-gradient(135deg, var(--cacao-secondary), var(--cacao-primary));
    color: var(--cacao-white);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 55, 40, 0.4);
}

.btn-secondary-professional {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: var(--cacao-white);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
}

.btn-secondary-professional:hover {
    background: linear-gradient(135deg, #495057, #6c757d);
    color: var(--cacao-white);
    transform: translateY(-2px);
}

.btn-success-professional {
    background: linear-gradient(135deg, var(--success), #1b5e20);
    color: var(--cacao-white);
    box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
}

.btn-success-professional:hover {
    background: linear-gradient(135deg, #1b5e20, var(--success));
    color: var(--cacao-white);
    transform: translateY(-2px);
}

/* Formularios profesionales */
.form-control-professional {
    border: 2px solid rgba(139, 111, 71, 0.2);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: var(--cacao-white);
}

.form-control-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.2rem rgba(139, 111, 71, 0.15);
    outline: none;
}

.form-select-professional {
    border: 2px solid rgba(139, 111, 71, 0.2);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: var(--cacao-white);
}

.form-select-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.2rem rgba(139, 111, 71, 0.15);
    outline: none;
}

.form-label-professional {
    color: var(--cacao-text);
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Alertas profesionales */
.alert-professional {
    border-radius: 10px;
    border: none;
    padding: 1rem 1.2rem;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.alert-success-professional {
    background: linear-gradient(135deg, rgba(46, 125, 50, 0.1), rgba(27, 94, 32, 0.05));
    color: var(--success);
    border-left: 4px solid var(--success);
}

.alert-warning-professional {
    background: linear-gradient(135deg, rgba(245, 124, 0, 0.1), rgba(230, 81, 0, 0.05));
    color: var(--warning);
    border-left: 4px solid var(--warning);
}

.alert-danger-professional {
    background: linear-gradient(135deg, rgba(198, 40, 40, 0.1), rgba(183, 28, 28, 0.05));
    color: var(--danger);
    border-left: 4px solid var(--danger);
}

.alert-info-professional {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.1), rgba(13, 71, 161, 0.05));
    color: var(--info);
    border-left: 4px solid var(--info);
}

/* Responsivo */
@media (max-width: 768px) {
    .main-container {
        margin: 0.5rem;
        border-radius: 8px;
    }
    
    .header-professional {
        padding: 1.5rem;
        margin: -1rem -1rem 1.5rem -1rem;
    }
    
    .main-title {
        font-size: 1.6rem;
        text-align: center;
    }
    
    .btn-professional {
        width: 100%;
        justify-content: center;
        margin-bottom: 0.5rem;
    }
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.fade-in-up:nth-child(2) { animation-delay: 0.1s; }
.fade-in-up:nth-child(3) { animation-delay: 0.2s; }
.fade-in-up:nth-child(4) { animation-delay: 0.3s; }
</style>

<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">
                        <i class="fas fa-edit"></i>Editar Producción
                    </h1>
                    <p class="main-subtitle">
                        Modifica los datos de la producción de cacao
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
                                <i class="fas fa-edit me-1"></i>Editar
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div class="d-flex gap-2 flex-wrap">
                        <button onclick="volverProduccion()" class="btn btn-secondary-professional">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </button>
                    </div>
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
                    <form action="{{ route('produccion.update', $produccion->id) }}" method="POST" id="produccionForm">
                        @csrf
                        @method('PUT')

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
                                                <option value="CCN-51" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'CCN-51' ? 'selected' : '' }}>🌱 CCN-51</option>
                                                <option value="ICS-95" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'ICS-95' ? 'selected' : '' }}>🌱 ICS-95</option>
                                                <option value="TCS-13" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'TCS-13' ? 'selected' : '' }}>🌱 TCS-13</option>
                                                <option value="EET-96" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'EET-96' ? 'selected' : '' }}>🌱 EET-96</option>
                                                <option value="CC-137" {{ old('tipo_cacao', $produccion->tipo_cacao) == 'CC-137' ? 'selected' : '' }}>🌱 CC-137</option>
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
                                                   value="{{ old('fecha_inicio', $produccion->fecha_inicio ? $produccion->fecha_inicio->format('Y-m-d') : '') }}" required>
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
                                                   value="{{ old('fecha_fin_esperada', $produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('Y-m-d') : '') }}" required>
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
                                                   value="{{ old('fecha_programada_cosecha', $produccion->fecha_programada_cosecha ? $produccion->fecha_programada_cosecha->format('Y-m-d') : '') }}">
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
                                                <i class="fas fa-ruler-combined"></i>Área Asignada (hectáreas) *
                                            </label>
                                            <input type="number" step="0.01" name="area_asignada" id="area_asignada" 
                                                   class="form-control form-control-professional @error('area_asignada') is-invalid @enderror" 
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
                                            <label for="estimacion_produccion" class="form-label-professional">
                                                <i class="fas fa-weight-hanging"></i>Rendimiento Esperado (toneladas) *
                                            </label>
                                            <input type="number" step="0.01" name="estimacion_produccion" id="estimacion_produccion" 
                                                   class="form-control form-control-professional @error('estimacion_produccion') is-invalid @enderror" 
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
                                                <option value="planificado" {{ old('estado', $produccion->estado) == 'planificado' ? 'selected' : '' }}>📋 Planificado</option>
                                                <option value="siembra" {{ old('estado', $produccion->estado) == 'siembra' ? 'selected' : '' }}>🌱 Siembra</option>
                                                <option value="crecimiento" {{ old('estado', $produccion->estado) == 'crecimiento' ? 'selected' : '' }}>🌿 Crecimiento</option>
                                                <option value="maduracion" {{ old('estado', $produccion->estado) == 'maduracion' ? 'selected' : '' }}>🌳 Maduración</option>
                                                <option value="cosecha" {{ old('estado', $produccion->estado) == 'cosecha' ? 'selected' : '' }}>🍫 Cosecha</option>
                                                <option value="secado" {{ old('estado', $produccion->estado) == 'secado' ? 'selected' : '' }}>☀️ Secado</option>
                                                <option value="completado" {{ old('estado', $produccion->estado) == 'completado' ? 'selected' : '' }}>✅ Completado</option>
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
                                                   value="{{ old('costo_total', $produccion->costo_total) }}">
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
                                                <option value="directa" {{ old('tipo_siembra', $produccion->tipo_siembra) == 'directa' ? 'selected' : '' }}>🌱 Directa</option>
                                                <option value="transplante" {{ old('tipo_siembra', $produccion->tipo_siembra) == 'transplante' ? 'selected' : '' }}>🌿 Transplante</option>
                                                <option value="injerto" {{ old('tipo_siembra', $produccion->tipo_siembra) == 'injerto' ? 'selected' : '' }}>🌳 Injerto</option>
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
                                              rows="3" placeholder="Ingrese cualquier observación relevante...">{{ old('observaciones', $produccion->observaciones) }}</textarea>
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
                                            <i class="fas fa-save me-2"></i>Actualizar Producción
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

@push('scripts')
<script>
$(document).ready(function() {
    // Calcular rendimiento inicial
    calcularRendimiento();
    
    // Actualizar información del lote cuando se selecciona
    $('#lote_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        const area = selectedOption.data('area');
        const capacidad = selectedOption.data('capacidad');
        const estado = selectedOption.data('estado');
        const tipoCacao = selectedOption.data('tipo-cacao');
        
        // Establecer automáticamente el tipo de cacao del lote seleccionado
        if (tipoCacao && $(this).val() !== '') {
            $('#tipo_cacao').val(tipoCacao);
        }
        
        // Mostrar advertencia si el lote está inactivo
        if (estado !== 'Activo') {
            $('#advertenciaLote').removeClass('d-none').text('Advertencia: El lote seleccionado está inactivo. Considere seleccionar un lote activo.');
        } else {
            $('#advertenciaLote').addClass('d-none').text('');
        }
        
        if (area && $(this).val() !== '') {
            $('#infoLote').show();
            $('#loteDetails').html(`
                <strong>Área:</strong> ${area} m² (${(area / 10000).toFixed(2)} ha)<br>
                <strong>Capacidad:</strong> ${capacidad} árboles<br>
                <strong>Estado:</strong> ${estado}<br>
                <strong>Tipo de Cacao:</strong> ${tipoCacao || 'No especificado'}
            `);
        } else {
            $('#infoLote').hide();
        }
    });

    // Calcular duración entre fechas
    $('#fecha_inicio, #fecha_fin_esperada').change(function() {
        const fechaInicio = $('#fecha_inicio').val();
        const fechaFin = $('#fecha_fin_esperada').val();
        
        if (fechaInicio && fechaFin) {
            const inicio = new Date(fechaInicio);
            const fin = new Date(fechaFin);
            const diferencia = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));
            
            if (diferencia > 0) {
                $('#duracionInfo').show();
                $('#duracionTexto').text(`${diferencia} días (${Math.round(diferencia / 30)} meses aproximadamente)`);
            } else {
                $('#duracionInfo').hide();
            }
        } else {
            $('#duracionInfo').hide();
        }
    });

    // Calcular rendimiento por hectárea
    $('#area_asignada, #estimacion_produccion').on('input', function() {
        calcularRendimiento();
    });
    
    function calcularRendimiento() {
        const area = parseFloat($('#area_asignada').val()) || 0;
        const rendimiento = parseFloat($('#estimacion_produccion').val()) || 0;
        
        if (area > 0 && rendimiento > 0) {
            const rendimientoHa = (rendimiento / area).toFixed(2);
            $('#rendimientoHa').text(rendimientoHa);
        } else {
            $('#rendimientoHa').text('0');
        }
    }

    // Validación de fechas
    $('#fecha_fin_esperada').change(function() {
        const fechaInicio = new Date($('#fecha_inicio').val());
        const fechaFin = new Date($(this).val());
        
        if (fechaInicio && fechaFin && fechaFin <= fechaInicio) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">La fecha fin debe ser posterior a la fecha inicio</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // Validación del formulario antes de enviar
    $('#produccionForm').submit(function(e) {
        e.preventDefault();
        let isValid = true;
        let missingFields = [];
        let advertencias = [];
        const selectedOption = $('#lote_id').find('option:selected');
        const estado = selectedOption.data('estado');
        
        if (!$('#lote_id').val()) {
            isValid = false;
            missingFields.push('Lote');
        }
        if (!$('#tipo_cacao').val()) {
            isValid = false;
            missingFields.push('Tipo de Cacao');
        }
        if (!$('#trabajadores').val()) {
            isValid = false;
            missingFields.push('Trabajadores');
        }
        if (!$('#fecha_inicio').val()) {
            isValid = false;
            missingFields.push('Fecha de Inicio');
        }
        if (!$('#fecha_fin_esperada').val()) {
            isValid = false;
            missingFields.push('Fecha Fin Esperada');
        }
        if (!$('#area_asignada').val()) {
            isValid = false;
            missingFields.push('Área Asignada');
        }
        if (!$('#estimacion_produccion').val()) {
            isValid = false;
            missingFields.push('Rendimiento Esperado');
        }
        
        // Verificar si el lote está inactivo
        if (estado !== 'Activo') {
            advertencias.push('El lote seleccionado está inactivo.');
        }
        
        if (!isValid) {
            Swal.fire({
                title: 'Campos Requeridos',
                text: 'Por favor completa los siguientes campos: ' + missingFields.join(', '),
                icon: 'warning',
                confirmButtonText: 'Entendido',
                customClass: {
                    popup: 'swal-cafe'
                }
            });
            return;
        }
        
        if (advertencias.length > 0) {
            Swal.fire({
                title: 'Advertencia',
                text: advertencias.join('\n'),
                icon: 'warning',
                confirmButtonText: 'Entendido',
                customClass: {
                    popup: 'swal-cafe'
                }
            });
            return;
        }
        
        Swal.fire({
            title: '¿Actualizar Producción?',
            text: 'Se guardarán los cambios realizados',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'var(--cacao-primary)',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'swal-cafe'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // Inicializar información del lote seleccionado al cargar la página
    $('#lote_id').trigger('change');
    
    // Calcular duración inicial
    $('#fecha_inicio').trigger('change');
});

// Funciones de navegación
function volverProduccion() {
    try {
        window.location.href = "{{ route('produccion.index') }}";
    } catch (error) {
        // Fallback en caso de error
        window.location.href = "/produccion";
    }
}

function irAInicio() {
    try {
        window.location.href = "{{ route('home') }}";
    } catch (error) {
        // Fallback en caso de error
        window.location.href = "/home";
    }
}

// Estilos SweetAlert2 personalizados para café
const style = document.createElement('style');
style.textContent = `
    .swal-cafe {
        background: var(--cacao-white);
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .swal-cafe .swal2-title {
        color: var(--cacao-text);
        font-weight: 700;
    }
    
    .swal-cafe .swal2-content {
        color: var(--cacao-muted);
    }
    
    .swal-cafe .swal2-confirm {
        background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary)) !important;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(74, 55, 40, 0.3);
    }
    
    .swal-cafe .swal2-cancel {
        background: linear-gradient(135deg, #6c757d, #495057) !important;
        border: none;
        border-radius: 8px;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
