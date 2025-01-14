<?php
// Definir la clase Estancia
class Estancia {
    public $dni;
    public $nombreCliente;
    public $habitacion;
    public $estancia;
    public $noches;
    public $pago;
    public $cuna;
    public $camaSupletoria;

    public function __construct($dni, $nombreCliente, $habitacion, $estancia, $noches, $pago, $cuna, $camaSupletoria) {
        $this->dni = $dni;
        $this->nombreCliente = $nombreCliente;
        $this->habitacion = $habitacion;
        $this->estancia = $estancia;
        $this->noches = $noches;
        $this->pago = $pago;
        $this->cuna = $cuna;
        $this->camaSupletoria = $camaSupletoria;
    }

    // Método para calcular el precio de la estancia
    public function calcularImporte() {
        if ($this->habitacion == 'individual') {
            $precioHabitacion = 45.00;
        } elseif ($this->habitacion == 'doble') {
            $precioHabitacion = 55.00;
        } elseif ($this->habitacion == 'suite') {
            $precioHabitacion = 75.00;
        }

        if ($this->estancia == 'fin_de_semana') {
            $precioHabitacion *= 1.10; // Aumento del 10%
        } elseif ($this->estancia == 'promocionado') {
            $precioHabitacion *= 0.90; // Descuento del 10%
        }

        return $precioHabitacion * $this->noches;
    }

    // Método para guardar los datos en un archivo
    public function guardarEnArchivo() {
        $linea = $this->dni . ';' . $this->nombreCliente . ';' . $this->habitacion . ';' . $this->estancia . ';' . $this->noches . ';' . $this->pago . ';' . ($this->cuna ? 'Sí' : 'No') . ';' . ($this->camaSupletoria ? 'Sí' : 'No') . "\n";
        $archivo = fopen('estancias.txt', 'a');
        if ($archivo) {
            fwrite($archivo, $linea);
            fclose($archivo);
        }
    }

    // Método estático para leer las estancias desde el archivo
    public static function leerEstancias() {
        $estancias = [];
        if (file_exists('estancias.txt')) {
            $archivo = fopen('estancias.txt', 'r');
            if ($archivo) {
                while (($linea = fgets($archivo)) !== false) {
                    $datos = explode(';', trim($linea)); // Separamos por punto y coma
                    $estancia = new Estancia(
                        $datos[0], $datos[1], $datos[2], $datos[3], 
                        (int)$datos[4], $datos[5], $datos[6] == 'Sí', $datos[7] == 'Sí'
                    );
                    $estancias[] = $estancia;
                }
                fclose($archivo);
            }
        }
        return $estancias;
    }
}

// Inicializar variables de error y resultado
$errores = [];
$mensaje = "";
$importe = 0;
$detallesEstancia = "";

