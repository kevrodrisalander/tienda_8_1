<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = [
    [
        'imagen' => 'images/deportes.jpg',
        'titulo' => 'Deportes',
        'descripcion' => 'Todo lo que necesitas para tu deporte favorito.',
        'slug' => 'hogar'
    ],
    [
        'imagen' => 'images/electronica.jpg',
        'titulo' => 'Electrónica',
        'descripcion' => 'Celulares, laptops, audífonos y más.',
        'slug' => 'electronica'
    ],
    [
        'imagen' => 'images/frutas_verduras.jpg',
        'titulo' => 'Frutas y verduras',
        'descripcion' => 'Frutas y verduras para toda ocación.',
        'slug' => 'hogar'
    ],
    [
        'imagen' => 'images/hogar.jpg',
        'titulo' => 'Hogar',
        'descripcion' => 'Muebles, decoración, cocina y artículos para tu casa.',
        'slug' => 'hogar'
    ],
    [
        'imagen' => 'images/juguetes.jpg',
        'titulo' => 'Juguetes',
        'descripcion' => 'Juega diviertete y aprende.',
        'slug' => 'hogar'
    ],
    [
        'imagen' => 'images/ropa.jpg',
        'titulo' => 'Ropa',
        'descripcion' => 'Moda para toda la familia.',
        'slug' => 'ropa'
    ],
    [
        'imagen' => 'images/tecnologia.jpg',
        'titulo' => 'Tecnologia',
        'descripcion' => 'Buscando siempre aprender.',
        'slug' => 'hogar'
    ]
];

        return view('home', compact('categorias'));
    }
}
