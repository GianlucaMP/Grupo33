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
	exit;
}

$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '".$_GET['id']."'"); 

if (!$datosConductor = mysqli_fetch_array($sql)) {
	header('Location: index.php?result=4');
	exit;
}


//TESTEAR?? SEGURO ESTA MAL??
$sql2 = mysqli_query($conexion, "SELECT postulaciones.*, viajes.usuarios_id FROM postulaciones INNER JOIN viajes ON postulados.usuarios_id=viajes.usuarios_id WHERE postulados_id='".$datosConductor['id']."' AND postulados.postulados_id='".$user['nombre']."'  AND postulaciones.estado='A' ");


//consulta anterior, cuando se tenia tabla de passajeros y de postulados
//$sql2 = mysqli_query($conexion,"SELECT viajes.*,pasajeros.pasajeros_id FROM viajes INNER JOIN pasajeros ON viajes.id=pasajeros.viajes_id WHERE viajes.usuarios_id='".$datosConductor['id']."' AND pasajeros.pasajeros_id='".$_SESSION['id']."' ");

if (!$sql2) {
	header('Location: index.php?result=926'); //le pongo este error por el momento para que salte y se note que es este, despues definirlo como error 4???
	exit;
	
}

//defino si se deben mostrar o no los datos de contacto
$mostrarDatosContacto = false;
if (mysqli_num_rows($sql2) > 0 || ($datosConductor['id'] == $user['id'])) {
	$mostrarDatosContacto = true;
}



//calculo la edad para poder mostrarla
$f1 = new DateTime($datosConductor['fecha']);
$f2 = new DateTime("now");
$edad =  ($f1->diff($f2))->format("%y");


//???SE DEBERIA CAMBIAR EL METODO DE ENVIO DE ID POR POST.. SINO SE PUEDE REVISAR TODA LA BD CON SOLO CAMBIAR EL ID DE LA URL???


?>
<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheets.css"/>
	<title> Ver Perfil </title>
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
	
	p, span{
		font-size:25px;
	}
	
	.alerta{
		color:red;
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

<div id="container">
	<h2> Ver Perfil: <?php echo $datosConductor['nombre']; ?> </h2>
	<div id='menucostado' style="font-size:22px">
	
	<!-- si se llego aca por un link de una pagina de un viaje. muestro el boton volver al viaje-->
	<?php if(isset($_GET['viaje'])) { ?>
		<p> <a href="verviaje.php<?php echo ( isset($_GET['viaje']) ? "?id=${_GET['viaje']}" : "" ) ?>" style="text-decoration:none">Volver al Viaje</a></p>
	<?php } ?>
	<p> <a href="index.php" style="text-decoration:none">Volver al inicio</a></p>
	</div>
	<div id="datos">
		<fieldset>
		<h1> Informacion del usuario: <?php echo $datosConductor['nombre']; ?> </h1>
		<p> Nombre: <?php echo $datosConductor['nombre'] ?> </p>
		<p> Edad: <?php echo $edad ?> </p>
		<p> Email: <?php  echo ($mostrarDatosContacto ? $datosConductor['email'] : '<span class="alerta"> Debe ser pasajero de algun viaje de este usuario para poder ver sus datos de contacto </span>'  ) ?> </p>
		<p> Telefono: <?php echo ($mostrarDatosContacto ? $datosConductor['telefono'] : '<span class="alerta"> Debe ser pasajero de algun viaje de este usuario para poder ver sus datos de contacto </span>' ) ?> </p>
		</fieldset>
	</div>
</div>
</body>
</html>




<!--CODIGO ANTERIOR: CON UN BOTON PARA MOSTRAR DATOS DE CONTACTO (RESPETA LO QUE DICE LA HISTORIA DE USUARIO, PERO SE DIJO DE CAMBIARLA)

<div id="container">
	<h2> Informacion del usuario: <?php echo $datosConductor['nombre']; ?> </h2>
	<div id='menucostado' style="font-size:22px">
		<p> <a href="index.php" style="text-decoration:none">Volver al inicio</a></p>
	</div>
	<div id="datos">
		<p> Nombre: <?php echo $datosConductor['nombre'] ?> </p>
		<p> Edad: <?php echo $edad ?></p>
		<button style="margin:70px 200px; width:40%;" onclick="mostrarDatosDeContacto()"> Mostrar datos de contacto </button>	
		<div id="datosDeContacto" style="display:none">
			<?php 
			if ($mostrarDatosContacto) { ?>
				 <p> Email: <?php echo $datosConductor['email'] ?> </p>
				 <p> Telefono: <?php echo $datosConductor['telefono'] ?> </p>
			<?php }
			else { ?>
				 <p class="alerta"> Debe ser pasajero de algun viaje de este usuario para poder ver sus datos de contacto </p>
			<?php } 	?>
		</div>
	</div>
</div>
</body>
</html>


-->


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
