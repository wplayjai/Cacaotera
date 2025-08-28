<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Probar la relación
try {
    echo "Probando relación inventario en SalidaInventario...\n";

    $salida = App\Models\SalidaInventario::with('inventario')->first();

    if ($salida) {
        echo "✓ Relación funciona correctamente\n";
        if ($salida->inventario) {
            echo "✓ Inventario encontrado: " . $salida->inventario->nombre . "\n";
        } else {
            echo "⚠ Relación existe pero inventario no encontrado para esta salida\n";
        }
    } else {
        echo "⚠ No hay registros de SalidaInventario\n";
    }

} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
