<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    public function show($slug)
{
    if (view()->exists("categorias.$slug")) {
        return view("categorias.$slug");
    }

    abort(404); // Si no existe la vista, muestra error
}
}
