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


//  Route::get('productos', [ProductosController::class, 'productos']);
