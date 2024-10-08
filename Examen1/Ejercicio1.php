<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Insert title here</title>
</head>
<body>
	<form action="Ejercicio1_datos.php" method="post">
		<p>
    		<label>Tipo de cliente</label>
    		<br/>
    		<select name="tipoC">
    			<option selected="selected">Empresa</option>
    			<option>Particular</option>
    			<option>Organismo Público</option>
    		</select>
		</p>
		<p>
    		<label>Nombre de cliente</label>
    		<br/>
    		<input type="text" name="nombreC" placeholder="Nombre del cliente"/>
    		<br>
    		<label>Email de cliente</label>
    		<br/>
    		<input type="email" name="emailC" placeholder="email@email.com"/>
		</p>
		<p>
    		<label>Tipo de motor</label>
    		<br/>
    		<input type="radio" name="tipoM" value="Diesel" checked="checked"/>Diesel
    		<input type="radio" name="tipoM" value ="Gasolina"/>Gasolina
    		<input type="radio" name="tipoM" value="Electrico"/>Eléctrico
    		
		</p>
		<p>
    		<label>Opciones</label>
    		<br/>
    		<input type="checkbox" name="climatizador" value="clim"/>Climatizador
    		<input type="checkbox" name="gps" value="gps"/>GPS
    		<input type="checkbox" name="camara" value="cam"/>Camara
		</p>
		<p>
    		<label>Modelo de Vehículo</label>
    		<br/>
    		<select name="modelo">
    			<option selected="selected">Ford Focus</option>
    			<option>Citrpen C4</option>
    			<option>Seat Ibiza</option>
    		</select>
    		<label>Precio</label>
    		<input type="number" name="precio" placeholder="10000"/>
		</p>
		<p>
    		<label>Promoción</label>
    		<br/>
    		<select name="promocion">
    			<option value="PR">Plan Renove (-2000)</option>
    			<option value="PGE">Plan Green Energy (-2500)</option>
    			<option selected="selected" value="SP">Sin Promoción</option>
    		</select>    		
		</p>
		<p>
			<input type="submit" name="Enviar" value="Enviar">
		</p>
	</form>
	
</body>
</html>