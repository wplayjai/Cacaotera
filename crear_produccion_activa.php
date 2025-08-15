<?php
// Script para crear una producción activa de prueba para el lote seleccionado
use Illuminate\Support\Facades\DB;
use App\Models\Produccion;

$loteId = 1; // Cambia por el ID del lote que necesitas

Produccion::create([
    'lote_id' => $loteId,
    'fecha_inicio' => now(),
    'tipo_cacao' => 'CCN-51',
    'area_asignada' => 10,
    'estimacion_produccion' => 1000,
    'estado' => 'activo',
    'activo' => true,
]);

echo "Producción activa creada para el lote $loteId";
