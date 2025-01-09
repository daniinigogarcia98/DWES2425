<?php
require_once 'Modelo.php';
$modelo = new Modelo();
//Cargar asignaturas en un array
$asigs = $modelo->obtenerAsignaturas();

if (isset($_POST["fecha"]) && isset($_POST["asignatura"]) && isset($_POST["descripcion"]) && isset($_POST["nota"]) && isset($_POST["tipo"])) {
    $fecha = $_POST["fecha"];
    $asignatura = $_POST["asignatura"];
    $descripcion = $_POST["descripcion"];
    $nota = $_POST["nota"];
    $tipo = $_POST["tipo"];

    $nota = new Nota($asignatura, $fecha, $tipo, $descripcion, $nota);
    $modelo->crearNota($nota);

    // Crear archivo notas.dat
    $contenido = "Fecha: $fecha\nAsignatura: $asignatura\nDescripción: $descripcion\nNota: $nota\nTipo: $tipo\n";
    $modelo->crearArchivoNotas($contenido);
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
    <h1>Mis Notas de Exámenes y tareas 2º DAW</h1>
    <form action="" method="post">
        <div>
            <label for="asig">Asignatura</label><br/>
            <select name="asignatura" id="asig">
            <!-- HAcer un option para cada asignatura -->   
             <?php 
             foreach($asigs as $a){
                echo '<option value="'.$a.'">'.$a.'</option>';
             }
             ?>
            </select>
        </div>
        <div>
            <label for="fecha">Fecha</label><br/>
            <input type="date" name="fecha" id="fecha" value="<?php echo date('Y-m-d');?>"/>
        </div>
        <div>
            <label for="descripcion">Descripción</label><br/>
            <input type="text" name="descripcion" id="descripcion" placeholder="Examen tema 1"/>
        </div>
        <div>
            <label>Tipo</label><br/>
            <input type="radio" name="tipo" id="ex" value="Examen" checked="checked"/>
            <label for="ex">Examen</label>
            <input type="radio" name="tipo" id="ta" value="Tarea"/>
            <label for="ta">Tarea</label>
        </div>
        <div>
            <label for="nota">Nota</label><br/>
            <input type="number" name="nota" id="nota" placeholder="Nota"/>
        </div>
        <input type="submit" value="Crear Nota">
    </form>
    <?php
    // Mostrar notas registradas
echo "<h2>Notas registradas</h2>";
echo "<table border='1'>";
echo "<tr><th>Fecha</th><th>Asignatura</th><th>Descripción</th><th>Nota</th><th>Tipo</th></tr>";
$notas = explode("\n", $modelo->obtenerNotas());
foreach ($notas as $nota) {
    $datos = explode("|", $nota);
    $fecha = date("d/m/Y", strtotime($datos[0]));
    echo "<tr>";
    echo "<td>$fecha</td>";
    echo "<td>$datos[1]</td>";
    echo "<td>$datos[2]</td>";
    echo "<td>$datos[3]</td>";
    echo "<td>$datos[4]</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>