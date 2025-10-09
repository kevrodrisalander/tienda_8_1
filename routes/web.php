<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CartController;


use Yajra\DataTables\Facades\DataTables;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/inventario', function () {
    return view('inventario');
});

Route::get('/ropa', function () {
    return view('categorias.ropa');
});


//Ruta para consulta productos
Route::post('/inventario', [InventarioController::class, 'consultaInventario'])->name('productos.consulta');

Route::get('/ropa', [ProductoController::class, 'ropa'])->name('ropa');


Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');


