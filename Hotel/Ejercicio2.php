<?php
// Inicializar variables de error y resultado
$errores = [];
$mensaje = "";
$importe = 0;
$detallesEstancia = "";

// Procesamiento al recibir el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
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

    // Si no hay errores, calcular el importe
    if (empty($errores)) {
        // Precios de las habitaciones
        if ($habitacion == 'individual') {
            $precioHabitacion = 45.00;
        } elseif ($habitacion == 'doble') {
            $precioHabitacion = 55.00;
        } elseif ($habitacion == 'suite') {
            $precioHabitacion = 75.00;
        }

        // Ajustar precio según tipo de estancia
        if ($estancia == 'fin_de_semana') {
            $precioHabitacion *= 1.10; // Aumento del 10%
        } elseif ($estancia == 'promocionado') {
            $precioHabitacion *= 0.90; // Descuento del 10%
        }

        // Calcular el importe total
        $importe = $precioHabitacion * $noches;

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
    <form action="Ejercicio2.php" method="post">
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

    <!-- Mostrar detalles de la estancia si no hay errores -->
    <?php if (empty($errores) && !empty($detallesEstancia)): ?>
        <h3>Resumen de la Estancia</h3>
        <div>
            <?php echo $detallesEstancia; ?>
        </div>
    <?php endif; ?>
</body>
</html>
