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

            // Relación con lotes
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');

            // Campos básicos
            $table->date('fecha_inicio');
            $table->string('tipo_cacao');
            $table->decimal('area_asignada', 10, 2);
            $table->decimal('estimacion_produccion', 10, 2);
            $table->string('estado')->default('planificado');
            $table->timestamp('fecha_cambio_estado')->nullable();
            $table->text('observaciones')->nullable();

            // Campos de cosecha
            $table->decimal('cantidad_cosechada', 10, 2)->nullable();
            $table->date('fecha_cosecha_real')->nullable();
            $table->decimal('rendimiento_real', 10, 2)->nullable();
            $table->decimal('desviacion_estimacion', 10, 2)->nullable();

            // Campos adicionales
            $table->json('personal_asignado')->nullable();
            $table->json('insumos_utilizados')->nullable();
            $table->date('fecha_programada_cosecha')->nullable();
            $table->boolean('notificacion_cosecha')->default(false);
            $table->boolean('activo')->default(true);

            // Campos que se agregan en la migración de actualización
            $table->decimal('precio_venta_kg', 10, 2)->nullable();
            $table->decimal('costo_total', 10, 2)->nullable();
            $table->decimal('rentabilidad', 10, 2)->nullable();
            $table->decimal('margen_rentabilidad', 5, 2)->nullable();

            $table->timestamps();

            // Índices
            $table->index(['estado', 'activo']);
            $table->index(['fecha_programada_cosecha', 'estado']);
            $table->index(['tipo_cacao', 'activo']);
            $table->index(['fecha_inicio', 'activo']);
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
