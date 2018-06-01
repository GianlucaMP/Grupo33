<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	//$user = $sesion->datosuser();
	$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE id=".$_GET['id']." ORDER BY id");
	$vehiculo=mysqli_fetch_array($vehiculos);
	// si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
	}
	if (!empty($_GET['error'])) {//////////////////////////////////
		switch ($_GET['error']) {/////////////////////////
			 case '1'://///////////////////////////
				$error = 'La patente que ingreso ya esta registrada';////////////////////////////
				break;}}else{////////////////////////////////
					$error = '&nbsp;';/////////////////////
				}/////////////////////
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="js/js_viajes.js"></script>
	<style type="text/css">
		#container{
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
		}
		#menucostado{
			float: left;
			width: 40%;
		}
		#datos{
			float: right;
			width: 59%;
		}
	</style>
</head>
<body>
	<div id="container">
	<h3>Mi perfil</h3>
		<div id="menucostado">
			<p><a href="miperfil.php">Volver</a></p>
		</div>
		<div id="datos">
			<h4>Modificar Vehiculo</h3>
			<form enctype="multipart/form-data" method="POST" action="modificacion.php?id=<?php echo $_GET['id'];?>">
				<p>Marca: <input type="text" id="marca" name="marca" value="<?php echo $vehiculo['marca']; ?>"></p>
				<p>Modelo: <input type="text" id="modelo" name="modelo" value="<?php echo $vehiculo['modelo']; ?>"></p>
				<p>Color: <input type="text" id="color" name="color" value="<?php echo $vehiculo['color']; ?>"></p>
				<p>Plazas: <input type="number" id="plazas" name="plazas" value="<?php echo $vehiculo['plazas']; ?>"></p>
				<p>Patente: <input type="text" id="patente" name="patente" length="7" value="<?php echo $vehiculo['patente']; ?>"></p>
			<input type="submit" class="botonregistro" style="margin: 10px;" onclick="return registrovacio()" style="margin-bottom: 20px;" value="Listo!">
			<p id="error" style="color: red;"><?php echo $error?></p>///////////////////////////////////////////////////////
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
