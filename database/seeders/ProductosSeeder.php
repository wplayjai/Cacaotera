<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductosSeeder extends Seeder
{
    public function run()
{
    Producto::create([
        'nombre' => 'Cacao Criollo',
        'tipo_insumo' => 'Cacao', // Changed from 'tipo' to 'tipo_insumo'
        'cantidad' => 750,
        'estado' => 'Óptimo',
    ]);

    // You might want to add a few more seed entries for variety
    Producto::create([
        'nombre' => 'Cacao Forastero',
        'tipo_insumo' => 'Cacao',
        'cantidad' => 500,
        'estado' => 'Óptimo',
    ]);

    Producto::create([
        'nombre' => 'Manteca de Cacao',
        'tipo_insumo' => 'Derivado',
        'cantidad' => 250,
        'estado' => 'Bajo',
    ]);

    Producto::create([
        'nombre' => 'Azúcar',
        'tipo_insumo' => 'Insumo',
        'cantidad' => 80,
        'estado' => 'Bajo',
    ]);
}

}