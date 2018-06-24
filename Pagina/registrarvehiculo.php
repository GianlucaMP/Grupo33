<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	//$user = $sesion->datosuser();

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
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
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
	<div id='container'>
	<h2>Mi perfil</h2>
		<div id='menucostado'>
			<h2> <a href="miperfil.php" style="text-decoration:none">Volver</a></h2>
		</div>
		<div id='datos'>
			<h3>Registrando auto</h3>
			<form enctype="multipart/form-data" method="POST" action="altavehiculo.php">
				<p>Marca: <input type="text" id="marca" name="marca" ></p>
				<p>Modelo: <input type="text" id="modelo" name="modelo" ></p>
				<p>Color: <input type="text" id="color" name="color" ></p>
				<p>Plazas: <input type="number" id="plazas" name="plazas" ></p>
				<p style="font-size:small"> *Ingresa la cantidad total de plazas que posee el vehiculo (contando tambien la plaza que sera ocupada por el conductor)</p>
				<p>Patente: <input type="text" id="patente" name="patente" length="7"></p>
			<input type="submit" class="botonregistro" style="margin: 10px;" onclick="return registrovacio()" style="margin-bottom: 20px;" value="Listo!">
			<p id="error" style="color: red;"><?php echo $error?></p>
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>