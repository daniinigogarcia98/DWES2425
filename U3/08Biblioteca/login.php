<?php
require_once 'Modelo.php';
if (isset($_POST['entrar'])) {
    $db=new Modelo();
    if ($db->getConexion() == null) {
      $error='No se pudo conectar a la base de datos';
}
else {
  echo 'Conexión establecida';
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Biblioteca DWES</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
  <div class="container">

<p class="display-2">Biblioteca DWES</p>
<form action="" method="post">
    <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="userHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
    </div>

    <button type="submit" class="btn btn-primary" name="entrar">Entrar</button>
</form>
<?php
if (isset($error)) {
    echo '<div class="text-danger">'.$error.'</div>';
}
?>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>