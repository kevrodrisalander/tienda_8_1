<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    // 🔹 Inventario con filtros
    public function consultaInventario(Request $request)
    {
        if ($request->ajax()) {

            $query = DB::table('productos as p')
                ->leftJoin('stock as s', 's.id', '=', 'p.id_detalle_prod')
                ->leftJoin('cat_categorias as c', 'p.id_categoria', '=', 'c.id')
                ->leftJoin('cat_estatus_inventario as e', 'p.id_status', '=', 'e.id')
                ->leftJoin('cat_marcas as m', 'p.id_marca', '=', 'm.id')
                ->select(
                    'p.id',
                    'p.descripcion',
                    DB::raw("
                        COALESCE(
                            (
                                SELECT SUM(
                                    CASE
                                        WHEN st.tipo_movimiento IN ('entrada','ajuste') THEN st.cantidad
                                        WHEN st.tipo_movimiento = 'salida' THEN -st.cantidad
                                        ELSE 0
                                    END
                                )
                                FROM stock st
                                WHERE st.producto_id = p.id
                                  AND st.activo = true
                            ), 0
                        ) AS stock_actual
                    "),
                    's.detalles',
                    'p.precio_venta',
                    'p.activo',
                    'e.tipo as estatus',
                    'm.id as id_marca',
                    'm.nombre as marca',
                    'c.categoria'
                );

            // 🔹 Filtros
            if ($request->filled('marca')) {
                $query->where('p.id_marca', $request->marca);
            }

            if ($request->filled('categoria')) {
                $query->where('p.id_categoria', $request->categoria);
            }

            if ($request->filled('status')) {
                $query->where('p.activo', $request->status);
            }

            if ($request->filled('stock')) {

                if ($request->stock === 'con') {
                    $query->whereRaw("
            COALESCE(
                (
                    SELECT SUM(
                        CASE
                            WHEN st.tipo_movimiento IN ('entrada','ajuste') THEN st.cantidad
                            WHEN st.tipo_movimiento = 'salida' THEN -st.cantidad
                            ELSE 0
                        END
                    )
                    FROM stock st
                    WHERE st.producto_id = p.id
                      AND st.activo = true
                ), 0
            ) > 0
        ");
                }

                if ($request->stock === 'sin') {
                    $query->whereRaw("
            COALESCE(
                (
                    SELECT SUM(
                        CASE
                            WHEN st.tipo_movimiento IN ('entrada','ajuste') THEN st.cantidad
                            WHEN st.tipo_movimiento = 'salida' THEN -st.cantidad
                            ELSE 0
                        END
                    )
                    FROM stock st
                    WHERE st.producto_id = p.id
                      AND st.activo = true
                ), 0
            ) <= 0
        ");
                }
            }


            $data = $query->get()->map(function ($row) {
                if ((int)$row->stock_actual <= 0) {
                    $row->stock_actual = '<span class="badge bg-danger">0</span>';
                } else {
                    $row->stock_actual = '<span class="badge bg-success">' . $row->stock_actual . '</span>';
                }

                if ($row->activo) {
                    $row->estatus = '<span class="badge bg-success">Disponible</span>';
                } else {
                    $row->estatus = '<span class="badge bg-danger">No disponible</span>';
                }

                return $row;
            });

            return response()->json([
                'data' => $data
            ]);
        }

        return view('inventario');
    }

    // 🔹 Marcas
    public function marcas()
    {
        return DB::table('cat_marcas')
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();
    }

    // 🔹 Categorías
    public function categorias()
    {
        return DB::table('cat_categorias')
            ->select('id', 'categoria as nombre')
            ->orderBy('categoria')
            ->get();
    }
}
