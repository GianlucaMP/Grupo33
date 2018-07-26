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
	
	
	
	
	if (isset($_POST['periodico'])) { //el viaje es periodico
		echo 'el viaje periodico, no esta todavia implementado'; //???implementar en un futuro todo el chequeo para este tipo de viajes???
		die();
	}
	else { //el viaje es ocasional
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
		if(!isset($_POST['fecha']) || empty($_POST['fecha'])) {
			header('Location: crearviaje.php?error=4');
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
		if(!isset($_POST['vehiculo']) || empty($_POST['vehiculo'])) {
			header('Location: crearviaje.php?error=7');
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
			
	}
	
	
	//SI QUIERO MEZCLAR FECHA Y HORA SOLO HAGO: mezclo fecha y hora en una variable (son strings concatenables)
	$fechaYHora = "{$_POST['fecha']}". ' '. "{$_POST['horario']}"; 
		
	//chequeo que la fecha no halla ya ocurrido
	date_default_timezone_set("America/Argentina/Buenos_Aires");	
	$fechaactual = strtotime(date("Y-m-d H:i")); //convierto las fechas a formato unix timestamp para compararlas
	$fechaevento = strtotime($fechaYHora);
	if ($fechaactual > $fechaevento){	//fecha ya ocurrida
		header('Location: crearviaje.php?error=20');
		die();
	}
	
	
	
	//************************************************************************
	//ESTE CODIGO ENTRE ASTERISCOS ESTA EN CONSTRUCCION
	
	//chequeo que el vehiculo no tenga otro viaje asignado en ese momento 			
	//????PENDIENTE???

	/*
	
	
	//extraigo en variables separadas las horas y minutos de la duracion del viaje
	$duracionTimeStamp = strtotime ($_POST['duracion']); //convierto la duracion a timestamp, pero queda con tambien con la informacion de dia, mes y año actual que deben ser truncados
	$duracionHoras = date("H", $duracionTimeStamp); //convierto a String la duracion en horas
	$duracionMinutos = date("i", $duracionTimeStamp); //convierto a String la duracion en minutos
	
		
	//instancio objetos para almacenar y comparar fecha y hora del inicio del viaje
	$objetoInicioDeViaje = new DateTime($fechaYHora);
	$objetoFinDeViaje = new DateTime($fechaYHora);
	//le agrego las horas y minutos de la duracion que faltan para el momento de fin del viaje
	$objetoFinDeViaje = $objetoFinDeViaje->add(new DateInterval("PT"."$duracionHoras"."H"."$duracionMinutos"."M"));
	
	
	//convierto a string el inicio y fin del viaje //DEBUG
	$inicioDeViaje =  $objetoInicioDeViaje->format("Y-m-d H:i"); //DEBUG
	$finDeViaje = $objetoFinDeViaje->format("Y-m-d H:i"); //DEBUG

	echo "inicio nuevo viaje vale: $inicioDeViaje <br>"; //DEBUG
	echo "fin del nuev viaje vale: $finDeViaje <br>"; //DEBUG
	
	
	
	
	//obtengo el dia anterior en un formato string, tal como se guarda en la BD para poder buscarlo
	$diaAnterior = date("Y-m-d",strtotime("{$_POST['fecha']} -1 day ")); 
	$diaViaje = date($_POST['fecha']);		
			
	echo "dia anterior vale $diaAnterior <br>"; //DEBUG		
	echo "el dia vale: $diaViaje <br>"; //DEBUG	

	
	
	//parece que ahora para sacar los elementos de un dia X tengo que especificar tambien la hora???
	
	
	
	
	$sqlfecha = mysqli_query($coneccion, "SELECT * FROM viajes WHERE fecha=$diaViaje ");   //aun asi parece que no matchea con los del mismo dia???
	if (!$sqlfecha) {
		header('Location: crearviaje.php?error=10');
		exit;
	}
	
	echo ("la cantidad de columnas de la consulta es: ". mysqli_num_rows($sqlfecha) . "<br>"); //DEBUG
	
	
	
	while ($otroViaje = mysqli_fetch_array($sqlfecha)) { //para todos los viejos en esos dias, tengo que chequear que el vehiculo no este ocupado en ese momento
	
	
		echo"entre al while <br>"; //DEBUG
		
		//extraigo en variables separadas las horas y minutos de la duracion del otro viaje
		$duracionOtroViaje = strtotime ($otroViaje['duracion']); //convierto la duracion a timestamp, pero queda con tambien con la informacion de dia, mes y año actual que deben ser truncados
		$horasOtroViaje = date("H", $duracionOtroViaje); //convierto a String la duracion en horas
		$minutosOtroViaje = date("i", $duracionOtroViaje); //convierto a String la duracion en minutos
		
		
		//instancio objetos para comparar el el momento de inicio y fin del otro viaje
		$objetoInicioDeOtroViaje = new DateTime($otroViaje['fecha']);
		$objetoFinDeOtroViaje = new DateTime($otroViaje['fecha']);
		$objetoFinDeOtroViaje = $objetoFinDeOtroViaje->add(new DateInterval("PT"."$horasOtroViaje"."H"."$minutosOtroViaje"."M"));
	
	
		//convierto a string el inicio y fin del viaje
		$inicioDeOtroViaje =  $objetoInicioDeOtroViaje->format("Y-m-d H:i"); //DEBUG
		$finDeOtroViaje = $objetoFinDeOtroViaje->format("Y-m-d H:i"); //DEBUG

		echo "iniciotroViaje vale: $inicioDeOtroViaje <br>"; //DEBUG
		echo "finDeOtroViaje vale: $finDeOtroViaje <br>"; //DEBUG
	
		exit;
		
	
		//si la hora de salida del nuevo viaje esta entre las horas de salida y fin de otro viaje doy aviso que el vehiculo esta ocupado
		//if () {
			
		//}
		
		//si la hora de llegada estimada del nuevo viaje esta entre las horas de salida y fin de otro viaje doy aviso que el vehiculo esta ocupado
		//if () {
			
		//}
		
	}
		
	echo"pase el while"; //DEBUG
	exit; //DEBUG
	
	*/
	//ESTE CODIGO ENTRE ASTERISCOS ESTA EN CONSTRUCCION
	//************************************************************************
	
	
	//se envian los datos a la base de datos
	$sql = mysqli_query($coneccion, "INSERT INTO viajes (preciototal, origen, destino, fecha, duracion, plazas, vehiculos_id, usuarios_id,horario) VALUES ('".$_POST['preciototal']."', '".$_POST['origen']."', '".$_POST['destino']."', '".$fechaYHora."', '".$_POST['duracion']."','".$_POST['plazas']."','".$_POST['vehiculo']."','".$_POST['creador']."','".$_POST['horario']."')");

	if($sql) {//transaccion valida, viaje creado
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
	}
	else { 
		header('Location: index.php?result=2');
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
