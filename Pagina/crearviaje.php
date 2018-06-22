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
	//si esta logeado cargo varios datos del usuario en la variable $datosUsuario ???puede que ya halla una variable para esto, en ese caso modificarlo???
	else {
		$datosUsuario = $sesion->datosuser();
	}
	
	$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<title></title>
	<!--<script type="text/javascript" src="js/js_viajes.js"></script>-->
</head>
<body>
	<h3>Agregar nuevo viaje</h3>
		<form enctype="multipart/form-data" method="POST" action="agregar.php" >
			<p>PrecioTotal:<input type="number" id="preciototal" name="preciototal" min="0" max="1000000"></p>
			<p>Origen: <input type="text" id="origen" name="origen"></p>
			<p>Destino: <input type="text" id="destino" name="destino"></p>
			<p>Este viaje se realizara periodicamente <input type=checkbox id="periodico" name="periodico" onclick=intercambiarOcasionalPeriodico()> </p> 
			
			<div id="formularioOcasional">
			<p>Fecha: <input type="date" id="fecha" name="fecha"></p>
			</div>
			<div id="formularioPeriodico" style="display:none">
			<p> IMAGINATE QUE SOY UN CALENDARIO</p>
			<!--???AGREGAR EL CALENDARIO EN CASO DE QUE SEA PERIODICO??? --> 
			</div>
			
			
			<p> Hora: </p> <!-- ????AGREGAR LA HORA??? -->
			<p> Duracion Estimada: </p>  <!-- ????AGREGAR LA DURACION??? -->
			
			
			<fieldset>

			<p>Vehiculo <select id="vehiculo" name="vehiculo">
				<?php while($listarvehiculos = mysqli_fetch_array($vehiculos)){
					//???Sugiero mostrar solo marca modelo y patente del vehiculo en la version final. Aunque en la version de prueba dejarlo asi, ver si se puede hacer una compilacion condiccional???
					echo '<option value="'.$listarvehiculos['id'].'">'.$listarvehiculos['marca'].' '.$listarvehiculos['modelo'].' | '.$listarvehiculos['plazas'].' plazas</option>';
				} ?>
			</select></p>
			
			<p> Plazas: <input type="number" id="plazas" name="plazas"> </p> 	<!-- ????CARGAR EL VALOR POR PHP??? -->
			<p> Modelo:<input type="text" id="modelo" name="modelo"> </p>		<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR??? -->
			<p> Marca:<input type="text" id="marca" name="marca"> </p>			<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR??? -->
			<p> Color:<input type="text" id="color" name="color"> </p>			<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR??? -->
			<p> Patente:<input type="text" id="patente" name="patente"> </p>	<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR??? -->

			</fieldset>	
			
						
			<p>Email de Contacto: <input type="text" value=<?php echo $datosUsuario['email'] ?>> </p>
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

<script>

function intercambiarOcasionalPeriodico() {
    var x = document.getElementById("formularioOcasional");
    var y = document.getElementById("formularioPeriodico");
    if (x.style.display === "none") {
        x.style.display = "block";
		y.style.display = "none";
    } else {
        x.style.display = "none";
		y.style.display = "block";
    }
}
</script>


<!-- IMPORTANTE!!!!

FALTAN HACER TODOS LOS CHEQUEOS DE LOS NUEVOS CAMPOS DEL FORMULARIO (todos los datos del vehiculo) EN EL ARCHIVO AGREGARVIAJE.PHP
FALTA AGREGAR EL CALENDARIO PARA VIAJES PERIODICOS-->
