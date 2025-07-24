<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCantidadDisponibleToRecoleccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recolecciones', function (Blueprint $table) {
            // Solo agregar si no existe el campo
            if (!Schema::hasColumn('recolecciones', 'cantidad_disponible')) {
                $table->decimal('cantidad_disponible', 10, 2)->default(0)->after('cantidad_recolectada');
            }
        });

        // Actualizar cantidad_disponible con la cantidad_recolectada existente
        // Esto asume que inicialmente todo el stock está disponible
        DB::statement('UPDATE recolecciones SET cantidad_disponible = cantidad_recolectada WHERE cantidad_disponible = 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recolecciones', function (Blueprint $table) {
            $table->dropColumn('cantidad_disponible');
        });
    }
}