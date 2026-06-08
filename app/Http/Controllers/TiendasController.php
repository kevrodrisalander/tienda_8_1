<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TiendasController extends Controller
{
    public function tiendas()
    {
        return view('tiendas');
    }
}