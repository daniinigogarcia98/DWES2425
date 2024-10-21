<?php
if (basename($_SERVER['PHP_SELF']) == 'menu.php') {
    header('location:prestamos.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<nav class="nav justify-content-center">
  <a class="nav-link " href="prestamos.php">Préstamos</a>
  <a class="nav-link" href="libros.php">Libros</a>
<?php
if ($_SESSION['usuario']->getTipo() == 'A') {
?>
   <a class="nav-link" href="socios.php">Socios</a>
<?php
}
?>
</nav>
<form action="" method="post">
    <span><?php echo $_SESSION['usuario']->getId(); ?></span>
    <button type="submit" class="btn btn-primary" name="cerrar">Salir</button>
</form>
</body>
</html>
