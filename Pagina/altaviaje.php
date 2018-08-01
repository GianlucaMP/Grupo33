<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	
	
	//chequeo la sesion, ya que necesito enviar al user actual a la BD como conductor del viaje
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user= $sesion->datosuser();
	
	//guardo los datos recibidos en variables de sesion para poder conservarlos en caso de error (antes de todos los header, pero despues del chequeo de si esta logeado)
	$_SESSION['flagRegistro'] = $_POST['flagRegistro'];
	$_SESSION['preciototal'] = $_POST['preciototal'];
	$_SESSION['origen'] = $_POST['origen'];
	$_SESSION['destino'] = $_POST['destino'];
	$_SESSION['fecha'] = $_POST['fecha'];
	$_SESSION['horario'] = $_POST['horario'];
	$_SESSION['duracion'] = $_POST['duracion'];
	$_SESSION['vehiculo'] = $_POST['vehiculo'];
	$_SESSION['plazas'] = $_POST['plazas'];
	

	
	// se chequea si esta logeado, y si no lo esta se lo redirecciona al inicio.
	if(!$logeado){
		header('Location: index.php');
		exit;
	}
	
	//chequeo que los parametros recibidos no esten vacios
	if(!isset($_POST['preciototal']) || empty($_POST['preciototal'])) {
		header('Location: crearviaje.php?error=1');			
		exit;
	}
	if(!isset($_POST['origen']) || empty($_POST['origen'])) {
		header('Location: crearviaje.php?error=2');
		exit;
	}
	if(!isset($_POST['destino']) || empty($_POST['destino'])) {
		header('Location: crearviaje.php?error=3');
		exit;
	}
	if(!isset($_POST['horario']) || empty($_POST['horario'])) {
		header('Location: crearviaje.php?error=5');
		exit;
	}
	if(!isset($_POST['duracion']) || empty($_POST['duracion'])) {
		header('Location: crearviaje.php?error=6');
		exit;
	}	
	if(!isset($_POST['plazas']) || empty($_POST['plazas'])) {
		header('Location: crearviaje.php?error=8');
		exit;
	}
	if(!isset($_POST['vehiculo']) || empty($_POST['vehiculo'])) {
		header('Location: crearviaje.php?error=7');
		exit;
	}

	//chequeo por que las plazas no superen el maximo
	$sqltoken = mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE id = '".$_POST['vehiculo']."'");
	if (!$sqltoken) {																		
		header('Location: crearviaje.php?error=10');	
		exit;
	}
	$vehiculo = mysqli_fetch_array($sqltoken);		

	if($_POST['plazas'] > ($vehiculo['plazas']) - 1 ) {
		header('Location: crearviaje.php?error=9');
		exit;
	}
	
	
	//chequeo que el vehiculo no este marcado como eliminado
	$sql4 = mysqli_query($coneccion, "SELECT * FROM enlace WHERE vehiculos_id={$_POST['vehiculo']} AND usuarios_id={$user['id']}");
	if (!$sql4) {																	
		header('Location: crearviaje.php?error=10');
		exit;
	}
	$enlace = mysqli_fetch_array($sql4);
	if ($enlace['eliminado'] =='S') {//el vehiculo elegido esta eliminado y no puede usarse
		header('Location: crearviaje.php?error=22');
		exit;	
	}
	
	//codigo encargado de verificar la consistencia de las fechas y disponibilidad del vehiculo para viajes ocasionales y periodicos		
	require('chequeos.php');

	//creo un pago en la BD asociado a este viaje 
	$sqlpago = mysqli_query($coneccion, "INSERT INTO pagos (viajes_id, usuarios_id, pago) VALUES ($idViaje, {$user['id']}, 'F' )");

	if(!$sqlpago){//no se pudo crear la entrada de pago asociada al viaje
		
		//???SE DEBERIA ELIMINAR EL VIAJE RECIEN CREADO, PARA NO COMPROMETER EL ESTADO DE LA BASE DE DATOS (QUEDANDO UN VIAJE SIN PAGO ASOCIADO, usar $idViaje????
		//???PENDIENTE???
		header('Location: index.php?result=2');   //este es error 2, cambiarlo despues //DEBUG
		exit;
	}
	else {	//viaje y pago creados, todo listo
		//borro todos los datos temporales de los campos llenados por el user para que no se vuelvan a mostrar en la proxima vez que se use el formulario
		unset($_SESSION['flagRegistro']);
		unset($_SESSION['preciototal']);
		unset($_SESSION['origen']);
		unset($_SESSION['destino']);
		unset($_SESSION['fecha']);
		unset($_SESSION['horario']);
		unset($_SESSION['duracion']);
		unset($_SESSION['vehiculo']);
		unset($_SESSION['plazas']);	
		header('Location: index.php?result=1');
		exit;
	}
	
	
	
	
	

	
	
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>viaje creado?</title>
</head>
<body>
	<p><a href="index.php">INICIO</a></p>
</body>
</html>
