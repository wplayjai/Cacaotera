<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'area',
        'capacidad',
        'tipo_cacao',
        'tipo_cultivo',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'area' => 'decimal:2',
        'capacidad' => 'decimal:2',
    ];

    // Relaciones
    public function producciones()
    {
        return $this->hasMany(Produccion::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function salidaInventarios()
    {
        return $this->hasMany(SalidaInventario::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', '!=', 'inactivo')
                    ->orWhereNull('estado');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_cultivo', $tipo);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // Accessors
    public function getAreaFormateadaAttribute()
    {
        return number_format($this->area, 2) . ' ha';
    }

    public function getNombreCompletoAttribute()
    {
        $info = $this->nombre;
        
        if ($this->area) {
            $info .= ' - ' . $this->area_formateada;
        }
        
        if ($this->tipo_cultivo) {
            $info .= ' (' . ucfirst($this->tipo_cultivo) . ')';
        }
        
        return $info;
    }

    // Métodos de utilidad
    public function estaActivo()
    {
        return $this->estado !== 'inactivo';
    }

    public function getTipoDisplay()
    {
        return ucfirst($this->tipo_cultivo ?? $this->tipo_cacao ?? 'Sin especificar');
    }
}
