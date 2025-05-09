<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('lotes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->date('fecha_inicio');
        $table->decimal('area', 8, 2);
        $table->integer('capacidad');
        $table->string('tipo_cacao');
        $table->enum('estado', ['Activo', 'Inactivo']);
        $table->decimal('estimacion_cosecha', 8, 2)->nullable();
        $table->date('fecha_programada_cosecha')->nullable();
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
        Schema::dropIfExists('lotes');
    }
}