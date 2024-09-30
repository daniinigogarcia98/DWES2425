<?php

require_once'Ticket.php';
class AccesoDatos{
    private $nombre;

    function __construct($n)
    {
        $this ->nombre=$n;
    }

    function insertarProducto( Ticket $t){
        try{
             //Abrir el fichero
        $fichero=fopen($this->nombre,'a+');
        //Insertar al final
        fwrite($fichero,$t->getProducto().';'.$t->getPrecioU().';'.$t->getCantidad().';'.$t->getTotal().PHP_EOL);
        //Cerrar el fichero
        }
        catch(Throwable $e){
           echo $e->getMessage();
        }
        finally{
            if(isset($fichero))
        //Cerrar el fichero
        fclose($fichero);
        }
       
    }
    function obtenerProductos($t){
        $resultado=array();
    try{
        if(file_exists($this->nombre)){
            $tmp= file($this->nombre);
            $b=4/0;
        foreach($tmp as $linea){
            $campos=explode(';',$linea);
            //Crear objeto Ticket
            $t=new Ticket($campos[0],$campos[1],$campos[2]);
            //Añadimos al array de objetos resultado
            $resultado[]=$t;
        }
        
    }
        }
        catch(Throwable $e){
           echo $e->getMessage();
        }
        return $resultado;
    }
    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}
?>