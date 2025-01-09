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
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/bootstrap.rtl.css" rel="stylesheet" />
    <link href="css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link href="css/bootstrap-grid.css" rel="stylesheet" />
    <link href="css/bootstrap-grid.min.css" rel="stylesheet" />
    <link href="css/bootstrap-grid.rtl.css" rel="stylesheet" />
    <link href="css/bootstrap-grid.rtl.min.css" rel="stylesheet" />
    <link href="css/bootstrap-reboot.css" rel="stylesheet" />
    <link href="css/bootstrap-reboot.rtl.css" rel="stylesheet" />
    <link href="css/bootstrap-reboot.css" rel="stylesheet" />
    <link href="css/bootstrap-reboot.min.css" rel="stylesheet" />
    <link href="css/bootstrap-utilities.css" rel="stylesheet" />
    <link href="css/bootstrap-utilities.rtl.css" rel="stylesheet" />
    <link href="css/bootstrap-utilities.css" rel="stylesheet" />
    <link href="css/bootstrap-utilities.min.css" rel="stylesheet" />
    <link href="css/bootstrap-utilities.min.css" rel="stylesheet" />
    <link href="css/bootstrap-utilities.rtl.min.css" rel="stylesheet" />
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <?php require_once 'menu.php'; ?>

    <div class="container">

        <br />

        <div>

            <!-- ÁREA DE ERRORES -->

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

            // Formulario para crear o modificar libros

            if ($_SESSION['usuario']->getTipo() == 'A') {

                if (isset($libroModificar)) {

                    ?>

                    <form action="" method="post" class="row g-3">

                        <input type="hidden" name="idLibro" value="<?php echo $libroModificar->getId(); ?>" />

                        <div class="col-md-3">

                            <label for="titulo" class="form-label">Título</label>

                            <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $libroModificar->getTitulo(); ?>" />

                        </div>

                        <div class="col-md-3">

                            <label for="autor" class="form-label">Autor</label>

                            <input type="text" class="form-control" name="autor" id="autor" value="<?php echo $libroModificar->getAutor(); ?>" />

                        </div>

                        <div class="col-md-3">

                            <label for="ejemplares" class="form-label">Ejemplares</label>

                            <input class="form-control" name="ejemplares" id="ejemplares" value="<?php echo $libroModificar->getEjemplares(); ?>" type="number" />

                        </div>

                        <div class="col-md-3">

                            <label class="form-label">Acción</label><br />

                            <button class="btn btn-outline-secondary" type="submit" name="lActualizar">Actualizar</button>

                        </div>

                    </form>

                    <?php

                } else {

                    ?>

                    <form action="" method="post" class="row g-3">

                        <div class="col-md-3">

                            <label for="titulo" class="form-label">Título</label>

                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título" />

                        </div>

                        <div class="col-md-3">

                            <label for="autor" class="form-label">Autor</label>

                            <input type="text" class="form-control" name="autor" id="autor" placeholder="Autor" />

                        </div>

                        <div class="col-md-3">

                            <label for="ejemplares" class="form-label">Ejemplares</label>

                            <input class="form-control" name="ejemplares" id="ejemplares" value="1" type="number" />

                        </div>

                        <div class="col-md-3">

                            <label class="form-label">Acción</label><br />

                            <button class="btn btn-outline-secondary" type="submit" id="lCrear" name="lCrear">+</button>

                        </div>

                    </form>

                    <?php

                }

            }

            ?>

        </div>

        <div>

            <br />

            <!-- Mostrar libros -->

            <form action="" method="post">

                <table class="table">

                    <thead>

                        <tr>

                            <th>Id</th>

                            <th>Título</th>

                            <th>Autor</th>

                            <th>Ejemplares</th>

                            <?php if ($_SESSION['usuario']->getTipo() == 'A') { ?>

                                <th>Acciones</th>

                            <?php } ?>
                            </tr>

                    </thead>

                    <tbody>

                        <?php

                        $libros = $bd->obtenerLibros();

                        foreach ($libros as $l) {

                            echo '<tr>';

                            echo '<td>' . $l->getId() . '</td>';

                            echo '<td>' . $l->getTitulo() . '</td>';

                            echo '<td>' . $l->getAutor() . '</td>';

                            echo '<td>' . $l->getEjemplares() . '</td>';

                            if ($_SESSION['usuario']->getTipo() == 'A') {

                                echo '<td>';

                                echo '<button class="btn btn-outline-secondary" type="submit" name="lModificar" 

                                    value="' . $l->getId() . '">Modificar</button>';

                                echo '<button class="btn btn-outline-secondary" type="submit" name="lBorrar" 

                                value="' . $l->getId() . '">Borrar</button>';

                                echo '</td>';

                            }

                            echo '</tr>';

                        }

                        ?>

                    </tbody>

                </table>

            </form>

        </div>

    </div>

</body>


</html>