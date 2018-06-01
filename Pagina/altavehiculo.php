<?php
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
	$sql = mysqli_query($coneccion, "INSERT INTO vehiculos (plazas, marca, modelo, color, patente  	) VALUES ('".$_POST['plazas']."', '".$_POST['marca']."', '".$_POST['modelo']."', '".$_POST['color']."','".$_POST['patente']."')");
	//printf("Id del registro creado %d\n", mysqli_insert_id($sql));
	//echo "$sql";
	if($sql) $mensaje = 'El vehiculo fue agregado con exito.';
	else $mensaje = 'Hubo un error al agregar el vehiculo.';
	echo "$mensaje";
?>
<a href="miperfil.php">volver</a>