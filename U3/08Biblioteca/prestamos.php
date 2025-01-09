<?php
require_once 'controlador.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
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
    <?php
    require_once 'menu.php';
    ?>
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
            <!-- ÁREA DE INSERT (SÓLO ADMIN) -->
            <?php
            if ($_SESSION['usuario']->getTipo() == 'A') {
                //Obtenemos los socios
                $socios = $bd->obtenerSocios();
                //Obtenemos libros
                $libros = $bd->obtenerLibros();
            ?>
                <form action="" method="post" class="row g-3">
                    <div class="col-md-3">
                        <label for="socio" class="form-label">Socio</label>
                        <select class="form-select" name="socio" id="socio">
                            <?php
                            foreach ($socios as $s) {
                                echo '<option value="' . $s->getId() . '">'
                                    . $s->getNombre() . '-' . $s->getUs() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="libro" class="form-label">Libro</label>
                        <select class="form-select" name="libro" id="libro">
                            <?php
                            foreach ($libros as $l) {
                                echo '<option value="' . $l->getId() . '">'
                                    . $l->getTitulo() . '-' . $l->getEjemplares() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Acción</label><br />
                        <button class="btn btn-outline-secondary" type="submit" id="pCrear" name="pCrear">+</button>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
        <div>
            <br />
            <!-- mostrar préstamos -->
            <form action="" method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Socio</th>
                            <th>Libro</th>
                            <th>Fecha Préstamos</th>
                            <th>Fecha Devolución</th>
                            <th>Fecha Real Devolución</th>
                            <?php if ($_SESSION['usuario']->getTipo() == 'A') { ?>
                                <th>Acciones</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SESSION['usuario']->getTipo() == 'A') {
                            $prestamos = $bd->obtenerPrestamos();
                        } elseif ($_SESSION['usuario']->getTipo() == 'S') {
                            $prestamos = $bd->obtenerPrestamosSocio($_SESSION['usuario']);
                        } else {
                            $prestamos = array();
                        }
                        foreach ($prestamos as $p) {
                            echo '<tr>';
                            echo '<td>' . $p->getId() . '</td>';
                            echo '<td>' . $p->getSocio()->getNombre() . '-' . $p->getSocio()->getUs() . '</td>';
                            echo '<td>' . $p->getLibro()->getTitulo() . '-' . $p->getLibro()->getAutor() . '</td>';
                            echo '<td>' . date('d/m/Y', strtotime($p->getFechaP())) . '</td>';
                            echo '<td>' . date('d/m/Y', strtotime($p->getFechaD())) . '</td>';
                            echo '<td>' .
                                ($p->getFechaRD() == null ? '' : date('d/m/Y', strtotime($p->getFechaRD()))) .
                                '</td>';
                            if ($_SESSION['usuario']->getTipo() == 'A') {
                                echo '<td>';
                                echo ($p->getFechaRD() == null ?
                                    '<button class="btn btn-outline-secondary" type="submit" name="pDevolver" 
                                    value="' . $p->getId() . '">Devolver</button>'
                                    : '');
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