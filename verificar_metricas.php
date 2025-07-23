<?php

require 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Produccion;

echo "=== VERIFICANDO MÉTRICAS DE RENDIMIENTO ===\n";

try {
    $producciones = Produccion::where('estado', 'completado')->with('recolecciones')->get();
    
    foreach($producciones as $produccion) {
        echo "--- PRODUCCIÓN #" . $produccion->id . " ---\n";
        echo "Tipo: " . $produccion->tipo_cacao . "\n";
        echo "Estado: " . $produccion->estado . "\n";
        echo "Estimación Producción: " . $produccion->estimacion_produccion . " kg\n";
        echo "Cantidad Cosechada (BD): " . ($produccion->cantidad_cosechada ?? 'NULL') . " kg\n";
        echo "Total Recolectado (calculado): " . $produccion->total_recolectado . " kg\n";
        echo "Rendimiento Real (BD): " . ($produccion->rendimiento_real ?? 'NULL') . "%\n";
        echo "Desviación Estimación (BD): " . ($produccion->desviacion_estimacion ?? 'NULL') . " kg\n";
        echo "Fecha Cosecha Real: " . ($produccion->fecha_cosecha_real ? $produccion->fecha_cosecha_real->format('d/m/Y') : 'NULL') . "\n";
        echo "Recolecciones: " . $produccion->recolecciones->count() . "\n";
        
        if ($produccion->recolecciones->count() > 0) {
            echo "Detalles de recolecciones:\n";
            foreach($produccion->recolecciones as $rec) {
                echo "  - Fecha: " . $rec->fecha_recoleccion->format('d/m/Y') . " | Cantidad: " . $rec->cantidad_recolectada . " kg\n";
            }
        }
        echo "---\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
