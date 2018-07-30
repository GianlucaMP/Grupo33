<?php

//la idea es incluir este archivo al principio de toda pagina en la que se deba verificar si el user tiene deudas como para impedir que use la pagina

//antes de este codigo se tiene que tener abierta la conexion con la DB en $coneccion




//determino si el user tiene deudas
$tieneDeudas = false;



//si hay un user logeado realizo el chequeo (asi en caso de que no hay nadie logeado determina que no tiene deudas, y puedo ver normalmente las  paginas del sitio, aunque sin poder realizar ninguna accion
if ($logeado) {
	$user = $sesion->datosuser();
		
	
	//???PENDIENTE???
	//???ES probable que haya que agregarle un chequeo por la fecha del viaje con pago pendiente, para poder asi dar una semana o un tiempo X para pagar antes de impedir el uso de la pagina???
	
	$sqlpagos = mysqli_query($coneccion, "SELECT * FROM pagos WHERE usuarios_id={$user['id']} AND pago='F' ");

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