<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte {{ ucfirst($tipo) }} - {{ $fecha_generacion }}</title>
    <style>
        /* ESTILO PROFESIONAL CAFÉ EMPRESARIAL PARA PDF INDIVIDUAL */
        @page {
            margin: 1.5cm;
            size: A4;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 8px;
            line-height: 1.2;
            color: #2C1810;
            background: #ffffff;
        }
        
        /* ENCABEZADO EMPRESARIAL */
        .header-container {
            background: linear-gradient(135deg, #6F4E37 0%, #8B4513 50%, #A0522D 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
            border: 3px solid #8B4513;
        }
        
        .header-container h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .header-container .subtitle {
            font-size: 10px;
            opacity: 0.9;
            margin-bottom: 8px;
        }
        
        .header-info {
            font-size: 9px;
            opacity: 0.8;
        }
        
        /* MÉTRICAS DEL MÓDULO */
        .module-metrics {
            background: #f8f6f3;
            padding: 12px 15px;
            border: 2px solid #8B4513;
            border-radius: 8px;
            display: flex;
            justify-content: space-around;
            text-align: center;
            margin-bottom: 15px;
        }
        
        .metric-item {
            flex: 1;
            padding: 0 10px;
        }
        
        .metric-value {
            font-size: 16px;
            font-weight: bold;
            color: #6F4E37;
            display: block;
        }
        
        .metric-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
            margin-top: 2px;
        }
        
        /* TABLAS PROFESIONALES */
        .table-container {
            border: 2px solid #8B4513;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .table-header {
            background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%);
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 12px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        th {
            background: linear-gradient(135deg, #8B4513 0%, #6F4E37 100%);
            color: white;
            padding: 8px 6px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            border: none;
        }
        
        td {
            padding: 6px;
            font-size: 7px;
            border-bottom: 1px solid #e8e4e0;
            text-align: center;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: #faf9f7;
        }
        
        tr:hover {
            background-color: #f0ece8;
        }
        
        /* BADGES Y ESTADOS */
        .badge {
            padding: 3px 6px;
            border-radius: 12px;
            font-size: 6px;
            font-weight: bold;
            color: white;
            display: inline-block;
            text-align: center;
            min-width: 50px;
        }
        
        .badge-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
        .badge-warning { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: #2C1810; }
        .badge-info { background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); }
        .badge-secondary { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); }
        .badge-cafe { background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%); color: #2C1810; }
        
        /* RESUMEN */
        .summary-section {
            background: linear-gradient(135deg, #A0522D 0%, #CD853F 100%);
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-top: 15px;
            border: 2px solid #8B4513;
        }
        
        .summary-section h3 {
            font-size: 10px;
            margin-bottom: 6px;
            font-weight: bold;
        }
        
        .summary-content {
            font-size: 8px;
            line-height: 1.3;
        }
        
        /* FOOTER */
        .footer {
            position: fixed;
            bottom: 1cm;
            left: 1.5cm;
            right: 1.5cm;
            text-align: center;
            font-size: 7px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
            border-radius: 8px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }
        
        .company-info h1 {
            color: #6F4E37;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .company-info .subtitle {
            color: #8B4513;
            font-size: 11px;
            font-style: italic;
        }
        
        .report-info {
            text-align: right;
            background: #F5F1EA;
            padding: 10px;
            border-radius: 6px;
            border-left: 4px solid #6F4E37;
        }
        
        .report-info .report-title {
            color: #6F4E37;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .report-info .report-details {
            color: #5D4037;
            font-size: 9px;
            line-height: 1.4;
        }
        
        /* SECCIÓN DE MÓDULO */
        .module-section {
            background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%);
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .module-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .module-description {
            font-size: 10px;
            opacity: 0.9;
        }
        
        /* TABLAS PROFESIONALES */
        .table-container {
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(111, 78, 55, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        
        thead th {
            background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%);
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        tbody tr {
            border-bottom: 1px solid #E5E5E5;
        }
        
        tbody tr:nth-child(even) {
            background-color: #F9F7F4;
        }
        
        tbody tr:hover {
            background-color: #F5F1EA;
        }
        
        tbody td {
            padding: 10px 8px;
            color: #2C1810;
            vertical-align: top;
        }
        
        /* ESTILOS ESPECÍFICOS POR TIPO DE DATO */
        .number {
            text-align: right;
            font-weight: 600;
            color: #6F4E37;
        }
        
        .date {
            color: #8B4513;
            font-size: 8px;
        }
        
        .status {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
        }
        
        .status.activo {
            background: #E8F5E8;
            color: #2E7D32;
        }
        
        .status.inactivo {
            background: #FFEBEE;
            color: #C62828;
        }
        
        /* RESUMEN Y TOTALES */
        .summary-section {
            background: #F5F1EA;
            border: 2px solid #6F4E37;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .summary-title {
            color: #6F4E37;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        
        .summary-item {
            text-align: center;
            padding: 8px;
            background: white;
            border-radius: 6px;
            border: 1px solid #DDD;
        }
        
        .summary-item .label {
            color: #8B4513;
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .summary-item .value {
            color: #6F4E37;
            font-size: 11px;
            font-weight: bold;
        }
        
        /* PIE DE PÁGINA */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #6F4E37;
            text-align: center;
            color: #8B4513;
            font-size: 8px;
        }
        
        .footer-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .generated-info {
            font-style: italic;
        }
        
        .page-number {
            font-weight: bold;
        }
        
        /* UTILIDADES */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <!-- ENCABEZADO EMPRESARIAL -->
    <div class="header-container">
        <h1>📊 REPORTE DE {{ strtoupper($tipo) }}</h1>
        <div class="subtitle">Sistema de Gestión de Inventario CACAOSOF</div>
        <div class="header-info">Generado el: {{ $fecha_generacion }}</div>
    </div>

    <!-- MÉTRICAS DEL MÓDULO -->
    @if(isset($datos['items']) && count($datos['items']) > 0)
    <div class="module-metrics">
        @switch($tipo)
            @case('inventario')
                <div class="metric-item">
                    <span class="metric-value">{{ count($datos['items']) }}</span>
                    <span class="metric-label">Total Productos</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">${{ number_format(collect($datos['items'])->sum('valor_total')) }}</span>
                    <span class="metric-label">Valor Stock</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">{{ collect($datos['items'])->where('estado', 'Óptimo')->count() }}</span>
                    <span class="metric-label">Estado Óptimo</span>
                </div>
                @break
            @case('lote')
                <div class="metric-item">
                    <span class="metric-value">{{ count($datos['items']) }}</span>
                    <span class="metric-label">Total Lotes</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">{{ number_format(collect($datos['items'])->sum('area')) }}</span>
                    <span class="metric-label">Área Total (m²)</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">{{ number_format(collect($datos['items'])->sum('capacidad')) }}</span>
                    <span class="metric-label">Capacidad Total</span>
                </div>
                @break
            @case('ventas')
                <div class="metric-item">
                    <span class="metric-value">{{ count($datos['items']) }}</span>
                    <span class="metric-label">Total Ventas</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">${{ number_format(collect($datos['items'])->sum('precio_total')) }}</span>
                    <span class="metric-label">Ingresos Totales</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">${{ number_format(collect($datos['items'])->avg('precio_total')) }}</span>
                    <span class="metric-label">Promedio por Venta</span>
                </div>
                @break
            @case('produccion')
                <div class="metric-item">
                    <span class="metric-value">{{ count($datos['items']) }}</span>
                    <span class="metric-label">Total Procesos</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">{{ number_format(collect($datos['items'])->sum('area')) }}</span>
                    <span class="metric-label">Área Total (m²)</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">{{ number_format(collect($datos['items'])->avg('rendimiento'), 2) }}</span>
                    <span class="metric-label">Rendimiento Prom.</span>
                </div>
                @break
            @case('trabajadores')
                <div class="metric-item">
                    <span class="metric-value">{{ count($datos['items']) }}</span>
                    <span class="metric-label">Total Trabajadores</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">{{ collect($datos['items'])->where('estado', 'Activo')->count() }}</span>
                    <span class="metric-label">Activos</span>
                </div>
                <div class="metric-item">
                    <span class="metric-value">{{ collect($datos['items'])->where('estado', 'Inactivo')->count() }}</span>
                    <span class="metric-label">Inactivos</span>
                </div>
                @break
        @endswitch
    </div>

    <!-- CONTENIDO DEL MÓDULO -->
    <div class="table-container">
        <div class="table-header">
            @switch($tipo)
                @case('inventario')
                    📦 CONTROL DE INVENTARIO - Insumos y materiales
                    @break
                @case('lote')
                    🏞️ GESTIÓN DE LOTES - Terrenos y cultivos
                    @break
                @case('ventas')
                    💰 ANÁLISIS DE VENTAS - Ingresos y clientes
                    @break
                @case('produccion')
                    🌱 CONTROL DE PRODUCCIÓN - Cultivos y rendimiento
                    @break
                @case('trabajadores')
                    👥 RECURSOS HUMANOS - Personal y nómina
                    @break
                @default
                    📋 REPORTE DE {{ strtoupper($tipo) }}
            @endswitch
        </div>
        
        @switch($tipo)
            @case('inventario')
                @include('reporte.modulos.tabla_inventario', ['datos' => $datos['items']])
                @break
            @case('lote')
                @include('reporte.modulos.tabla_lote', ['datos' => $datos['items']])
                @break
            @case('ventas')
                @include('reporte.modulos.tabla_ventas', ['datos' => $datos['items']])
                @break
            @case('produccion')
                @include('reporte.modulos.tabla_produccion', ['datos' => $datos['items']])
                @break
            @case('trabajadores')
                @include('reporte.modulos.tabla_trabajadores', ['datos' => $datos['items']])
                @break
        @endswitch
    </div>

    <!-- SECCIÓN DE SALIDAS (SOLO PARA INVENTARIO) -->
    @if($tipo === 'inventario' && isset($datos['salidas']) && count($datos['salidas']) > 0)
    <div class="table-container">
        <div class="table-header">📤 SALIDAS DE INVENTARIO - Insumos utilizados</div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>INSUMO</th>
                    <th>LOTE</th>
                    <th>PRODUCCIÓN</th>
                    <th>CANTIDAD</th>
                    <th>VALOR</th>
                    <th>FECHA</th>
                    <th>RESPONSABLE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos['salidas'] as $salida)
                <tr>
                    <td style="font-weight: bold;">#{{ $salida->id }}</td>
                    <td>
                        <span class="badge badge-cafe">{{ $salida->insumo->nombre ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $salida->lote->nombre ?? 'No asociado' }}</td>
                    <td>{{ $salida->produccion->cultivo ?? 'No asociado' }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($salida->cantidad) }} {{ $salida->insumo->unidad ?? '' }}</td>
                    <td style="text-align: right; font-weight: bold; color: #6F4E37;">${{ number_format($salida->valor) }}</td>
                    <td style="color: #666; font-size: 7px;">{{ $salida->fecha }}</td>
                    <td>{{ $salida->responsable ?? 'No especificado' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- RESUMEN -->
    <div class="summary-section">
        <h3>📋 Resumen del {{ ucfirst($tipo) }}</h3>
        <div class="summary-content">
            @switch($tipo)
                @case('inventario')
                    <strong>Total de productos registrados:</strong> {{ count($datos['items']) }}<br>
                    <strong>Valor total del inventario:</strong> ${{ number_format(collect($datos['items'])->sum('valor_total')) }}<br>
                    <strong>Productos en estado óptimo:</strong> {{ collect($datos['items'])->where('estado', 'Óptimo')->count() }}<br>
                    <strong>Productos que requieren atención:</strong> {{ collect($datos['items'])->where('estado', '!=', 'Óptimo')->count() }}
                    @if(isset($datos['salidas']))
                        <br><strong>Total de salidas registradas:</strong> {{ count($datos['salidas']) }}
                        <br><strong>Valor total de salidas:</strong> ${{ number_format(collect($datos['salidas'])->sum('valor')) }}
                    @endif
                    @break
                @case('lote')
                    <strong>Total de lotes registrados:</strong> {{ count($datos['items']) }}<br>
                    <strong>Área total:</strong> {{ number_format(collect($datos['items'])->sum('area')) }} m²<br>
                    <strong>Capacidad total:</strong> {{ number_format(collect($datos['items'])->sum('capacidad')) }}<br>
                    <strong>Lotes activos:</strong> {{ collect($datos['items'])->where('estado', 'Activo')->count() }}
                    @break
                @case('ventas')
                    <strong>Total de ventas registradas:</strong> {{ count($datos['items']) }}<br>
                    <strong>Ingresos totales:</strong> ${{ number_format(collect($datos['items'])->sum('precio_total')) }}<br>
                    <strong>Promedio por venta:</strong> ${{ number_format(collect($datos['items'])->avg('precio_total')) }}<br>
                    <strong>Cantidad total vendida:</strong> {{ number_format(collect($datos['items'])->sum('cantidad')) }} kg
                    @break
                @case('produccion')
                    <strong>Total de procesos:</strong> {{ count($datos['items']) }}<br>
                    <strong>Área total en producción:</strong> {{ number_format(collect($datos['items'])->sum('area')) }} m²<br>
                    <strong>Rendimiento promedio:</strong> {{ number_format(collect($datos['items'])->avg('rendimiento'), 2) }} kg/m²<br>
                    <strong>Procesos completados:</strong> {{ collect($datos['items'])->where('estado', 'completado')->count() }}
                    @break
                @case('trabajadores')
                    <strong>Total de trabajadores:</strong> {{ count($datos['items']) }}<br>
                    <strong>Trabajadores activos:</strong> {{ collect($datos['items'])->where('estado', 'Activo')->count() }}<br>
                    <strong>Trabajadores inactivos:</strong> {{ collect($datos['items'])->where('estado', 'Inactivo')->count() }}
                    @break
            @endswitch
        </div>
    </div>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        <strong>CACAOSOF - Sistema de Gestión de Inventario</strong><br>
        Reporte generado automáticamente el {{ $fecha_generacion }}<br>
        Este documento contiene información confidencial de la empresa.
    </div>
</body>
</html>
