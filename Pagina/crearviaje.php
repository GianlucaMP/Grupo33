<?php
if (!empty($_GET['error'])) {
		switch ($_GET['error']) {
			case '1':
				$error = 'Uno o mas campos estan en blanco.';
				break;

			case '2':
				$error = 'Ha ingresado una fecha invalida';
				break;}}
else{
		$error = '&nbsp;';
	}
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user= $sesion->datosuser();
	
	// si esta logeado, se verifica que sea admin, si no lo esta, se da aviso al usuario y se bloquea el acceso.
	if(!$logeado){
		header('Location: index.php');
	}
	
	//$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");

	//SELECCIONO los campos que se mencionan DE la tabla de vehiculos Y la tabla de enlace DONDE el campo de enlace y de vehiculo son iguales. Explicacion incompleta.
	$vehiculos=mysqli_query($coneccion,"SELECT vehiculos.* FROM vehiculos INNER JOIN enlace ON enlace.vehiculos_id=vehiculos.id INNER JOIN usuarios ON enlace.usuarios_id=usuarios.id WHERE usuarios.id=".$user['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!--<script type="text/javascript" src="js/js_viajes.js"></script>-->
</head>
<body>
	<h3>Agregar nuevo viaje</h3>
		<form enctype="multipart/form-data" method="POST" action="agregar.php" >
			<p>Precio<input type="number" id="preciototal" name="preciototal" min="0" max="1000000"></p>
			<p>Origen: <input type="text" id="origen" name="origen">
			   Destino: <input type="text" id="destino" name="destino"></p>
			<p>Fecha: <input type="date" id="fecha" name="fecha">
			   Duracion: <input type="time" id="duracion" name="duracion"></p>
			<p>Vehiculo <select id="vehiculo" name="vehiculo" onchange="actualizar()">
				<?php while($listarvehiculos = mysqli_fetch_array($vehiculos)){
					echo '<option value="'.$listarvehiculos['id'].'">'.$listarvehiculos['marca'].' '.$listarvehiculos['modelo'].' | '.$listarvehiculos['plazas'].' plazas</option>';
				} ?>
			</select> 
			Plazas: <input type="number" name="plazas"></p>
			<p>Contacto: <?php echo 	$user['email']; ?></p>
			<input type="hidden" name="contacto" value="<?php echo ''.$user['email'].'' ?>">
			<input type="hidden" name="creador" value="<?php echo ''.$user['id'].'' ?>">
			<!--<textarea name="contacto" id="contacto" style="width: 450px; height: 200px;"></textarea>-->
			<input type="submit" class="botonregistro" onclick="return viaje()" style="margin-bottom: 20px;" value="Crear viaje">
			<p id="error" style="color: red;"><?php echo $error?></p>
		</form>
</body>
</html>