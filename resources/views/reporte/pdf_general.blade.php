<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General - Sistema Cacaotera</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            color: #2c3e50;
            line-height: 1.6;
            background: white;
            padding: 0;
            margin: 0;
        }

        .container {
            width: 100%;
            margin: 0;
            background: white;
            overflow: visible;
            min-height: 100vh;
        }

        /* Configuración específica para PDF */
        @page {
            size: A4;
            margin: 12mm;
        }

        @media print {
            body {
                background: white !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            .container {
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            
            .card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }

        /* Header más espacioso */
        .header {
            background: #4a6fa5;
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 12px;
            letter-spacing: 2px;
        }

        .header .subtitle {
            font-size: 18px;
            opacity: 0.95;
            margin-bottom: 25px;
        }

        .header-info {
            display: table;
            width: 100%;
            font-size: 14px;
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: 20px;
        }

        .header-info > div {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            vertical-align: middle;
        }

        /* Métricas más amplias */
        .metrics {
            padding: 35px 30px;
            background: #fff;
            border-bottom: 2px solid #e9ecef;
        }

        .metrics-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .metric {
            display: table-cell;
            width: 16.66%;
            text-align: center;
            padding: 25px 15px;
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            vertical-align: middle;
            position: relative;
            margin: 0 5px;
        }

        .metric + .metric {
            border-left: 1px solid #e9ecef;
        }

        .metric.primary { border-left-color: #e74c3c; }
        .metric.success { border-left-color: #27ae60; }
        .metric.warning { border-left-color: #f39c12; }
        .metric.info { border-left-color: #3498db; }

        .metric-value {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            display: block;
            margin-bottom: 8px;
        }

        .metric-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        /* Layout principal más espacioso */
        .main-content {
            padding: 0 30px 30px;
        }

        .grid {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 25px;
        }

        .grid .card {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }

        .grid .card:last-child {
            padding-right: 0;
            padding-left: 15px;
        }

        .grid.full .card {
            display: block;
            width: 100%;
            padding: 0;
        }

        /* Cards más amplias */
        .card {
            background: white;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            break-inside: avoid;
            min-height: 300px;
        }

        .card-header {
            background: #f8f9fa;
            padding: 20px 25px;
            border-bottom: 2px solid #dee2e6;
            display: table;
            width: 100%;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #495057;
            display: table-cell;
            vertical-align: middle;
        }

        .card-count {
            background: #6c757d;
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        /* Tablas más espaciosas */
        .table-container {
            max-height: none;
            overflow: visible;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            background: #f1f3f4;
            padding: 15px 12px;
            text-align: left;
            font-weight: 700;
            font-size: 12px;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid #f8f9fa;
            vertical-align: middle;
            font-size: 13px;
        }

        tr:nth-child(even) td {
            background-color: #f8f9fa;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        tr:hover td {
            background-color: #e3f2fd;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        /* Badges más grandes */
        .badge {
            padding: 6px 12px;
            font-size: 10px;
            font-weight: 700;
            text-align: center;
            border-radius: 15px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: white;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .badge-activo { background: #28a745; }
        .badge-optimo { background: #28a745; }
        .badge-completado { background: #28a745; }
        .badge-pagado { background: #28a745; }
        .badge-cosecha { background: #fd7e14; }
        .badge-maduracion { background: #6f42c1; }

        /* Estados sin datos */
        .no-data {
            text-align: center;
            padding: 60px 30px;
            color: #6c757d;
            font-style: italic;
            font-size: 16px;
        }

        /* Utilidades */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-weight-bold { font-weight: 700; }
        .text-success { color: #28a745; font-weight: 600; }
        .text-danger { color: #dc3545; font-weight: 600; }
        .bg-success { background-color: #d4edda; }
        .bg-danger { background-color: #f8d7da; }

        /* Footer más espacioso */
        .footer {
            background: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 2px solid #e9ecef;
            font-size: 13px;
            color: #6c757d;
            margin-top: 30px;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .footer p {
            margin-bottom: 5px;
        }

        /* Espaciado adicional para elementos */
        .card-title {
            font-size: 18px;
        }

        /* Mejorar legibilidad */
        .metric-value {
            font-size: 28px;
        }

        .metric-label {
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>🍫 REPORTE SISTEMA CACAOTERA</h1>
                <p class="subtitle">Sistema Integral de Gestión Cacaotera</p>
                <div class="header-info">
                    <div><strong>Generado:</strong> 15/08/2025 04:17:12</div>
                    <div><strong>Usuario:</strong> Administrador</div>
                    <div><strong>Período:</strong> Todos los registros</div>
                </div>
            </div>
        </div>

        <!-- Métricas principales -->
        <div class="metrics">
            <div class="metrics-grid">
                <div class="metric primary">
                    <span class="metric-value">3</span>
                    <span class="metric-label">Lotes Activos</span>
                </div>
                <div class="metric success">
                    <span class="metric-value">1 kg</span>
                    <span class="metric-label">Producción Total</span>
                </div>
                <div class="metric success">
                    <span class="metric-value">$99,999</span>
                    <span class="metric-label">Ingresos Totales</span>
                </div>
                <div class="metric warning">
                    <span class="metric-value">0.0%</span>
                    <span class="metric-label">Rentabilidad</span>
                </div>
                <div class="metric info">
                    <span class="metric-value">1</span>
                    <span class="metric-label">Personal Activo</span>
                </div>
                <div class="metric info">
                    <span class="metric-value">$289,366</span>
                    <span class="metric-label">Valor Inventario</span>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="main-content">
            <!-- Primera fila: Lotes e Inventario -->
            <div class="grid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            🏞️ GESTIÓN DE LOTES
                        </div>
                        <div class="card-count">3 registros</div>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Lote</th>
                                    <th>Área</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">N1</td>
                                    <td class="text-right">522.00 ha</td>
                                    <td>EET-96</td>
                                    <td><span class="badge badge-activo">ACTIVO</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">n3</td>
                                    <td class="text-right">5.00 ha</td>
                                    <td>ICS-95</td>
                                    <td><span class="badge badge-activo">ACTIVO</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">juan</td>
                                    <td class="text-right">122222.00 ha</td>
                                    <td>CC-137</td>
                                    <td><span class="badge badge-activo">ACTIVO</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            📦 INVENTARIO
                        </div>
                        <div class="card-count">3 registros</div>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Urea</td>
                                    <td class="text-right">4.00 kg</td>
                                    <td class="text-right text-success">$25,000.00</td>
                                    <td><span class="badge badge-optimo">ÓPTIMO</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Cloruro de potasio</td>
                                    <td class="text-right">34.00 kg</td>
                                    <td class="text-right text-success">$5,550.00</td>
                                    <td><span class="badge badge-optimo">ÓPTIMO</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Cloruro de potasio</td>
                                    <td class="text-right">2.00 kg</td>
                                    <td class="text-right text-success">$333.00</td>
                                    <td><span class="badge badge-optimo">ÓPTIMO</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Segunda fila: Ventas y Producción -->
            <div class="grid">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            💰 VENTAS
                        </div>
                        <div class="card-count">1 registros</div>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">juan</td>
                                    <td class="text-right">3.00 kg</td>
                                    <td class="text-right text-success">$99,999.00</td>
                                    <td><span class="badge badge-pagado">PAGADO</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            🌱 PRODUCCIÓN
                        </div>
                        <div class="card-count">4 registros</div>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Lote</th>
                                    <th>Tipo</th>
                                    <th>Estimado</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">1</td>
                                    <td>Eet-96</td>
                                    <td class="text-right">5.00 kg</td>
                                    <td><span class="badge badge-completado">COMPLETADO</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">1</td>
                                    <td>Eet-96</td>
                                    <td class="text-right">5.00 kg</td>
                                    <td><span class="badge badge-maduracion">MADURACION</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">2</td>
                                    <td>Ics-95</td>
                                    <td class="text-right">1.00 kg</td>
                                    <td><span class="badge badge-completado">COMPLETADO</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">3</td>
                                    <td>Cc-137</td>
                                    <td class="text-right">122.00 kg</td>
                                    <td><span class="badge badge-cosecha">COSECHA</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tercera fila: Recursos Humanos (ancho completo) -->
            <div class="grid full">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            👥 RECURSOS HUMANOS
                        </div>
                        <div class="card-count">1 registros</div>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Teléfono</th>
                                    <th>Fecha Contratación</th>
                                    <th>Tipo Contrato</th>
                                    <th>Forma Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Juan David</td>
                                    <td>3043667236</td>
                                    <td class="text-center">14/08/2025</td>
                                    <td>Indefinido</td>
                                    <td>Transferencia</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Contabilidad -->
        <div class="section-break"></div>
        <div class="section">
            <h2 class="section-title">📊 ANÁLISIS DE CONTABILIDAD Y RENTABILIDAD</h2>
            
            <!-- Resumen General Contabilidad -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        💰 RESUMEN GENERAL DE RENTABILIDAD
                    </div>
                </div>
                <div class="table-container">
                    <table>
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">Total Gastos en Insumos:</td>
                                <td class="text-right">${{ number_format($datosCompletos['contabilidad']['resumen_general']['total_gastos'], 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Total Ventas Generadas:</td>
                                <td class="text-right">${{ number_format($datosCompletos['contabilidad']['resumen_general']['total_ventas'], 2) }}</td>
                            </tr>
                            <tr class="{{ $datosCompletos['contabilidad']['resumen_general']['ganancia_total'] >= 0 ? 'bg-success' : 'bg-danger' }}">
                                <td class="font-weight-bold">Ganancia/Pérdida Total:</td>
                                <td class="text-right font-weight-bold">
                                    ${{ number_format($datosCompletos['contabilidad']['resumen_general']['ganancia_total'], 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Rentabilidad General (%):</td>
                                <td class="text-right">{{ number_format($datosCompletos['contabilidad']['resumen_general']['rentabilidad_general'], 2) }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Detalle por Lotes -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        🌱 RENTABILIDAD POR LOTES ACTIVOS
                    </div>
                    <div class="card-count">{{ count($datosCompletos['contabilidad']['resumen_lotes']) }} lotes</div>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Lote</th>
                                <th>Gastos Insumos</th>
                                <th>Total Ventas</th>
                                <th>Ganancia/Pérdida</th>
                                <th>Rentabilidad (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($datosCompletos['contabilidad']['resumen_lotes'] as $lote)
                                <tr>
                                    <td class="font-weight-bold">{{ $lote['nombre'] }}</td>
                                    <td class="text-right">${{ number_format($lote['total_gastos'], 2) }}</td>
                                    <td class="text-right">${{ number_format($lote['total_ventas'], 2) }}</td>
                                    <td class="text-right {{ $lote['ganancia'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        ${{ number_format($lote['ganancia'], 2) }}
                                    </td>
                                    <td class="text-right">{{ number_format($lote['rentabilidad'], 2) }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay lotes activos en producción</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Detalle de Insumos por Lote -->
            @foreach($datosCompletos['contabilidad']['resumen_lotes'] as $lote)
                @if(count($lote['insumos']) > 0)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                🧪 INSUMOS UTILIZADOS - {{ $lote['nombre'] }}
                            </div>
                            <div class="card-count">{{ count($lote['insumos']) }} insumos</div>
                        </div>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Insumo</th>
                                        <th>Cantidad Total</th>
                                        <th>Costo Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lote['insumos'] as $insumo)
                                        <tr>
                                            <td>{{ $insumo['nombre'] }}</td>
                                            <td class="text-center">{{ $insumo['cantidad'] }}</td>
                                            <td class="text-right">${{ number_format($insumo['costo_total'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>🌿 Sistema Integral de Gestión Cacaotera</strong></p>
            <p>Reporte generado automáticamente el 15/08/2025 04:17:12 por Administrador</p>
        </div>
    </div>
</body>
</html>