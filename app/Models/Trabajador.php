<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajadors'; // Especifica el nombre correcto de la tabla

    protected $fillable = [
        'user_id',
        'direccion',
        'telefono',
        'fecha_contratacion',
        'tipo_contrato',
        'forma_pago',
        'identificacion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function producciones()
    {
        return $this->belongsToMany(Produccion::class, 'produccion_trabajador')
                    ->withPivot('fecha_asignacion', 'rol', 'horas_trabajadas', 'tarifa_hora', 'observaciones')
                    ->withTimestamps();
    }
}