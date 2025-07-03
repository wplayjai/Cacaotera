<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidaInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ejemplo de migración
        Schema::create('salida_inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insumo_id')->constrained('inventarios')->onDelete('cascade');
            $table->decimal('cantidad', 10, 2);
            $table->string('unidad_medida');
            $table->decimal('precio_unitario', 10, 2);
            $table->string('estado');
            $table->date('fecha_registro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salida_inventarios');
    }
}
