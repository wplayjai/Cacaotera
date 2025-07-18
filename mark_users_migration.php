<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Marcar la migración como ejecutada
    DB::table('migrations')->insert([
        'migration' => '2025_07_08_180545_add_estado_to_users_table',
        'batch' => 2
    ]);
    
    echo "✅ Migración add_estado_to_users_table marcada como ejecutada\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
