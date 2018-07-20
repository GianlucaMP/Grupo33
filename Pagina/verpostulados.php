<?php // Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
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
	
	if (!isset($_GET['id'])){
		header('Location: index.php?result=9999'); //retorno un error desconocido. Ya que a este caso no se deberia llegar mediante un uso "normal" de la pagina
		exit;
	}
	
	
//defino las constantes usadas en el estado de una postulacion A (ACEPTADO) P (POSTULADO) N (NO POSTULADO) R (RECHAZADO)
define ('NOPOSTULADO', 'N'); //esta constante nunca se cargaria en la BD, ya que se entiende que si el user no esta en la tabla de postulaciones --> su estado == NOPOSTULADO
define ('POSTULADO', 'P');
define ('ACEPTADO', 'A');
define ('RECHAZADO', 'R');	
	
if(!empty($_GET['result'])){
		switch ($_GET['result']) {
			case '1':
				$result='Postulante aceptado con exito';
				$color= "lightgreen";
				break;
			case '2':
				$result='Postulante rechazado con exito';
				$color="lightgreen";
				break;
			case '3':
				$result='Error al realizar la operacion';
				$color= "red";
				break;
			case '4':
				$result='No hay mas plazas disponibles en el viaje';
				$color= "red";
				break;
			default:
				$result='Error desconocido.';
				$color="red";
		}
}else{
	$result = '&nbsp;';
}

	// se bajan los datos del viaje en $viaje, para despues volcarse en un array. 
    $sqlviaje = mysqli_query($coneccion, "SELECT * FROM viajes WHERE viajes.id=".$_GET['id']);
	if (!$sqlviaje) {
 		header('Location: miperfil.php?result=30');
		exit;
 	}
	$viaje = mysqli_fetch_array($sqlviaje);
	
	
	
	//SELECCIONO los campos tanto de la tabla de postualciones Y usuarios CON RESPECTO a los campos tanto DONDE la id del viaje es la que se recibe por GET, y el usuario es postulado
	$postulados = mysqli_query ($coneccion, "SELECT postulaciones.*,usuarios.nombre FROM postulaciones INNER JOIN usuarios ON postulaciones.postulados_id=usuarios.id  WHERE postulaciones.viajes_id={$_GET['id']} AND postulaciones.estado='P'");
	if (!$postulados) {
 		header('Location: miperfil.php?result=30');
		exit;
 	}

	//SELECCIONO los campos tanto de la tabla de postualciones Y usuarios CON RESPECTO a los campos tanto DONDE la id del viaje es la que se recibe por GET y el usuario es aceptado
	$pasajeros = mysqli_query ($coneccion, "SELECT postulaciones.*,usuarios.nombre FROM postulaciones INNER JOIN usuarios ON postulaciones.postulados_id=usuarios.id  WHERE postulaciones.viajes_id={$_GET['id']} AND postulaciones.estado='A'");
	if (!$pasajeros) {
 		header('Location: miperfil.php?result=30');
		exit;
 	}
	
	
	//SELECCIONO los campos tanto de la tabla de postualciones Y usuarios CON RESPECTO a los campos tanto DONDE la id del viaje es la que se recibe por GET y el usuario es rechazado
	$rechazados = mysqli_query ($coneccion, "SELECT postulaciones.*,usuarios.nombre FROM postulaciones INNER JOIN usuarios ON postulaciones.postulados_id=usuarios.id  WHERE postulaciones.viajes_id={$_GET['id']} AND postulaciones.estado='R'");
	if (!$rechazados) {
 		header('Location: miperfil.php?result=30');
		exit;
 	}
	
	
	//guardo info basica sobre la cantidad de pasajeros y postulados
	$cantidadPasajeros = (mysqli_num_rows($pasajeros));
	$cantidadPostulados = (mysqli_num_rows($postulados));
	$tienePasajeros = $cantidadPasajeros != 0;	
	$tienePostulados = $cantidadPostulados != 0;
	$tieneRechazados = mysqli_num_rows($rechazados) != 0;
	
	
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<title></title>
	<script type="text/javascript" src="js/js_viajes.js"></script>
	<style type="text/css">
		#container{
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
		}
		#menucostado{
			float: left;
			width: 25%;
		}
		#datos{
			float: right;
			width: 74%;
		}
		
		.grande {
			font-size: 22px;
			text-align:center;
			margin: 0;
		}
		
		.dorado {
			color:gold;
		}
		
		

		<!--???El layout de esta pagina esta hecho muy por arriba, deberia ser re-hecho desde 0???-->
		
	</style>
