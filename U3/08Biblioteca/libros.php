<?php
require_once 'controlador.php';

if (basename($_SERVER['PHP_SELF']) == 'menu.php') {
    header('location:prestamos.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros</title>
    <link rel="shortcut icon" href="img/biblioteca.png">
    <link href="css/bootstrap.css" rel="stylesheet"/>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/bootstrap.rtl.css" rel="stylesheet"/>
    <link href="css/bootstrap.rtl.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-grid.css" rel="stylesheet"/>
    <link href="css/bootstrap-grid.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-grid.rtl.css" rel="stylesheet"/>
    <link href="css/bootstrap-grid.rtl.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-reboot.css" rel="stylesheet"/>
    <link href="css/bootstrap-reboot.rtl.css" rel="stylesheet"/>
    <link href="css/bootstrap-reboot.css" rel="stylesheet"/>
    <link href="css/bootstrap-reboot.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-utilities.css" rel="stylesheet"/>
    <link href="css/bootstrap-utilities.rtl.css" rel="stylesheet"/>
    <link href="css/bootstrap-utilities.css" rel="stylesheet"/>
    <link href="css/bootstrap-utilities.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-utilities.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-utilities.rtl.min.css" rel="stylesheet"/>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'prestamos.php')?'active':''?>" href="prestamos.php">Préstamos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'libros.php')?'active':''?>" href="libros.php">Libros</a>
                    </li>
                    <?php
                    if ($_SESSION['usuario']->getTipo() == 'A') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'socios.php')?'active':''?>" href="socios.php">Socios</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <form action="" method="post" class="d-flex">
                    <span class="navbar-text"><?php echo $_SESSION['usuario']->getId(); ?></span>
                    <button class="btn btn-outline-secondary" type="submit" name="cerrar">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <br />
        <div>
            <?php
            if (isset($mensaje)) {
                echo '<div class="alert alert-success" role="alert">' . $mensaje . '</div>';
            }
            if (isset($error)) {
                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
            ?>
        </div>
        <div>
            <?php
            if ($_SESSION['usuario']->getTipo() == 'A') {
            ?>
                <form action="" method="post" class="row g-3">
                    <div class="col-md-4">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" id="titulo" required>
                    </div>
                    <div class="col-md-4">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" name="autor" id="autor" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ejemplares" class="form-label">Ejemplares</label>
                        <input type="number" class="form-control" name="ejemplares" id="ejemplares" required>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary" type="submit" name="crearLibro">Crear Libro</button>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
        <div>
            <br />
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Ejemplares</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $libros = $bd->obtenerLibros();
                    foreach ($libros as $libro) {
                        echo '<tr>';
                        echo '<td>' . $libro->getId() . '</td>';
                        echo '<td>' . $libro->getTitulo() . '</td>';
                        echo '<td>' . $libro->getAutor() . '</td>';
                        echo '<td>' . $libro->getEjemplares() . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-outline-secondary" type="button" name="modificar" value="' . $libro->getId() . '">Modificar</button>';
                        echo ' <button class="btn btn-outline-danger" type="button" name="borrar" value="' . $libro->getId() . '">Borrar</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
