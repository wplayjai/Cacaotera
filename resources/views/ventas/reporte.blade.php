<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
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
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .filters {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
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
            background-color: #f8f9fa;
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
        
        .amount {
            color: #28a745 !important;
        }
        
        .pending {
            color: #ffc107 !important;
        }
        
        .paid {
            color: #28a745 !important;
        }
        
        .quantity {
            color: #17a2b8 !important;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        
        table thead {
            background-color: #343a40;
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
        
        .method-icon {
            font-weight: bold;
            font-size: 9px;
        }
        
        .efectivo {
            color: #28a745;
        }
        
        .transferencia {
            color: #007bff;
        }
        
        .cheque {
            color: #17a2b8;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
        }
        
        .totals-summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border-left: 4px solid #28a745;
        }
        
        .totals-summary h3 {
            margin: 0 0 10px 0;
            color: #495057;
            font-size: 14px;
        }
        
        .totals-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        
        .totals-label {
            display: table-cell;
            width: 70%;
            font-weight: bold;
            font-size: 11px;
        }
        
        .totals-value {
            display: table-cell;
            width: 30%;
            text-align: right;
            font-weight: bold;
            font-size: 11px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }
        
        .no-data i {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .summary {
                page-break-inside: avoid;
            }
            
            table {
                page-break-inside: auto;
            }
            
            table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📊 REPORTE DE VENTAS</h1>
        <p>Sistema de Gestión de Cacao</p>
        <p>Generado el: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Filtros aplicados -->
    <div class="filters">
        <h3>🔍 Filtros Aplicados:</h3>
        <p><strong>Fecha desde:</strong> {{ $fechaDesde ? date('d/m/Y', strtotime($fechaDesde)) : 'Sin filtro' }}</p>
        <p><strong>Fecha hasta:</strong> {{ $fechaHasta ? date('d/m/Y', strtotime($fechaHasta)) : 'Sin filtro' }}</p>
        <p><strong>Estado de pago:</strong> {{ $estadoPago ? ucfirst($estadoPago) : 'Todos los estados' }}</p>
    </div>

    <!-- Resumen estadístico -->
    <div class="summary">
        <div class="summary-item">
            <h4 class="quantity">{{ number_format($totalVentas) }}</h4>
            <p>Total Ventas</p>
        </div>
        <div class="summary-item">
            <h4 class="amount">${{ number_format($montoTotal, 2) }}</h4>
            <p>Monto Total</p>
        </div>
        <div class="summary-item">
            <h4 class="quantity">{{ number_format($cantidadTotal, 2) }} kg</h4>
            <p>Cantidad Total</p>
        </div>
        <div class="summary-item">
            <h4 class="paid">{{ $ventasPagadas }}</h4>
            <p>Pagadas</p>
        </div>
    </div>

    @if($ventas->count() > 0)
        <!-- Tabla de ventas -->
        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Lote/Tipo</th>
                    <th class="text-right">Cantidad (kg)</th>
                    <th class="text-right">Precio/kg</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Método</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td class="text-center">{{ $venta->id }}</td>
                    <td>{{ $venta->fecha_venta->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $venta->cliente }}</strong>
                        @if($venta->telefono_cliente)
                            <br><small>{{ $venta->telefono_cliente }}</small>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $venta->recoleccion->produccion->lote->nombre ?? 'Sin lote' }}</strong>
                        <br><small>{{ $venta->recoleccion->produccion->tipo_cacao }}</small>
                    </td>
                    <td class="text-right">{{ number_format($venta->cantidad_vendida, 2) }}</td>
                    <td class="text-right">${{ number_format($venta->precio_por_kg, 2) }}</td>
                    <td class="text-right"><strong>${{ number_format($venta->total_venta, 2) }}</strong></td>
                    <td class="text-center">
                        <span class="badge badge-{{ $venta->estado_pago == 'pagado' ? 'success' : 'warning' }}">
                            {{ ucfirst($venta->estado_pago) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="method-icon {{ $venta->metodo_pago }}">
                            @switch($venta->metodo_pago)
                                @case('efectivo')
                                    💵 EFE
                                    @break
                                @case('transferencia')
                                    🏦 TRA
                                    @break
                                @case('cheque')
                                    📋 CHE
                                    @break
                                @default
                                    {{ strtoupper(substr($venta->metodo_pago, 0, 3)) }}
                            @endswitch
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Resumen de totales -->
        <div class="totals-summary">
            <h3>📋 Resumen Financiero:</h3>
            <div class="totals-row">
                <div class="totals-label">Total de Ventas:</div>
                <div class="totals-value">{{ number_format($totalVentas) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Cantidad Total Vendida:</div>
                <div class="totals-value">{{ number_format($cantidadTotal, 2) }} kg</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Monto Total Vendido:</div>
                <div class="totals-value amount">${{ number_format($montoTotal, 2) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Ventas Pagadas:</div>
                <div class="totals-value paid">{{ $ventasPagadas }} ({{ $totalVentas > 0 ? number_format(($ventasPagadas/$totalVentas)*100, 1) : 0 }}%)</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Ventas Pendientes:</div>
                <div class="totals-value pending">{{ $ventasPendientes }} ({{ $totalVentas > 0 ? number_format(($ventasPendientes/$totalVentas)*100, 1) : 0 }}%)</div>
            </div>
            @if($ventasPendientes > 0)
            <div class="totals-row">
                <div class="totals-label">Monto Pendiente de Cobro:</div>
                <div class="totals-value pending">${{ number_format($ventas->where('estado_pago', 'pendiente')->sum('total_venta'), 2) }}</div>
            </div>
            @endif
            <div class="totals-row">
                <div class="totals-label">Precio Promedio por kg:</div>
                <div class="totals-value">${{ $cantidadTotal > 0 ? number_format($montoTotal/$cantidadTotal, 2) : '0.00' }}</div>
            </div>
        </div>
    @else
        <div class="no-data">
            <i>📊</i>
            <h3>No hay datos para mostrar</h3>
            <p>No se encontraron ventas con los filtros aplicados.</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema de Gestión de Cacao</p>
        <p>© {{ date('Y') }} - Todos los derechos reservados</p>
    </div>
</body>
</html>