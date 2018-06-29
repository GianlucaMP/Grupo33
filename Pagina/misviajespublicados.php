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
	}

	$viajes=mysqli_query($coneccion, "SELECT * FROM viajes WHERE viajes.usuarios_id=".$user['id']);
	
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
	</style>
</head>
<body>
	<div id='container'>
	<h2>Mi perfil</h2>
		<div id='menucostado'>
			<h2> <a style="text-decoration:none" href="miperfil.php">Volver</h2	></p>
		</div>
		<div id='datos'>
			<h4>Viajes Publicados: <?php echo $user['nombre']; ?></h3>
			<?php
			while ($listarviajes=mysqli_fetch_array($viajes)) {  
				
					echo '<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px darkgray; width: 600px; margin-bottom:15px; float: left">';
					echo '<div>';
					echo "Origen: ".$listarviajes['origen']."<br/>";
					echo "Destino: ".$listarviajes['destino']."<br/>";
					echo "Fecha: ".$listarviajes['fecha']."<br/>";
					echo'</div>';
					echo '<div>';
					echo '...<a style="color: white;" href="postulados.php?id='.$listarviajes['id'].'">Ver Postulados</a>';
					echo '</div>';
					echo '</div>';
				
			}
			?>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
