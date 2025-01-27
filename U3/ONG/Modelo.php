<?php
// Incluyendo las clases necesarias
require_once 'Centro.php';
require_once 'Beneficiario.php';
require_once 'Servicio.php';
require_once 'ServicioUsuario.php';

class Modelo
{
    // Propiedad para mantener la conexión a la base de datos
    private $conexion = null;

    // Constructor para establecer la conexión a la base de datos
    function __construct()
    {
        try {
            // Se crea una nueva instancia de PDO para conectar con la base de datos
            $this->conexion = new PDO("mysql:host=localhost;port=3306;dbname=ong", 'root', 'root');
        } catch (\Throwable $th) {
            // En caso de error en la conexión, se muestra el mensaje de error
            echo $th->getMessage();
        }
    }

    // Método para obtener todos los centros
    function obtenerCentros()
    {
        $resultado = array();
        try {
            // Ejecuta la consulta para obtener todos los centros
            $consulta = $this->conexion->query("SELECT * FROM centros");
            // Itera sobre los resultados y crea un objeto Centro por cada fila
            while ($fila = $consulta->fetch()) {
                $resultado[] = new Centro($fila['id'], $fila['nombre'], $fila['localidad'], $fila['activo']);
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }
        return $resultado;
    }

    // Método para obtener todos los servicios
    function obtenerServicios()
    {
        $resultado = array();
        try {
            // Ejecuta la consulta para obtener todos los servicios
            $consulta = $this->conexion->query("SELECT * FROM servicios");
            // Itera sobre los resultados y crea un objeto Servicio por cada fila
            while ($fila = $consulta->fetch()) {
                $resultado[] = new Servicio($fila['id'], $fila['nombre_servicio'], $fila['descripcion']);
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }
        return $resultado;
    }

    // Método para obtener un centro específico por su ID
    function seleccionarCentro($id)
    {
        $resultado = null;
        try {
            // Prepara la consulta para obtener un centro por su ID
            $consulta = $this->conexion->prepare('SELECT * from centros where id = ?');
            $params = array($id);
            // Ejecuta la consulta y obtiene el resultado
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    // Si se encuentra el centro, se crea un objeto Centro
                    $resultado = new Centro($fila['id'], $fila['nombre'], $fila['localidad'], $fila['activo']);
                }
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }
        return $resultado;
    }

    // Método para obtener todos los beneficiarios de un centro específico
    function obtenerBeneficiarios($centro)
    {
        $resultado = array();
        try {
            // Prepara la consulta para obtener beneficiarios de un centro
            $consulta = $this->conexion->prepare('SELECT * from beneficiarios where centro = ? order by nombre');
            $params = array($centro);
            // Ejecuta la consulta y obtiene los beneficiarios
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    // Por cada beneficiario, se crea un objeto Beneficiario
                    $resultado[] = new Beneficiario($fila['id'], $fila['dni'], $fila['nombre'], $fila['centro'], $fila['fechaN'], $fila['direccion']);
                }
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }

        return $resultado;
    }

