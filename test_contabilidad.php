<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Lote;
use App\Models\Produccion;
use App\Models\SalidaInventario;
use App\Models\Venta;
use App\Models\Recoleccion;

echo "=== TEST DE RELACIONES DE CONTABILIDAD ===\n\n";

// Verificar lotes con producciones
$lotes = Lote::with(['producciones', 'salidaInventarios.insumo', 'producciones.recolecciones.ventas'])->get();

foreach ($lotes as $lote) {
    echo "Lote: " . $lote->nombre . " (ID: " . $lote->id . ")\n";
    echo "  Estado: " . $lote->estado . "\n";
    echo "  Producciones: " . $lote->producciones->count() . "\n";
    echo "  Salidas de inventario: " . $lote->salidaInventarios->count() . "\n";
    
    $totalGastado = 0;
    foreach ($lote->salidaInventarios as $salida) {
        $valor = $salida->cantidad * $salida->precio_unitario;
        $totalGastado += $valor;
        $insumoNombre = $salida->insumo ? $salida->insumo->nombre : 'Sin insumo';
        echo "    - " . $insumoNombre . ": " . $salida->cantidad . " x $" . $salida->precio_unitario . " = $" . $valor . "\n";
    }
    
    $totalVendido = 0;
    foreach ($lote->producciones as $produccion) {
        echo "  Producción " . $produccion->id . ": " . $produccion->recolecciones->count() . " recolecciones\n";
        foreach ($produccion->recolecciones as $recoleccion) {
            echo "    Recolección " . $recoleccion->id . ": " . $recoleccion->ventas->count() . " ventas\n";
            foreach ($recoleccion->ventas as $venta) {
                $totalVendido += $venta->total_venta;
                echo "      - Venta $" . $venta->total_venta . " a " . $venta->cliente . "\n";
            }
        }
    }
    
    $ganancia = $totalVendido - $totalGastado;
    echo "  RESUMEN:\n";
    echo "    Total gastado: $" . $totalGastado . "\n";
    echo "    Total vendido: $" . $totalVendido . "\n";
    echo "    Ganancia: $" . $ganancia . " " . ($ganancia >= 0 ? '✅' : '❌') . "\n";
    echo "\n" . str_repeat('-', 50) . "\n\n";
}

echo "Test completado.\n";
