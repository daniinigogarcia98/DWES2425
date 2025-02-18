<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrada extends Model
{
    //
    function concierto(){
        return $this->BelongsTo(Concierto::class);
    }
}
