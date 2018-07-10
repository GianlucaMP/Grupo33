<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	
	// Se chequea si el usuario esta logeado y se deja en una variable
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	//$user = $sesion->datosuser();
	if(!empty($_GET['result'])){
		switch ($_GET['result']) {
		case '1':
			$result = 'Viaje creado con exito!';
			$color = "lightgreen";
			break;
		case '2':
			$result = 'Error al crear el viaje :(';
			$color = "red";
			break;
		case '3':
			$result = 'el viaje indicado no existe';
			$color = "red";
			break;
		case '4':
			$result = 'Error en la operacion con la base de datos. Intentalo de nuevo';
			$color = "red";
			break;
		case '5':
			$result = 'El viaje que deseas administrar no te pertenece';
			$color = "red";
			break;
		case '6': //DEBUG
			$result = 'Error en la consulta a la BD. seguro esta mal escrita'; //DEBUG
			$color = "red"; //DEBUG
			break; //DEBYG
		default:
			$result = 'Error desconocido.';
			$color = "red";
		}
	}else{
		$result = '&nbsp;';
	}

	
	//Se verifica que llegue "por" a travez de get, esto define de que manera se van a listar las peliculas. Si llega, un case hace el resto, si no, por defecto se hara por momento en el que se agrego.
	if(isset($_GET['por'])){
		if(isset($_GET['orden'])){
			switch ($_GET['orden']) {
				case 'ASC':
					$orden = 'ASC';
					break;
				
				default:
					$orden = 'DESC';
					break;
			}
		}else{
			$orden = 'DESC';
		}
		
		// "por" define el orden en el que se muestra, y hay una query para cada cosa.
		switch ($_GET['por']) {
			case 'fecha':
				$viajes=mysqli_query($coneccion, "SELECT * FROM viajes ORDER BY fecha ".$orden." ");
				break;

			case 'precio':
				$viajes=mysqli_query($coneccion, "SELECT * FROM viajes ORDER BY preciototal ".$orden." ");
				break;
			
			default:
				$viajes=mysqli_query($coneccion, "SELECT * FROM viajes ORDER BY id ".$orden." ");
				break;
		}
		// si no hay por, se hace el default, por orden de agregado.
	}else{
		$viajes=mysqli_query($coneccion, "SELECT * FROM viajes ORDER BY id DESC");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<meta charset="utf-8">
	<title>Aventon: Somos lo que estabas buscando</title>
	<style type="text/css"> 
		body {
			font-family: sans-serif;
			text-align: center;
		}
		h1 {
			padding: 55px;
		}
		#container{
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
		}
		#bienvenide{
			float: left;
			width: 40%;
		}
		#reg{
			float: right;
			width: 59%;
		}
		<!--						//comentado para poder aplicar todo el estilo con violeta y blanco
		@keyframes cambiaColor {
			to {
				background-color: grey;
				/*transform: translateY(100px);*/
			}
		}
		-->
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
	<div id="container">
	<div id="encabezado">
		<img src="partes\Logo.jpg" width="200" height="100" align="left"> </>
		<div id="bienvenide" align="center"><h2>Bienvenido <i id='user'>
			<?php
			if (!$logeado) echo 'visitante';
			else echo $_SESSION['usuario'] ; ?></i></h2></div>
		<div id="reg" align="right">
			<?php include('partes/arriba.php'); ?>
		</div>
		<div style="clear: both;"></div>
	</div>

	<div align="center">
		<h1 style="background-color:black;">AVENTON</h1>
		<h3>Somos lo que estabas buscando</h3>
		<p>Aventon, el servicio para compartir viajes mas completo del pais!!!</p>
		<p>¿Te gustaria crear un viaje y compartirlo?<br/>
			<?php if($logeado) { ?>
				<a href="crearviaje.php">Crear un viaje</a> <?php }
				else echo "Debes estar logeado para crear un viaje"; ?>
				<p id="error" style="color: <?php echo $color; ?>;font-size:25px"><?php echo $result?></p><!-- //////////////////// -->
			</p>
		<div id="menuarriba">
				<p>Orden Agregados <a href="index.php?por=agreg&orden=ASC">&#8593;</a> <a href="index.php?por=agreg&orden=DESC">&#8595;</a> | Por fecha <a href="index.php?por=fecha&orden=ASC">&#8593;</a> <a href="index.php?por=fecha&orden=DESC">&#8595;</a> | Por precio <a href="index.php?por=precio&orden=ASC">&#8593;</a> <a href="index.php?por=precio&orden=DESC">&#8595;</a></p>
		</div>
	</div>
	<div align="center" id=viajes>
		<?php
		while ($listarviajes=mysqli_fetch_array($viajes)) {  
			$fechaactual = Date("Y-m-d");
			$fechaevento = $listarviajes['fecha'];
			if ($fechaactual <= $fechaevento) {
				echo '<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px darkgray; width: 800px; margin-bottom:15px;">';
				echo '<div>';
				echo "Origen: ".$listarviajes['origen']."<br/>";
				echo "Destino: ".$listarviajes['destino']."<br/>";
				echo "Fecha: ".$listarviajes['fecha']."<br/>";
				echo'</div>';
				echo '<div>';
				echo '...<a style="color: white;" href="verviaje.php?id='.$listarviajes['id'].'">Ver Mas</a>';
				echo '</div>';
				echo '</div>';
			}//
		}
		?>
	</div>
	</div>
</body>
</html>
