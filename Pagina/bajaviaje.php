<?php

	// Se crea la coneccion a la SQL y se coloca en $conexion
	require('dbc.php');
	$conexion = conectar();
	
	
	//chequeo la sesion
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user = $sesion->datosuser();



	if(!$logeado){
		header('Location: index.php');
		exit;
	}
	else { //si esta logeado cargo varios datos del usuario en la variable $datosUsuario
		$datosUsuario = $sesion->datosuser();
	}
	
	


	//busco el viaje en la BD
	$sqltoken = mysqli_query($conexion, "SELECT * FROM viajes WHERE id='".$_GET['id']."'");
	if (!$sqltoken) {//si no lo puedo recibir, entonces existe o hubo un error en la operacion
		header('Location: miperfil.php?result=10');
		exit;
	}
	
	//guardo el viaje en $viaje
	$viaje = mysqli_fetch_array($sqltoken);
	
	
	
	
	//si el viaje no es del user cancelo la operacion
	if (!($viaje['usuarios_id']  == $user['id'])) {
		header('Location: miperfil.php?result=9');
		exit;
	}
		
	//muevo el viaje a la tabla de viajes finalizados/cancelados
	$alta  = mysqli_query($conexion, "INSERT INTO viajes_finalizados (preciototal, origen, destino, fecha, duracion, plazas,  vehiculos_id, usuarios_id) VALUES ('".$viaje['preciototal']."', '".$viaje['origen']."', '".$viaje['destino']."', '".$viaje['fecha']."', '".$viaje['duracion']."','".$viaje['plazas']."','".$viaje['vehiculo']."','".$viaje['creador']."')");
	
	
	if(!$alta) {
		header('Location: miperfil.php?result=11');
		exit;
	}
	else { //transaccion valida, viaje registrado en lista de viajes finalizados
			
		$baja = mysqli_query($conexion, "DELETE FROM viajes WHERE id=".$_GET['id']); //delete el viaje de la tabla de viajes aun pendientes		
		if(!baja) { //no se pudo eliminar el viaje Y EN LA BD QUEDO DUPLICADO EL VIAJE ???REPARAR ESTE CASO??
			header('Location: miperfil.php?result=11');
			exit;
		}
		else {//viaje eliminado con exito
			header('Location: miperfil.php?result=8');
			exit;
		}
		
		//capaz se deberia tratar el tema de la lista de postulados y pasaeros. capaz convenga hacer algo con ellos pero por el momento creo que esta bien asi????
		
	}
	

	
	
	
?>