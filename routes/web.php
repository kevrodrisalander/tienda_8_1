<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;

// Ruta principal: carga la vista 'home' con datos desde el controlador
Route::get('/', [HomeController::class, 'index'])->name('home');

// Vista directa de productos
Route::get('/productos', function () {
    return view('productos');
});

// Consulta dinámica de productos
Route::post('/productos', [ProductosController::class, 'consultaProductos'])->name('productos.consulta');

// Ruta para mostrar una categoría específica
Route::get('/categorias/{slug}', [CategoriaController::class, 'show'])->name('categorias.show');
