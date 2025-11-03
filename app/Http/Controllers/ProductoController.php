<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\CatSeccion;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class ProductoController extends Controller
{
    // Vista específica para la categoría
    public function mostrarCategoria($slug)
    {
        $categoria = CatSeccion::where('slug', $slug)->firstOrFail();

        $productos = Producto::where('id_categoria', $categoria->id)
            ->where('id_status', 1)
            ->orderBy('descripcion', 'asc')
            ->get();

        if (View::exists("categorias.$slug")) {
            return view("categorias.$slug", compact('categoria', 'productos'));
        }

        return response()->view('mensaje.sin_categoria', ['slug' => $slug], 404);
    }

    // Guardar producto
    public function store(Request $request)
{
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
