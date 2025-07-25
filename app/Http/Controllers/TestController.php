<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'El servidor Laravel está funcionando correctamente',
            'timestamp' => now()
        ]);
    }
}
