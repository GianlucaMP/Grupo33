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
	}
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
			<h3>Eliminar Vehiculo</h3>
			<p>¿Seguro que desea eliminar el vehiculo con patente:  <?php echo $vehiculo['patente']; ?> ?</p>  	<!-- //////////////////// -->
			<p>Esta acción es permanente</p>
			<p><a style="color:green" href="eliminar.php?id=<?php echo $vehiculo['id']; ?>">Si, Eliminar</a> | <a style="color: red;" href="miperfil.php">No, volver</a></p>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
