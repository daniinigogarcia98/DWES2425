<?php
$numAcceso = 0;
$fechaUltAcceso = '';
//recuperamos valores de las cookies
if (isset($_COOKIE['numAcceso'])) {
    $numAcceso= $_COOKIE['numAcceso'];
    $fechaUltAcceso= $_COOKIE['fechaUltAcceso'];
}
//Cada vez que se acceda a la página se incrementa el número de accesos y la fecha creando dos cookies
setcookie("numAcceso", $numAcceso+1);
setcookie("fechaUltAcceso", date('d-m-Y h:i:s'));

if (isset($_POST['borrar'])) {
    //borramos las cookies
    setcookie("numAcceso",'', time()-1);
    setcookie("fechaUltAcceso",'', time()-1);
    //recargamos la página
    header('location: 02Ejercicio1.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="" method="post">
        <table border="1">
            <tr>
        <td><h3>nº de Accesos:<?php echo $numAcceso; ?></h3></td>
        <td><h3>Fecha última acceso:<?php echo $fechaUltAcceso; ?></h3></td>
        <input type="submit" name="borrar" value="Borrar">
        </table>
        
    </form>
</body>
</html>