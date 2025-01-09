<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Insert title here</title>
</head>
<body>
	<?php
	if(isset($_POST["Enviar"])){
	    //Crear array con datos
	    $datos = array();
	    $datos["TipoCliente"]=$_POST["tipoC"];
	    $datos["NombreCliente"]=$_POST["nombreC"];
	    $datos["Email"]=$_POST["emailC"];
	    $datos["Motor"]=$_POST["tipoM"];
	    if(isset($_POST["climatizador"])){
	        $datos["Climatizador"]=$_POST["climatizador"];
	    }
	    if(isset($_POST["gps"])){
	        $datos["GPS"]=$_POST["gps"];
	    }
	    if(isset($_POST["camara"])){
	        $datos["Camara"]=$_POST["camara"];
	    }
	    $datos["Coche"]=$_POST["modelo"];
	    $datos["Precio"]=$_POST["precio"];
	    $datos["Promocion"]=$_POST["promocion"];
	    
	    //Mostrar el array en la tabla
	    ?>
	    <table border="1">
	    	<?php 
	    	foreach ($datos as $clave=>$valor){
	    	     echo "<tr>
                            <td>$clave</td>
                            <td>$valor</td>
                       </tr>";
	    	}
	    	?>
	    </table>
	    <?php 
	}
	else{
	    echo "<h2>Debes rellenar el formulario</h2>";
	}
	?>
	
</body>
</html>