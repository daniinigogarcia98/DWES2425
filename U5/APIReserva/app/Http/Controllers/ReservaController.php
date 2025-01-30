<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Recurso;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
  
    public function index()
    {

        $reservas = Reserva::with('recurso')->get();
        return response()->json($reservas);
    }


    public function store(Request $request)
    {

        $request->validate([
            'empleado' => 'required|string',
            'recurso' => 'required|exists:recursos,id',
            'fechaI' => 'required|date|after:now',
            'fechaF' => 'required|date|after:fechaI',
        ]);


        $conflicto = Reserva::where('recurso', $request->recurso)
                            ->where(function($query) use ($request) {

                                $query->whereBetween('fechaI', [$request->fechaI, $request->fechaF])
                                      ->orWhereBetween('fechaF', [$request->fechaI, $request->fechaF]);
                            })
                            ->exists();

        if ($conflicto) {
            return response()->json(['error' => 'El recurso ya está reservado en este rango de fechas.'], 400);
        }

        // Crear la nueva reserva
        $reserva = Reserva::create([
            'empleado' => $request->empleado,
            'recurso' => $request->recurso,
            'fechaI' => $request->fechaI,
            'fechaF' => $request->fechaF,
        ]);

        return response()->json($reserva, 201);
    }
}
