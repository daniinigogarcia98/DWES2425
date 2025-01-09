<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DetalleCita</title>
</head>
<body>
    @if (session('mensaje'))
    <p style="color: red">{{session('mensaje')}}</p>
    @endif
<h3>Fecha:{{$cita->fecha}}Hora:{{$cita->hora}}Cliente:{{$cita->cliente}}</h3>
<h3><a href="{{route('verCitas')}}">Volver</a></h3>
<form action="{{route('crearD',$cita->id)}}" method="post">
    @csrf
<h2>Secciona Servicio</h2>
<select name="servicio" id="servicio">
    @foreach($servicios as $s)
    <option value="{{$s->id}}">{{$s->descripcion}}</option>
    @endforeach
</select>
<button type="submit">Añadir</button>
</form>
<h3>Servicios Cita</h3>
@if($cita->total!=0)

<form action="{{route('modificarC',$cita->id)}}" method="post">
    @method('PUT')
    @csrf

    <button type="submit">Finalizar Cita</button>
</form>
@endif
<table border="1px solid black" width="50%">
    <tr>
        <td>Id</td>
        <td>Descripcion</td>
        <td>Importe</td>
    </tr>
    @foreach($cita->detalle() as $d)

    <tr>
        <td>{{$d->id}}</td>
        <td>{{$d->servicio->descripcion}}</td>
        <td>{{$d->precio}}</td>
    </tr>
    @endforeach
</table>
</body>
</html>
