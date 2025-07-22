<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produccion;

class LoteController extends Controller
{
    // Retorna la producción activa para un lote dado
    public function produccionActiva($loteId)
    {
        $produccion = Produccion::where('lote_id', $loteId)
            ->where('estado', '!=', 'completado')
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'produccion_id' => $produccion?->id
        ]);
    }
}
