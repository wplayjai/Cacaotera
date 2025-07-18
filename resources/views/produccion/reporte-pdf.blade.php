<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Rendimiento de Producción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .estadisticas {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .badge-success { background-color: #28a745; color: white; padding: 2px 6px; border-radius: 3px; }
        .badge-warning { background-color: #ffc107; color: black; padding: 2px 6px; border-radius: 3px; }
        .badge-danger { background-color: #dc3545; color: white; padding: 2px 6px; border-radius: 3px; }
        .badge-info { background-color: #17a2b8; color: white; padding: 2px 6px; border-radius: 3px; }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Rendimiento de Producción de Cacao</h1>
        <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="estadisticas">
        <div class="stat-item">
            <strong>{{ $estadisticas['total_producciones'] }}</strong><br>
            Total Producciones
        </div>
        <div class="stat-item">
            <strong>{{ number_format($estadisticas['area_total'], 2) }} ha</strong><br>
            Área Total
        </div>
        <div class="stat-item">
            <strong>{{ number_format($estadisticas['produccion_total'], 2) }} kg</strong><br>
            Producción Total
        </div>
        <div class="stat-item">
            <strong>{{ number_format($estadisticas['rendimiento_promedio'], 1) }}%</strong><br>
            Rendimiento Promedio
        </div>
    </div>

    <h3>Detalle de Producciones</h3>
    <table>
        <thead>
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
            </tr>
        </thead>
        <tbody>
            @foreach($producciones as $produccion)
                @php
                    $porcentaje = $produccion->estimacion_produccion > 0 
                        ? ($produccion->total_recolectado / $produccion->estimacion_produccion) * 100 
                        : 0;
                @endphp
                <tr>
                    <td>{{ $produccion->id }}</td>
                    <td>{{ ucfirst($produccion->tipo_cacao) }}</td>
                    <td>{{ $produccion->lote->nombre ?? 'N/A' }}</td>
                    <td>{{ number_format($produccion->area_asignada, 2) }}</td>
                    <td>{{ ucfirst($produccion->estado) }}</td>
                    <td>{{ number_format($produccion->estimacion_produccion, 2) }}</td>
                    <td>{{ number_format($produccion->total_recolectado, 2) }}</td>
                    <td>
                        <span class="badge-{{ $porcentaje < 80 ? 'danger' : ($porcentaje > 120 ? 'info' : 'success') }}">
                            {{ number_format($porcentaje, 1) }}%
                        </span>
                    </td>
                    <td>{{ $produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sistema de Gestión de Producción de Cacao - {{ config('app.name') }}</p>
    </div>
</body>
</html>
