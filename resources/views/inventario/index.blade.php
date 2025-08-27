@extends('layouts.masterr')

@section('content')
<link rel="stylesheet" href="{{ asset('css/inventario/index.css') }}">

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Gestión de Inventario de Insumos</h1>
    </div>

    <!-- Dashboard de Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ count($inventarios ?? []) }}</div>
            <div class="stat-label">Productos Totales</div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-number">{{ collect($inventarios ?? [])->where('estado', 'Óptimo')->count() }}</div>
            <div class="stat-label">Estado Óptimo</div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-number">{{ collect($inventarios ?? [])->where('estado', 'Por vencer')->count() }}</div>
            <div class="stat-label">Por Vencer</div>
        </div>
        <div class="stat-card stat-info">
            <div class="stat-number">${{ number_format(collect($inventarios ?? [])->sum(function($item) { return $item->cantidad * $item->precio_unitario; }), 0, ',', '.') }}</div>
            <div class="stat-label">Valor Total Inventario</div>
        </div>
    </div>

    <!-- Barra de Acciones -->
    <div class="action-bar">
        <div class="action-left">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                Nuevo Producto
            </button>
            <div class="search-box">
                <input type="text" id="searchInput" class="search-input" placeholder="Buscar producto...">
            </div>
        </div>
        <div class="action-right">
            <a href="{{ route('inventario.reporte') }}" class="btn btn-outline">Ver Reportes</a>
            <a href="{{ route('inventario.salida') }}" class="btn btn-outline">Salida Inventario</a>
        </div>
    </div>

    <!-- Tabla Principal -->
    <div class="main-card">
        <div class="card-header">
            <h3 class="card-title">Productos Registrados</h3>
            <span class="product-count" id="totalProductos">{{ count($inventarios ?? []) }}</span>
        </div>
        <div class="table-container">
            <table class="data-table" id="inventoryTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Precio Unit.</th>
                        <th>Valor Total</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($inventarios) && count($inventarios) > 0)
                        @foreach($inventarios as $producto)
                            <tr data-id="{{ $producto->id }}">
                                <td class="id-cell">{{ $producto->id }}</td>
                                <td class="product-cell">
                                    <div class="product-name">{{ $producto->nombre }}</div>
                                    <div class="product-date">Reg: {{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</td>
                                <td class="quantity-cell">{{ number_format($producto->cantidad, 0, ',', '.') }}</td>
                                <td class="unit-cell">{{ $producto->unidad_medida }}</td>
                                <td class="price-cell">${{ number_format($producto->precio_unitario, 0, ',', '.') }}</td>
                                <td class="total-cell">${{ number_format($producto->cantidad * $producto->precio_unitario, 0, ',', '.') }}</td>
                                <td class="type-cell">{{ $producto->tipo }}</td>
                                <td>
                                    @if($producto->estado == 'Óptimo')
                                        <span class="status-badge status-success">Óptimo</span>
                                    @elseif($producto->estado == 'Por vencer')
                                        <span class="status-badge status-warning">Por vencer</span>
                                    @else
                                        <span class="status-badge status-danger">Restringido</span>
                                    @endif
                                </td>
                                <td class="actions-cell">
                                    <button class="btn-action btn-edit edit-producto-btn" data-id="{{ $producto->id }}" title="Editar">
                                        Editar
                                    </button>
                                    <button class="btn-action btn-delete delete-producto-btn" data-id="{{ $producto->id }}" title="Eliminar">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="noProductsRow">
                            <td colspan="10" class="empty-state">
                                <div class="empty-content">
                                    <h4>No hay productos registrados</h4>
                                    <p>Comience creando su primer producto de inventario</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                                        Agregar Primer Producto
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Información de totales -->
    <div class="table-footer">
        <div class="table-info">
            Mostrando <span id="showingCount">{{ count($inventarios ?? []) }}</span> de <span id="totalCount">{{ count($inventarios ?? []) }}</span> productos
        </div>
        <div class="last-update">
            Última actualización: <span id="lastUpdate">{{ date('d/m/Y H:i') }}</span>
        </div>
    </div>
</div>

<!-- Modal Nuevo Producto -->
<div class="modal fade" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="nuevoProductoForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoProductoModalLabel">Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <select class="form-control" id="nombre" name="nombre" required>
                                <option value="">Seleccione un producto...</option>
                                <optgroup label="FERTILIZANTES">
                                    <option value="Urea" data-tipo="Fertilizantes" data-unidad="kg">Urea</option>
                                    <option value="Cloruro de potasio" data-tipo="Fertilizantes" data-unidad="kg">Cloruro de potasio</option>
                                    <option value="Superfosfato triple" data-tipo="Fertilizantes" data-unidad="kg">Superfosfato triple</option>
                                    <option value="Fertilizante NPK 15-15-15" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante NPK 15-15-15</option>
                                    <option value="Fertilizante foliar Masteragro" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante foliar Masteragro</option>
                                    <option value="Compost orgánico" data-tipo="Fertilizantes" data-unidad="kg">Compost orgánico</option>
                                    <option value="Humus de lombriz" data-tipo="Fertilizantes" data-unidad="kg">Humus de lombriz</option>
                                </optgroup>
                                <optgroup label="PESTICIDAS">
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
                        <div class="form-group">
                            <label for="tipo" class="form-label">Tipo de Producto</label>
                            <select class="form-control" id="tipo" name="tipo" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="Fertilizantes">Fertilizantes</option>
                                <option value="Pesticidas">Pesticidas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" max="99999" placeholder="100" required>
                        </div>
                        <div class="form-group">
                            <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                            <select class="form-control" id="unidad_medida" name="unidad_medida" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="kg">Kilogramos (kg)</option>
                                <option value="ml">Mililitros (ml)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="precio_unitario" class="form-label">Precio Unitario</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" min="0" max="999999" step="0.01" placeholder="25,500" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="estado" class="form-label">Estado del Producto</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="Óptimo">Óptimo</option>
                                <option value="Por vencer">Por vencer</option>
                                <option value="Restringido">Restringido</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                            <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editarProductoForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editarProductoModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div id="ajaxResponseEdit"></div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="edit_nombre" class="form-label">Nombre del Producto</label>
                            <select class="form-control" id="edit_nombre" name="nombre" required>
                                <option value="">Seleccione un producto...</option>
                                <optgroup label="FERTILIZANTES">
                                    <option value="Urea" data-tipo="Fertilizantes" data-unidad="kg">Urea</option>
                                    <option value="Cloruro de potasio" data-tipo="Fertilizantes" data-unidad="kg">Cloruro de potasio</option>
                                    <option value="Superfosfato triple" data-tipo="Fertilizantes" data-unidad="kg">Superfosfato triple</option>
                                    <option value="Fertilizante NPK 15-15-15" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante NPK 15-15-15</option>
                                    <option value="Fertilizante foliar Masteragro" data-tipo="Fertilizantes" data-unidad="kg">Fertilizante foliar Masteragro</option>
                                    <option value="Compost orgánico" data-tipo="Fertilizantes" data-unidad="kg">Compost orgánico</option>
                                    <option value="Humus de lombriz" data-tipo="Fertilizantes" data-unidad="kg">Humus de lombriz</option>
                                </optgroup>
                                <optgroup label="PESTICIDAS">
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
                        <div class="form-group">
                            <label for="edit_tipo" class="form-label">Tipo de Producto</label>
                            <select class="form-control" id="edit_tipo" name="tipo" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="Fertilizantes">Fertilizantes</option>
                                <option value="Pesticidas">Pesticidas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="edit_cantidad" name="cantidad" min="1" max="99999" placeholder="100" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_unidad_medida" class="form-label">Unidad de Medida</label>
                            <select class="form-control" id="edit_unidad_medida" name="unidad_medida" required readonly disabled>
                                <option value="">Se asignará automáticamente</option>
                                <option value="kg">Kilogramos (kg)</option>
                                <option value="ml">Mililitros (ml)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_precio_unitario" class="form-label">Precio Unitario</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="edit_precio_unitario" name="precio_unitario" min="0" max="999999" step="0.01" placeholder="25,500" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_estado" class="form-label">Estado del Producto</label>
                            <select class="form-control" id="edit_estado" name="estado" required>
                                <option value="Óptimo">Óptimo</option>
                                <option value="Por vencer">Por vencer</option>
                                <option value="Restringido">Restringido</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_fecha_registro" class="form-label">Fecha de Registro</label>
                            <input type="date" class="form-control" id="edit_fecha_registro" name="fecha_registro" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Eliminar -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5 class="mb-3">¿Está seguro de eliminar este producto?</h5>
                <p class="text-muted mb-4">
                    <strong id="nombreProductoEliminar">Nombre del producto</strong><br>
                    Esta acción no se puede deshacer.
                </p>
                <input type="hidden" id="productoEliminar">
                <div class="alert alert-warning">
                    Se eliminará permanentemente del inventario
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar Producto</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Éxito -->
<div class="modal fade" id="modalExitoInventario" tabindex="-1" aria-labelledby="modalExitoInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-icon mb-4">✓</div>
                <h4 class="mb-3">¡Inventario Actualizado Exitosamente!</h4>
                <p class="text-muted mb-4">El producto ha sido registrado correctamente en el sistema.</p>
                <div class="mt-3">
                    <small class="text-muted">
                        Recargando página en <span id="countdownInventario">3</span> segundos...
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const RUTA_INVENTARIO = "{{ url('/inventario') }}";
</script>

@endsection

@section('scripts')
<script src="{{ asset('js/inventario/index.js') }}"></script>
@endsection
