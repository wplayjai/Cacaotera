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
    padding: 1.5rem;
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
}

/* Título principal */
.main-title {
    color: var(--cacao-white);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.main-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

/* Breadcrumb profesional */
.breadcrumb-professional {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    padding: 0.5rem 1rem;
    margin-top: 1rem;
}

.breadcrumb-professional .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-professional .breadcrumb-item a:hover {
    color: var(--cacao-white);
}

.breadcrumb-professional .breadcrumb-item.active {
    color: var(--cacao-white);
}

/* Formularios profesionales */
.form-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.form-header {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    padding: 1rem 1.5rem;
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label-professional {
    color: var(--cacao-primary);
    font-weight: 500;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.form-control-professional,
.form-select-professional {
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.7rem 0.9rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: var(--cacao-white);
}

.form-control-professional:focus,
.form-select-professional:focus {
    border-color: var(--cacao-accent);
    box-shadow: 0 0 0 0.15rem rgba(139, 111, 71, 0.15);
    outline: none;
}

/* Botones profesionales */
.btn-professional {
    border: none;
    border-radius: 6px;
    padding: 0.7rem 1.3rem;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-primary-professional {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(74, 55, 40, 0.25);
}

.btn-primary-professional:hover {
    background: linear-gradient(135deg, var(--cacao-secondary), var(--cacao-primary));
    color: var(--cacao-white);
    transform: translateY(-1px);
    box-shadow: 0 5px 12px rgba(74, 55, 40, 0.3);
}

.btn-outline-professional {
    background: transparent;
    color: var(--cacao-primary);
    border: 2px solid var(--cacao-light);
}

.btn-outline-professional:hover {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border-color: var(--cacao-primary);
}

.btn-success-professional {
    background: linear-gradient(135deg, var(--success), #1b5e20);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(46, 125, 50, 0.25);
}

.btn-success-professional:hover {
    background: linear-gradient(135deg, #1b5e20, var(--success));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

.btn-info-professional {
    background: linear-gradient(135deg, var(--info), #0d47a1);
    color: var(--cacao-white);
    box-shadow: 0 3px 8px rgba(25, 118, 210, 0.25);
}

.btn-info-professional:hover {
    background: linear-gradient(135deg, #0d47a1, var(--info));
    color: var(--cacao-white);
    transform: translateY(-1px);
}

/* Info cards */
.info-cards {
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.05), rgba(139, 111, 71, 0.02));
    border-radius: 8px;
    padding: 1rem;
    margin: 1rem 0;
    border: 1px solid var(--cacao-light);
}

.info-card {
    background: var(--cacao-white);
    border: 1px solid var(--cacao-light);
    border-radius: 6px;
    padding: 0.7rem;
    text-align: center;
    transition: all 0.2s ease;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.info-card small {
    color: var(--cacao-muted);
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-card .value {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    margin-top: 0.2rem;
}

/* Modales profesionales */
.modal-professional .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.modal-professional .modal-header {
    background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary));
    color: var(--cacao-white);
    border-bottom: none;
    padding: 1.2rem 1.5rem;
}

.modal-professional .modal-body {
    padding: 1.5rem;
}

.modal-professional .modal-footer {
    border-top: 1px solid var(--cacao-light);
    padding: 1rem 1.5rem;
    background: var(--cacao-bg);
}

/* Tabla profesional */
.table-professional {
    margin: 0;
    font-size: 0.9rem;
    border-collapse: separate;
    border-spacing: 0;
}

.table-professional thead th {
    background: var(--cacao-primary);
    color: var(--cacao-white);
    border: none;
    padding: 1rem 0.8rem;
    font-weight: 600;
    font-size: 0.85rem;
    text-align: center;
    vertical-align: middle;
    border-bottom: 2px solid var(--cacao-secondary);
    white-space: nowrap;
}

.table-professional tbody td {
    padding: 0.9rem 0.8rem;
    vertical-align: middle;
    border-color: var(--cacao-light);
    text-align: center;
    font-size: 0.85rem;
    border-top: 1px solid var(--cacao-light);
}

.table-professional tbody tr {
    transition: all 0.2s ease;
}

.table-professional tbody tr:hover {
    background-color: rgba(139, 111, 71, 0.05);
    transform: translateY(-1px);
}

/* Badges profesionales */
.badge-professional {
    padding: 0.3rem 0.6rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.badge-success-professional {
    background-color: var(--success);
    color: var(--cacao-white);
}

.badge-primary-professional {
    background-color: var(--cacao-primary);
    color: var(--cacao-white);
}

.badge-info-professional {
    background-color: var(--info);
    color: var(--cacao-white);
}

/* Estados responsivos */
@media (max-width: 768px) {
    .main-container {
        margin: 0.5rem;
        border-radius: 8px;
    }
    
    .header-professional {
        padding: 1.2rem;
        margin: -1rem -1rem 1.2rem -1rem;
    }
    
    .main-title {
        font-size: 1.3rem;
        text-align: center;
    }
    
    .form-card {
        margin: 1rem 0;
    }
    
    .btn-professional {
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
        width: 100%;
        justify-content: center;
    }
    
    .info-cards {
        padding: 0.8rem;
    }
    
    .info-card {
        margin-bottom: 0.5rem;
    }
}

/* Alertas personalizadas */
.alert-professional {
    border: none;
    border-radius: 8px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.alert-success-professional {
    background: linear-gradient(135deg, var(--success), #1b5e20);
    color: var(--cacao-white);
}

.alert-danger-professional {
    background: linear-gradient(135deg, var(--danger), #b71c1c);
    color: var(--cacao-white);
}

/* Estado vacío profesional */
.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--cacao-muted);
    background: linear-gradient(135deg, rgba(139, 111, 71, 0.02), rgba(139, 111, 71, 0.05));
    border-radius: 8px;
    margin: 1rem;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
    color: var(--cacao-primary);
}

.empty-state h5 {
    color: var(--cacao-primary);
    margin-bottom: 1rem;
    font-size: 1.3rem;
    font-weight: 600;
}

.empty-state p {
    color: var(--cacao-muted);
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

/* Animaciones profesionales */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
</style>
<div class="container-fluid p-3">
    <div class="main-container p-4">
        <!-- Header profesional -->
        <div class="header-professional">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="flex-grow-1">
                    <h1 class="main-title">
                        <i class="fas fa-arrow-right me-2"></i>Salida de Inventario
                    </h1>
                    <p class="main-subtitle">
                        Registro y control de salidas de productos e insumos del inventario
                    </p>
                    
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="breadcrumb-professional">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('inventario.index') }}">
                                    <i class="fas fa-warehouse me-1"></i>Inventario
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-arrow-right me-1"></i>Salida
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-info-professional" data-bs-toggle="modal" data-bs-target="#verSalidasModal">
                            <i class="fas fa-list me-2"></i>Ver Salidas
                        </button>
                        <a href="{{ route('inventario.index') }}" class="btn btn-outline-professional">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Inventario
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas profesionales -->
        <div id="ajaxResponseSalida"></div>

        <!-- Formulario de Salida de Inventario -->
        <div class="row justify-content-center fade-in-up">
            <div class="col-lg-10 col-xl-8">
                <div class="form-card">
                    <div class="form-header">
                        <i class="fas fa-arrow-right me-2"></i>Registrar Salida de Inventario
                    </div>

                    <form id="salidaInventarioForm">
                        @csrf
                        <div class="p-4">
                            <!-- Producto -->
                            <div class="mb-4">
                                <label for="insumo_id" class="form-label-professional">
                                    <i class="fas fa-box"></i>Seleccionar Producto/Insumo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-professional" id="insumo_id" name="insumo_id" required>
                                    <option value="">-- Elegir producto --</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" 
                                                data-precio="{{ $producto->precio_unitario }}" 
                                                data-estado="{{ $producto->estado }}" 
                                                data-fecha="{{ $producto->fecha_registro }}"
                                                data-unidad="{{ $producto->unidad_medida }}"
                                                data-tipo="{{ $producto->tipo }}"
                                                data-disponible="{{ $producto->cantidad }}">
                                            {{ $producto->nombre }} ({{ $producto->tipo }}) - {{ $producto->cantidad }} {{ $producto->unidad_medida }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Información del Producto -->
                            <div id="producto-info" class="info-cards" style="display: none;">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Información del Producto
                                </h6>
                                <div class="row g-3">
                                    <div class="col-lg-2 col-md-4 col-sm-6">
                                        <div class="info-card">
                                            <small>Precio</small>
                                            <span class="value text-success" id="info_precio">--</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6">
                                        <div class="info-card">
                                            <small>Estado</small>
                                            <span class="value" id="info_estado">--</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6">
                                        <div class="info-card">
                                            <small>Tipo</small>
                                            <span class="value text-info" id="info_tipo">--</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6">
                                        <div class="info-card">
                                            <small>Disponible</small>
                                            <span class="value text-primary" id="info_disponible">--</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6">
                                        <div class="info-card">
                                            <small>Unidad</small>
                                            <span class="value" id="info_unidad">--</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6">
                                        <div class="info-card">
                                            <small>Registro</small>
                                            <span class="value text-muted" id="info_fecha">--</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos principales -->
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="lote_id" class="form-label-professional">
                                        <i class="fas fa-seedling"></i>Lote
                                    </label>
                                    <select class="form-select form-select-professional" id="lote_id" name="lote_id">
                                        <option value="">Sin lote específico</option>
                                        @foreach($lotes as $lote)
                                            <option value="{{ $lote->id }}">{{ $lote->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="cantidad" class="form-label-professional">
                                        <i class="fas fa-balance-scale"></i>Cantidad <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control form-control-professional" 
                                           id="cantidad" name="cantidad" step="0.001" min="0.001" required 
                                           placeholder="Ej: 10.500">
                                </div>

                                <div class="col-md-6">
                                    <label for="fecha_salida" class="form-label-professional">
                                        <i class="fas fa-calendar"></i>Fecha de Salida
                                    </label>
                                    <input type="date" class="form-control form-control-professional" 
                                           id="fecha_salida" name="fecha_salida" value="{{ date('Y-m-d') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="observaciones" class="form-label-professional">
                                        <i class="fas fa-sticky-note"></i>Observaciones
                                    </label>
                                    <input type="text" class="form-control form-control-professional" 
                                           id="observaciones" name="observaciones" placeholder="Motivo de la salida...">
                                </div>
                            </div>

                            <!-- Campos ocultos -->
                            <input type="hidden" id="unidad_medida" name="unidad_medida">
                            <input type="hidden" id="precio_unitario" name="precio_unitario">
                            <input type="hidden" id="estado" name="estado">
                            <input type="hidden" id="fecha_registro" name="fecha_registro">
                            <input type="hidden" id="produccion_id" name="produccion_id">
                        </div>

                        <div class="modal-footer bg-light">
                            <div class="d-flex gap-2 justify-content-center w-100">
                                <a href="{{ route('inventario.index') }}" class="btn btn-outline-professional">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary-professional">
                                    <i class="fas fa-check me-2"></i>Registrar Salida
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Salidas -->
<div class="modal fade" id="verSalidasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #6F4E37, #8B4513);">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-list me-2"></i>Lista de Salidas de Inventario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Filtros -->
                <div class="p-3 bg-light border-bottom">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="filtroProducto" placeholder="🔍 Buscar producto...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filtroTipo">
                                <option value="">Todos los tipos</option>
                                <option value="Fertilizantes">🌱 Fertilizantes</option>
                                <option value="Pesticidas">🐛 Pesticidas</option>
                                <option value="Herramientas">🔧 Herramientas</option>
                                <option value="Equipos">⚙️ Equipos</option>
                                <option value="Otros">📦 Otros</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="filtroFecha" placeholder="Fecha">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary w-100" onclick="limpiarFiltros()">
                                <i class="fas fa-eraser me-1"></i>Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="max-height: 500px;">
                    <table class="table table-hover mb-0" id="tablaSalidas">
                        <thead class="table-dark sticky-top">
                            <tr>
                                <th class="text-center"><i class="fas fa-hashtag me-1"></i>ID</th>
                                <th><i class="fas fa-box me-1"></i>Producto</th>
                                <th class="text-center"><i class="fas fa-layer-group me-1"></i>Tipo</th>
                                <th class="text-center"><i class="fas fa-balance-scale me-1"></i>Cantidad</th>
                                <th class="text-center"><i class="fas fa-ruler me-1"></i>Unidad</th>
                                <th class="text-center"><i class="fas fa-dollar-sign me-1"></i>Precio</th>
                                <th class="text-center"><i class="fas fa-seedling me-1"></i>Lote</th>
                                <th class="text-center"><i class="fas fa-calendar me-1"></i>Fecha</th>
                                <th><i class="fas fa-sticky-note me-1"></i>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTablaSalidas">
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <!-- Estado vacío -->
                <div id="estadoVacio" class="text-center py-5 d-none">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay salidas registradas</h5>
                    <p class="text-muted">Las salidas aparecerán aquí cuando se registren</p>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100">
                    <small class="text-muted align-self-center">
                        <i class="fas fa-info-circle me-1"></i>Total: <span id="totalSalidas">0</span> salidas
                    </small>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Éxito -->
<div class="modal fade" id="modalExitoSalida" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="fw-bold mb-2 text-secondary">¡Salida Registrada!</h5>
                <p class="text-muted mb-3">La salida se registró correctamente.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Volver
                    </a>
                    <button type="button" class="btn btn-sm text-white" style="background: #8B4513;" onclick="window.location.reload()">
                        <i class="fas fa-plus me-1"></i>Nueva Salida
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root { --coffee: #8B4513; --coffee-dark: #6F4E37; }
.form-control:focus, .form-select:focus { border-color: var(--coffee); box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25); }
.btn:hover { transform: translateY(-1px); transition: all 0.2s ease; }
.card { transition: transform 0.2s ease; }
.card:hover { transform: translateY(-2px); }
.table th { font-size: 0.9rem; font-weight: 600; }
.table td { font-size: 0.9rem; }
.sticky-top { position: sticky; top: 0; z-index: 1020; }
</style>
@endpush

@section('scripts')
<script>
$(document).ready(function() {
    // Función para formatear fechas
    function formatearFecha(fecha) {
        if (!fecha) return '--';
        const date = new Date(fecha);
        return date.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    // Función para formatear moneda
    function formatearMoneda(valor) {
        if (!valor || valor === 0) return '$0.00';
        return '$' + parseFloat(valor).toLocaleString('es-ES', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Manejar cambio en la selección de producto
    $('#insumo_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        
        if (selectedOption.val()) {
            // Mostrar información del producto con animación suave
            $('#producto-info').slideDown(300);
            
            // Actualizar información del producto
            $('#info_precio').text(formatearMoneda(selectedOption.data('precio')));
            $('#info_estado').text(selectedOption.data('estado') || '--');
            $('#info_tipo').text(selectedOption.data('tipo') || '--');
            $('#info_disponible').text(
                (selectedOption.data('disponible') || 0) + ' ' + 
                (selectedOption.data('unidad') || '')
            );
            $('#info_unidad').text(selectedOption.data('unidad') || '--');
            $('#info_fecha').text(formatearFecha(selectedOption.data('fecha')));
            
            // Agregar clase de estado para colorear
            const estado = selectedOption.data('estado');
            $('#info_estado').removeClass('text-success text-warning text-danger');
            if (estado === 'Disponible') {
                $('#info_estado').addClass('text-success');
            } else if (estado === 'Agotado') {
                $('#info_estado').addClass('text-danger');
            } else {
                $('#info_estado').addClass('text-warning');
            }
            
            // Llenar campos ocultos
            $('#unidad_medida').val(selectedOption.data('unidad'));
            $('#precio_unitario').val(selectedOption.data('precio'));
            $('#estado').val(selectedOption.data('estado'));
            $('#fecha_registro').val(selectedOption.data('fecha'));
            
            // Configurar cantidad máxima
            const cantidadDisponible = selectedOption.data('disponible');
            $('#cantidad').attr('max', cantidadDisponible);
            $('#cantidad').attr('placeholder', `Máximo: ${cantidadDisponible}`);
            
        } else {
            // Ocultar información del producto
            $('#producto-info').slideUp(300);
            
            // Limpiar campos ocultos
            $('#unidad_medida, #precio_unitario, #estado, #fecha_registro').val('');
            $('#cantidad').removeAttr('max').attr('placeholder', 'Ej: 10.500');
        }
    });

    // Validación en tiempo real de cantidad
    $('#cantidad').on('input', function() {
        const cantidadIngresada = parseFloat($(this).val());
        const cantidadMaxima = parseFloat($(this).attr('max'));
        
        if (cantidadIngresada > cantidadMaxima) {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after(`<div class="invalid-feedback">
                    La cantidad no puede exceder ${cantidadMaxima}
                </div>`);
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    // Manejar envío del formulario
    $('#salidaInventarioForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validaciones adicionales
        const cantidadIngresada = parseFloat($('#cantidad').val());
        const cantidadMaxima = parseFloat($('#cantidad').attr('max'));
        
        if (cantidadIngresada > cantidadMaxima) {
            Swal.fire({
                icon: 'error',
                title: 'Cantidad Inválida',
                text: `La cantidad no puede exceder ${cantidadMaxima}`,
                confirmButtonColor: 'var(--cacao-primary)'
            });
            return;
        }

        // Confirmar acción
        Swal.fire({
            title: '¿Confirmar Salida?',
            text: `Se registrará la salida de ${cantidadIngresada} unidades del producto seleccionado.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'var(--cacao-primary)',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check"></i> Sí, registrar',
            cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
            customClass: {
                popup: 'swal-cafe',
                confirmButton: 'btn-professional',
                cancelButton: 'btn-outline-professional'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                registrarSalida();
            }
        });
    });

    // Función para registrar la salida
    function registrarSalida() {
        const formData = new FormData($('#salidaInventarioForm')[0]);
        
        // Mostrar loading
        Swal.fire({
            title: 'Procesando...',
            text: 'Registrando salida de inventario',
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
                popup: 'swal-cafe'
            },
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('inventario.salida.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Salida de inventario registrada correctamente',
                    confirmButtonColor: 'var(--cacao-primary)',
                    customClass: {
                        popup: 'swal-cafe',
                        confirmButton: 'btn-professional'
                    }
                }).then(() => {
                    // Limpiar formulario
                    $('#salidaInventarioForm')[0].reset();
                    $('#producto-info').slideUp(300);
                    $('#cantidad').removeClass('is-invalid').next('.invalid-feedback').remove();
                    
                    // Opcional: redirigir o actualizar datos
                    // window.location.href = "{{ route('inventario.index') }}";
                });
            },
            error: function(xhr) {
                let errorMessage = 'Error al procesar la solicitud';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonColor: 'var(--cacao-primary)',
                    customClass: {
                        popup: 'swal-cafe',
                        confirmButton: 'btn-professional'
                    }
                });
            }
        });
    }

    // Cuando se seleccione un lote, buscar la producción activa y asignar el produccion_id
    $('#lote_id').on('change', function() {
        const loteId = $(this).val();
        if (loteId) {
            // AJAX para buscar la producción activa de ese lote
            $.get('/api/lotes/' + loteId + '/produccion-activa', function(data) {
                if (data && data.produccion_id) {
                    $('#produccion_id').val(data.produccion_id);
                } else {
                    $('#produccion_id').val('');
                }
            });
        } else {
            $('#produccion_id').val('');
        }
    });

    // Animación de entrada
    $('.fade-in-up').addClass('show');

    // Cargar salidas en modal
    $('#verSalidasModal').on('show.bs.modal', function() {
        cargarSalidas();
    });

    // Filtros de búsqueda
    $('#filtroProducto, #filtroTipo, #filtroFecha').on('input change', function() {
        filtrarSalidas();
    });
});

// Cargar todas las salidas
function cargarSalidas() {
    $('#cuerpoTablaSalidas').html('<tr><td colspan="9" class="text-center py-3"><i class="fas fa-spinner fa-spin me-2"></i>Cargando salidas...</td></tr>');
    
    $.ajax({
        url: '{{ route("salida-inventario.index") }}',
        method: 'GET',
        success: function(salidas) {
            let html = '';
            if (salidas.length > 0) {
                salidas.forEach(function(salida) {
                    const tipoIcon = { 
                        'Fertilizantes': '🌱', 
                        'Pesticidas': '🐛', 
                        'Herramientas': '🔧', 
                        'Equipos': '⚙️' 
                    }[salida.tipo] || '📦';
                    
                    html += `
                        <tr>
                            <td class="text-center fw-bold">${salida.id}</td>
                            <td>${salida.producto_nombre}</td>
                            <td class="text-center">${tipoIcon} ${salida.tipo}</td>
                            <td class="text-center">
                                <span class="badge bg-primary">${salida.cantidad}</span>
                            </td>
                            <td class="text-center">${salida.unidad_medida}</td>
                            <td class="text-center">
                                <span class="badge bg-success">$${salida.precio_unitario}</span>
                            </td>
                            <td class="text-center">${salida.lote_nombre || '<small class="text-muted">Sin lote</small>'}</td>
                            <td class="text-center">
                                <small>${new Date(salida.fecha_salida).toLocaleDateString('es-ES')}</small>
                            </td>
                            <td>
                                <small>${salida.observaciones || '<span class="text-muted">Sin observaciones</span>'}</small>
                            </td>
                        </tr>
                    `;
                });
                $('#estadoVacio').addClass('d-none');
            } else {
                $('#estadoVacio').removeClass('d-none');
            }
            
            $('#cuerpoTablaSalidas').html(html);
            $('#totalSalidas').text(salidas.length);
            window.salidasData = salidas;
        },
        error: function(xhr) {
            console.error('Error al cargar salidas:', xhr);
            $('#cuerpoTablaSalidas').html('<tr><td colspan="9" class="text-center text-danger py-3"><i class="fas fa-exclamation-triangle me-2"></i>Error al cargar las salidas</td></tr>');
        }
    });
}

// Filtrar salidas
function filtrarSalidas() {
    if (!window.salidasData) return;
    
    const filtroProducto = $('#filtroProducto').val().toLowerCase();
    const filtroTipo = $('#filtroTipo').val();
    const filtroFecha = $('#filtroFecha').val();
    
    const salidasFiltradas = window.salidasData.filter(salida => {
        const matchProducto = !filtroProducto || salida.producto_nombre.toLowerCase().includes(filtroProducto);
        const matchTipo = !filtroTipo || salida.tipo === filtroTipo;
        const matchFecha = !filtroFecha || salida.fecha_salida === filtroFecha;
        
        return matchProducto && matchTipo && matchFecha;
    });
    
    let html = '';
    salidasFiltradas.forEach(function(salida) {
        const tipoIcon = { 
            'Fertilizantes': '🌱', 
            'Pesticidas': '🐛', 
            'Herramientas': '🔧', 
            'Equipos': '⚙️' 
        }[salida.tipo] || '📦';
        
        html += `
            <tr>
                <td class="text-center fw-bold">${salida.id}</td>
                <td>${salida.producto_nombre}</td>
                <td class="text-center">${tipoIcon} ${salida.tipo}</td>
                <td class="text-center">
                    <span class="badge bg-primary">${salida.cantidad}</span>
                </td>
                <td class="text-center">${salida.unidad_medida}</td>
                <td class="text-center">
                    <span class="badge bg-success">$${salida.precio_unitario}</span>
                </td>
                <td class="text-center">${salida.lote_nombre || '<small class="text-muted">Sin lote</small>'}</td>
                <td class="text-center">
                    <small>${new Date(salida.fecha_salida).toLocaleDateString('es-ES')}</small>
                </td>
                <td>
                    <small>${salida.observaciones || '<span class="text-muted">Sin observaciones</span>'}</small>
                </td>
            </tr>
        `;
    });
    
    $('#cuerpoTablaSalidas').html(html);
    $('#totalSalidas').text(salidasFiltradas.length);
    
    if (salidasFiltradas.length === 0 && (filtroProducto || filtroTipo || filtroFecha)) {
        $('#cuerpoTablaSalidas').html('<tr><td colspan="9" class="text-center py-4 text-muted"><i class="fas fa-search-minus fa-2x mb-2"></i><br>No se encontraron resultados</td></tr>');
    }
}

// Limpiar filtros
function limpiarFiltros() {
    $('#filtroProducto, #filtroTipo, #filtroFecha').val('');
    filtrarSalidas();
}
</script>
@endsection
