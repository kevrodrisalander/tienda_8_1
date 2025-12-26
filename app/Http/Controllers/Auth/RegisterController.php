<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'usuario'  => 'required|string|max:50',
            'correo'   => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::transaction(function () use ($request) {

            // Usuario
            $usuario = Usuario::create([
                'usuario' => $request->usuario,
                'correo'  => $request->correo,
                'clave'   => Hash::make($request->password),
                'id_rol'  => 6, // cliente
            ]);

            //Cliente (YA RELACIONADO)
            Cliente::create([
                'nombre'     => $request->usuario,
                'correo'     => $request->correo,
                'id_usuario' => $usuario->id,
            ]);

            //Login automático
            Auth::login($usuario);
        });

        return redirect('/home')
            ->with('success', 'Cliente registrado correctamente.');
    }
}
