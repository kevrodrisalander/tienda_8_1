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
    public function consultaStock(Request $request)
    {
        $query = DB::table('stock')
            ->join('productos', 'stock.producto_id', '=', 'productos.id')
            ->leftJoin('lotes_producto', 'stock.id_lote', '=', 'lotes_producto.id_lote');

        if ($request->get('eliminados') == 1) {
            $query->where('stock.activo', 0);
        } else {
            $query->where('stock.activo', 1);
        }

        $stocks = $query->select([
            'stock.id',
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
        ])->get();

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
    public function show($id)
    {
        $stock = DB::table('stock')
            ->join('productos', 'stock.producto_id', '=', 'productos.id')
            ->select(
                'stock.*',
                'productos.descripcion as nombre_producto'
            )
            ->where('stock.id', $id)
            ->first();

        return response()->json($stock);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad'          => 'required|numeric|min:0',
            'ubicacion'         => 'nullable|string|max:255',
            'estado'            => 'required|string',
            'id_lote'           => 'nullable|integer',
            'minimos'           => 'nullable|numeric',
            'maximos'           => 'nullable|numeric',
            'fecha_ingreso'     => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'tipo_movimiento'   => 'required|string',
            'observaciones'     => 'nullable|string',
        ]);

        DB::table('stock')
            ->where('id', $id)
            ->update([
                'cantidad'          => $request->cantidad,
                'ubicacion'         => $request->ubicacion,
                'estado'            => $request->estado,
                'id_lote'           => $request->id_lote,
                'minimo_seguro'     => $request->minimos,
                'maximo_permitido'  => $request->maximos,
                'fecha_ingreso'     => $request->fecha_ingreso,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'tipo_movimiento'   => $request->tipo_movimiento,
                'observaciones'     => $request->observaciones,
                'updated_at'        => now(),
            ]);

        return redirect()
            ->route('stock')
            ->with('success', 'Stock actualizado correctamente');
    }

    //Eliminar registros , pasa a status 0
    public function destroy($id)
    {
        DB::table('stock')
            ->where('id', $id)
            ->update([
                'activo' => 0,
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Registro eliminado correctamente'
        ]);
    }

    //Recuperar registro pasa a status 1
    public function restaurar($id)
{
    DB::table('stock')
        ->where('id', $id)
        ->update(['activo' => 1]);

    return response()->json(['ok' => true]);
}

}
