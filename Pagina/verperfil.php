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
<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheets.css"/>
	<title> Ver Perfil </title>
	<!--<script type="text/javascript" src="js/js_viajes.js"></script>-->
	<style> 

	
	.centrado{
		margin: 70px 0; <!--centrado vertical-->
	

		width: 50%; <!--centrado horizontal muchas veces hace lo que se le canta con solo agregar un comment-->
		text-align: center; 
	}
	
	
	button{

		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 20%;
		height: 3em;
		font-size:25px;
	}	
	
	</style>
</head>
<body>

<!-- poner aca todos los datos, en grande (salvo los de contacto. (nombre, )-->


<p class="centrado"> Nombre</p>

<button onclick="mostrarDatosDeContacto()"> Mostrar datos de contacto </button>


<div class="centrado" id="datosDeContacto" style="display:none">
	<p> IMAGINATE QUE ACA ESTAN LOS DATOS DE CONTACTO</p>
</div>

</body>
</html>




<script>

function mostrarDatosDeContacto() {
    var x = document.getElementById("datosDeContacto");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

</script>
