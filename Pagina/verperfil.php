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


//calculo la edad


$f1 = new DateTime($datosConductor['fecha']);
$f2 = new DateTime("now");
$diferencia =  $f1->diff($f2);
$edad = $diferencia->format("%y");




?>
<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheets.css"/>
	<title> Ver Perfil </title>
	<!--<script type="text/javascript" src="js/js_viajes.js"></script>-->
	<style> 

	#container{
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
		}
	
	#menucostado{
		float: left;
		width: 20%;
	}
	
	
	#datos{
			float: right;
			width: 79%;
	}
	
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

<div id="container">
	<h2> Informacion del usuario: <?php echo $datosConductor['nombre']; ?> </h2>
	<div id='menucostado' style="font-size:22px">
		<p> <a href="index.php" style="text-decoration:none">Volver al inicio</a></p>
	</div>
	<div id="datos">
		<p style="font-size:25px"> Nombre: <?php echo $datosConductor['nombre'] ?> </p>
		<p style="font-size:25px"> Edad: <?php echo $edad ?></p>
		<button style="margin:70px 200px; width:40%;" onclick="mostrarDatosDeContacto()"> Mostrar datos de contacto </button>	
		<div id="datosDeContacto" style="display:none">
			<?php 
			if(mysqli_num_rows($sql2) > 0 || ($datosConductor['id'] == $user['id'])) { ?>
				 <p style="font-size:25px"> Email: <?php echo $datosConductor['email'] ?> </p>
				 <p style="font-size:25px"> Telefono: <?php echo $datosConductor['telefono'] ?> </p>
			<?php }
			else { ?>
				 <p style="font-size:25px; color:red"> Debe ser pasajero de algun viaje de este usuario para poder ver sus datos de contacto </p>
			<?php } 	?>
		</div>
	</div>
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
