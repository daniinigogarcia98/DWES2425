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
            ?>
                <form action="" method="post">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" name="dni" id="dni" value="<?php echo(isset($_POST['dni'])?$_POST['dni']:'')?>"/>
                        </div>
                        <div class="col-md-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" name="tipo" id="tipo" onchange="submit();">
                                <option value="A">Administrador</option>
                                <option value="S"<?php echo(isset($_POST['tipo'])and $_POST['tipo']=='S'?'selected=selected':'')?>>Socio</option>
                            </select>
                        </div>
                        <!-- quita Boton -->
                        <!-- <div class="col-md-3">
                            <label class="form-label">Acción</label><br />
                            <button class="btn btn-outline-secondary" type="submit" id="sCrear" name="sCrear">+</button>
                        </div> -->

                    </div>
                    <?php
                    if (isset($_SESSION['crearSocio']) and $_SESSION['crearSocio']) {

                    
                    ?>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                        </div>
                        <div class="col-md-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Acción</label><br />
                            <button class="btn btn-outline-secondary" type="submit" id="sCrearSocio" name="sCrearSocio">+</button>
                        </div>
                    </div>
                    <?php
                     }
                     ?>
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
                            <th>Tipo</th>
                            <th>IdSocio</th>
                            <th>Nombre</th>
                            <th>Fecha Sanción</th>
                            <th>Email</th>
                            <?php if ($_SESSION['usuario']->getTipo() == 'A') { ?>
                                <th>Acciones</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>

</html>