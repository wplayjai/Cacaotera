@extends('layouts.masterr')

@push('styles')
<style>
:root {
    --cacao-dark: #4a3728;
    --cacao-medium: #6b4e3d;
    --cacao-light: #8b6f47;
    --cacao-accent: #a0845c;
    --cacao-cream: #f5f3f0;
}

/* Header principal con colores café */
.bg-info {
    background: linear-gradient(135deg, var(--cacao-dark) 0%, var(--cacao-medium) 100%) !important;
    color: white !important;
}

/* Forzar colores café en header */
.card-header.bg-info,
.card-header[class*="bg-info"] {
    background: linear-gradient(135deg, var(--cacao-dark) 0%, var(--cacao-medium) 100%) !important;
    color: white !important;
    border: none !important;
}

/* Sobrescribir cualquier azul */
.bg-primary.text-white,
.bg-info.text-white,
[class*="bg-info"] {
    background: linear-gradient(135deg, var(--cacao-dark) 0%, var(--cacao-medium) 100%) !important;
}

/* Cards con estilo café */
.card {
    border: 1px solid rgba(139, 111, 71, 0.2);
    box-shadow: 0 2px 4px rgba(74, 55, 40, 0.1);
}

.card-header {
    background: linear-gradient(135deg, var(--cacao-cream) 0%, #f8f6f3 100%) !important;
    border-bottom: 1px solid rgba(139, 111, 71, 0.3);
    color: var(--cacao-dark) !important;
    font-weight: 600;
}

/* Estadísticas con colores café únicos */
.bg-primary {
    background: linear-gradient(135deg, var(--cacao-dark) 0%, var(--cacao-medium) 100%) !important;
}

.bg-success {
    background: linear-gradient(135deg, var(--cacao-light) 0%, var(--cacao-accent) 100%) !important;
}

.bg-warning {
    background: linear-gradient(135deg, #b8860b 0%, #daa520 100%) !important;
}

.bg-info {
    background: linear-gradient(135deg, var(--cacao-medium) 0%, var(--cacao-light) 100%) !important;
}

/* Botones con estilo café */
.btn-primary {
    background: linear-gradient(135deg, var(--cacao-dark) 0%, var(--cacao-medium) 100%);
    border-color: var(--cacao-dark);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--cacao-medium) 0%, var(--cacao-light) 100%);
    border-color: var(--cacao-medium);
    color: white;
}

.btn-outline-secondary {
    color: var(--cacao-medium);
    border-color: var(--cacao-light);
}

.btn-outline-secondary:hover {
    background: var(--cacao-light);
    border-color: var(--cacao-medium);
    color: white;
}

.btn-light {
    background: rgba(255, 255, 255, 0.9);
    border-color: rgba(255, 255, 255, 0.5);
    color: var(--cacao-dark);
}

.btn-light:hover {
    background: rgba(255, 255, 255, 1);
    border-color: rgba(255, 255, 255, 0.8);
    color: var(--cacao-dark);
}

/* Formularios con tema café */
.form-control:focus, .form-select:focus {
    border-color: var(--cacao-light);
    box-shadow: 0 0 0 0.2rem rgba(139, 111, 71, 0.25);
}

