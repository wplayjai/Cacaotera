<?php

require_once 'vendor/autoload.php';

// Cargar la aplicación Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Produccion;
use App\Models\Asistencia;
use App\Models\Trabajador;
use App\Models\Lote;
use Carbon\Carbon;

echo "=== DEBUG ESPECÍFICO DE PRODUCCIONES Y ASISTENCIAS ===\n\n";

// Mostrar todas las producciones
echo "1. Producciones disponibles:\n";
$producciones = Produccion::with(['lote', 'trabajadores.user'])->get();

foreach ($producciones as $produccion) {
    echo "   - ID: {$produccion->id}\n";
    echo "     Tipo: {$produccion->tipo_cacao}\n";
    echo "     Lote: " . ($produccion->lote->nombre ?? 'Sin lote') . " (ID: {$produccion->lote_id})\n";
    echo "     Estado: {$produccion->estado}\n";
    echo "     Fecha inicio: " . ($produccion->fecha_inicio ? $produccion->fecha_inicio->format('d/m/Y') : 'Sin fecha') . "\n";
    echo "     Fecha fin: " . ($produccion->fecha_fin_esperada ? $produccion->fecha_fin_esperada->format('d/m/Y') : 'Sin fecha') . "\n";
    echo "     Trabajadores asignados: " . $produccion->trabajadores->count() . "\n";
    
    // Mostrar trabajadores asignados
    if ($produccion->trabajadores->count() > 0) {
        echo "     Trabajadores:\n";
        foreach ($produccion->trabajadores as $trabajador) {
            echo "       * " . ($trabajador->user->name ?? 'Sin nombre') . " (ID: {$trabajador->id})\n";
        }
    }
    echo "     ----\n";
}

// Analizar una producción específica (tomar la primera)
if ($producciones->count() > 0) {
    $produccion = $producciones->first();
    echo "\n2. Análisis detallado de la producción ID: {$produccion->id}\n";
    echo "   Lote de la producción: {$produccion->lote_id}\n";
    
    // Definir rangos de fecha como en la vista
    $fechaInicio = $produccion->fecha_inicio ?? now()->subMonths(3);
    $fechaFin = $produccion->fecha_fin_esperada ?? now()->addDays(7);
    
    if ($fechaInicio->lt(now()->subMonths(6))) {
        $fechaInicio = now()->subMonths(1);
    }
    if ($fechaFin->gt(now()->addMonths(1))) {
        $fechaFin = now()->addDays(7);
    }
    
    echo "   Rango de fechas a buscar: " . $fechaInicio->format('d/m/Y') . " - " . $fechaFin->format('d/m/Y') . "\n";
    
    // Buscar asistencias para cada trabajador
    foreach ($produccion->trabajadores as $trabajador) {
        echo "\n   Trabajador: " . ($trabajador->user->name ?? 'Sin nombre') . " (ID: {$trabajador->id})\n";
        
        // Todas las asistencias del trabajador
        $todasAsistencias = $trabajador->asistencias()->with('lote')->get();
        echo "     * Total asistencias del trabajador: " . $todasAsistencias->count() . "\n";
        
        if ($todasAsistencias->count() > 0) {
            echo "     * Detalles de TODAS las asistencias:\n";
            foreach ($todasAsistencias as $asistencia) {
                echo "       - Fecha: " . $asistencia->fecha->format('d/m/Y') . 
                     ", Lote ID: {$asistencia->lote_id}" . 
                     ", Lote: " . ($asistencia->lote->nombre ?? 'Sin lote') . 
                     ", Horas: {$asistencia->horas_trabajadas}h\n";
            }
        }
        
        // Asistencias filtradas por lote de la producción
        $asistenciasLote = $trabajador->asistencias()
            ->where('lote_id', $produccion->lote_id)
            ->with('lote')
            ->get();
        echo "     * Asistencias en el lote de la producción (ID: {$produccion->lote_id}): " . $asistenciasLote->count() . "\n";
        
        // Asistencias filtradas por lote Y fechas
        $asistenciasFiltradas = $trabajador->asistencias()
            ->where('lote_id', $produccion->lote_id)
            ->where('fecha', '>=', $fechaInicio)
            ->where('fecha', '<=', $fechaFin)
            ->with('lote')
            ->get();
        echo "     * Asistencias filtradas (lote + fechas): " . $asistenciasFiltradas->count() . "\n";
        
        if ($asistenciasFiltradas->count() > 0) {
            $totalHoras = $asistenciasFiltradas->sum('horas_trabajadas');
            echo "       Total horas: {$totalHoras}h\n";
            echo "       Días trabajados: " . $asistenciasFiltradas->count() . "\n";
            echo "       Promedio diario: " . ($totalHoras / $asistenciasFiltradas->count()) . "h/día\n";
        }
    }
} else {
    echo "\nNo hay producciones disponibles para analizar.\n";
}

echo "\n=== DEBUG COMPLETADO ===\n";
