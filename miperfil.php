<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user = $sesion->datosuser();
	
	
	//SELECCIONO los campos que se mencionan DE la tabla de vehiculos Y la tabla de enlace DONDE los campos de enlace y de vehiculo (vehiculos_id) son iguales y DE usuarios DONDE los campos de enlace y de usuarios (usuarios.id) son iguales y que el vehiculo no este eliminado
	$vehiculos = mysqli_query ($coneccion,"SELECT vehiculos.* FROM vehiculos INNER JOIN enlace ON enlace.vehiculos_id=vehiculos.id INNER JOIN usuarios ON enlace.usuarios_id=usuarios.id WHERE usuarios.id={$user['id']}  AND enlace.eliminado='N' ");

	
	//chequeo si falla la consulta
	if (!$vehiculos) {
		header('Location: index.php?result=4');
		exit;
	}
	
	//si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
		exit;
	}
	if(!empty($_GET['result'])){
		switch ($_GET['result']) {
			case '1':
				$result='Vehiculo agregado con exito';
				$color= "lightgreen";
				break;
			case '2':
				$result='Hubo un error al agregar el vehiculo';
				$color="red";
				break;
			case '3':
				$result='Vehiculo eliminado con exito';
				$color= "lightgreen";
				break;
			case '4':
				$result='Hubo un error al eliminar el vehiculo';
				$color="red";
				break;
			case '41':
				$result='El vehiculo a eliminar tiene viajes pendientes. Podras borrarlo cuando terminen esos viajes';
				$color="red";
				break;	
			case '42':
				$result='El vehiculo que intentas eliminar no te pertenece.';
				$color="red";
				break;		
			case '5':
				$result='Vehiculo modificado con exito';
				$color= "lightgreen";
				break;
			case '6':
				$result='Hubo un error al modificar el vehiculo';
				$color="red";
				break;
			case '7':
				$result='Perfil editado con exito';
				$color="lightgreen";
				break;
			case '8':
				$result='El viaje fue eliminado con exito';
				$color="gold";
				break;
			case '9':
				$result='El viaje que queres eliminar pertenece a otro usuario';
				$color="red";
				break;
			case '10':
				$result='El viaje que queres eliminar no existe, o hubo un error en la transaccion con la base de datos';
				$color="red";
				break;
			case '11':
				$result='Error al operar con la base de datos, el viaje NO pudo ser eliminado. Intentalo de nuevo';
				$color="red";
				break;
			case '20':
				$result='Hubo un error al eliminar tu cuenta';
				$color="red";
				break;
			case '21':
				$result='La cuenta que queres eliminar no te pertenece';
				$color="red";
				break;
			case '22':
				$result='Error al eliminar el usuario. Intentalo de Nuevo';
				$color="red";
				break;
			case '23':
				$result='El usuario a eliminar tiene viajes pendientes. No se pudo eliminar';
				$color="red";
				break;
			case '30':
				$result= 'Hubo un error al realizar la operacion con la base de datos. Intentalo de nuevo';
				$color='red';
				break;
			default:
				$result='Error desconocido.';
				$color="red";}
	}else{
			$result = '&nbsp;';
	}
	
	
	
	
	//calculo la edad para poder mostrarla
	$f1 = new DateTime($user['fecha']);
	$f2 = new DateTime("now");
	$edad =  ($f1->diff($f2))->format("%y");

	
	
	//simplifico el codigo
	$userid = $user['id'];
	
	
	//obtengo las calificaciones del user
	$sqlcalificacion = mysqli_query($coneccion, "SELECT * FROM calificaciones INNER JOIN usuarios ON calificador_id = usuarios.id WHERE calificado_id = $userid AND puntaje<>-1");

	
	if (!$sqlcalificacion) {
		header('Location: index.php?result=4');
		exit;
	}
	
	
	//por el momento lo hago 2 veces, necesito primero obtener el promedio
	$otrosql = mysqli_query($coneccion, "SELECT * FROM calificaciones WHERE calificado_id = $userid AND puntaje<>-1");

	
	
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
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<title>
	</title>
	<script type="text/javascript" src="js/js_viajes.js"></script>
	<style type="text/css">
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
		
		p{
			line-height:0.6;			
		}
		
	</style>
