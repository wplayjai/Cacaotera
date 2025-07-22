@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <!-- Content Header con estilo café -->
    <div class="content-header" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); color: white; padding: 2rem 0; margin-bottom: 2rem; border-radius: 0 0 25px 25px;">
        <div class="container-fluid">
            <div class="row align-items-center py-3">
                <div class="col-sm-6">
                    <h1 class="h3 mb-0 text-white fw-bold">
                        <i class="fas fa-boxes me-3" style="font-size: 1.5rem;"></i>Inventario de Productos
                    </h1>
                    <p class="mb-0 mt-2" style="opacity: 0.9;">Gestión completa de fertilizantes y pesticidas</p>
                </div>
                <div class="col-sm-6 text-end">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <div class="text-center">
                            <div class="badge bg-light text-dark fs-6 px-3 py-2" style="border-radius: 15px;">
                                <i class="fas fa-cube me-1"></i>
                                <span id="totalProductos">{{ count($inventarios ?? []) }}</span> Productos
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="ajaxResponse"></div>

            <!-- Header con botones de acción estilo lotes -->
            <div class="row">
                <div class="col-12">
                    <!-- Header con estilo lotes -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-list me-2" style="color: #6F4E37; font-size: 1.5rem;"></i>
                            <h4 class="mb-0 fw-bold" style="color: #6F4E37;">Inventario de Productos Registrados</h4>
                            <span class="badge bg-secondary ms-3" style="background: #6F4E37 !important;">
                                {{ count($inventarios ?? []) }}
                            </span>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Buscador con estilo café -->
                            <div class="input-group" style="max-width: 300px;">
                                <input type="text" id="searchInput" name="table_search" class="form-control" 
                                       placeholder="Buscar producto..." 
                                       style="border: 2px solid #6F4E37; border-radius: 10px 0 0 10px; padding: 12px 16px; font-weight: 500;">
                                <button class="btn" type="button" id="searchBtn" 
                                        style="background: #6F4E37; color: white; border: 2px solid #6F4E37; border-radius: 0 10px 10px 0; padding: 12px 16px;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <!-- Botón Nuevo Producto -->
                            <button class="btn" style="background: #6F4E37; color: white; border: 2px solid #6F4E37;" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                                <i class="fas fa-plus me-2"></i>Nuevo Producto
                            </button>
                            <!-- Botón Salida Inventario -->
                            <a href="{{ route('inventario.salida') }}" class="btn" style="background: #8B4513; color: white; border: 2px solid #8B4513;">
                                <i class="fas fa-arrow-right me-2"></i>Salida Inventario
                            </a>
                        </div>
                    </div>

                    <!-- Tabla estilo lotes -->
                    <div class="table-responsive" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <table class="table table-hover mb-0" id="inventoryTable">
                            <!-- Header café como en lotes -->
                            <thead style="background: linear-gradient(135deg, #6F4E37 0%, #5D4037 100%); color: white;">
                                <tr>
                                    <th class="text-center fw-bold" style="padding: 1rem 0.8rem;">
                                        <i class="fas fa-tag me-2"></i>Nombre
                                    </th>
                                    <th class="text-center fw-bold" style="padding: 1rem 0.8rem;">
                                        <i class="fas fa-calendar me-2"></i>Fecha Registro
                                    </th>
                                    <th class="text-center fw-bold" style="padding: 1rem 0.8rem;">
                                        <i class="fas fa-weight-hanging me-2"></i>Cantidad
                                    </th>
                                    <th class="text-center fw-bold" style="padding: 1rem 0.8rem;">
                                        <i class="fas fa-dollar-sign me-2"></i>Precio
                                    </th>
                                    <th class="text-center fw-bold" style="padding: 1rem 0.8rem;">
                                        <i class="fas fa-layer-group me-2"></i>Tipo
                                    </th>
                                    <th class="text-center fw-bold" style="padding: 1rem 0.8rem;">
                                        <i class="fas fa-info-circle me-2"></i>Estado
                                    </th>
                                    <th class="text-center fw-bold" style="padding: 1rem 0.8rem;">
                                        <i class="fas fa-eye me-2"></i>Unidad
                                    </th>
                                    <th class="text-center fw-bold" style="padding: 1rem 0.8rem;">
                                        <i class="fas fa-cogs me-2"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($inventarios) && count($inventarios) > 0)
                                    @foreach($inventarios as $producto)
                                        <tr class="align-middle" style="background: white; transition: all 0.3s ease;" data-id="{{ $producto->id }}">
                                            <td class="text-center fw-medium" style="color: #6F4E37;">
                                                {{ $producto->nombre }}
                                            </td>
                                            <td class="text-center">
                                                {{ date('d/m/Y', strtotime($producto->fecha_registro)) }}
                                                <br><small class="text-muted">{{ date('M. Y', strtotime($producto->fecha_registro)) }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge text-white px-3 py-2" style="background: #007bff; border-radius: 25px;">
                                                    {{ number_format($producto->cantidad) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge text-white px-3 py-2" style="background: #28a745; border-radius: 25px;">
                                                    COP ${{ number_format($producto->precio_unitario, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    @if($producto->tipo == 'Fertilizantes')
                                                        🌱
                                                    @else
                                                        🐛
                                                    @endif
                                                    <span class="ms-2">{{ $producto->tipo }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($producto->estado == 'Óptimo')
                                                    <span class="badge bg-success text-white px-3 py-2" style="border-radius: 25px;">
                                                        <i class="fas fa-check-circle me-1"></i>ÓPTIMO
                                                    </span>
                                                @elseif($producto->estado == 'Por vencer')
                                                    <span class="badge bg-warning text-white px-3 py-2" style="border-radius: 25px;">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>POR VENCER
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger text-white px-3 py-2" style="border-radius: 25px;">
                                                        <i class="fas fa-times-circle me-1"></i>RESTRINGIDO
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary text-white px-3 py-2" style="border-radius: 25px;">
                                                    @if($producto->unidad_medida == 'kg')
                                                        ⚖️ {{ $producto->unidad_medida }}
                                                    @else
                                                        🧪 {{ $producto->unidad_medida }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-warning btn-sm edit-producto-btn" data-id="{{ $producto->id }}" title="Editar">
                                                        <i class="fas fa-edit"></i>Editar
                                                    </button>
                                                    <button class="btn btn-danger btn-sm delete-producto-btn" data-id="{{ $producto->id }}" title="Eliminar">
                                                        <i class="fas fa-trash"></i>Eliminar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="mb-3">
                                                <i class="fas fa-box-open fa-3x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted">No hay productos registrados</h5>
                                            <p class="text-muted">Comience agregando su primer producto al inventario</p>
                                            <button class="btn" style="background: #6F4E37; color: white;" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                                                <i class="fas fa-plus me-2"></i>Agregar Primer Producto
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer información -->
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="fas fa-sync-alt me-1"></i>
                            Última actualización: <span id="lastUpdate">{{ date('d/m/Y H:i') }}</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Nuevo Producto Modal -->
<div class="modal fade modal-cafe" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; background: linear-gradient(135deg, #f8f5f0 0%, #ffffff 100%);">
            <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); padding: 1.5rem;">
                <h5 class="modal-title fw-bold" id="nuevoProductoModalLabel" style="font-size: 1.3rem;">
                    <i class="fas fa-plus-circle me-2" style="color: #D7CCC8;"></i>Agregar Nuevo Producto al Inventario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: brightness(0) invert(1);"></button>
            </div>
            <form id="nuevoProductoForm">
                @csrf
                <div class="modal-body p-4" style="background: linear-gradient(135deg, #f8f5f0 0%, #ffffff 100%);">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-tag me-2" style="color: #8B4513;"></i>Nombre del Producto
                            </label>
                            <select class="form-select shadow-sm" id="nombre" name="nombre" required 
                                    style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                                <option value="" style="color: #999;">Seleccione un producto...</option>
                                <optgroup label="🌱 FERTILIZANTES" class="fw-bold" style="color: #28a745;">
                                    <option value="Urea" data-tipo="Fertilizantes" data-unidad="kg">🟢 Urea</option>
                                    <option value="Cloruro de potasio" data-tipo="Fertilizantes" data-unidad="kg">🟢 Cloruro de potasio</option>
                                    <option value="Superfosfato triple" data-tipo="Fertilizantes" data-unidad="kg">🟢 Superfosfato triple</option>
                                    <option value="Fertilizante NPK 15-15-15" data-tipo="Fertilizantes" data-unidad="kg">🟢 Fertilizante NPK 15-15-15</option>
                                    <option value="Fertilizante foliar Masteragro" data-tipo="Fertilizantes" data-unidad="kg">🟢 Fertilizante foliar Masteragro</option>
                                    <option value="Compost orgánico" data-tipo="Fertilizantes" data-unidad="kg">🟢 Compost orgánico</option>
                                    <option value="Humus de lombriz" data-tipo="Fertilizantes" data-unidad="kg">🟢 Humus de lombriz</option>
                                </optgroup>
                                <optgroup label="🐛 PESTICIDAS" class="fw-bold" style="color: #dc3545;">
                                    <option value="Clorpirifos" data-tipo="Pesticidas" data-unidad="ml">🔴 Clorpirifos</option>
                                    <option value="Mancozeb" data-tipo="Pesticidas" data-unidad="ml">🔴 Mancozeb</option>
                                    <option value="Cobre" data-tipo="Pesticidas" data-unidad="ml">🔴 Cobre</option>
                                    <option value="Imidacloprid" data-tipo="Pesticidas" data-unidad="ml">🔴 Imidacloprid</option>
                                    <option value="Cipermetrina" data-tipo="Pesticidas" data-unidad="ml">🔴 Cipermetrina</option>
                                    <option value="Glifosato" data-tipo="Pesticidas" data-unidad="ml">🔴 Glifosato</option>
                                    <option value="Bacillus thuringiensis" data-tipo="Pesticidas" data-unidad="ml">🔴 Bacillus thuringiensis</option>
                                </optgroup>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-lightbulb me-1"></i>Los productos están organizados por categoría
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label for="tipo" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-layer-group me-2" style="color: #8B4513;"></i>Tipo de Producto
                            </label>
                            <select class="form-select shadow-sm" id="tipo" name="tipo" required readonly disabled
                                    style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: #f8f9fa; color: #6c757d; font-weight: 500; cursor: not-allowed; pointer-events: none;">
                                <option value="">Se asignará automáticamente</option>
                                <option value="Fertilizantes">🌱 Fertilizantes</option>
                                <option value="Pesticidas">🐛 Pesticidas</option>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Se selecciona automáticamente según el producto
                            </small>
                        </div>

                        <div class="col-md-4">
                            <label for="cantidad" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-weight-hanging me-2" style="color: #8B4513;"></i>Cantidad
                            </label>
                            <input type="number" class="form-control shadow-sm" id="cantidad" name="cantidad" min="1" max="99999" placeholder="100" required
                                   style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                            <small class="form-text text-muted">Máximo 5 dígitos</small>
                        </div>

                        <div class="col-md-4">
                            <label for="unidad_medida" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-ruler me-2" style="color: #8B4513;"></i>Unidad de Medida
                            </label>
                            <select class="form-select shadow-sm" id="unidad_medida" name="unidad_medida" required readonly disabled
                                    style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: #f8f9fa; color: #6c757d; font-weight: 500; cursor: not-allowed; pointer-events: none;">
                                <option value="">Se asignará automáticamente</option>
                                <option value="kg">⚖️ Kilogramos (kg)</option>
                                <option value="ml">🧪 Mililitros (ml)</option>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Fertilizantes: kg, Pesticidas: ml
                            </small>
                        </div>

                        <div class="col-md-4">
                            <label for="precio_unitario" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-dollar-sign me-2" style="color: #8B4513;"></i>Precio Unitario
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text text-white" style="background: linear-gradient(135deg, #6F4E37, #8B4513); border: 2px solid #D7CCC8; border-right: none;">COP $</span>
                                <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" min="0" max="999999" step="0.01" placeholder="25,500" required
                                       style="border: 2px solid #D7CCC8; border-left: none; border-radius: 0 10px 10px 0; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Precio máximo 6 dígitos (COP)
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label for="estado" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-info-circle me-2" style="color: #8B4513;"></i>Estado del Producto
                            </label>
                            <select class="form-select shadow-sm" id="estado" name="estado" required
                                    style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                                <option value="Óptimo" style="color: #28a745;">✅ Óptimo</option>
                                <option value="Por vencer" style="color: #ffc107;">⚠️ Por vencer</option>
                                <option value="Restringido" style="color: #dc3545;">🔒 Restringido</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_registro" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-calendar me-2" style="color: #8B4513;"></i>Fecha de Registro
                            </label>
                            <input type="date" class="form-control shadow-sm" id="fecha_registro" name="fecha_registro" value="2025-07-20" required
                                   style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4" style="background: linear-gradient(135deg, #f8f5f0 0%, #ffffff 100%);">
                    <button type="button" class="btn btn-lg shadow-sm" data-bs-dismiss="modal" 
                            style="background: #6c757d; color: white; border-radius: 50px; padding: 12px 30px; font-weight: 600; border: none;">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-lg shadow-sm" 
                            style="background: linear-gradient(135deg, #6F4E37, #8B4513); color: white; border-radius: 50px; padding: 12px 30px; font-weight: 600; border: none;">
                        <i class="fas fa-save me-2"></i>Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Editar Producto Modal -->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; background: linear-gradient(135deg, #f8f5f0 0%, #ffffff 100%);">
            <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%); padding: 1.5rem;">
                <h5 class="modal-title fw-bold" id="editarProductoModalLabel" style="font-size: 1.3rem;">
                    <i class="fas fa-edit me-2" style="color: #D7CCC8;"></i>Editar Producto del Inventario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: brightness(0) invert(1);"></button>
            </div>
            <form id="editarProductoForm">
                @csrf
                @method('PUT')
                <div class="modal-body p-4" style="background: linear-gradient(135deg, #f8f5f0 0%, #ffffff 100%);">
                    <input type="hidden" id="edit_id" name="id">
                    <div id="ajaxResponseEdit"></div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="edit_nombre" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-tag me-2" style="color: #8B4513;"></i>Nombre del Producto
                            </label>
                            <select class="form-select shadow-sm" id="edit_nombre" name="nombre" required 
                                    style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                                <option value="">Seleccione un producto...</option>
                                <optgroup label="🌱 FERTILIZANTES" class="fw-bold" style="color: #28a745;">
                                    <option value="Urea" data-tipo="Fertilizantes" data-unidad="kg">🟢 Urea</option>
                                    <option value="Cloruro de potasio" data-tipo="Fertilizantes" data-unidad="kg">🟢 Cloruro de potasio</option>
                                    <option value="Superfosfato triple" data-tipo="Fertilizantes" data-unidad="kg">🟢 Superfosfato triple</option>
                                    <option value="Fertilizante NPK 15-15-15" data-tipo="Fertilizantes" data-unidad="kg">🟢 Fertilizante NPK 15-15-15</option>
                                    <option value="Fertilizante foliar Masteragro" data-tipo="Fertilizantes" data-unidad="kg">🟢 Fertilizante foliar Masteragro</option>
                                    <option value="Compost orgánico" data-tipo="Fertilizantes" data-unidad="kg">🟢 Compost orgánico</option>
                                    <option value="Humus de lombriz" data-tipo="Fertilizantes" data-unidad="kg">🟢 Humus de lombriz</option>
                                </optgroup>
                                <optgroup label="🐛 PESTICIDAS" class="fw-bold" style="color: #dc3545;">
                                    <option value="Clorpirifos" data-tipo="Pesticidas" data-unidad="ml">🔴 Clorpirifos</option>
                                    <option value="Mancozeb" data-tipo="Pesticidas" data-unidad="ml">🔴 Mancozeb</option>
                                    <option value="Cobre" data-tipo="Pesticidas" data-unidad="ml">🔴 Cobre</option>
                                    <option value="Imidacloprid" data-tipo="Pesticidas" data-unidad="ml">🔴 Imidacloprid</option>
                                    <option value="Cipermetrina" data-tipo="Pesticidas" data-unidad="ml">🔴 Cipermetrina</option>
                                    <option value="Glifosato" data-tipo="Pesticidas" data-unidad="ml">🔴 Glifosato</option>
                                    <option value="Bacillus thuringiensis" data-tipo="Pesticidas" data-unidad="ml">🔴 Bacillus thuringiensis</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_tipo" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-layer-group me-2" style="color: #8B4513;"></i>Tipo de Producto
                            </label>
                            <select class="form-select shadow-sm" id="edit_tipo" name="tipo" required readonly disabled
                                    style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: #f8f9fa; color: #6c757d; font-weight: 500; cursor: not-allowed; pointer-events: none;">
                                <option value="">Se asignará automáticamente</option>
                                <option value="Fertilizantes">🌱 Fertilizantes</option>
                                <option value="Pesticidas">🐛 Pesticidas</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="edit_cantidad" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-weight-hanging me-2" style="color: #8B4513;"></i>Cantidad
                            </label>
                            <input type="number" class="form-control shadow-sm" id="edit_cantidad" name="cantidad" 
                                   min="1" max="99999" placeholder="100" required
                                   style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                            <small class="form-text text-muted">Máximo 5 dígitos</small>
                        </div>

                        <div class="col-md-4">
                            <label for="edit_unidad_medida" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-ruler me-2" style="color: #8B4513;"></i>Unidad de Medida
                            </label>
                            <select class="form-select shadow-sm" id="edit_unidad_medida" name="unidad_medida" required readonly disabled
                                    style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: #f8f9fa; color: #6c757d; font-weight: 500; cursor: not-allowed; pointer-events: none;">
                                <option value="">Se asignará automáticamente</option>
                                <option value="kg">⚖️ Kilogramos (kg)</option>
                                <option value="ml">🧪 Mililitros (ml)</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="edit_precio_unitario" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-dollar-sign me-2" style="color: #8B4513;"></i>Precio Unitario
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text text-white" style="background: linear-gradient(135deg, #6F4E37, #8B4513); border: 2px solid #D7CCC8; border-right: none;">COP $</span>
                                <input type="number" class="form-control" id="edit_precio_unitario" name="precio_unitario" 
                                       min="0" max="999999" step="0.01" placeholder="25,500" required
                                       style="border: 2px solid #D7CCC8; border-left: none; border-radius: 0 10px 10px 0; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                            </div>
                            <small class="form-text text-muted">Precio máximo 6 dígitos</small>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_estado" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-info-circle me-2" style="color: #8B4513;"></i>Estado del Producto
                            </label>
                            <select class="form-select shadow-sm" id="edit_estado" name="estado" required
                                    style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                                <option value="Óptimo">✅ Óptimo</option>
                                <option value="Por vencer">⚠️ Por vencer</option>
                                <option value="Restringido">🔒 Restringido</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_fecha_registro" class="form-label fw-bold" style="color: #6F4E37; font-size: 0.95rem;">
                                <i class="fas fa-calendar me-2" style="color: #8B4513;"></i>Fecha de Registro
                            </label>
                            <input type="date" class="form-control shadow-sm" id="edit_fecha_registro" name="fecha_registro" required
                                   style="border: 2px solid #D7CCC8; border-radius: 10px; padding: 12px; background: white; color: #6F4E37; font-weight: 500;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4" style="background: linear-gradient(135deg, #f8f5f0 0%, #ffffff 100%);">
                    <button type="button" class="btn btn-lg shadow-sm" data-bs-dismiss="modal" 
                            style="background: #6c757d; color: white; border-radius: 50px; padding: 12px 30px; font-weight: 600; border: none;">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-lg shadow-sm" 
                            style="background: linear-gradient(135deg, #6F4E37, #8B4513); color: white; border-radius: 50px; padding: 12px 30px; font-weight: 600; border: none;">
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
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 1.5rem;">
                <h5 class="modal-title fw-bold" id="confirmarEliminarModalLabel" style="font-size: 1.3rem;">
                    <i class="fas fa-exclamation-triangle me-2" style="color: #fff3cd;"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: brightness(0) invert(1);"></button>
            </div>
            <div class="modal-body text-center p-4" style="background: linear-gradient(135deg, #fff8f8 0%, #ffffff 100%);">
                <div class="mb-3">
                    <i class="fas fa-trash-alt fa-3x" style="color: #dc3545;"></i>
                </div>
                <h5 class="mb-3" style="color: #6F4E37;">¿Está seguro de eliminar este producto?</h5>
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
            <div class="modal-footer border-0 p-4" style="background: linear-gradient(135deg, #fff8f8 0%, #ffffff 100%);">
                <button type="button" class="btn btn-lg shadow-sm" data-bs-dismiss="modal" 
                        style="background: #6c757d; color: white; border-radius: 50px; padding: 12px 30px; font-weight: 600; border: none;">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-lg shadow-sm" id="confirmarEliminarBtn"
                        style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; border-radius: 50px; padding: 12px 30px; font-weight: 600; border: none;">
                    <i class="fas fa-trash me-2"></i>Eliminar Producto
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Éxito para Inventario Creado -->
<div class="modal fade" id="modalExitoInventario" tabindex="-1" aria-labelledby="modalExitoInventarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border: none; border-radius: 25px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); box-shadow: 0 25px 50px rgba(0,0,0,0.15); overflow: hidden;">
      <div class="modal-body text-center p-5" style="position: relative;">
        <!-- Decoración de fondo -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 30% 20%, rgba(111, 78, 55, 0.1) 0%, transparent 50%), radial-gradient(circle at 70% 80%, rgba(139, 69, 19, 0.1) 0%, transparent 50%); z-index: 1;"></div>
        
        <!-- Contenido -->
        <div class="position-relative" style="z-index: 2;">
          <!-- Icono principal animado -->
          <div class="mb-4" style="animation: successBounce 1s ease-out;">
            <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #6F4E37, #5D4037); border-radius: 50%; box-shadow: 0 10px 25px rgba(111, 78, 55, 0.4);">
              <i class="fas fa-check text-white" style="font-size: 2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
            </div>
          </div>
          
          <!-- Título -->
          <h4 class="fw-bold mb-3" style="color: #6F4E37; animation: fadeInUp 0.8s ease-out 0.2s both;">
            ¡Inventario Creado Exitosamente!
          </h4>
          
          <!-- Descripción -->
          <p class="text-muted mb-4" style="font-size: 1.1rem; animation: fadeInUp 0.8s ease-out 0.4s both;">
            El producto ha sido registrado correctamente en el inventario.
          </p>
          
          <!-- Icono decorativo -->
          <div style="animation: fadeInUp 0.8s ease-out 0.6s both;">
            <i class="fas fa-boxes" style="font-size: 2.5rem; color: #8B4513;"></i>
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
</div>

<!-- Success Notification Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white border-0 text-center">
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
@endsection

@push('styles')
<style>
/* Color café personalizado - Color café real como en la imagen */
:root {
    --brown-color: #6F4E37;  /* Café oscuro real */
    --brown-hover: #8B4513;  /* Café medio */
    --brown-light: #A0522D;  /* Café claro */
    --brown-dark: #5D4037;   /* Café muy oscuro */
    --brown-cream: #D7CCC8;  /* Crema café */
    --brown-beige: #EFEBE9;  /* Beige café */
}

.bg-brown {
    background: linear-gradient(135deg, var(--brown-color), var(--brown-hover)) !important;
    border: none !important;
}

.text-brown {
    color: var(--brown-color) !important;
}

.border-brown {
    border-color: var(--brown-color) !important;
    border-width: 2px !important;
}

.btn-brown {
    background: linear-gradient(135deg, var(--brown-color), var(--brown-hover));
    border: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    box-shadow: 0 4px 12px rgba(111, 78, 55, 0.3);
}

.btn-brown:hover {
    background: linear-gradient(135deg, var(--brown-hover), var(--brown-light));
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(111, 78, 55, 0.4);
}

.btn-brown:focus, .btn-brown:active {
    background: linear-gradient(135deg, var(--brown-hover), var(--brown-light));
    border: none;
    color: white;
    box-shadow: 0 0 0 0.2rem rgba(111, 78, 55, 0.25);
}

/* Botones con mejor hover */
.btn {
    transition: all 0.3s ease;
    border-radius: 8px;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-lg {
    padding: 12px 30px;
    font-size: 1.1rem;
}

/* Cards con gradientes suaves */
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3) !important;
}

.bg-gradient-brown {
    background: linear-gradient(45deg, var(--brown-color), var(--brown-hover)) !important;
}

/* Alertas mejoradas */
.alert {
    border: none;
    border-left: 4px solid;
    border-radius: 12px;
}

.alert-success {
    border-left-color: #28a745;
    background-color: #d4edda;
}

.alert-warning {
    border-left-color: #ffc107;
    background-color: #fff3cd;
}

/* Formularios mejorados */
.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    padding: 12px 16px;
}

.form-control:focus, .form-select:focus {
    border-color: var(--brown-color);
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
}

.border-brown:focus {
    border-color: var(--brown-hover) !important;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25) !important;
}

/* Modales mejorados */
.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    padding: 20px 25px;
}

.modal-body {
    padding: 25px;
}

.modal-footer {
    padding: 20px 25px;
}

/* Tablas mejoradas */
.table {
    border-radius: 12px;
    overflow: hidden;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid var(--brown-color);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    padding: 15px 12px;
}

.table-hover tbody tr:hover {
    background-color: rgba(139, 69, 19, 0.05);
}

/* Input groups mejorados */
.input-group-text {
    border-radius: 8px 0 0 8px;
    border: 2px solid #e9ecef;
    border-right: none;
    font-weight: 600;
}

.input-group .form-control {
    border-radius: 0 8px 8px 0;
    border-left: none;
}

/* Badges de estado */
.badge {
    font-size: 0.8rem;
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 500;
}

/* Selectores organizados */
optgroup {
    font-weight: bold;
    padding: 8px 0;
}

optgroup option {
    font-weight: normal;
    padding-left: 15px;
}

/* Animaciones suaves */
.fade {
    transition: opacity 0.3s ease;
}

/* Sombras mejoradas */
.shadow-lg {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

.shadow-sm {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
}

/* Ocultar mensajes de error automáticamente */
.alert-danger {
    display: none !important;
}

.alert-error {
    display: none !important;
}

/* Ocultar cualquier error de validación */
.is-invalid {
    border-color: #6F4E37 !important;
}

.invalid-feedback {
    display: none !important;
}

/* Estados de carga */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Estilos para búsqueda */
#searchInput {
    transition: all 0.3s ease;
}

#searchInput:focus {
    border-color: #6F4E37 !important;
    box-shadow: 0 0 0 0.2rem rgba(111, 78, 55, 0.25) !important;
    transform: scale(1.02);
}

/* Estilo para el botón de búsqueda */
#searchBtn {
    transition: all 0.2s ease;
}

#searchBtn:hover {
    background: #5a3e2a !important;
    transform: scale(1.02);
}

.search-highlight {
    background: #fff3cd !important;
    color: #6F4E37 !important;
    font-weight: bold;
    padding: 2px 4px;
    border-radius: 3px;
    animation: highlightPulse 0.5s ease-in-out;
}

@keyframes highlightPulse {
    0% { background: #ffffff; }
    50% { background: #fff3cd; }
    100% { background: #fff3cd; }
}

/* Efecto cuando no hay resultados */
.no-results-row {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 10px;
    }
    
    .btn-lg {
        padding: 10px 20px;
        font-size: 1rem;
    }
    
    .modal-header, .modal-body, .modal-footer {
        padding: 15px 20px;
    }
}

/* Animaciones para modal de éxito */
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
    background-color: rgba(40, 167, 69, 0.1);
}

.alert-danger {
    border-left-color: #dc3545;
    background-color: rgba(220, 53, 69, 0.1);
}

/* Create product button special effect */
.btn-create-product {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24) !important;
    color: white !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 12px 30px !important;
    font-weight: 600 !important;
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4) !important;
    transition: all 0.4s ease !important;
}

.btn-create-product:hover {
    background: linear-gradient(135deg, #ee5a24, #e55039) !important;
    box-shadow: 0 12px 35px rgba(255, 107, 107, 0.6) !important;
    transform: translateY(-3px) scale(1.05) !important;
    color: white !important;
}

/* Modales mejorados */
.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    border-bottom: none;
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(0,0,0,0.1);
    padding: 1.5rem;
}

/* Estilo para badges de estado */
.badge {
    font-size: 0.8em;
    padding: 0.375rem 0.75rem;
}

/* Animaciones suaves */
.table tr {
    transition: all 0.2s ease;
}

.table tr:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Animaciones para actualizaciones en tiempo real */
.table-warning {
    background-color: rgba(255, 193, 7, 0.15) !important;
    transition: all 0.3s ease !important;
}

.table-success {
    background-color: rgba(25, 135, 84, 0.15) !important;
    transition: all 0.3s ease !important;
}

.updating-row {
    animation: updatePulse 1s ease-in-out;
}

@keyframes updatePulse {
    0% { background-color: transparent; }
    50% { background-color: rgba(111, 78, 55, 0.1); }
    100% { background-color: transparent; }
}

/* Efecto de actualización en tiempo real */
.real-time-update {
    position: relative;
    overflow: hidden;
}

.real-time-update::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(111, 78, 55, 0.3), transparent);
    animation: realTimeShine 2s ease-in-out;
}

