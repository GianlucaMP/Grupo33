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
				$color="green";
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
	$result = '&nbsp;';}

	//SELECCIONO los campos tanto de la tabla de postualciones Y usuarios CON RESPECTO a los campos tanto DONDE la id del viaje es la que se recibe por GET
	$postulados = mysqli_query ($coneccion,"SELECT postulaciones.*,usuarios.nombre FROM postulaciones INNER JOIN usuarios ON postulaciones.postulados_id=usuarios.id  WHERE postulaciones.viajes_id=".$_GET['id']);

	if ($postulados) {
 		$err = false;}
 	else{
 		$err = true;
 	}

	// se bajan los datos del viaje en $viaje, para despues volcarse en un array. 
    $viaje=mysqli_query($coneccion, "SELECT * FROM viajes WHERE viajes.id=".$_GET['id']);

    // se colocan los datos de la viaje en un array
    $datoviaje = mysqli_fetch_array($viaje);

	
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
			font-size: 25px;
			text-align:center;
			margin: 0;
		}
		

	</style>
</head>
<body>
	<div id='container'>
	<h2>Mi perfil</h2>
		<div id='menucostado'>
			<h2> <a style="text-decoration:none" href="misviajespublicados.php">Volver</h2></p>
		</div>
		<div id='datos'>
			<!--???imprimir esta fecha en un formato mas lindo???-->
			<h3>Postulados al viaje | Desde: <?php echo $datoviaje['origen']; ?>| Hacia: <?php echo $datoviaje['destino']; ?>| El: <?php echo $datoviaje['fecha']; ?></h3> 
			<p id="error" style="color: <?php echo $color; ?>;"><?php echo $result?></p> 
			<?php
			if (mysqli_num_rows($postulados) == 0) {?>
				<p class="grande" style="color:gold"> No tenes ningun postulado en este viaje </p>
			
			<?php }
			while ($listarpostulados = mysqli_fetch_array($postulados)) {  ?>		
				<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px darkgray; width: 600px; margin-bottom:15px; float: left">
				<div>
				<p> Usuario: <?php echo $listarpostulados['nombre'] ?> </p>
			<a style="color:white" href="verperfil.php?id=<?php echo "{$listarpostulados['postulados_id']}&viaje=${datoviaje['id']} "?>">Ver Perfil</a>
				</div>
				<div>
				<a style="color:white; text-decoration:none; color:lightgreen" href="altarespuestapostulacion.php?postulado=<?php echo "${listarpostulados['postulados_id']}&viaje=${listarpostulados['viajes_id']}&accion=aceptar" ?>" > Aceptar </a>
				<a style="color:white; text-decoration:none; color:red" href="altarespuestapostulacion.php?postulado=<?php echo "${listarpostulados['postulados_id']}&viaje=${listarpostulados['viajes_id']}&accion=rechazar" ?>"> Rechazar </a>
				</div>
				</div>
			<?php 
			}
			?>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>

