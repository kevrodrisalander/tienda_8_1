<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoController extends Controller
{
    // public function ropa()
    // {
    //     // Aquí filtramos por categoría 1 (ajústalo si es otro id)
    //     $productos = Producto::where('id_categoria', 2)
    //                          ->where('id_status', 1) // solo activos
    //                          ->get();

    //     return view('categorias.ropa', compact('productos'));
    // }

    public function ropa()
{
    $productos = Producto::where('id_categoria', 2)   // categoría Ropa
                         ->where('id_status', 1)       // solo activos
                         ->orderBy('descripcion', 'asc')  // ordenar A → Z
                         ->get();

    return view('categorias.ropa', compact('productos'));
}

}
