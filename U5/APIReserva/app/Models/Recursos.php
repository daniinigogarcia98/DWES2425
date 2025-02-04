<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recursos extends Model
{
    use HasFactory;

    protected $table = 'recursos';
    

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'nombre',
        'tipo',
    ];

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'recurso_id');
    }
}
