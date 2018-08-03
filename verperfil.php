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

$sql = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id ={$_GET['id']}"); 

if (!$datosConductor = mysqli_fetch_array($sql)) {
	header('Location: index.php?result=4');
	exit;
}

//puesto por facilidad de escritura de la consulta
$idConductor = $datosConductor['id'];
$idUser = $user['id'];



$sql2 = mysqli_query($conexion, "SELECT postulaciones.* FROM postulaciones INNER JOIN viajes ON postulaciones.viajes_id=viajes.id WHERE viajes.usuarios_id={$datosConductor['id']} AND postulaciones.postulados_id={$user['id']} AND postulaciones.estado='A' ");
if (!$sql2) {
	header('Location: index.php?result=4');
	exit;
	
}
$sql3 = mysqli_query($conexion, "SELECT postulaciones.* FROM postulaciones INNER JOIN viajes ON postulaciones.viajes_id=viajes.id WHERE viajes.usuarios_id={$user['id']} AND postulaciones.postulados_id={$datosConductor['id']} AND postulaciones.estado='A' ");
if (!$sql3) {
	header('Location: index.php?result=4');
	exit;
	
}



//defino si se deben mostrar o no los datos de contacto
$mostrarDatosContacto = false;
//si el conductor es el mismo usuario que esta logeado muestro los datos de contacto
if (($datosConductor['id'] == $user['id'])) {
	$mostrarDatosContacto = true;
}
//si el user actual se postulo a algun viaje de este usuario que estoy visitando el perfil (tengo que tener al menos una columna como resultado), muestro los datos de contacto
if (mysqli_num_rows($sql2) > 0 ) {
	$mostrarDatosContacto = true;
}

//si el usuario que estoy visitando el perfil se postulo a algun viaje del user actual (tengo que tener al menos una columna como resultado), muestro los datos de contacto
if (mysqli_num_rows($sql3) > 0 ) {
	$mostrarDatosContacto = true;
}



//calculo la edad para poder mostrarla
$f1 = new DateTime($datosConductor['fecha']);
$f2 = new DateTime("now");
$edad =  ($f1->diff($f2))->format("%y");


//asumo que el user NO elimino su cuenta
$eliminado = false;
if ($datosConductor['eliminado'] == 'S') {
	$eliminado = true;
}


//simplifico el codigo
$perfilid = $_GET['id'];
	

//obtengo las calificaciones del user
$sqlcalificacion = mysqli_query($conexion, "SELECT * FROM calificaciones INNER JOIN usuarios ON calificador_id = usuarios.id WHERE calificado_id = $perfilid AND puntaje<>-1");


if (!$sqlcalificacion) {
	header('Location: index.php?result=4');
	exit;
}


//por el momento lo hago 2 veces, necesito primero obtener el promedio
$otrosql = mysqli_query($conexion, "SELECT * FROM calificaciones WHERE calificado_id = $perfilid AND puntaje<>-1");



if (!$otrosql) {
	header('Location: index.php?result=4');
	exit;
}

	//obtengo la cantidad de votos y el promedio
	$cantidadvotos = mysqli_num_rows($sqlcalificacion);
	$promedio = 0;
	
	while ($calificacion = mysqli_fetch_array($otrosql)) {
		$promedio = $promedio + $calificacion['puntaje'];
		
	}
	
	
	if ($cantidadvotos != 0) {
	  $promedio = intdiv ($promedio, $cantidadvotos);
	}
	
	
	//determino la reputacion del user
	switch ($promedio) {
		case '5':
			$reputacion="Excelente";
			$colorReputacion= "lightgreen";
			break;
		case '4':
			$reputacion="Muy buena";
			$colorReputacion= "lightgreen";
			break;
		case '3':
			$reputacion="Buena";
			$colorReputacion= "gold";
			break;
		case '2':
			$reputacion="regular";
			$colorReputacion= "red";
			break;
		case '1':
			$reputacion="Mala";
			$colorReputacion= "red";
			break;
		case '0':
			$reputacion="Pendiente (sin calificaciones)"; 
			$colorReputacion= "gold";
			break;
		default;
			$reputacion="Error";
			$colorReputacion= "red";
	}
	



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
		font-size:20px;
		line-height:1;
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
		<div style="padding: 2px 10px; box-shadow: 0px 0px 5px 5px lightblue; width: 700px;">
			<h1> Informacion del usuario: <?php echo $datosConductor['nombre'];
			if ($eliminado){ //si esta eliminada la cuenta, lo aviso por pantalla ?>
				<span style="color:red; font-size:30px"> Cuenta Eliminada </span> <?php
			}?>
			</h1>
			<p> Nombre: <?php echo $datosConductor['nombre'] ?> </p>
			<p> Reputacion: <span style="color:<?php echo $colorReputacion ?> "> <?php echo $reputacion ?> </span> <p> 
			<p> Edad: <?php echo $edad ?> </p>
			<p> Email: <?php  echo ($mostrarDatosContacto ? $datosConductor['email'] : '<span class="alerta"> Debe ser pasajero de algun viaje de este usuario para poder ver sus datos de contacto </span>'  ) ?> </p>
			<p> Telefono: <?php echo ($mostrarDatosContacto ? $datosConductor['telefono'] : '<span class="alerta"> Debe ser pasajero de algun viaje de este usuario para poder ver sus datos de contacto </span>' ) ?> </p>
		</div>
		<p> <br/> </p>
		<h2> Calificaciones </h2>
		<p style="font-size:20px"> El usuario tiene <?php echo $cantidadvotos ?> calificacion/es que promedian una reputacion <span style="color:<?php echo $colorReputacion ?> "> <?php echo $reputacion ?> <span></p>
		
		<?php while ($cali = mysqli_fetch_array($sqlcalificacion)) { ?>
			<div class="calificacion" align="left" style="padding: 10px; color:white; font-size:20px; box-shadow: 0px 0px 5px 5px lightblue; width: 700px; margin-bottom:15px;">
				<p style="font-size:22px; margin:0px"  > <?php echo $cali['nombre'] ?>: </p> 
				<p style="align:right"> Puntaje:
				<span style="color:gold"> <?php for ($i=1; $i <= $cali['puntaje']; $i++) { echo "★"; } ?></span><!--
			 --><span style="color:black"><?php for ($i=1; $i <= (5 - $cali['puntaje']) ; $i++) { echo "★"; } ?>  </p>	
				<?php if(empty($cali['descripcion'])) { $cali['descripcion'] = "-------"; } ?>
				<p> Comentarios: <?php echo $cali['descripcion'] ?> </p>	
			</div>
		<?php } ?>
		
		
	
	<div style="clear: both;"></div>
	</div>
</div>
</body>
</html>

