<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            //Devolver pedidos de usuario logueado
            //return User::find(Auth::user()->id)->pedidos();
            return Pedido::where('user_id',Auth::user()->id)->get();
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validaciones
        $request->validate([
            'producto' => 'required',
            'cantidad' => 'required',
        ]);
        //Crear pedido
        try {
            DB::transaction(function () use ($request) {
                //Obtener Producto y Validar Stock
                $p=Producto::find($request->producto);
                if($p!=null && $p->stock>=$request->cantidad){

                    $pedido=new Pedido();
                    $pedido->producto_id=$p->id;
                    $pedido->cantidad=$request->cantidad;
                    $pedido->precioU=$p->precio;
                    $pedido->user_id=Auth::user()->id;
                    //crear pedido
                    if($pedido->save()){
                        //Actualizar stock del producto
                        $p->stock-=$pedido->cantidad;
                        if ($p->save()){
                            return response()->json('Pedido creado ',200);
                        }

                    }
                }
                else{
                    throw new Exception('Producto no encontrado o sin stock');
                }
            });
            //Devolver pedido creado y su nombre
            return response()->json('Pedido creado ',200);
        } catch (\Throwable $th) {
            return response()->json('Error:'.$th->getMessage(),500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
