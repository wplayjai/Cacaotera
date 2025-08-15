<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Rendimiento de Producción</title>
</head>
<style>
     body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #6f4e37;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #6f4e37;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .filters {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #6f4e37;
        }
        
        .filters h3 {
            margin: 0 0 10px 0;
            color: #495057;
            font-size: 14px;
        }
        
        .filters p {
            margin: 5px 0;
            font-size: 11px;
        }
        
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        
        .summary-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px 10px;
            background-color: #f5f5f5;
            border-radius: 8px;
            margin-right: 10px;
            vertical-align: top;
        }
        
        .summary-item:last-child {
            margin-right: 0;
        }
        
        .summary-item h4 {
            margin: 0 0 5px 0;
            font-size: 18px;
            color: #495057;
        }
        
        .summary-item p {
            margin: 0;
            font-size: 11px;
            color: #6c757d;
            font-weight: bold;
        }
        
        .productions {
            color: #6f4e37 !important;
        }
        
        .quantity {
            color: #28a745 !important;
        }
        
        .percentage {
            color: #17a2b8 !important;
        }
        
        .active {
            color: #ffc107 !important;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        
        table thead {
            background-color: #6f4e37;
            color: white;
        }
        
        table th,
        table td {
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        
        table th {
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        table tbody tr:hover {
            background-color: #e9ecef;
        }
        
        .text-center {
            text-align: center !important;
        }
        
        .text-right {
            text-align: right !important;
        }
        
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        
        .totals {
            margin-top: 20px;
            border-top: 2px solid #6f4e37;
            padding-top: 15px;
        }
        
        .totals-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .totals-label {
            display: table-cell;
            width: 70%;
            text-align: right;
            font-weight: bold;
            padding-right: 10px;
        }
        
        .totals-value {
            display: table-cell;
            width: 30%;
            text-align: right;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
        </style>
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
