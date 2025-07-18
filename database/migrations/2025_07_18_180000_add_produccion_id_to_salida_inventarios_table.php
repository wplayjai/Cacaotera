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
            if (!Schema::hasColumn('salida_inventarios', 'produccion_id')) {
                $table->foreignId('produccion_id')->nullable()->constrained('producciones')->onDelete('set null');
            }
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
            if (Schema::hasColumn('salida_inventarios', 'produccion_id')) {
                $table->dropForeign(['produccion_id']);
                $table->dropColumn('produccion_id');
            }
        });
    }
}
