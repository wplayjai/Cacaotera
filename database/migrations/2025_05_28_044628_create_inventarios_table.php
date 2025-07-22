<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('nombre'); // Nombre del producto
            $table->enum('tipo', ['Fertilizantes', 'Pesticidas']); // Tipo
            $table->integer('cantidad'); // Cantidad (kg)
            $table->enum('unidad_medida', ['kg', 'ml']); // Unidad de medida
            $table->decimal('precio_unitario', 10, 2); // Precio unitario
            $table->enum('estado', ['Óptimo', 'Por vencer', 'Restringido']); // Estado
            $table->date('fecha_registro'); // Nueva columna para la fecha de registro
            $table->timestamps(); // created_at (fecha registro) y updated_at (fecha actualización)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventarios');
    }
}


