<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'trabajador_id',
        'lote_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'horas_trabajadas',
        'observaciones'
    ];

    protected $casts = [
        'fecha' => 'date',
        'horas_trabajadas' => 'decimal:2',
    ];

    // Relaciones
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    // Eventos del modelo
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($asistencia) {
            $asistencia->calcularHorasTrabajadas();
        });
    }

    // Método para calcular horas trabajadas automáticamente
    public function calcularHorasTrabajadas()
    {
        if ($this->hora_entrada && $this->hora_salida) {
            try {
                // Si ya vienen en formato H:i, los usamos directamente
                if (is_string($this->hora_entrada) && preg_match('/^\d{2}:\d{2}$/', $this->hora_entrada)) {
                    $entrada = Carbon::createFromFormat('H:i', $this->hora_entrada);
                } else {
                    $entrada = Carbon::parse($this->hora_entrada);
                }
                
                if (is_string($this->hora_salida) && preg_match('/^\d{2}:\d{2}$/', $this->hora_salida)) {
                    $salida = Carbon::createFromFormat('H:i', $this->hora_salida);
                } else {
                    $salida = Carbon::parse($this->hora_salida);
                }
                
                // Si la hora de salida es menor que la de entrada, asumimos que pasó a otro día
                if ($salida->lessThan($entrada)) {
                    $salida->addDay();
                }
                
                $this->horas_trabajadas = $salida->diffInMinutes($entrada) / 60;
            } catch (\Exception $e) {
                // Si hay error en el parsing, dejamos las horas en null
                $this->horas_trabajadas = null;
            }
        }
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->whereNotNull('fecha');
    }

    public function scopePorLote($query, $loteId)
    {
        return $query->where('lote_id', $loteId);
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin = null)
    {
        if ($fechaFin) {
            return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        return $query->whereDate('fecha', $fechaInicio);
    }

    // Accessor para formatear horas trabajadas
    public function getHorasTrabajadasFormateadaAttribute()
    {
        if (!$this->horas_trabajadas) {
            return '0.0h';
        }
        
        $horas = floor($this->horas_trabajadas);
        $minutos = ($this->horas_trabajadas - $horas) * 60;
        
        if ($minutos > 0) {
            return $horas . 'h ' . round($minutos) . 'm';
        }
        
        return $horas . 'h';
    }
}