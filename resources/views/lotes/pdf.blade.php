{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Lotes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #6f4e37;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #6f4e37;
            color: white;
        }
        h1 {
            text-align: center;
            color: #6f4e37;
        }
    </style>
</head>
<body>
    <h1>Reporte de Lotes</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha Inicio</th>
                <th>Área (m²)</th>
                <th>Capacidad (kg)</th>
                <th>Tipo de Cacao</th>
                <th>Estado</th>
                <th>Estimación Cosecha (kg)</th>
                <th>Fecha Programada Cosecha</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lotes as $lote)
                <tr>
                    <td>{{ $lote->nombre }}</td>
                    <td>{{ $lote->fecha_inicio }}</td>
                    <td>{{ $lote->area }}</td>
                    <td>{{ $lote->capacidad }}</td>
                    <td>{{ $lote->tipo_cacao }}</td>
                    <td>{{ $lote->estado }}</td>
                    <td>{{ $lote->estimacion_cosecha }}</td>
                    <td>{{ $lote->fecha_programada_cosecha }}</td>
                    <td>{{ $lote->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>