<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_venta',
        'recoleccion_id',
        'cliente',
        'telefono_cliente',
        'cantidad_vendida',
        'precio_por_kg',
        'total_venta',
        'estado_pago',
        'metodo_pago',
        'fecha_pago',
        'observaciones'
    ];

    protected $casts = [
        'fecha_venta' => 'date',
        'fecha_pago' => 'datetime',
        'cantidad_vendida' => 'decimal:2',
        'precio_por_kg' => 'decimal:2',
        'total_venta' => 'decimal:2'
    ];

    /**
     * Relación con Recoleccion
     */
    public function recoleccion()
    {
        return $this->belongsTo(Recoleccion::class);
    }

    /**
     * Accessor para formatear el estado de pago
     */
    public function getEstadoPagoFormateadoAttribute()
    {
        return ucfirst($this->estado_pago);
    }

    /**
     * Accessor para formatear el método de pago
     */
    public function getMetodoPagoFormateadoAttribute()
    {
        $metodos = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia',
            'cheque' => 'Cheque'
        ];

        return $metodos[$this->metodo_pago] ?? $this->metodo_pago;
    }

    /**
     * Scope para ventas de hoy
     */
    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_venta', Carbon::today());
    }

    /**
     * Scope para ventas pagadas
     */
    public function scopePagadas($query)
    {
        return $query->where('estado_pago', 'pagado');
    }

    /**
     * Scope para ventas pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado_pago', 'pendiente');
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_venta', [$fechaInicio, $fechaFin]);
    }

    /**
     * Scope para buscar por cliente
     */
    public function scopeBuscarCliente($query, $termino)
    {
        return $query->where('cliente', 'LIKE', "%{$termino}%");
    }
}