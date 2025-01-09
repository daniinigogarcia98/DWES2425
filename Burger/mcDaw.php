<?php
require_once 'ProductoEnCesta.php';
require_once 'Producto.php';
session_start();

// Conectar a la base de datos
$host = 'localhost';
$user = 'root';
$password = 'root';
$dbname = 'mcDaw';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Definir la clase ProductosEnCesta
class ProductosEnCesta {
    public $productoId;
    public $nombre;
    public $precio;
    public $cantidad;

    public function __construct($productoId, $nombre, $precio, $cantidad) {
        $this->productoId = $productoId;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }
}

// Rellenar el select de tiendas
$tiendasQuery = "SELECT * FROM tienda";
$tiendasResult = $conn->query($tiendasQuery);

// Gestionar la tienda seleccionada
if (isset($_POST['selTienda'])) {
    $tiendaSeleccionada = $_POST['tienda'];
    $_SESSION['tienda'] = $tiendaSeleccionada;
}

// Cambiar tienda (destruir sesión de tienda)
if (isset($_POST['cambiar'])) {
    unset($_SESSION['tienda']);
    header("Location: mcDaw.php");
    exit();
}

// Gestionar la cesta de productos
if (isset($_POST['agregar'])) {
    $productoId = $_POST['producto'];
    $cantidad = $_POST['cantidad'];

    if ($cantidad <= 0) {
        echo "<script>alert('La cantidad debe ser mayor que 0.');</script>";
    } else {
        // Obtener información del producto
        $productoQuery = "SELECT nombre, precio FROM producto WHERE codigo = $productoId";
        $productoResult = $conn->query($productoQuery);
        $productoData = $productoResult->fetch_assoc();
        
        // Crear el objeto ProductoEnCesta
        $productoEnCesta = new ProductosEnCesta($productoId, $productoData['nombre'], $productoData['precio'], $cantidad);

        // Si la cesta no está inicializada, inicializarla
        if (!isset($_SESSION['cesta'])) {
            $_SESSION['cesta'] = [];
        }

        // Verificar si el producto ya está en la cesta
        $found = false;
        foreach ($_SESSION['cesta'] as &$item) {
            if ($item->productoId == $productoId) {
                $item->cantidad += $cantidad;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cesta'][] = $productoEnCesta;
        }
    }
}

// Crear pedido
if (isset($_POST['crearPedido'])) {
    if (isset($_SESSION['cesta']) && count($_SESSION['cesta']) > 0) {
        // Obtener los datos de la tienda seleccionada
        $tiendaId = $_SESSION['tienda'];
        $fecha = date('Y-m-d');
        
        // Crear el pedido en la base de datos
        $insertPedido = "INSERT INTO pedido (fecha, tienda) VALUES ('$fecha', $tiendaId)";
        if ($conn->query($insertPedido) === TRUE) {
            // Obtener el id del nuevo pedido
            $pedidoId = $conn->insert_id;
            
            // Insertar los productos del pedido en la tabla detalle
            $linea = 1;
            foreach ($_SESSION['cesta'] as $item) {
                $insertDetalle = "INSERT INTO detalle (pedido, producto, cantidad, precioU, linea) 
                                  VALUES ($pedidoId, {$item->productoId}, {$item->cantidad}, {$item->precio}, $linea)";
                $conn->query($insertDetalle);
                $linea++;
            }

            // Llamar al procedimiento almacenado para obtener los datos del pedido
            $result = $conn->query("CALL datosPedido($pedidoId)");
            $pedidoData = $result->fetch_assoc();
            
            // Mostrar el mensaje con la información del pedido
            echo "<script>alert('Pedido nº $pedidoId generado. El nº de productos es {$pedidoData['numProd']} y el importe total del pedido es €" . number_format($pedidoData['total'], 2) . "');</script>";
            
            // Eliminar la cesta de la sesión
            unset($_SESSION['cesta']);
        }
    } else {
        echo "<script>alert('La cesta está vacía.');</script>";
    }
}

// Obtener datos de la tienda seleccionada
$tiendaSeleccionada = isset($_SESSION['tienda']) ? $_SESSION['tienda'] : null;
$tiendaInfo = null;
if ($tiendaSeleccionada) {
    $tiendaQuery = "SELECT * FROM tienda WHERE codigo = $tiendaSeleccionada";
    $tiendaInfo = $conn->query($tiendaQuery)->fetch_assoc();
}

// Obtener los productos disponibles
$productosQuery = "SELECT * FROM producto";
$productosResult = $conn->query($productosQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mcDaw Tienda</title>
</head>
<body>
    <div>
        <h1 style='color:red;'>Mensajes</h1>
    </div>

    <form action="mcDaw.php" method="post">
        <?php if (!$tiendaSeleccionada): ?>
        <!-- Sección de seleccionar tienda -->
        <div>
            <h1 style='color:blue;'>Tienda</h1>
            <label for="tienda">Selecciona una tienda</label><br />
            <select name="tienda" id="tienda">
                <?php while ($tienda = $tiendasResult->fetch_assoc()): ?>
                    <option value="<?= $tienda['codigo'] ?>"><?= $tienda['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="selTienda">Seleccionar tienda</button>
        </div>
        <?php else: ?>
        <!-- Sección de añadir productos y contenido de la cesta -->
        <div>
            <h1 style='color:blue;'>Añade productos a la cesta</h1>
            <h2 style='color:green;'>Datos Tienda: <?= $tiendaInfo['nombre'] ?> - <?= $tiendaInfo['telefono'] ?>
                <button type="submit" name="cambiar">Cambiar Tienda</button>
            </h2>
            <table>
                <tr>
                    <td><label for="producto">Producto</label><br /></td>
                    <td><label for="cantidad">Cantidad</label><br /></td>
                    <td>Añadir a la cesta</td>
                </tr>
                <tr>
                    <td>
                        <select id="producto" name="producto">
                            <?php while ($producto = $productosResult->fetch_assoc()): ?>
                                <option value="<?= $producto['codigo'] ?>"><?= $producto['nombre'] ?> - €<?= number_format($producto['precio'], 2) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                    <td><input id="cantidad" type="number" name="cantidad" value="1" min="1" /></td>
                    <td><button type="submit" name="agregar">+</button></td>
                </tr>
            </table>            
        </div>

        <div>
            <h1 style='color:blue;'>Contenido de la cesta</h1>
            <table border="1" rules="all" width="50%">
                <tr>
                    <td><b>Producto</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Precio</b></td>
                    <td><b>Total</b></td>
                </tr>
                <?php if (isset($_SESSION['cesta'])): ?>
                    <?php $totalPedido = 0; ?>
                    <?php foreach ($_SESSION['cesta'] as $item): ?>
                    <tr>
                        <td><?= $item->nombre ?></td>
                        <td><?= $item->cantidad ?></td>
                        <td>€<?= number_format($item->precio, 2) ?></td>
                        <td>€<?= number_format($item->precio * $item->cantidad, 2) ?></td>
                    </tr>
                    <?php $totalPedido += $item->precio * $item->cantidad; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3"><b>Total</b></td>
                        <td><b>€<?= number_format($totalPedido, 2) ?></b></td>
                    </tr>
                <?php endif; ?>
            </table>
            <button type="submit" name="crearPedido">Crear Pedido</button>         
        </div>
        <?php endif; ?>
    </form>
</body>
</html>
