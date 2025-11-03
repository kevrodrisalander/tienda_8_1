<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvedoresController extends Controller
{
    /**
     * Consulta el inventario completo con relaciones.
     */
    public function consultaProvedores()
    {
$Provedores = DB::table('cat_marcas as m')
    ->join('proveedores as p', 'm.provedor_id', '=', 'p.id')
    ->select(
        'm.id as id_marca',
        'm.nombre as nombre_marca',
        'p.id as id_proveedor',
        'p.nombre as nombre_proveedor',
        'p.contacto',
        'p.telefono',
        'p.email',
        'p.direccion',
        'p.fecha_registro',
        'p.id_cat_marcas',
        // 'p.id_cat_provedores'
    )
    ->orderBy('m.nombre') // ← Aquí se ordena por nombre_marca


    ->get();

        return response()->json(['data' => $Provedores]);
    }
}
