<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    //
    function detalle(){
        return $this->hasMany(DetalleCita::class)->get();
    }
}
