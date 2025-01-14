<?php
// Leer archivo de texto donde se guardan las películas
$peliculas = file('peliculas.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas Registradas</title>
</head>
<body>
    <h2>Listado de Películas Registradas</h2>

    <!-- Mostrar la tabla con las películas -->
    <table border="1">
        <tr>
            <th>Título</th>
            <th>Fecha Registro</th>
            <th>Género</th>
            <th>Tipo</th>
            <th>Capítulos</th>
        </tr>
        
        <?php if (empty($peliculas)): ?>
            <tr>
                <td colspan="5">No hay películas registradas.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($peliculas as $pelicula): ?>
                <?php list($titulo, $fechaRegistro, $generos, $tipo, $capitulos) = explode(';', $pelicula); ?>
                <tr>
                    <td><?= $titulo ?></td>
                    <td><?= $fechaRegistro ?></td>
                    <td><?= $generos ?></td>
                    <td><?= $tipo ?></td>
                    <td><?= $capitulos ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>
