<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cita Peluqueria</title>
</head>
<body>
    <form action="{{ route('crearC') }}" method="post">
        @csrf
        <label for="fecha">Fecha</label>
        <input type="date" name="fecha" value="{{ date('Y-m-d') }}"></br>
        @error('fecha')
            <p style="color: red;">Rellena Fecha</p>
        @enderror
        <label for="hora">Hora</label>
        <input type="time" name="hora" value="{{ date('H:i') }}"></br>
        @error('hora')
        <p style="color: red;">Rellena Hora</p>
    @enderror
        <label for="cliente">Cliente</label>
        <input type="text" name="cliente" placeholder="Cliente"></br>
        @error('cliente')
            <p style="color: red;">Rellena Cliente</p>
    @enderror
        <button type="submit" name="crearC">Crear Cita</button>
    </form>
    @if (session('mensaje'))
    <h3 style="color: red;">{{session('mensaje')}}</h3>
    @endif
    <style>
        table, th, td {
            border: 2px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;

        }
        table ,th{
            background-color: #80daf0;
            color: white;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }
        form{
            display: flex;
            background-color: lightgray;
            color: white;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }
        label{
            border: 2px solid black;
        }
        input{
            background-color: lightgreen;
            color: white;
            text-align: center;
            vertical-align: middle;
        }
        button{
            background-color: lightblue;
            color: white;
            text-align: center;
            vertical-align: middle;
        }
    </style>
<table border="1px solid black" width="50%">
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Cliente</th>
        <th>Total</th>
    </tr>
    @foreach($citas as $c)
    <tr>
        <td>{{$c->id}}</td>
        <td>{{$c->fecha}}</td>
        <td>{{$c->hora}}</td>
        <td>{{$c->cliente}}</td>
        <td>{{$c->total}}</td>
        <td>
            <form action="{{route('cargarDetalle',$c->id)}}" method="get">
                @csrf
                <button type="submit" name="detalleC">Detalle</button>
            <form>
            <form action="{{route('borrarC',$c->id)}}"  method="post">
                @csrf
                @method('DELETE')
                <button type="submit" name="borrarC">Borrar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
</body>
</html>
