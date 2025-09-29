<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function buscador()
    {
        return view('buscador'); // o lo que necesites retornar
    }
}


 public function buscador()
    {
        $usuario = auth()->user()->load('rol'); // chequeo de rol

        $investigadores = DB::table('investigadores')->orderBy('nombre_investigador')->get();
        $cat_investigacion = DB::table('cat_investigacion')->orderBy('linea_investigacion')->get();
        $cat_institucion = DB::table('cat_institucion')->orderBy('nombre_institucion')->get();
        $cat_grado_escolar = DB::table('cat_grado_escolar')->orderBy('tipo_grado')->get();
        $cat_localidad = DB::table('cat_localidad')->select('id_cat_localidad', 'nombre')->get();



        return view('buscador', compact(
            'usuario',
            'investigadores',
            'cat_investigacion',
            'cat_institucion',
            'cat_grado_escolar',
            'cat_localidad'
        ));
    }
