<?php

// app/Http/Controllers/TiendaController.php
namespace App\Http\Controllers;

use App\Models\CatSeccion;

class TiendaController extends Controller
{
    public function home()
    {
        $secciones = CatSeccion::all();
        return view('home', compact('secciones'));
    }

}
