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
	
	
	
	echo "mesatras vale: $mesatras <br>"; //DEBUG
	//exit; //DEBUG
	
	
	
	//consulto por las calificaciones pendientes de hace mas de 1 mes				//???ESTA FALLANDO EL TEMA DE lA FECHA!!!???
	//$sqltoken = mysqli_query($coneccion, "SELECT calificaciones.* FROM calificaciones INNER JOIN viajes ON calificaciones.viaje_id = viajes.id WHERE calificador_id=$userid AND puntaje=-1 AND viajes.fecha < $mesatras");  
	
	
	//sin considerar la fecha seria
	$sqltoken = mysqli_query($coneccion, "SELECT calificaciones.* FROM calificaciones INNER JOIN viajes ON calificaciones.viaje_id = viajes.id WHERE calificador_id=$userid AND puntaje=-1");  
	
	
	
	echo "tenes "; //DEBUG
	echo (mysqli_num_rows($sqltoken)); //DEBUG
	echo " calificaciones pendientes atrasadas <br>"; //DEBUG
 	
	
	
	

	if (!$sqltoken){
		header('Location: index.php?result=4');
		exit;
	}


	if (mysqli_num_rows($sqltoken) > 0) {
		$calificacionesPendientes = true;
	}

}


?>