    // Método para obtener un beneficiario específico por su ID
    function obtenerBeneficiario($id)
    {
        $resultado = null;
        try {
            // Prepara la consulta para obtener un beneficiario por su ID
            $consulta = $this->conexion->prepare('SELECT * from beneficiarios where id = ?');
            $params = array($id);
            // Ejecuta la consulta y obtiene el resultado
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    // Si se encuentra el beneficiario, se crea un objeto Beneficiario
                    $resultado = new Beneficiario($fila['id'], $fila['dni'], $fila['nombre'], $fila['centro'], $fila['fechaN'], $fila['direccion']);
                }
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }
        return $resultado;
    }

    // Método para asignar un servicio a un beneficiario
    function asginarServicio($su)
    {
        $resultado = false;
        try {
            // Prepara la consulta para insertar el servicio asignado al beneficiario
            $consulta = $this->conexion->prepare('insert into servicio_usuario values(null, ?,?,curdate())');
            $params = array($su->getBeneficiario(), $su->getServicio());
            // Ejecuta la consulta y verifica que la inserción se haya realizado correctamente
            if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                $resultado = true;
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }
        return $resultado;
    }

    // Método para verificar si un beneficiario tiene un servicio asignado para hoy
    function obtenerServicioHoy($b, $s)
    {
        $resultado = false;
        try {
            // Prepara la consulta para verificar si el servicio fue asignado hoy
            $consulta = $this->conexion->prepare('SELECT * from servicio_usuario where servicio = ? and beneficiario=? and fecha=curdate()');
            $params = array($s, $b);
            // Ejecuta la consulta y verifica si existe una entrada para el servicio hoy
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    $resultado = true;
                }
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }
        return $resultado;
    }

    // Método para obtener todos los servicios prestados a un beneficiario
    function obtenerServiciosPrestados($b)
    {
        $resultado = array();
        try {
            // Prepara la consulta para obtener los servicios prestados al beneficiario
            $consulta = $this->conexion->prepare('SELECT * from servicio_usuario su 
                                                            inner join servicios s on s.id= su.servicio 
                                                            inner join beneficiarios b on b.id=su.beneficiario
                                                            where beneficiario=? order by fecha desc');
            $params = array($b);
            // Ejecuta la consulta y obtiene los servicios prestados
            if ($consulta->execute($params)) {
                while ($fila = $consulta->fetch()) {
                    // Por cada servicio prestado, se crea un objeto ServicioUsuario
                    $resultado[] = new ServicioUsuario(
                        $fila['0'],
                        new Beneficiario($fila['beneficiario'], $fila['dni'], $fila['nombre'], $fila['centro'], $fila['fechaN'], $fila['direccion']),
                        new Servicio($fila['servicio'], $fila['nombre_servicio'], $fila['descripcion']),
                        $fila['fecha']
                    );
                }
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }

        return $resultado;
    }

    // Método para borrar un beneficiario (incluyendo sus servicios asignados)
    function borrarBeneficiario($b)
    {
        $resultado = false;
        try {
            // Inicia una transacción para garantizar la integridad de las operaciones
            $this->conexion->beginTransaction();
            // Elimina primero las asignaciones de servicio del beneficiario
            $consulta = $this->conexion->prepare('DELETE from servicio_usuario where beneficiario=?');
            $params = array($b);
            if ($consulta->execute($params)) {
                // Si se eliminan correctamente, se elimina el beneficiario
                $consulta = $this->conexion->prepare('DELETE from beneficiarios where id = ?');
                $params = array($b);
                if ($consulta->execute($params) and $consulta->rowCount() == 1) {
                    // Si ambas eliminaciones son exitosas, se confirma la transacción
                    $this->conexion->commit();
                    $resultado = true;
                } else {
                    // Si algo falla, se revierte la transacción
                    $this->conexion->rollBack();
                }
            }
        } catch (\Throwable $th) {
            // Si ocurre un error, se revierte la transacción
            $this->conexion->rollBack();
            echo $th->getMessage();
        }
        return $resultado;
    }

    // Método para obtener información específica de un centro usando un procedimiento almacenado
    function obtenerInfoCentro($centro)
    {
        $resultado = null;
        try {
            // Prepara la consulta para ejecutar el procedimiento almacenado 'infoCentro'
            $consulta = $this->conexion->prepare('CALL infoCentro(?)');
            $params = array($centro);
            if ($consulta->execute($params)) {
                if ($fila = $consulta->fetch()) {
                    // Si se encuentra información, se retorna en un array
                    $resultado = array($fila[0], $fila[1]);
                }
            }
        } catch (\Throwable $th) {
            // En caso de error, se muestra el mensaje de error
            echo $th->getMessage();
        }

        return $resultado;
    }

    // Getter para la conexión a la base de datos
    public function getConexion()
    {
        return $this->conexion;
    }

    // Setter para establecer la conexión a la base de datos
    public function setConexion($conexion)
    {
        $this->conexion = $conexion;

        return $this;
    }
}
