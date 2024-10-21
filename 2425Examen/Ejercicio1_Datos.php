<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
</head>

<body>
    <?php
    if (isset($_POST['guardar'])) {
        //Creo un array que me almacene los datos del formulario
        $campos = array();
        $campos["fechaEntrada"] = $_POST["fecha"];
        $campos["nombreCliente"] = $_POST["cliente"];
        $campos["tipoPrenda"] = $_POST["prendas"];
        if (empty($_POST['fecha']) or empty($_POST['cliente']) or empty($_POST['prendas'])) {
            echo '<h3 style="color:red;">*Faltan Campos por Rellenar*</h3>';
        }
        if (isset($_POST["limpieza"])) {
            $campos["Limpieza"] = $_POST["limpieza"];
        }
        if (isset($_POST["planchado"])) {
            $campos["Planchado"] = $_POST["planchado"];
        }
        if (isset($_POST["desmanchado"])) {
            $campos["Desmanchado"] = $_POST["desmanchado"];
        }
        $campos["Importe"] = $_POST["importe"];
        //Mostramos el array 
    ?>
    
            <h1>Datos Correctos</h1>
            <?php
            foreach ($campos as $datos=>$valor) {
                $campos = implode('/', $valor);
                echo "
                    Prenda:$valor
                    Servicio$valor
                    Importe:$valor
               ";
            }
            ?>

    <?php
    }else{
        echo '<h3 style="color:red;">*Debes Rellenar el Formulario*</h3>';
    }
    ?>
</body>

</html>