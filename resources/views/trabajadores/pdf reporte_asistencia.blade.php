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
            margin: 20px;
        }
        h1 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .periodo {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Reporte de Asistencia</h1>
    
    <div class="periodo">
        Periodo: {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}
    </div>
    
    <h2>Estadísticas de Asistencia</h2>
    <table>
        <thead>
            <tr>
                <th>Trabajador</th>
                <th>Total Asistencias</th>
                <th>% Asistencia</th>
                <th>Horas Trabajadas</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_dias = \Carbon\Carbon::parse($fecha_inicio)->diffInDays(\Carbon\Carbon::parse($fecha_fin)) + 1;
                $asistencias_por_trabajador = $asistencias->groupBy('trabajador_id');
            @endphp
            
            @foreach($asistencias_por_trabajador as $trabajador_id => $asistencias_trabajador)
                @php
                    $trabajador = $asistencias_trabajador->first()->trabajador;
                    $total_asistencias = $asistencias_trabajador->count();
                    $horas_trabajadas = 0;
                    
                    foreach($asistencias_trabajador as $asistencia) {
                        if($asistencia->hora_entrada && $asistencia->hora_salida) {
                            $entrada = \Carbon\Carbon::parse($asistencia->hora_entrada);
                            $salida = \Carbon\Carbon::parse($asistencia->hora_salida);
                            $horas_trabajadas += $entrada->diffInHours($salida);
                        }
                    }
                    
                    $porcentaje_asistencia = round(($total_asistencias / $total_dias) * 100, 2);
                @endphp
                
                <tr>
                    <td>{{ $trabajador->user->name }}</td>
                    <td>{{ $total_asistencias }}</td>
                    <td>{{ $porcentaje_asistencia }}%</td>
                    <td>{{ $horas_trabajadas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h2>Detalle de Asistencias</h2>
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
                    <td>{{ $asistencia->trabajador->user->name }}</td>
                    <td>{{ $asistencia->trabajador->user->identificacion }}</td>
                    <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : 'N/A' }}</td>
                    <td>{{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : 'N/A' }}</td>
                    <td>
                        @if($asistencia->hora_entrada && $asistencia->hora_salida)
                            {{ \Carbon\Carbon::parse($asistencia->hora_entrada)->diffInHours(\Carbon\Carbon::parse($asistencia->hora_salida)) }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $asistencia->observaciones ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center">No hay registros de asistencia en el periodo seleccionado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>