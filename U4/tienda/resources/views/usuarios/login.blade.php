<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Agregar enlace al CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="text-center mb-4 col-md-6">
                <img src="{{asset('img/logo.png')}}" alt="logo">
                <h2 class="text-center my-4">Login</h2>
                <form action="{{route('loguear')}}" method="post">
                    <!-- Token CSRF si usas Laravel -->
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" />
                        @error('email')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="ps" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="ps" id="ps"/>
                        @error('ps')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                @if(session('mensaje'))
                <div class="alert alert-danger mt-3">
                    {{session('mensaje')}}
                </div>
            @endif
                <div class="text-center mt-3">
                    <a href="{{route('vistaRegistro')}}">¿No tienes cuenta? Registrate aquí</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar el script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
