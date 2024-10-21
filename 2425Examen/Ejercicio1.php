<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
</head>

<body>
    <form action="Ejercicio1_Datos.php" method="post">
        <h1>Tintoreria La Morada</h1>
        <p>Registar Trabajo</p>
        <label>Fecha de entrada</label><br />
        <input type="date" name="fecha" id="fecha" value="<?php echo date('Y-m-d'); ?>"><br /><br />
        <label>Cliente</label><br />
        <input type="text" name="cliente" id="cliente"><br /><br />
        <label>Tipo de Prenda</label><br />
        <br />
        <select name="prendas">
            <option>Fiesta</option>
            <option>Cuero</option>
            <option>Hogar</option>
            <option selected="selected">Textil</option>
        </select><br /><br />
        <label>Servicio</label>
        <br />
        <input type="checkbox" name="limpieza" value="limp" />Limpieza
        <input type="checkbox" name="planchado" value="plan" />planchado
        <input type="checkbox" name="desmanchado" value="desm" />Desmanchado
        <br /><br />
        <label>Importe</label>
        <input type="number" name="importe" id="importe">
        <br /><br />
        <input type="submit" name="guardar" value="Guardar">
    </form>
</body>

</html>