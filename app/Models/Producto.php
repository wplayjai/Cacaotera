<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; 

    protected $fillable = [
        'nombre', 
        'tipo_insumo', 
        'cantidad', 
        'estado'
    ];

   
    protected $attributes = [
        'tipo_insumo' => '', 
        'cantidad' => 0,
        'estado' => 'Óptimo'
    ];


    public function updateStatus()
    {
        
        $this->estado = $this->cantidad > 100 ? 'Óptimo' : 'Bajo';
        $this->save();
    }
}