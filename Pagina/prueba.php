
<?php

require('dbc.php');
$coneccion = conectar();


$sql = mysqli_query($coneccion, "SELECT * FROM viajes where id='45' ");
if (!$sql) {
	echo "fallo la query";
}

echo "el valor de mysqli_num_rows es: ";
echo mysqli_num_rows($sql), "<br>";

$viaje = mysqli_fetch_array($sql);


echo "el valor de la fecha del viaje es: {$viaje['fecha']} <br>";

echo "el tipo de la fecha del viaje es: ";
echo gettype($viaje['fecha']), "<br>";


?>

<HTML>

<HEAD>

<BODY>

</BODY>

</HEAD>


</HTML>