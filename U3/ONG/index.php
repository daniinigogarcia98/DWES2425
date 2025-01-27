<?php
// Se incluye el archivo controlador.php, que contiene la lógica necesaria para manejar la base de datos y otros aspectos del sistema.
require_once 'controlador.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión ONG</title>
</head>

<body>
    <div>
        <!-- Muestra un mensaje de error o éxito si la variable $mensaje está definida -->
        <h1 style='color:red;'><?php echo (isset($mensaje) ? $mensaje : '') ?></h1>
    </div>
    <?php
    // Si no hay una sesión activa con el centro, se obtiene la lista de centros de la base de datos
    if (!isset($_SESSION['centro'])) {
        $centros = $bd->obtenerCentros();
    ?>
        <!-- Formulario para seleccionar un centro -->
        <form action="" method="post">
            <label for="centro">Centro:</label>
            <select name="centro" id="centro">
                <?php 
                // Se muestran todos los centros en un menú desplegable
                foreach ($centros as $centro) {
                    echo '<option value="' . $centro->getId() . '">' . $centro->getNombre() . '</option>';
                } 
                ?>
            </select>
            <button type="submit" name="seleccionarC">Seleccionar</button>
        </form>
    <?php
    } else {
    ?>
        <!-- Si ya hay un centro seleccionado, se muestra el nombre y localidad del centro -->
        <form action="" method="post">
            <h3>
                <?php echo $_SESSION['centro']->getNombre() . '-' . $_SESSION['centro']->getLocalidad(); ?>
                <!-- Botón para cambiar el centro -->
                <button type="submit" name="cambiarC">Cambiar Centro</button>
            </h3>
            <h3>
                <?php 
                // Se obtienen y muestran algunos datos del centro seleccionado, como los beneficiarios y los servicios prestados
                $datos = $bd->obtenerInfoCentro($_SESSION['centro']->getId());
                echo 'Beneficiarios:'. $datos[0] . '-' . 'Servicios Prestados:'.$datos[1];
                ?>
            </h3>
        </form>
        <?php

        // Se obtienen los beneficiarios y los servicios disponibles desde la base de datos
        $beneficiarios = $bd->obtenerBeneficiarios($_SESSION['centro']->getId());
        $servicios = $bd->obtenerServicios();
        ?>
        <!-- Formulario para seleccionar un beneficiario -->
        <form action="" method="post">
            <div>
                <label for="usuario">Beneficiario</label><br />
                <select name="beneficiario" id="beneficiario">
                    <?php 
                    // Se muestran todos los beneficiarios del centro seleccionado en un menú desplegable
                    foreach ($beneficiarios as $b) {
                        echo '<option value="' . $b->getId() . '" ' .
                            (isset($_POST['beneficiario']) && $_POST['beneficiario'] == $b->getId() ? 'selected="selected"' : '') 
                            . '>' . $b->getNombre() . '-' . $b->getDni() . '</option>';
                    } 
                    ?>
                </select>
                <!-- Botón para ver los servicios prestados al beneficiario -->
                <button type="submit" name="verSP">Ver Servicios Prestados</button>
                <!-- Botón para borrar al beneficiario -->
                <button type="submit" name="borrarB">Borrar Beneficiario</button>
            </div>
            <p />
            <div>
                <label for="usuario">Servicio</label><br />
                <select name="servicio" id="servicio">
                    <?php 
                    // Se muestran todos los servicios disponibles en un menú desplegable
                    foreach ($servicios as $s) {
                        echo '<option value="' . $s->getId() . '">' . $s->getDescripcion() . '</option>';
                    } 
                    ?>
                </select>
            </div>
            <p />
            <div>
                <!-- Botón para asignar un servicio a un beneficiario -->
                <button type="submit" name="asignarS">Asignar</button>
            </div>
        </form>
        <?php
        // Si se han prestado servicios, se muestra una tabla con los detalles
        if (isset($serviciosP)) {
        ?>
            <h2>Servicios Prestados</h2>
            <table width="50%" border="1">
                <tr>
                    <td>ID</td>
                    <td>DESCRIPCIÓN</td>
                    <td>FECHA</td>
                    <td>BENEFICIARIO</td>
                    <td>DNI</td>
                </tr>
                <?php
                // Se recorren los servicios prestados y se muestran en una tabla
                foreach ($serviciosP as $sp) {
                    echo '<tr>';
                    echo '<td>' . $sp->getId() . '</td>';
                    echo '<td>' . $sp->getServicio()->getDescripcion() . '</td>';
                    echo '<td>' . date('d/m/Y', strtotime($sp->getFecha())) . '</td>';
                    echo '<td>' . $sp->getBeneficiario()->getNombre() . '</td>';
                    echo '<td>' . $sp->getBeneficiario()->getDni() . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
    <?php
        }
    }
    ?>
</body>

</html>
