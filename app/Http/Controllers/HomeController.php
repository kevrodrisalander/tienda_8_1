<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;

class HomeController extends Controller
{
public function index(Request $request)
{
    $secciones = Seccion::query()
        ->when($request->filled('buscar'), function ($query) use ($request) {
            $query->where('nombre', 'LIKE', '%' . $request->buscar . '%');
        })
        ->orderBy('nombre', 'asc') // aquí se ordena de A-Z
        ->get();

    return view('home', compact('secciones'));
}


}