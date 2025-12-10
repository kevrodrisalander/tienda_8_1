<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Consulta el inventario completo con relaciones.
     */
    public function consultaInventario()
    {
        $inventario = DB::table('productos as p')
            ->leftJoin('stock as st', 'p.id', '=', 'st.producto_id')
            ->leftJoin('cat_categorias as c', 'p.id_categoria', '=', 'c.id')
            ->leftJoin('cat_secciones as s', 'p.id_categoria', '=', 's.id')
            ->leftJoin('cat_estatus_inventario as e', 'p.id_status', '=', 'e.id')
            ->leftJoin('cat_marcas as m', 'p.id_marca', '=', 'm.id')
            ->select(
                'p.id as IdProducto',
                'p.descripcion as Descripcion',
                'st.cantidad as Stock',
                'p.precio_venta as PrecioVenta',
                'p.id_categoria',
                'c.categoria as categoria',
                's.id as IdSeccion',
                's.nombre as SeccionNombre',
                's.slug as SeccionSlug',
                'p.id_status',
                'e.tipo as estatus',
                'm.id as id_marca',
                'm.nombre as MarcaNombre'
            )
            ->orderBy('p.descripcion', 'ASC') // <--- ORDENAR POR DESCRIPCIÓN
            ->get();

        return response()->json(['data' => $inventario]);
    }
}
