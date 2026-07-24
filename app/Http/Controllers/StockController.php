<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Lote; // Solo si tienes este modelo
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;

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

        // Filtro base: Activos / Eliminados
        if ($request->get('eliminados') == 1) {
            $query->where('stock.activo', 0);
        } else {
            $query->where('stock.activo', 1);
        }

        /**************************************************
         * APLICACIÓN DE FILTROS AVANZADOS DINÁMICOS
         **************************************************/

        // 1. Texto (Búsquedas parciales con LIKE)
        $query->when($request->filled('filter_nombre'), function ($q) use ($request) {
            return $q->where('productos.descripcion', 'LIKE', '%' . $request->filter_nombre . '%');
        });

        $query->when($request->filled('filter_ubicacion'), function ($q) use ($request) {
            return $q->where('stock.ubicacion', 'LIKE', '%' . $request->filter_ubicacion . '%');
        });

        $query->when($request->filled('filter_lote'), function ($q) use ($request) {
            return $q->where('lotes_producto.codigo_lote', 'LIKE', '%' . $request->filter_lote . '%');
        });

        $query->when($request->filled('filter_observaciones'), function ($q) use ($request) {
            return $q->where('stock.observaciones', 'LIKE', '%' . $request->filter_observaciones . '%');
        });

        $query->when($request->filled('filter_estado'), function ($q) use ($request) {
             return $q->whereRaw('LOWER(stock.estado) = ?', [strtolower($request->filter_estado)]);
        });

        $query->when($request->filled('filter_tipo_movimiento'), function ($q) use ($request) {
        return $q->whereRaw('LOWER(stock.tipo_movimiento) = ?', [strtolower($request->filter_tipo_movimiento)]);
        });

        // 3. Rangos de Cantidades y Límites numéricos
        $query->when($request->filled('filter_cantidad_min'), function ($q) use ($request) {
            return $q->where('stock.cantidad', '>=', $request->filter_cantidad_min);
        });

        $query->when($request->filled('filter_cantidad_max'), function ($q) use ($request) {
            return $q->where('stock.cantidad', '<=', $request->filter_cantidad_max);
        });

        $query->when($request->filled('filter_minimo'), function ($q) use ($request) {
            return $q->where('stock.minimo_seguro', '>=', $request->filter_minimo);
        });

        $query->when($request->filled('filter_maximo'), function ($q) use ($request) {
            return $q->where('stock.maximo_permitido', '<=', $request->filter_maximo);
        });

        // 4. Rangos de Fechas (Ingreso y Vencimiento)
        $query->when($request->filled('filter_fecha_ingreso_desde'), function ($q) use ($request) {
            return $q->whereDate('stock.fecha_ingreso', '>=', $request->filter_fecha_ingreso_desde);
        });

        $query->when($request->filled('filter_fecha_ingreso_hasta'), function ($q) use ($request) {
            return $q->whereDate('stock.fecha_ingreso', '<=', $request->filter_fecha_ingreso_hasta);
        });

        $query->when($request->filled('filter_fecha_vencimiento_desde'), function ($q) use ($request) {
            return $q->whereDate('stock.fecha_vencimiento', '>=', $request->filter_fecha_vencimiento_desde);
        });

        $query->when($request->filled('filter_fecha_vencimiento_hasta'), function ($q) use ($request) {
            return $q->whereDate('stock.fecha_vencimiento', '<=', $request->filter_fecha_vencimiento_hasta);
        });

        /**************************************************/

        // Ejecución de la consulta con las columnas requeridas
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
            'stock.fecha_salida',
        ])
        ->orderBy('stock.id', 'desc') //Se agrega el orderBy aquí
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

    public function store(Request $request)
    { {
            $validated = $request->validate([
                'nombre_producto'    => 'required|string|max:255',
                'id_categoria'       => 'required|exists:cat_categorias,id',
                'id_marca'           => 'required|exists:cat_marcas,id',
                'cantidad_inicial'   => 'required|integer|min:0',
                'precio_venta'       => 'required|numeric|min:0',
                'cantidad_minima'    => 'required|integer|min:0',
                'cantidad_maxima'    => 'required|integer|min:0',
                'estado'             => 'required|string',
                'nuevo_lote'         => 'required|string|max:50',
                'tipo_movimiento'    => 'required|string|in:entrada,salida,ajuste,traslado',
                'fecha_ingreso'      => 'required|date',
                'fecha_vencimiento'  => 'nullable|date|after_or_equal:fecha_ingreso',
                'observaciones'      => 'nullable|string|max:255',
                'ubicacion'          => 'required|string|max:255',
                'imagen'             => 'nullable|image|max:2048',

            ]);

            // Crear nuevo lote
            $idLote = DB::table('lotes_producto')->insertGetId([
                'codigo_lote'   => $validated['nuevo_lote'],
                'fecha_ingreso' => $validated['fecha_ingreso'],
                'cantidad'      => $validated['cantidad_inicial'],
            ], 'id_lote');

            // Subir imagen si existe (sin redimensionar)
            $imagePath = null;
            if ($request->hasFile('imagen')) {
                $imagePath = $request->file('imagen')->store('productos', 'public');
            }
            // Guardar producto
            $producto = Producto::create([
                'descripcion'  => $validated['nombre_producto'],
                // 'descripcion_larga'  => $validated['descripcion_larga'] ?? null, // <-- aquí
                'stock'        => $validated['cantidad_inicial'],
                'precio_venta' => $validated['precio_venta'],
                'id_status'    => 1,
                'id_categoria' => $validated['id_categoria'],
                'id_marca'     => $validated['id_marca'],
                'fecha'        => $validated['fecha_ingreso'],
                'name_file'    => $imagePath,
            ]);

            // Guardar stock
            DB::table('stock')->insert([
                'producto_id'       => $producto->id,
                'cantidad'          => $validated['cantidad_inicial'],
                'minimo_seguro'     => $validated['cantidad_minima'],
                'maximo_permitido'  => $validated['cantidad_maxima'],
                'estado'            => $validated['estado'],
                'id_lote'           => $idLote,
                'ubicacion'         => $validated['ubicacion'],
                'tipo_movimiento'   => $validated['tipo_movimiento'],
                'fecha_ingreso'     => $validated['fecha_ingreso'],
                'fecha_vencimiento' => $validated['fecha_vencimiento'],
                'observaciones'     => $validated['observaciones'],

            ]);

            return redirect()->back()->with('success', 'Producto y stock registrados correctamente.');
        }
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
        // Obtener registro de stock
        $stock = DB::table('stock')->where('id', $id)->first();

        if ($stock && $stock->activo) {
            // Descontar la cantidad del stock actual del producto
            DB::table('productos')
                ->where('id', $stock->producto_id)
                ->decrement('stock_actual', $stock->cantidad);

            // Marcar como inactivo y actualizar fecha de salida
            DB::table('stock')
                ->where('id', $id)
                ->update([
                    'activo' => 0,
                    'fecha_salida' => now(),
                    'updated_at' => now(),
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registro eliminado correctamente'
        ]);
    }


    //Recuperar registro pasa a status 1
    public function restaurar($id)
    {
        // Obtener registro de stock
        $stock = DB::table('stock')->where('id', $id)->first();

        if ($stock && !$stock->activo) {
            // Sumar la cantidad al stock actual del producto
            DB::table('productos')
                ->where('id', $stock->producto_id)
                ->increment('stock_actual', $stock->cantidad);

            // Marcar como activo y limpiar fecha de salida
            DB::table('stock')
                ->where('id', $id)
                ->update([
                    'activo' => 1,
                    'fecha_salida' => null,
                    'updated_at' => now(),
                ]);
        }

        return response()->json(['ok' => true]);
    }

public function exportarExcel(Request $request)
{
    dd($request->all()); //Verifica qué parámetros llegan aquí
    return Excel::download(new StockExport($request->all()), 'reporte_stock.xlsx');
}

}
