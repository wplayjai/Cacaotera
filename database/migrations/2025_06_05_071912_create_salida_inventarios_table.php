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
        Schema::create('salida_inventarios', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('insumo_id')->constrained('inventarios')->onDelete('cascade');
            $table->foreignId('produccion_id')->nullable()->constrained('producciones')->onDelete('set null');

            // Campos principales de la primera versión
            $table->decimal('cantidad', 10, 3); // Precisión aumentada de 2 a 3 decimales
            $table->string('unidad_medida');
            $table->decimal('precio_unitario', 10, 2);
            $table->string('estado');
            $table->date('fecha_registro');

            // Campos adicionales del segundo bloque
            $table->string('motivo');
            $table->date('fecha_salida');
            $table->string('responsable');
            $table->text('observaciones')->nullable();

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
