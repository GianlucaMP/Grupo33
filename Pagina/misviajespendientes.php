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

	
	
	
	date_default_timezone_set("America/Argentina/Buenos_Aires");	
	
	
	//obtengo la fecha actual (tipo string con formato Y-m-d)
	$fechaactual = date("Y-m-d"); 
	
	
	
	//tomo todos los viajes pendientes como conductor
	
	//??? PENDIENTE CORREGIR EL TEMA DE LA FECHA DE LA QUERY PARA QUE SOLO MUESTRE VIAJES AUN NO REALIZADOS????
	
	$viajesComoConductor = mysqli_query($coneccion, "SELECT * FROM viajes WHERE usuarios_id={$user['id']} AND fecha>='".$fechaactual."'" );  
	
	//echo "fecha vale: <br>"; //DEBUG
	//echo "fechaactual vale:  $fechaactual <br>";		//DEBUG
	
	if(!$viajesComoConductor) {
		header('Location: miperfil.php?result=30');
		exit;
	}
	
	
	//tomo todos los viajes pendientes como pasajero
	
	//??? PEENDIENTE FALTA CORREGIR EL TEMA DE LA FECHA DE LA QUERY PARA QUE SOLO MUESTRE VIAJES AUN NO REALIZADOS????
	
	$viajesComoPasajero = mysqli_query($coneccion, "SELECT viajes.* FROM postulaciones INNER JOIN  usuarios ON postulaciones.postulados_id=usuarios.id  INNER JOIN viajes ON viajes.id=postulaciones.viajes_id WHERE postulaciones.postulados_id={$user['id']} AND viajes.fecha>='".$fechaactual."' "); 
	
	if(!$viajesComoPasajero) {
		header('Location: miperfil.php?result=30');
		exit;
	}
	
	
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
			width: 20%;
		}
		#datos{
			float: right;
			width: 79%;
		}
		
		.grande {
			font-size: 25px;
			text-align:center;
			margin: 0;
		}
		
		p{
			line-height:0.8;
			
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
			<div id="izq" align="center" style="float: left;width:470px">
			<h2>Viajes Pendientes como conductor:</h2>	
			<!-- si no tiene viajes publicados-->
			<?php if(mysqli_num_rows($viajesComoConductor) == 0) { ?> 
				<p class="grande" style="color:gold;"> No tenes ningun viaje pendiente como conductor</p>
			<?php 
			}
			else { 		
				while ($listarviajes=mysqli_fetch_array($viajesComoConductor)) {  ?>
					
						<div class="viaje" align="center" style="padding: 10px; font-size:18px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 300px; margin-bottom:15px; float: middle">
						<div>
						<p> Origen: <?php echo $listarviajes['origen'] ?> </p>
						<p> Destino: <?php echo $listarviajes['destino'] ?> </p>
						<p> Fecha: <?php echo (Date("d-m-Y",strtotime($listarviajes['fecha']))); ?> </p>
						</div>
						<div>
						<a style="color:white; font-size:22px" href="verviaje.php?id=<?php echo "${listarviajes['id']}" ?>"> Ver Detalles </a>
						</div>
						</div>
					
		<?php	}
			}	?>
			</div>
			<div id="der" align="center" style="float: right; width:470px ">
			<h2>Viajes Pendientes como pasajero/postulado:</h2>
			<?php if(mysqli_num_rows($viajesComoPasajero) == 0) { ?> 
				<p class="grande" style="color:gold;"> No tenes ningun viaje pendiente como pasajero/postulado</p>
			<?php 
			}
			else { 		
				while ($listarviajes=mysqli_fetch_array($viajesComoPasajero)) {  ?>		
						<div class="viaje" align="center" style="padding: 10px; font-size:18px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 300px; margin-bottom:15px; float: middle;">
						<div>
						<p> Origen: <?php echo $listarviajes['origen'] ?> </p>
						<p> Destino: <?php echo $listarviajes['destino'] ?> </p>
						<p> Fecha: <?php echo (Date("d-m-Y",strtotime($listarviajes['fecha']))); ?> </p>
						</div>
						<div>
						<a style="color:white; font-size:22px" href="verviaje.php?id=<?php echo "${listarviajes['id']}" ?>"> Ver Detalles </a>
						</div>
						</div>
					
		<?php	}
			}	?>
			</div>
		<div style="clear: both;"></div>
		</div>
	</div>
</body>
</html>


