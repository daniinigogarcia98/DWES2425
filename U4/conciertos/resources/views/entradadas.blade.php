<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{route('borrarC',$concierto->id)}}" method="post">
        @method('DELETE')
        @csrf
        <h2>Concierto:{{$concierto->titulo}}<button type="submit">Borrar</button></h2>
        <h2>Aforo:{{$concierto->aforo}}</h2>
        <h2>Precio Entrada:{{$concierto->precioEntrada}}</h2>
        <h3><a href="{{route('verConciertos')}}">Inicio</a></h3>
    </form>
    
    @if (session('mensaje'))
        <p style="color:red;">{{session('mensaje')}}</p>
    @endif
    <form action="{{route('crearE',$concierto->id)}}" method="post">
        @csrf
        <label for="email">Email</label>
        <input type="email" name="email" value="{{old('email')}}" placeholder="example@example.com"/>
        @error('email')
            <p style="color:red;">Rellena Email</p>
        @enderror
        <label for="numE">Nº de Entradas</label>
        <input type="number" name="numE" value="1"/>
        @error('numE')
        <p style="color:red;">Rellena Nº de entradas. Mínimo 1 y Máximo 4</p>
        @enderror
        <button type="submit" name="crearC">Registrar Venta</button>
    </form>
    <h1>Entradas Vendidas</h1>
    <table border="1" width="50%">
        <tr>
            <td>Id</td>
            <td>Fecha Venta</td>
            <td>Email</td>
            <td>Nº Entradas</td>
        </tr>
        @foreach ($concierto->entradas() as $e)
        <tr>
            <td>{{$e->id}}</td>
            <td>{{$e->fechaVenta}}</td>
            <td>{{$e->email}}</td>
            <td>{{$e->numEntradas}}</td>
            
        </tr>
        @endforeach
    </table>
</body>
</html>