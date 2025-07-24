<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            
            // Información básica de la venta
            $table->date('fecha_venta');
            $table->unsignedBigInteger('recoleccion_id');
            
            // Información del cliente
            $table->string('cliente', 255);
            $table->string('telefono_cliente', 20)->nullable();
            
            // Detalles de la venta
            $table->decimal('cantidad_vendida', 10, 2); // kg vendidos
            $table->decimal('precio_por_kg', 10, 2); // precio por kilogramo
            $table->decimal('total_venta', 12, 2); // total de la venta
            
            // Estado y método de pago
            $table->enum('estado_pago', ['pagado', 'pendiente'])->default('pendiente');
            $table->enum('metodo_pago', ['efectivo', 'transferencia', 'cheque']);
            $table->timestamp('fecha_pago')->nullable(); // fecha cuando se completó el pago
            
            // Observaciones adicionales
            $table->text('observaciones')->nullable();
            
            $table->timestamps();

            // Índices para optimizar consultas
            $table->index('fecha_venta');
            $table->index('estado_pago');
            $table->index('cliente');
            
            // Clave foránea
            $table->foreign('recoleccion_id')
                  ->references('id')
                  ->on('recolecciones')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}