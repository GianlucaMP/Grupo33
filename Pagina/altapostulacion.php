<?php 
    // Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();

	if(!$logeado) header('Location: index.php');
	
	$sql = mysqli_query($coneccion,"INSERT INTO postulaciones (viajes_id,postulados_id) VALUES ('".$_POST['viaje_id']."','".$_SESSION['id']."')");

	if($sql) {
		 header('Location: verviaje.php?id="'.$_POST['viaje_id'].'"&result=1');
	}
	else { 
		header('Location: verviaje.php?id="'.$_POST['viaje_id'].'"&result=2');
	}
?>	