<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    //Consulta de usuarios para DataTables
    public function consultaUsuarios(Request $request)
    {
        $usuarios = DB::table('usuarios as u')
            ->join('cat_roles as r', 'u.id_rol', '=', 'r.id_rol')
            ->select(
                'u.id',
                'u.usuario',
                'u.correo',
                'u.id_rol',
                'u.activo',
                'r.nombre as nombre_rol',
                'r.descripcion as descripcion_rol'
            )
            ->when(!$request->eliminados, function ($q) {
                $q->where('u.activo', 1);
            })
            ->when($request->eliminados, function ($q) {
                $q->where('u.activo', 0);
            })
            ->get();

        return response()->json([
            'data' => $usuarios
        ]);
    }

    //Mostrar usuario por ID (para edición)
    public function show($id)
    {
        $usuario = DB::table('usuarios')
            ->where('id', $id)
            ->first();

        return response()->json($usuario);
    }

    //Actualizar usuario por ID
    public function update(Request $request, $id)
    {
        $request->validate([
            'usuario' => 'required|string|max:255',
            'correo'  => 'required|email|max:255',
            'id_rol'  => 'required|integer',
        ]);

        DB::table('usuarios')
            ->where('id_usuario', $id)
            ->update([
                'usuario'    => $request->usuario,
                'correo'     => $request->correo,
                'id_rol'     => $request->id_rol,
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Usuario actualizado correctamente'
        ]);
    }

    //Desactivar usuario por ID
    public function destroy($id)
    {
        DB::table('usuarios')
            ->where('id', $id)
            ->update([
                'activo'     => 0,
                'updated_at'=> now(),
            ]);

        return response()->json([
            'message' => 'Usuario desactivado'
        ]);
    }

    //Restaurar usuario por ID
    public function restaurar($id)
    {
        DB::table('usuarios')
            ->where('id', $id)
            ->update([
                'activo'     => 1,
                'updated_at'=> now(),
            ]);

        return response()->json([
            'message' => 'Usuario restaurado'
        ]);
    }
}



