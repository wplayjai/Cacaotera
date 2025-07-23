<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            // Agregar lote_id para vincular la asistencia con un lote específico
            $table->unsignedBigInteger('lote_id')->nullable()->after('trabajador_id');
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('set null');
            
            // Agregar horas_trabajadas calculado automáticamente
            $table->decimal('horas_trabajadas', 5, 2)->nullable()->after('hora_salida');
            
            // Agregar índices para mejorar rendimiento
            $table->index(['trabajador_id', 'fecha']);
            $table->index(['lote_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex(['trabajador_id', 'fecha']);
            $table->dropIndex(['lote_id', 'fecha']);
            
            // Eliminar foreign key
            $table->dropForeign(['lote_id']);
            
            // Eliminar columnas
            $table->dropColumn(['lote_id', 'horas_trabajadas']);
        });
    }
}
