<?php

require_once 'vendor/autoload.php';

// Cargar la aplicación Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Asistencia;
use App\Models\Trabajador;
use App\Models\Lote;
use Carbon\Carbon;

echo "=== VERIFICACIÓN DE ASISTENCIAS POR FECHA Y LOTE ===\n\n";

echo "Fecha actual: " . Carbon::now()->format('d/m/Y H:i:s') . "\n\n";

// Mostrar asistencias de hoy
echo "1. Asistencias registradas HOY (" . Carbon::today()->format('d/m/Y') . "):\n";
$asistenciasHoy = Asistencia::whereDate('fecha', Carbon::today())
    ->with(['trabajador.user', 'lote'])
    ->get();

if ($asistenciasHoy->count() > 0) {
    foreach ($asistenciasHoy as $asistencia) {
        echo "   - Trabajador: " . ($asistencia->trabajador->user->name ?? 'Sin nombre') . "\n";
        echo "     Lote: " . ($asistencia->lote->nombre_completo ?? 'Sin lote') . " (ID: {$asistencia->lote_id})\n";
        echo "     Fecha: " . $asistencia->fecha->format('d/m/Y') . "\n";
        echo "     Horas: {$asistencia->horas_trabajadas}h ({$asistencia->hora_entrada} - {$asistencia->hora_salida})\n";
        echo "     ----\n";
    }
} else {
    echo "   No hay asistencias registradas hoy.\n";
}

// Mostrar asistencias de ayer
echo "\n2. Asistencias registradas AYER (" . Carbon::yesterday()->format('d/m/Y') . "):\n";
$asistenciasAyer = Asistencia::whereDate('fecha', Carbon::yesterday())
    ->with(['trabajador.user', 'lote'])
    ->get();

if ($asistenciasAyer->count() > 0) {
    foreach ($asistenciasAyer as $asistencia) {
        echo "   - Trabajador: " . ($asistencia->trabajador->user->name ?? 'Sin nombre') . "\n";
        echo "     Lote: " . ($asistencia->lote->nombre_completo ?? 'Sin lote') . " (ID: {$asistencia->lote_id})\n";
        echo "     Fecha: " . $asistencia->fecha->format('d/m/Y') . "\n";
        echo "     Horas: {$asistencia->horas_trabajadas}h\n";
        echo "     ----\n";
    }
} else {
    echo "   No hay asistencias registradas ayer.\n";
}

// Mostrar asistencias de la última semana
echo "\n3. Resumen de asistencias última semana:\n";
$asistenciasSemana = Asistencia::where('fecha', '>=', Carbon::now()->subDays(7))
    ->with(['trabajador.user', 'lote'])
    ->orderBy('fecha', 'desc')
    ->get();

if ($asistenciasSemana->count() > 0) {
    $totalHoras = $asistenciasSemana->sum('horas_trabajadas');
    $diasConRegistros = $asistenciasSemana->groupBy(function($item) {
        return $item->fecha->format('Y-m-d');
    })->count();
    
    echo "   - Total registros: {$asistenciasSemana->count()}\n";
    echo "   - Total horas: {$totalHoras}\n";
    echo "   - Días con registros: {$diasConRegistros}\n";
    
    echo "\n   Detalle por lote:\n";
    $porLote = $asistenciasSemana->groupBy('lote_id');
    foreach ($porLote as $loteId => $asistenciasLote) {
        $lote = $asistenciasLote->first()->lote;
        $horas = $asistenciasLote->sum('horas_trabajadas');
        echo "     * {$lote->nombre_completo}: {$horas}h ({$asistenciasLote->count()} registros)\n";
    }
} else {
    echo "   No hay asistencias en la última semana.\n";
}

echo "\n=== VERIFICACIÓN COMPLETADA ===\n";
