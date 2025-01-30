<?php
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Ruta para obtener todos los recursos
Route::get('recursos', [RecursoController::class, 'index']);


// Ruta para obtener todas las reservas
Route::get('/reservas', [ReservaController::class, 'index']);


// Ruta para crear una nueva reserva
Route::post('reservas', [ReservaController::class, 'store']);



