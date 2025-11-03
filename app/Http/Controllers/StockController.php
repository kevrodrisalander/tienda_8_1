<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Lote; // Solo si tienes este modelo

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Consulta el inventario con nombre de producto y campos clave.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultaStock()
    {
        $stocks = DB::table('stock')
            ->join('productos', 'stock.producto_id', '=', 'productos.id')
            ->leftJoin('lotes_producto', 'stock.id_lote', '=', 'lotes_producto.id_lote')
            ->leftJoin('usuarios', 'stock.usuario_id', '=', 'usuarios.id')
            ->select([
                'stock.id as id', // Necesario para el botón Editar
                'productos.descripcion as nombre_producto',
                'stock.cantidad',
                'stock.ubicacion',
                'stock.estado',
                'stock.minimo_seguro',
                'stock.maximo_permitido',
                'stock.fecha_ingreso',
                'stock.fecha_vencimiento',
                'lotes_producto.codigo_lote as lote',
                'stock.observaciones',
                'stock.activo',
                'stock.tipo_movimiento',
                // 'usuarios.nombre as usuario_nombre',
            ])
            ->get();

        return response()->json(['data' => $stocks]);
    }

    public function catalogos()
    {
        $productos = Producto::all();

        $lotes = DB::table('lotes_producto')
            ->select('id_lote', 'codigo_lote')
            ->get();

        $categorias = DB::table('cat_categorias')
            ->select('id', 'categoria')
            // ->where('estatus', 1)
            ->orderBy('categoria')
            ->get();

        $marcas = DB::table('cat_marcas')
            ->select('id', 'nombre')
            // ->where('estatus', 1) // opcional, si manejas estado
            ->orderBy('nombre')
            ->get();

        $estados = ['disponible', 'reservado', 'agotado', 'transito'];
        $tiposMovimiento = ['entrada', 'salida', 'ajuste', 'traslado'];

        return view('stock', compact(
            'productos',
            'lotes',
            'categorias',
            'marcas',
            'estados',
            'tiposMovimiento'
        ));
    }
}
