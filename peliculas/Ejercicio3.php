<?php
// Variables inicializadas
$title = $date = $capitulos = $type = '';
$genres = [];
$plus18 = false;
$errors = [];

// Establecemos la fecha actual en formato yyyy-mm-dd
$currentDate = date('Y-m-d'); // Fecha en formato año-mes-día

// Clase Película
class Pelicula {
    public $titulo;
    public $fechaRegistro;
    public $generos;
    public $tipo;
    public $capitulos;

    public function __construct($titulo, $fechaRegistro, $generos, $tipo, $capitulos) {
        $this->titulo = $titulo;
        $this->fechaRegistro = $fechaRegistro;
        $this->generos = $generos;
        $this->tipo = $tipo;
        $this->capitulos = $capitulos;
    }

    // Guardar película en un archivo
    public function guardar() {
        $line = "{$this->titulo};{$this->fechaRegistro};{$this->generos};{$this->tipo};{$this->capitulos}\n";
        file_put_contents('peliculas.txt', $line, FILE_APPEND);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recolectar datos del formulario
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : $currentDate;  // Si no se envía, se usa la fecha actual
    $capitulos = isset($_POST['capitulos']) ? $_POST['capitulos'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : 'Película'; // Tipo por defecto es "Película"
    $genres = isset($_POST['genres']) ? $_POST['genres'] : [];
    $plus18 = isset($_POST['plus18']); // Checkbox +18
    
    // Validaciones
    if (empty($title)) {
        $errors[] = "El título no puede estar vacío.";
    }
    if (empty($date)) {
        $errors[] = "La fecha no puede estar vacía.";
    }
    if (empty($capitulos)) {
        $errors[] = "El número de capítulos no puede estar vacío.";
    }
    
    if ($type == 'Serie' && (int)$capitulos <= 1) {
        $errors[] = "El número de capítulos debe ser mayor que 1 para el tipo Serie.";
    }
    
    if (count($genres) == 0) {
        $errors[] = "Debes seleccionar al menos un género.";
    }

    // Verificar si se seleccionó el género "Terror" y si el checkbox +18 está marcado
    $genreTerrorSelected = false;
    foreach ($genres as $genre) {
        if ($genre === "Terror") {
            $genreTerrorSelected = true;
            break; // Si encontramos Terror, no es necesario seguir buscando
        }
    }

    if ($genreTerrorSelected && !$plus18) {
        $errors[] = "Si seleccionas Terror, debes marcar el checkbox +18.";
    }

    // Si no hay errores, guardamos la película
    if (empty($errors)) {
        $genreText = implode("/", $genres);
        $capitulos = $type == 'Película' ? 0 : $capitulos;  // Para películas, los capítulos siempre son 0

        // Crear objeto de la película
        $pelicula = new Pelicula($title, $date, $genreText, $type, $capitulos);
        $pelicula->guardar(); // Guardar en el archivo

        echo "<h3>Datos Guardados</h3>";
        echo "Título: $title<br>";
        echo "Fecha de Registro: $date<br>";
        echo "Género(s): $genreText<br>";
        echo "Tipo: $type<br>";
        echo "Número de Capítulos: $capitulos<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Película / Serie</title>
</head>
<body>
    <h2>Formulario de Película o Serie</h2>
    
    <form action="" method="POST">
        <!-- Título -->
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" value="<?= $title ?>"><br><br>
        
        <!-- Fecha de Registro -->
        <label for="date">Fecha de Registro:</label>
        <input type="date" id="date" name="date" value="<?= $date ?>"><br><br>
        
        <!-- Género: Usamos un select múltiple -->
        <label for="genres">Género(s):</label><br>
        <select name="genres[]" id="genres" multiple size="5">
            <option value="Acción" <?= isset($genres) && array_key_exists('Acción', array_flip($genres)) ? "selected" : "" ?>>Acción</option>
            <option value="Aventura" <?= isset($genres) && array_key_exists('Aventura', array_flip($genres)) ? "selected" : "" ?>>Aventura</option>
            <option value="Comedia" <?= isset($genres) && array_key_exists('Comedia', array_flip($genres)) ? "selected" : "" ?>>Comedia</option>
            <option value="Drama" <?= isset($genres) && array_key_exists('Drama', array_flip($genres)) ? "selected" : "" ?>>Drama</option>
            <option value="Terror" <?= isset($genres) && array_key_exists('Terror', array_flip($genres)) ? "selected" : "" ?>>Terror</option>
        </select><br><br>
        
        <!-- Tipo: Película o Serie -->
        <label for="type">Tipo:</label>
        <select name="type" id="type">
            <option value="Película" <?= $type == 'Película' ? "selected" : "" ?>>Película</option>
            <option value="Serie" <?= $type == 'Serie' ? "selected" : "" ?>>Serie</option>
        </select><br><br>
        
        <!-- Número de capítulos -->
        <label for="capitulos">Número de Capítulos:</label>
        <input type="text" id="capitulos" name="capitulos" value="<?= $capitulos ?>"><br><br>
        
        <!-- Checkbox +18 -->
        <input type="checkbox" name="plus18" <?= $plus18 ? "checked" : "" ?>> +18<br><br>
        
        <button type="submit">Guardar</button>
    </form>

    <!-- Mostrar errores si los hay -->
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>