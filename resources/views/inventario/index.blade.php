@extends('layouts.masterr')

@section('content')
<link rel="stylesheet" href="{{ asset('css/inventario/index.css') }}">

<div class="container-fluid">
    <h1 class="main-title">
        <i class="fas fa-boxes me-2"></i>
        Gestión de Inventario de Insumos
    </h1>

    <!-- Dashboard de Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ count($inventarios ?? []) }}</div>
                        <div class="label">Productos Totales</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ collect($inventarios ?? [])->where('estado', 'Óptimo')->count() }}</div>
                        <div class="label">Estado Óptimo</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">{{ collect($inventarios ?? [])->where('estado', 'Por vencer')->count() }}</div>
                        <div class="label">Por Vencer</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
            <div class="stats-card stats-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="value">${{ number_format(collect($inventarios ?? [])->sum(function($item) { return $item->cantidad * $item->precio_unitario; }), 0, ',', '.') }}</div>
                        <div class="label">Valor Total Inventario</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de Acción y Búsqueda -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-professional btn-crear" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                <i class="fas fa-plus"></i>
                Nuevo Producto
            </button>
            <!-- Búsqueda discreta -->
            <div class="search-container-top">
                <input type="text" id="searchInput" class="form-control search-input-top" placeholder="Buscar producto...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('inventario.reporte') }}" class="btn btn-professional btn-reporte">
                <i class="fas fa-chart-line"></i>
                Ver Reportes
            </a>
            <a href="{{ route('inventario.salida') }}" class="btn btn-professional btn-salida">
                <i class="fas fa-arrow-right"></i>
                Salida Inventario
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="main-layout">
        <!-- Área de Contenido Principal -->
        <div class="content-area">
            <div class="card main-card">
                <div class="card-header card-header-professional">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title-professional">
                            <i class="fas fa-list-alt"></i>
                            Productos Registrados
                            <span class="badge bg-light text-dark ms-2" id="totalProductos">{{ count($inventarios ?? []) }}</span>
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-professional" id="inventoryTable">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i> ID</th>
                                    <th><i class="fas fa-tag me-1"></i> Producto</th>
                                    <th><i class="fas fa-calendar me-1"></i> Fecha</th>
                                    <th><i class="fas fa-weight-hanging me-1"></i> Cantidad</th>
                                    <th><i class="fas fa-ruler me-1"></i> Unidad</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i> Precio Unit.</th>
                                    <th><i class="fas fa-calculator me-1"></i> Valor Total</th>
                                    <th><i class="fas fa-layer-group me-1"></i> Tipo</th>
                                    <th><i class="fas fa-info-circle me-1"></i> Estado</th>
                                    <th><i class="fas fa-cogs me-1"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                        @if(isset($inventarios) && count($inventarios) > 0)
                            @foreach($inventarios as $producto)
                                <tr data-id="{{ $producto->id }}" data-tipo="{{ $producto->tipo }}" data-estado="{{ $producto->estado }}">
                                    <td>
                                        <div class="fw-bold">{{ $producto->id }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $producto->nombre }}</div>
                                        <small class="text-muted">Reg: {{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($producto->fecha_registro)->locale('es')->isoFormat('MMM') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-professional badge-cantidad">
                                            {{ number_format($producto->cantidad, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-professional badge-unidad">
                                            @if($producto->unidad_medida == 'kg')
                                                <i class="fas fa-weight me-1"></i>{{ $producto->unidad_medida }}
                                            @else
                                                <i class="fas fa-flask me-1"></i>{{ $producto->unidad_medida }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-professional badge-precio">
                                            ${{ number_format($producto->precio_unitario, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-professional" style="background-color: var(--info); color: white;">
                                            ${{ number_format($producto->cantidad * $producto->precio_unitario, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold" style="color: var(--cacao-accent);">
                                            @if($producto->tipo == 'Fertilizantes')
                                                <i class="fas fa-seedling me-1"></i>{{ $producto->tipo }}
                                            @else
                                                <i class="fas fa-shield-alt me-1"></i>{{ $producto->tipo }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($producto->estado == 'Óptimo')
                                            <span class="badge badge-professional badge-optimo">
                                                <i class="fas fa-check-circle me-1"></i>Óptimo
                                            </span>
                                        @elseif($producto->estado == 'Por vencer')
                                            <span class="badge badge-professional badge-vencer">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Por vencer
                                            </span>
                                        @else
                                            <span class="badge badge-professional badge-restringido">
                                                <i class="fas fa-times-circle me-1"></i>Restringido
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-action btn-edit edit-producto-btn" data-id="{{ $producto->id }}" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-action btn-delete delete-producto-btn" data-id="{{ $producto->id }}" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr id="noProductsRow">
                                <td colspan="10" class="text-center py-5">
                                    <div class="no-results">
                                        <i class="fas fa-boxes fa-3x mb-3"></i>
                                        <h5>No hay productos registrados</h5>
                                        <p>Comience creando su primer producto de inventario</p>
                                        <button class="btn btn-professional btn-crear" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                                            <i class="fas fa-plus me-2"></i>Agregar Primer Producto
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Información de totales -->
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Mostrando <span id="showingCount">{{ count($inventarios ?? []) }}</span> de <span id="totalCount">{{ count($inventarios ?? []) }}</span> productos
        </small>
        <small class="text-muted">
            <i class="fas fa-sync-alt me-1"></i>
            Última actualización: <span id="lastUpdate">{{ date('d/m/Y H:i') }}</span>
        </small>
    </div>
</div>

<!-- Nuevo Producto Modal -->
<div class="modal fade" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <form id="nuevoProductoForm">
                @csrf
                <div class="modal-header modal-header-professional">
                    <h5 class="modal-title fw-bold" id="nuevoProductoModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Agregar Nuevo Producto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nombre del Producto
                            </label>
                            <select class="form-select form-select-professional" id="nombre" name="nombre" required>
                                <option value="">Seleccione un producto...</option>
                                <optgroup label="🌱 FERTILIZANTES">
                                    <option value="Urea" data-tipo="Fertilizantes" data-unidad="kg">Urea</option>
                                    <option value="Cloruro de potasio" data-tipo="Fertilizantes" data-unidad="kg">Cloruro de potasio</option>
                                    <option value="Superfosfato triple" data-tipo="Fertilizantes" data-unidad="kg">Superfosfato triple</option>
                                    <option value="Fertilizante NPK 15-15-15" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante NPK 15-15-15</option>
                                    <option value="Fertilizante foliar Masteragro" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante foliar Masteragro</option>
                                    <option value="Compost orgánico" data-tipo="Fertilizantes" data-unidad="kg">Compost orgánico</option>
                                    <option value="Humus de lombriz" data-tipo="Fertilizantes" data-unidad="kg">Humus de lombriz</option>
                                </optgroup>
                                <optgroup label="�️ PESTICIDAS">
                                    <option value="Clorpirifos" data-tipo="Pesticidas" data-unidad="ml">Clorpirifos</option>
                                    <option value="Mancozeb" data-tipo="Pesticidas" data-unidad="ml">Mancozeb</option>
                                    <option value="Cobre" data-tipo="Pesticidas" data-unidad="ml">Cobre</option>
                                    <option value="Imidacloprid" data-tipo="Pesticidas" data-unidad="ml">Imidacloprid</option>
                                    <option value="Cipermetrina" data-tipo="Pesticidas" data-unidad="ml">Cipermetrina</option>
                                    <option value="Glifosato" data-tipo="Pesticidas" data-unidad="ml">Glifosato</option>
                                    <option value="Bacillus thuringiensis" data-tipo="Pesticidas" data-unidad="ml">Bacillus thuringiensis</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">
                                <i class="fas fa-layer-group me-2"></i>Tipo de Producto
                            </label>
                            <select class="form-select form-select-professional" id="tipo" name="tipo" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="Fertilizantes">🌱 Fertilizantes</option>
                                <option value="Pesticidas">�️ Pesticidas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="cantidad" class="form-label">
                                <i class="fas fa-weight-hanging me-2"></i>Cantidad
                            </label>
                            <input type="number" class="form-control form-control-professional" id="cantidad" name="cantidad" min="1" max="99999" placeholder="100" required>
                        </div>
                        <div class="col-md-4">
                            <label for="unidad_medida" class="form-label">
                                <i class="fas fa-ruler me-2"></i>Unidad de Medida
                            </label>
                            <select class="form-select form-select-professional" id="unidad_medida" name="unidad_medida" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="kg">⚖️ Kilogramos (kg)</option>
                                <option value="ml">🧪 Mililitros (ml)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="precio_unitario" class="form-label">
                                <i class="fas fa-dollar-sign me-2"></i>Precio Unitario
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control form-control-professional" id="precio_unitario" name="precio_unitario" min="0" max="999999" step="0.01" placeholder="25,500" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Estado del Producto
                            </label>
                            <select class="form-select form-select-professional" id="estado" name="estado" required>
                                <option value="Óptimo">✅ Óptimo</option>
                                <option value="Por vencer">⚠️ Por vencer</option>
                                <option value="Restringido">🔒 Restringido</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_registro" class="form-label">
                                <i class="fas fa-calendar me-2"></i>Fecha de Registro
                            </label>
                            <input type="date" class="form-control form-control-professional" id="fecha_registro" name="fecha_registro" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-professional">
                    <button type="button" class="btn btn-professional btn-secondary-professional" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-professional btn-primary-professional">
                        <i class="fas fa-save me-2"></i>Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Editar Producto Modal -->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <form id="editarProductoForm">
                @csrf
                @method('PUT')
                <div class="modal-header modal-header-professional">
                    <h5 class="modal-title fw-bold" id="editarProductoModalLabel">
                        <i class="fas fa-edit me-2"></i>Editar Producto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <input type="hidden" id="edit_id" name="id">
                    <div id="ajaxResponseEdit"></div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="edit_nombre" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nombre del Producto
                            </label>
                            <select class="form-select form-select-professional" id="edit_nombre" name="nombre" required>
                                <option value="">Seleccione un producto...</option>
                                <optgroup label="🌱 FERTILIZANTES">
                                    <option value="Urea" data-tipo="Fertilizantes" data-unidad="kg">Urea</option>
                                    <option value="Cloruro de potasio" data-tipo="Fertilizantes" data-unidad="kg">Cloruro de potasio</option>
                                    <option value="Superfosfato triple" data-tipo="Fertilizantes" data-unidad="kg">Superfosfato triple</option>
                                    <option value="Fertilizante NPK 15-15-15" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante NPK 15-15-15</option>
                                    <option value="Fertilizante foliar Masteragro" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante foliar Masteragro</option>
                                    <option value="Compost orgánico" data-tipo="Fertilizantes" data-unidad="kg">Compost orgánico</option>
                                    <option value="Humus de lombriz" data-tipo="Fertilizantes" data-unidad="kg">Humus de lombriz</option>
                                </optgroup>
                                <optgroup label="�️ PESTICIDAS">
                                    <option value="Clorpirifos" data-tipo="Pesticidas" data-unidad="ml">Clorpirifos</option>
                                    <option value="Mancozeb" data-tipo="Pesticidas" data-unidad="ml">Mancozeb</option>
                                    <option value="Cobre" data-tipo="Pesticidas" data-unidad="ml">Cobre</option>
                                    <option value="Imidacloprid" data-tipo="Pesticidas" data-unidad="ml">Imidacloprid</option>
                                    <option value="Cipermetrina" data-tipo="Pesticidas" data-unidad="ml">Cipermetrina</option>
                                    <option value="Glifosato" data-tipo="Pesticidas" data-unidad="ml">Glifosato</option>
                                    <option value="Bacillus thuringiensis" data-tipo="Pesticidas" data-unidad="ml">Bacillus thuringiensis</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_tipo" class="form-label">
                                <i class="fas fa-layer-group me-2"></i>Tipo de Producto
                            </label>
                            <select class="form-select form-select-professional" id="edit_tipo" name="tipo" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="Fertilizantes">🌱 Fertilizantes</option>
                                <option value="Pesticidas">�️ Pesticidas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_cantidad" class="form-label">
                                <i class="fas fa-weight-hanging me-2"></i>Cantidad
                            </label>
                            <input type="number" class="form-control form-control-professional" id="edit_cantidad" name="cantidad" min="1" max="99999" placeholder="100" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_unidad_medida" class="form-label">
                                <i class="fas fa-ruler me-2"></i>Unidad de Medida
                            </label>
                            <select class="form-select form-select-professional" id="edit_unidad_medida" name="unidad_medida" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="kg">⚖️ Kilogramos (kg)</option>
                                <option value="ml">🧪 Mililitros (ml)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_precio_unitario" class="form-label">
                                <i class="fas fa-dollar-sign me-2"></i>Precio Unitario
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control form-control-professional" id="edit_precio_unitario" name="precio_unitario" min="0" max="999999" step="0.01" placeholder="25,500" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_estado" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Estado del Producto
                            </label>
                            <select class="form-select form-select-professional" id="edit_estado" name="estado" required>
                                <option value="Óptimo">✅ Óptimo</option>
                                <option value="Por vencer">⚠️ Por vencer</option>
                                <option value="Restringido">🔒 Restringido</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fecha_registro" class="form-label">
                                <i class="fas fa-calendar me-2"></i>Fecha de Registro
                            </label>
                            <input type="date" class="form-control form-control-professional" id="edit_fecha_registro" name="fecha_registro" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-professional">
                    <button type="button" class="btn btn-professional btn-secondary-professional" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-professional btn-primary-professional">
                        <i class="fas fa-save me-2"></i>Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lista de Inventario Modal (CRUD) -->
<div class="modal fade" id="listaInventarioModal" tabindex="-1" aria-labelledby="listaInventarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-brown text-white border-0">
                <h5 class="modal-title fw-bold" id="listaInventarioModalLabel">
                    <i class="fas fa-clipboard-list me-2"></i>Lista Completa de Inventario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body bg-light p-0">
                <div class="p-3 bg-white border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-0 text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Gestión completa del inventario - Editar y eliminar productos
                            </h6>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                                <i class="fas fa-plus me-1"></i>Nuevo Producto
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle" id="tablaListaInventario">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-hashtag me-1"></i>ID
                                </th>
                                <th class="fw-bold">
                                    <i class="fas fa-tag me-1"></i>Producto
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-layer-group me-1"></i>Tipo
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-weight-hanging me-1"></i>Cantidad
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-ruler me-1"></i>Unidad
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-dollar-sign me-1"></i>Precio
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-calendar me-1"></i>Fecha
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-info-circle me-1"></i>Estado
                                </th>
                                <th class="text-center fw-bold">
                                    <i class="fas fa-cogs me-1"></i>Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider bg-white">
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="emptyInventoryState" class="text-center py-5 d-none">
                    <div class="mb-3">
                        <i class="fas fa-box-open fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No hay productos en el inventario</h5>
                    <p class="text-muted">Agregue productos para comenzar a gestionar el inventario</p>
                </div>
            </div>
            <div class="modal-footer bg-brown border-0">
                <button type="button" class="btn btn-light shadow-sm btn-lg" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Eliminar -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <div class="modal-header modal-header-professional" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <h5 class="modal-title fw-bold" id="confirmarEliminarModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="padding: 2rem;">
                <div class="mb-3">
                    <i class="fas fa-trash-alt fa-3x" style="color: #dc3545;"></i>
                </div>
                <h5 class="mb-3" style="color: var(--cacao-primary);">¿Está seguro de eliminar este producto?</h5>
                <p class="text-muted mb-4">
                    <strong id="nombreProductoEliminar">Nombre del producto</strong><br>
                    Esta acción no se puede deshacer.
                </p>
                <input type="hidden" id="productoEliminar">
                <div class="alert alert-warning" style="background: #fff3cd; border: none; border-left: 4px solid #ffc107;">
                    <i class="fas fa-info-circle me-2"></i>
                    Se eliminará permanentemente del inventario
                </div>
            </div>
            <div class="modal-footer modal-footer-professional">
                <button type="button" class="btn btn-professional btn-secondary-professional" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-professional" id="confirmarEliminarBtn" style="background-color: #dc3545; color: white; border: none;">
                    <i class="fas fa-trash me-2"></i>Eliminar Producto
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Éxito para Inventario Creado -->
<div class="modal fade" id="modalExitoInventario" tabindex="-1" aria-labelledby="modalExitoInventarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-content-professional" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
      <div class="modal-body text-center p-5" style="position: relative;">
        <!-- Decoración de fondo -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 30% 20%, rgba(111, 78, 55, 0.1) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(139, 69, 19, 0.1) 0%, transparent 50%); z-index: 1; border-radius: 8px;"></div>

        <!-- Contenido -->
        <div class="position-relative" style="z-index: 2;">
          <!-- Icono principal animado -->
          <div class="mb-4" style="animation: successBounce 1s ease-out;">
            <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--cacao-primary), var(--cacao-secondary)); border-radius: 50%; box-shadow: 0 10px 25px rgba(111, 78, 55, 0.4);">
              <i class="fas fa-check text-white" style="font-size: 2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
            </div>
          </div>

          <!-- Título -->
          <h4 class="fw-bold mb-3" style="color: var(--cacao-primary); animation: fadeInUp 0.8s ease-out 0.2s both;">
            ¡Inventario Actualizado Exitosamente!
          </h4>

          <!-- Descripción -->
          <p class="text-muted mb-4" style="font-size: 1.1rem; animation: fadeInUp 0.8s ease-out 0.4s both;">
            El producto ha sido registrado correctamente en el sistema.
          </p>

          <!-- Icono decorativo -->
          <div style="animation: fadeInUp 0.8s ease-out 0.6s both;">
            <i class="fas fa-boxes" style="font-size: 2.5rem; color: var(--cacao-accent);"></i>
          </div>

          <!-- Contador automático -->
          <div class="mt-3" style="animation: fadeInUp 0.8s ease-out 0.8s both;">
            <small class="text-muted">
              <i class="fas fa-clock me-1"></i>
              Recargando página en <span id="countdownInventario">3</span> segundos...
            </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Success Notification Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content modal-content-professional">
            <div class="modal-header modal-header-professional" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); text-align: center;">
                <div class="w-100">
                    <div class="mb-2">
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                    <h5 class="modal-title fw-bold" id="successModalLabel">¡Operación Exitosa!</h5>
                </div>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-0 text-muted" id="successMessage">La operación se completó correctamente.</p>
            </div>
        </div>
    </div>
</div>
<script>
    const RUTA_INVENTARIO = "{{ url('/inventario') }}";
</script>

@endsection

@push('styles')


@endpush

@section('scripts')
<script src="{{ asset('js/inventario/index.js') }}"></script>
@endsection
