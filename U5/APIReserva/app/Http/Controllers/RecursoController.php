<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;

class RecursoController extends Controller
{
    
    public function index()
    {
        $recursos = Recurso::all();
        return response()->json($recursos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:recursos,id',
            'nombre' => 'required|string',
            'tipo' => 'required|string|in:Salas,Ordenadores,Discos Duros,Coche',
        ]);

        $recurso = Recurso::create([
            'id' => $request->id,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
        ]);

        return response()->json($recurso, 201);
    }
}
