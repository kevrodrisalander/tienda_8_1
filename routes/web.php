<?php

use Illuminate\Support\Facades\Route;

// Importación de Controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProvedoresController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\TiendasController;
use App\Http\Controllers\EnvioController;

Route::redirect('/', '/home');

// 1. AUTENTICACIÓN (Login, Registro y Sesiones)

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Dashboard básico protegido
Route::get('/dashboard', function () {
    return "Bienvenido al dashboard";
})->middleware('auth')->name('dashboard');

// 2. TIENDA PÚBLICA & FLUJO DE COMPRA (E-commerce)

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/categoria/{slug}', [ProductoController::class, 'mostrarCategoria'])->name('categoria.mostrar');
Route::get('/producto/{id}/observaciones', [InventarioController::class, 'observaciones'])
    ->whereNumber('id')
    ->name('producto.observaciones');
Route::get('/tiendas', [TiendasController::class, 'tiendas'])->name('tiendas.index');

// Carrito de compras (AJAX / Session)
Route::get('/cart/show', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout y Generación de Tickets
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.procesar');
Route::get('/pedido/ticket/{id}', [CheckoutController::class, 'descargarTicket'])->name('pedido.ticket');

//  3. PANEL DE ADMINISTRACIÓN VISTAS GENERALES
Route::view('/administracion', 'administracion')
    ->middleware(['auth', 'role:1,2,9'])
    ->name('administracion');

//  4. MÓDULOS DE GESTIÓN (CRUDs, Inventarios y DataTables)

// --- STOCK & PRODUCTOS ---
Route::middleware(['auth', 'role:1,4,8'])->group(function () {
Route::get('/stock', [StockController::class, 'catalogos'])->name('stock');
Route::get('/stock/consulta', [StockController::class, 'consultaStock'])->name('stock.consulta');

//RUTA AGREGADA (Debe ir ARRIBA de las rutas con {id})
Route::get('/stock/exportar-excel', [StockController::class, 'exportarExcel'])->name('stock.exportarExcel');

Route::post('/stock/guardar', [StockController::class, 'guardar'])->name('stock.guardar');
Route::post('/productos', [ProductoController::class, 'store'])->name('producto.guardar');

//RUTAS CON ID (Al final y protegidas para recibir solo números)
Route::get('/stock/{id}', [StockController::class, 'show'])->name('stock.show')->whereNumber('id');
Route::put('/stock/{id}', [StockController::class, 'update'])->name('stock.update')->whereNumber('id');
Route::delete('/stock/{id}', [StockController::class, 'destroy'])->name('stock.destroy')->whereNumber('id');
Route::put('/stock/{id}/restaurar', [StockController::class, 'restaurar'])->name('stock.restaurar')->whereNumber('id');
});

// INVENTARIO & CATÁLOGOS
Route::middleware(['auth', 'role:1,4'])->group(function () {
Route::get('/inventario', function () { return view('inventario'); })->name('inventario');
Route::post('/inventario', [InventarioController::class, 'consultaInventario'])->name('productos.consulta');
Route::get('/inventario/marcas', [InventarioController::class, 'marcas'])->name('inventario.marcas');
Route::get('/inventario/categorias', [InventarioController::class, 'categorias'])->name('inventario.categorias');
});

// ---ENVÍOS Y DOMICILIOS ---
Route::middleware(['auth', 'role:1,2,3'])->group(function () {
Route::get('/envios', [EnvioController::class, 'index'])->name('envios'); // Única ruta GET para la vista
Route::get('/envios/consulta', [EnvioController::class, 'consulta'])->name('envios.consulta');
Route::post('/envios/info', [EnvioController::class, 'guardarInfo'])->name('envios.info'); // Se queda con el alias que usa tu JS
});

// ---PROVEEDORES ---
Route::middleware(['auth', 'role:1,8'])->group(function () {
Route::get('/provedores', function () { return view('provedores'); })->name('provedores');
Route::post('/provedores', [ProvedoresController::class, 'consultaProvedores'])->name('provedores.consulta');
Route::post('/provedores/store', [ProvedoresController::class, 'store'])->name('provedores.store');
Route::get('/provedores/marcas', [ProvedoresController::class, 'marcas'])->name('provedores.marcas');
Route::get('/provedores/lista', [ProvedoresController::class, 'lista'])->name('provedores.lista');
Route::get('/provedores/{id}', [ProvedoresController::class, 'show'])->where('id', '[0-9]+')->name('provedores.show');
Route::put('/provedores/{id}', [ProvedoresController::class, 'update'])->where('id', '[0-9]+')->name('provedores.update');
Route::delete('/provedores/{id}', [ProvedoresController::class, 'destroy'])->name('provedores.destroy');
Route::put('/provedores/{id}/restaurar', [ProvedoresController::class, 'restaurar'])->name('provedores.restaurar');
});

// ---USUARIOS ---
Route::middleware(['auth', 'role:1,9'])->group(function () {
Route::view('/usuarios', 'usuarios')->name('usuarios'); // Centralizado como vista básica
Route::get('usuarios/consulta', [UsuariosController::class, 'consultaUsuarios'])->name('usuarios.consulta');
Route::post('usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
Route::get('/roles', [UsuariosController::class, 'getRoles'])->name('roles.get');
Route::get('usuarios/{id}', [UsuariosController::class, 'show'])->name('usuarios.show');
Route::put('usuarios/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');
Route::delete('usuarios/{id}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
Route::put('usuarios/{id}/restaurar', [UsuariosController::class, 'restaurar'])->name('usuarios.restaurar');
});

// ---CLIENTES ---
Route::middleware(['auth', 'role:1,3,4'])->group(function () {
Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes');
Route::get('/clientes/consulta', [ClientesController::class, 'consulta'])->name('clientes.consulta');
Route::post('/clientes/update/{id}', [ClientesController::class, 'update']);
Route::post('/clientes/desactivar/{id}', [ClientesController::class, 'desactivar']);
Route::post('/clientes/restaurar/{id}', [ClientesController::class, 'restaurar']);
});

// ---REPORTES ---
Route::middleware(['auth', 'role:1,2,5'])->group(function () {
Route::get('/reportes/reportes', [ReporteController::class, 'index'])->name('reportes');
Route::get('/reportes/lista', [ReporteController::class, 'lista'])->name('reportes.lista');
});

// ---VENTAS ---
Route::get('/venta/{id}/ticket', [VentaController::class, 'ticketPdf'])
    ->middleware('auth')
    ->name('venta.ticket');


// 5. RUTAS DE PRUEBA / TESTING (Mantener abajo o borrar en producción)
if (app()->environment('local')) {
    Route::get('/test-vista/{slug}', function ($slug) {
        return view('mensaje.sin_categoria', ['slug' => $slug]);
    })->name('test.vista');
}
