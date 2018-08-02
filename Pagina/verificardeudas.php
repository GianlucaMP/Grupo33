<?php

//la idea es incluir este archivo al principio de toda pagina en la que se deba verificar si el user tiene deudas como para impedir que use la pagina

//antes de este codigo se tiene que tener abierta la conexion con la DB en $coneccion




//determino si el user tiene deudas
$tieneDeudas = false;



//si hay un user logeado realizo el chequeo (asi en caso de que no hay nadie logeado determina que no tiene deudas, y puedo ver normalmente las  paginas del sitio, aunque sin poder realizar ninguna accion
if ($logeado) {
	$user = $sesion->datosuser();
		
	
	//facilito el codigo
	$userid = $user['id'];
	
	
	//obtengo la fecha de 1 semana anterior
	date_default_timezone_set("America/Argentina/Buenos_Aires");	
	$semanaatras = date("Y-m-d", strtotime("-1 week"));
	
	
	
	echo "semanaatras vale: $semanaatras <br>"; //DEBUG
	//exit; //DEBUG
	
	
	
	//consulto por los pagos pendientes de hace mas de 1 semana				//???ESTA FALLANDO EL TEMA DE LA SEMANA...!!!???
	$sqlpagos = mysqli_query($coneccion, "SELECT pagos.* FROM pagos INNER JOIN viajes ON pagos.viajes_id = viajes.id WHERE pagos.usuarios_id=$userid AND pago='F' AND viajes.fecha < $semanaatras");  
	
	
	echo "tenes "; //DEBUG
	echo (mysqli_num_rows($sqlpagos)); //DEBUG
	echo " deudas vencidas <br>"; //DEBUG
 	
	
	
	//antes, cuando no daba 1 semana hacia:
	//$sqlpagos = mysqli_query($coneccion, "SELECT * FROM pagos WHERE usuarios_id={$user['id']} AND pago='F' ");

	if (!$sqlpagos){
		header('Location: index.php?result=4');
		exit;
	}


	if (mysqli_num_rows($sqlpagos) > 0) {
		$tieneDeudas = true;
	}

}


//$tieneDeudas = true; //DEBUG


?>