<?php

// Se crea la coneccion a la SQL y se coloca en $conexion
require('dbc.php');
$conexion = conectar();

// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
require('usuarioclass.php');
$sesion = new sesion;
$logeado = $sesion->logeado();
$user = $sesion->datosuser();

// si el usuario no esta logeado se redirecciona automaticamente al inicio
if(!$logeado){
	header('Location: index.php');
}

$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '".$_GET['id']."'"); 

if (!$datosConductor = mysqli_fetch_array($sql)) {
	echo"Error inesperado. No se puede acceder al conductor en la BD"; //hacer un manejo de este error mas copado
	exit;
}
//si llegue hasta aca todo bien, ya tengo los datos del conductor
$sql2=mysqli_query($conexion,"SELECT viajes.*,pasajeros.pasajeros_id FROM viajes INNER JOIN pasajeros ON viajes.id=pasajeros.viajes_id WHERE viajes.usuarios_id='".$datosConductor['id']."' AND pasajeros.pasajeros_id='".$_SESSION['id']."' ");

if ($sql2) {
	$exito= mysqli_fetch_array($sql2);
}

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


<p class="centrado"> Nombre: <?php echo $datosConductor['nombre'] ?></p>

<button onclick="mostrarDatosDeContacto()"> Mostrar datos de contacto </button>


<div class="centrado" id="datosDeContacto" style="display:none">
	<?php 
	if(mysqli_num_rows($sql2)>0) {
		echo "Email:".$datosConductor['email']." </br> ";
		echo "Telefono:".$datosConductor['telefono']." </br> ";
		}
	else
		{echo "Debe ser pasajero de algun viaje de este usuario para poder ver sus datos de contacto";	} 
	?>
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
