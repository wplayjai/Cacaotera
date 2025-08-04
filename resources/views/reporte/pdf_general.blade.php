<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General - Sistema Cacaotera</title>
    <style>
        /* Reset y configuración base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #2C1810;
            line-height: 1.4;
            background: #ffffff;
        }

        /* Variables de colores café profesional */
        :root {
            --cafe-principal: #6F4E37;
            --cafe-secundario: #8B4513;
            --cafe-claro: #A0522D;
            --cafe-muy-claro: #CD853F;
        }

        /* Configuración de página */
        @page {
            margin: 15mm;
            size: A4;
        }

        /* Salto de página */
        .page-break {
            page-break-before: always;
        }

        /* Header principal de cada página */
        .page-header {
            background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .page-header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .page-header .subtitle {
            font-size: 11px;
            opacity: 0.9;
            font-weight: normal;
        }

        .page-header .page-info {
            font-size: 9px;
            opacity: 0.8;
            margin-top: 8px;
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: 8px;
        }

        /* Módulo específico header */
        .module-header {
            background: linear-gradient(135deg, #A0522D 0%, #CD853F 100%);
            color: white;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .module-title {
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .module-icon {
            font-size: 16px;
            margin-right: 8px;
        }

        .module-count {
            background: rgba(255,255,255,0.2);
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
        }

        /* Tablas profesionales */
        .table-container {
            margin-bottom: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        table thead tr {
            background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%);
            color: white;
        }

        table th {
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        table td {
            padding: 6px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 7px;
            vertical-align: top;
        }

        table tbody tr:nth-child(even) {
            background-color: #F9F7F4;
        }

        table tbody tr:hover {
            background-color: #F5F3F0;
        }

        /* Badges y estados */
        .badge {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 6px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 20px;
        }

        .badge-tipo {
            background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%);
            color: #2C1810;
        }

        .badge-activo {
            background: #28a745;
            color: white;
        }

        .badge-inactivo {
            background: #6c757d;
            color: white;
        }

        .badge-desarrollo {
            background: #ffc107;
            color: #2C1810;
        }

        .badge-optimo {
            background: #28a745;
            color: white;
        }

        .badge-restringido {
            background: #ffc107;
            color: white;
        }

        .badge-disponible {
            background: #17a2b8;
            color: white;
        }

        .badge-pagado {
            background: #28a745;
            color: white;
        }

        .badge-pendiente {
            background: #ffc107;
            color: #2C1810;
        }

        .badge-completado {
            background: #28a745;
            color: white;
        }

        .badge-progreso {
            background: #17a2b8;
            color: white;
        }

        .badge-planificado {
            background: #6c757d;
            color: white;
        }

        /* Footer de página */
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #6F4E37 0%, #8B4513 100%);
            color: white;
            padding: 8px 20px;
            font-size: 8px;
            text-align: center;
        }

        /* Estilos específicos por tipo de dato */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-weight-bold { font-weight: bold; }
        .text-primary { color: #6F4E37; }
        .text-success { color: #28a745; }
        .text-muted { color: #6c757d; }

        /* Responsive para diferentes tamaños */
        @media print {
            .page-break {
                page-break-before: always;
            }
        }

        /* Mejoras visuales */
        .data-highlight {
            background: linear-gradient(135deg, #CD853F 0%, #DEB887 100%);
            color: #2C1810;
            font-weight: bold;
            padding: 2px 4px;
            border-radius: 3px;
        }

        .currency {
            color: #2C7A2C;
            font-weight: bold;
        }

        .metric-row {
            background: #F9F7F4;
            border-left: 4px solid #6F4E37;
            padding: 8px 12px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<!-- PÁGINA 1: GESTIÓN DE LOTES -->
<div class="page-header">
    <h1>📋 Reporte General de Módulos</h1>
    <p class="subtitle">Sistema Integral de Gestión Cacaotera</p>
    <p class="page-info">
        Generado el: {{ $fecha_generacion ?? now()->format('d/m/Y H:i:s') }} | 
        Página 1 de 5: Gestión de Lotes
    </p>
</div>

<div class="module-header">
    <div class="module-title">
        <span class="module-icon">🏞️</span>
        MÓDULO 1: GESTIÓN DE LOTES
    </div>
    <div class="module-count">
        {{ isset($datosCompletos['lote']['items']) ? count($datosCompletos['lote']['items']) : 0 }} registros
    </div>
</div>

<div class="table-container">
    @if(isset($datosCompletos['lote']['items']) && count($datosCompletos['lote']['items']) > 0)
        @include('reporte.modulos.tabla_lote', ['datos' => $datosCompletos['lote']['items']])
    @else
        <div style="text-align: center; padding: 40px; color: #6c757d;">
            <p><strong>Sin datos disponibles</strong></p>
            <p>No hay registros de lotes en el período seleccionado</p>
        </div>
    @endif
</div>

<!-- PÁGINA 2: CONTROL DE INVENTARIO -->
<div class="page-break">
    <div class="page-header">
        <h1>📋 Reporte General de Módulos</h1>
        <p class="subtitle">Sistema Integral de Gestión Cacaotera</p>
        <p class="page-info">
            Generado el: {{ $fecha_generacion ?? now()->format('d/m/Y H:i:s') }} | 
            Página 2 de 5: Control de Inventario
        </p>
    </div>

    <div class="module-header">
        <div class="module-title">
            <span class="module-icon">📦</span>
            MÓDULO 2: CONTROL DE INVENTARIO
        </div>
        <div class="module-count">
            {{ isset($datosCompletos['inventario']['items']) ? count($datosCompletos['inventario']['items']) : 0 }} registros
        </div>
    </div>

    <div class="table-container">
        @if(isset($datosCompletos['inventario']['items']) && count($datosCompletos['inventario']['items']) > 0)
            @include('reporte.modulos.tabla_inventario', ['datos' => $datosCompletos['inventario']['items']])
        @else
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <p><strong>Sin datos disponibles</strong></p>
                <p>No hay registros de inventario en el período seleccionado</p>
            </div>
        @endif
    </div>
</div>

<!-- PÁGINA 3: ANÁLISIS DE VENTAS -->
<div class="page-break">
    <div class="page-header">
        <h1>📋 Reporte General de Módulos</h1>
        <p class="subtitle">Sistema Integral de Gestión Cacaotera</p>
        <p class="page-info">
            Generado el: {{ $fecha_generacion ?? now()->format('d/m/Y H:i:s') }} | 
            Página 3 de 5: Análisis de Ventas
        </p>
    </div>

    <div class="module-header">
        <div class="module-title">
            <span class="module-icon">💰</span>
            MÓDULO 3: ANÁLISIS DE VENTAS
        </div>
        <div class="module-count">
            {{ isset($datosCompletos['ventas']['items']) ? count($datosCompletos['ventas']['items']) : 0 }} registros
        </div>
    </div>

    <div class="table-container">
        @if(isset($datosCompletos['ventas']['items']) && count($datosCompletos['ventas']['items']) > 0)
            @include('reporte.modulos.tabla_ventas', ['datos' => $datosCompletos['ventas']['items']])
        @else
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <p><strong>Sin datos disponibles</strong></p>
                <p>No hay registros de ventas en el período seleccionado</p>
            </div>
        @endif
    </div>
</div>

<!-- PÁGINA 4: CONTROL DE PRODUCCIÓN -->
<div class="page-break">
    <div class="page-header">
        <h1>📋 Reporte General de Módulos</h1>
        <p class="subtitle">Sistema Integral de Gestión Cacaotera</p>
        <p class="page-info">
            Generado el: {{ $fecha_generacion ?? now()->format('d/m/Y H:i:s') }} | 
            Página 4 de 5: Control de Producción
        </p>
    </div>

    <div class="module-header">
        <div class="module-title">
            <span class="module-icon">🌱</span>
            MÓDULO 4: CONTROL DE PRODUCCIÓN
        </div>
        <div class="module-count">
            {{ isset($datosCompletos['produccion']['items']) ? count($datosCompletos['produccion']['items']) : 0 }} registros
        </div>
    </div>

    <div class="table-container">
        @if(isset($datosCompletos['produccion']['items']) && count($datosCompletos['produccion']['items']) > 0)
            @include('reporte.modulos.tabla_produccion', ['datos' => $datosCompletos['produccion']['items']])
        @else
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <p><strong>Sin datos disponibles</strong></p>
                <p>No hay registros de producción en el período seleccionado</p>
            </div>
        @endif
    </div>
</div>

<!-- PÁGINA 5: RECURSOS HUMANOS -->
<div class="page-break">
    <div class="page-header">
        <h1>📋 Reporte General de Módulos</h1>
        <p class="subtitle">Sistema Integral de Gestión Cacaotera</p>
        <p class="page-info">
            Generado el: {{ $fecha_generacion ?? now()->format('d/m/Y H:i:s') }} | 
            Página 5 de 5: Recursos Humanos
        </p>
    </div>

    <div class="module-header">
        <div class="module-title">
            <span class="module-icon">👥</span>
            MÓDULO 5: RECURSOS HUMANOS
        </div>
        <div class="module-count">
            {{ isset($datosCompletos['trabajadores']['items']) ? count($datosCompletos['trabajadores']['items']) : 0 }} registros
        </div>
    </div>

    <div class="table-container">
        @if(isset($datosCompletos['trabajadores']['items']) && count($datosCompletos['trabajadores']['items']) > 0)
            @include('reporte.modulos.tabla_trabajadores', ['datos' => $datosCompletos['trabajadores']['items']])
        @else
            <div style="text-align: center; padding: 40px; color: #6c757d;">
                <p><strong>Sin datos disponibles</strong></p>
                <p>No hay registros de trabajadores en el período seleccionado</p>
            </div>
        @endif
    </div>
</div>

</body>
</html>