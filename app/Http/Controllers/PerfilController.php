<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    // Mostrar la vista de perfil
    public function show()
    {
        return view('perfil');
    }

    // Cambiar la contraseña
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password_nueva' => 'required|min:6|confirmed', // <- requiere el campo password_nueva_confirmation
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_actual, $user->password)) {
            return back()->with('error', 'La contraseña actual no es correcta.');
        }

        $user->password = Hash::make($request->password_nueva);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    // Actualizar datos de usuario
    public function actualizarDatos(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('update_success', 'Datos actualizados correctamente.');
    }
}
