<?php

	// Se crea la conexion a la SQL y se coloca en $coneccion
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
		exit();
	}
	//si esta logeado cargo varios datos del usuario en la variable $datosUsuario
	else {
		$datosUsuario = $sesion->datosuser();
	}
	
	
	
	$userid = $user['id'];

	
	if (!empty($_GET['result'])) {
		switch ($_GET['result']) {
			case '1':
				$result = 'Usuario eliminado con exito';
				break;
			case '2':
				$result = 'No ingresaste ninguna contraseña';
				break;
			case '3':
				$result = 'Contraseña no valida';
				break;
			case '4':
				$result = 'Hubo un error en la operacion con la BD';
				break;
			case '5':
				$result = 'Tenes viajes pendientes como conductor';
				break;
			default:
				$result = 'Error desconocido';
		}
	}
	else {
		$result = '&nbsp';
	}
	

?>

<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheets.css"/>
	<title> Ver Perfil </title>
	<style> 

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
	
	.centrado{
		margin: 70px 0; <!--centrado vertical-->
	

		width: 50%; <!--centrado horizontal muchas veces hace lo que se le canta con solo agregar un comment-->
		text-align: center; 
	}
	
		
	button{
		width: 20%;
		height: 2em;
		font-size:20px;
	}	
	
	</style>
</head>
<body>

<div id="container">
	<h2> Eliminar mi cuenta </h2>
	<div id='menucostado' style="font-size:22px">
		<p> <a href="index.php" style="text-decoration:none">Volver a Inicio</a></p>
	</div>
	<div id="datos" class="centrado">
			<p style="color:red; font-size:20px"> <?php echo $result ?> </p>
			<h2> Si queres eliminar tu cuenta necesitamos primero confirmar tu identidad</h2>
			<form action="bajausuario.php" method="POST" onsubmit="return confirm('Estas seguro que queres eliminar tu cuenta?')" >	
				<p style="font-size:20px"> Ingresa tu contraseña  <input type="password" name="pass" > 
				<input type="submit" value="Eliminar mi cuenta" style="height:2em"> </p>
			</form>
		</div>		
	</div>
	
	
<div style="clear: both;"></div>
</div>
</body>
</html>





<!--
<div style="padding: 10px; box-shadow: 0px 0px 5px 5px lightblue; width: 700px;">
</div> -->	
