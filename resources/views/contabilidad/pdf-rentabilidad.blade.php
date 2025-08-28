<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .header {
            background: linear-gradient(135deg, #4e342e 0%, #6b4e3d 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .info-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #6b4e3d;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: bold;
            color: #4e342e;
        }

        .resumen-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        .resumen-card {
            flex: 1;
            min-width: 200px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            color: white;
        }

        .resumen-card.gastos {
            background: #dc3545;
        }

        .resumen-card.ventas {
            background: #28a745;
        }

        .resumen-card.ganancia {
            background: #17a2b8;
        }

        .resumen-card.perdida {
            background: #dc3545;
        }

        .resumen-card h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .resumen-card .valor {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .resumen-card .descripcion {
            font-size: 11px;
            opacity: 0.9;
        }

        .lote-section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }

        .lote-header {
            background: #4e342e;
            color: white;
            padding: 12px 15px;
            border-radius: 6px 6px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lote-titulo {
            font-size: 16px;
            font-weight: bold;
        }

        .lote-badge {
            background: rgba(255,255,255,0.2);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
        }

        .lote-resumen {
            display: flex;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-top: none;
        }

        .lote-resumen-item {
            flex: 1;
            padding: 15px;
            text-align: center;
            border-right: 1px solid #dee2e6;
        }

        .lote-resumen-item:last-child {
            border-right: none;
        }

        .lote-resumen-item.gastos {
            background: #f8d7da;
            color: #721c24;
        }

        .lote-resumen-item.ventas {
            background: #d4edda;
            color: #155724;
        }

        .lote-resumen-item.ganancia {
            background: #d1ecf1;
            color: #0c5460;
        }

        .lote-resumen-item.perdida {
            background: #f8d7da;
            color: #721c24;
        }

        .lote-resumen-item h4 {
            font-size: 12px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .lote-resumen-item .valor {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .lote-resumen-item .detalle {
            font-size: 10px;
            opacity: 0.8;
        }

        .tabla-container {
            margin-top: 20px;
        }

        .tabla-titulo {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #4e342e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #4e342e;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .tabla-gastos th {
            background: #dc3545;
        }

        .tabla-ventas th {
            background: #28a745;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .subtotal-row {
            background: #f8f9fa;
            font-weight: bold;
        }

        .empty-message {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
            background: white;
        }

        .page-break {
            page-break-before: always;
        }

        /* Estilos para badges */
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .badge-info {
            background: #17a2b8;
            color: white;
        }

        .badge-secondary {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <div class="subtitle">
            AgroFinca - Sistema de Gestión de Cacao<br>
            Generado el {{ $fecha_generacion }}
        </div>
    </div>

    <!-- Información General -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Filtro aplicado:</span>
            <span>{{ $filtro_aplicado }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de lotes analizados:</span>
            <span>{{ $resumen['total_lotes'] }} lote(s)</span>
        </div>
        <div class="info-row">
            <span class="info-label">Lotes rentables:</span>
            <span>{{ $resumen['lotes_rentables'] ?? 0 }} de {{ $resumen['total_lotes'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Lotes con pérdidas:</span>
            <span>{{ $resumen['lotes_perdidas'] ?? 0 }} de {{ $resumen['total_lotes'] }}</span>
        </div>
    </div>

    <!-- Resumen General -->
    <div class="resumen-cards">
        <div class="resumen-card gastos">
            <h3>Total Gastos</h3>
            <div class="valor">${{ number_format($resumen['total_gastos'], 2) }}</div>
            <div class="descripcion">Insumos utilizados</div>
        </div>
        <div class="resumen-card ventas">
            <h3>Total Ventas</h3>
            <div class="valor">${{ number_format($resumen['total_ventas'], 2) }}</div>
            <div class="descripcion">Productos vendidos</div>
        </div>
        <div class="resumen-card {{ $resumen['ganancia_total'] >= 0 ? 'ganancia' : 'perdida' }}">
            <h3>{{ $resumen['ganancia_total'] >= 0 ? 'Ganancia Total' : 'Pérdida Total' }}</h3>
            <div class="valor">${{ number_format(abs($resumen['ganancia_total']), 2) }}</div>
            <div class="descripcion">
                ROI: {{ $resumen['total_gastos'] > 0 ? number_format(($resumen['ganancia_total'] / $resumen['total_gastos']) * 100, 1) : 0 }}%
            </div>
        </div>
    </div>

    <!-- Detalle por Lotes -->
    @forelse($lotes as $index => $lote)
        @if($index > 0)
            <div class="page-break"></div>
        @endif

        <div class="lote-section">
            <div class="lote-header">
                <div class="lote-titulo">
                    {{ $lote['lote_nombre'] }} ({{ $lote['tipo_cacao'] }})
                </div>
                <div class="lote-badge">
                    {{ $lote['lote_estado'] }} - {{ $lote['area'] }} hectáreas
                </div>
            </div>

            <div class="lote-resumen">
                <div class="lote-resumen-item gastos">
                    <h4>Gastos en Insumos</h4>
                    <div class="valor">${{ number_format($lote['total_gastado'], 2) }}</div>
                    <div class="detalle">{{ $lote['cantidad_insumos'] }} insumo(s)</div>
                </div>
                <div class="lote-resumen-item ventas">
                    <h4>Ventas Realizadas</h4>
                    <div class="valor">${{ number_format($lote['total_vendido'], 2) }}</div>
                    <div class="detalle">{{ $lote['cantidad_ventas'] }} venta(s)</div>
                </div>
                <div class="lote-resumen-item {{ $lote['ganancia'] >= 0 ? 'ganancia' : 'perdida' }}">
                    <h4>{{ $lote['ganancia'] >= 0 ? 'Ganancia' : 'Pérdida' }}</h4>
                    <div class="valor">${{ number_format(abs($lote['ganancia']), 2) }}</div>
                    <div class="detalle">
                        {{ $lote['rentabilidad'] }}% rentabilidad
                    </div>
                </div>
            </div>

            <!-- Tabla de Insumos -->
            @if(count($lote['insumos_detalle']) > 0)
                <div class="tabla-container">
                    <div class="tabla-titulo">📦 Insumos Utilizados</div>
                    <table class="tabla-gastos">
                        <thead>
                            <tr>
                                <th>Insumo</th>
                                <th>Cantidad</th>
                                <th>Precio Unit.</th>
                                <th>Valor Total</th>
                                <th>Fecha</th>
                                <th>Responsable</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lote['insumos_detalle'] as $insumo)
                                <tr>
                                    <td>
                                        <strong>{{ $insumo['insumo_nombre'] }}</strong>
                                        @if($insumo['motivo'] && $insumo['motivo'] !== 'Sin especificar')
                                            <br><small>{{ $insumo['motivo'] }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $insumo['cantidad'] }} {{ $insumo['unidad_medida'] }}</td>
                                    <td class="text-right">${{ number_format($insumo['precio_unitario'], 2) }}</td>
                                    <td class="text-right fw-bold">${{ number_format($insumo['valor_total'], 2) }}</td>
                                    <td class="text-center">{{ $insumo['fecha_salida'] }}</td>
                                    <td>{{ $insumo['responsable'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="subtotal-row">
                                <td colspan="3" class="text-right fw-bold">Subtotal Gastos:</td>
                                <td class="text-right fw-bold">${{ number_format($lote['total_gastado'], 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="tabla-container">
                    <div class="tabla-titulo">📦 Insumos Utilizados</div>
                    <div class="empty-message">
                        No hay insumos registrados para este lote
                    </div>
                </div>
            @endif

            <!-- Tabla de Ventas -->
            @if(count($lote['ventas_detalle']) > 0)
                <div class="tabla-container">
                    <div class="tabla-titulo">💰 Ventas Realizadas</div>
                    <table class="tabla-ventas">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Cantidad (kg)</th>
                                <th>Precio/kg</th>
                                <th>Total Venta</th>
                                <th>Fecha</th>
                                <th>Estado Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lote['ventas_detalle'] as $venta)
                                <tr>
                                    <td>
                                        <strong>{{ $venta['cliente'] }}</strong>
                                        @if($venta['metodo_pago'] && $venta['metodo_pago'] !== 'Sin especificar')
                                            <br><small>{{ $venta['metodo_pago'] }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $venta['cantidad_vendida'] }} kg</td>
                                    <td class="text-right">${{ number_format($venta['precio_por_kg'], 2) }}</td>
                                    <td class="text-right fw-bold">${{ number_format($venta['total_venta'], 2) }}</td>
                                    <td class="text-center">{{ $venta['fecha_venta'] }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $venta['estado_pago'] === 'pagado' ? 'badge-success' : ($venta['estado_pago'] === 'pendiente' ? 'badge-warning' : 'badge-danger') }}">
                                            {{ ucfirst($venta['estado_pago']) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="subtotal-row">
                                <td colspan="3" class="text-right fw-bold">Subtotal Ventas:</td>
                                <td class="text-right fw-bold">${{ number_format($lote['total_vendido'], 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="tabla-container">
                    <div class="tabla-titulo">💰 Ventas Realizadas</div>
                    <div class="empty-message">
                        No hay ventas registradas para este lote
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="empty-message">
            <h3>No hay datos disponibles</h3>
            <p>No se encontraron lotes con información de rentabilidad.</p>
        </div>
    @endforelse

    <!-- Footer -->
    <div class="footer">
        <strong>AgroFinca - Sistema de Gestión de Cacao</strong><br>
        Reporte de rentabilidad generado automáticamente el {{ $fecha_generacion }}<br>
        Este documento contiene información confidencial de la empresa.
    </div>
</body>
</html>
