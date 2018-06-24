<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// levanto los campos en un array, con el foreach de abajo reviso rapidamente que ninguno de los post a cada campo este vacio
	$campos = array('preciototal','origen', 'destino', 'fecha', 'vehiculo',  'contacto');
	
	//se chequean los datos no esten vacios y y a su vez se copian al array $_SESSION[];
	$error= false;
	foreach($campos AS $campo) {
		if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
			$error = true;
		}
		$_SESSION["formularioTemp$campo"] = $_POST[$campo]; //chequear que este bien el indice cosa de que copie
	}
	if ($error) {
		header('Location: crearviaje.php?error=1');
		die();
	}
	
//	foreach($campos AS $campo) {
//		print($_POST[$campo]);
//	    if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
//	    	echo "$campo vacio";
//			header('Location: admin.php?error=1&accion=agregar');s
//	    	die();
//	   }
//  }


$fechaactual = Date("Y-m-d");
$fechaevento = $_POST['fecha'];
if ($fechaactual <= $fechaevento) {
	// se envian los datos a la base de datos, si se sube te avisa y si no tambien.
	$sql  = mysqli_query($coneccion, "INSERT INTO viajes (preciototal, origen, destino, fecha, vehiculo, contacto) VALUES ('".$_POST['preciototal']."', '".$_POST['origen']."', '".$_POST['destino']."', '".$_POST['fecha']."','".$_POST['vehiculo']."','".$_POST['contacto']."')");
	//printf("Id del registro creado %d\n", mysqli_insert_id($sql));
	echo "$sql";
	if($sql) header('Location: index.php?result=1');////////////////////////////
	else header('Location: index.php?result=2');}//////////////////
	else{
		header('Location: crearviaje.php?error=2');
		die();}
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
