<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;

use Yajra\DataTables\Facades\DataTables;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/productos', function () {
    return view('productos');
});

Route::get('/ropa', function () {
    return view('categorias.ropa');
});


//Ruta para consulta productos
Route::post('/productos', [ProductosController::class, 'consultaProductos'])->name('productos.consulta');

