<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventario;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventarios = [
            [
                'nombre' => 'Fertilizante NPK',
                'lote_id' => null,
                'tipo' => 'Fertilizantes',
                'cantidad' => 500,
                'unidad_medida' => 'kg',
                'precio_unitario' => 25.50,
                'estado' => 'Óptimo',
                'fecha_registro' => now(),
            ],
            [
                'nombre' => 'Pesticida Orgánico',
                'lote_id' => null,
                'tipo' => 'Pesticidas',
                'cantidad' => 200,
                'unidad_medida' => 'ml',
                'precio_unitario' => 45.75,
                'estado' => 'Óptimo',
                'fecha_registro' => now(),
            ],
            [
                'nombre' => 'Fertilizante de Cacao',
                'lote_id' => null,
                'tipo' => 'Fertilizantes',
                'cantidad' => 300,
                'unidad_medida' => 'kg',
                'precio_unitario' => 30.00,
                'estado' => 'Por vencer',
                'fecha_registro' => now(),
            ],
            [
                'nombre' => 'Fungicida',
                'lote_id' => null,
                'tipo' => 'Pesticidas',
                'cantidad' => 150,
                'unidad_medida' => 'ml',
                'precio_unitario' => 55.25,
                'estado' => 'Restringido',
                'fecha_registro' => now(),
            ],
        ];

        foreach ($inventarios as $inventario) {
            Inventario::create($inventario);
        }
    }
}