</head>
<body>
	<div id='container'>
	<h2>Mi perfil</h2>
		<div id='menucostado'>
			<h2> <a style="text-decoration:none" href="misviajespublicados.php">Volver</h2>
			<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
		</div>
		<div id='datos'>
			<h1>Lista de pasajeros y postulados al viaje: </h1>
			<h2>Desde: <span class="dorado"> <?php echo $viaje['origen']; ?>  </span> hacia: <span class="dorado"> <?php echo $viaje['destino']; ?> </span> el dia: <span class="dorado"> <?php echo (Date("d-m-Y",strtotime($viaje['fecha']))); ?> </span> a las:  <span class="dorado"> <?php echo (Date("H:i",strtotime($viaje['fecha']))); ?> </span> </h2> 
			<p id="error" style="color: <?php echo $color; ?>;"><?php echo $result?></p> 
			<div style="clear:both">
			<h2> Pasajeros (<?php echo $cantidadPasajeros ?> de <?php echo $viaje['plazas'] ?>): </h2>
			<?php
			if (!$tienePasajeros) {?>
				<p class="grande" style="color:gold; float:left" > No tenes ningun pasajero en este viaje </p>
			<?php }
			while ($listarpasajeros = mysqli_fetch_array($pasajeros)) {  ?>		
				<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 600px; margin-bottom:15px; float: left">
				<div>
					<p> Usuario: <?php echo $listarpasajeros['nombre'] ?> </p>
					<a style="color:white" href="verperfil.php?id=<?php echo "{$listarpasajeros['postulados_id']}&viaje=${viaje['id']} "?>">Ver Perfil</a>
				</div>
				</div>
			<?php }	?>
			<p> </p>
			</div>
			<div style="clear:both; padding: 40px 0">
			<h2> Postulados (<?php echo $cantidadPostulados ?>): </h2>
			<?php
			if (!$tienePostulados) {?>
				<p class="grande" style="color:gold; float:left"> No tenes ningun postulado en este viaje </p>
			<?php }
			while ($listarpostulados = mysqli_fetch_array($postulados)) {  ?>		
				<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 600px; margin-bottom:15px; float:left">
				<div>
				<p> Usuario: <?php echo $listarpostulados['nombre'] ?> </p>
				<a style="color:white" href="verperfil.php?id=<?php echo "{$listarpostulados['postulados_id']}&viaje=${viaje['id']} "?>">Ver Perfil</a>
				</div>
				<div>
				<a style="color:white; text-decoration:none; color:lightgreen" href="altarespuestapostulacion.php?postulado=<?php echo "${listarpostulados['postulados_id']}&viaje=${listarpostulados['viajes_id']}&accion=aceptar" ?>" > Aceptar </a>
				<a style="color:white; text-decoration:none; color:red" href="altarespuestapostulacion.php?postulado=<?php echo "${listarpostulados['postulados_id']}&viaje=${listarpostulados['viajes_id']}&accion=rechazar" ?>"> Rechazar </a>
				</div>
				</div>
			<?php }	?>		
			</div>
			<div style="clear:both; padding: 40px 0">
			<h2> Postulados rechazados: </h2>
			<?php
			if (!$tieneRechazados) {?>
				<p class="grande" style="color:gold; float:left" > No rechazaste a ningun postulado en este viaje</p>
			<?php }
			while ($listarrechazados = mysqli_fetch_array($rechazados)) {  ?>		
				<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 600px; margin-bottom:15px; float: left">
				<div>
					<p> Usuario: <?php echo $listarrechazados['nombre'] ?> </p>
					<a style="color:white" href="verperfil.php?id=<?php echo "{$listarrechazados['postulados_id']}&viaje=${viaje['id']} "?>">Ver Perfil</a>
				</div>
				</div>
			<?php }	?>
			<p> </p>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>

