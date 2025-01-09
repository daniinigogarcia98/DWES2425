<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\DetalleCita;
use App\Models\Servicio;
use Illuminate\Http\Request;

class CitaC extends Controller
{

        function verCitas(){
            $citas=Cita::orderBy('fecha','DESC')->orderBy('hora')->get();
            return view('citas',compact('citas'));
        }

        function modificarCita(Request $request,$id){
            $cita=Cita::find($id);
            if($cita!=null){
              //Calculamos total
              foreach($cita->detalle() as $d){
                $cita->total+=$d->precio;
              }
              //Guardamos los cambios
              if($cita->save()){
                return back()->with('mensaje','Cita con id Finalizada');
              }
              else{
                return back()->with('mensaje','No se pudo finalizar la cita ');
              }
            }
            else{
                return back()->with('mensaje','No existe la cita');
            }
        }
        function borrarCita(Request $request,$id){
            $cita=Cita::find($id);
            if($cita!=null){
                if(!isset($cita->detalle()[0])){
                    if($cita->delete()){
                        return back()->with('mensaje','Cita con id '.$cita->id.' borrada');
                    }
                    else{
                        return back()->with('mensaje','Error al borrar cita');
                    }
                }
                else{
                    return back()->with('mensaje','Error, no puede borrar una cita con detalles');
                }
            }
            else{
                return back()->with('mensaje','Error, cita no existe');
            }
        }
        function crearCita(Request $request){
            //Validar
            $request->validate([
                "fecha"=>"required",
                "hora"=>"required",
                "cliente"=>"required"
            ])  ;

            $cita = new Cita();
            $cita->fecha=$request->fecha;
            $cita->hora=$request->hora;
            $cita->cliente=$request->cliente;
            if($cita->save()){
                return back()->with('mensaje','Cita con id '.$cita->id.' creada');
            }
            else{
                return back()->with('mensaje','Error, al crear la cita');
            }
        }
        function cargarDetalle($id){
            //Recuperar la cita
            $cita=Cita::find($id);
            $servicios=Servicio::all();
            if($cita!=null){

                return view('detalle',compact('cita','servicios'));
            }
            else{
                return back()->with('mensaje','Error, la cita no existe');
            }

        }
        function insertarDetalle(Request $request,$id){
            $cita=Cita::find($id);
            if($cita!=null){
                $servicio=Servicio::find($request->servicio);
                if($servicio!=null){
                    //Crear el Detalle
                    $d=new DetalleCita();
                    $d->cita_id=$cita->id;
                    $d->servicio_id=$servicio->id;
                    $d->precio=$servicio->precio;
                    if($d->save()){
                        return back()->with('mensaje','Servicio Añadido');
                    }
                    else{
                        return back()->with('mensaje','Error No se ha añadido servicio');
                    }
                }
                else{
                    return back()->with('mensaje','Error, el servicio no existe');
                }
            }
            else{
                return back()->with('mensaje','Error, la cita no existe');
            }

        }

}
