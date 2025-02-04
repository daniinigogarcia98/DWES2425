<?php

namespace App\Http\Controllers;

use App\Models\Recursos;
use Illuminate\Http\Request;

class RecursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recursos = Recursos::all();
        return response()->json($recursos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Recursos $recursos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recursos $recursos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recursos $recursos)
    {
        //
    }
}
