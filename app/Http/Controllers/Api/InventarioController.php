<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Inventario::select([
                'id',
                'nombre',
                'tipo',
                'cantidad',
                'unidad_medida',
                'precio_unitario',
                'estado',
                'fecha_registro'
            ]);

            // Filtrar por tipo si se especifica (acepta singular/plural y mayúsculas/minúsculas)
            if ($request->has('tipo') && $request->tipo) {
                $tipo = strtolower($request->tipo);
                $tiposValidos = [];
                if ($tipo === 'fertilizante' || $tipo === 'fertilizantes') {
                    $tiposValidos = ['fertilizante', 'Fertilizante', 'fertilizantes', 'Fertilizantes'];
                } else if ($tipo === 'pesticida' || $tipo === 'pesticidas') {
                    $tiposValidos = ['pesticida', 'Pesticida', 'pesticidas', 'Pesticidas'];
                } else {
                    $tiposValidos = [$request->tipo];
                }
                $query->whereIn('tipo', $tiposValidos);
            }

            $inventario = $query->take(10)->get();

            return response()->json([
                'success' => true,
                'data' => $inventario,
                'count' => $inventario->count(),
                'tipo' => $request->tipo ?? 'Todos'
            ]);
        } catch (\Exception $e) {
            Log::error('Error en InventarioController: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al cargar el inventario',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
