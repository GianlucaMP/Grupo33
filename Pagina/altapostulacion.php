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
		
	$sql = mysqli_query($coneccion,"INSERT INTO postulaciones (viajes_id,postulados_id,estado) VALUES ('".$_POST['viaje_id']."','".$_SESSION['id']."', 'P' )");

	if($sql) {
		header('Location: verviaje.php?id="'.$_POST['viaje_id'].'"&result=1');
		exit;
	}
	else { 
		header('Location: verviaje.php?id="'.$_POST['viaje_id'].'"&result=2');
		exit;
	}
?>	