// Procesamiento al recibir el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    if (isset($_POST['ver_estancias'])) {
        // Leer todas las estancias guardadas
        $estancias = Estancia::leerEstancias();
    } else {
        $dni = $_POST['dni'];
        $nombreCliente = $_POST['nombre_cliente'];
        $habitacion = $_POST['habitacion'];
        $estancia = $_POST['estancia'];
        $noches = $_POST['noches'];
        $pago = $_POST['pago'];
        $cuna = isset($_POST['cuna']);
        $camaSupletoria = isset($_POST['cama_supletoria']);

        // Validar que los campos no estén vacíos
        if (empty($dni)) {
            $errores[] = "El DNI es obligatorio.";
        }
        if (empty($nombreCliente)) {
            $errores[] = "El nombre del cliente es obligatorio.";
        }
        if (empty($noches)) {
            $errores[] = "El número de noches es obligatorio.";
        }

        // Validar que el pago en efectivo solo se permita para estancias de menos de 2 noches
        if ($pago == "efectivo" && $noches >= 2) {
            $errores[] = "El pago en efectivo solo es permitido para estancias de menos de 2 noches.";
        }

        // Validar que no se seleccionen cuna y cama supletoria a la vez
        if ($cuna && $camaSupletoria) {
            $errores[] = "No se puede seleccionar cuna y cama supletoria a la vez.";
        }

        // Si no hay errores, crear objeto Estancia y guardarlo
        if (empty($errores)) {
            // Crear el objeto Estancia
            $estanciaObj = new Estancia($dni, $nombreCliente, $habitacion, $estancia, $noches, $pago, $cuna, $camaSupletoria);

            // Guardar los datos en un archivo
            $estanciaObj->guardarEnArchivo();

            // Calcular el importe
            $importe = $estanciaObj->calcularImporte();

            // Crear detalles de la estancia
            $detallesEstancia = "<h2>Detalles de la Estancia</h2>";
            $detallesEstancia .= "<p><strong>DNI:</strong> " . $dni . "</p>";
            $detallesEstancia .= "<p><strong>Nombre Cliente:</strong> " . $nombreCliente . "</p>";
            $detallesEstancia .= "<p><strong>Habitación:</strong> " . $habitacion . "</p>";
            $detallesEstancia .= "<p><strong>Estancia:</strong> " . $estancia . "</p>";
            $detallesEstancia .= "<p><strong>Número de Noches:</strong> " . $noches . "</p>";
            $detallesEstancia .= "<p><strong>Tipo de Pago:</strong> " . $pago . "</p>";
            $detallesEstancia .= "<p><strong>Importe Total:</strong> " . $importe . "€</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Estancia</title>
</head>
<body>
    <h1>Formulario de Estancia</h1>

    <!-- Mostrar los errores -->
    <?php if (!empty($errores)): ?>
        <ul style="color: red;">
            <?php foreach ($errores as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Formulario de entrada -->
    <form action="Ejercicio4.php" method="post">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" value="<?php echo isset($dni) ? $dni : ''; ?>"><br><br>

        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo isset($nombreCliente) ? $nombreCliente : ''; ?>"><br><br>

        <label for="habitacion">Tipo de Habitación:</label>
        <select id="habitacion" name="habitacion">
            <option value="doble" <?php echo (isset($habitacion) && $habitacion == 'doble') ? 'selected' : ''; ?>>Doble</option>
            <option value="individual" <?php echo (isset($habitacion) && $habitacion == 'individual') ? 'selected' : ''; ?>>Individual</option>
            <option value="suite" <?php echo (isset($habitacion) && $habitacion == 'suite') ? 'selected' : ''; ?>>Suite</option>
        </select><br><br>

        <label for="estancia">Tipo de Estancia:</label>
        <select id="estancia" name="estancia">
            <option value="diario" <?php echo (isset($estancia) && $estancia == 'diario') ? 'selected' : ''; ?>>Diario</option>
            <option value="fin_de_semana" <?php echo (isset($estancia) && $estancia == 'fin_de_semana') ? 'selected' : ''; ?>>Fin de Semana</option>
            <option value="promocionado" <?php echo (isset($estancia) && $estancia == 'promocionado') ? 'selected' : ''; ?>>Promocionado</option>
        </select><br><br>

        <label for="noches">Número de Noches:</label>
        <input type="number" id="noches" name="noches" value="<?php echo isset($noches) ? $noches : ''; ?>" min="1"><br><br>

        <label for="pago">Tipo de Pago:</label>
        <select id="pago" name="pago">
            <option value="tarjeta" <?php echo (isset($pago) && $pago == 'tarjeta') ? 'selected' : ''; ?>>Tarjeta</option>
            <option value="efectivo" <?php echo (isset($pago) && $pago == 'efectivo') ? 'selected' : ''; ?>>Efectivo</option>
        </select><br><br>

        <label for="cuna">Cuna:</label>
        <input type="checkbox" id="cuna" name="cuna" <?php echo (isset($cuna) && $cuna) ? 'checked' : ''; ?>><br><br>

        <label for="cama_supletoria">Cama Supletoria:</label>
        <input type="checkbox" id="cama_supletoria" name="cama_supletoria" <?php echo (isset($camaSupletoria) && $camaSupletoria) ? 'checked' : ''; ?>><br><br>

        <input type="submit" value="Crear Registro">
    </form>

    <!-- Botón para ver las estancias guardadas -->
    <form action="Ejercicio4.php" method="post">
        <input type="submit" name="ver_estancias" value="Ver Estancias">
    </form>

    <!-- Mostrar todas las estancias guardadas -->
    <?php if (isset($estancias)): ?>
        <h2>Estancias Guardadas</h2>
        <table border="1">
            <tr>
                <th>DNI</th>
                <th>Nombre Cliente</th>
                <th>Habitación</th>
                <th>Estancia</th>
                <th>Noches</th>
                <th>Pago</th>
                <th>Cuna</th>
                <th>Cama Supletoria</th>
            </tr>
            <?php foreach ($estancias as $estancia): ?>
                <tr>
                    <td><?php echo $estancia->dni; ?></td>
                    <td><?php echo $estancia->nombreCliente; ?></td>
                    <td><?php echo $estancia->habitacion; ?></td>
                    <td><?php echo $estancia->estancia; ?></td>
                    <td><?php echo $estancia->noches; ?></td>
                    <td><?php echo $estancia->pago; ?></td>
                    <td><?php echo $estancia->cuna ? 'Sí' : 'No'; ?></td>
                    <td><?php echo $estancia->camaSupletoria ? 'Sí' : 'No'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>
