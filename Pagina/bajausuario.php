<?php


	//???ESTA PAGINA ESTA HECHA MUY POR ARRIBA TIENE QUE SER BIEN CORREGIDA Y TESTEADA???


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
	
	
	// si no hay una ID seteada se vuelve a mi perfil
	if(!isset($_GET['id'])){
		header('Location: miperfil.php?result=20');
		exit;		
	}
	
	
	//se chequea que la cuanta a eliminar realmente pertenezca al user que la quiere borrar 
	if ($_GET['id'] != user['id'] ) {
		header('Location: miperfil.php?result=42');
		exit;		
	}
	
	
	
	//???cuidado, la comparacion aca la estoy haciendo con strings, pero creo que por como esta ordenado el string casi seguro deberia funcionar igual???
	
	//se chequea que el usuario no tenga viajes pendientes como conductor	
	$fechaactual = Date("Y-m-d");
	$sql5 =  mysqli_query($coneccion, "SELECT * FROM viajes WHERE usuarios_id={$user['id']}");
	while ($viajetemp = mysqli_fetch_array($sql5)) {
		if ($viajetemp['fecha'] > $fechaactual) {
			header('Location: miperfil.php?result=23');
			exit;	
		}
	}


	//se deberia chequear que el user no tenga viajes pendientes como pasajero
	//???PENDIENTE???
	
	//se deberia chequear que el user NO tenga viajes pendientes como conductor
	//???pendiente???
	


	//se marcan los enlaces entre este usuario y sus vehiculos como borrados
	$sql =  mysqli_query($coneccion, "UPDATE enlace SET eliminado='S' WHERE usuarios_id={$user['id']}");
	//Se verifica que la query haya sido exitosa
	if(!$sql) {
		header('Location: miperfil.php?result=22');
		exit;
	}	
	
	
	
	//se desloguea al user
	$logeado = $sesion->logout();
		
	//se elimina al usuario
	$sql4 = mysqli_query($coneccion, "UPDATE usuarios SET eliminado='S' WHERE id=".$_GET['id']);
	if (!$sql4) {
		header('Location: miperfil.php?result=22'); 
		exit;
	}
	else { //baja exitosa
		header('Location: index.php?result=7');
		exit;
	}	
	
?>




