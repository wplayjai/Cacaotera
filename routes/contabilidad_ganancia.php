<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContabilidadController;

Route::get('/contabilidad/ganancia', [ContabilidadController::class, 'ganancia'])->name('contabilidad.ganancia');
