<?php
use App\Http\Controllers\RecursosController;
use App\Http\Controllers\ReservasController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('recursos', [RecursosController::class, 'index'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('reservas', [ReservasController::class, 'index'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('reservas', [ReservasController::class, 'store'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('recursos', [ReservasController::class, 'getRecursos'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('reservas', [ReservasController::class, 'getReservas'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('reservas', [ReservasController::class, 'createReserva'])->withoutMiddleware([VerifyCsrfToken::class]);
