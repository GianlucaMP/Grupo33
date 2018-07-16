<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	

	$logeado = $sesion->logeado();
	
	
	//guardo los datos recibidos en variables de sesion para poder conservarlos en caso de error (antes de todos los header, pero despues del chequeo de si esta logeado)
	$_SESSION['marca'] = $_POST['marca'];
	$_SESSION['modelo'] = $_POST['modelo'];
	$_SESSION['color'] = $_POST['color'];
	$_SESSION['plazas'] = $_POST['plazas'];
	$_SESSION['patente'] = $_POST['patente'];
	
	
	
	//???LO QUE SIGUE NO SE DEBERIA DES-COMENTAR (YA ESTABA COMENTADO DE ANTES)???
	//$user = $sesion->datosuser();
	//$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");
	// si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
	}
	
	
	
	
	if(!isset($_POST['marca']) || empty($_POST['marca'])) {
		header('Location: registrarvehiculo.php?error=2');
		exit;
	}
	if(!isset($_POST['modelo']) || empty($_POST['modelo'])) {
		header('Location: registrarvehiculo.php?error=3');
		exit;
	}
	if(!isset($_POST['color']) || empty($_POST['color'])) {
		header('Location: registrarvehiculo.php?error=4');
		exit;
	}
	if(!isset($_POST['plazas']) || empty($_POST['plazas'])) {
		header('Location: registrarvehiculo.php?error=5');
		exit;
	}
	if(!isset($_POST['patente']) || empty($_POST['patente'])) {
		header('Location: registrarvehiculo.php?error=6');
		exit;
	}

	
	
		
	
	#lo que sigue a continuacion se puede mejorar. No lo hice porque no me daba la bateria, tengo tanta energia como una pila china
	# $chequeo busca el vehiculo en la tabla de vehiculos
	$chequeo = mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE patente='".$_POST['patente']."'");
	# $chequeo2 basicamente es la lista de vehiculos del usuario
	$chequeo2=mysqli_query($coneccion,"SELECT vehiculos.* FROM vehiculos INNER JOIN enlace ON enlace.vehiculos_id=vehiculos.id INNER JOIN usuarios ON enlace.usuarios_id=usuarios.id WHERE usuarios.id=".$_SESSION['id']);

	if(mysqli_num_rows($chequeo2) > 0) {
		/*Este if lo que hace es buscar en la lista de vehiculos, uno que tenga patente igual a la que llega por post
		De ser asi quiere decir que el usuario intenta duplicar un vehiculo con una patente ya registrada
		en su lista de vehiculos*/ 
		while ($listarvehiculos=mysqli_fetch_array($chequeo2)) {
			if ($listarvehiculos['patente']==$_POST['patente']) {
				header('Location: registrarvehiculo.php?error=1');
				exit();
				}
			}
        }

    if(mysqli_num_rows($chequeo)>0){
    	#si el vehiculo ya existe, solamente se agrga el enlace
    	$car=mysqli_fetch_array($chequeo);
    	$autoid = $car['id'];
    	$sql2= mysqli_query($coneccion,"INSERT INTO enlace (usuarios_id,vehiculos_id) VALUES ('".$_SESSION['id']."','".$autoid."')");	
    }
    else {
    	#Caso Contrario, se da de alta el vehiculo en la BD y se crea el enlace 
    	$sql = mysqli_query($coneccion, "INSERT INTO vehiculos (plazas, marca, modelo, color, patente) VALUES ('".$_POST['plazas']."', '".$_POST['marca']."', '".$_POST['modelo']."', '".$_POST['color']."','".$_POST['patente']."')");
    	$autoid = mysqli_insert_id($coneccion);
    	$sql2= mysqli_query($coneccion,"INSERT INTO enlace (usuarios_id,vehiculos_id) VALUES ('".$_SESSION['id']."','".$autoid."')");
    }

	//printf("Id del registro creado %d\n", mysqli_insert_id($sql));
	//echo "$sql";
	#si hubo exito (o no) se notifica
	if($sql || $sql2) {
		unset($_SESSION['marca']);
		unset($_SESSION['modelo']);
		unset($_SESSION['color']);
		unset($_SESSION['plazas']);
		unset($_SESSION['patente']);
		header('Location: miperfil.php?result=1');
	}
	else {
		header('Location: miperfil.php?result=2');
	}
?>
