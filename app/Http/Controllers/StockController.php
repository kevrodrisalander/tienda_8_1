<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Exports\StockExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    /**
     * Consulta el inventario y aplica los filtros del reporte.
     */
    public function consultaStock(Request $request)
    {
        $query = DB::table('stock')
            ->join(
                'productos',
                'stock.producto_id',
                '=',
                'productos.id'
            )
            ->leftJoin(
                'lotes_producto',
                'stock.id_lote',
                '=',
                'lotes_producto.id_lote'
            );

        /*
        |--------------------------------------------------------------------------
        | Registros activos o eliminados
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('eliminados')) {
            $query->where('stock.activo', 0);
        } else {
            $query->where('stock.activo', 1);
        }

        /*
        |--------------------------------------------------------------------------
        | Filtro por nombre del producto
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_nombre'),
            function ($q) use ($request) {
                $nombre = trim($request->input('filter_nombre'));

                return $q->where(
                    'productos.descripcion',
                    'ILIKE',
                    '%' . $nombre . '%'
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtro por ubicación
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_ubicacion'),
            function ($q) use ($request) {
                $ubicacion = trim($request->input('filter_ubicacion'));

                return $q->where(
                    'stock.ubicacion',
                    'ILIKE',
                    '%' . $ubicacion . '%'
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtro por lote
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_lote'),
            function ($q) use ($request) {
                $lote = trim($request->input('filter_lote'));

                return $q->where(
                    'lotes_producto.codigo_lote',
                    'ILIKE',
                    '%' . $lote . '%'
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtro por observaciones
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_observaciones'),
            function ($q) use ($request) {
                $observaciones = trim(
                    $request->input('filter_observaciones')
                );

                return $q->where(
                    'stock.observaciones',
                    'ILIKE',
                    '%' . $observaciones . '%'
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtro por estado
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_estado'),
            function ($q) use ($request) {
                $estado = strtolower(
                    trim($request->input('filter_estado'))
                );

                return $q->whereRaw(
                    'LOWER(TRIM(stock.estado)) = ?',
                    [$estado]
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtro por tipo de movimiento
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_tipo_movimiento'),
            function ($q) use ($request) {
                $tipoMovimiento = strtolower(
                    trim($request->input('filter_tipo_movimiento'))
                );

                return $q->whereRaw(
                    'LOWER(TRIM(stock.tipo_movimiento)) = ?',
                    [$tipoMovimiento]
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtros por cantidad
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_cantidad_min'),
            function ($q) use ($request) {
                return $q->where(
                    'stock.cantidad',
                    '>=',
                    $request->input('filter_cantidad_min')
                );
            }
        );

        $query->when(
            $request->filled('filter_cantidad_max'),
            function ($q) use ($request) {
                return $q->where(
                    'stock.cantidad',
                    '<=',
                    $request->input('filter_cantidad_max')
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtros por mínimos y máximos
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_minimo'),
            function ($q) use ($request) {
                return $q->where(
                    'stock.minimo_seguro',
                    '>=',
                    $request->input('filter_minimo')
                );
            }
        );

        $query->when(
            $request->filled('filter_maximo'),
            function ($q) use ($request) {
                return $q->where(
                    'stock.maximo_permitido',
                    '<=',
                    $request->input('filter_maximo')
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtros por fecha de ingreso
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_fecha_ingreso_desde'),
            function ($q) use ($request) {
                return $q->whereDate(
                    'stock.fecha_ingreso',
                    '>=',
                    $request->input('filter_fecha_ingreso_desde')
                );
            }
        );

        $query->when(
            $request->filled('filter_fecha_ingreso_hasta'),
            function ($q) use ($request) {
                return $q->whereDate(
                    'stock.fecha_ingreso',
                    '<=',
                    $request->input('filter_fecha_ingreso_hasta')
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Filtros por fecha de vencimiento
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('filter_fecha_vencimiento_desde'),
            function ($q) use ($request) {
                return $q->whereDate(
                    'stock.fecha_vencimiento',
                    '>=',
                    $request->input('filter_fecha_vencimiento_desde')
                );
            }
        );

        $query->when(
            $request->filled('filter_fecha_vencimiento_hasta'),
            function ($q) use ($request) {
                return $q->whereDate(
                    'stock.fecha_vencimiento',
                    '<=',
                    $request->input('filter_fecha_vencimiento_hasta')
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Resultado
        |--------------------------------------------------------------------------
        */

        $stocks = $query
            ->select([
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
            ->orderByDesc('stock.id')
            ->get();

        return response()->json([
            'data' => $stocks,
        ]);
    }

    /**
     * Muestra la vista principal de stock.
     */
    public function catalogos()
    {
        $productos = Producto::all();

        $lotes = DB::table('lotes_producto')
            ->select(
                'id_lote',
                'codigo_lote'
            )
            ->orderBy('codigo_lote')
            ->get();

        $categorias = DB::table('cat_categorias')
            ->select(
                'id',
                'categoria'
            )
            ->orderBy('categoria')
            ->get();

        $marcas = DB::table('cat_marcas')
            ->select(
                'id',
                'nombre'
            )
            ->orderBy('nombre')
            ->get();

        $estados = [
            'disponible',
            'reservado',
            'agotado',
            'transito',
        ];

        $tiposMovimiento = [
            'entrada' => 'Entrada de inventario (+)',
            'salida' => 'Salida por venta o merma (-)',
            'ajuste' => 'Ajuste de inventario',
            'traslado' => 'Transferencia interna',
        ];

        return view(
            'stock',
            compact(
                'productos',
                'lotes',
                'categorias',
                'marcas',
                'estados',
                'tiposMovimiento'
            )
        );
    }

    /**
     * Obtiene un registro de stock.
     */
    public function show($id)
    {
        $stock = DB::table('stock')
            ->join(
                'productos',
                'stock.producto_id',
                '=',
                'productos.id'
            )
            ->select(
                'stock.*',
                'productos.descripcion as nombre_producto'
            )
            ->where('stock.id', $id)
            ->first();

        if (!$stock) {
            return response()->json([
                'message' => 'Registro de stock no encontrado.',
            ], 404);
        }

        return response()->json($stock);
    }

    /**
     * Registra un nuevo producto y su inventario inicial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_producto' => [
                'required',
                'string',
                'max:255',
            ],
            'id_categoria' => [
                'required',
                'exists:cat_categorias,id',
            ],
            'id_marca' => [
                'required',
                'exists:cat_marcas,id',
            ],
            'cantidad_inicial' => [
                'required',
                'integer',
                'min:0',
            ],
            'precio_venta' => [
                'required',
                'numeric',
                'min:0',
            ],
            'cantidad_minima' => [
                'required',
                'integer',
                'min:0',
            ],
            'cantidad_maxima' => [
                'required',
                'integer',
                'min:0',
                'gte:cantidad_minima',
            ],
            'estado' => [
                'required',
                'string',
            ],
            'nuevo_lote' => [
                'required',
                'string',
                'max:50',
            ],
            'tipo_movimiento' => [
                'required',
                'string',
                'in:entrada,salida,ajuste,traslado',
            ],
            'fecha_ingreso' => [
                'required',
                'date',
            ],
            'fecha_vencimiento' => [
                'nullable',
                'date',
                'after_or_equal:fecha_ingreso',
            ],
            'observaciones' => [
                'nullable',
                'string',
                'max:255',
            ],
            'ubicacion' => [
                'required',
                'string',
                'max:255',
            ],
            'imagen' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ]);

        DB::beginTransaction();

        try {
            $idLote = DB::table('lotes_producto')
                ->insertGetId([
                    'codigo_lote' => $validated['nuevo_lote'],
                    'fecha_ingreso' => $validated['fecha_ingreso'],
                    'cantidad' => $validated['cantidad_inicial'],
                ], 'id_lote');

            $imagePath = null;

            if ($request->hasFile('imagen')) {
                $imagePath = $request
                    ->file('imagen')
                    ->store('productos', 'public');
            }

            $producto = Producto::create([
                'descripcion' => $validated['nombre_producto'],
                'stock' => $validated['cantidad_inicial'],
                'precio_venta' => $validated['precio_venta'],
                'id_status' => 1,
                'id_categoria' => $validated['id_categoria'],
                'id_marca' => $validated['id_marca'],
                'fecha' => $validated['fecha_ingreso'],
                'name_file' => $imagePath,
            ]);

            DB::table('stock')->insert([
                'producto_id' => $producto->id,
                'cantidad' => $validated['cantidad_inicial'],
                'minimo_seguro' => $validated['cantidad_minima'],
                'maximo_permitido' => $validated['cantidad_maxima'],
                'estado' => $validated['estado'],
                'id_lote' => $idLote,
                'ubicacion' => $validated['ubicacion'],
                'tipo_movimiento' => $validated['tipo_movimiento'],
                'fecha_ingreso' => $validated['fecha_ingreso'],
                'fecha_vencimiento' =>
                    $validated['fecha_vencimiento'] ?? null,
                'observaciones' =>
                    $validated['observaciones'] ?? null,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Producto y stock registrados correctamente.'
                );
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'No fue posible registrar el producto y el stock.'
                );
        }
    }

    /**
     * Actualiza un registro de stock.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cantidad' => [
                'required',
                'numeric',
            ],
            'ubicacion' => [
                'nullable',
                'string',
                'max:255',
            ],
            'estado' => [
                'required',
                'string',
            ],
            'id_lote' => [
                'nullable',
                'integer',
            ],
            'minimos' => [
                'nullable',
                'numeric',
            ],
            'maximos' => [
                'nullable',
                'numeric',
            ],
            'fecha_ingreso' => [
                'nullable',
                'date',
            ],
            'fecha_vencimiento' => [
                'nullable',
                'date',
                'after_or_equal:fecha_ingreso',
            ],
            'tipo_movimiento' => [
                'required',
                'string',
            ],
            'observaciones' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $actualizado = DB::table('stock')
            ->where('id', $id)
            ->update([
                'cantidad' => $validated['cantidad'],
                'ubicacion' => $validated['ubicacion'] ?? null,
                'estado' => $validated['estado'],
                'id_lote' => $validated['id_lote'] ?? null,
                'minimo_seguro' => $validated['minimos'] ?? null,
                'maximo_permitido' => $validated['maximos'] ?? null,
                'fecha_ingreso' =>
                    $validated['fecha_ingreso'] ?? null,
                'fecha_vencimiento' =>
                    $validated['fecha_vencimiento'] ?? null,
                'tipo_movimiento' => $validated['tipo_movimiento'],
                'observaciones' =>
                    $validated['observaciones'] ?? null,
                'updated_at' => now(),
            ]);

        if (!$actualizado) {
            return redirect()
                ->back()
                ->with(
                    'warning',
                    'No se realizaron cambios en el registro.'
                );
        }

        return redirect()
            ->route('stock')
            ->with(
                'success',
                'Stock actualizado correctamente.'
            );
    }

    /**
     * Desactiva un registro de stock.
     */
    public function destroy($id)
    {
        $stock = DB::table('stock')
            ->where('id', $id)
            ->first();

        if (!$stock) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado.',
            ], 404);
        }

        if (!$stock->activo) {
            return response()->json([
                'success' => false,
                'message' => 'El registro ya está eliminado.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            DB::table('productos')
                ->where('id', $stock->producto_id)
                ->decrement(
                    'stock_actual',
                    $stock->cantidad
                );

            DB::table('stock')
                ->where('id', $id)
                ->update([
                    'activo' => 0,
                    'fecha_salida' => now(),
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registro eliminado correctamente.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'No fue posible eliminar el registro.',
            ], 500);
        }
    }

    /**
     * Restaura un registro de stock.
     */
    public function restaurar($id)
    {
        $stock = DB::table('stock')
            ->where('id', $id)
            ->first();

        if (!$stock) {
            return response()->json([
                'ok' => false,
                'message' => 'Registro no encontrado.',
            ], 404);
        }

        if ($stock->activo) {
            return response()->json([
                'ok' => false,
                'message' => 'El registro ya está activo.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            DB::table('productos')
                ->where('id', $stock->producto_id)
                ->increment(
                    'stock_actual',
                    $stock->cantidad
                );

            DB::table('stock')
                ->where('id', $id)
                ->update([
                    'activo' => 1,
                    'fecha_salida' => null,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'ok' => true,
                'message' => 'Registro restaurado correctamente.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            return response()->json([
                'ok' => false,
                'message' => 'No fue posible restaurar el registro.',
            ], 500);
        }
    }

    /**
     * Exporta el reporte de stock a Excel.
     */
    public function exportarExcel(Request $request)
    {
        $filtros = $request->only([
            'filter_nombre',
            'filter_ubicacion',
            'filter_estado',
            'filter_lote',
            'filter_observaciones',
            'filter_tipo_movimiento',
            'filter_cantidad_min',
            'filter_cantidad_max',
            'filter_minimo',
            'filter_maximo',
            'filter_fecha_ingreso_desde',
            'filter_fecha_ingreso_hasta',
            'filter_fecha_vencimiento_desde',
            'filter_fecha_vencimiento_hasta',
        ]);

        return Excel::download(
            new StockExport($filtros),
            'reporte_stock_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
        );
    }
}
