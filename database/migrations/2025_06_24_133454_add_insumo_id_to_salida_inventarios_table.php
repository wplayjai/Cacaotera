<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInsumoIdToSalidaInventariosTable extends Migration
{
    public function up()
    {
        Schema::table('salida_inventarios', function (Blueprint $table) {
            if (!Schema::hasColumn('salida_inventarios', 'insumo_id')) {
                $table->foreignId('insumo_id')->nullable()->constrained('inventarios')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('salida_inventarios', function (Blueprint $table) {
            if (Schema::hasColumn('salida_inventarios', 'insumo_id')) {
                $table->dropForeign(['insumo_id']);
                $table->dropColumn('insumo_id');
            }
        });
    }
}
