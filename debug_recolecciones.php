<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Recoleccion;

echo "=== DEBUG DE RECOLECCIONES ===\n\n";

// Contar recolecciones
$total = Recoleccion::count();
echo "Total de recolecciones en BD: $total\n\n";

if ($total > 0) {
    // Obtener las primeras 3
    $recolecciones = Recoleccion::with('produccion.lote')->take(3)->get();
    
    foreach ($recolecciones as $r) {
        echo "ID: {$r->id}\n";
        echo "Fecha: " . ($r->fecha_recoleccion ? $r->fecha_recoleccion->format('Y-m-d') : 'NULL') . "\n";
        echo "Cantidad: " . ($r->cantidad_recolectada ?? 'NULL') . "\n";
        echo "Producción ID: " . ($r->produccion_id ?? 'NULL') . "\n";
        echo "Tiene producción: " . ($r->produccion ? 'SÍ' : 'NO') . "\n";
        if ($r->produccion) {
            echo "Tipo cacao: " . ($r->produccion->tipo_cacao ?? 'NULL') . "\n";
            echo "Tiene lote: " . ($r->produccion->lote ? 'SÍ' : 'NO') . "\n";
            if ($r->produccion->lote) {
                echo "Nombre lote: " . $r->produccion->lote->nombre . "\n";
            }
        }
        echo "Estado fruto: " . ($r->estado_fruto ?? 'NULL') . "\n";
        echo "Clima: " . ($r->condiciones_climaticas ?? 'NULL') . "\n";
        echo "Trabajadores: " . (is_array($r->trabajadores_participantes) ? count($r->trabajadores_participantes) : '0') . "\n";
        echo "Activo: " . ($r->activo ? 'SÍ' : 'NO') . "\n";
        echo "------------------------\n\n";
    }
} else {
    echo "No hay recolecciones en la base de datos.\n";
}
