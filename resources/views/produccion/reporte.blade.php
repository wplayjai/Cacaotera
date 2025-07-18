@extends('layouts.masterr')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-chart-line"></i> Reporte de Rendimiento de Producción</h4>
                    <div>
                        <button class="btn btn-light btn-sm" onclick="exportarReporte('pdf')">
                            <i class="fas fa-file-pdf"></i> Exportar PDF
                        </button>
                        <button class="btn btn-light btn-sm" onclick="exportarReporte('excel')">
                            <i class="fas fa-file-excel"></i> Exportar Excel
                        </button>
                        <a href="{{ route('produccion.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filtros de Reporte -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form id="filtrosReporte" method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Fecha Desde</label>
                                        <input type="date" id="fechaDesde" name="fecha_desde" class="form-control" 
                                               value="{{ request('fecha_desde', now()->subMonths(3)->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Fecha Hasta</label>
                                        <input type="date" id="fechaHasta" name="fecha_hasta" class="form-control" 
                                               value="{{ request('fecha_hasta', now()->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Estado</label>
                                        <select id="estadoFiltro" name="estado" class="form-select">
                                            <option value="">Todos los estados</option>
                                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                                            <option value="cosecha" {{ request('estado') == 'cosecha' ? 'selected' : '' }}>En Cosecha</option>
                                            <option value="maduracion" {{ request('estado') == 'maduracion' ? 'selected' : '' }}>Maduración</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
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
                                </div>
                                <div class="row mt-3">
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
                            <div class="card bg-primary text-white">
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
                            <div class="card bg-success text-white">
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
                            <div class="card bg-warning text-white">
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
                            <div class="card bg-info text-white">
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
                                <div class="card-header bg-warning text-dark">
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-calendar-day"></i> Historial de Recolecciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="contenidoRecolecciones">
                <!-- Contenido cargado dinámicamente -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Datos para los gráficos
const rendimientoPorMes = @json($rendimientoPorMes);
const distribucionTipos = @json($distribucionTipos);

// Gráfico de Rendimiento por Mes
const ctxRendimiento = document.getElementById('rendimientoChart').getContext('2d');
new Chart(ctxRendimiento, {
    type: 'line',
    data: {
        labels: rendimientoPorMes.map(item => item.mes),
        datasets: [{
            label: 'Rendimiento Promedio (%)',
            data: rendimientoPorMes.map(item => item.rendimiento_promedio),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Evolución del Rendimiento'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 150
            }
        }
    }
});

// Gráfico de Distribución por Tipos
const ctxTipos = document.getElementById('tiposCacaoChart').getContext('2d');
new Chart(ctxTipos, {
    type: 'doughnut',
    data: {
        labels: distribucionTipos.map(item => item.tipo),
        datasets: [{
            data: distribucionTipos.map(item => item.cantidad),
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
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
    const params = new URLSearchParams(window.location.search);
    params.set('formato', formato);
    window.open(`{{ route('produccion.reporte_rendimiento') }}?${params.toString()}`, '_blank');
}

function verRecolecciones(produccionId) {
    fetch(`/recolecciones/produccion/${produccionId}/lista`)
        .then(response => response.json())
        .then(data => {
            let html = '<div class="table-responsive">';
            html += '<table class="table table-sm">';
            html += '<thead><tr><th>Fecha</th><th>Cantidad (kg)</th><th>Estado Fruto</th><th>Trabajadores</th></tr></thead>';
            html += '<tbody>';
            
            data.forEach(recoleccion => {
                html += `<tr>
                    <td>${new Date(recoleccion.fecha_recoleccion).toLocaleDateString()}</td>
                    <td>${recoleccion.cantidad_recolectada} kg</td>
                    <td><span class="badge bg-success">${recoleccion.estado_fruto}</span></td>
                    <td>${recoleccion.trabajadores_participantes ? recoleccion.trabajadores_participantes.length : 0} trabajadores</td>
                </tr>`;
            });
            
            html += '</tbody></table></div>';
            
            document.getElementById('contenidoRecolecciones').innerHTML = html;
            new bootstrap.Modal(document.getElementById('modalRecolecciones')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('contenidoRecolecciones').innerHTML = 
                '<div class="alert alert-danger">Error al cargar las recolecciones</div>';
        });
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
