<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Recoleccion;

echo "=== TESTING CONTROLLER LOGIC ===\n\n";

try {
    // Simular exactamente lo que hace el controlador
    $recoleccion = Recoleccion::find(1);
    
    if (!$recoleccion) {
        echo "❌ Recolección con ID 1 no encontrada\n";
        exit;
    }
    
    echo "✅ Recolección encontrada: ID {$recoleccion->id}\n\n";
    
    // Aplicar el mismo load que hace el controlador
    $recoleccion->load([
        'produccion.lote', 
        'produccion' => function($query) {
            $query->withCount('recolecciones');
        }
    ]);
    
    echo "=== DATOS DESPUÉS DEL LOAD ===\n";
    echo "ID: {$recoleccion->id}\n";
    echo "Fecha (raw): " . $recoleccion->getRawOriginal('fecha_recoleccion') . "\n";
    echo "Fecha (cast): " . ($recoleccion->fecha_recoleccion ? $recoleccion->fecha_recoleccion->format('d/m/Y') : 'NULL') . "\n";
    echo "Cantidad: " . ($recoleccion->cantidad_recolectada ?? 'NULL') . "\n";
    echo "Estado fruto: " . ($recoleccion->estado_fruto ?? 'NULL') . "\n";
    echo "Clima: " . ($recoleccion->condiciones_climaticas ?? 'NULL') . "\n";
    echo "Producción ID: " . ($recoleccion->produccion_id ?? 'NULL') . "\n";
    echo "Tiene producción: " . ($recoleccion->produccion ? 'SÍ' : 'NO') . "\n";
    
    if ($recoleccion->produccion) {
        echo "Tipo cacao: " . ($recoleccion->produccion->tipo_cacao ?? 'NULL') . "\n";
        echo "Estimación: " . ($recoleccion->produccion->estimacion_produccion ?? 'NULL') . "\n";
        echo "Tiene lote: " . ($recoleccion->produccion->lote ? 'SÍ' : 'NO') . "\n";
        
        if ($recoleccion->produccion->lote) {
            echo "Nombre lote: " . $recoleccion->produccion->lote->nombre . "\n";
        }
    }
    
    echo "\n=== VERIFICANDO CONDICIONES DE LA VISTA ===\n";
    
    // Verificar las condiciones exactas de la vista
    echo "¿\$recoleccion->fecha_recoleccion? " . ($recoleccion->fecha_recoleccion ? 'TRUE' : 'FALSE') . "\n";
    echo "¿\$recoleccion->produccion? " . ($recoleccion->produccion ? 'TRUE' : 'FALSE') . "\n";
    echo "¿\$recoleccion->produccion->lote? " . (($recoleccion->produccion && $recoleccion->produccion->lote) ? 'TRUE' : 'FALSE') . "\n";
    echo "¿\$recoleccion->produccion->tipo_cacao? " . (($recoleccion->produccion && $recoleccion->produccion->tipo_cacao) ? 'TRUE' : 'FALSE') . "\n";
    echo "¿\$recoleccion->estado_fruto? " . ($recoleccion->estado_fruto ? 'TRUE' : 'FALSE') . "\n";
    echo "¿\$recoleccion->condiciones_climaticas? " . ($recoleccion->condiciones_climaticas ? 'TRUE' : 'FALSE') . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
