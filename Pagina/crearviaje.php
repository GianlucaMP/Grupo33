<?php
//Tras un intento de crear viaje vuelve aca en un estilo recursivo
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
	
	// se chequea si esta logeado, y si no lo esta se lo redirecciona al inicio.
	if(!$logeado){
		header('Location: index.php');
	}
	$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");
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
			<p>PrecioTotal:<input type="number" id="preciototal" name="preciototal" min="0" max="1000000"></p>
			<p>Origen: <input type="text" id="origen" name="origen"></p>
			<!--DEBE SER MODIFICADO POR ORIGNES Y DESTINOS MAS COMPLETOS (CON CALLES Y TODO)-->
			<p>Destino: <input type="text" id="destino" name="destino"></p>
			<p>Este viaje se realizara periodicamente <input type=checkbox id="periodico" name="periodico"> </p> 
			<!--???AGREGAR EL CALENDARIO EN CASO DE QUE SEA PERIODICO??? --> 
			<p>Fecha: <input type="date" id="fecha" name="fecha"></p>
			<p> Hora: </p> <!-- ????AGREGAR LA HORA??? -->
			<p> Duracion Estimada: </p>  <!-- ????AGREGAR LA DURACION??? -->
			
			
			<fieldset>

			<p>Vehiculo <select id="vehiculo" name="vehiculo">
				<?php while($listarvehiculos = mysqli_fetch_array($vehiculos)){
					echo '<option value="'.$listarvehiculos['id'].'">'.$listarvehiculos['marca'].' '.$listarvehiculos['modelo'].' | '.$listarvehiculos['plazas'].' plazas</option>';
				} ?>
			</select></p>
			
			<p> Plazas: <input type="number" id="plazas" name="plazas"> </p> 	<!-- ????CARGAR EL VALOR POR PHP??? -->
			<p> Modelo:<input type="text" id="modelo" name="modelo"> </p>		<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR??? -->
			<p> Marca:<input type="text" id="marca" name="marca"> </p>			<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR??? -->
			<p> Color:<input type="text" id="color" name="color"> </p>			<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR??? -->
			<p> Patente:<input type="text" id="patente" name="patente"> </p>	<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR??? -->

			</fieldset>	
			
						
			<p>Email de Contacto <input type="text" value=<?php echo $datosUsuario['email'] ?>> </p>
			<p>Telefono de Contacto: <input type="text" id="telefono" name="telefono" value=> </p> 
			<!-- 
			REGISTRAR TELEFONOS DE USER EN LA DB PARA PODER ASIGNARLO AUTOMATICAMENTE CON LA SIGUIENTE LINEA>
			<p>Telefono de Contacto: <input type="text" id="telefono" name="telefono" value=<?php echo $datosUsuario['telefono'] ?>> </p> 
			-->
						
			<input type="submit" class="botonregistro" onclick="return viaje()" style="margin-bottom: 20px;" value="Crear viaje">
			<p id="error" style="color: red;"><?php echo $error?></p>
		</form>
</body>
</html>


<!-- IMPORTANTE!!!!
FALTAN HACER TODOS LOS CHEQUEOS DE LOS NUEVOS CAMPOS DEL FORMULARIO (todos los datos del vehiculo) EN EL ARCHIVO AGREGARVIAJE.PHP-->

