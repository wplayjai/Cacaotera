<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalidaInventario extends Model
{
    protected $table = 'salida_inventarios';

    protected $fillable = [
        'cantidad',
        'unidad_medida',
        'precio_unitario',
        'estado',
        'fecha_registro',
        'insumo_id',
        'produccion_id',
        'motivo',
        'fecha_salida',
        'responsable',
        'observaciones',
        'lote_id',
    ];

    protected $casts = [
        'fecha_salida' => 'date',
        'cantidad' => 'decimal:3',
        'fecha_registro' => 'date',
    ];

    // Relaciones
    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id'); // Asegúrate que exista 'lote_id' si usas esta relación
    }

    public function insumo()
    {
        return $this->belongsTo(Inventario::class, 'insumo_id');
    }

  public function produccion()
{
    return $this->belongsTo(Produccion::class, 'produccion_id');
}
}
