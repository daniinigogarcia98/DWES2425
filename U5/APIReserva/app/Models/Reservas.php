<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $fillable = ['empleado', 'fechaI', 'fechaF', 'recurso_id'];

    public function recurso()
    {
        return $this->belongsTo(Recursos::class, 'recurso_id');
    }
}
