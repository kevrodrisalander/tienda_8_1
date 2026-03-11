<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
{
    public function consultaUsuarios(Request $request)
    {
        //1️ Consulta individual por ID
        if ($request->filled('id')) {
            $usuario = DB::table('usuarios as u')
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
                ->where('u.id', $request->id)
                ->first();

            return response()->json($usuario);
        }

        //Lista general con filtros
        $query = DB::table('usuarios as u')
            ->join('cat_roles as r', 'u.id_rol', '=', 'r.id_rol')
            ->select(
                'u.id',
                'u.usuario',
                'u.correo',
                'u.id_rol',
                'u.activo',
                'r.nombre as nombre_rol',
                'r.descripcion as descripcion_rol'
            );

        // 3️ Filtros dinámicos

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('u.id_rol', $request->rol);
        }

        // Filtro por nombre de usuario
        if ($request->filled('usuario')) {
            $query->where('u.usuario', 'like', '%' . $request->usuario . '%');
        }

        // Filtro por correo
        if ($request->filled('correo')) {
            $query->where('u.correo', 'like', '%' . $request->correo . '%');
        }

        // Ver activos / eliminados
        if ($request->has('eliminados')) {
            $query->where('u.activo', $request->eliminados ? 0 : 1);
        }

        // 4️ Ejecutar consulta
        $usuarios = $query->get();

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
            ->where('id', $id)
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
                'updated_at' => now(),
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
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Usuario restaurado'
        ]);
    }

    // Obtener lista de roles para select
    public function getRoles()
    {
        $roles = DB::table('cat_roles')
            ->select('id_rol', 'nombre')
            ->orderBy('nombre')
            ->get();

        return response()->json($roles);
    }
    public function store(Request $request)
    {
        $request->validate([
            'usuario'   => 'required|string|max:255',
            'correo'    => 'required|email|unique:usuarios,correo',
            'id_rol'    => 'required|integer',
            'password'  => 'required|min:6',
            'nombre'    => 'required_if:id_rol,6',
            'direccion' => 'required_if:id_rol,6',
        ]);

        try {
            DB::beginTransaction();

            // 1. Siempre creamos el usuario
            $usuarioId = DB::table('usuarios')->insertGetId([
                'usuario' => $request->usuario,
                'correo'  => $request->correo,
                'id_rol'  => $request->id_rol,
                'clave'   => Hash::make($request->password),
                'activo'  => 1,
                'fecha'   => now(),
            ]);

            // 2. ¿Es rol de Cliente? (ID 6)
            if ($request->id_rol == 6) {
                DB::table('clientes')->insert([
                    'id_usuario'     => $usuarioId,
                    'nombre'         => $request->nombre,
                    'correo'         => $request->correo,
                    'telefono'       => $request->telefono,
                    'direccion'      => $request->direccion,
                    'fecha_registro' => now(),
                ]);
            }

            DB::commit();
            return response()->json(['ok' => true, 'mensaje' => 'Registro procesado']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ok' => false, 'mensaje' => $e->getMessage()], 500);
        }
    }
}
