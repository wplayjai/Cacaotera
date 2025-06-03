<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventarios';

    protected $fillable = [
        'nombre',
        'tipo',
        'cantidad',
        'unidad_medida',
        'precio_unitario',
        'estado',
        'fecha_registro',
    ];
}
