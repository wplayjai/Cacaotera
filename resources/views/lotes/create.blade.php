{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\create.blade.php --}}
@extends('layouts.masterr')

@section('content')
<style>
/* Colores principales del tema café */
:root {
    --coffee-dark: #6d4e36;
    --coffee-medium: #8b5a3c;
    --coffee-light: #a0674b;
    --coffee-accent: #b8785a;
    --coffee-cream: #d7ccc8;
    --coffee-beige: #efebe9;
    --coffee-gold: #d4af37;
    --coffee-gradient: linear-gradient(135deg, var(--coffee-dark) 0%, var(--coffee-medium) 50%, var(--coffee-light) 100%);
}

/* Estilos generales mejorados */
body {
    background: linear-gradient(135deg, #f8f5f0 0%, #ede7e0 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.container-fluid {
    padding: 2rem;
    max-width: 1800px;
    margin: 0 auto;
}

/* Título principal elegante */
.main-title {
    background: linear-gradient(135deg, var(--coffee-dark) 0%, var(--coffee-medium) 50%, var(--coffee-light) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 2rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    position: relative;
}

.main-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 150px;
    height: 3px;
    background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium));
    border-radius: 2px;
}

/* Botones mejorados con efectos */
.btn-modern {
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn-crear {
    background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium));
    color: white;
    text-decoration: none;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.btn-crear:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(109, 78, 54, 0.4);
}

.btn-crear::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-crear:hover::before {
    left: 100%;
}

.btn-reporte {
    background: linear-gradient(135deg, var(--coffee-gold), #b8860b);
    color: white;
    text-decoration: none;
}

.btn-reporte:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
}

/* Card principal con diseño premium */
.main-card {
    background: rgba(255, 255, 255, 0.95);
    border: none;
    border-radius: 20px;
    box-shadow: 
        0 20px 40px rgba(0,0,0,0.1),
        0 1px 3px rgba(0,0,0,0.05),
        inset 0 1px 0 rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    overflow: hidden;
    width: 100%;
}

.card-header-premium {
    background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium));
    color: white;
    padding: 1.5rem 2rem;
    border: none;
    position: relative;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
}

.card-header-premium::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #a1887f, transparent, #a1887f);
}

.card-title-premium {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Buscador mejorado */
.search-container {
    position: relative;
    max-width: 350px;
}

.search-input {
    border: 2px solid var(--coffee-cream);
    border-radius: 25px;
    padding: 8px 45px 8px 15px;
    background: rgba(255,255,255,0.9);
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: var(--coffee-medium);
    box-shadow: 0 0 0 0.2rem rgba(139, 90, 60, 0.25);
    background: white;
}

.search-btn {
    position: absolute;
    right: 3px;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium));
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    color: white;
    transition: all 0.3s ease;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.search-btn:hover {
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 4px 12px rgba(109, 78, 54, 0.4);
}

/* Tabla premium */
.table-premium {
    margin: 0;
    border-radius: 0;
}

.table-premium thead th {
    background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium));
    color: white;
    border: none;
    padding: 1.2rem 1rem;
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
    position: relative;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
    min-width: 140px;
}

.table-premium thead th::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(255,255,255,0.2);
}

.table-premium tbody td {
    padding: 1.2rem 1rem;
    vertical-align: middle;
    border-color: var(--coffee-beige);
    font-size: 0.9rem;
    text-align: center;
    min-width: 140px;
}

.table-premium tbody tr {
    transition: all 0.3s ease;
}

