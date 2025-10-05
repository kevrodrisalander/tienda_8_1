<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    public function consultaProductos(Request $request)
    {
    $productos = DB::table('productos as p')
    ->join('cat_categorias as c', 'p.id_categoria', '=', 'c.id')
    ->join('cat_estatus_ventas as e', 'p.id_status', '=', 'e.id_estatus')
    ->select(
        'p.id as IdProducto',
        'p.descripcion as Descripcion',
        'p.stock as Stock',
        'p.precio_venta as PrecioVenta',
        'p.id_categoria',
        'c.categoria as categoria',
        'p.id_status',
        'e.nombre_estatus as Estatus'
    )
    ->get();

        return response()->json(['data' => $productos]);
    }
}
