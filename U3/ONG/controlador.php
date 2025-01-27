<?php
// Se incluye el archivo 'Modelo.php', que probablemente contiene clases y métodos para interactuar con la base de datos.
require_once 'Modelo.php';

// Inicia una sesión para gestionar datos a lo largo de las peticiones.
session_start();

// Crea una instancia de la clase Modelo para acceder a las funcionalidades de la base de datos.
$bd = new Modelo();

// Verifica si la conexión con la base de datos fue exitosa.
if ($bd->getConexion() == null) {
    // Si no hay conexión, se muestra un mensaje de error.
    $mensaje = 'Error, no hay conexión con la BD';
}

// Comienza a verificar los formularios enviados a través de POST.

if (isset($_POST['seleccionarC'])) {
    // Si se recibe un formulario para seleccionar un centro, se obtiene el centro correspondiente.
    $c = $bd->seleccionarCentro($_POST['centro']);
    
    // Si el centro existe y está activo, se guarda en la sesión.
    if ($c != null and $c->getActivo()) {
        $_SESSION['centro'] = $c;
    } else {
        // Si el centro no existe o no está activo, se muestra un mensaje de error.
        $mensaje = 'Error, no existe el centro';
    }
} elseif (isset($_POST['cambiarC'])) {
    // Si se recibe un formulario para cambiar el centro, se destruye la sesión y se redirige al usuario.
    session_destroy();
    header('location:index.php');
} elseif (isset($_POST['asignarS'])) {
    // Si se recibe un formulario para asignar un servicio, se valida que no estén vacíos los campos.
    if (empty($_POST['beneficiario']) or empty($_POST['servicio'])) {
        $mensaje = 'Error, el beneficiario y el servicio no pueden estar vacíos';
    } else {
        // Se obtiene el beneficiario desde la base de datos.
        $b = $bd->obtenerBeneficiario($_POST['beneficiario']);
        
        // Verifica si el beneficiario pertenece al centro actual en sesión.
        if ($b->getCentro() != $_SESSION['centro']->getId()) {
            $mensaje = 'Error, el beneficiario no corresponde al centro ' . $_SESSION['centro']->getNombre();
        } else {
            // Verifica si el beneficiario ya tiene asignado el servicio hoy.
            if (!$bd->obtenerServicioHoy($_POST['beneficiario'], $_POST['servicio'])) {
                // Si no se ha asignado el servicio, se crea un objeto ServicioUsuario.
                $su = new ServicioUsuario();
                $su->setServicio($_POST['servicio']);
                $su->setBeneficiario($_POST['beneficiario']);
                
                // Asigna el servicio a través de la base de datos.
                if ($bd->asginarServicio($su)) {
                    $mensaje = 'Servicio Asignado';
                } else {
                    // Si hay un error al asignar el servicio, se muestra un mensaje de error.
                    $mensaje = 'Error, no se ha asignado el servicio';
                }
            } else {
                // Si el servicio ya fue dado hoy, se muestra un mensaje de error.
                $mensaje = 'Error, ya se ha dado el servicio hoy';
            }
        }
    }
} elseif (isset($_POST['borrarB'])) {
    // Si se recibe un formulario para borrar un beneficiario, se valida que el campo no esté vacío.
    if (empty($_POST['beneficiario'])) {
        $mensaje = 'Error, el beneficiario no pueden estar vacíos';
    } else {
        // Si se encuentra el beneficiario, se procede a borrarlo de la base de datos.
        if ($bd->borrarBeneficiario($_POST['beneficiario'])) {
            $mensaje = 'Se ha borrado el beneficiario y sus servicios prestados';
        } else {
            // Si ocurre un error al borrar, se muestra un mensaje de error.
            $mensaje = 'Se ha producido un error al borrar el beneficiario';
        }
    }
}

// Si se recibe un formulario para ver los servicios prestados de un beneficiario.
if (isset($_POST['verSP'])) {
    // Si el beneficiario no está vacío, se obtienen los servicios prestados.
    if (empty($_POST['beneficiario'])) {
        $mensaje = 'Error, el beneficiario no pueden estar vacíos';
    } else {
        $serviciosP = $bd->obtenerServiciosPrestados($_POST['beneficiario']);
    }
}
?>