.table-premium tbody tr:hover {
    background: linear-gradient(135deg, rgba(109, 78, 54, 0.05), rgba(139, 90, 60, 0.08));
    transform: scale(1.01);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Estados con badges modernos */
.badge-estado {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-activo {
    background: linear-gradient(135deg, #4caf50, #43a047);
    color: white;
    box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
}

.badge-inactivo {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
    box-shadow: 0 2px 8px rgba(244, 67, 54, 0.3);
}

/* Botones de acción mejorados */
.btn-action {
    border: none;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
    margin: 0 2px;
}

.btn-edit {
    background: linear-gradient(135deg, #ff9800, #f57c00);
    color: white;
}

.btn-edit:hover {
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
}

.btn-delete {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
}

.btn-delete:hover {
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
}

/* Estilos para formularios modernos */
.form-control-modern, .form-select-modern {
    border: 2px solid var(--coffee-cream);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    background: rgba(255, 255, 255, 0.9);
}

.form-control-modern:focus, .form-select-modern:focus {
    border-color: var(--coffee-light);
    box-shadow: 0 0 0 0.25rem rgba(111, 78, 55, 0.15);
    background: white;
    transform: translateY(-1px);
}

.form-label {
    font-weight: 600;
    color: var(--coffee-dark);
    margin-bottom: 8px;
}

/* Botones modernos para modales */
.btn-secondary-modern {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
    border: none;
}

.btn-secondary-modern:hover {
    color: white;
    background: linear-gradient(135deg, #5a6268, #495057);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
}

.btn-primary-modern {
    background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium));
    color: white;
    border: none;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.btn-primary-modern:hover {
    color: white;
    background: linear-gradient(135deg, var(--coffee-medium), var(--coffee-light));
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(109, 78, 54, 0.4);
}

.btn-warning-modern {
    background: linear-gradient(135deg, #ff9800, #f57c00);
    color: white;
    border: none;
}

.btn-warning-modern:hover {
    color: white;
    background: linear-gradient(135deg, #f57c00, #ef6c00);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
}

/* Animaciones de carga para botones */
.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    margin: auto;
    border: 2px solid transparent;
    border-top-color: white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Efectos hover para inputs */
.form-control-modern:hover:not(:focus) {
    border-color: var(--coffee-accent);
    background: rgba(255, 255, 255, 0.95);
}

/* Estilos para select con iconos */
.form-select-modern {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23%236f4e37' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px 12px;
}

.form-select-modern option {
    padding: 8px;
    font-weight: 500;
}
</style>

<div class="container-fluid">
    {{-- Título principal elegante --}}
    <h1 class="main-title">
        <i class="fas fa-seedling me-3"></i>
        Gestión de Lotes de Cacao
    </h1>

    {{-- Botones principales --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-modern btn-crear" data-bs-toggle="modal" data-bs-target="#crearLoteModal">
            <i class="fas fa-plus me-2"></i>
            Crear Nuevo Lote
        </button>
        <a href="{{ url('/reporte') }}" class="btn btn-modern btn-reporte" style="background: linear-gradient(135deg, var(--coffee-gold), #b8860b); color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
            <i class="fas fa-chart-line me-2"></i>
            Ver Reportes
        </a>
    </div>
    
    {{-- Card principal de la tabla --}}
    <div class="card main-card">
        <div class="card-header card-header-premium">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title-premium">
                    <i class="fas fa-list-alt me-2"></i>
                    Lotes Registrados
                    <span class="badge bg-light text-dark ms-2">{{ count($lotes) }}</span>
                </h5>
                <div class="search-container">
                    <input type="text" id="buscarVariedad" class="form-control search-input" placeholder="Buscar lote...">
                    <button class="btn search-btn" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-premium" id="tablaLotes">
                    <thead>
                        <tr>
                            <th><i class="fas fa-tag me-1"></i> Nombre</th>
                            <th><i class="fas fa-calendar me-1"></i> Fecha Inicio</th>
                            <th><i class="fas fa-expand-arrows-alt me-1"></i> Área (m²)</th>
                            <th><i class="fas fa-tree me-1"></i> Capacidad</th>
                            <th><i class="fas fa-leaf me-1"></i> Tipo Cacao</th>
                            <th><i class="fas fa-toggle-on me-1"></i> Estado</th>
                            <th><i class="fas fa-sticky-note me-1"></i> Observaciones</th>
                            <th><i class="fas fa-cogs me-1"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lotes as $lote)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $lote->nombre }}</div>
                                    <small class="text-muted">Lote #{{ $loop->iteration }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ \Carbon\Carbon::parse($lote->fecha_inicio)->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($lote->fecha_inicio)->locale('es')->isoFormat('MMM YYYY') }}</small>
                                </td>
                                <td>
                                    <span class="badge" style="background: linear-gradient(135deg, #2196f3, #1976d2); color: white;">
                                        {{ number_format($lote->area, 0, ',', '.') }} m²
                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background: linear-gradient(135deg, #4caf50, #388e3c); color: white;">
                                        {{ number_format($lote->capacidad, 0, ',', '.') }} árboles
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold" style="color: var(--coffee-medium);">
                                        <i class="fas fa-seedling me-1"></i>
                                        {{ $lote->tipo_cacao }}
                                    </div>
                                </td>
                                <td>
                                    @if($lote->estado === 'Activo')
                                        <span class="badge badge-estado badge-activo">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge badge-estado badge-inactivo">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($lote->observaciones)
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $lote->observaciones }}">
                                            {{ $lote->observaciones }}
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">Sin observaciones</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editarLoteModal" 
                                            onclick="cargarDatosLote({{ $lote }})">
                                            <i class="fas fa-edit me-1"></i>
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-action btn-delete"
                                            onclick="verificarEliminarLote('{{ $lote->estado }}', '{{ route('lotes.destroy', $lote->id) }}')">
                                            <i class="fas fa-trash me-1"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-seedling fa-3x mb-3" style="color: #bcaaa4;"></i>
                                        <h5>No hay lotes registrados</h5>
                                        <p>Comienza creando tu primer lote de cacao</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal para crear un nuevo lote --}}
<div class="modal fade" id="crearLoteModal" tabindex="-1" aria-labelledby="crearLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <form id="formCrearLote" action="{{ route('lotes.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white position-relative" style="background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="modal-title fw-bold" id="crearLoteModalLabel" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
                        <i class="fas fa-plus-circle me-2"></i>
                        Crear Nuevo Lote
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="position-absolute bottom-0 start-0 end-0" style="height: 3px; background: linear-gradient(90deg, #a1887f, transparent, #a1887f);"></div>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-tag me-2"></i>Nombre del Lote
                            </label>
                            <input type="text" class="form-control form-control-modern" id="nombre" name="nombre" required 
                                   placeholder="Ej. Lote Norte A" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-calendar-alt me-2"></i>Fecha de Inicio
                            </label>
                            <input type="date" class="form-control form-control-modern" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                    </div>
                    <div class="row g-4 mt-0">
                        <div class="col-md-6">
                            <label for="area" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-expand-arrows-alt me-2"></i>Área (m²)
                            </label>
                            <input type="number" class="form-control form-control-modern" id="area" name="area" required 
                                   placeholder="Ej. 5000" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="capacidad" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-tree me-2"></i>Capacidad (árboles)
                            </label>
                            <input type="number" class="form-control form-control-modern" id="capacidad" name="capacidad" required 
                                   min="1" max="99999" maxlength="5" placeholder="Ej. 200"
                                   oninput="if(this.value.length>5)this.value=this.value.slice(0,5);" autocomplete="off">
                        </div>
                    </div>
                    <div class="row g-4 mt-0">
                        <div class="col-md-6">
                            <label for="tipo_cacao" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-seedling me-2"></i>Tipo de Cacao
                            </label>
                            <select class="form-select form-select-modern" id="tipo_cacao" name="tipo_cacao" required>
                                <option value="">Seleccione el tipo...</option>
                                <option value="CCN-51">🌱 CCN-51</option>
                                <option value="ICS-95">🌱 ICS-95</option>
                                <option value="TCS-13">🌱 TCS-13</option>
                                <option value="EET-96">🌱 EET-96</option>
                                <option value="CC-137">🌱 CC-137</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-toggle-on me-2"></i>Estado
                            </label>
                            <select class="form-select form-select-modern" id="estado" name="estado" required>
                                <option value="Activo" style="color: #4caf50;">✅ Activo</option>
                                <option value="Inactivo" style="color: #f44336;">❌ Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="observaciones" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                            <i class="fas fa-sticky-note me-2"></i>Observaciones
                        </label>
                        <textarea class="form-control form-control-modern" id="observaciones" name="observaciones" rows="3" 
                                  placeholder="Ingrese observaciones adicionales..." autocomplete="off"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8f9fa; border-radius: 0 0 20px 20px; padding: 1.5rem 2rem;">
                    <button type="button" class="btn btn-modern btn-secondary-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" id="btnGuardarLote" class="btn btn-modern btn-primary-modern">
                        <i class="fas fa-save me-2"></i>Guardar Lote
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para editar un lote --}}
<div class="modal fade" id="editarLoteModal" tabindex="-1" aria-labelledby="editarLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <form id="editarLoteForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header text-white position-relative" style="background: linear-gradient(135deg, #ff9800, #f57c00); border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="modal-title fw-bold" id="editarLoteModalLabel">
                        <i class="fas fa-edit me-2"></i>
                        Editar Lote
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="position-absolute bottom-0 start-0 end-0" style="height: 3px; background: linear-gradient(90deg, #ffc107, transparent, #ffc107);"></div>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="edit_nombre" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-tag me-2"></i>Nombre del Lote
                            </label>
                            <input type="text" class="form-control form-control-modern" id="edit_nombre" name="nombre" required 
                                   placeholder="Nombre del lote" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fecha_inicio" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-calendar-alt me-2"></i>Fecha de Inicio
                            </label>
                            <input type="date" class="form-control form-control-modern" id="edit_fecha_inicio" name="fecha_inicio" required>
                        </div>
                    </div>
                    <div class="row g-4 mt-0">
                        <div class="col-md-6">
                            <label for="edit_area" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-expand-arrows-alt me-2"></i>Área (m²)
                            </label>
                            <input type="number" class="form-control form-control-modern" id="edit_area" name="area" required 
                                   placeholder="Área del lote" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_capacidad" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-tree me-2"></i>Capacidad (árboles)
                            </label>
                            <input type="number" class="form-control form-control-modern" id="edit_capacidad" name="capacidad" required 
                                   min="1" max="99999" maxlength="5" placeholder="Cantidad de árboles"
                                   oninput="if(this.value.length>5)this.value=this.value.slice(0,5);" autocomplete="off">
                        </div>
                    </div>
                    <div class="row g-4 mt-0">
                        <div class="col-md-6">
                            <label for="edit_tipo_cacao" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-seedling me-2"></i>Tipo de Cacao
                            </label>
                            <select class="form-select form-select-modern" id="edit_tipo_cacao" name="tipo_cacao" required>
                                <option value="">Seleccione el tipo...</option>
                                <option value="CCN-51">🌱 CCN-51</option>
                                <option value="ICS-95">🌱 ICS-95</option>
                                <option value="TCS-13">🌱 TCS-13</option>
                                <option value="EET-96">🌱 EET-96</option>
                                <option value="CC-137">🌱 CC-137</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_estado" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                                <i class="fas fa-toggle-on me-2"></i>Estado
                            </label>
                            <select class="form-select form-select-modern" id="edit_estado" name="estado" required>
                                <option value="Activo" style="color: #4caf50;">✅ Activo</option>
                                <option value="Inactivo" style="color: #f44336;">❌ Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="edit_observaciones" class="form-label fw-semibold" style="color: var(--coffee-dark);">
                            <i class="fas fa-sticky-note me-2"></i>Observaciones
                        </label>
                        <textarea class="form-control form-control-modern" id="edit_observaciones" name="observaciones" rows="3" 
                                  placeholder="Observaciones adicionales..." autocomplete="off"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8f9fa; border-radius: 0 0 20px 20px; padding: 1.5rem 2rem;">
                    <button type="button" class="btn btn-modern btn-secondary-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-modern btn-warning-modern">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal de éxito moderno --}}
<div class="modal fade" id="modalExitoLote" tabindex="-1" aria-labelledby="modalExitoLoteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border: none; border-radius: 25px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); box-shadow: 0 25px 50px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body text-center p-5" style="position: relative;">
        <!-- Decoración de fondo -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 30% 20%, rgba(111, 78, 55, 0.1) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(76, 175, 80, 0.1) 0%, transparent 50%); z-index: 1;"></div>
        
        <!-- Contenido -->
        <div class="position-relative" style="z-index: 2;">
          <!-- Icono principal animado -->
          <div class="mb-4" style="animation: successBounce 1s ease-out;">
            <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); border-radius: 50%; box-shadow: 0 10px 25px rgba(109, 78, 54, 0.4);">
              <i class="fas fa-check text-white" style="font-size: 2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
            </div>
          </div>
          
          <!-- Título -->
          <h4 class="fw-bold mb-3" style="color: var(--coffee-dark); animation: fadeInUp 0.8s ease-out 0.2s both;">
            ¡Lote Creado Exitosamente!
          </h4>
          
          <!-- Descripción -->
          <p class="text-muted mb-4" style="font-size: 1.1rem; animation: fadeInUp 0.8s ease-out 0.4s both;">
            El nuevo lote de cacao ha sido registrado correctamente en el sistema.
          </p>
          
          <!-- Icono decorativo -->
          <div style="animation: fadeInUp 0.8s ease-out 0.6s both;">
            <i class="fas fa-seedling" style="font-size: 2.5rem; color: var(--coffee-medium);"></i>
          </div>
          
          <!-- Contador automático -->
          <div class="mt-3" style="animation: fadeInUp 0.8s ease-out 0.8s both;">
            <small class="text-muted">
              <i class="fas fa-clock me-1"></i>
              Cerrando automáticamente en <span id="countdown">5</span> segundos...
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal de éxito para editar lote moderno --}}
<div class="modal fade" id="modalExitoEditarLote" tabindex="-1" aria-labelledby="modalExitoEditarLoteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border: none; border-radius: 25px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); box-shadow: 0 25px 50px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body text-center p-5" style="position: relative;">
        <!-- Decoración de fondo -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 30% 20%, rgba(255, 152, 0, 0.1) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(111, 78, 55, 0.1) 0%, transparent 50%); z-index: 1;"></div>
        
        <!-- Contenido -->
        <div class="position-relative" style="z-index: 2;">
          <!-- Icono principal animado -->
          <div class="mb-4" style="animation: successBounce 1s ease-out;">
            <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff9800, #f57c00); border-radius: 50%; box-shadow: 0 10px 25px rgba(255, 152, 0, 0.3);">
              <i class="fas fa-edit text-white" style="font-size: 2rem;"></i>
            </div>
          </div>
          
          <!-- Título -->
          <h4 class="fw-bold mb-3" style="color: var(--coffee-dark); animation: fadeInUp 0.8s ease-out 0.2s both;">
            ¡Lote Actualizado Correctamente!
          </h4>
          
          <!-- Descripción -->
          <p class="text-muted mb-4" style="font-size: 1.1rem; animation: fadeInUp 0.8s ease-out 0.4s both;">
            Los cambios han sido guardados exitosamente en el sistema.
          </p>
          
          <!-- Icono decorativo -->
          <div style="animation: fadeInUp 0.8s ease-out 0.6s both;">
            <i class="fas fa-leaf" style="font-size: 2.5rem; color: #ff9800;"></i>
          </div>
          
          <!-- Contador automático -->
          <div class="mt-3" style="animation: fadeInUp 0.8s ease-out 0.8s both;">
            <small class="text-muted">
              <i class="fas fa-clock me-1"></i>
              Cerrando automáticamente en <span id="countdownEdit">5</span> segundos...
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
@keyframes successBounce {
  0% { 
    transform: scale(0.3) rotate(-10deg); 
    opacity: 0; 
  }
  50% { 
    transform: scale(1.1) rotate(5deg); 
    opacity: 0.8; 
  }
  70% { 
    transform: scale(0.95) rotate(-2deg); 
    opacity: 0.9; 
  }
  100% { 
    transform: scale(1) rotate(0deg); 
    opacity: 1; 
  }
}

