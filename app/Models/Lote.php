<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'area',
        'capacidad',
        'tipo_cacao',
        'estado',
        'estimacion_cosecha',
        'fecha_programada_cosecha',
        'observaciones',
    ];
}