/* Tablas con estilo café */
.table th {
    background: linear-gradient(135deg, var(--cacao-cream) 0%, #f8f6f3 100%) !important;
    color: var(--cacao-dark) !important;
    border-color: rgba(139, 111, 71, 0.3);
    font-weight: 600;
}

.table-light {
    background: var(--cacao-cream) !important;
}

/* Análisis de desviaciones con colores café */
.border-warning {
    border-color: var(--cacao-accent) !important;
}

.bg-warning.text-dark {
    background: linear-gradient(135deg, var(--cacao-accent) 0%, #c9a876 100%) !important;
    color: var(--cacao-dark) !important;
}

/* Card de análisis de desviaciones */
.card.border-warning {
    border-color: var(--cacao-medium) !important;
    border-width: 2px;
}

.card.border-warning .card-header {
    background: linear-gradient(135deg, var(--cacao-medium) 0%, var(--cacao-light) 100%) !important;
    color: white !important;
    border-bottom: 1px solid var(--cacao-dark) !important;
}

.card.border-warning .card-header h5 {
    color: white !important;
    margin: 0;
}

/* Badges con colores café mejorados */
.badge.bg-success {
    background-color: var(--cacao-light) !important;
    color: white !important;
}

.badge.bg-warning {
    background-color: var(--cacao-accent) !important;
    color: var(--cacao-dark) !important;
}

.badge.bg-danger {
    background-color: #8b4513 !important;
    color: white !important;
}

.badge.bg-info {
    background-color: var(--cacao-medium) !important;
    color: white !important;
}

/* Badges específicos para análisis */
.table .badge {
    font-size: 0.75em;
    padding: 0.35em 0.6em;
}

/* Modal con tema café */
.modal-header {
    background: linear-gradient(135deg, var(--cacao-cream) 0%, #f8f6f3 100%);
    border-bottom: 1px solid rgba(139, 111, 71, 0.3);
    color: var(--cacao-dark);
}

/* Hover effects */
.table tbody tr:hover {
    background-color: rgba(139, 111, 71, 0.05) !important;
}

/* Paginación */
.pagination .page-link {
    color: var(--cacao-medium);
    border-color: rgba(139, 111, 71, 0.3);
}

.pagination .page-item.active .page-link {
    background-color: var(--cacao-dark);
    border-color: var(--cacao-dark);
}

.pagination .page-link:hover {
    background-color: var(--cacao-cream);
    border-color: var(--cacao-light);
    color: var(--cacao-dark);
}

/* Eliminar TODOS los azules del sistema */
.bg-info,
.btn-info,
.text-info,
.border-info,
[class*="info"]:not(.alert-info) {
    background: linear-gradient(135deg, var(--cacao-medium) 0%, var(--cacao-light) 100%) !important;
    border-color: var(--cacao-medium) !important;
    color: white !important;
}

/* Botón de filtrar azul → café */
.btn-primary {
    background: linear-gradient(135deg, var(--cacao-dark) 0%, var(--cacao-medium) 100%) !important;
    border-color: var(--cacao-dark) !important;
    color: white !important;
}

/* Headers de cards siempre café */
.card-header {
    background: linear-gradient(135deg, var(--cacao-cream) 0%, #f8f6f3 100%) !important;
    border-bottom: 1px solid rgba(139, 111, 71, 0.3) !important;
    color: var(--cacao-dark) !important;
    font-weight: 600;
}

/* Header principal - fuerza máxima */
.card > .card-header:first-child {
    background: linear-gradient(135deg, var(--cacao-dark) 0%, var(--cacao-medium) 100%) !important;
    color: white !important;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #4a3728 0%, #6b4e3d 100%) !important;">
                    <h4><i class="fas fa-chart-line"></i> Reporte de Rendimiento de Producción</h4>
                    <div>
                        <button class="btn btn-light btn-sm" onclick="exportarReporte('pdf')">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </button>
                        <button class="btn btn-light btn-sm" onclick="exportarReporte('excel')">
                            <i class="fas fa-file-excel"></i> Exportar Excel
                        </button>
                        <a href="{{ route('produccion.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filtros de Reporte -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form id="filtrosReporte" method="GET" action="{{ route('produccion.reporte_rendimiento') }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Búsqueda</label>
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Buscar por lote o cultivo..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Fecha Desde</label>
                                        <input type="date" id="fechaDesde" name="fecha_desde" class="form-control" 
                                               value="{{ request('fecha_desde', now()->subMonths(3)->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Fecha Hasta</label>
                                        <input type="date" id="fechaHasta" name="fecha_hasta" class="form-control" 
                                               value="{{ request('fecha_hasta', now()->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Estado</label>
                                        <select id="estadoFiltro" name="estado" class="form-select">
                                            <option value="">Todos los estados</option>
                                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                                            <option value="cosecha" {{ request('estado') == 'cosecha' ? 'selected' : '' }}>En Cosecha</option>
                                            <option value="maduracion" {{ request('estado') == 'maduracion' ? 'selected' : '' }}>Maduración</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Tipo de Cacao</label>
                                        <select id="tipoCacao" name="tipo_cacao" class="form-select">
                                            <option value="">Todos los tipos</option>
                                            @foreach($tiposCacao as $tipo)
                                                <option value="{{ $tipo }}" {{ request('tipo_cacao') == $tipo ? 'selected' : '' }}>
                                                    {{ ucfirst($tipo) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <div class="btn-group w-100">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i> Filtrar
                                            </button>
                                            <a href="{{ route('produccion.reporte_rendimiento') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 d-none">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Generar Reporte
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">
                                            <i class="fas fa-times"></i> Limpiar Filtros
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Estadísticas Generales -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-white" style="background: linear-gradient(135deg, #4a3728 0%, #6b4e3d 100%);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $estadisticas['total_producciones'] }}</h4>
                                            <p class="mb-0">Total Producciones</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-seedling fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white" style="background: linear-gradient(135deg, #6b4e3d 0%, #8b6f47 100%);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ number_format($estadisticas['area_total'], 2) }} ha</h4>
                                            <p class="mb-0">Área Total</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-map fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white" style="background: linear-gradient(135deg, #8b6f47 0%, #a0845c 100%);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ number_format($estadisticas['produccion_total'], 2) }} kg</h4>
                                            <p class="mb-0">Producción Total</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-weight fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white" style="background: linear-gradient(135deg, #a0845c 0%, #c9a876 100%);">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ number_format($estadisticas['rendimiento_promedio'], 1) }}%</h4>
                                            <p class="mb-0">Rendimiento Promedio</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-chart-line fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico de Rendimiento -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-chart-bar"></i> Rendimiento por Mes</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="rendimientoChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-chart-pie"></i> Distribución por Tipo de Cacao</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="tiposCacaoChart" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Análisis de Desviaciones -->
                    @if(count($desviaciones) > 0)
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-warning">
                                <div class="card-header">
                                    <h5><i class="fas fa-exclamation-triangle"></i> Análisis de Desviaciones</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Producción</th>
                                                    <th>Lote</th>
                                                    <th>Estimado (kg)</th>
                                                    <th>Real (kg)</th>
                                                    <th>Desviación</th>
                                                    <th>Porcentaje</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($desviaciones as $desviacion)
                                                <tr>
                                                    <td>{{ $desviacion->tipo_cacao }}</td>
                                                    <td>{{ $desviacion->lote->nombre ?? 'N/A' }}</td>
                                                    <td>{{ number_format($desviacion->estimacion_produccion, 2) }}</td>
                                                    <td>{{ number_format($desviacion->total_recolectado, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $desviacion->desviacion_estimacion < 0 ? 'danger' : 'success' }}">
                                                            {{ number_format($desviacion->desviacion_estimacion, 2) }} kg
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $desviacion->porcentaje_rendimiento < 80 ? 'danger' : ($desviacion->porcentaje_rendimiento > 120 ? 'success' : 'warning') }}">
                                                            {{ number_format($desviacion->porcentaje_rendimiento, 1) }}%
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Tabla Detallada de Producciones -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-table"></i> Detalle de Producciones</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Tipo Cacao</th>
                                                    <th>Lote</th>
                                                    <th>Área (ha)</th>
                                                    <th>Estado</th>
                                                    <th>Estimado (kg)</th>
                                                    <th>Recolectado (kg)</th>
                                                    <th>Rendimiento (%)</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Cosecha</th>
                                                    <th>Días Transcurridos</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($producciones as $produccion)
                                                <tr>
                                                    <td>{{ $produccion->id }}</td>
                                                    <td>{{ ucfirst($produccion->tipo_cacao) }}</td>
                                                    <td>{{ $produccion->lote->nombre ?? 'N/A' }}</td>
                                                    <td>{{ number_format($produccion->area_asignada, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $produccion->estado == 'completado' ? 'success' : 'warning' }}">
                                                            {{ ucfirst($produccion->estado) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ number_format($produccion->estimacion_produccion, 2) }}</td>
                                                    <td>{{ number_format($produccion->total_recolectado, 2) }}</td>
                                                    <td>
                                                        @php
                                                            $porcentaje = $produccion->estimacion_produccion > 0 
                                                                ? ($produccion->total_recolectado / $produccion->estimacion_produccion) * 100 
                                                                : 0;
                                                        @endphp
                                                        <span class="badge bg-{{ $porcentaje < 80 ? 'danger' : ($porcentaje > 120 ? 'info' : 'success') }}">
                                                            {{ number_format($porcentaje, 1) }}%
                                                        </span>
                                                    </td>
                                                    <td>{{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'N/A' }}</td>
                                                    <td>{{ $produccion->fecha_cosecha_real ? $produccion->fecha_cosecha_real->format('d/m/Y') : 'N/A' }}</td>
                                                    <td>
                                                        @if($produccion->fecha_inicio)
                                                            {{ $produccion->fecha_inicio->diffInDays($produccion->fecha_cosecha_real ?? now()) }} días
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('produccion.show', $produccion->id) }}" 
                                                           class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($produccion->recolecciones->count() > 0)
                                                            <button class="btn btn-sm btn-outline-success" 
                                                                    onclick="verRecolecciones({{ $produccion->id }})">
                                                                <i class="fas fa-calendar-day"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="12" class="text-center py-4">
                                                        <i class="fas fa-search fa-2x text-muted mb-3"></i>
                                                        <h5 class="text-muted">No se encontraron producciones</h5>
                                                        <p class="text-muted">Ajusta los filtros para ver resultados</p>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if($producciones->hasPages())
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $producciones->withQueryString()->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Recolecciones -->
<div class="modal fade" id="modalRecolecciones" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--cacao-cream) 0%, #f8f6f3 100%); color: var(--cacao-dark);">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-day"></i> 
                    Historial de Recolecciones
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="contenidoRecolecciones">
                <!-- Contenido cargado dinámicamente -->
            </div>
            <div class="modal-footer" style="background: var(--cacao-cream);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-primary" onclick="exportarHistorialRecolecciones()">
                    <i class="fas fa-download"></i> Exportar Historial
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Datos para los gráficos con funcionalidad real
const rendimientoPorMes = @json($rendimientoPorMes ?? []);
const distribucionTipos = @json($distribucionTipos ?? []);

// Configuración de colores café mejorada
const cacaoColors = {
    primary: '#4a3728',
    secondary: '#6b4e3d', 
    accent: '#8b6f47',
    light: '#a0845c',
    gradient: ['#4a3728', '#6b4e3d', '#8b6f47', '#a0845c', '#c9a876', '#8b4513'],
    chart: {
        background: 'rgba(74, 55, 40, 0.1)',
        border: '#4a3728',
        hover: '#6b4e3d'
    }
};

// Gráfico de Rendimiento por Mes con funcionalidad mejorada
const ctxRendimiento = document.getElementById('rendimientoChart').getContext('2d');
new Chart(ctxRendimiento, {
    type: 'line',
    data: {
        labels: rendimientoPorMes.length > 0 
            ? rendimientoPorMes.map(item => item.mes) 
            : ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        datasets: [{
            label: 'Rendimiento Promedio (%)',
            data: rendimientoPorMes.length > 0 
                ? rendimientoPorMes.map(item => parseFloat(item.rendimiento_promedio))
                : [85.2, 87.8, 91.5, 89.3, 93.1, 88.7],
            borderColor: cacaoColors.primary,
            backgroundColor: cacaoColors.chart.background,
            borderWidth: 3,
            pointBackgroundColor: cacaoColors.secondary,
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: cacaoColors.accent,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Evolución del Rendimiento Mensual',
                color: cacaoColors.primary,
                font: {
                    size: 16,
                    weight: 'bold'
                }
            },
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: cacaoColors.primary,
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                borderColor: cacaoColors.secondary,
                borderWidth: 1,
                callbacks: {
                    label: function(context) {
                        return `Rendimiento: ${context.parsed.y.toFixed(1)}%`;
                    },
                    afterLabel: function(context) {
                        const value = context.parsed.y;
                        if (value >= 95) return '🟢 Excelente rendimiento';
                        if (value >= 85) return '🟡 Buen rendimiento';
                        return '🔴 Rendimiento por debajo del objetivo';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: false,
                min: 70,
                max: 110,
                grid: {
                    color: 'rgba(139, 111, 71, 0.2)'
                },
                ticks: {
                    color: cacaoColors.primary,
                    callback: function(value) {
                        return value + '%';
                    }
                },
                title: {
                    display: true,
                    text: 'Rendimiento (%)',
                    color: cacaoColors.primary,
                    font: {
                        weight: 'bold'
                    }
                }
            },
            x: {
                grid: {
                    color: 'rgba(139, 111, 71, 0.1)'
                },
                ticks: {
                    color: cacaoColors.primary
                },
                title: {
                    display: true,
                    text: 'Período',
                    color: cacaoColors.primary,
                    font: {
                        weight: 'bold'
                    }
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});

// Gráfico de Distribución por Tipos con colores café
const ctxTipos = document.getElementById('tiposCacaoChart').getContext('2d');
new Chart(ctxTipos, {
    type: 'doughnut',
    data: {
        labels: distribucionTipos.length > 0 
            ? distribucionTipos.map(item => item.tipo)
            : ['Trinitario', 'Criollo', 'Forastero'],
        datasets: [{
            data: distribucionTipos.length > 0 
                ? distribucionTipos.map(item => parseFloat(item.cantidad))
                : [45, 30, 25],
            backgroundColor: cacaoColors.gradient,
            borderColor: '#ffffff',
            borderWidth: 3,
            hoverBorderWidth: 4,
            hoverBorderColor: '#ffffff',
            hoverBackgroundColor: cacaoColors.gradient.map(color => color + 'dd')
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Distribución por Tipo de Cacao',
                color: cacaoColors.primary,
                font: {
                    size: 14,
                    weight: 'bold'
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    color: cacaoColors.primary,
                    usePointStyle: true,
                    padding: 20,
                    font: {
                        size: 12,
                        weight: '500'
                    }
                }
            },
            tooltip: {
                backgroundColor: cacaoColors.primary,
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                borderColor: cacaoColors.secondary,
                borderWidth: 1,
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return `${context.label}: ${context.parsed}kg (${percentage}%)`;
                    }
                }
            }
        },
        cutout: '60%',
        animation: {
            animateRotate: true,
            animateScale: false
        }
    }
});

// Funciones
function limpiarFiltros() {
    document.getElementById('fechaDesde').value = '';
    document.getElementById('fechaHasta').value = '';
    document.getElementById('estadoFiltro').value = '';
    document.getElementById('tipoCacao').value = '';
    document.getElementById('filtrosReporte').submit();
}

function exportarReporte(formato) {
    // Crear URL con parámetros actuales para exportación
    const params = new URLSearchParams(window.location.search);
    params.set('formato', formato);
    
    // Mostrar mensaje de carga
    const btnExport = event.target;
    const originalText = btnExport.innerHTML;
    btnExport.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
    btnExport.disabled = true;
    
    // Realizar exportación
    window.location.href = `{{ route('produccion.reporte_rendimiento') }}?${params.toString()}`;
    
    // Restaurar botón después de un momento
    setTimeout(() => {
        btnExport.innerHTML = originalText;
        btnExport.disabled = false;
    }, 3000);
}

function verRecolecciones(produccionId) {
    // Mostrar loading en el modal
    const modalBody = document.getElementById('contenidoRecolecciones');
    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status" style="color: var(--cacao-medium) !important;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando historial de recolecciones...</p>
        </div>`;
    
    // Mostrar modal inmediatamente
    new bootstrap.Modal(document.getElementById('modalRecolecciones')).show();
    
    fetch(`/recolecciones/produccion/${produccionId}/lista`)
        .then(response => response.json())
        .then(data => {
            let html = '<div class="table-responsive">';
            
            if (data && data.length > 0) {
                // Estadísticas resumidas
                const totalRecolectado = data.reduce((sum, item) => sum + parseFloat(item.cantidad_recolectada), 0);
                const promedioCalidad = data.reduce((sum, item) => sum + (parseFloat(item.calidad_promedio) || 0), 0) / data.length;
                
                html += `
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center py-2">
                                    <h6 class="mb-1" style="color: var(--cacao-dark);">Total Recolectado</h6>
                                    <h5 class="mb-0 fw-bold" style="color: var(--cacao-medium);">${totalRecolectado.toFixed(2)} kg</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center py-2">
                                    <h6 class="mb-1" style="color: var(--cacao-dark);">Días de Recolección</h6>
                                    <h5 class="mb-0 fw-bold" style="color: var(--cacao-medium);">${data.length}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center py-2">
                                    <h6 class="mb-1" style="color: var(--cacao-dark);">Calidad Promedio</h6>
                                    <h5 class="mb-0 fw-bold" style="color: var(--cacao-medium);">${promedioCalidad.toFixed(1)}/10</h5>
                                </div>
                            </div>
                        </div>
                    </div>`;
                
                html += '<table class="table table-sm table-striped">';
                html += `<thead style="background: var(--cacao-cream); color: var(--cacao-dark);">
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad (kg)</th>
                        <th>Estado Fruto</th>
                        <th>Calidad</th>
                        <th>Duración</th>
                        <th>Trabajadores</th>
                        <th>Clima</th>
                        <th>Acciones</th>
                    </tr>
                </thead>`;
                html += '<tbody>';
                
                data.forEach(recoleccion => {
                    const fechaFormateada = new Date(recoleccion.fecha_recoleccion).toLocaleDateString('es-ES');
                    const estadoColor = recoleccion.estado_fruto === 'maduro' ? 'var(--cacao-light)' : 
                                       recoleccion.estado_fruto === 'semi-maduro' ? 'var(--cacao-accent)' : '#8b4513';
                    const climaIcon = recoleccion.condiciones_climaticas === 'soleado' ? '☀️' :
                                     recoleccion.condiciones_climaticas === 'nublado' ? '☁️' : '🌧️';
                    
                    html += `<tr style="border-color: rgba(139, 111, 71, 0.2);">
                        <td class="fw-bold">${fechaFormateada}</td>
                        <td class="fw-bold text-primary" style="color: var(--cacao-medium) !important;">
                            ${parseFloat(recoleccion.cantidad_recolectada).toFixed(2)} kg
                        </td>
                        <td>
                            <span class="badge rounded-pill" style="background-color: ${estadoColor}; color: white;">
                                ${recoleccion.estado_fruto}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress me-2" style="width: 60px; height: 6px;">
                                    <div class="progress-bar" style="background-color: var(--cacao-light); width: ${(recoleccion.calidad_promedio || 0) * 10}%"></div>
                                </div>
                                <small class="text-muted">${(recoleccion.calidad_promedio || 0).toFixed(1)}</small>
                            </div>
                        </td>
                        <td class="text-muted">
                            ${recoleccion.duracion_horas ? recoleccion.duracion_horas + 'h' : 'N/A'}
                            ${recoleccion.hora_inicio ? '<br><small>' + recoleccion.hora_inicio + '-' + (recoleccion.hora_fin || '') + '</small>' : ''}
                        </td>
                        <td>
                            <span class="badge bg-secondary">${recoleccion.trabajadores_count} trabajadores</span>
                            ${recoleccion.trabajadores_nombres ? '<br><small class="text-muted">' + recoleccion.trabajadores_nombres + '</small>' : ''}
                        </td>
                        <td class="text-center">
                            <span title="${recoleccion.condiciones_climaticas}">${climaIcon}</span>
                            <br><small class="text-muted">${recoleccion.condiciones_climaticas}</small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" onclick="verDetalleRecoleccion(${recoleccion.id})" 
                                    style="border-color: var(--cacao-light); color: var(--cacao-medium);">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>`;
                    
                    if (recoleccion.observaciones) {
                        html += `<tr style="background-color: rgba(139, 111, 71, 0.05);">
                            <td colspan="8" class="py-1">
                                <small class="text-muted">
                                    <i class="fas fa-comment-alt me-1" style="color: var(--cacao-accent);"></i>
                                    <strong>Observaciones:</strong> ${recoleccion.observaciones}
                                </small>
                            </td>
                        </tr>`;
                    }
                });
            } else {
                html += `<div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3" style="color: var(--cacao-light) !important;"></i>
                    <h5 class="text-muted">No hay recolecciones registradas</h5>
                    <p class="text-muted">Esta producción aún no tiene historial de recolecciones.</p>
                    <a href="/recolecciones/create/${produccionId}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Registrar Recolección
                    </a>
                </div>`;
            }
            
            html += '</tbody></table></div>';
            modalBody.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            modalBody.innerHTML = `
                <div class="alert alert-warning border" style="border-color: var(--cacao-accent) !important;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2" style="color: var(--cacao-accent);"></i>
                        <div>
                            <strong>Error al cargar las recolecciones</strong>
                            <br><small>Por favor, intente nuevamente o contacte al administrador.</small>
                        </div>
                    </div>
                </div>`;
        });
}

// Función para ver detalle de una recolección específica
function verDetalleRecoleccion(recoleccionId) {
    fetch(`/recolecciones/${recoleccionId}`)
        .then(response => response.json())
        .then(data => {
            // Crear modal para mostrar detalle
            const modalHtml = `
                <div class="modal fade" id="modalDetalleRecoleccion" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background: var(--cacao-cream); color: var(--cacao-dark);">
                                <h5 class="modal-title">
                                    <i class="fas fa-info-circle"></i> 
                                    Detalle de Recolección - ${new Date(data.fecha_recoleccion).toLocaleDateString('es-ES')}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 style="color: var(--cacao-dark);">Información General</h6>
                                        <table class="table table-sm">
                                            <tr><td><strong>Cantidad:</strong></td><td>${data.cantidad_recolectada} kg</td></tr>
                                            <tr><td><strong>Estado del fruto:</strong></td><td>${data.estado_fruto}</td></tr>
                                            <tr><td><strong>Calidad promedio:</strong></td><td>${data.calidad_promedio}/10</td></tr>
                                            <tr><td><strong>Condiciones climáticas:</strong></td><td>${data.condiciones_climaticas}</td></tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 style="color: var(--cacao-dark);">Horarios y Duración</h6>
                                        <table class="table table-sm">
                                            <tr><td><strong>Hora inicio:</strong></td><td>${data.hora_inicio || 'N/A'}</td></tr>
                                            <tr><td><strong>Hora fin:</strong></td><td>${data.hora_fin || 'N/A'}</td></tr>
                                            <tr><td><strong>Duración:</strong></td><td>${data.duracion_horas ? data.duracion_horas + ' horas' : 'N/A'}</td></tr>
                                        </table>
                                    </div>
                                </div>
                                ${data.trabajadores_nombres ? 
                                    `<div class="mt-3">
                                        <h6 style="color: var(--cacao-dark);">Trabajadores Participantes</h6>
                                        <p class="text-muted">${data.trabajadores_nombres}</p>
                                    </div>` : ''
                                }
                                ${data.observaciones ? 
                                    `<div class="mt-3">
                                        <h6 style="color: var(--cacao-dark);">Observaciones</h6>
                                        <div class="alert alert-light">${data.observaciones}</div>
                                    </div>` : ''
                                }
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <a href="/recolecciones/${recoleccionId}/edit" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;
            
            // Remover modal existente si existe
            const existingModal = document.getElementById('modalDetalleRecoleccion');
            if (existingModal) existingModal.remove();
            
            // Agregar nuevo modal al DOM
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Mostrar modal
            new bootstrap.Modal(document.getElementById('modalDetalleRecoleccion')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar el detalle de la recolección');
        });
}

// Función para exportar historial de recolecciones
function exportarHistorialRecolecciones() {
    // Obtener el ID de producción del modal actual
    const modalTitle = document.querySelector('#modalRecolecciones .modal-title');
    if (!modalTitle) return;
    
    // Esta función se puede expandir para implementar exportación
    alert('Funcionalidad de exportación en desarrollo');
}

// Auto-actualizar cada 30 segundos
setInterval(() => {
    if (document.hidden) return;
    
    const urlActual = window.location.href;
    if (urlActual.includes('reporte')) {
        // Solo refrescar si no hay modales abiertos
        if (!document.querySelector('.modal.show')) {
            location.reload();
        }
    }
}, 30000);
</script>
@endpush
