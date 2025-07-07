<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduccionInsumoTable extends Migration
{
    public function up()
    {
        Schema::create('produccion_insumo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produccion_id')->constrained('producciones')->onDelete('cascade');
            $table->foreignId('inventario_id')->constrained('inventarios')->onDelete('cascade');
            $table->decimal('cantidad_utilizada', 10, 3);
            $table->date('fecha_uso');
            $table->decimal('costo_unitario', 10, 2);
            $table->decimal('costo_total', 10, 2);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produccion_insumo');
    }
}

