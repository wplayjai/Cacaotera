
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Reporte General Modular</title>
	<style>
		body { font-family: Arial, sans-serif; font-size: 12px; }
		h1 { background: #343a40; color: #fff; padding: 10px; text-align: center; }
		.metricas-resumen { display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 30px; }
		.metrica-card { background: #f8f9fa; border: 1px solid #343a40; border-radius: 6px; padding: 12px 18px; margin: 6px; min-width: 180px; text-align: center; }
		.metrica-titulo { font-weight: bold; color: #343a40; margin-bottom: 4px; }
		.metrica-valor { font-size: 1.3em; color: #007bff; margin-bottom: 2px; }
		table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
		th, td { border: 1px solid #343a40; padding: 6px; text-align: left; }
		th { background: #343a40; color: #fff; }
		.modulo-title { background: #6c757d; color: #fff; padding: 6px; margin-top: 20px; }
	</style>
</head>
<body>
	<h1>Reporte General Modular</h1>

	@if(isset($metricas))
	<div class="metricas-resumen">
		<div class="metrica-card">
			<div class="metrica-titulo">Lotes Activos</div>
			<div class="metrica-valor">{{ $metricas['total_lotes'] ?? 0 }}</div>
		</div>
		<div class="metrica-card">
			<div class="metrica-titulo">Producción Total</div>
			<div class="metrica-valor">{{ number_format($metricas['total_produccion'] ?? 0) }} kg</div>
		</div>
		<div class="metrica-card">
			<div class="metrica-titulo">Ingresos Totales</div>
			<div class="metrica-valor">${{ number_format($metricas['total_ventas'] ?? 0) }}</div>
		</div>
		<div class="metrica-card">
			<div class="metrica-titulo">Rentabilidad</div>
			<div class="metrica-valor">{{ number_format($metricas['rentabilidad'] ?? 0, 1) }}%</div>
		</div>
		<div class="metrica-card">
			<div class="metrica-titulo">Personal Activo</div>
			<div class="metrica-valor">{{ $metricas['total_trabajadores'] ?? 0 }}</div>
		</div>
	</div>
	@endif

	@foreach($datosCompletos as $modulo => $items)
		<div class="modulo-title">{{ ucfirst($modulo) }}</div>
		<table>
			<thead>
				<tr>
					@if(count($items) > 0)
						@foreach(array_keys((array)$items[0]) as $col)
							<th>{{ ucfirst($col) }}</th>
						@endforeach
					@else
						<th>Sin datos</th>
					@endif
				</tr>
			</thead>
			<tbody>
				@forelse($items as $item)
					<tr>
						@foreach((array)$item as $val)
							<td>{{ $val }}</td>
						@endforeach
					</tr>
				@empty
					<tr><td colspan="100%">No hay registros para este módulo.</td></tr>
				@endforelse
			</tbody>
		</table>
	@endforeach
</body>
</html>
