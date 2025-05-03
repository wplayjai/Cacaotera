<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'direccion',
        'telefono',
        'fecha_contratacion',
        'tipo_contrato',
        'forma_pago',
        'identificacion' // si también la tienes aquí
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
