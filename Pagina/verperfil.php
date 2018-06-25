<?php

// Se crea la coneccion a la SQL y se coloca en $conexion
require('dbc.php');
$conexion = conectar();


$usuarios=mysqli_query($coneccion, "SELECT * FROM usuarios WHERE id = '".$_GET['id']."'"); //esto deberia funcionar
$conductor=mysqli_fetch_array($conductor);


?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<title></title>
	</style>
</head>
<body>

<div> mostrar datos de contacto </div> <!-- convertir esto en boton-->

</body>
<html>


<!--PENDIENTE:
En la pagina de un viaje, agregar boton para ir al perfil del tipo en cuestion (el cual es un link a esta pagina, que manda por GET, el id del chabon)-->