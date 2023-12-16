<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//rutas de usuario para api y usar en postamn
use App\Http\Controllers\WebUsuarioController;

Route::post('/registro/usuario', [WebUsuarioController::class, 'register']);
Route::post('/login', [WebUsuarioController::class, 'loginAPI']);
// Ruta para eliminar un usuario mediante solicitud DELETE
Route::delete('/delete/user/{id}', [WebUsuarioController::class, 'deleteUser']);




//rutas de la peliculas api y usar en postman
use App\Http\Controllers\PeliculaController;

Route::get('/peliculas', [PeliculaController::class, 'index']);
Route::get('/peliculas/{id}', [PeliculaController::class, 'show']);
Route::post('/peliculas/registro', [PeliculaController::class, 'store']);
Route::put('/peliculas/{id}', [PeliculaController::class, 'update']);
Route::delete('/peliculas/{id}', [PeliculaController::class, 'destroy']);
