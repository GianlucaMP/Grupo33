<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user = $sesion->datosuser();

	#$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");

	//SELECCIONO los campos que se mencionan DE la tabla de vehiculos Y la tabla de enlace DONDE los campos de enlace y de vehiculo (vehiculos_id) son iguales y DE usuarios DONDE los campos de enlace y de usuarios (usuarios.id) son iguales y que el vehiculo no este eliminado
	$vehiculos = mysqli_query ($coneccion,"SELECT vehiculos.* FROM vehiculos INNER JOIN enlace ON enlace.vehiculos_id=vehiculos.id INNER JOIN usuarios ON enlace.usuarios_id=usuarios.id WHERE usuarios.id={$user['id']}  AND enlace.eliminado='N' ");


	//chequeo si falla la consulta
	if (!$vehiculos) {
		echo "Error en la operacion con la Base de datos";
		exit;
	}

	//si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
		exit;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<title>
	</title>
	<script type="text/javascript" src="js/js_viajes.js"></script>
	<style type="text/css">
		#container{
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
		}
		#menucostado{
			float: left;
			width: 20%;
		}
		#datos{
			float: right;
			width: 79%;
		}
	</style>
</head>
<body>
	<div id='container'>
	<h2>Mi perfil</h2>
		<div id='menucostado'>
      <h2> <a style="text-decoration:none" href="miperfil.php"> Volver </h2>
			<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
		</div>
    <div align="left">
          <p style="font-size:25px	"> PROXIMAMENTE （´ヘ｀；） </p>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
