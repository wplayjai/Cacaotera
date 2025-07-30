<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario</title>
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
            border-bottom: 2px solid #6F4E37;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #6F4E37;
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
            border-left: 4px solid #6F4E37;
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
        
        .total-productos {
            color: #007bff !important;
        }
        
        .valor-total {
            color: #28a745 !important;
        }
        
        .productos-optimos {
            color: #ffc107 !important;
        }
        
        .productos-alerta {
            color: #dc3545 !important;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        
        table thead {
            background-color: #6F4E37;
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
            border-left: 4px solid #6F4E37;
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
        <h1>📦 REPORTE DE INVENTARIO</h1>
        <p>Sistema de Gestión de Inventario CACAOSOF</p>
        <p>Generado el: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Filtros aplicados -->
    @if(count($filtros) > 0)
    <div class="filters">
        <h3>� Filtros Aplicados:</h3>
        @foreach($filtros as $label => $value)
            <p><strong>{{ $label }}:</strong> {{ $value }}</p>
        @endforeach
    </div>
    @endif

    <!-- Resumen estadístico -->
    <div class="summary">
        <div class="summary-item">
            <h4 class="total-productos">{{ $totalProductos }}</h4>
            <p>Total Productos</p>
        </div>
        <div class="summary-item">
            <h4 class="valor-total">${{ number_format($valorTotalInventario, 2) }}</h4>
            <p>Valor Stock</p>
        </div>
        <div class="summary-item">
            <h4 class="productos-optimos">{{ $totalSalidas }}</h4>
            <p>Total Salidas</p>
        </div>
        <div class="summary-item">
            <h4 class="productos-alerta">${{ number_format($valorTotalSalidas, 2) }}</h4>
            <p>Valor Salidas</p>
        </div>
    </div>

    @if($inventarios->count() > 0)
        <!-- Tabla de productos -->
        <table>
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Precio Unit.</th>
                    <th class="text-right">Valor Total</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventarios as $producto)
                <tr>
                    <td class="text-center">{{ $producto->id }}</td>
                    <td><strong>{{ $producto->nombre }}</strong></td>
                    <td>
                        @if($producto->tipo == 'Fertilizantes')
                            <span class="badge badge-success">🌱 {{ $producto->tipo }}</span>
                        @else
                            <span class="badge badge-warning">🛡️ {{ $producto->tipo }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <strong>{{ $producto->cantidad }}</strong> {{ $producto->unidad_medida }}
                    </td>
                    <td class="text-right">${{ number_format($producto->precio_unitario, 2) }}</td>
                    <td class="text-right">
                        <strong>${{ number_format($producto->cantidad * $producto->precio_unitario, 2) }}</strong>
                    </td>
                    <td class="text-center">
                        @if($producto->estado == 'Óptimo')
                            <span class="badge badge-success">✅ {{ $producto->estado }}</span>
                        @elseif($producto->estado == 'Por vencer')
                            <span class="badge badge-warning">⚠️ {{ $producto->estado }}</span>
                        @else
                            <span class="badge badge-danger">🔒 {{ $producto->estado }}</span>
                        @endif
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($producto->fecha_registro)->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Resumen final -->
        <div class="totals-summary">
            <h3>📊 Resumen del Inventario</h3>
            <div class="totals-row">
                <div class="totals-label">Total de productos registrados:</div>
                <div class="totals-value">{{ $totalProductos }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Valor total del inventario:</div>
                <div class="totals-value">${{ number_format($valorTotalInventario, 2) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Productos en estado óptimo:</div>
                <div class="totals-value">{{ $productosOptimos }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Productos que requieren atención:</div>
                <div class="totals-value">{{ $productosAlerta }}</div>
            </div>
        </div>

        @if($salidas->count() > 0)
            <!-- Sección de Salidas de Inventario -->
            <div style="page-break-before: always;"></div>
            
            <div class="header">
                <h1>📤 SALIDAS DE INVENTARIO</h1>
                <p>Insumos utilizados en Lotes y Producciones</p>
                <p>Total de salidas: {{ $salidas->count() }}</p>
            </div>

            <!-- Tabla de salidas -->
            <table>
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Insumo</th>
                        <th>Lote</th>
                        <th>Producción</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-right">Valor</th>
                        <th class="text-center">Fecha</th>
                        <th>Responsable</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salidas as $salida)
                    <tr>
                        <td class="text-center">{{ $salida->id }}</td>
                        <td>
                            <strong>{{ $salida->insumo ? $salida->insumo->nombre : 'N/A' }}</strong>
                            @if($salida->insumo)
                                <br>
                                @if($salida->insumo->tipo == 'Fertilizantes')
                                    <span class="badge badge-success">🌱 {{ $salida->insumo->tipo }}</span>
                                @else
                                    <span class="badge badge-warning">🛡️ {{ $salida->insumo->tipo }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($salida->lote)
                                <strong>{{ $salida->lote->nombre }}</strong><br>
                                <small>{{ $salida->lote->tipo_cacao }}</small>
                            @else
                                No especificado
                            @endif
                        </td>
                        <td class="text-center">
                            @if($salida->produccion)
                                <span class="badge badge-info">ID: {{ $salida->produccion->id }}</span>
                            @else
                                No asociado
                            @endif
                        </td>
                        <td class="text-center">
                            <strong>{{ $salida->cantidad }}</strong> {{ $salida->unidad_medida }}
                        </td>
                        <td class="text-right">
                            <strong>${{ number_format($salida->cantidad * $salida->precio_unitario, 2) }}</strong>
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($salida->fecha_salida)->format('d/m/Y') }}</td>
                        <td>{{ $salida->responsable ?? 'No especificado' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Resumen de salidas -->
            <div class="totals-summary">
                <h3>📈 Resumen de Salidas</h3>
                <div class="totals-row">
                    <div class="totals-label">Total de salidas registradas:</div>
                    <div class="totals-value">{{ $totalSalidas }}</div>
                </div>
                <div class="totals-row">
                    <div class="totals-label">Valor total de salidas:</div>
                    <div class="totals-value">${{ number_format($valorTotalSalidas, 2) }}</div>
                </div>
                <div class="totals-row">
                    <div class="totals-label">Promedio por salida:</div>
                    <div class="totals-value">${{ $totalSalidas > 0 ? number_format($valorTotalSalidas / $totalSalidas, 2) : '0.00' }}</div>
                </div>
            </div>
        @endif
    @else
        <div class="no-data">
            <i>📭</i>
            <h3>No hay productos registrados</h3>
            <p>No se encontraron productos que coincidan con los filtros aplicados.</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <strong>CACAOSOF - Sistema de Gestión de Inventario</strong><br>
        Reporte generado automáticamente el {{ date('d/m/Y') }} a las {{ date('H:i:s') }}<br>
        Este documento contiene información confidencial de la empresa.
    </div>
</body>
</html>
