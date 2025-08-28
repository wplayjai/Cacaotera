<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Recoleccion extends Model
{
    protected $table = 'recolecciones';

    protected $fillable = [
        'produccion_id',
        'fecha_recoleccion',
        'cantidad_recolectada',
        'cantidad_disponible',
        'estado_fruto',
        'trabajadores_participantes',
        'observaciones',
        'condiciones_climaticas',
        'calidad_promedio',
        'hora_inicio',
        'hora_fin',
        'foto_recoleccion',
        'activo'
    ];

    protected $casts = [
        'fecha_recoleccion' => 'date',
        'cantidad_recolectada' => 'decimal:3',
        'cantidad_disponible' => 'decimal:3',
        'calidad_promedio' => 'decimal:1',
        'trabajadores_participantes' => 'array',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'activo' => 'boolean'
    ];

    // Relación con Producción
    public function produccion(): BelongsTo
    {
        return $this->belongsTo(Produccion::class);
    }

    // Relación con Ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'recoleccion_id');
    }

    // Obtener trabajadores participantes como objetos
    public function trabajadoresParticipantes()
    {
        if (!$this->trabajadores_participantes) {
            return collect();
        }

        return Trabajador::whereIn('id', $this->trabajadores_participantes)->get();
    }

    // Calcular horas trabajadas
    public function getHorasTrabajadasAttribute()
    {
        if (!$this->hora_inicio || !$this->hora_fin) {
            return null;
        }

        $inicio = Carbon::parse($this->hora_inicio);
        $fin = Carbon::parse($this->hora_fin);

        return $fin->diffInHours($inicio);
    }

    // Obtener rendimiento por hora
    public function getRendimientoPorHoraAttribute()
    {
        $horas = $this->horas_trabajadas;
        if (!$horas || $horas == 0) {
            return 0;
        }

        return round($this->cantidad_recolectada / $horas, 2);
    }

    // Obtener badge de estado del fruto
    public function getBadgeEstadoFrutoAttribute()
    {
        $estados = [
            'maduro' => ['class' => 'success', 'icon' => 'check-circle'],
            'semi-maduro' => ['class' => 'warning', 'icon' => 'clock'],
            'verde' => ['class' => 'danger', 'icon' => 'times-circle']
        ];

        return $estados[$this->estado_fruto] ?? ['class' => 'secondary', 'icon' => 'question'];
    }

    // Obtener badge de condiciones climáticas
    public function getBadgeClimaAttribute()
    {
        $climas = [
            'soleado' => ['class' => 'warning', 'icon' => 'sun'],
            'nublado' => ['class' => 'secondary', 'icon' => 'cloud'],
            'lluvioso' => ['class' => 'info', 'icon' => 'cloud-rain']
        ];

        return $climas[$this->condiciones_climaticas] ?? ['class' => 'light', 'icon' => 'question'];
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorProduccion($query, $produccionId)
    {
        return $query->where('produccion_id', $produccionId);
    }

    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fecha_recoleccion', $fecha);
    }
}
