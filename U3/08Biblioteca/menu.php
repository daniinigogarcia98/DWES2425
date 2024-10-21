<!doctype html>
<html lang="en">
  <head>
    <title>menu</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <nav class="nav justify-content-center">
      <a class="nav-link" href="prestamos.php">Préstamos</a>
      <a class="nav-link" href="libros.php">Libros</a>
      <a class="nav-link" href="socios.php">Socios</a>
    </nav>
    <form action="" method="post">
        <span><?php echo $_SESSION['usuario']->getId(); ?></span>
        <button type="submit" class="btn btn-primary">Salir</button>
    </form>
  </body>
</html>