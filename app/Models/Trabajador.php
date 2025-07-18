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

    // Scope para trabajadores activos (basado en el estado del usuario)
    public function scopeActivos($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('estado', 'activo');
        });
    }

    // Método para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->user->name ?? 'Sin nombre';
    }

    // Método para obtener el nombre separado
    public function getNombreAttribute()
    {
        $nombreCompleto = $this->user->name ?? '';
        return explode(' ', $nombreCompleto)[0] ?? '';
    }

    // Método para obtener el apellido
    public function getApellidoAttribute()
    {
        $nombreCompleto = $this->user->name ?? '';
        $partes = explode(' ', $nombreCompleto);
        return count($partes) > 1 ? implode(' ', array_slice($partes, 1)) : '';
    }
}