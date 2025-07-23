<?php

require 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Recoleccion;
use App\Models\Produccion;

echo "=== VERIFICANDO DATOS DE RECOLECCIONES Y BADGES ===\n";

try {
    $recolecciones = Recoleccion::with('produccion.lote')->get();
    
    if ($recolecciones->isEmpty()) {
        echo "❌ No hay recolecciones en la base de datos.\n";
    } else {
        foreach($recolecciones as $recoleccion) {
            echo "--- RECOLECCIÓN #" . $recoleccion->id . " ---\n";
            echo "Estado fruto: " . $recoleccion->estado_fruto . "\n";
            echo "Badge estado fruto: " . json_encode($recoleccion->badgeEstadoFruto) . "\n";
            echo "Condiciones climáticas: " . $recoleccion->condiciones_climaticas . "\n";
            echo "Badge clima: " . json_encode($recoleccion->badgeClima) . "\n";
            echo "Cantidad recolectada: " . $recoleccion->cantidad_recolectada . " kg\n";
            echo "Lote: " . ($recoleccion->produccion->lote->nombre ?? 'Sin lote') . "\n";
            echo "---\n";
        }
    }
    
    // Verificar una producción específica
    echo "\n=== VERIFICANDO PRODUCCIÓN ===\n";
    $produccion = Produccion::with('lote', 'recolecciones')->first();
    if ($produccion) {
        echo "Producción ID: " . $produccion->id . "\n";
        echo "Estado: " . $produccion->estado . "\n";
        echo "Tipo cacao: " . $produccion->tipo_cacao . "\n";
        echo "Lote: " . ($produccion->lote->nombre ?? 'Sin lote') . "\n";
        echo "Recolecciones: " . $produccion->recolecciones->count() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
