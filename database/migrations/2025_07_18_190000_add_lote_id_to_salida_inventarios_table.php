<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoteIdToSalidaInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salida_inventarios', function (Blueprint $table) {
            if (!Schema::hasColumn('salida_inventarios', 'lote_id')) {
                $table->foreignId('lote_id')->nullable()->constrained('lotes')->onDelete('set null');
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
            if (Schema::hasColumn('salida_inventarios', 'lote_id')) {
                $table->dropForeign(['lote_id']);
                $table->dropColumn('lote_id');
            }
        });
    }
}
