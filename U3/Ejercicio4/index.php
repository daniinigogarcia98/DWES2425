<?php
// Si no existe el cookie se crea
if (!isset($_COOKIE['eventos'])) {
    $eventos = array();
    setcookie('eventos', serialize($eventos), time() + (60*60*24*30));
}

// Función para agregar un evento
function agregarEvento($nombre, $fecha, $hora, $asunto) {
    $eventos = unserialize($_COOKIE['eventos']);
    $eventos[] = array('nombre' => $nombre, 'fecha' => $fecha, 'hora' => $hora, 'asunto' => $asunto);
    setcookie('eventos', serialize($eventos), time() + (60*60*24*30));
}

// Función para borrar un evento
function borrarEvento($id) {
    $eventos = unserialize($_COOKIE['eventos']);
    unset($eventos[$id]);
    $eventos = array_values($eventos);
    setcookie('eventos', serialize($eventos), time() + (60*60*24*30));
}

// Función para mostrar los eventos
function mostrarEventos() {
    $eventos = unserialize($_COOKIE['eventos']);
    foreach ($eventos as $id => $evento) {
        echo "Nombre:$evento[nombre] Fecha:$evento[fecha] Hora:$evento[hora] Asunto:$evento[asunto]";
        echo '<form action="" method="post" style="display:inline;">
                <input type="hidden" name="id" value="' . $id . '">
                <input type="submit" name="borrar" value="Borrar">
              </form><br>';
    }
}

// Añadimos el evento al pulsar el botón
if (isset($_POST['agregar'])) {
    agregarEvento($_POST['nombre'], $_POST['fecha'], $_POST['hora'], $_POST['asunto']);
    header('location:index.php');
    exit;
} elseif (isset($_POST['borrar'])) {
    borrarEvento($_POST['id']);
    header('location:index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de eventos</title>
</head>
<body>
<h1>Calendario de eventos</h1>
<!-- Mostrar los eventos -->
<?php mostrarEventos(); ?>
    <form action="" method="post">
        <label for="nombre"></label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre del evento" required>
        <label for="fecha"></label>
        <input type="date" name="fecha" id="fecha" placeholder="Fecha del evento" required>
        <label for="hora"></label>
        <input type="time" name="hora" id="hora" placeholder="Hora del evento" required>
        <label for="asunto"></label>
        <input type="text" name="asunto" id="asunto" placeholder="Asunto del evento" required>
        <input type="submit" name="agregar" value="Añadir">
    </form>
</body>
</html>