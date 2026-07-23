<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{
    /**
     * Mostrar la vista.
     */
    public function index()
    {
        return view('clientes');
    }

    /**
     * Consulta para DataTables.
     */
    public function consulta(Request $request)
    {
        $query = DB::table('clientes as c')
            ->join('usuarios as u', 'c.id_usuario', '=', 'u.id')
            ->select(
                'c.id_cliente',
                'u.usuario as nombre_cliente',
                'c.correo',
                'c.telefono',
                'c.direccion',
                'c.id_usuario',
                'c.fecha_registro',
                'c.activo',
                'c.observaciones'
            );

        // Mostrar activos o eliminados
        if ($request->filled('eliminados')) {
            $query->where('c.activo', $request->eliminados == 1 ? 0 : 1);
        } else {
            $query->where('c.activo', 1);
        }

        // Filtros
        if ($request->filled('nombre')) {
            $query->where('u.usuario', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('correo')) {
            $query->where('c.correo', 'like', '%' . $request->correo . '%');
        }

        if ($request->filled('telefono')) {
            $query->where('c.telefono', 'like', '%' . $request->telefono . '%');
        }

        return response()->json(
            $query
                ->orderBy('c.id_cliente', 'desc')
                ->get()
        );
    }

    /**
     * Actualizar cliente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
        ]);

        DB::table('clientes')
            ->where('id_cliente', $id)
            ->update([
                'telefono'       => $request->telefono,
                'direccion'      => $request->direccion,
                'activo'         => $request->has('activo') ? 1 : 0,
                'observaciones'  => $request->observaciones
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado correctamente.'
        ]);
    }

    /**
     * Desactivar (eliminado lógico).
     */
    public function desactivar($id)
    {
        DB::table('clientes')
            ->where('id_cliente', $id)
            ->update([
                'activo' => 0
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente desactivado.'
        ]);
    }

    /**
     * Restaurar cliente.
     */
    public function restaurar($id)
    {
        DB::table('clientes')
            ->where('id_cliente', $id)
            ->update([
                'activo' => 1
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente restaurado.'
        ]);
    }
}