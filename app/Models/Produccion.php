<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon; // ✅ Correcto


class Produccion extends Model
{
    protected $table = 'producciones';
    
    protected $fillable = [
        'lote_id',
        'fecha_inicio',
        'tipo_cacao',
        'area_asignada',
        'estimacion_produccion',
        'estado',
        'fecha_cambio_estado',
        'observaciones',
        'cantidad_cosechada',
        'fecha_cosecha_real',
        'rendimiento_real',
        'desviacion_estimacion',
        'personal_asignado',
        'insumos_utilizados',
        'fecha_programada_cosecha',
        'notificacion_cosecha',
        'activo'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_cambio_estado' => 'datetime',
        'fecha_cosecha_real' => 'date',
        'fecha_programada_cosecha' => 'date',
        'estimacion_produccion' => 'decimal:2',
        'cantidad_cosechada' => 'decimal:2',
        'rendimiento_real' => 'decimal:2',
        'desviacion_estimacion' => 'decimal:2',
        'personal_asignado' => 'json',
        'insumos_utilizados' => 'json',
        'notificacion_cosecha' => 'boolean',
        'activo' => 'boolean'
    ];

    // Estados disponibles para la producción
    const ESTADOS = [
        'planificado' => 'Planificado',
        'siembra' => 'Siembra',
        'crecimiento' => 'Crecimiento',
        'maduracion' => 'Maduración',
        'cosecha' => 'Cosecha',
        'secado' => 'Secado',
        'completado' => 'Completado'
    ];

    // Relaciones
   public function lote()
{
    return $this->belongsTo(Lote::class, 'lote_id');
}


    public function trabajadores(): BelongsToMany
    {
        return $this->belongsToMany(Trabajador::class, 'produccion_trabajador')
            ->withPivot(['fecha_asignacion', 'rol', 'horas_trabajadas'])
            ->withTimestamps();
    }

   public function calcularProgreso()
{
    if (!$this->fecha_inicio || !$this->fecha_programada_cosecha) {
        return 0;
    }

    $inicio = Carbon::parse($this->fecha_inicio);
    $fin = Carbon::parse($this->fecha_programada_cosecha);
    $hoy = Carbon::now();

    if ($hoy->lt($inicio)) return 0;
    if ($hoy->gt($fin)) return 100;

    $totalDias = $inicio->diffInDays($fin);
    $diasTranscurridos = $inicio->diffInDays($hoy);

    return round(($diasTranscurridos / max($totalDias, 1)) * 100);
}

    public function insumos(): BelongsToMany
    {
        return $this->belongsToMany(Inventario::class, 'produccion_insumo')
            ->withPivot(['cantidad_utilizada', 'fecha_uso', 'costo_unitario'])
            ->withTimestamps();
    }

    public function salidaInventarios(): HasMany
    {
        return $this->hasMany(SalidaInventario::class);
    }

    // Métodos de cálculo
    public function calcularDesviacion()
    {
        if ($this->estimacion_produccion > 0 && $this->cantidad_cosechada > 0) {
            $desviacion = (($this->cantidad_cosechada - $this->estimacion_produccion) / $this->estimacion_produccion) * 100;
            $this->desviacion_estimacion = round($desviacion, 2);
            return $this->desviacion_estimacion;
        }
        return 0;
    }

    public function porcentajeRendimiento()
    {
        if ($this->estimacion_produccion > 0 && $this->cantidad_cosechada > 0) {
            return ($this->cantidad_cosechada / $this->estimacion_produccion) * 100;
        }
        return 0;
    }

    public function costoTotalInsumos()
    {
        return $this->insumos->sum(function($insumo) {
            return $insumo->pivot->cantidad_utilizada * $insumo->pivot->costo_unitario;
        });
    }

