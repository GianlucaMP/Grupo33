<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user = $sesion->datosuser();

	$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");

	// si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
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
	<h3>Mi perfil</h3>
		<div id='menucostado'>
			<p> <a href="editar.php">Editar Perfil</a></p>
			<p> <a href="registrarvehiculo.php">Agregar vehiculo</a></p>
			<p> <a href="index.php">INICIO</a></p>
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
				<h4>Listado de Vehiculos</h4>
				<?php
				while ($listarvehiculos=mysqli_fetch_array($vehiculos)) {
					echo '<div class="viaje" align="center" style="padding: 10px; box-shadow: 0px 0px 5px 5px darkgrey; width: 800px; margin-bottom:15px;">';
					echo "Marca: ".$listarvehiculos['marca']."<br/>";
					echo "Modelo: ".$listarvehiculos['modelo']."<br/>";
					echo "Color: ".$listarvehiculos['color']."<br/>";
					echo "Plazas: ".$listarvehiculos['plazas']."<br/>";
					echo "Patente: ".$listarvehiculos['patente']."<br/>";
					echo '<a href="modificarvehiculo.php?id='.$listarvehiculos['id'].'">Modificar vehiculo</a>';
					echo '</div>';
				}
				?>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
