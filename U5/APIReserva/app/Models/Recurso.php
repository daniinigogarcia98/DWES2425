<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;


    protected $table = 'recursos';

    protected $fillable = [
        'id',
        'nombre',
        'tipo',
    ];


    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'recurso');
    }
}
