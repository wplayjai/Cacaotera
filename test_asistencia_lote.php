<?php

require_once 'vendor/autoload.php';

// Cargar la aplicación Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Asistencia;
use App\Models\Trabajador;
use App\Models\Lote;
use Carbon\Carbon;

echo "=== PRUEBA DE REGISTRO DE ASISTENCIA CON LOTE ===\n\n";

// Verificar trabajadores disponibles
echo "1. Verificando trabajadores disponibles:\n";
$trabajadores = Trabajador::with('user')->take(3)->get();
foreach ($trabajadores as $trabajador) {
    echo "   - ID: {$trabajador->id}, Nombre: {$trabajador->user->name}\n";
}

echo "\n2. Verificando lotes disponibles:\n";
$lotes = Lote::activos()->take(3)->get();
foreach ($lotes as $lote) {
    echo "   - ID: {$lote->id}, Nombre: {$lote->nombre_completo}\n";
}

if ($trabajadores->count() > 0 && $lotes->count() > 0) {
    $trabajador = $trabajadores->first();
    $lote = $lotes->first();
    
    echo "\n3. Creando asistencia de prueba:\n";
    echo "   - Trabajador: {$trabajador->user->name} (ID: {$trabajador->id})\n";
    echo "   - Lote: {$lote->nombre_completo} (ID: {$lote->id})\n";
    echo "   - Fecha: " . Carbon::today()->format('Y-m-d') . "\n";
    
    try {
        $asistencia = Asistencia::create([
            'trabajador_id' => $trabajador->id,
            'lote_id' => $lote->id,
            'fecha' => Carbon::today(),
            'hora_entrada' => '08:00',
            'hora_salida' => '17:00',
            'observaciones' => 'Prueba de registro con lote'
        ]);
        
        echo "\n✅ Asistencia creada exitosamente!\n";
        echo "   - ID: {$asistencia->id}\n";
        echo "   - Lote ID: {$asistencia->lote_id}\n";
        echo "   - Horas trabajadas: {$asistencia->horas_trabajadas}\n";
        
        // Cargar las relaciones
        $asistencia->load(['trabajador.user', 'lote']);
        echo "   - Trabajador: {$asistencia->trabajador->user->name}\n";
        echo "   - Lote: {$asistencia->lote->nombre_completo}\n";
        
        echo "\n4. Limpiando datos de prueba...\n";
        $asistencia->delete();
        echo "✅ Datos de prueba eliminados\n";
        
    } catch (Exception $e) {
        echo "\n❌ Error al crear asistencia:\n";
        echo "   - Error: {$e->getMessage()}\n";
        echo "   - Archivo: {$e->getFile()}:{$e->getLine()}\n";
    }
} else {
    echo "\n❌ No hay suficientes datos para la prueba\n";
    echo "   - Trabajadores: {$trabajadores->count()}\n";
    echo "   - Lotes: {$lotes->count()}\n";
}

echo "\n=== PRUEBA COMPLETADA ===\n";
