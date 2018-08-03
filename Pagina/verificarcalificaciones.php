<?php

//antes de este codigo se tiene que tener abierta la conexion con la DB en $coneccion




//determino si el user tiene deudas
$calificacionesPendientes = false;



//si hay un user logeado realizo el chequeo (asi en caso de que no hay nadie logeado determina que no tiene calificaciones pendientes, y puedo ver normalmente las  paginas del sitio, aunque sin poder realizar ninguna accion
if ($logeado) {
	$user = $sesion->datosuser();
		
	
	//facilito el codigo
	$userid = $user['id'];
	
	
	//obtengo la fecha de 1 mes anterior
	date_default_timezone_set("America/Argentina/Buenos_Aires");	
	$mesatras = date("Y-m-d", strtotime("-1 month"));
	
	
	
	//consulto por las calificaciones pendientes de hace mas de 1 mes
	$sqltoken = mysqli_query($coneccion, "SELECT * FROM calificaciones INNER JOIN viajes ON calificaciones.viaje_id = viajes.id WHERE calificador_id=$userid AND puntaje=-1 AND viajes.fecha < '$mesatras'");  
	

	if (!$sqltoken){
		header('Location: index.php?result=4');
		exit;
	}


	if (mysqli_num_rows($sqltoken) > 0) {
		$calificacionesPendientes = true;
	}

}


?>