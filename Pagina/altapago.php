<?php
	
	 // Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	
		
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	
	// se chequea si esta logeado, y si no lo esta se lo redirecciona al inicio.
	if(!$logeado){
		header('Location: index.php');
		exit;
	}
	
	$user = $sesion->datosuser();
	
	
	
	//guardo todo lo recibido por POST en variables de sesion (antes de los headers, pero despues del chequeo de que este logeado)
	if(isset($_POST['tarjeta']) && (!empty($_POST['tarjeta']))) {
		$_SESSION['tarjeta'] = $_POST['tarjeta'];
	}
	
	if(isset($_POST['titular']) && (!empty($_POST['titular']))) {
		$_SESSION['titular'] = $_POST['titular'];
	}
	
	if(isset($_POST['fecha']) && (!empty($_POST['fecha']))) {
		$_SESSION['fecha'] = $_POST['fecha'];
	}
	
	if(isset($_POST['codigo']) && (!empty($_POST['codigo']))) {
		$_SESSION['codigo'] = $_POST['codigo'];
	}
	
	
	//se chequean que los campos no esten vacios
	if(!isset($_POST['tarjeta']) || empty($_POST['tarjeta'])) {
		header('Location: mispagos.php?result=5');			
		exit;
	}
	if(!isset($_POST['titular']) || empty($_POST['titular'])) {
		header('Location: mispagos.php?result=6');			
		exit;
	}
	if(!isset($_POST['fecha']) || empty($_POST['fecha'])) {
		header('Location: mispagos.php?result=7');			
		exit;
	}
	if(!isset($_POST['codigo']) || empty($_POST['codigo'])) {
		header('Location: mispagos.php?result=8');			
		exit;
	}
	if(!isset($_POST['pago']) || empty($_POST['pago'])) {
		header('Location: mispagos.php?result=99');			
		exit;
	}
	
	
	//valido el numero de la tarjeta
	if (!preg_match("#^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$#", $_POST['tarjeta']))  {  
		header('Location: mispagos.php?result=9');			
		exit;
	}
	
	
	//verifico medianamente la fecha
	if (!preg_match("#^(0[1-9]|1[0-2])/[0-9]{2}$#", $_POST['fecha'])) { 
		header('Location: mispagos.php?result=10');			
		exit;
	}
	
	
	//valido que el codigo de seguridad sean 3 numeros
	if (!preg_match("#^[0-9]{3}$#", $_POST['codigo'])) {
		header('Location: mispagos.php?result=11');			
		exit;
	}
	
	
	
	
	
	

	
	
	$sqlpago = mysqli_query($coneccion, "UPDATE pagos SET pago='T' WHERE id={$_POST['pago']} ");
	

	
	if($sqlpago) {//transaccion valida, se realizo el pago con exito
		//borro todos los datos temporales de los campos llenados por el user para que no se vuelvan a mostrar en la proxima vez que se use el formulario
		unset($_SESSION['tarjeta']);
		unset($_SESSION['titular']);
		unset($_SESSION['fecha']);
		unset($_SESSION['codigo']);
		header('Location: mispagos.php?result=1');	
		exit;
	}
	else {
		header('Location: mispagos.php?result=2');	
		exit;
	}
	
	
	