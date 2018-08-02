<?php	
	 // Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	
	
	
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	
	// se chequea si esta logeado, y si no lo esta se lo redirecciona al inicio.
	if(!$logeado){
		header('Location: index.php?result=99');
		exit;
	}
	
	$user = $sesion->datosuser();
	 
	
	
	
	
	//se chequean que se halla recibido un viaje
	if(!isset($_GET['viaje']) || empty($_GET['viaje'])) {
		header('Location: index.php?result=4');			
		exit;
	}
	
	
	$userid = $user['id'];
	$viajeid =$_GET['viaje'];
	
	
	//busco el viaje en la BD
	$sqltoken = mysqli_query($coneccion, "SELECT * FROM viajes WHERE id=$viajeid");
	if (!$sqltoken) {//si no lo puedo recibir, entonces existe o hubo un error en la operacion
		header("Location: verviaje.php?id=$viajeid&result=4");
		exit;
	}
	
		
	
	
	//el viaje NO existe, lo retorno a inicio 
	if (mysqli_num_rows($sqltoken) == 0) {
		header('Location: index.php?result=999');			
		exit;
	}

	
	//guardo el viaje en $viaje
	$viaje = mysqli_fetch_array($sqltoken);
	
	
	//busco la calificacion en la BD
	$sqlpostulacion = mysqli_query($coneccion, "SELECT * FROM postulaciones WHERE postulados_id=$userid AND viajes_id=$viajeid "); 
	
	
	
	if(!$sqlpostulacion) { //no se pudo realizar la operacion
		header("Location: verviaje.php?id=$viajeid");
		exit;
	}
	
		
	
		
	
	//si la postulacion NO existe, lo retorno a inicio 
	if (mysqli_num_rows($sqlpostulacion) == 0) {
		header('Location: index.php?result=999');			
		exit;
	}
	

	$postulacion = mysqli_fetch_array($sqlpostulacion);
	
	//determino si la postulacion estaba aceptada o no, para ver si califico negativamente
	$calificarnegativo= false;
	if ($postulacion['estado'] == 'A') {
		$calificarnegativo = true;
	}
	
	
	if ($postulacion['estado'] == 'R') {
		header("Location: verviaje.php?id=$viajeid&result=5");
		exit;
	}
	
	
	
	//elimino la postulacion
	$baja = mysqli_query($coneccion, "DELETE FROM postulaciones WHERE postulados_id=$userid AND viajes_id=$viajeid "); 
	
	
	
	
	if(!$baja) { //no se pudo eliminar la postulacion
		header("Location: verviaje.php?id=$viajeid&result=4");
		exit;
	}

	
	$descripcion = "Calificacion automatica por darse de baja de un viaje habiendo sido ya aceptado";
	
	// si tengo que calificar negativo, lo hago a nombre del user con ID "1"  que esta reservado para el sistema
	if($calificarnegativo) {
		$sqlnegativa = mysqli_query($coneccion, "INSERT INTO calificaciones (viaje_id, calificado_id, puntaje, calificador_id, descripcion) VALUES ($viajeid, $userid, 1, 1, '$descripcion') " );
		
		if(!$sqlnegativa){ //no se guardar crear la calificacion negativa
			header("Location: verviaje.php?id=$viajeid&result=4");
			exit;
		}
	}
	
	//si llegue hasta aca, todo bien retorno y aviso que salio todo bien
	header("Location: verviaje.php?id=$viajeid&result=3");
	exit;

		
	
	
	
	
	
	
	
	