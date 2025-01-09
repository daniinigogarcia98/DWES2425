<?php
require_once 'Modelo.php';
session_start();
if (isset($_SESSION['usuario'])) {
    // Redirigimos si ya estamos logueados
    header('location:prestamos.php');
    exit();
}
if (isset($_POST['entrar'])) {
    $bd = new Modelo();
    if ($bd->getConexion() == null) {
        $error = 'Error, no se puede conectar con la BD';
    } else {
        // Comprobar usuario y ps
        $us = $bd->loguear($_POST['usuario'], $_POST['ps']);
        if ($us != null) {
            // Almacenamos en la sesión
            $_SESSION['usuario'] = $us;
            // Redirigimos
            header('location:prestamos.php');
            exit();
        } else {
            $error = 'Error, datos incorrectos';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Biblioteca</title>
    <link rel="shortcut icon" href="img/biblioteca.png">
  <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Biblioteca<img src="img/biblioteca.png" width="100" height="100"></h1>
        <form action="" method="post" class="card p-4 shadow">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" id="usuario" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="ps" class="form-control" id="password" required />
            </div>
            <button type="submit" class="btn btn-primary w-100" name="entrar">Entrar</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="text-danger text-center mt-3"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</body>

</html>