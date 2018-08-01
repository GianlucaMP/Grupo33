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
	
	
	
	//se chequea que se haya especificado un puntaje	
	if(!isset($_POST['puntaje'])) {
		header('Location: calificar.php?result=3'); 
		exit;
		
	}
	
	
	//se chequea que se haya especificado un usuario al cual calificar
	if(!isset($_POST['calificado'])) {
		header('Location: calificar.php?result=4'); 
		exit;
		
	}
	
	
	//se chequea que se halla especificado un viaje al cual calificar
	if(!isset($_POST['viaje'])){
		header('Location: calificar.php?result=999'); 
		exit;
	}	
	
		
	//para facilitar el codigo
	$puntaje = $_POST['puntaje'];
	$descripcion = $_POST['descripcion'];
	$calificado  = $_POST['calificado'];
	$viajeid = $_POST['viaje'];
	$userid = $user['id'];
	
	
	
	$haydescripcion = false;
	if (isset($_POST['descripcion']) && (!empty($_POST['descripcion']))) {	//para arrancar este chequeo no funciona bien.. aunque puede que no sea necesario
		$haydescripcion = true;
	}
	
	

	if ($haydescripcion) { //si hay descripcion la incluyo en la query ???ESTE CASO ME FALLA  ???
		$sql = mysqli_query($coneccion, "UPDATE calificaciones SET puntaje=$puntaje , descripcion=$descripcion WHERE viaje_id = $viajeid AND calificador_id = $userid ");
	}
	else {//si no hay descripcion hago una query sin eso
		 $sql = mysqli_query($coneccion, "UPDATE calificaciones SET puntaje=$puntaje WHERE viaje_id = $viajeid AND calificador_id = $userid "); 
	}
	
	
	/* DEBUG
	
		echo (mysqli_error($coneccion));
		echo "<br>";
		echo "hay descripcion vale: $haydescripcion <br>";
		echo "calificado vale: $calificado <br>";
		echo "userid vale: $userid <br>";
		echo "viajeid vale: $viajeid <br>";
		echo "puntaje vale: $puntaje <br>";
		echo "descripcion vale: $descripcion <br>";
		exit;
		
	*/
	
	if(!$sql) {
		header('Location: calificar.php?result=2'); 
		exit;
	}
	

	else { //todo bien aviso todo bien
		header('Location: calificar.php?result=1'); 
		exit;
	}
	