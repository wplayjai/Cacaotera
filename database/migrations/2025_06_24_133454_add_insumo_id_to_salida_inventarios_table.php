<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInsumoIdToSalidaInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('salida_inventarios', function (Blueprint $table) {
        $table->foreignId('insumo_id')->nullable()->constrained('inventarios')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('salida_inventarios', function (Blueprint $table) {
        $table->dropForeign(['insumo_id']);
        $table->dropColumn('insumo_id');
    });
}
}