@keyframes fadeInUp {
  0% {
    transform: translateY(30px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
}
</style>

{{-- Modal de advertencia para lote activo --}}
<div class="modal fade" id="modalLoteActivo" tabindex="-1" aria-labelledby="modalLoteActivoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border: 3px solid #ff9800; border-radius: 15px; box-shadow: 0 0 30px #ff9800;">
      <div class="modal-header" style="background: linear-gradient(90deg, #ff9800 60%, #fff3e0 100%);">
        <h5 class="modal-title" id="modalLoteActivoLabel" style="color: #fff; font-weight: bold;">
          <i class="fas fa-exclamation-triangle"></i> Lote Activo
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center" style="font-size: 1.2rem; color: #6f4e37;">
        <strong>¡Este lote está <span style="color: #43a047;">ACTIVO</span> y no se puede eliminar!</strong>
        <br>
        <img src="https://cdn-icons-png.flaticon.com/512/463/463612.png" alt="Advertencia" style="width: 80px; margin-top: 15px;">
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-warning" data-bs-dismiss="modal" style="font-weight: bold;">Entendido</button>
      </div>
    </div>
  </div>
</div>

<script>
function verificarEliminarLote(estado, rutaEliminar) {
    if (estado.trim().toLowerCase() === 'activo') {
        var modal = new bootstrap.Modal(document.getElementById('modalLoteActivo'));
        modal.show();
    } else {
        let form = document.createElement('form');
        form.action = rutaEliminar;
        form.method = 'POST';
        form.style.display = 'none';

        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        let method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);

        document.body.appendChild(form);
        form.submit();
    }
}

function cargarDatosLote(lote) {
    // Establecer la acción del formulario con la ruta de actualización
    const form = document.getElementById('editarLoteForm');
    form.action = '/lotes/' + lote.id;
    
    // Cargar los datos en los campos del modal de editar
    document.getElementById('edit_nombre').value = lote.nombre || '';
    document.getElementById('edit_fecha_inicio').value = lote.fecha_inicio || '';
    document.getElementById('edit_area').value = lote.area || '';
    document.getElementById('edit_capacidad').value = lote.capacidad || '';
    document.getElementById('edit_tipo_cacao').value = lote.tipo_cacao || '';
    document.getElementById('edit_estado').value = lote.estado || '';
    document.getElementById('edit_observaciones').value = lote.observaciones || '';
}

// Establecer fecha de hoy por defecto cuando se abre el modal de crear lote
document.addEventListener('DOMContentLoaded', function() {
    const crearLoteModal = document.getElementById('crearLoteModal');
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const formCrearLote = document.getElementById('formCrearLote');
    
    crearLoteModal.addEventListener('show.bs.modal', function() {
        // Limpiar todos los campos del formulario
        formCrearLote.reset();
        
        // Obtener la fecha de hoy en formato YYYY-MM-DD
        const hoy = new Date();
        const year = hoy.getFullYear();
        const month = String(hoy.getMonth() + 1).padStart(2, '0');
        const day = String(hoy.getDate()).padStart(2, '0');
        const fechaHoy = `${year}-${month}-${day}`;
        
        // Establecer la fecha de hoy como valor por defecto después de limpiar
        fechaInicioInput.value = fechaHoy;
        
        // Limpiar específicamente los campos que queremos vacíos
        document.getElementById('nombre').value = '';
        document.getElementById('area').value = '';
        document.getElementById('capacidad').value = '';
        document.getElementById('tipo_cacao').value = '';
        document.getElementById('observaciones').value = '';
        
        // Establecer estado por defecto a Activo
        document.getElementById('estado').value = 'Activo';
    });

    // Manejar el envío del formulario de crear lote
    formCrearLote.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir el envío normal del formulario
        
        // Crear FormData con los datos del formulario
        const formData = new FormData(formCrearLote);
        
        // Enviar la solicitud usando fetch
        fetch(formCrearLote.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (response.ok) {
                // Cerrar el modal de crear lote
                const modalCrear = bootstrap.Modal.getInstance(document.getElementById('crearLoteModal'));
                modalCrear.hide();
                
                // Mostrar el modal de éxito
                const modalExito = new bootstrap.Modal(document.getElementById('modalExitoLote'));
                modalExito.show();
                
                // Iniciar contador regresivo
                let countdown = 5;
                const countdownElement = document.getElementById('countdown');
                const countdownInterval = setInterval(() => {
                    countdown--;
                    countdownElement.textContent = countdown;
                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                    }
                }, 1000);
                
                // Cerrar automáticamente después de 5 segundos y recargar la página
                setTimeout(function() {
                    modalExito.hide();
                    setTimeout(function() {
                        window.location.reload();
                    }, 300); // Pequeña pausa para que se cierre suavemente el modal
                }, 5000);
            } else {
                // Manejar errores si es necesario
                console.error('Error al crear el lote');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Manejar el envío del formulario de editar lote
    const formEditarLote = document.getElementById('editarLoteForm');
    formEditarLote.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir el envío normal del formulario
        
        // Crear FormData con los datos del formulario
        const formData = new FormData(formEditarLote);
        
        // Enviar la solicitud usando fetch
        fetch(formEditarLote.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (response.ok) {
                // Cerrar el modal de editar lote
                const modalEditar = bootstrap.Modal.getInstance(document.getElementById('editarLoteModal'));
                modalEditar.hide();
                
                // Mostrar el modal de éxito para editar
                const modalExitoEditar = new bootstrap.Modal(document.getElementById('modalExitoEditarLote'));
                modalExitoEditar.show();
                
                // Iniciar contador regresivo para editar
                let countdownEdit = 5;
                const countdownEditElement = document.getElementById('countdownEdit');
                const countdownEditInterval = setInterval(() => {
                    countdownEdit--;
                    countdownEditElement.textContent = countdownEdit;
                    if (countdownEdit <= 0) {
                        clearInterval(countdownEditInterval);
                    }
                }, 1000);
                
                // Cerrar automáticamente después de 5 segundos y recargar la página
                setTimeout(function() {
                    modalExitoEditar.hide();
                    setTimeout(function() {
                        window.location.reload();
                    }, 300); // Pequeña pausa para que se cierre suavemente el modal
                }, 5000);
            } else {
                // Manejar errores si es necesario
                console.error('Error al editar el lote');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

// Funcionalidad de búsqueda de lotes
document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarVariedad');
    const tablaLotes = document.getElementById('tablaLotes');
    const filasLotes = tablaLotes.querySelectorAll('tbody tr');
    
    buscarInput.addEventListener('input', function() {
        const terminoBusqueda = this.value.toLowerCase().trim();
        
        filasLotes.forEach(function(fila) {
            // Obtener el nombre del lote (primera celda)
            const nombreCelda = fila.querySelector('td:first-child');
            if (nombreCelda) {
                // Obtener solo el texto del nombre del lote (sin el "Lote #")
                const nombreCompleto = nombreCelda.querySelector('.fw-bold').textContent.toLowerCase().trim();
                
                // Filtrar por la primera letra o nombre completo
                let coincide = false;
                if (terminoBusqueda === '') {
                    coincide = true;
                } else if (terminoBusqueda.length === 1) {
                    // Si escriben una sola letra, filtrar por primera letra
                    coincide = nombreCompleto.startsWith(terminoBusqueda);
                } else {
                    // Si escriben más de una letra, buscar nombre completo
                    coincide = nombreCompleto.includes(terminoBusqueda);
                }
                
                // Mostrar u ocultar la fila
                if (coincide) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            }
        });
        
        // Mostrar mensaje si no hay resultados
        const filasVisibles = Array.from(filasLotes).filter(fila => fila.style.display !== 'none');
        const tbody = tablaLotes.querySelector('tbody');
        
        // Remover mensaje anterior si existe
        const mensajeAnterior = tbody.querySelector('.mensaje-sin-resultados');
        if (mensajeAnterior) {
            mensajeAnterior.remove();
        }
        
        // Si no hay filas visibles y hay término de búsqueda, mostrar mensaje
        if (filasVisibles.length === 0 && terminoBusqueda !== '') {
            const filaMensaje = document.createElement('tr');
            filaMensaje.className = 'mensaje-sin-resultados';
            filaMensaje.innerHTML = `
                <td colspan="8" class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-search fa-3x mb-3" style="color: #bcaaa4;"></i>
                        <h5>No se encontraron lotes</h5>
                        <p>No hay lotes que coincidan con "${terminoBusqueda}"</p>
                    </div>
                </td>
            `;
            tbody.appendChild(filaMensaje);
        }
    });
    
    // Funcionalidad del botón de búsqueda
    const botonBuscar = document.querySelector('.search-btn');
    botonBuscar.addEventListener('click', function() {
        buscarInput.focus();
    });
});
</script>
@endsection 