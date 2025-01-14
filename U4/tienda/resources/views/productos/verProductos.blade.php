@extends('plantilla')

@if (session('mensaje'))
    @section('info')
        <div class="alert alert-info" role="alert">
            {{session('mensaje')}}
        </div>
    @endsection
@endif
@if (session('error'))
    @section('error')
        <div class="alert alert-danger" role="alert">
            {{session('error')}}
        </div>
    @endsection
@endif
@section('main')
<table class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Imagen</th>
            <th>Acciones</th> <!-- Nueva columna para el botón -->
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $p)
        <tr>
            <td>{{$p->id}}</td>
            <td>{{$p->nombre}}</td>
            <td>{{$p->precio}}</td>
            <td>{{$p->stock}}</td>
            <td><img src="{{asset('img/productos/'.$p->imagen)}}" alt="{{$p->id}}" width="90px"></td>
            <td>
                <!-- Formulario para añadir el producto al carrito -->
                <form action="{{route('addCarrito')}}" method="post">

                    @csrf
                  <button type="submit" value="{{$p->id}}" name="btnAdd"><img src="img/cesta.png" alt="cesta" width="50px"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
