<?php 
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$datosUsuario = $sesion->datosuser();
	
	
	
		
	//determino si el user tiene deudas pendientes, para ver si mostrar el link a la pagina de pagos
	//??? SE DEBE TESTEAR QUE FUNCIONE COMO SE ESPERA???
	require 'verificardeudas.php';
	
	
	
	
	$idviaje = $_GET['id'];
    // si el ID esta vacio, se asume un error y se envia al index
    if(!isset($idviaje) || empty($idviaje)){
    	header('Location: index.php');
		exit;
    }
    // se bajan los datos de la viaje en $viaje, para despues volcarse en un array. 
    $viaje=mysqli_query($coneccion, "SELECT * FROM viajes WHERE viajes.id=".$idviaje);

	
	//si el viaje no existe informo el error
	if (mysqli_num_rows($viaje) == 0 ) {
		header('Location: index.php?result=3');
		exit;
	}
	
	//defino las constantes usadas en el estado de una postulacion A (ACEPTADO) P (POSTULADO) N (NO POSTULADO) R (RECHAZADO)
	define ('NOPOSTULADO', 'N'); //esta constante Nunca se cargaria en la BD, ya que se entiende que si el user no esta en la tabla de postulaciones --> su estado == NOPOSTULADO
	define ('POSTULADO', 'P');
	define ('ACEPTADO', 'A');
	define ('RECHAZADO', 'R');
		
	
    // se colocan los datos de la viaje en un array
    $datoviaje = mysqli_fetch_array($viaje);

    //se busca el vehiculo del viaje por su id
    $vehiculo = mysqli_query($coneccion,"SELECT * FROM vehiculos WHERE vehiculos.id={$datoviaje['vehiculos_id']}");
    // se colocan los datos del vehiculo en un array
    $datovehiculo = mysqli_fetch_array($vehiculo);
	
	//por facilidad de escritura de codigo (por tema de escape de comillas, etc)
	$idConductor = $datoviaje['usuarios_id'];
	
	
	
	//!IMPORANTE: los posibles estados de la postulacion de un user son: NO POSTULADO (N), POSTULADO (P), ACEPTADO (A), RECHAZADO (R)   
	
	//determino si el viaje tiene todas sus plazas ocupadas
	$queryplazas = mysqli_query($coneccion, "SELECT * FROM postulaciones WHERE viajes_id={$datoviaje['id']}	AND estado='A' "); 
	if (!$queryplazas) {
		header('Location: index.php?result=4');
		exit;
	}
	$plazasLlenas = false;
	$plazasOcupadas = (mysqli_num_rows($queryplazas));
	if (($datoviaje['plazas']) == $plazasOcupadas) {
		$plazasLlenas = true;
	}
	
	//determino si el user actual esta: no postulado (N), postulado (P), aceptado (A), o rechazado (R) en el viaje.
	$userEstado = NOPOSTULADO;
	$querypostulados = mysqli_query($coneccion, "SELECT * FROM postulaciones WHERE viajes_id={$datoviaje['id']}"); 
	while ($postulado = mysqli_fetch_array($querypostulados)){
		if ($postulado['postulados_id'] == $datosUsuario['id']) {
			switch ($postulado['estado']){
				case POSTULADO:
					$userEstado = POSTULADO;
					break;
				case ACEPTADO:
					$userEstado = ACEPTADO;
					break;
				case RECHAZADO:
					$userEstado = RECHAZADO;
					break;	
			}
		}		
	}
	
		
	//obtengo el nombre del conductor
	$sql = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE id={$idConductor}");
	if (!$sql) { //si no puedo obtenerlo retorno error
		header('Location: index.php?result=4');
		exit;
	}
	
	$datosConductor = mysqli_fetch_array($sql);
	$nombreConductor = $datosConductor['nombre'];
	

	$colorMensaje = "lightgreen";
	$mensaje = "&nbsp";
	
	if (!empty($_GET['result'])) {
		switch ($_GET['result']){
			case '1': 
				$mensaje = "Postulacion exitosa. Chequea \"Mis Postulaciones\" para saber cuando te acepten";
				break;
			case '2':
				$mensaje = "La postulacion no pudo realizarse. Intentalo de nuevo"; 
				$colorMensaje = "red";
				break;
			default:
				$mensaje = "error desconocido";		
		}		
	}
	
	
?>



<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<meta charset="utf-8">
	<title>Compartir</title>
	<style type="text/css">
		body {
			font-family: sans-serif;
			text-align: center;			
		}
		h1 {
			background-color: black;
			padding: 55px;
		}
		
		#container{
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
		}
		
		#menucostado{
			float: left;
			width: 20%;
		}
		
		.datos{
			float: right;
			width: 79%;
		}
		
		
	</style>
	<script src="jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$("#botonver").click(function(){
			    $("#viajes").slideToggle();
			}); 
		}); 
	</script>
