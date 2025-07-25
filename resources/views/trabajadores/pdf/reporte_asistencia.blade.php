<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asistencia</title>
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
        
        .workers {
            color: #6f4e37 !important;
        }
        
        .attendance {
            color: #28a745 !important;
        }
        
        .hours {
            color: #17a2b8 !important;
        }
        
        .percentage {
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
</head>
<body>
    <div class="header">
        <h1>Reporte de Asistencia de Trabajadores</h1>
        <p>Sistema de Gestión Cacaotera</p>
    </div>

    <!-- Filtros aplicados -->
    <div class="filters">
        <h3><i class="fas fa-filter"></i> Filtros Aplicados</h3>
        <p><strong>Periodo:</strong> {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</p>
        <p><strong>Fecha de generación:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Resumen estadístico -->
    @if(isset($estadisticas) && count($estadisticas) > 0)
        @php
            $totalTrabajadores = count($estadisticas);
            $totalAsistencias = array_sum(array_column($estadisticas, 'total_asistencias'));
            $promedioAsistencia = $totalTrabajadores > 0 ? round(array_sum(array_column($estadisticas, 'porcentaje_asistencia')) / $totalTrabajadores, 1) : 0;
            $totalHoras = array_sum(array_column($estadisticas, 'horas_trabajadas'));
        @endphp
        
        <div class="summary">
            <div class="summary-item">
                <h4 class="workers">{{ $totalTrabajadores }}</h4>
                <p>Total Trabajadores</p>
            </div>
            <div class="summary-item">
                <h4 class="attendance">{{ $totalAsistencias }}</h4>
                <p>Total Asistencias</p>
            </div>
            <div class="summary-item">
                <h4 class="hours">{{ $totalHoras }} hrs</h4>
                <p>Horas Trabajadas</p>
            </div>
            <div class="summary-item">
                <h4 class="percentage">{{ $promedioAsistencia }}%</h4>
                <p>Promedio Asistencia</p>
            </div>
        </div>
    @endif

    <!-- Estadísticas por trabajador -->
    <table>
        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Total Asistencias</th>
                <th>% Asistencia</th>
                <th>Horas Trabajadas</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($estadisticas) && count($estadisticas) > 0)
                @foreach($estadisticas as $estadistica)
                    <tr>
                        <td><strong>{{ $estadistica['trabajador'] }}</strong></td>
                        <td class="text-center">{{ $estadistica['total_asistencias'] }}</td>
                        <td class="text-center">
                            @if($estadistica['porcentaje_asistencia'] >= 90)
                                <span class="badge badge-success">{{ $estadistica['porcentaje_asistencia'] }}%</span>
                            @elseif($estadistica['porcentaje_asistencia'] >= 75)
                                <span class="badge badge-warning">{{ $estadistica['porcentaje_asistencia'] }}%</span>
                            @else
                                <span class="badge" style="background-color: #dc3545; color: white;">{{ $estadistica['porcentaje_asistencia'] }}%</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $estadistica['horas_trabajadas'] }} hrs</td>
                        <td class="text-center">
                            @if($estadistica['porcentaje_asistencia'] >= 90)
                                <span class="badge badge-success">Excelente</span>
                            @elseif($estadistica['porcentaje_asistencia'] >= 75)
                                <span class="badge badge-warning">Bueno</span>
                            @else
                                <span class="badge" style="background-color: #dc3545; color: white;">Mejorar</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">No hay estadísticas disponibles para el periodo seleccionado</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Detalle de asistencias -->
    <h3 style="color: #6f4e37; margin-top: 30px; border-bottom: 1px solid #dee2e6; padding-bottom: 5px;">
        Detalle de Asistencias ({{ $asistencias->count() }} registros)
    </h3>
    
    <table>
        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Identificación</th>
                <th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Horas</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asistencias as $asistencia)
                <tr>
                    <td><strong>{{ $asistencia->trabajador->user->name }}</strong></td>
                    <td class="text-center">{{ $asistencia->trabajador->user->identificacion ?? 'N/A' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if($asistencia->hora_entrada)
                            <span class="badge badge-success">{{ \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') }}</span>
                        @else
                            <span class="badge" style="background-color: #6c757d; color: white;">N/A</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($asistencia->hora_salida)
                            <span class="badge badge-info">{{ \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') }}</span>
                        @else
                            <span class="badge" style="background-color: #6c757d; color: white;">N/A</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($asistencia->hora_entrada && $asistencia->hora_salida)
                            @php
                                $horas = \Carbon\Carbon::parse($asistencia->hora_entrada)->diffInHours(\Carbon\Carbon::parse($asistencia->hora_salida));
                            @endphp
                            <strong>{{ $horas }} hrs</strong>
                        @else
                            <span style="color: #6c757d;">N/A</span>
                        @endif
                    </td>
                    <td>{{ $asistencia->observaciones ?? 'Sin observaciones' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px; color: #6c757d;">
                        No hay registros de asistencia en el periodo seleccionado
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Totales finales -->
    @if(isset($estadisticas) && count($estadisticas) > 0)
        <div class="totals">
            <div class="totals-row">
                <div class="totals-label">Total de trabajadores registrados:</div>
                <div class="totals-value workers">{{ count($estadisticas) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Total de asistencias registradas:</div>
                <div class="totals-value attendance">{{ array_sum(array_column($estadisticas, 'total_asistencias')) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Total de horas trabajadas:</div>
                <div class="totals-value hours">{{ array_sum(array_column($estadisticas, 'horas_trabajadas')) }} hrs</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Promedio de asistencia general:</div>
                <div class="totals-value percentage">{{ round(array_sum(array_column($estadisticas, 'porcentaje_asistencia')) / count($estadisticas), 1) }}%</div>
            </div>
        </div>
    @endif

    <div class="footer">
        <p>Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }} | Sistema de Gestión Cacaotera</p>
    </div>
</body>
</html>