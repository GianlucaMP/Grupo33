<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user = $sesion->datosuser();
	
	#$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");

	//SELECCIONO los campos que se mencionan DE la tabla de vehiculos Y la tabla de enlace DONDE los campos de enlace y de vehiculo (vehiculos_id) son iguales y DE usuarios DONDE los campos de enlace y de usuarios (usuarios.id) son iguales
	$vehiculos = mysqli_query ($coneccion,"SELECT vehiculos.* FROM vehiculos INNER JOIN enlace ON enlace.vehiculos_id=vehiculos.id INNER JOIN usuarios ON enlace.usuarios_id=usuarios.id WHERE usuarios.id=".$user['id']);

	
	//chequeo si falla la consulta
	if (!$vehiculos) {
		echo "Error en la operacion con la Base de datos";
		exit;
	}
	
	//si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
	}
	if(!empty($_GET['result'])){
		switch ($_GET['result']) {
			case '1':
				$result='Vehiculo agregado con exito';
				$color= "lightgreen";
				break;
			case '2':
				$result=	'Hubo un error al agregar el vehiculo';
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
			default:
				$result='Error desconocido.';
				$color="red";}
	}else{
			$result = '&nbsp;';}
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
	</style>
</head>
<body>
	<div id='container'>
	<h2>Mi perfil</h2>
		<div id='menucostado'>
			<p> <a href="editarusuario.php" style="text-decoration:none">Editar Perfil</a></p>
			<p> <a href="registrarvehiculo.php" style="text-decoration:none">Agregar vehiculo</a></p>
			<p> <a href="misviajespublicados.php" style="text-decoration:none">Mis Viajes Publicados</a></p>
			<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
		</div>
		<div id='datos'>
			<div>
				<ul>
					<li><b>Nick: </b><?php echo " ".$user['nombreusuario']." "; ?></li>
					<li><b>Nombre: </b><?php echo " ".$user['nombre']." "; ?></li>
					<li><b>Email: </b><?php echo " ".$user['email']." "; ?></li>
					<li><b>Fecha de nacimiento: </b><?php echo " ".$user['fecha']." "; ?></li>
				</ul>
			</div>
			<div align="left">
				<p id="error" style="color: <?php echo $color; ?>;"><?php echo $result?></p>
				<h4>Listado de Vehiculos</h4>
				<?php
				$tieneVehiculos = false;
				while ($listarvehiculos=mysqli_fetch_array($vehiculos)) {
					$tieneVehiculos = true; //no es muy lindo el codigo pero se entiende y sirve
					echo '<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 800px; margin-bottom:15px;">';
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
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
