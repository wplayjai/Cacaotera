<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

class ContabilidadController extends Controller
{
    // Retorna la ganancia total de ventas
    public function ganancia(Request $request)
    {
        $ganancia = Venta::sum('total_venta');
        return response()->json(['ganancia' => $ganancia]);
    }
}
