{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\create.blade.php --}}
@extends('layouts.masterr')

@section('content')
<style>
:root {
    --coffee-dark: #6d4e36; --coffee-medium: #8b5a3c; --coffee-light: #a0674b; --coffee-accent: #b8785a;
    --coffee-cream: #d7ccc8; --coffee-beige: #efebe9; --coffee-gold: #d4af37;
    --coffee-gradient: linear-gradient(135deg, var(--coffee-dark) 0%, var(--coffee-medium) 50%, var(--coffee-light) 100%);
}
body { background: linear-gradient(135deg, #f8f5f0 0%, #ede7e0 100%); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.container-fluid { padding: 2rem; max-width: 1800px; margin: 0 auto; }
.main-title { background: var(--coffee-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 2.5rem; font-weight: 700; text-align: center; margin-bottom: 2rem; position: relative; }
.main-title::after { content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 150px; height: 3px; background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); border-radius: 2px; }
.btn-modern { border: none; border-radius: 12px; padding: 12px 24px; font-weight: 600; font-size: 0.95rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.btn-crear, .btn-primary-modern { background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }
.btn-crear:hover, .btn-primary-modern:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(109, 78, 54, 0.4); }
.btn-reporte { background: linear-gradient(135deg, var(--coffee-gold), #b8860b); color: white; }
.btn-reporte:hover { color: white; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4); }
.main-card { background: rgba(255, 255, 255, 0.95); border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,0.9); backdrop-filter: blur(10px); overflow: hidden; }
.card-header-premium { background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); color: white; padding: 1.5rem 2rem; border: none; position: relative; text-shadow: 1px 1px 3px rgba(0,0,0,0.7); }
.card-title-premium { font-size: 1.3rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem; }
.search-container { position: relative; max-width: 350px; }
.search-input { border: 2px solid var(--coffee-cream); border-radius: 25px; padding: 8px 45px 8px 15px; background: rgba(255,255,255,0.9); transition: all 0.3s ease; }
.search-input:focus { border-color: var(--coffee-medium); box-shadow: 0 0 0 0.2rem rgba(139, 90, 60, 0.25); background: white; }
.search-btn { position: absolute; right: 3px; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); border: none; border-radius: 50%; width: 35px; height: 35px; color: white; transition: all 0.3s ease; }
.search-btn:hover { transform: translateY(-50%) scale(1.1); box-shadow: 0 4px 12px rgba(109, 78, 54, 0.4); }
.table-premium { margin: 0; }
.table-premium thead th { background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); color: white; border: none; padding: 1.2rem 1rem; font-weight: 600; font-size: 0.9rem; text-align: center; text-shadow: 1px 1px 3px rgba(0,0,0,0.7); min-width: 140px; }
.table-premium tbody td { padding: 1.2rem 1rem; vertical-align: middle; border-color: var(--coffee-beige); font-size: 0.9rem; text-align: center; min-width: 140px; }
.table-premium tbody tr { transition: all 0.3s ease; }
.table-premium tbody tr:hover { background: linear-gradient(135deg, rgba(109, 78, 54, 0.05), rgba(139, 90, 60, 0.08)); transform: scale(1.01); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.badge-estado { padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; }
.badge-activo { background: linear-gradient(135deg, #4caf50, #43a047); color: white; box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3); }
.badge-inactivo { background: linear-gradient(135deg, #f44336, #d32f2f); color: white; box-shadow: 0 2px 8px rgba(244, 67, 54, 0.3); }
.btn-action { border: none; border-radius: 8px; padding: 6px 12px; font-size: 0.8rem; font-weight: 600; transition: all 0.3s ease; margin: 0 2px; }
.btn-edit { background: linear-gradient(135deg, #ffc107, #ffb300); color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }
.btn-edit:hover { color: white; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4); }
.btn-delete { background: linear-gradient(135deg, #dc3545, #c82333); color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }
.btn-delete:hover { color: white; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4); }
.form-control-modern, .form-select-modern { border: 2px solid var(--coffee-cream); border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: all 0.3s ease; background: rgba(255, 255, 255, 0.9); }
.form-control-modern:focus, .form-select-modern:focus { border-color: var(--coffee-light); box-shadow: 0 0 0 0.25rem rgba(111, 78, 55, 0.15); background: white; transform: translateY(-1px); }
.form-label { font-weight: 600; color: var(--coffee-dark); margin-bottom: 8px; }
.btn-secondary-modern { background: linear-gradient(135deg, #6c757d, #5a6268); color: white; border: none; }
.btn-secondary-modern:hover { color: white; background: linear-gradient(135deg, #5a6268, #495057); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3); }
.form-select-modern { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23%236f4e37' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px 12px; }
@keyframes successBounce { 0% { transform: scale(0.3) rotate(-10deg); opacity: 0; } 50% { transform: scale(1.1) rotate(5deg); opacity: 0.8; } 70% { transform: scale(0.95) rotate(-2deg); opacity: 0.9; } 100% { transform: scale(1) rotate(0deg); opacity: 1; } }
@keyframes fadeInUp { 0% { transform: translateY(30px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
</style>

<div class="container-fluid">
    <h1 class="main-title"><i class="fas fa-seedling me-3"></i>Gestión de Lotes de Cacao</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-modern btn-crear" data-bs-toggle="modal" data-bs-target="#crearLoteModal">
            <i class="fas fa-plus me-2"></i>Crear Nuevo Lote
        </button>
        <a href="{{ url('/reporte') }}" class="btn btn-modern btn-reporte">
            <i class="fas fa-chart-line me-2"></i>Ver Reportes
        </a>
    </div>
    
    <div class="card main-card">
        <div class="card-header card-header-premium">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title-premium">
                    <i class="fas fa-list-alt me-2"></i>Lotes Registrados
                    <span class="badge bg-light text-dark ms-2">{{ count($lotes) }}</span>
                </h5>
                <div class="search-container">
                    <input type="text" id="buscarVariedad" class="form-control search-input" placeholder="Buscar lote...">
                    <button class="btn search-btn" type="button"><i class="fas fa-search"></i></button>
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
                                <td><span class="badge" style="background: linear-gradient(135deg, #2196f3, #1976d2); color: white;">{{ number_format($lote->area, 0, ',', '.') }} m²</span></td>
                                <td><span class="badge" style="background: linear-gradient(135deg, #4caf50, #388e3c); color: white;">{{ number_format($lote->capacidad, 0, ',', '.') }} árboles</span></td>
                                <td><div class="fw-bold" style="color: var(--coffee-medium);"><i class="fas fa-seedling me-1"></i>{{ $lote->tipo_cacao }}</div></td>
                                <td>
                                    @if($lote->estado === 'Activo')
                                        <span class="badge badge-estado badge-activo"><i class="fas fa-check-circle me-1"></i>Activo</span>
                                    @else
                                        <span class="badge badge-estado badge-inactivo"><i class="fas fa-times-circle me-1"></i>Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lote->observaciones)
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $lote->observaciones }}">{{ $lote->observaciones }}</div>
                                    @else
                                        <span class="text-muted fst-italic">Sin observaciones</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editarLoteModal" onclick="cargarDatosLote({{ $lote }})">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </button>
                                        <button type="button" class="btn btn-action btn-delete" onclick="verificarEliminarLote('{{ $lote->estado }}', '{{ route('lotes.destroy', $lote->id) }}')">
                                            <i class="fas fa-trash me-1"></i>Eliminar
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

{{-- Modales optimizados --}}
<div class="modal fade" id="crearLoteModal" tabindex="-1" aria-labelledby="crearLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <form id="formCrearLote" action="{{ route('lotes.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white position-relative" style="background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="modal-title fw-bold" id="crearLoteModalLabel" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
                        <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Lote
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label"><i class="fas fa-tag me-2"></i>Nombre del Lote</label>
                            <input type="text" class="form-control form-control-modern" id="nombre" name="nombre" required placeholder="Ej. Lote Norte A">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label"><i class="fas fa-calendar-alt me-2"></i>Fecha de Inicio</label>
                            <input type="date" class="form-control form-control-modern" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="area" class="form-label"><i class="fas fa-expand-arrows-alt me-2"></i>Área (m²)</label>
                            <input type="number" class="form-control form-control-modern" id="area" name="area" required placeholder="Ej. 5000">
                        </div>
                        <div class="col-md-6">
                            <label for="capacidad" class="form-label"><i class="fas fa-tree me-2"></i>Capacidad (árboles)</label>
                            <input type="number" class="form-control form-control-modern" id="capacidad" name="capacidad" required min="1" max="99999" maxlength="5" placeholder="Ej. 200" oninput="if(this.value.length>5)this.value=this.value.slice(0,5);">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_cacao" class="form-label"><i class="fas fa-seedling me-2"></i>Tipo de Cacao</label>
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
                            <label for="estado" class="form-label"><i class="fas fa-toggle-on me-2"></i>Estado</label>
                            <select class="form-select form-select-modern" id="estado" name="estado" required>
                                <option value="Activo" style="color: #4caf50;">✅ Activo</option>
                                <option value="Inactivo" style="color: #f44336;">❌ Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="observaciones" class="form-label"><i class="fas fa-sticky-note me-2"></i>Observaciones</label>
                            <textarea class="form-control form-control-modern" id="observaciones" name="observaciones" rows="3" placeholder="Ingrese observaciones adicionales..."></textarea>
                        </div>
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

<div class="modal fade" id="editarLoteModal" tabindex="-1" aria-labelledby="editarLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <form id="editarLoteForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header text-white position-relative" style="background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                    <h5 class="modal-title fw-bold" id="editarLoteModalLabel"><i class="fas fa-edit me-2"></i>Editar Lote</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="edit_nombre" class="form-label"><i class="fas fa-tag me-2"></i>Nombre del Lote</label>
                            <input type="text" class="form-control form-control-modern" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fecha_inicio" class="form-label"><i class="fas fa-calendar-alt me-2"></i>Fecha de Inicio</label>
                            <input type="date" class="form-control form-control-modern" id="edit_fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_area" class="form-label"><i class="fas fa-expand-arrows-alt me-2"></i>Área (m²)</label>
                            <input type="number" class="form-control form-control-modern" id="edit_area" name="area" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_capacidad" class="form-label"><i class="fas fa-tree me-2"></i>Capacidad (árboles)</label>
                            <input type="number" class="form-control form-control-modern" id="edit_capacidad" name="capacidad" required min="1" max="99999" maxlength="5" oninput="if(this.value.length>5)this.value=this.value.slice(0,5);">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_tipo_cacao" class="form-label"><i class="fas fa-seedling me-2"></i>Tipo de Cacao</label>
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
                            <label for="edit_estado" class="form-label"><i class="fas fa-toggle-on me-2"></i>Estado</label>
                            <select class="form-select form-select-modern" id="edit_estado" name="estado" required>
                                <option value="Activo" style="color: #4caf50;">✅ Activo</option>
                                <option value="Inactivo" style="color: #f44336;">❌ Inactivo</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="edit_observaciones" class="form-label"><i class="fas fa-sticky-note me-2"></i>Observaciones</label>
                            <textarea class="form-control form-control-modern" id="edit_observaciones" name="observaciones" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8f9fa; border-radius: 0 0 20px 20px; padding: 1.5rem 2rem;">
                    <button type="button" class="btn btn-modern btn-secondary-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-modern btn-primary-modern">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modales de éxito y advertencia --}}
<div class="modal fade" id="modalExitoLote" tabindex="-1" aria-labelledby="modalExitoLoteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border: none; border-radius: 25px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); box-shadow: 0 25px 50px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body text-center p-5" style="position: relative;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 30% 20%, rgba(111, 78, 55, 0.1) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(76, 175, 80, 0.1) 0%, transparent 50%); z-index: 1;"></div>
        <div class="position-relative" style="z-index: 2;">
          <div class="mb-4" style="animation: successBounce 1s ease-out;">
            <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); border-radius: 50%; box-shadow: 0 10px 25px rgba(109, 78, 54, 0.4);">
              <i class="fas fa-check text-white" style="font-size: 2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
            </div>
          </div>
          <h4 class="fw-bold mb-3" style="color: var(--coffee-dark); animation: fadeInUp 0.8s ease-out 0.2s both;">¡Lote Creado Exitosamente!</h4>
          <p class="text-muted mb-4" style="font-size: 1.1rem; animation: fadeInUp 0.8s ease-out 0.4s both;">El nuevo lote de cacao ha sido registrado correctamente en el sistema.</p>
          <div style="animation: fadeInUp 0.8s ease-out 0.6s both;">
            <i class="fas fa-seedling" style="font-size: 2.5rem; color: var(--coffee-medium);"></i>
          </div>
          <div class="mt-3" style="animation: fadeInUp 0.8s ease-out 0.8s both;">
            <small class="text-muted"><i class="fas fa-clock me-1"></i>Cerrando automáticamente en <span id="countdown">3</span> segundos...</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalExitoEditarLote" tabindex="-1" aria-labelledby="modalExitoEditarLoteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border: none; border-radius: 25px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); box-shadow: 0 25px 50px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body text-center p-5" style="position: relative;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 30% 20%, rgba(111, 78, 55, 0.1) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(139, 90, 60, 0.1) 0%, transparent 50%); z-index: 1;"></div>
        <div class="position-relative" style="z-index: 2;">
          <div class="mb-4" style="animation: successBounce 1s ease-out;">
            <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--coffee-dark), var(--coffee-medium)); border-radius: 50%; box-shadow: 0 10px 25px rgba(111, 78, 55, 0.4);">
              <i class="fas fa-edit text-white" style="font-size: 2rem;"></i>
            </div>
          </div>
          <h4 class="fw-bold mb-3" style="color: var(--coffee-dark); animation: fadeInUp 0.8s ease-out 0.2s both;">¡Lote Actualizado Correctamente!</h4>
          <p class="text-muted mb-4" style="font-size: 1.1rem; animation: fadeInUp 0.8s ease-out 0.4s both;">Los cambios han sido guardados exitosamente en el sistema.</p>
          <div style="animation: fadeInUp 0.8s ease-out 0.6s both;">
            <i class="fas fa-leaf" style="font-size: 2.5rem; color: var(--coffee-medium);"></i>
          </div>
          <div class="mt-3" style="animation: fadeInUp 0.8s ease-out 0.8s both;">
            <small class="text-muted"><i class="fas fa-clock me-1"></i>Cerrando automáticamente en <span id="countdownEdit">3</span> segundos...</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalLoteActivo" tabindex="-1" aria-labelledby="modalLoteActivoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border: 3px solid var(--coffee-medium); border-radius: 15px; box-shadow: 0 0 30px rgba(111, 78, 55, 0.3);">
      <div class="modal-header" style="background: linear-gradient(90deg, var(--coffee-dark) 60%, var(--coffee-light) 100%);">
        <h5 class="modal-title" id="modalLoteActivoLabel" style="color: #fff; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
          <i class="fas fa-exclamation-triangle"></i> Lote Activo
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center" style="font-size: 1.2rem; color: var(--coffee-dark); padding: 2rem;">
        <div class="mb-3"><i class="fas fa-shield-alt fa-3x" style="color: var(--coffee-medium);"></i></div>
        <strong>¡Este lote está <span style="color: #43a047;">ACTIVO</span> y no se puede eliminar!</strong>
        <br><br>
        <p style="color: #666; font-size: 1rem;">Los lotes activos están siendo utilizados en el sistema y no pueden eliminarse por seguridad.</p>
      </div>
      <div class="modal-footer justify-content-center" style="background-color: #f8f9fa;">
        <button type="button" class="btn btn-modern btn-primary-modern" data-bs-dismiss="modal">
          <i class="fas fa-check me-2"></i>Entendido
        </button>
      </div>
    </div>
  </div>
</div>

<script>
function verificarEliminarLote(estado, rutaEliminar) {
    if (estado.trim().toLowerCase() === 'activo') {
        new bootstrap.Modal(document.getElementById('modalLoteActivo')).show();
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
    const form = document.getElementById('editarLoteForm');
    form.action = '/lotes/' + lote.id;
    document.getElementById('edit_nombre').value = lote.nombre || '';
    document.getElementById('edit_fecha_inicio').value = lote.fecha_inicio || '';
    document.getElementById('edit_area').value = lote.area || '';
    document.getElementById('edit_capacidad').value = lote.capacidad || '';
    document.getElementById('edit_tipo_cacao').value = lote.tipo_cacao || '';
    document.getElementById('edit_estado').value = lote.estado || '';
    document.getElementById('edit_observaciones').value = lote.observaciones || '';
}

document.addEventListener('DOMContentLoaded', function() {
    const crearLoteModal = document.getElementById('crearLoteModal');
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const formCrearLote = document.getElementById('formCrearLote');
    
    crearLoteModal.addEventListener('show.bs.modal', function() {
        formCrearLote.reset();
        const btnGuardar = document.getElementById('btnGuardarLote');
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save me-2"></i>Guardar Lote';
        const hoy = new Date();
        const year = hoy.getFullYear();
        const month = String(hoy.getMonth() + 1).padStart(2, '0');
        const day = String(hoy.getDate()).padStart(2, '0');
        const fechaHoy = `${year}-${month}-${day}`;
        fechaInicioInput.value = fechaHoy;
        document.getElementById('nombre').value = '';
        document.getElementById('area').value = '';
        document.getElementById('capacidad').value = '';
        document.getElementById('tipo_cacao').value = '';
        document.getElementById('observaciones').value = '';
        document.getElementById('estado').value = 'Activo';
    });

    formCrearLote.addEventListener('submit', function(e) {
        e.preventDefault();
        const btnGuardar = document.getElementById('btnGuardarLote');
        if (btnGuardar.disabled) return;
        btnGuardar.disabled = true;
        const textoOriginal = btnGuardar.innerHTML;
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        const formData = new FormData(formCrearLote);
        
        fetch(formCrearLote.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (response.ok) {
                bootstrap.Modal.getInstance(document.getElementById('crearLoteModal')).hide();
                const modalExito = new bootstrap.Modal(document.getElementById('modalExitoLote'));
                modalExito.show();
                let countdown = 3;
                const countdownElement = document.getElementById('countdown');
                const countdownInterval = setInterval(() => {
                    countdown--;
                    countdownElement.textContent = countdown;
                    if (countdown <= 0) clearInterval(countdownInterval);
                }, 1000);
                setTimeout(function() {
                    modalExito.hide();
                    setTimeout(function() {
                        window.location.reload();
                    }, 300);
                }, 3000);
            } else {
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = textoOriginal;
                console.error('Error al crear el lote');
            }
        })
        .catch(error => {
            btnGuardar.disabled = false;
            btnGuardar.innerHTML = textoOriginal;
            console.error('Error:', error);
        });
    });

    const formEditarLote = document.getElementById('editarLoteForm');
    formEditarLote.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formEditarLote);
        
        fetch(formEditarLote.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (response.ok) {
                bootstrap.Modal.getInstance(document.getElementById('editarLoteModal')).hide();
                const modalExitoEditar = new bootstrap.Modal(document.getElementById('modalExitoEditarLote'));
                modalExitoEditar.show();
                let countdownEdit = 3;
                const countdownEditElement = document.getElementById('countdownEdit');
                const countdownEditInterval = setInterval(() => {
                    countdownEdit--;
                    countdownEditElement.textContent = countdownEdit;
                    if (countdownEdit <= 0) clearInterval(countdownEditInterval);
                }, 1000);
                setTimeout(function() {
                    modalExitoEditar.hide();
                    setTimeout(function() {
                        window.location.reload();
                    }, 300);
                }, 3000);
            } else {
                console.error('Error al editar el lote');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    const buscarInput = document.getElementById('buscarVariedad');
    const tablaLotes = document.getElementById('tablaLotes');
    const filasLotes = tablaLotes.querySelectorAll('tbody tr');
    
    buscarInput.addEventListener('input', function() {
        const terminoBusqueda = this.value.toLowerCase().trim();
        
        filasLotes.forEach(function(fila) {
            const nombreCelda = fila.querySelector('td:first-child');
            if (nombreCelda) {
                const nombreCompleto = nombreCelda.querySelector('.fw-bold').textContent.toLowerCase().trim();
                let coincide = false;
                if (terminoBusqueda === '') {
                    coincide = true;
                } else if (terminoBusqueda.length === 1) {
                    coincide = nombreCompleto.startsWith(terminoBusqueda);
                } else {
                    coincide = nombreCompleto.includes(terminoBusqueda);
                }
                
                if (coincide) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            }
        });
        
        const filasVisibles = Array.from(filasLotes).filter(fila => fila.style.display !== 'none');
        const tbody = tablaLotes.querySelector('tbody');
        const mensajeAnterior = tbody.querySelector('.mensaje-sin-resultados');
        if (mensajeAnterior) mensajeAnterior.remove();
        
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
    
    const botonBuscar = document.querySelector('.search-btn');
    botonBuscar.addEventListener('click', function() {
        buscarInput.focus();
    });
});
</script>
@endsection 