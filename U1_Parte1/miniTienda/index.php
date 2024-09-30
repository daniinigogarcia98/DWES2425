<?php
require_once 'Ticket.php';
require_once 'AccesoDatos.php';

//Creamos una instacia de acceso a datos
$ad=new AccesoDatos('ventas.txt');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniTienda</title>
</head>
<body>
    <h1>MiniTienda</h1>
    <form action="#" method="post">
        <div>
            <label for="producto">Selecciona Producto</label><br/>
            <select name="producto" id="producto">
                <option>Pantalones - 15</option>
                <option>Camiseta España -23</option>
                <option>Zapatillas Nike -15</option>
                <option>Chandal -27</option>
            </select>
        </div>
        <div>
            <label for="cantidad"></label>
            <input type="number" name="cantidad" id="cantidad" value="1">
        </div>
        <input type="submit"  name="enviar"value="Añadir">
    </form>
    <?php
    if(isset($_POST['enviar'])){
        $datosProducto=explode('-',$_POST['producto']);
        $t = new Ticket($datosProducto[0],$datosProducto[1],$_POST['cantidad']);

        //Introducir el ticket en la venta
        $ad->insertarProducto($t);
       
    }
     //Recuperar lo que hay en el fichero y pintarlo en una tabla
     echo '<h3>Productos</h3>';
     echo '<table border="2px solid black">';
     echo '<tr><th>Productos</th> <th>Precio U</th><th>Cantidad</th><th>Total</th></tr>';
     //Creamos un array y lo rellenamos con todos los productos del fichero
     //El array va a contener objetos producto
     $productos = $ad -> obtenerProductos($t);
     foreach($productos as $p){
        echo '<tr>';
        echo '<td>'.$p->getProducto().'</td>';
        echo '<td>'.$p->getPrecioU().'</td>';
        echo '<td>'.$p->getCantidad().'</td>';
        echo '<td>'.$p->getTotal().'</td>';
        echo '</tr>';
     }
     echo' </table>';
    ?>
</body>
</html>