@keyframes realTimeShine {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Estilos específicos para modal estilo café/lotes */
.modal-cafe .form-control:focus,
.modal-cafe .form-select:focus {
    border-color: #8B4513 !important;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25) !important;
}

.modal-cafe .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.modal-cafe .form-control:disabled,
.modal-cafe .form-select:disabled,
.modal-cafe .form-control:read-only,
.modal-cafe .form-select:read-only,
.modal-cafe textarea:disabled {
    background-color: #f8f9fa !important;
    border-color: #D7CCC8 !important;
    color: #6c757d !important;
    cursor: not-allowed !important;
}

.modal-cafe .btn-cafe-primary {
    background: linear-gradient(135deg, #6F4E37, #8B4513);
    color: white;
    border: none;
    transition: all 0.3s ease;
}

.modal-cafe .btn-cafe-primary:hover {
    background: linear-gradient(135deg, #8B4513, #A0522D);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(111, 78, 55, 0.4);
}
</style>
@endpush

@section('scripts')
<script>
// Configurar CSRF token para AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

$(document).ready(function() {
    // Limpiar errores
    function limpiarErrores() { $('.alert-danger, .alert-error, .invalid-feedback').hide().remove(); $('.is-invalid').removeClass('is-invalid'); $('#ajaxResponse, #ajaxResponseEdit').empty(); }
    limpiarErrores(); $('.modal').on('show.bs.modal', limpiarErrores); setInterval(limpiarErrores, 2000);
    
    // Fecha actual
    const hoy = new Date().toISOString().split('T')[0]; 
    function setFecha() { $('#fecha_registro, #edit_fecha_registro').val(hoy); }
    setFecha(); $('#nuevoProductoModal, #editarProductoModal').on('show.bs.modal', setFecha);
    
    // Limpieza de modales
    $('#nuevoProductoModal').on('hidden.bs.modal', function() { $(this).find('form')[0].reset(); $(this).find('.is-invalid').removeClass('is-invalid'); $('#ajaxResponse').empty(); });
    $('#editarProductoModal').on('hidden.bs.modal', function() { $(this).find('.is-invalid').removeClass('is-invalid'); $('#ajaxResponseEdit').empty(); });
    $('#confirmarEliminarModal').on('hidden.bs.modal', function() { $('#productoEliminar').val(''); $('#nombreProductoEliminar').text(''); });
    $('.modal').on('hide.bs.modal', function() { $('body').removeClass('modal-open'); $('.modal-backdrop').remove(); });
    
    // Auto-asignación tipo/unidad
    function configurarAutoasignacion(nombre, tipo, unidad) {
        $(nombre).on('change', function() {
            const option = $(this).find('option:selected');
            const tipoVal = option.data('tipo'), unidadVal = option.data('unidad');
            if (tipoVal && unidadVal) {
                $(tipo).prop('disabled', false).val(tipoVal).prop('disabled', true);
                $(unidad).prop('disabled', false).val(unidadVal).prop('disabled', true);
            }
        });
    }
    configurarAutoasignacion('#nombre', '#tipo', '#unidad_medida');
    configurarAutoasignacion('#edit_nombre', '#edit_tipo', '#edit_unidad_medida');
    
    // Validaciones y funciones auxiliares
    $('#cantidad, #edit_cantidad').on('input', function() { if ($(this).val().length > 5) $(this).val($(this).val().slice(0, 5)); });
    $('#precio_unitario, #edit_precio_unitario').on('input', function() { if ($(this).val().length > 6) $(this).val($(this).val().slice(0, 6)); });
    
    function mostrarModalExito() { $('.modal-backdrop').remove(); $('body').removeClass('modal-open'); new bootstrap.Modal(document.getElementById('modalExitoInventario')).show(); setTimeout(() => window.location.reload(), 1500); }
    window.actualizarTiempoReal = function() { const ahora = new Date(); $('#lastUpdate').text(ahora.toLocaleDateString('es-ES') + ' ' + ahora.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})); };
    setInterval(window.actualizarTiempoReal, 30000);
    
    // Editar producto
    $(document).on('click', '.edit-producto-btn', function(e) {
        e.preventDefault(); 
        const id = $(this).data('id');
        const btn = $(this);
        const originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true); 
        limpiarErrores();
        
        $.ajax({
            url: `{{ url('/inventario') }}/${id}`, 
            type: 'GET',
            success: function(producto) {
                $('#edit_id').val(producto.id); 
                $('#edit_nombre').val(producto.nombre); 
                $('#edit_cantidad').val(producto.cantidad);
                $('#edit_precio_unitario').val(producto.precio_unitario); 
                $('#edit_estado').val(producto.estado); 
                $('#edit_fecha_registro').val(producto.fecha_registro);
                
                const option = $(`#edit_nombre option[value="${producto.nombre}"]`);
                const tipo = option.data('tipo') || producto.tipo;
                const unidad = option.data('unidad') || producto.unidad_medida;
                
                if (tipo && unidad) { 
                    $('#edit_tipo').prop('disabled', false).val(tipo).prop('disabled', true); 
                    $('#edit_unidad_medida').prop('disabled', false).val(unidad).prop('disabled', true); 
                }
                
                btn.html(originalText).prop('disabled', false); 
                new bootstrap.Modal(document.getElementById('editarProductoModal')).show();
            },
            error: function(xhr, status, error) { 
                console.log('Error:', xhr.responseText);
                btn.html(originalText).prop('disabled', false); 
                alert('Error al cargar los datos del producto. Intente nuevamente.');
            }
        });
    });
    
    // Guardar edición
    $('#editarProductoForm').on('submit', function(e) {
        e.preventDefault(); 
        const form = $(this);
        const id = $('#edit_id').val();
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Actualizando...').prop('disabled', true);
        
        // Habilitar campos para enviar
        $('#edit_tipo, #edit_unidad_medida').prop('disabled', false);
        
        $.ajax({
            url: `{{ url('/inventario') }}/${id}`, 
            method: 'PUT', 
            data: form.serialize(),
            success: function(response) { 
                submitBtn.html(originalText).prop('disabled', false); 
                bootstrap.Modal.getInstance(document.getElementById('editarProductoModal')).hide();
                $('.modal-backdrop').remove(); 
                $('body').removeClass('modal-open'); 
                mostrarModalExito(); 
            },
            error: function(xhr, status, error) { 
                console.log('Error:', xhr.responseText);
                submitBtn.html(originalText).prop('disabled', false); 
                $('#edit_tipo, #edit_unidad_medida').prop('disabled', true);
                alert('Error al actualizar el producto. Verifique los datos e intente nuevamente.');
            }
        });
    });
    
    // Eliminar producto
    $(document).on('click', '.delete-producto-btn', function(e) {
        e.preventDefault(); 
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        const nombre = row.find('td').eq(0).text().trim();
        
        $('#productoEliminar').val(id); 
        $('#nombreProductoEliminar').text(nombre); 
        new bootstrap.Modal(document.getElementById('confirmarEliminarModal')).show();
    });
    
    $('#confirmarEliminarBtn').on('click', function() {
        const id = $('#productoEliminar').val();
        const btn = $(this);
        const originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Eliminando...').prop('disabled', true);
        
        $.ajax({
            url: `{{ url('/inventario') }}/${id}`, 
            method: 'DELETE',
            success: function(response) { 
                bootstrap.Modal.getInstance(document.getElementById('confirmarEliminarModal')).hide(); 
                $('.modal-backdrop').remove(); 
                $('body').removeClass('modal-open');
                btn.html(originalText).prop('disabled', false); 
                mostrarModalExito(); 
            },
            error: function(xhr, status, error) { 
                console.log('Error:', xhr.responseText);
                bootstrap.Modal.getInstance(document.getElementById('confirmarEliminarModal')).hide(); 
                $('.modal-backdrop').remove(); 
                $('body').removeClass('modal-open');
                btn.html(originalText).prop('disabled', false); 
                alert('Error al eliminar el producto. Intente nuevamente.');
            }
        });
    });
    
    // Agregar producto
    $('#nuevoProductoForm').on('submit', function(e) {
        e.preventDefault(); const form = $(this), submitBtn = form.find('button[type="submit"]'), originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Guardando...').prop('disabled', true); $('#tipo, #unidad_medida').prop('disabled', false);
        $.ajax({
            url: '{{ route("inventario.store") }}', method: 'POST', data: form.serialize(),
            success: function() { submitBtn.html(originalText).prop('disabled', false); $('#tipo, #unidad_medida').prop('disabled', true);
                bootstrap.Modal.getInstance(document.getElementById('nuevoProductoModal')).hide(); form[0].reset(); mostrarModalExito(); },
            error: function() { submitBtn.html(originalText).prop('disabled', false); $('#tipo, #unidad_medida').prop('disabled', true); setTimeout(() => window.location.reload(), 1000); }
        });
    });
    
    // Búsqueda simple
    $('#searchInput').on('input', function() {
        const term = $(this).val().toLowerCase(); $('#noResultsMessage').remove(); let visibleCount = 0;
        $('#inventoryTable tbody tr[data-id]').each(function() {
            const row = $(this), text = row.text().toLowerCase(), matches = text.includes(term) || term === '';
            row.toggle(matches); if (matches) visibleCount++;
        });
        if (visibleCount === 0 && term !== '') {
            $('#inventoryTable tbody').append(`<tr id="noResultsMessage"><td colspan="8" class="text-center py-4"><i class="fas fa-search-minus fa-2x text-muted mb-2"></i><h6 class="text-muted">No se encontraron productos</h6><button class="btn btn-sm btn-brown" onclick="$('#searchInput').val('').trigger('input')">Limpiar</button></td></tr>`);
        }
        const total = $('#inventoryTable tbody tr[data-id]').length; $('#totalProductos').text(term === '' ? total : `${visibleCount} de ${total}`);
    });
    
    // Botón búsqueda
    $('#searchBtn').on('click', function() { const input = $('#searchInput'); input.val() === '' ? input.focus() : input.val('').trigger('input').focus(); });
    
    // Limpiar modales
    $('.modal').on('hidden.bs.modal', function() { $(this).find('form')[0]?.reset(); $(this).find('.is-invalid').removeClass('is-invalid'); $('.modal-backdrop').remove(); $('body').removeClass('modal-open'); });
});
</script>
@endsection