    public function costoTotalTrabajadores()
    {
        return $this->trabajadores->sum(function($trabajador) {
            $horasTrabajadas = $trabajador->pivot->horas_trabajadas ?? 0;
            return $horasTrabajadas * ($trabajador->tarifa_hora ?? 0);
        });
    }

    public function costoTotalProduccion()
    {
        return $this->costoTotalInsumos() + $this->costoTotalTrabajadores();
    }

    public function rentabilidad()
    {
        if ($this->cantidad_cosechada > 0) {
            $precioVenta = $this->cantidad_cosechada * ($this->precio_venta_kg ?? 0);
            $costoTotal = $this->costoTotalProduccion();
            return $precioVenta - $costoTotal;
        }
        return 0;
    }

    public function margenRentabilidad()
    {
        $rentabilidad = $this->rentabilidad();
        $costoTotal = $this->costoTotalProduccion();
        
        if ($costoTotal > 0) {
            return ($rentabilidad / $costoTotal) * 100;
        }
        return 0;
    }

    // Verificaciones de estado
    public function proximoCosecha()
    {
        if ($this->fecha_programada_cosecha) {
            $diasRestantes = now()->diffInDays($this->fecha_programada_cosecha, false);
            return $diasRestantes <= 7 && $diasRestantes >= 0;
        }
        return false;
    }

    public function estaAtrasado()
    {
        if ($this->fecha_programada_cosecha && $this->estado != 'completado') {
            return now()->isAfter($this->fecha_programada_cosecha);
        }
        return false;
    }

    public function diasAtraso()
    {
        if ($this->estaAtrasado()) {
            return now()->diffInDays($this->fecha_programada_cosecha);
        }
        return 0;
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeProximosCosecha($query)
    {
        return $query->where('fecha_programada_cosecha', '>=', now())
                    ->where('fecha_programada_cosecha', '<=', now()->addDays(7))
                    ->where('estado', '!=', 'completado');
    }

    public function scopeAtrasados($query)
    {
        return $query->where('fecha_programada_cosecha', '<', now())
                    ->where('estado', '!=', 'completado');
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopeEnProceso($query)
    {
        return $query->whereIn('estado', ['siembra', 'crecimiento', 'maduracion', 'cosecha', 'secado']);
    }

    public function scopePorTipoCacao($query, $tipo)
    {
        return $query->where('tipo_cacao', $tipo);
    }

    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin]);
    }

    // Accessors
    public function getEstadoColorAttribute()
    {
        $colores = [
            'planificado' => 'secondary',
            'siembra' => 'info',
            'crecimiento' => 'primary',
            'maduracion' => 'warning',
            'cosecha' => 'success',
            'secado' => 'dark',
            'completado' => 'success'
        ];
        return $colores[$this->estado] ?? 'secondary';
    }

    public function getEstadoTextoAttribute()
    {
        return self::ESTADOS[$this->estado] ?? 'Desconocido';
    }

    public function getRendimientoClasificacionAttribute()
    {
        $rendimiento = $this->porcentajeRendimiento();
        if ($rendimiento >= 90) return 'Excelente';
        if ($rendimiento >= 80) return 'Bueno';
        if ($rendimiento >= 70) return 'Regular';
        return 'Deficiente';
    }

    public function getDiasTranscurridosAttribute()
    {
        return $this->fecha_inicio->diffInDays(now());
    }

    public function getDiasRestantesCosechaAttribute()
    {
        if ($this->fecha_programada_cosecha) {
            return now()->diffInDays($this->fecha_programada_cosecha, false);
        }
        return null;
    }

    // Mutators
    public function setTipoCacaoAttribute($value)
    {
        $this->attributes['tipo_cacao'] = ucfirst(strtolower($value));
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = $value ? trim($value) : null;
    }




    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produccion) {
            $produccion->fecha_cambio_estado = now();
        });

        static::updating(function ($produccion) {
            if ($produccion->isDirty('estado')) {
                $produccion->fecha_cambio_estado = now();
            }
        });
    }
}