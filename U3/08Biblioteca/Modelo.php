<?php
class Modelo
{
    private $conexion=null;

    public function __construct()
    {
        try {
            $config = $this->obtenerDatos();
            if ($config == null) {
                throw new Exception('No se pudo cargar la configuración');

                $this->conexion = new PDO('mysql:host=' 
                . $config['urlBD'], ';port=' 
                . $config['puerto'] . ';dbname=' 
                . $config['nombreBD'],'usuario='
                . $config['usDB'].';password='
                , $config['psUS']);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    private function obtenerDatos()
    {
        $resultado = array();
        if (file_exists('config')) {
            $datosF = file('config', FILE_IGNORE_NEW_LINES);
            foreach ($datosF as $linea) {
                $campos = explode('=', $linea);
                $resultado[$campos[0]] = $campos[1];
            }
        } else {
            return null;
        }
    }

    /**
     * Get the value of conexion
     */ 
    public function getConexion()
    {
        return $this->conexion;
    }

    /**
     * Set the value of conexion
     *
     * @return  self
     */ 
    public function setConexion($conexion)
    {
        $this->conexion = $conexion;

        return $this;
    }
}
