<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\CatSeccion;
use Illuminate\Support\Facades\View;

class ProductoController extends Controller
{
    // Vista específica para la categoría
    public function mostrarCategoria($slug)
{
    // Busca la categoría por slug
    $categoria = CatSeccion::where('slug', $slug)->firstOrFail();

    // Busca los productos que pertenecen a esa categoría usando el nuevo campo 'id'
    $productos = Producto::where('id_categoria', $categoria->id) // ← cambio aquí
                         ->where('id_status', 1)
                         ->orderBy('descripcion', 'asc')
                         ->get();

    // Carga la vista específica si existe
    if (View::exists("categorias.$slug")) {
        return view("categorias.$slug", compact('categoria', 'productos'));
    }
    return response()->view('mensaje.sin_categoria', ['slug' => $slug], 404);
}
}
