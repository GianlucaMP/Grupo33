<?php 
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	
	// si esta logeado, se verifica que sea admin, si no lo esta, se da aviso al usuario y se bloquea el acceso.
	if(!$logeado){
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="js/js_viajes.js"></script>
</head>
<body>
	<h3>Agregar nuevo viaje</h3>
		<form enctype="multipart/form-data" method="POST" action="agregar.php" >
			<p>PrecioTotal <input type="number" id="preciototal" name="preciototal" min="0" max="1000000"></p>
			<p>Origen: <input type="text" id="origen" name="origen"></p>
			<p>Destino: <input type="text" id="destino" name="destino"></p>
			<p>Fecha: <input type="date" id="fecha" name="fecha"></p>
			<p>Vehiculo <input type="text" id="vehiculo" name="vehiculo"> </p>
			<p>Contacto:</p>
			<textarea name="contacto" id="contacto" style="width: 450px; height: 200px;"></textarea>
			
			<input type="submit" class="botonregistro" onclick="return viaje()" style="margin-bottom: 20px;" value="Crear viaje">
		</form>
</body>
</html>