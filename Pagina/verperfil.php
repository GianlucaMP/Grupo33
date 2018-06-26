<?php

// Se crea la coneccion a la SQL y se coloca en $conexion
require('dbc.php');
$conexion = conectar();


$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '".$_GET['id']."'"); 

if (!$datosConductor = mysqli_fetch_array($sql)) {
	echo"Error inesperado. No se puede acceder al conductor en la BD"; //hacer un manejo de este error mas copado
	exit;
}
//si llegue hasta aca todo bien, ya tengo los datos del conductor


?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<title> Ver Perfil </title>
</head>
<body>

<p> mostrar datos de contacto </p> <!-- convertir esto en boton-->

</body>
</html>



