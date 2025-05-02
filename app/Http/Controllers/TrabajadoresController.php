<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trabajador;
use Illuminate\Support\Facades\Hash;

class TrabajadoresController extends Controller
{
    public function index()
{
    $trabajadores = Trabajador::with('user')->get(); // Esto asume que tienes una relación definida
    return view('trabajadores.index', compact('trabajadores'));
}

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'identificacion',
            'password' => 'required|min:6',
            // Otros campos...
        ]);
    
        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'identificacion' => $request->identificacion,
            'password' => Hash::make($request->password),
            'rol' => 'trabajador' // si manejas roles
        ]);
    
        // Crear datos del trabajador
        Trabajador::create([
            'user_id' => $user->id,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'fecha_contratacion' => $request->fecha_contratacion,
            'tipo_contrato' => $request->tipo_contrato,
            'forma_pago' => $request->forma_pago,
        ]);
    
        return redirect()->back()->with('success', 'Trabajador registrado correctamente');
    }
}
