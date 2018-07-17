<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user = $sesion->datosuser();
	
	
	// si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
		exit;
	}
	
	
	// si no hay una ID seteada se sigue
	if(!isset($_GET['id'])){
		header('Location: miperfil.php?result=4');
		exit;		
	}
	
	
	//se chequea que el vehiculo realmente pertenezca al user que lo quiere borrar 
	$sql4 =  mysqli_query($coneccion, "SELECT * FROM enlace WHERE vehiculos_id={$_GET['id']} AND usuarios_id={$user['id']} ");	
	if (mysqli_num_rows($sql4) == 0) {
		header('Location: miperfil.php?result=42');
		exit;		
	}
	
	
	//???MIENTRAS NO SE UTILICE LA TABLA VIAJES FINALIZADOS, HAY QUE TESTEAR SI O SI QUE LA FECHA SEA >= fecha actual + un changui capaz para darle tiempo a que se muevan de tablas los viajes
	
	//se chequea que el vehiculo no tenga viajes pendientes	
	$fechaactual = Date("Y-m-d");
	$sql5 =  mysqli_query($coneccion, "SELECT * FROM viajes WHERE vehiculos_id={$_GET['id']}");
	while ($viajetemp = mysqli_fetch_array($sql5)) {
		if ($viajetemp['fecha'] > $fechaactual) {
			header('Location: miperfil.php?result=41');
			exit;	
		}
	}



	//se "elimina" el vehiculo mediante marcar su enlace como borrado
	$sql9 =  mysqli_query($coneccion, "UPDATE enlace SET eliminado='S' WHERE vehiculos_id={$_GET['id']} AND usuarios_id={$user['id']}");
	if(!$sql9) { //no se pudo borrar el vehiculo
		header('Location: miperfil.php?result=4');
		exit;
	}
	else { //vehiculo borrado con exito
		header('Location: miperfil.php?result=3');
		exit;
	}
		
?>




