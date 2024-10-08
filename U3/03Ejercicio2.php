<?php
// Eliminamos las cookies
if (isset($_POST['borrar'])) {
    setcookie('fondoColor', '', time() - 1);
    setcookie('colorTexto', '', time() - 1);
    header('Location: 03Ejercicio2.php');
}

// Obtenemos los colores de las cookies
$fondoColor = $_COOKIE['fondoColor'] ?? '';
$colorTexto = $_COOKIE['colorTexto'] ?? '';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2</title>
    <style>
        /* añadimos al body el color de fondo y el color de texto */
        body {
            background-color: <?php echo $fondoColor; ?>;
            color: <?php echo $colorTexto; ?>;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <label for="fondocolor">Color de fondo:</label>
        <input type="color" id="fondocolor" name="fondocolor" value="<?php echo $fondoColor; ?>">
        <br>
        <label for="colortexto">Color de texto:</label>
        <input type="color" id="colortexto" name="colortexto" value="<?php echo $colorTexto; ?>">
        <br>
        <button type="submit" name="guardar">Guardar</button>
        <button type="submit" name="borrar">Borrar</button>
    </form>
</body>
</html>

<?php
// Guardamos los colores en las cookies
if (isset($_POST['guardar'])) {
    //establecemos un mes de expiración
    setcookie('fondoColor', $_POST['fondocolor'], time() + (60 * 60 * 24 * 30));
    setcookie('colorTexto', $_POST['colortexto'], time() + (60 * 60 * 24 * 30));
    header('Location: 03Ejercicio2.php');
}
?>