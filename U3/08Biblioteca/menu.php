<?php
session_start();
if (basename($_SERVER['PHP_SELF']) == 'menu.php') {
    header('location:prestamos.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Menú</title>
</head>
<body>

<div class="container mt-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mi Aplicación</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="prestamos.php">Préstamos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="libros.php">Libros</a>
                </li>
                <?php if ($_SESSION['usuario']->getTipo() == 'A') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="socios.php">Socios</a>
                    </li>
                <?php } ?>
            </ul>
            <form class="form-inline ml-auto" action="" method="post">
                <span class="mr-2"><?php echo $_SESSION['usuario']->getId(); ?></span>
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="cerrar">Salir</button>
            </form>
        </div>
    </nav>
</div>

<script src="js/jquery-3.6.0.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
