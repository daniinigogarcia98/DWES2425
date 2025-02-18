<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if (session('mensaje'))
    <p style="color:red;">{{session('mensaje')}}</p>
    @endif
    <h2>Selecciona un concierto</h2>
    <form action="{{route('venderEntradas')}}" method="get">
        <select name="concierto" id="concierto">
            @foreach ($conciertos as $c)
            <option value="{{$c->id}}">{{$c->titulo}}</option>
            @endforeach
        </select>
        <button type="submit">Entradas</button>
    </form>
   
    <h2>Listado de Conciertos</h2>
    <table border="1" width="50%">
        <tr>
            <td>Id</td>
            <td>Título</td>
            <td>Fecha</td>
            <td>Aforo</td>
            <td>Precio</td>
        </tr>
        @foreach ($conciertos as $c)
        <tr>
            <td>{{$c->id}}</td>
            <td>{{$c->titulo}}</td>
            <td>{{$c->fecha}}</td>
            <td>{{$c->aforo}}</td>
            <td>{{$c->precioEntrada}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>