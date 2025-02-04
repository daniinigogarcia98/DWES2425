<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservasResource;
use App\Models\Recursos;
use App\Models\Reservas;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reservas::with('recurso')->get();
        return response()->json($reservas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $esCorecto = $request->validate([
            'empleado' => 'required|string|max:100',
            'fechaI' => 'required|date',
            'fechaF' => 'required|date',
            'recurso_id' => 'required|exists:recursos,id',
        ]);
        $esCorecto = Reservas::where('recurso_id', $esCorecto['recurso_id'])
        ->where(function($datos) use ($esCorecto) {
            $datos->whereBetween('fechaI', [$esCorecto['fechaI'], $esCorecto['fechaF']])
                  ->orWhereBetween('fechaF', [$esCorecto['fechaI'], $esCorecto['fechaF']]);
        })->exists();
        if ($esCorecto) {
            return response()->json(['message' => 'Error: El recurso ya está reservado en este período'], 400);
        }
        $reserva = Reservas::create($esCorecto);

        return response()->json($reserva, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservas $reservas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservas $reservas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservas $reservas)
    {
        //
    }

    public function getRecursos()
    {
        $recursos = Recursos::all();
        return response()->json($recursos);
    }


    public function getReservas()
    {
        $reservas = Reservas::with('recurso')->get();
        return ReservasResource::collection($reservas);
    }

   
    public function createReserva(Request $request)
    {
        $validated = $request->validate([
            'empleado' => 'required|string|max:100',
            'fechaI' => 'required|date',
            'fechaF' => 'required|date|after:fechaI',
            'recurso_id' => 'required|exists:recursos,id',
        ]);


        $exists = Reservas::where('recurso_id', $validated['recurso_id'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('fechaI', [$validated['fechaI'], $validated['fechaF']])
                    ->orWhereBetween('fechaF', [$validated['fechaI'], $validated['fechaF']]);
            })
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'El recurso ya está reservado en este período.'], 400);
        }


        $reserva = Reservas::create([
            'empleado' => $validated['empleado'],
            'fechaI' => $validated['fechaI'],
            'fechaF' => $validated['fechaF'],
            'recurso_id' => $validated['recurso_id'],
        ]);

        return new ReservasResource($reserva);
    }
}
