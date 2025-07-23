<?php

require_once __DIR__ . '/vendor/autoload.php';

// Configurar Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Recoleccion;

echo "=== VERIFICANDO DATOS REALES ===\n\n";

try {
    // Verificar conexión
    $connection = \DB::connection()->getPDO();
    echo "✅ Conexión a BD exitosa\n";
    echo "Base de datos: " . \DB::connection()->getDatabaseName() . "\n\n";

    // Contar registros
    $total = Recoleccion::count();
    echo "📊 Total de recolecciones: $total\n\n";

    if ($total > 0) {
        // Obtener recolecciones con relaciones
        $recolecciones = Recoleccion::with(['produccion.lote'])->get();
        
        foreach ($recolecciones as $index => $r) {
            echo "--- RECOLECCIÓN #" . ($index + 1) . " ---\n";
            echo "ID: {$r->id}\n";
            echo "Fecha: " . ($r->fecha_recoleccion ? $r->fecha_recoleccion->format('Y-m-d') : 'NULL') . "\n";
            echo "Cantidad: " . ($r->cantidad_recolectada ?? 'NULL') . " kg\n";
            echo "Estado fruto: " . ($r->estado_fruto ?? 'NULL') . "\n";
            echo "Clima: " . ($r->condiciones_climaticas ?? 'NULL') . "\n";
            echo "Producción ID: " . ($r->produccion_id ?? 'NULL') . "\n";
            
            if ($r->produccion) {
                echo "✅ Producción cargada: ID {$r->produccion->id}\n";
                echo "   Tipo cacao: " . ($r->produccion->tipo_cacao ?? 'NULL') . "\n";
                echo "   Estimación: " . ($r->produccion->estimacion_produccion ?? 'NULL') . " kg\n";
                
                if ($r->produccion->lote) {
                    echo "✅ Lote cargado: '{$r->produccion->lote->nombre}'\n";
                } else {
                    echo "❌ Lote NO cargado\n";
                }
            } else {
                echo "❌ Producción NO cargada\n";
            }
            
            $trabajadores = $r->trabajadores_participantes;
            if (is_array($trabajadores)) {
                echo "Trabajadores: " . count($trabajadores) . " registrados\n";
            } else {
                echo "Trabajadores: NULL o formato incorrecto\n";
            }
            
            echo "Activo: " . ($r->activo ? 'SÍ' : 'NO') . "\n";
            echo "\n";
        }
    } else {
        echo "❌ No hay recolecciones en la tabla\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
