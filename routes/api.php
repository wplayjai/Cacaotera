<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\Api\InventarioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ✅ Ruta para obtener producción activa de un lote
Route::get('lotes/{loteId}/produccion-activa', [LotesController::class, 'produccionActiva']);

// ✅ Ruta para obtener inventario
Route::get('inventario', [InventarioController::class, 'index']);

Route::get('/api/lotes/{loteId}/produccion-activa', [ProduccionController::class, 'obtenerProduccionActivaPorLote'])
    ->name('api.lotes.produccion-activa');