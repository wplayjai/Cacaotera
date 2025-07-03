<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalidaInventario extends Model
{
    protected $table = 'salida_inventarios';
    protected $fillable = [
        'lote_nombre',
        'tipo_cacao',
        'tipo',
        'cantidad',
        'unidad_medida',
        'precio_unitario',
        'estado',
        'fecha_registro',
        'insumo_id',
    ];

    public function lote()
{
    return $this->belongsTo(Lote::class, 'lote_id'); // o el nombre correcto de la clave foránea
}
public function insumo()
{
    return $this->belongsTo(Inventario::class, 'insumo_id');
}

   
}
