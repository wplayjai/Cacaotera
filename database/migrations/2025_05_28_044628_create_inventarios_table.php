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
            $table->string('tipo_insumo'); // Tipo
            $table->decimal('cantidad', 10, 2); // Cantidad (kg)
            $table->string('unidad_medida'); // Unidad de medida
            $table->decimal('precio_unitario', 10, 2); // Precio unitario
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo'); // Estado
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
