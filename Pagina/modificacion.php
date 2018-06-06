<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	// si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
	header('Location: index.php');
	}
	//chequea que no haya campos vacios
	$campos = array('marca','modelo', 'plazas', 'color','patente');
	foreach($campos AS $campo) {
	  	if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
	    	echo "$campo vacio";
	    	die();
	  	}
	}
	$chequeo = mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE patente='".$_POST['patente']."'");
	if(mysqli_num_rows($chequeo) > 0) { // si es mayor a 0, entonces hay un vehiculo con la misma patente
        header('Location: modificarvehiculo.php?error=1');///////////////////////////////////////////////////////////////
				die();
        }

	$sql = mysqli_query($coneccion, "UPDATE vehiculos SET plazas='".$_POST['plazas']."', marca='".$_POST['marca']."', modelo='".$_POST['modelo']."', color='".$_POST['color']."', patente='".$_POST['patente']."' WHERE id=".$_GET['id']);
	//printf("Id del registro creado %d\n", mysqli_insert_id($sql));
	//echo "$sql";
	if($sql) header('Location: miperfil.php?result=5');////////////////////////////
	else header('Location: miperfil.php?result=6');//////////////////
?>
<a href="miperfil.php">volver</a>
