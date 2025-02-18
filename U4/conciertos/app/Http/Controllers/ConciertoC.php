<?php

namespace App\Http\Controllers;

use App\Models\Concierto;
use App\Models\Entrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConciertoC extends Controller
{
    public function verConciertos()
    {
        try {
            //code...
            $conciertos = Concierto::orderBy('titulo')->get();
            return view('conciertos', compact('conciertos'));
        } catch (\Throwable $th) {
            return back()->with('mensaje', $th->getMessage());
        }
    }
    public  function borrarConcierto(Request $request, $id)
    {

        try {
            $c = Concierto::find($id);
            if ($c != null) {
                DB::transaction(
                    function () use ($request, $c) {
                        foreach ($c->entradas() as $e) {
                            $e->delete();
                        }
                        $c->delete();
                    }
                );
                return redirect()->route('verConciertos')->with('mensaje', 'Concierto Borrado');
            } else {
                return back()->with('mensaje', 'Error, no existe el concierto');
            }
        } catch (\Throwable $th) {
            return back()->with('mensaje', $th->getMessage());
        }
    }
    public  function crearEntrada(Request $request, $id)
    {
        $request->validate(
            [
                'email' => 'required',
                'numE' => 'required|numeric|between:1,4'
            ]
        );
        try {
            $c = Concierto::find($id);
            if ($c->aforo >= $request->numE) {
                DB::transaction(
                    function () use ($request, $id, $c) {
                        $e = new Entrada();
                        $e->concierto_id = $c->id;
                        $e->fechaVenta = date('Y-m-d');
                        $e->email = $request->email;
                        $e->numEntradas = $request->numE;
                        if ($e->save()) {
                            $c->aforo -= $request->numE;
                            $c->save();
                        }
                    }
                );
                return back()->with('mensaje', 'Venta registrada');
            } else {
                return back()->with('mensaje', 'Error, aforo completo');
            }
        } catch (\Throwable $th) {
            return back()->with('mensaje', $th->getMessage());
        }
    }
    public  function venderEntradas(Request $request)
    {
        try {
            //Obtener el concierto
            $concierto = Concierto::find($request->concierto);
            if ($concierto != null) {
                return view('entradadas', compact('concierto'));
            } else {
                return back()->with('mensaje', 'Error, no existe el concierto');
            }
        } catch (\Throwable $th) {
            return back()->with('mensaje', $th->getMessage());
        }
    }
}
