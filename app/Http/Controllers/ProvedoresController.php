<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Proveedor;
use Yajra\DataTables\Facades\DataTables;


class ProvedoresController extends Controller
{
    // Consulta de provedores para DataTables
       public function consultaProvedores(Request $request)
    {
       // 1 Consulta individual por ID (proveedor para editar)
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

       //Lista general con filtros
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

       //Filtros dinamicos

        // Filtro por marca
        if ($request->filled('marca')) {
            $query->where('p.id_cat_marcas', $request->marca);
        }

        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('p.nombre', 'like', '%' . $request->nombre . '%');
        }

        // Nombre del proveedor
        if ($request->filled('nombre_proveedor')) {
            $query->where('p.nombre', 'like', '%' . $request->nombre_proveedor . '%');
        }

        // Filtro por contacto
        if ($request->filled('contacto')) {
            $query->where('p.contacto', 'like', '%' . $request->contacto . '%');
        }

        // Teléfono
        if ($request->filled('telefono')) {
            $query->where('p.telefono', 'like', '%' . $request->telefono . '%');
        }

        // Email
        if ($request->filled('email')) {
            $query->where('p.email', 'like', '%' . $request->email . '%');
        }

        // Ver activos / eliminados
        if ($request->has('eliminados')) {
            $query->where('p.activo', $request->eliminados ? 0 : 1);
        }

      //Ejecutar consulta y obtener resultados
        $proveedores = $query->get();

        return response()->json([
            'data' => $proveedores
        ]);
    }

    // Traer un proveedor por ID
    public function show($id)
    {
        $proveedor = \DB::table('proveedores')->where('id', $id)->first();

        $marca = \DB::table('cat_marcas')->where('id', $proveedor->id_cat_marcas)->first();

        return response()->json([
            'id_proveedor' => $proveedor->id,
            'nombre_proveedor' => $proveedor->nombre,
            'contacto' => $proveedor->contacto,
            'telefono' => $proveedor->telefono,
            'email' => $proveedor->email,
            'direccion' => $proveedor->direccion,
            'id_cat_marcas' => $proveedor->id_cat_marcas,
            'nombre_marca' => $marca->nombre ?? ''
        ]);
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

    public function store(Request $request)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|max:255',
            'id_cat_marcas' => 'required|exists:cat_marcas,id',
            'email' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'contacto' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:500',
        ]);

        DB::table('proveedores')->insert([
            'nombre' => $request->nombre_proveedor,
            'contacto' => $request->contacto,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'id_cat_marcas' => $request->id_cat_marcas,
            'activo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
 // Lista de proveedores con filtros
    public function lista(Request $request)
    {
        $query = \DB::table('proveedores');

        if ($request->eliminados) {
            $query->where('activo', false); // o usar SoftDeletes si lo tienes
        }

        if ($request->marca) {
            $query->where('id_cat_marcas', $request->marca);
        }

        if ($request->nombre) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        $proveedores = $query->get()->map(function ($p) {
            // Obtener nombre de la marca
            $marca = \DB::table('cat_marcas')->where('id', $p->id_cat_marcas)->first();
            return [
                'id_proveedor' => $p->id,                     // para los botones
                'nombre_marca' => $marca->nombre ?? '',       // nombre de la marca
                'nombre_proveedor' => $p->nombre,             // nombre del proveedor
                'contacto' => $p->contacto,
                'telefono' => $p->telefono,
                'email' => $p->email,
                'direccion' => $p->direccion,
                'activo' => $p->activo ?? 1,
            ];
        });

        return response()->json(['data' => $proveedores]);
    }
}
