<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	
	
	// levanto los campos en un array, con el foreach de abajo reviso rapidamente que ninguno de los post a cada campo este vacio (el array a usar depende el tipo de viaje) ???por el momento se implemetno de otra manera???
	//$datosOcasional = array('preciototal', 'origen', 'destino', 'fecha', 'horario', 'duracion', 'vehiculo', 'plazas');
	//$datosPeriodico = array('preciototal', 'origen', 'destino', 'fecha', 'horario', 'duracion', 'vehiculo', 'plazas'); //capaz se maneje un array distinto en un futuro para periodicos. Pero la idea es algo asi
	#By LC. Que el array a usar dependa del tipo de viaje.
	
	
	//se chequean que los datos no esten vacios y y a su vez se copian al array $_SESSION[] ???la idea es hacer todo esto en el foreach, pero se complico???
	
	
	if (isset($_POST['periodico'])) { //el viaje es periodico
		echo 'el viaje periodico, no esta todavia implementado'; //???implementar en un futuro todo el chequeo para este tipo de viajes???
		die();
	}
	else { //el viaje es ocasional
		//hago todo estos chequeos a lo bruto, sin usar foreach por simplicidad.. lo ideal seria corregirlo despues
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
		/*if(!isset($_POST['horario']) || empty($_POST['horario'])) {
			header('Location: crearviaje.php?error=5');
			exit;
		}*/
		if(!isset($_POST['duracion']) || empty($_POST['duracion'])) {
			header('Location: crearviaje.php?error=6');
			exit;
		}
		if(!isset($_POST['plazas']) || empty($_POST['plazas'])) {
			header('Location: crearviaje.php?error=8');
			exit;
		}
	}
	
	$fechaactual = Date("Y-m-d");
	$fechaevento = $_POST['fecha'];
	if ($fechaactual >= $fechaevento){	//fecha ya ocurrida -> aviso y retorno a la pagina de crear viaje
		header('Location: crearviaje.php?error=20');
		die();
	}
		
					
		
		
		//este foreach fue un intento fallido de una buena implementacion. de lo anterior
		/*foreach($datosOcasional AS $campo) {		
			if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
				$error = true;
				$codigoError = array_search($campo,array_keys($datosOcasional)); //esto deberia devolver el indice del elemento del array datosOcasional que es vacio/nulo para poder informarlo ??chequear ???
			}
			$_SESSION["formularioTemp$campo"] = $_POST[$campo]; //???chequear que este bien el indice cosa de que copie???		
		}*/
		#By LC. Si la idea seria usar un for de este estilo. Luego lo vemos bien.
	
		
	//??? Se agrego este pedazo de codigo, con todo el logeo para poder conseguir los datos del user.. chequear que funcione???
	
	//chequeo la sesion, ya que necesito enviar al user actual a la BD como conductor del viaje (creo que no hace falta pero por las dudas..)
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user= $sesion->datosuser();
	
	// se chequea si esta logeado, y si no lo esta se lo redirecciona al inicio.
	if(!$logeado){
		header('Location: index.php');
	}else { //si esta logeado cargo varios datos del usuario en la variable $datosUsuario
		$datosUsuario = $sesion->datosuser();
	}
	
	$_SESSION['preciototal'] = $_POST['preciototal'];
	$_SESSION['origen'] = $_POST['origen'];
	$_SESSION['destino'] = $_POST['destino'];
	$_SESSION['fecha'] = $_POST['fecha'];
	//$_SESSION['horario'] = $_POST['horario'];
	$_SESSION['duracion'] = $_POST['duracion'];
	$_SESSION['vehiculo'] = $_POST['vehiculo'];
	$_SESSION['plazas'] = $_POST['plazas'];
	

	
	//DEBUGGING
	echo "_SESSION EN precio vale: $_SESSION[preciototal]<br>";
	echo "_SESSION EN origen vale: $_SESSION[origen]<br>";
	echo "_SESSION EN destino vale: $_SESSION[destino]<br>";
	echo "_SESSION EN fecha vale: $_SESSION[fecha]<br>";
	//echo "_SESSION EN horario vale: $_SESSION[horario]<br>";
	echo "_SESSION EN duracion vale: $_SESSION[duracion]<br>";
	echo "_SESSION EN vehiculo vale: $_SESSION[vehiculo]<br>";
	echo "_SESSION EN plazas vale: $_SESSION[plazas]<br>";
	

	
	
	
	//fecha valida se envian los datos a la base de datos, si se sube te avisa y si no tambien.
	
	$sql  = mysqli_query($coneccion, "INSERT INTO viajes (preciototal, origen, destino, fecha, duracion, plazas,  vehiculos_id, contacto,usuarios_id) VALUES ('".$_POST['preciototal']."', '".$_POST['origen']."', '".$_POST['destino']."', '".$_POST['fecha']."', '".$_POST['duracion']."','".$_POST['plazas']."','".$_POST['vehiculo']."','".$_POST['contacto']."','".$_POST['creador']."')");

	/*$sql  = mysqli_query($coneccion, "INSERT INTO viajes (preciototal, origen, destino, fecha, vehiculo, conductor) VALUES ('".$_POST['preciototal']."', '".$_POST['origen']."', '".$_POST['destino']."', '".$_POST['fecha']."','".$_POST['vehiculo']."','".$datosUsuario['id']."')"); 
	//se le agrego el envio del ID del conductor ???chequearlo??? */

	if($sql) {//transaccion valida, viaje creado
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
