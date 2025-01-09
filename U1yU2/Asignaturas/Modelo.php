<?php
require_once 'Nota.php';

class Modelo{
    private $nombreFN='notas.dat', $nombreFA='asig.dat';

    function __construct() {
          // Crear archivo notas.dat si no existe
          if (!file_exists($this->nombreFN)) {
            touch($this->nombreFN);
        }
    }

    function crearNota(Nota $n){
        try {
            // Crear archivo notas.dat si no existe
            if (!file_exists($this->nombreFN)) {
                touch($this->nombreFN);
            }
    
            if (!file_exists($this->nombreFN)) {
                throw new Exception('El archivo no existe');
            }
            if (!is_writable($this->nombreFN)) {
                chmod($this->nombreFN, 0777);
            }
            $fichero = fopen($this->nombreFN, 'a');
            if ($fichero === false) {
                throw new Exception('No se puede abrir el fichero');
            }
            fwrite($fichero, $n->getNota()."\n");
            fclose($fichero);
        } catch (Throwable $e) {
            echo ('Error al escribir en el fichero: ' . $e->getMessage());
        }
    }
    function obtenerNotas(){
        try {
            return file_get_contents($this->nombreFN);
        } catch (Throwable $e) {
            echo $e->getMessage();

        }
    }

    function obtenerAsignaturas(){
        try {
            $archivo = fopen($this->nombreFA, 'r');
            $asignaturas = array();
            while(!feof($archivo)){
                $asignatura = fgets($archivo);
                $asignatura = trim($asignatura);
                array_push($asignaturas, $asignatura);
            }
            fclose($archivo);
            return $asignaturas;
        } catch (Throwable $e) {
            echo $e->getMessage();

        }
    }
    function crearArchivoNotas($contenido) {
        
        try {
            $fichero = fopen($this->nombreFN, 'w');
            if ($fichero === false) {
                echo ('No se puede abrir el fichero');
            }
            fwrite($fichero, $contenido);
            fclose($fichero);
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
}
?>
