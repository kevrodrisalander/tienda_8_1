<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    // 🔹 Inventario con filtros y cálculo de Kardex exacto
    public function consultaInventario(Request $request)
    {
        if ($request->ajax()) {

           $query = DB::table('productos as p')
    ->leftJoin('cat_categorias as c', 'p.id_categoria', '=', 'c.id') // <-- Corregido aquí
    ->leftJoin('cat_marcas as m', 'p.id_marca', '=', 'm.id')
    ->select([
        'p.id',
        'p.descripcion',
        'p.precio_venta',
        'p.activo',
        'm.id as id_marca',
        'm.nombre as marca',
        'c.categoria as categoria',
        // Cálculo matemático real del Kardex dinámico
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
        ")
    ]);

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

            if ($request->filled('descripcion')) {
                $query->where('p.descripcion', 'ilike', '%' . $request->descripcion . '%');
            }

            if ($request->filled('stock')) {
                if ($request->stock === 'con') {
                    $query->whereRaw("
                        (
                            SELECT COALESCE(SUM(
                                CASE
                                    WHEN st.tipo_movimiento IN ('entrada','ajuste') THEN st.cantidad
                                    WHEN st.tipo_movimiento = 'salida' THEN -st.cantidad
                                    ELSE 0
                                END
                            ), 0)
                            FROM stock st
                            WHERE st.producto_id = p.id
                              AND st.activo = true
                        ) > 0
                    ");
                }

                if ($request->stock === 'sin') {
                    $query->whereRaw("
                        (
                            SELECT COALESCE(SUM(
                                CASE
                                    WHEN st.tipo_movimiento IN ('entrada','ajuste') THEN st.cantidad
                                    WHEN st.tipo_movimiento = 'salida' THEN -st.cantidad
                                    ELSE 0
                                END
                            ), 0)
                            FROM stock st
                            WHERE st.producto_id = p.id
                              AND st.activo = true
                        ) <= 0
                    ");
                }
            }

            return response()->json([
                'data' => $query->get()
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

    // Muestra todas las observaciones acumuladas de los movimientos activos
    public function observaciones($id)
    {
        $observaciones = DB::table('stock')
            ->where('producto_id', $id)
            ->where('activo', true)
            ->whereNotNull('observaciones')
            ->where('observaciones', '!=', '')
            ->pluck('observaciones');

        return response()->json([
            'observaciones' => $observaciones->isEmpty()
                ? 'Sin observaciones'
                : $observaciones->implode("\n")
        ]);
    }
}