</head>
<body>
	<div id='container'>
	<h2>Mi perfil</h2>
		<div id='menucostado'>
			<p> <a href="editarusuario.php" style="text-decoration:none">Editar Perfil</a></p>
			<p> <a href="registrarvehiculo.php" style="text-decoration:none">Agregar vehiculo</a></p>
			<p> <a href="misviajespendientes.php" style="text-decoration:none" title="Viajes aun no realizados en los que soy conductor, pasajero o postulado" >Mis Viajes Pendientes</a></p>
			<p> <a href="calificar.php" style="text-decoration:none" title="Todas las calificaciones pendientes"> Mis Calificaciones Pendientes</a></p>
			<p> <a href="misviajespublicados.php" style="text-decoration:none" title="Todos los viajes publicados por mi como conductor" >Mis Viajes Publicados</a></p>
			<p> <a href="mispagos.php" style="text-decoration:none" title="Lista de pagos pendientes y realizados como conductor y pasajero" >Mis Pagos</a></p>
			<p> <a href="eliminarusuario.php" style="text-decoration:none">Eliminar cuenta</a></p>
			<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
		</div>
		<div id='datos'>
			<div>
				<ul style="font-size:20px">
					<li><b>Nick: </b><?php echo " ".$user['nombreusuario']." "; ?></li>
					<li><b>Nombre: </b><?php echo " ".$user['nombre']." "; ?></li>
					<li><b>Reputacion: </b> <span style="color:<?php echo $colorReputacion ?> "> <?php echo $reputacion ?>  <span>  </li>
					<li><b>Edad: </b><?php echo $edad ?> </li>
					<li><b>Email: </b><?php echo " ".$user['email']." "; ?></li>					
				</ul>
			</div>
			<div align="left">
				<p id="error" style="color: <?php echo $color; ?>;"><?php echo $result?></p>
				<h2>Vehiculos</h2>
				<?php
				$tieneVehiculos = false;
				while ($listarvehiculos=mysqli_fetch_array($vehiculos)) {
					$tieneVehiculos = true; //no es muy lindo el codigo pero se entiende y sirve
					echo '<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 700px; margin-bottom:15px;">';
					echo "Marca: ".$listarvehiculos['marca']."<br/>";
					echo "Modelo: ".$listarvehiculos['modelo']."<br/>";
					echo "Color: ".$listarvehiculos['color']."<br/>";
					echo "Plazas: ".$listarvehiculos['plazas']."<br/>";
					echo "Patente: ".$listarvehiculos['patente']."<br/>";
					echo '<a href="editarvehiculo.php?id='.$listarvehiculos['id'].'">Modificar vehiculo</a> <a href="eliminarvehiculo.php?id='.$listarvehiculos['id'].'">Eliminar vehiculo</a>';
					echo '</div>';
				}
				if (!$tieneVehiculos){ 
					?>  <div align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 800px; margin-bottom:15px;"> 
						<p style="font-size:25px	"> No tenes ningun vehiculo registrado :( </p>
						<a href="registrarvehiculo.php" style="font-size:17px"> Registra tu vehiculo</a> para poder crear un viaje y compartirlo con otros usuarios </a>
					</div><?php
				}
				?>
			
			<h2> Calificaciones </h2>
			<p style="font-size:20px"> El usuario tiene <?php echo $cantidadvotos ?> calificacion/es que promedian una reputacion <span style="color:<?php echo $colorReputacion ?> "> <?php echo $reputacion ?>  <span> </p>
			
			<?php while ($cali = mysqli_fetch_array($sqlcalificacion)) { ?>
				<div class="calificacion" align="left" style="padding: 10px; color:white; font-size:20px; box-shadow: 0px 0px 5px 5px lightblue; width: 700px; margin-bottom:15px;">
				<p style="font-size:22px; margin:0px"  > <?php echo $cali['nombre'] ?>: </p> 
				<p style="align:right"> Puntaje:
				<span style="color:gold"> <?php for ($i=1; $i <= $cali['puntaje']; $i++) { echo "★"; } ?></span><!--
				--><span style="color:black"><?php for ($i=1; $i <= (5 - $cali['puntaje']) ; $i++) { echo "★"; }    ?>  </p>		
				<?php if(empty($cali['descripcion'])) { $cali['descripcion'] = "-------"; } ?>
				<p> Comentarios: <?php echo $cali['descripcion'] ?> </p>	
			
			<?php } ?>
			
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>


<!--	 lo comento, porque no es 100% necesario y queda corrido haciendo quedar mal la pagina
<footer>
<div class="footer" align="right">
	<a href="ayuda.php" style="font-size:20px; text-decoration:none" >Ayuda</a> <span> &nbsp &nbsp </span>
	<a href="contacto.php" style="font-size:20px; text-decoration:none ">Contacto</a>
</div>
</footer>

-->
		
	
</body>
</html>
