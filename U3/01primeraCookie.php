<?php

if (isset($_POST['guardar'])) {
    //creamos una cookie y le damos el valor del input
    if (!empty($_POST['Valor'])) {
        //ponemos como fecha de expiracion un mes a partir de la fecha actual
        setcookie("miPrimeraC", $_POST['Valor'], time() + (60 * 60*24*30));
        //recargamos la página
    header('location: 01primeraCookie.php');
    }
    
}
//recuperamos el valor de la cookie
if (isset($_COOKIE['miPrimeraC'])) {
    $valorC= $_COOKIE['miPrimeraC'];
}
if (isset($_POST['borrar'])) {
    //borramos la cookie
    setcookie("miPrimeraC",'', time()-1);
    //recargamos la página
    header('location: 01primeraCookie.php');
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
        <td><label >Valor de la cookie</label></td>
        </br></br>
        <td><input type="text" name="Valor" value="<?php echo(isset($valorC) ? $valorC : ''); ?>" placeholder="valor que se almacena en la cookie miPrimeraC"></td>  </tr>
        <input type="submit"  name="guardar"value="Guardar">
        <input type="submit" name="borrar" value="Borrar">
        </table>
        
    </form>
</body>
</html>