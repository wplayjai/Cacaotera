<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateProduccionesTable extends Migration
{
    public function up()
    {
        Schema::table('producciones', function (Blueprint $table) {
            // Los campos ya existen en la migración de creación
            // Esta migración ahora es redundante pero se mantiene para compatibilidad
        });
    }

    public function down()
    {
        Schema::table('producciones', function (Blueprint $table) {
            $table->dropIndex(['estado', 'activo']);
            $table->dropIndex(['fecha_programada_cosecha', 'estado']);
            $table->dropIndex(['tipo_cacao', 'activo']);
            $table->dropIndex(['fecha_inicio', 'activo']);

            $table->dropColumn([
                'precio_venta_kg',
                'costo_total',
                'rentabilidad',
                'margen_rentabilidad'
            ]);
        });
    }
}