</head>
<body>
	<div id='container'>
	<h2>Bienvenido <i id='user'>  <?php echo ($logeado ? $_SESSION['usuario'] : 'visitante') ?> </i></h2>
	<div id='menucostado'>
		<p><a href="index.php" style="text-decoration:none">INICIO</a></p>
	</div>
	<div class='datos' align="center">
		<h1>AVENTON</h1> 
		<p>Somos el servicio para compartir viajes mas completo del pais!!!<br/>
		Animate a viajar</p>
	<p style="color:<?php echo $colorMensaje; ?>; font-size:20px"> <?php echo $mensaje; ?> </p>
	<div align="center" style="padding: 10px 10px 45px 10px; box-shadow: 0px 0px 5px 5px lightblue; background-color:rgb(100, 00, 200); width: 800px; margin-bottom:15px; line-height:0.8;">
		<?php
		if ($logeado) { ?>
	<p style="font-size:20px;float:left"> <a style="text-decoration:none" href="consultas.php?id=<?php echo "${idConductor}&viaje=${idviaje}" ?>" > Consultas </p> 	<?php	} ?>
	

	<?php
	//si el user no tiene deudas
	if (!$tieneDeudas) {
		if (!$plazasLlenas) { ?>
		<p style="color:lightblue; font-size:20px" align="right"> Plazas ocupadas: <?php echo " $plazasOcupadas de {$datoviaje['plazas']} " ?> </p> <!-- mostrar la cantidad de plazas ocupadas-->
		<?php }
		else { ?>
			<p style="color:red; font-size:20px" align="right"> Las <?php echo $datoviaje['plazas'] ?> plazas estan ocupadas </p>
		<?php 
		} ?>
		<p> Origen: <?php echo  $datoviaje['origen'] ?> </p>
		<p> Destino: <?php echo $datoviaje['destino']?> </p> 
		<p> Fecha:<?php echo (Date("d-m-Y",strtotime($datoviaje['fecha']))); ?></p>
		<p> Horario: <?php echo (Date("H:i",strtotime($datoviaje['fechayhora']))); ?> </p>
		<p> Duracion Estimada: <?php echo (Date("H:i",strtotime($datoviaje['duracion']))); ?> (horas:minutos)</p>
		<p> Precio: <?php echo $datoviaje['preciototal'] ?></p>			
		<p> Vehiculo: <?php echo "${datovehiculo['marca']}  ${datovehiculo['modelo']}" ?></p>
		<?php //si el user es el conductor muestro un link para ver los postulados
		if ($datosUsuario['id'] == $idConductor) { ?>
			<form action="verpostulados.php">
				<input type="hidden" name="id" value="<?php echo $idviaje ?>">
				<input type="submit" value="Ver postulados" style="width:14em; height:3em; font-size:25px; color:white; border-color:white; background-color:lightblue;">
			</form>
		<?php }
		else { //si no es el conductor, me fijo su estado de postulacion para ver que opciones mostrarle
			switch ($userEstado) { 
			case NOPOSTULADO:
				if (!$plazasLlenas&&$logeado) { ?>
				<form action="altapostulacion.php" onsubmit="return confirm('Estas seguro que queres postularte?')" method="POST">
					<input type="submit" value="Postulate!" style="width:12em; height:2em; font-size:30px; background-color:black; color:white; border: 2px solid darkgrey">
					<input type="hidden" name="viaje_id" value="<?php echo $idviaje ?>">
				</form> 
				<?php 
				}
				if($plazasLlenas) { ?>
						<p style="font-size:20px; color:red"> No podes postularte, todas las plazas de este viaje estan ocupadas</p>
					
				 <?php } if(!$logeado){ ?> <p style="font-size:20px; color:red"> Debes ser un usuario registrado e iniciar sesion para postularte</p>
				<?php } 
				break;
			case POSTULADO: ?>
				<p style="color:gold; font-size:20px; line-height:1"> Estas postulado a este viaje. <br>
				Te vamos a avisar en esta misma pagina cuando el conductor responda a tu postulacion</p>
				<?php
				break;
			case RECHAZADO: ?>
				<p style="color:red; font-size:20px; line-height:1"> El conductor del viaje rechazo tu postulacion. <br>
				No vas a poder participar en este viaje. </p>
				<?php
				break;
			case ACEPTADO: ?>
				<p style="color:gold; font-size:20px; line-height:1"> Has sido aceptado en el viaje!. <br>
				Chequea los datos del conductor para ponerte en contacto con el: <br> <a href="verperfil.php?id=<?php echo $idConductor ?>&viaje=<?php echo $idviaje ?>"> Ver Datos del Conductor <p>
				<?php
				break;			
			} 
		} ?>
		<p style="font-size:20px;float:left"> <a style="text-decoration:none" href="verperfil.php?id=<?php echo "${idConductor}&viaje=${idviaje}" ?>" > Conductor: <?php echo $nombreConductor ?> (ver perfil)</p>
		<?php //si el user es el conductor muestro un link para eliminar el viaje
		if ($datosUsuario['id'] == $idConductor) { ?>
			<p style="font-size:20px;float:right"><span style="float:right;"> <a style="color: white; text-decoration:none;" href="bajaviaje.php?id=<?php echo $datoviaje['id']?>" onclick="return confirm('Estas seguro? si tenes pasajeros ya aceptados vas a recibir automaticamente una calificacion negativa')"> Eliminar Viaje </a> </p>
		<?php }
	}
	//si tiene deudas pendientes
	else { ?>
		<div style="text-align:center">
		<p  style="font-size:25px"> Tenes viajes pendientes por pagar. </p>
		<p style="font-size:25px"> Si no los pagas, no podras continuar utilizando el servicio</p>	
		<a href="mispagos.php" style="font-size:25px"> Podes pagar tus viajes siguiendo este enlace</a> 
		<div>
	<?php 
	} ?>
	
	</div>	
	</div>
	</div>
</body>
</html>