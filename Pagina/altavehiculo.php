<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	//$user = $sesion->datosuser();
	//$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");
	// si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
	}
	$campos = array('marca','modelo', 'plazas', 'color','patente');
	foreach($campos AS $campo) {
	  	if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
	    	echo "$campo vacio";
	    	die();
	  	}
	}
	$chequeo = mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE patente='".$_POST['patente']."'");

	$chequeo2=mysqli_query($coneccion,"SELECT vehiculos.* FROM vehiculos INNER JOIN enlace ON enlace.vehiculos_id=vehiculos.id INNER JOIN usuarios ON enlace.usuarios_id=usuarios.id WHERE usuarios.id=".$_SESSION['id']);

	if(mysqli_num_rows($chequeo2) > 0) { // si es mayor a 0, entonces hay un vehiculo con la misma patente
		while ($listarvehiculos=mysqli_fetch_array($chequeo2)) {
			if ($listarvehiculos['patente']==$_POST['patente']) {
				header('Location: registrarvehiculo.php?error=1');
				exit();
				}
			}
        }

    if(mysqli_num_rows($chequeo)>0){
    	$car=mysqli_fetch_array($chequeo);
    	$autoid = $car['id'];
    	$sql2= mysqli_query($coneccion,"INSERT INTO enlace (usuarios_id,vehiculos_id) VALUES ('".$_SESSION['id']."','".$autoid."')");	
    }
    else {
    	$sql = mysqli_query($coneccion, "INSERT INTO vehiculos (plazas, marca, modelo, color, patente) VALUES ('".$_POST['plazas']."', '".$_POST['marca']."', '".$_POST['modelo']."', '".$_POST['color']."','".$_POST['patente']."')");
    	$autoid = mysqli_insert_id($coneccion);
    	$sql2= mysqli_query($coneccion,"INSERT INTO enlace (usuarios_id,vehiculos_id) VALUES ('".$_SESSION['id']."','".$autoid."')");
    }
	//$sql = mysqli_query($coneccion, "INSERT INTO vehiculos (plazas, marca, modelo, color, patente) VALUES ('".$_POST['plazas']."', '".$_POST['marca']."', '".$_POST['modelo']."', '".$_POST['color']."','".$_POST['patente']."')");
	//$autoid = mysqli_insert_id($coneccion);
	//echo "la id es " .$autoid  ;
	//printf("Id del registro creado %d\n", mysqli_insert_id($sql));
	//echo "$sql";
	//$newcar = mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE patente='".$_POST['patente']."'");
	//$vehiculo = mysqli_fetch_array($newcar);
	//$sql2= mysqli_query($coneccion,"INSERT INTO enlace (usuarios_id,vehiculos_id) VALUES ('".$_SESSION['id']."','".$autoid."')");
	if ($sql2) {
		echo "ESTA MAAAAL";
	}
	if($sql || $sql2) header('Location: miperfil.php?result=1');////////////////////////////
	else header('Location: miperfil.php?result=2');//////////////////
?>
