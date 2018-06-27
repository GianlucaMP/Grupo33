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
	
	//este chequeo es para evitar que queden 2 autos en la BD con una misma patente despues de una edicion???
	//???hay un bug por este chequeo, q salta si modifica algo y se deja la patente igual. Ya que no comtempla ese caso???
	//seguramente haya que ver esto solo si se cambia la patente, ahora si se deja igual salteamos este chequeo
	/*$chequeo = mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE patente='".$_POST['patente']."'");
	if(mysqli_num_rows($chequeo) > 0) { // si es mayor a 0, entonces hay un vehiculo con la misma patente  
        header('Location: editarvehiculo.php?error=1');
		die();
    }*/

    $chequeo = mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE patente='".$_POST['patente']."'");
	if(mysqli_num_rows($chequeo) > 0) { // si es mayor a 0, entonces hay un vehiculo con la misma patente
		$comp=mysqli_fetch_array($chequeo); 
		if ($_GET['id']!=$comp['id']){//verifico si se trata del vehiculo que quiero cambiar
        header('Location: editarvehiculo.php?error=1&id='.$_GET['id']);
				exit();}
        }

	$sql = mysqli_query($coneccion, "UPDATE vehiculos SET plazas='".$_POST['plazas']."', marca='".$_POST['marca']."', modelo='".$_POST['modelo']."', color='".$_POST['color']."', patente='".$_POST['patente']."' WHERE id=".$_GET['id']);
	//printf("Id del registro creado %d\n", mysqli_insert_id($sql));
	//echo "$sql";
	if($sql) header('Location: miperfil.php?result=5');
	else header('Location: miperfil.php?result=6');
?>
<a href="miperfil.php">volver</a>
