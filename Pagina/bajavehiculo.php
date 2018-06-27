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
	// si hay una ID seteada se sigue, si no, se activa $err
	if(!isset($_GET['id'])){
		$err = true;
	}else{
		#Primero se elimina el enlace entre el usuario y el vehiculo
		$mienlace = mysqli_query($coneccion,"DELETE FROM enlace WHERE usuarios_id='".$_SESSION['id']."' AND vehiculos_id='".$_GET['id']."' ");
		#Se verifica que la query haya sido exitosa, CC error desconocido
		if(!$mienlace) header('Location: miperfil.php?result=default');
		#Se verifica la cantidad de enlaces restantes del vehiculo. 
		$enlaces = mysqli_query($coneccion,"SELECT * FROM enlace WHERE vehiculos_id=".$_GET['id']);
		if (mysqli_num_rows($enlaces) < 1) { #Si enlaces del vehiculo es menor a 1, el vehiculo no tiene mas dueños
			#En ese caso se lo elimina definitivamente de la BD
			$sql = $comentar = mysqli_query($coneccion, "DELETE FROM vehiculos WHERE id=".$_GET['id']);
		}
		//$sql = $comentar = mysqli_query($coneccion, "DELETE FROM vehiculos WHERE id=".$_GET['id']);
		if($mienlace||$sql) header('Location: miperfil.php?result=3');
		else header('Location: miperfil.php?result=4');
	}
?>
<!--<!DOCTYPE html>
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
			<p> <?php// echo $mensaje ?>
		</p>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>-->
