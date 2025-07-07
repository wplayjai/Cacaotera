<?php

// Migración para tabla produccion_trabajador
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduccionTrabajadorTable extends Migration
{
    public function up()
    {
        Schema::create('produccion_trabajador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produccion_id')->constrained('producciones')->onDelete('cascade');
            $table->foreignId('trabajador_id')->constrained('trabajadors')->onDelete('cascade');
            $table->date('fecha_asignacion')->default(now());
            $table->string('rol')->nullable(); // supervisor, operario, etc.
            $table->decimal('horas_trabajadas', 8, 2)->default(0);
            $table->decimal('tarifa_hora', 8, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->unique(['produccion_id', 'trabajador_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('produccion_trabajador');
    }
}

