<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Recoleccion;

echo "=== DEBUG DE RECOLECCION ID 1 ===\n\n";

// Simular lo que hace el controlador
$recoleccion = Recoleccion::with([
    'produccion.lote', 
    'produccion' => function($query) {
        $query->withCount('recolecciones');
    }
])->find(1);

if ($recoleccion) {
    echo "Recolección encontrada: ID {$recoleccion->id}\n";
    echo "Fecha recolección (raw): " . $recoleccion->getRawOriginal('fecha_recoleccion') . "\n";
    echo "Fecha recolección (cast): " . ($recoleccion->fecha_recoleccion ? $recoleccion->fecha_recoleccion->format('Y-m-d') : 'NULL') . "\n";
    echo "Cantidad recolectada: " . $recoleccion->cantidad_recolectada . "\n";
    
    // Verificar la producción
    if ($recoleccion->produccion) {
        echo "\nProducción cargada: ID {$recoleccion->produccion->id}\n";
        echo "Tipo cacao: {$recoleccion->produccion->tipo_cacao}\n";
        echo "Estimación: {$recoleccion->produccion->estimacion_produccion}\n";
        
        // Verificar el lote
        if ($recoleccion->produccion->lote) {
            echo "\nLote cargado: ID {$recoleccion->produccion->lote->id}\n";
            echo "Nombre lote: {$recoleccion->produccion->lote->nombre}\n";
        } else {
            echo "\nLote NO cargado\n";
        }
    } else {
        echo "\nProducción NO cargada\n";
    }
    
    echo "\nTrabajadores participantes: \n";
    var_dump($recoleccion->trabajadores_participantes);
    
} else {
    echo "Recolección con ID 1 no encontrada.\n";
}
