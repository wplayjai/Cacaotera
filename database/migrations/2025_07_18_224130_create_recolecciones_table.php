<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecoleccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recolecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produccion_id')->constrained('producciones')->onDelete('cascade');
            $table->date('fecha_recoleccion');
            $table->decimal('cantidad_recolectada', 8, 3)->comment('Cantidad en kilogramos');
            $table->string('estado_fruto')->default('maduro'); // maduro, semi-maduro, verde
            $table->json('trabajadores_participantes')->nullable()->comment('Array de IDs de trabajadores');
            $table->text('observaciones')->nullable();
            $table->string('condiciones_climaticas')->nullable(); // soleado, lluvioso, nublado
            $table->decimal('calidad_promedio', 3, 1)->nullable()->comment('Calidad del 1 al 10');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('foto_recoleccion')->nullable()->comment('Ruta de la foto del día');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            // Índices para mejorar consultas
            $table->index(['produccion_id', 'fecha_recoleccion']);
            $table->index('fecha_recoleccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recolecciones');
    }
}
