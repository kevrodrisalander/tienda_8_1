<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvedoresController extends Controller
{
    // Consulta de provedores para DataTables
    public function consultaProvedores(Request $request)
    {
        // Si viene un ID, devolver solo ese proveedor (para editar)
        if ($request->filled('id')) {
            $proveedor = DB::table('proveedores')
                ->select(
                    'id as id_proveedor',
                    'nombre as nombre_proveedor',
                    'contacto',
                    'telefono',
                    'email',
                    'direccion',
                    'id_cat_marcas'
                )
                ->where('id', $request->id)
                ->first();

            return response()->json($proveedor);
        }

        // Caso normal: devolver todos los proveedores (DataTable)
        $query = DB::table('proveedores as p')
            ->leftJoin('cat_marcas as m', 'p.id_cat_marcas', '=', 'm.id')
            ->select(
                'p.id as id_proveedor',
                'p.nombre as nombre_proveedor',
                'p.contacto',
                'p.telefono',
                'p.email',
                'p.direccion',
                'p.activo',
                'p.id_cat_marcas',
                'm.nombre as nombre_marca'
            );

        // Filtros
        if ($request->filled('marca')) {
            $query->where('p.id_cat_marcas', $request->marca);
        }
        if ($request->filled('nombre')) {
            $query->where('p.nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->has('eliminados')) {
            $query->where('p.activo', $request->eliminados ? 0 : 1);
        }

        $provedores = $query->get();

        return response()->json(['data' => $provedores]);
    }



    // Traer un proveedor por ID
    public function show($id)
    {
        $proveedor = DB::table('proveedores')
            ->select(
                'id as id_proveedor',
                'nombre as nombre_proveedor',  // Cambiado aquí
                'contacto',
                'telefono',
                'email',
                'direccion',
                'id_cat_marcas'
            )
            ->where('id', $id)
            ->first();

        return response()->json($proveedor);
    }


    // Traer todas las marcas
    public function marcas()
    {
        $marcas = DB::table('cat_marcas')
            ->select('id', 'nombre')
            ->get();

        return response()->json($marcas);
    }

    // Actualizar proveedor
    public function update(Request $request, $id)
    {
        DB::table('proveedores')->where('id', $id)->update([
            'nombre' => $request->nombre_proveedor,
            'contacto' => $request->contacto,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'id_cat_marcas' => $request->id_cat_marcas
        ]);

        return response()->json(['success' => true]);
    }

    // Eliminar proveedor
    public function destroy($id)
    {
        // Marcar como eliminado (activo = 0)
        DB::table('proveedores')->where('id', $id)->update(['activo' => 0]);

        return response()->json(['success' => true]);
    }

    // Restaurar proveedor
    public function restaurar($id)
    {
        // Restaurar proveedor (activo = 1)
        DB::table('proveedores')->where('id', $id)->update(['activo' => 1]);

        return response()->json(['success' => true]);
    }
}
