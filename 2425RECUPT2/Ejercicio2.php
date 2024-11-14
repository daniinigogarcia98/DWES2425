<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>CULTURA NAVALMORAL</h1>
    <form action="" method="post">
        <fieldset>
            <legend>Venta de Entradas</legend>
            <div>
                <label for="nombre">Nombre Completo</label><br />
                <input type="text" id="nombre" name="nombre" placeholder="Introduce Nombre" value="<?php echo (isset($_POST['nombre'])?$_POST['nombre']:'')?>" />
            </div>
            <br />
            <div>
                <label for="TEntrada">Tipo Entrada:</label><br />
                <input type="radio" id="general" name="general" value="general" value="<?php echo (isset($_POST['TEntrada'])?$_POST['TEntrada']:'')?>" checked="checked" />
                <label for="general">General</label>
                <input type="radio" id="mayor60" name="mayor60" value="mayor60" value="<?php echo (isset($_POST['TEntrada'])?$_POST['TEntrada']:'')?>" />
                <label for="mayor60">Mayor de 60</label>
                <input type="radio" id="Menor6" name="Menor6" value="Menor6" value="<?php echo (isset($_POST['TEntrada'])?$_POST['TEntrada']:'')?>" />
                <label for="Menor6">Menor de 6 años</label>
            </div>
            <br />
            <div>
                <label for="fecha">Fecha Entrada</label><br />
                <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d')?>" />
            </div>
            <br />
            <div>
                <label for="entradas">Número de Entradas:</label><br />
                <input type="number" id="entradas" name="entradas" value="<?php echo (isset($_POST['entradas'])?$_POST['entradas']:'')?>" />
            </div>
            <br />
            <div>
            <label for="desc">Descuentos</label><br />
                <select name="desc" id="desc">
                    <option>Familia Numerosa</option>
                    <option>Abonado</option>
                    <option>Día del Espectador</option>
                </select>
            </div>
            <br />
            <div>
            <input type="submit" name="comprar" value="Comprar"/>
            </div>
        </fieldset>
    </form>
    <?php
   if(isset($_POST['comprar'])){
    if(empty(isset($_POST['nombre']))or empty(isset($_POST['TEntrada']))
    or empty(isset($_POST['fecha']))or empty(isset($_POST['entradas']))
    or empty(isset($_POST['desc']))){
        echo 'Rellena los datos';
        $err=true;
    }
 
    if(isset($err)){
        echo '<table border=1px solid black>';
        echo '<th>Nombre</th>';
        echo '<td>Tipo Entrada'.'</td>';
        echo '<td>Nº de entradas'.'</td>';
        echo '<td>Descuentos'.'</td>';
        echo '<td>Total a pagar'.'</td>';
        echo '<tr>';
        echo '<td>'.$_POST['nombre'].'</td>';
        echo '<td>'.$_POST['Tentrada'].'</td>';
        echo '<td>'.$_POST['entradas'].'</td>';
        echo '<td>'.$_POST['desc'].'</td>';
        echo'</tr>';   
        echo'</table>';
    }
   }
    ?>
</body>
</html>