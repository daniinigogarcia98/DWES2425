<?php
//Mostrar el array $_SESSION
echo '<h4>Valor de $_SESSION <u>antes</u> de hacer el session_start()</h4>';
echo var_dump($_SESSION);
//Antes de trabajar cons sesiones hay que llamar a la función session_start()
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <?php
  echo "Id Sesión: ".session_id()."<br>";
  echo "Nombre Sesión: ".session_name()."<br>";
  //Crear una variable en la sesión
  $_SESSION['nombre']='Daniel';
  echo "Nombre Sesión: ".$_SESSION['nombre']."<br>";
  ?>
</body>
</html>