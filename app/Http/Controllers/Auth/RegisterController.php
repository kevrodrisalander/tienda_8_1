<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Mostrar formulario
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Registrar usuario
    public function register(Request $request)
    {
        // Validación
        $request->validate([
            'usuario' => 'required|string|max:50',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Crear usuario con rol cliente (id_rol = 6)
        $usuario = Usuario::create([
            'usuario' => $request->usuario,
            'correo' => $request->correo,
            'clave' => Hash::make($request->password),
            'id_rol' => 6
        ]);

        // Loguear automáticamente
        Auth::login($usuario);

        // Redirigir a home
        return redirect('/home')->with('success', 'Usuario registrado correctamente.');
    }
}
