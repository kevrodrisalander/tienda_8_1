<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener todas las secciones
        $secciones = Seccion::all();

        // Pasarlas a la vista home
        return view('home', compact('secciones'));
    }
}
