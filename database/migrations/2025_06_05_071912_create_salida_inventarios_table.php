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
            $table->foreignId('lote_id')->nullable()->constrained('lotes')->onDelete('set null');

            // Campos principales
            $table->decimal('cantidad', 10, 3);
            $table->string('unidad_medida');
            $table->decimal('precio_unitario', 10, 2);
            $table->string('estado');
            $table->date('fecha_registro');
        

            // Campos adicionales (ahora opcionales)
            $table->date('fecha_salida')->nullable();
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
