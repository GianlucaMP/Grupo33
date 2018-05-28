<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// levanto los campos en un array, con el foreach de abajo reviso rapidamente que ninguno de los post a cada campo este vacio
	$campos = array('preciototal','origen', 'destino', 'fecha', 'vehiculo',  'contacto');
//	foreach($campos AS $campo) {
//		print($_POST[$campo]);
//	  if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
//
//	    echo "$campo vacio";
	    //header('Location: admin.php?error=1&accion=agregar');s
//	    die();
//	  }
//	}
	// se valida que el año sea un Integer y no cualquier fruta
	//if(!filter_var($_POST['fecha'], FILTER_VALIDATE_INT)){
		//header('Location: admin.php?error=5&accion=agregar');
		//die();
		$fechaactual = Date("Y-m-d");
$fechaevento = $_POST['fecha'];
if ($fechaactual <= $fechaevento) {
	// se envian los datos a la base de datos, si se sube te avisa y si no tambien.
	$sql  = mysqli_query($coneccion, "INSERT INTO viajes (preciototal, origen, destino, fecha, vehiculo, contacto) VALUES ('".$_POST['preciototal']."', '".$_POST['origen']."', '".$_POST['destino']."', '".$_POST['fecha']."','".$_POST['vehiculo']."','".$_POST['contacto']."')");
	//printf("Id del registro creado %d\n", mysqli_insert_id($sql));
	echo "$sql";
	if($sql) $mensaje = 'El viaje fue agregado con exito.';
	else $mensaje = 'Hubo un error al agregar el viaje.';
	echo "$mensaje";}
	else{echo "Ha ingresado una fecha invalida";}
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
