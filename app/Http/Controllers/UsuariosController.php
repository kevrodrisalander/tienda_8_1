<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    /**
     * Consulta el inventario completo con relaciones.
     */
    public function consultaUsuarios()
    {

        $Usuarios = DB::table('usuarios as u')
            ->join('cat_roles as r', 'u.id_rol', '=', 'r.id_rol')
            ->select(
                'u.usuario',
                'u.correo',
                'u.id_rol',
                'r.nombre as nombre_rol',
                'r.descripcion as descripcion_rol'
            )
            ->get();

        return response()->json(['data' => $Usuarios]);
    }
}
