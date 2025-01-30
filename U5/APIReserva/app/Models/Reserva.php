<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = ['empleado', 'fechaI', 'fechaF', 'recurso'];

    
    public function recurso()
    {
        return $this->belongsTo(Recurso::class);
    }
}
