<?php 
    // Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();

	if(!$logeado) { 
		header('Location: index.php');
		exit;
	}
	
	
	//determino si el user tiene deudas pendientes, para ver si mostrar el link a la pagina de pagos
	//??? SE DEBE TESTEAR QUE FUNCIONE COMO SE ESPERA???
	require 'verificardeudas.php';
	
	
	
	if ($tieneDeudas) {
		header("Location: verviaje.php?id={$_POST['viaje_id']}&result=6");
		exit;
		
	}
	
	
	
	//determino si el user tiene calificaciones pendientes con antiguedad mayor a 30 dias
	//??? SE DEBE TESTEAR QUE FUNCIONE COMO SE ESPERA???
	require 'verificarcalificaciones.php';
	

	if ($calificacionesPendientes) {
		header("Location: verviaje.php?id={$_POST['viaje_id']}&result=7");
		exit;
		
	}
	
	
		
	$sql = mysqli_query($coneccion,"INSERT INTO postulaciones (viajes_id,postulados_id,estado) VALUES ({$_POST['viaje_id']},{$_SESSION['id']}, 'P' )");

	if($sql) {
		header("Location: verviaje.php?id={$_POST['viaje_id']}&result=1");
		exit;
	}
	else { 
	header("Location: verviaje.php?id={$_POST['viaje_id']}&result=2");
		exit;
	}
?>	