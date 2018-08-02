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
	
	
	// si no hay una pass seteada se vuelve a mi perfil
	if(!isset($_POST['pass'])){
		header('Location: eliminarusuario.php?result=2');
		exit;		
	}
	
	
	$passhash = md5($_POST['pass']);
	
	
	
	//se chequea que la contrasena coincida
	$sqlpass = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE id={$user['id']} AND password='$passhash' "); 
	
	if (!$sqlpass) {
		header('Location: eliminarusuario.php?result=4');
		exit;
	}
	
	
	if (mysqli_num_rows($sqlpass) == 0){
		header('Location: eliminarusuario.php?result=3');
		exit;
	}
	
	
	//???cuidado, la comparacion aca la estoy haciendo con strings, pero creo que por como esta ordenado el string casi seguro deberia funcionar igual???
		
	//se chequea que el usuario no tenga viajes pendientes como conductor	
	$fechaactual = Date("Y-m-d");
	$sql5 =  mysqli_query($coneccion, "SELECT * FROM viajes WHERE usuarios_id={$user['id']}");
	if (!sql5) {
		header('Location: eliminarusuario.php?result=4');
		exit;
	}
	
	
	while ($viajetemp = mysqli_fetch_array($sql5)) {
		if ($viajetemp['fecha'] > $fechaactual) {
			header('Location: eliminarusuario.php?result=5');
			exit;	
		}
	}


	


	//se marcan los enlaces entre este usuario y sus vehiculos como borrados
	$sql =  mysqli_query($coneccion, "UPDATE enlace SET eliminado='S' WHERE usuarios_id={$user['id']}");
	if(!$sql) {
		header('Location: eliminarusuario.php?result=4');
		exit;
	}	
	
	
	
	//se desloguea al user
	$logeado = $sesion->logout();
		
	//se elimina al usuario
	$sql4 = mysqli_query($coneccion, "UPDATE usuarios SET eliminado='S' WHERE id=".$user['id']);
	if (!$sql4) {
		header('Location: eliminarusuario.php?result=4');
		exit;
	}
	else { //baja exitosa
		header('Location: index.php?result=7');
		exit;
	}	
	
?>




