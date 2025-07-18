{{-- filepath: c:\laragon\www\webcacao\Cacaotera\resources\views\lotes\pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Lotes de Cacao</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #6f4e37;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #6f4e37;
            font-size: 24px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
        }
        
        .header .date {
            color: #999;
            font-size: 12px;
            margin-top: 10px;
        }
        
        .summary {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            color: #6f4e37;
            font-size: 16px;
        }
        
        .summary .stats {
            display: inline-block;
            margin: 0 15px;
        }
        
        .summary .stats strong {
            color: #28a745;
            font-size: 18px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        
        thead th {
            background-color: #6f4e37;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #5d4037;
            font-size: 11px;
        }
        
        tbody td {
            border: 1px solid #d7ccc8;
            padding: 10px 8px;
            text-align: center;
            vertical-align: middle;
            line-height: 1.4;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tbody tr:hover {
            background-color: #e8f5e8;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        
        .badge-area {
            background-color: #007bff;
        }
        
        .badge-capacidad {
            background-color: #28a745;
        }
        
        .badge-activo {
            background-color: #28a745;
        }
        
        .badge-inactivo {
            background-color: #dc3545;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .lote-name {
            font-weight: bold;
            color: #6f4e37;
        }
        
        .fecha {
            font-weight: 500;
            color: #333;
        }
        
        .observaciones {
            max-width: 150px;
            word-wrap: break-word;
            font-style: italic;
            color: #666;
        }
        
        .no-observaciones {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌱 Reporte de Lotes de Cacao</h1>
        <div class="subtitle">Sistema de Gestión Cacaotera</div>
        <div class="date">Generado el: {{ date('d/m/Y H:i:s') }}</div>
    </div>

    <div class="summary">
        <h3>Resumen del Reporte</h3>
        <div class="stats">
            <strong>{{ $lotes->count() }}</strong><br>
            <small>Total de Lotes</small>
        </div>
        <div class="stats">
            <strong>{{ $lotes->where('estado', 'Activo')->count() }}</strong><br>
            <small>Lotes Activos</small>
        </div>
        <div class="stats">
            <strong>{{ number_format($lotes->sum('area'), 0, ',', '.') }} m²</strong><br>
            <small>Área Total</small>
        </div>
        <div class="stats">
            <strong>{{ number_format($lotes->sum('capacidad'), 0, ',', '.') }}</strong><br>
            <small>Capacidad Total</small>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%">Nombre</th>
                <th style="width: 12%">Fecha Inicio</th>
                <th style="width: 12%">Área (m²)</th>
                <th style="width: 12%">Capacidad</th>
                <th style="width: 13%">Tipo de Cacao</th>
                <th style="width: 10%">Estado</th>
                <th style="width: 26%">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lotes as $index => $lote)
                <tr>
                    <td>
                        <div class="lote-name">{{ $lote->nombre }}</div>
                        <small style="color: #999;">#{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</small>
                    </td>
                    <td>
                        <div class="fecha">{{ \Carbon\Carbon::parse($lote->fecha_inicio)->format('d/m/Y') }}</div>
                        <small style="color: #666;">{{ \Carbon\Carbon::parse($lote->fecha_inicio)->locale('es')->isoFormat('MMM YYYY') }}</small>
                    </td>
                    <td>
                        <span class="badge badge-area">
                            {{ number_format($lote->area, 0, ',', '.') }} m²
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-capacidad">
                            {{ number_format($lote->capacidad, 0, ',', '.') }} árboles
                        </span>
                    </td>
                    <td>
                        <strong>🍃 {{ $lote->tipo_cacao }}</strong>
                    </td>
                    <td>
                        @if($lote->estado === 'Activo')
                            <span class="badge badge-activo">✓ Activo</span>
                        @else
                            <span class="badge badge-inactivo">✗ Inactivo</span>
                        @endif
                    </td>
                    <td class="observaciones">
                        @if($lote->observaciones)
                            {{ $lote->observaciones }}
                        @else
                            <span class="no-observaciones">Sin observaciones registradas</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                        No hay lotes registrados en el sistema
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Sistema de Gestión Cacaotera</strong> | Reporte generado automáticamente</p>
        <p>📍 Total de registros: {{ $lotes->count() }} | 📅 {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>