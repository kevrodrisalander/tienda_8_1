<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProvedoresController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentaController;



// Página principal de la tienda
Route::get('/home', [HomeController::class, 'index'])->name('home');  // Ruta para la página principal de la tienda

// Mostrar productos de una categoría por slug
Route::get('/categoria/{slug}', [ProductoController::class, 'mostrarCategoria'])->name('categoria.mostrar');

//Ruta vista sin categoria
Route::get('/test-vista/{slug}', function ($slug) {
    return view('mensaje.sin_categoria', ['slug' => $slug]);
});

// Rutas de administración
Route::view('/administracion', 'administracion')->name('administracion'); // Muestra la vista de administración
Route::view('/usuarios', 'usuarios')->name('usuarios'); // Muestra la vista de usuarios

// Consulta de inventario por POST
Route::post('/inventario', [InventarioController::class, 'consultaInventario'])->name('productos.consulta');
Route::view('/inventario', 'inventario')->name('inventario');

//Ruta de stock
Route::get('/stock', [StockController::class, 'catalogos'])->name('stock'); // Muestra el stock (vista principal)
Route::get('/stock/consulta', [StockController::class, 'consultaStock'])->name('stock.consulta'); //Devuelve los datos en formato JSON para DataTables
Route::post('/stock/guardar', [StockController::class, 'guardar'])->name('stock.guardar');  //Guarda nuevo stock desde un formulario/modal
Route::post('/productos', [ProductoController::class, 'store'])->name('producto.guardar');  //Se guarda registro en productos , cantidad inicial
Route::get('/stock/{id}', [StockController::class, 'show'])->name('stock.show');  //Localizacion del id del producto
Route::put('/stock/{id}', [StockController::class, 'update'])->name('stock.update'); //Edición del producto id
Route::delete('/stock/{id}', [StockController::class, 'destroy'])->name('stock.destroy'); //Se elimina el producto
Route::put('/stock/{id}/restaurar', [StockController::class, 'restaurar'])->name('stock.restaurar'); // Se restaura de nuevo el producto

// Agregar producto al carrito
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); //Agregar producto al carrito
Route::get('/cart/show', [CartController::class, 'show'])->name('cart.show');  //Mostrar el carrito
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); //Procesar la venta
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear'); //Vaciar el carrito
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); //Procesar la venta

//Ruta de provedores
Route::view('/provedores', 'provedores')->name('provedores'); // Muestra los provedores (vista principal)
Route::post('/provedores', [ProvedoresController::class, 'consultaProvedores']); //Consulta de provedores para DataTables

// Mostrar formulario de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // Mostrar formulario de login
Route::post('/login', [LoginController::class, 'login'])->name('login.post'); // Procesar login
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); //
Route::get('/dashboard', function () { return "Bienvenido al dashboard"; })->middleware('auth')->name('dashboard'); // Ruta protegida por middleware de autenticación

// Cierre de sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); //Cerrar sesión

// Registro de usuarios
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register'); // Mostrar formulario de registro
Route::post('/register', [RegisterController::class, 'register'])->name('register.post'); // Procesar registro

//Usuarios
Route::get('usuarios/consulta', [UsuariosController::class, 'consultaUsuarios']); //Consulta de usuarios para DataTables
Route::get('usuarios/{id}', [UsuariosController::class, 'show']); //Mostrar usuario por ID (para edición)
Route::put('usuarios/{id}', [UsuariosController::class, 'update']); //Actualizar usuario por ID
Route::delete('usuarios/{id}', [UsuariosController::class, 'destroy']); //Desactivar usuario por ID
Route::put('usuarios/{id}/restaurar', [UsuariosController::class, 'restaurar']);


//Venta del producto
Route::post('/checkout', [VentaController::class, 'checkout']); //Procesar la venta

