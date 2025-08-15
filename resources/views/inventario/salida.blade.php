@extends('layouts.masterr')

@section('content')

<link rel="stylesheet" href="{{ asset('css/inventario/salida.css') }}">
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
                          <input type="hidden" name="produccion_id" id="produccion_id">

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
<div class="modal fade" id="verSalidasModal" tabindex="-1" aria-labelledby="verSalidasModalLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #6F4E37, #8B4513);">
                <h5 class="modal-title fw-bold" id="verSalidasModalLabel">
                    <i class="fas fa-list me-2"></i>Lista de Salidas de Inventario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar modal"></button>
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
                                <option value="Equipos">⚙ Equipos</option>
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
<div class="modal fade" id="modalExitoSalida" tabindex="-1" aria-labelledby="modalExitoSalidaLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="fw-bold mb-2 text-secondary" id="modalExitoSalidaLabel">¡Salida Registrada!</h5>
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
    // Variables globales para JavaScript
    window.inventarioRoutes = {
        salidaStore: "{{ route('inventario.salida.store') }}",
        salidaIndex: "{{ route('salida-inventario.index') }}",
        inventarioIndex: "{{ route('inventario.index') }}"
    };
    console.log('Rutas cargadas:', window.inventarioRoutes);
</script>
<script src="{{ asset('js/inventario/salida.js') }}?v={{ time() }}"></script>
@endsection
