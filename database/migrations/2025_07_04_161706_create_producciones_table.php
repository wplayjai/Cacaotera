<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lote_id');
            $table->date('fecha_inicio');
            $table->string('tipo_cacao');
            $table->decimal('area_asignada', 10, 2);
            $table->decimal('estimacion_produccion', 10, 2);
            $table->enum('estado', ['planificado', 'siembra', 'crecimiento', 'maduracion', 'cosecha', 'secado', 'completado'])->default('planificado');
            $table->datetime('fecha_cambio_estado')->nullable();
            $table->text('observaciones')->nullable();
            $table->decimal('cantidad_cosechada', 10, 2)->nullable();
            $table->date('fecha_cosecha_real')->nullable();
            $table->decimal('rendimiento_real', 10, 2)->nullable();
            $table->decimal('desviacion_estimacion', 10, 2)->nullable();
            $table->json('personal_asignado')->nullable();
            $table->json('insumos_utilizados')->nullable();
            $table->date('fecha_programada_cosecha')->nullable();
            $table->boolean('notificacion_cosecha')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Índices
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
            $table->index(['estado', 'activo']);
            $table->index('fecha_programada_cosecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producciones');
    }
}