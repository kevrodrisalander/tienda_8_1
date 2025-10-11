<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TiendaController;

//Rutas de Inventario
Route::view('/inventario', 'inventario')->name('inventario.vista');
Route::post('/inventario', [InventarioController::class, 'consultaInventario'])->name('productos.consulta');

//Rutas de Tienda
Route::get('/home', [TiendaController::class, 'home'])->name('home');

//Rutas de Productos por Categoría
Route::get('/categoria/{slug}', [ProductoController::class, 'mostrarCategoria'])->name('categoria.mostrar');

//Rutas de Carrito
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

Route::get('/test-vista/{slug}', function ($slug) {
    return view('mensaje.sin_categoria', ['slug' => $slug]);
});


Route::get('/administracion', function () {
    return view('administracion');
})->name('administracion');


Route::get('/inventario', function () {
    return view('inventario');
})->name('inventario');

Route::get('/stock', function () {
    return view('stock');
})->name('stock');

Route::get('/usuarios', function () {
    return view('usuarios');
})->name('usuarios');

Route::get('/provedores', function () {
    return view('provedores');
})->name('provedores');



