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
            $table->unsignedBigInteger('produccion_id')->nullable()->after('lote_id');
            $table->foreign('produccion_id')->references('id')->on('producciones')->onDelete('set null');
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
