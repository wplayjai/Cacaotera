<?php

// Verificación rápida del sistema de trabajo diario

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Configurar la conexión
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'cacaotera',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "✓ Conexión a la base de datos establecida\n";

// Verificar que las tablas existen
try {
    $trabajadores = Capsule::table('trabajadores')->count();
    echo "✓ Tabla trabajadores: {$trabajadores} registros\n";
    
    $lotes = Capsule::table('lotes')->count();
    echo "✓ Tabla lotes: {$lotes} registros\n";
    
    $producciones = Capsule::table('producciones')->count();
    echo "✓ Tabla producciones: {$producciones} registros\n";
    
    $trabajos_diarios = Capsule::table('trabajos_diarios')->count();
    echo "✓ Tabla trabajos_diarios: {$trabajos_diarios} registros\n";
    
    echo "\n✓ Sistema listo para uso!\n";
    echo "📋 Accede a: http://localhost/webcacao/Cacaotera/public/trabajadores/pagos\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
