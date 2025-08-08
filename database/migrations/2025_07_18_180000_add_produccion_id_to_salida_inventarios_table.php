<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProduccionIdToSalidaInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salida_inventarios', function (Blueprint $table) {
            // El campo produccion_id ya existe en la migración original de create_salida_inventarios_table
            // Esta migración se mantiene para compatibilidad pero no hace nada
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salida_inventarios', function (Blueprint $table) {
            $table->dropForeign(['produccion_id']);
            $table->dropColumn('produccion_id');
        });
    }
}
