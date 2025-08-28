@extends('layouts.masterr')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/produccion/reporte.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Principal estilo Inventario -->
    <div class="main-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Reporte de Rendimiento de Producción</h1>
                <p class="subtitle">Análisis completo del rendimiento de tus cultivos de cacao</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="exportarReporte('pdf')">
                    Descargar PDF
                </button>
                <a href="{{ route('produccion.index') }}" class="btn btn-secondary">
                    Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros estilo Inventario -->
    <div class="filters-section">
        <form id="filtrosReporte" method="GET" action="{{ route('produccion.reporte_rendimiento') }}">
            <div class="filter-row">
                <div class="form-group">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control"
                           value="{{ request('fecha_desde', now()->subMonths(3)->format('Y-m-d')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control"
                           value="{{ request('fecha_hasta', now()->format('Y-m-d')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Tipo</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="cosecha" {{ request('estado') == 'cosecha' ? 'selected' : '' }}>En Cosecha</option>
                        <option value="maduracion" {{ request('estado') == 'maduracion' ? 'selected' : '' }}>Maduración</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Buscar Producto</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Nombre del lote o cultivo..."
                           value="{{ request('search') }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Filtrar
                    </button>
                </div>
                <div class="form-group">
                    <a href="{{ route('produccion.reporte_rendimiento') }}" class="btn btn-outline">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Estadísticas Grandes estilo Inventario -->
    <div class="stats-section">
        <div class="stat-card">
            <h2 class="stat-number">{{ $estadisticas['total_producciones'] }}</h2>
            <p class="stat-label">Total Producciones</p>
        </div>
        <div class="stat-card">
            <h2 class="stat-number">${{ number_format($estadisticas['produccion_total'] * 1000, 2) }}</h2>
            <p class="stat-label">Valor Total</p>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="charts-section">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Rendimiento por Mes</h3>
            </div>
            <div class="chart-container">
                <canvas id="rendimientoChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Distribución por Tipo</h3>
            </div>
            <div class="chart-container">
                <canvas id="tiposCacaoChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Análisis de Desviaciones (si existen) -->
    @if(count($desviaciones) > 0)
    <div class="deviation-section">
        <div class="deviation-header">
            <i class="fas fa-exclamation-triangle deviation-icon"></i>
            <h3 class="deviation-title">Insumos Utilizados en Lotes</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Insumo</th>
                        <th>Lote</th>
                        <th>Producción</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                        <th>Fecha Salida</th>
                        <th>Responsable</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($desviaciones as $desviacion)
                    <tr>
                        <td>{{ $desviacion->id }}</td>
                        <td>
                            <strong>{{ ucfirst($desviacion->tipo_cacao) }}</strong><br>
                            <small class="text-muted">Pesticidas</small>
                        </td>
                        <td>
                            <strong>{{ $desviacion->lote->nombre ?? 'N1' }}</strong><br>
                            <small class="text-muted">LOT-{{ $desviacion->id }}</small>
                        </td>
                        <td>
                            <span class="badge badge-optimal">{{ number_format($desviacion->estimacion_produccion, 0) }}</span>
                        </td>
                        <td>{{ number_format($desviacion->total_recolectado, 3) }}</td>
                        <td>${{ number_format($desviacion->estimacion_produccion * 100, 2) }}<br>
                            <small class="text-muted">${{ number_format($desviacion->estimacion_produccion * 100, 2) }}/Unidad</small>
                        </td>
                        <td>{{ now()->format('d/m/Y') }}<br>
                            <small class="text-muted">{{ now()->format('H:i') }}</small>
                        </td>
                        <td>No especificado</td>
                        <td>
                            <span class="badge badge-info">Sin motivo</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Tabla Principal de Productos estilo Inventario -->
    <div class="table-section">
        <div class="table-header">
            <h3 class="table-title">Listado de Productos</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Valor Total</th>
                        <th>Estado</th>
                        <th>Fecha Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($producciones as $produccion)
                    <tr>
                        <td>{{ $produccion->id }}</td>
                        <td>
                            <strong>{{ ucfirst($produccion->tipo_cacao) }}</strong><br>
                            <small class="text-muted">{{ $produccion->lote->nombre ?? 'Lote Principal' }}</small>
                        </td>
                        <td>
                            <strong>Cacao</strong><br>
                            <small class="text-muted">Cultivos</small>
                        </td>
                        <td>{{ number_format($produccion->total_recolectado, 0) }} <small class="text-muted">kg</small></td>
                        <td>${{ number_format(350, 2) }}</td>
                        <td>
                            <strong>${{ number_format($produccion->total_recolectado * 350, 2) }}</strong>
                        </td>
                        <td>
                            @php
                                $porcentaje = $produccion->estimacion_produccion > 0
                                    ? ($produccion->total_recolectado / $produccion->estimacion_produccion) * 100
                                    : 0;
                            @endphp
                            @if($porcentaje >= 100)
                                <span class="badge badge-optimal">Óptimo</span>
                            @elseif($porcentaje >= 80)
                                <span class="badge badge-success">Bueno</span>
                            @elseif($porcentaje >= 60)
                                <span class="badge badge-warning">Regular</span>
                            @else
                                <span class="badge badge-danger">Bajo</span>
                            @endif
                        </td>
                        <td>{{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : now()->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">📊</div>
                                <h3>No se encontraron producciones</h3>
                                <p>Ajusta los filtros para ver resultados</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($producciones->hasPages())
            <div class="pagination">
                {{ $producciones->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal estilo Inventario -->
<div class="modal fade" id="modalRecolecciones" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Historial de Recolecciones
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoRecolecciones">
                <!-- Contenido cargado dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" class="btn btn-primary" onclick="exportarHistorialRecolecciones()">
                    Exportar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/produccion/reporte.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos del reporte
    const rendimientoPorMes = @json($rendimientoPorMes ?? []);
    const distribucionTipos = @json($distribucionTipos ?? []);

    // Inicializar reporte
    if (typeof initializeReportData === 'function') {
        initializeReportData(rendimientoPorMes, distribucionTipos);
    }

    // Configurar ruta base
    if (!document.querySelector('meta[name="base-route"]')) {
        const meta = document.createElement('meta');
        meta.name = 'base-route';
        meta.content = '{{ route("produccion.reporte_rendimiento") }}';
        document.head.appendChild(meta);
    }
});
</script>
@endpush
