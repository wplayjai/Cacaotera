<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoteIdToRecoleccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recolecciones', function (Blueprint $table) {
        $table->unsignedBigInteger('lote_id')->nullable(); // O quitar nullable si es obligatorio
        $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('recolecciones', function (Blueprint $table) {
        $table->dropForeign(['lote_id']);
        $table->dropColumn('lote_id');
    });
    }
}
