<?php
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\AdminPeliculaController;
use App\Http\Controllers\WebUsuarioController;
use App\Http\Controllers\CompraBoletoController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', function () {
    return ('Respuesta al metodo post');
});

Route::get('/', [WebUsuarioController::class, 'showHome'])->name('home');

Route::get('/registro', [WebUsuarioController::class, 'showRegistrationForm'])->name('registro');
Route::post('/registro', [WebUsuarioController::class, 'register']);

Route::get('/login', [WebUsuarioController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebUsuarioController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebUsuarioController::class, 'logout'])->name('logout');
    Route::get('/perfil', [WebUsuarioController::class, 'showProfile'])->name('perfil');
    Route::post('/perfil/actualizar', [WebUsuarioController::class, 'updateProfile'])->name('actualizarPerfil');
    Route::get('/perfil/editar', [WebUsuarioController::class, 'editarProfile'])->name('editarPerfil');
    Route::post('/perfil/eliminar', [WebUsuarioController::class, 'deleteAccount'])->name('eliminarCuenta');
});

Route::get('/admin', function () {
    return view('layouts.admin.adminIndex');
})->name('admin');

Route::post('/admin/peliculas', [AdminPeliculaController::class, 'store'])->name('admin.pelicula.store');
Route::get('/admin/peliculas/{id}/show', [AdminPeliculaController::class, 'show'])->name('admin.pelicula.show');
Route::get('/admin/peliculas', [AdminPeliculaController::class, 'index'])->name('admin.pelicula.index');
Route::get('/admin/peliculas/{id}/edit', [AdminPeliculaController::class, 'edit'])->name('admin.pelicula.edit'); 
Route::put('/admin/peliculas/{id}/update', [AdminPeliculaController::class, 'update'])->name('admin.pelicula.update');
Route::delete('/admin/peliculas/{id}/delete', [AdminPeliculaController::class, 'destroy'])->name('admin.pelicula.destroy');

Route::get('/home', [AdminPeliculaController::class, 'indexHome'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/carrito', [CarritoController::class, 'showCart'])->name('carrito.mostrar');
    Route::post('/carrito/agregar/{peliculaId}', [CarritoController::class, 'addToCart'])->name('carrito.agregar');
    Route::delete('/carrito/eliminar/{peliculaId}', [CarritoController::class, 'eliminarDelCarrito'])->name('carrito.eliminar');
    Route::post('/carrito/pagar', [CarritoController::class, 'pagarCarrito'])->name('carrito.pagar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciarCarrito'])->name('carrito.vaciar');

    Route::get('/compras/completadas', [CarritoController::class, 'comprasCompletadas'])->name('compras.completadas');
});
