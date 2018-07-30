<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
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

	$viajes = mysqli_query($coneccion, "SELECT * FROM viajes WHERE viajes.usuarios_id=".$user['id']);
	
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
		
		p{
			line-height:0.6;
			
		}
		
		
	</style>
</head>
<body>
	<div id='container'>
	<h2>Mi perfil</h2>
		<div id='menucostado'>
			<h2> <a style="text-decoration:none" href="miperfil.php"> Volver </h2>
			<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
		</div>
		<div id='datos'>
			<h2>Viajes Publicados de: <?php echo $user['nombre']; ?></h2>
			
			
		<!-- si no tiene viajes publicados-->
		<?php if(mysqli_num_rows($viajes) == 0) { ?> 
		
			<p class="grande" style="color:gold;"> Todavia no publicaste ningun viaje. </p> <p> </p>
			<p class="grande"> <a href="crearviaje.php"> Animate </a> </p>
			
		<?php 
		}
		else { 		
			while ($listarviajes=mysqli_fetch_array($viajes)) {  ?>
				
					<div class="viaje" align="center" style="padding: 10px; font-size:18px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 600px; margin-bottom:15px; float: left">
					<div>
					<p> Origen: <?php echo $listarviajes['origen'] ?> </p>
					<p> Destino: <?php echo $listarviajes['destino'] ?> </p>
					<p> Fecha: <?php echo (Date("d-m-Y",strtotime($listarviajes['fecha']))); ?> </p>
					</div>
					<div>
					<a style="color:white; font-size:22px" href="verviaje.php?id=<?php echo "${listarviajes['id']}" ?>"> Ver Detalles </a>
					<p style="text-align:right;"> <a style="color: white; text-decoration:none;" href="bajaviaje.php?id=<?php echo $listarviajes['id']?>" onclick="return confirm('Estas seguro? si tenes pasajeros ya aceptados vas a recibir automaticamente una calificacion negativa')"> Eliminar Viaje </a> </p>
					</div>
					</div>
				
	<?php	}
		}	?>
			
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>


