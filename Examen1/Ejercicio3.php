<?php 
function rellenarOption($nombre,$valor){
    if(isset($_POST["Enviar"]) and $_POST[$nombre]==$valor){
        echo "selected='selected'";
    }
}
function rellenarInput($nombre){
    if(isset($_POST["Enviar"]) and !empty($_POST[$nombre])){
        echo "value='".$_POST[$nombre]."'";
    }
}
function rellenarRadio($valor) {
    if(isset($_POST["Enviar"])){
        if($_POST["tipoM"]==$valor){
    
            echo "checked='checked'";
        }
    }
    else{
        if($valor=="Diesel"){          
            echo "checked='checked'";
        }
    }
}
function rellenarCheck($nombre) {
    if(isset($_POST["Enviar"])){
        if(isset($_POST[$nombre])){            
            echo "checked='checked'";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Insert title here</title>
</head>
<body>
	<form action="" method="post">
		<p>
    		<label>Tipo de cliente</label>
    		<br/>
    		<select name="tipoC">
    			<option <?php rellenarOption("tipoC","Empresa")?>>Empresa</option>
    			<option <?php rellenarOption("tipoC","Particular")?>>Particular</option>
    			<option <?php rellenarOption("tipoC","Organismo Público")?>>Organismo Público</option>
    		</select>
		</p>
		<p>
    		<label>Nombre de cliente</label>
    		<br/>
    		<input type="text" name="nombreC" 
    		       <?php rellenarInput("nombreC")?> 
    		       placeholder="Nombre del cliente"/>
    		<br>
    		<label>Email de cliente</label>
    		<br/>
    		<input type="email" name="emailC"  
    		       <?php rellenarInput("emailC")?> 
    		       placeholder="email@email.com"/>
		</p>
		<p>
    		<label>Tipo de motor</label>
    		<br/>
    		<input type="radio" name="tipoM" value="Diesel" <?php rellenarRadio("Diesel")?>/>Diesel
    		<input type="radio" name="tipoM" value ="Gasolina" <?php rellenarRadio("Gasolina")?>/>Gasolina
    		<input type="radio" name="tipoM" value="Electrico" <?php rellenarRadio("Electrico")?>/>Eléctrico
    		
		</p>
		<p>
    		<label>Opciones</label>
    		<br/>
    		<input type="checkbox" name="climatizador" value="clim" <?php rellenarCheck("climatizador")?>/>Climatizador
    		<input type="checkbox" name="gps" value="gps" <?php rellenarCheck("gps")?>/>GPS
    		<input type="checkbox" name="camara" value="cam" <?php rellenarCheck("camara")?>/>Camara
		</p>
		<p>
    		<label>Modelo de Vehículo</label>
    		<br/>
    		<select name="modelo">
    			<option <?php rellenarOption("modelo","Ford Focus")?>>Ford Focus</option>
    			<option <?php rellenarOption("modelo","Citrpen C4")?>>Citrpen C4</option>
    			<option <?php rellenarOption("modelo","Seat Ibiza")?>>Seat Ibiza</option>
    		</select>
    		<label>Precio</label>
    		<input type="number" name="precio"  
    		       <?php rellenarInput("precio")?> 
    		       placeholder="10000"/>
		</p>
		<p>
    		<label>Promoción</label>
    		<br/>
    		<select name="promocion">
    			<option value="PR" <?php rellenarOption("promocion","PR")?>>Plan Renove (-2000)</option>
    			<option value="PGE"<?php rellenarOption("promocion","PGE")?>>Plan Green Energy (-2500)</option>
    			<option <?php rellenarOption("promocion","SP")?> value="SP">Sin Promoción</option>
    		</select>    		
		</p>
		<p>
			<input type="submit" name="Enviar" value="Enviar">
		</p>
	</form>
	<?php 
	if(isset($_POST["Enviar"])){
	    //Nombre precio email no pueden estar vacíos
	    if(empty($_POST["nombreC"]) or 
	        empty($_POST["precio"]) or empty($_POST["emailC"])){
	        $mensaje="Error, el nombre, el precio y el email deben estar rellenos";
	    }
	    if(($_POST["tipoM"]=="Diesel" or $_POST["tipoM"]=="Gasolina") and 
	        $_POST["promocion"]=="PGE"){
	        $mensaje="Error, si el motor es diesel o gasolina no puede ser PGE";
	    }
	    
	    if($_POST["tipoC"]=="Organismo Público" and $_POST["precio"] > "15000"){
	        $mensaje="Error, el precio no puede ser > 15000";
	    }
	    if(isset($mensaje)){
	        echo $mensaje;
	    }
	    else{
	        if($_POST["promocion"]=="SP"){
	         $importe=$_POST["precio"];   
	        }
	        elseif($_POST["promocion"]=="PR"){
	            $importe=$_POST["precio"]-2000;   
	        }
	        elseif($_POST["promocion"]=="PGE"){
	            $importe=$_POST["precio"]-2500;
	        }
	        echo "Su presupuesto será enviado a ".$_POST["emailC"].
	             ". El importe de este presupuesto es de ".$importe;
	    }
	    
	}
	?>
</body>
</html>