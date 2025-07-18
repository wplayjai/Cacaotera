<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Marcar las migraciones como ejecutadas
    DB::table('migrations')->insert([
        ['migration' => '2025_07_05_005021_update_producciones_table', 'batch' => 2],
        ['migration' => '2025_07_08_180545_add_estado_to_users_table', 'batch' => 2],
        ['migration' => '2025_07_18_150218_remove_estimacion_cosecha_and_fecha_programada_cosecha_from_lotes_table', 'batch' => 2]
    ]);
    
    echo "✅ Migraciones marcadas como ejecutadas\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
