<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function consultaInventario(Request $request)
    {

  $inventario = DB::table('productos as p')
    ->join('cat_categorias as c', 'p.id_categoria', '=', 'c.id')
    ->join('cat_estatus_inventario as e', 'p.id_status', '=', 'e.id')
    ->join('cat_marcas as m', 'p.id_marca', '=', 'm.id') // ← nuevo JOIN
    // ->join('cat_marcas as m', 'p.marca_id', '=', 'm.id')
    ->select(
        'p.id as IdProducto',
        'p.descripcion as Descripcion',
        'p.stock as Stock',
        'p.precio_venta as PrecioVenta',
        'p.id_categoria',
        'c.categoria as categoria',
        'p.id_status',
        'e.tipo as Estatus',
        'm.id as IdMarca',           // ← nuevo campo
        'm.nombre as MarcaNombre'    // ← nuevo campo
    )
    ->get();

        return response()->json(['data' => $inventario]);
    }
}
