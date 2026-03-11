<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{
    public function index()
    {
        return view('clientes');
    }

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
                'c.activo'
            );

        // Filtro de eliminados (activo 0 o 1)
        if ($request->has('eliminados')) {
            $query->where('c.activo', $request->eliminados == 1 ? 0 : 1);
        }

        $clientes = $query->get();

        return response()->json($clientes);
    }
}
