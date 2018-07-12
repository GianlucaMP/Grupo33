<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	//$user = $sesion->datosuser();
	$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE id = '".$_GET['id']."'");
	$vehiculo=mysqli_fetch_array($vehiculos);
	// si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
		exit;
	}
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
	<div id="container">
	<h2>Mi perfil</h2>
		<div id="menucostado">
			<h2><a href="miperfil.php" style="text-decoration:none">Volver</a></h2>
		</div>
		<div id="datos">
			<h3>Eliminar Vehiculo</h3>
			<h3>¿Seguro que desea eliminar el vehiculo con patente:  <?php echo $vehiculo['patente']; ?>?  </h3> 
			<h3 style="font-size:22px"> Esta accion sera permanente! </h3>
			<!--???POR ALGUN MOTIVO EL TAG H3 ESPECIFICADO ACA, SE APLICA TAMBIEN SOBRE EL SIGUIENTE PARRAFO (COMO SI TAMBIEN FUERA UN H1, TENERLO EN CUENTA EN CASO DE ALGUN BUG???-->
			<p style="font-size:25px"><a style="text-decoration:none; color:red" href="bajavehiculo.php?id=<?php echo $vehiculo['id']; ?>">Si, Eliminar</a>  <a style="margin-left:25px;text-decoration:none; color:lightgreen" href="miperfil.php">No, cancelar</a></p>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
