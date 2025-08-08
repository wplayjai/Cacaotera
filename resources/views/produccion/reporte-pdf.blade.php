<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Rendimiento de Producción</title>
        <link rel="stylesheet" href="{{ asset('css/produccion/pdf.css') }}">
    
</head>
<body>
    <div class="header">
        <h1>Reporte de Rendimiento de Producción</h1>
        <p>Sistema de Gestión Cacaotera</p>
    </div>

    <!-- Filtros aplicados -->
    <div class="filters">
        <h3>📊 Filtros Aplicados</h3>
        @if(isset($fecha_inicio) && isset($fecha_fin))
            <p><strong>Periodo:</strong> {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</p>
        @endif
        @if(isset($estado) && $estado)
            <p><strong>Estado:</strong> {{ ucfirst($estado) }}</p>
        @endif
        <p><strong>Fecha de generación:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Resumen estadístico -->
    @php
        $totalProducciones = $producciones->count();
        $cantidadTotal = $producciones->sum('cantidad_estimada');
        $promedioRendimiento = $totalProducciones > 0 ? round($producciones->avg('rendimiento_estimado'), 1) : 0;
        $activas = $producciones->where('estado', 'activa')->count();
    @endphp
    
    <div class="summary">
        <div class="summary-item">
            <h4 class="productions">{{ $totalProducciones }}</h4>
            <p>Total Producciones</p>
        </div>
        <div class="summary-item">
            <h4 class="quantity">{{ number_format($cantidadTotal, 2) }} kg</h4>
            <p>Cantidad Estimada</p>
        </div>
        <div class="summary-item">
            <h4 class="percentage">{{ $promedioRendimiento }}%</h4>
            <p>Rendimiento Promedio</p>
        </div>
        <div class="summary-item">
            <h4 class="active">{{ $activas }}</h4>
            <p>Producciones Activas</p>
        </div>
    </div>

    <!-- Detalle de producciones -->
    <table>
        <thead>
            <tr>
                <th>Lote</th>
                <th>Tipo Cacao</th>
                <th>Fecha Inicio</th>
                <th>Fecha Estimada</th>
                <th>Cantidad Est.</th>
                <th>Rendimiento</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($producciones as $produccion)
                <tr>
                    <td><strong>{{ $produccion->lote->nombre ?? 'Sin lote' }}</strong></td>
                    <td>{{ $produccion->tipo_cacao }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($produccion->fecha_inicio)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if($produccion->fecha_cosecha_estimada)
                            {{ \Carbon\Carbon::parse($produccion->fecha_cosecha_estimada)->format('d/m/Y') }}
                        @else
                            <span style="color: #6c757d;">N/A</span>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($produccion->cantidad_estimada, 2) }} kg</td>
                    <td class="text-center">
                        @if($produccion->rendimiento_estimado >= 80)
                            <span class="badge badge-success">{{ $produccion->rendimiento_estimado }}%</span>
                        @elseif($produccion->rendimiento_estimado >= 60)
                            <span class="badge badge-warning">{{ $produccion->rendimiento_estimado }}%</span>
                        @else
                            <span class="badge badge-danger">{{ $produccion->rendimiento_estimado }}%</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @switch($produccion->estado)
                            @case('activa')
                                <span class="badge badge-success">Activa</span>
                                @break
                            @case('completada')
                                <span class="badge badge-info">Completada</span>
                                @break
                            @case('suspendida')
                                <span class="badge badge-warning">Suspendida</span>
                                @break
                            @case('cancelada')
                                <span class="badge badge-danger">Cancelada</span>
                                @break
                            @default
                                <span class="badge" style="background-color: #6c757d; color: white;">{{ ucfirst($produccion->estado) }}</span>
                        @endswitch
                    </td>
                    <td>{{ $produccion->observaciones ?? 'Sin observaciones' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #6c757d;">
                        No hay producciones registradas en el periodo seleccionado
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Totales finales -->
    <div class="totals">
        <div class="totals-row">
            <div class="totals-label">Total de producciones:</div>
            <div class="totals-value productions">{{ $totalProducciones }}</div>
        </div>
        <div class="totals-row">
            <div class="totals-label">Cantidad total estimada:</div>
            <div class="totals-value quantity">{{ number_format($cantidadTotal, 2) }} kg</div>
        </div>
        <div class="totals-row">
            <div class="totals-label">Rendimiento promedio:</div>
            <div class="totals-value percentage">{{ $promedioRendimiento }}%</div>
        </div>
        <div class="totals-row">
            <div class="totals-label">Producciones activas:</div>
            <div class="totals-value active">{{ $activas }} ({{ $totalProducciones > 0 ? round(($activas / $totalProducciones) * 100, 1) : 0 }}%)</div>
        </div>
    </div>

    <div class="footer">
        <p>Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }} | Sistema de Gestión Cacaotera</p>
    </div>
</body>
</html>
