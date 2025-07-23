<?php

require_once 'vendor/autoload.php';

// Cargar la aplicación Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Produccion;
use App\Models\Recoleccion;
use App\Models\Lote;

echo "=== PRUEBA DE FILTROS DE BÚSQUEDA ===\n\n";

// 1. Probar búsqueda en Producción
echo "1. Búsqueda en Producciones:\n";
$search = "Norte"; // Buscar por lote "Norte"

$producciones = Produccion::with(['lote'])
    ->where(function ($q) use ($search) {
        $q->where('tipo_cacao', 'like', "%$search%")
          ->orWhereHas('lote', function ($q) use ($search) {
              $q->where('nombre', 'like', "%$search%");
          });
    })
    ->get();

echo "   Resultados para búsqueda '$search': {$producciones->count()} producciones encontradas\n";
foreach ($producciones as $produccion) {
    echo "     - ID: {$produccion->id}, Tipo: {$produccion->tipo_cacao}, Lote: " . ($produccion->lote->nombre ?? 'Sin lote') . "\n";
}

// 2. Probar búsqueda en Recolecciones  
echo "\n2. Búsqueda en Recolecciones:\n";
$recolecciones = Recoleccion::with(['produccion.lote'])
    ->where(function ($q) use ($search) {
        $q->whereHas('produccion.lote', function ($q) use ($search) {
            $q->where('nombre', 'like', "%$search%");
        })
        ->orWhereHas('produccion', function ($q) use ($search) {
            $q->where('tipo_cacao', 'like', "%$search%");
        });
    })
    ->get();

echo "   Resultados para búsqueda '$search': {$recolecciones->count()} recolecciones encontradas\n";
foreach ($recolecciones as $recoleccion) {
    echo "     - ID: {$recoleccion->id}, Fecha: " . $recoleccion->fecha_recoleccion->format('d/m/Y') . 
         ", Lote: " . ($recoleccion->produccion->lote->nombre ?? 'Sin lote') . 
         ", Cantidad: {$recoleccion->cantidad_recolectada}kg\n";
}

// 3. Probar búsqueda por tipo de cacao
echo "\n3. Búsqueda por tipo de cacao:\n";
$tipoCacao = "Ccn-51";

$produccionesTipo = Produccion::with(['lote'])
    ->where('tipo_cacao', 'like', "%$tipoCacao%")
    ->get();

echo "   Resultados para tipo '$tipoCacao': {$produccionesTipo->count()} producciones encontradas\n";

// 4. Mostrar todos los lotes disponibles
echo "\n4. Lotes disponibles para búsqueda:\n";
$lotes = Lote::all();
foreach ($lotes as $lote) {
    echo "   - ID: {$lote->id}, Nombre: {$lote->nombre}, Área: " . ($lote->area ?? 'Sin área') . " ha\n";
}

// 5. Mostrar tipos de cacao disponibles
echo "\n5. Tipos de cacao disponibles:\n";
$tipos = Produccion::distinct()->pluck('tipo_cacao')->filter();
foreach ($tipos as $tipo) {
    echo "   - $tipo\n";
}

echo "\n=== PRUEBA COMPLETADA ===\n";
echo "Los filtros deberían funcionar correctamente en:\n";
echo "- /produccion (index)\n";
echo "- /recolecciones (index)\n"; 
echo "- /produccion/reporte-rendimiento (reportes)\n";
