<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\StockController;


// Página principal de la tienda
Route::get('/home', [TiendaController::class, 'home'])->name('home');

// Consulta de inventario por POST
Route::post('/inventario', [InventarioController::class, 'consultaInventario'])->name('productos.consulta');
Route::view('/inventario', 'inventario')->name('inventario');

//Ruta de stock
Route::get('/stock', [StockController::class, 'catalogos'])->name('stock'); // Muestra el stock (vista principal)
Route::get('/stock/consulta', [StockController::class, 'consultaStock'])->name('stock.consulta'); //Devuelve los datos en formato JSON para DataTables
Route::post('/stock/guardar', [StockController::class, 'guardar'])->name('stock.guardar');  //Guarda nuevo stock desde un formulario/modal
Route::post('/productos', [ProductoController::class, 'store'])->name('producto.guardar');



// Mostrar productos de una categoría por slug
Route::get('/categoria/{slug}', [ProductoController::class, 'mostrarCategoria'])->name('categoria.mostrar');

// Agregar producto al carrito
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');


//Ruta vista sin categoria
Route::get('/test-vista/{slug}', function ($slug) {
    return view('mensaje.sin_categoria', ['slug' => $slug]);
});

// Rutas de administración
Route::view('/administracion', 'administracion')->name('administracion');
Route::view('/usuarios', 'usuarios')->name('usuarios');
Route::view('/provedores', 'provedores')->name('provedores');
