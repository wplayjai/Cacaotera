<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'trabajador_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'observaciones'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}