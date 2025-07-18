<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

try {
    Schema::table('users', function (Blueprint $table) {
        $table->enum('estado', ['activo', 'inactivo'])->default('activo')->after('password');
    });
    
    echo "✅ Campo 'estado' agregado exitosamente a la tabla 'users'\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
