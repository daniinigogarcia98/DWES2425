<?php

use App\Http\Controllers\ConciertoC;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('verConciertos');
});
Route::controller(ConciertoC::class)->group(
    function(){
        Route::get('conciertos','verConciertos')->name('verConciertos');
        Route::get('entradas','venderEntradas')->name('venderEntradas');
        Route::delete('concierto/{id}','borrarConcierto')->name('borrarC');
        Route::post('entradas/{id}','crearEntrada')->name('crearE');
        
    }
);

