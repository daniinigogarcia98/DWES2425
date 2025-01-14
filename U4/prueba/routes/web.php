<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('holamundo');
});


Route::get('/alumnos', function () {
    return "Bienvenido a la ruta de alumnos";
});

Route::get('/alumnos/{nombre}', function ($nombreA) {
    return 'Bienvenido'.'_'.$nombreA;
});

Route::get('/alumnos/insertar/{nombre}', function ($nombreA) {
    return 'Página para crear alumno'.'_'.$nombreA;
});
