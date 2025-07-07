<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProduccionesTable extends Migration
{
    public function up()
    {
        Schema::table('producciones', function (Blueprint $table) {
            // Agregar campos faltantes si no existen
            if (!Schema::hasColumn('producciones', 'precio_venta_kg')) {
                $table->decimal('precio_venta_kg', 10, 2)->nullable()->after('desviacion_estimacion');
            }
            
            if (!Schema::hasColumn('producciones', 'costo_total')) {
                $table->decimal('costo_total', 10, 2)->nullable()->after('precio_venta_kg');
            }
            
            if (!Schema::hasColumn('producciones', 'rentabilidad')) {
                $table->decimal('rentabilidad', 10, 2)->nullable()->after('costo_total');
            }
            
            if (!Schema::hasColumn('producciones', 'margen_rentabilidad')) {
                $table->decimal('margen_rentabilidad', 5, 2)->nullable()->after('rentabilidad');
            }
            
            // Índices para optimizar consultas
            $table->index(['estado', 'activo'], 'estado_activo_custom_index');
            $table->index(['fecha_programada_cosecha', 'estado']);
            $table->index(['tipo_cacao', 'activo']);
            $table->index(['fecha_inicio', 'activo']);
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

