<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user = $sesion->datosuser();

	
	
	//si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
		exit;
	}
	
	
	//obtengo las calificaciones pendientes  
	$sqlcalificaciones = mysqli_query($coneccion, "SELECT * FROM calificaciones INNER JOIN viajes ON calificaciones.viaje_id=viajes.id WHERE calificaciones.calificador_id={$user['id']} AND puntaje = -1  "); 
	
	
	if(!$sqlcalificaciones) {
		header('Location: index.php?result=4');
		exit;
	}
	
	$tieneCalificaciones = mysqli_num_rows($sqlcalificaciones) != 0 ? true : false;

	

	
	if(!empty($_GET['result'])){
		switch ($_GET['result']) {
			case '1':
				$result='Calificacion registrada con exito';
				$color= "lightgreen";
				break;
			case '2':
				$result='Error al realizar la operacion con la base de datos';
				$color="red";
				break;
			case '3':
				$result='No elegiste un puntaje';
				$color= "red";
				break;
			case '4':
				$result='No se ha definido un usuario al cual calificar';
				$color= "red";
				break;
			default:
				$result='Error desconocido';
				$color="red";}
	}else{
			$result = '&nbsp;';
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
		
		p, span{
		font-size:20px;
		line-height:0.3;
	}
	
	
	
	
	label { 
		color:black;
		font-size:40px;
	}

	.calificacion{
		direction: rtl;
		unicode-bidi: bidi-override;
	}

	input[type = "radio"]{ 
		display:none;
	}

	label:hover,
	label:hover ~ label{color:gold;}
	input[type = "radio"]:checked ~ label{color:gold;}


	
		
	</style>
</head>
<body>
	<div id='container'>
	<h2>Mis Calificaciones Pendientes</h2>
		<div id='menucostado'>
		<h2> <a style="text-decoration:none" href="miperfil.php"> Volver </h2>
			<h3> <a href="index.php" style="text-decoration:none">INICIO</a></h3>
		</div>
		<div id='datos'>
			<p style="font-size:25px; color:<?php echo $color ?> "> <?php echo $result ?> </p> <p> &nbsp </p>
			<?php 
			if (!$tieneCalificaciones) { ?>
				<p> No tenes ninguna calificacion pendiente </p>
					
			<?php }
			else {
				while ($cali = mysqli_fetch_array($sqlcalificaciones) ) {
					
					$sqluser = mysqli_query ($coneccion, "SELECT * FROM usuarios WHERE id={$cali['calificado_id']}");
					
					if (!$sqluser) {
						header('Location: index.php?result=412'); //DEBUG este deberia ser result 4. lo cambia para identificarlo momentanemante nomas
						exit;
					}
					$user = mysqli_fetch_array($sqluser);
					?>
					<div align="center" style="padding: 10px; font-size:18px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 500px; margin-bottom:15px; float: left">
					<p> Viaje: </p>
					<p> Origen: <?php echo $cali['origen'] ?> </p>
					<p> Destino: <?php echo $cali['destino'] ?> </p>
					<p> Fecha: <?php echo (Date("d-m-Y",strtotime($cali['fecha']))); ?> </p>
				
					<p> Usuario: <?php echo $user['nombre'] ?> </p> <!--POR AHI SE DEBA DISTINGUIR ENTRE CONDUCTOR Y PASAJERO????  En ese caso se haria algo como-->
					<?php // if ($cali['calificaciones.calificado_id'] == $cali['viajes.user_id'])  es el conductor, sino es un pasajero ?>
					<p> <a style="color:white; font-size:22px" href="verviaje.php?id=<?php echo "${cali['id']}" ?>"> Ver mas detalles </a> </p>
					<p> Calificar al usuario por este viaje: 
					<div class="calificacion">
					<form action="altacalificacion.php" method="POST">
						<p class="calificacion">
						<input id="radio1" type="radio" name="puntaje" value="5"><!--
						--><label for="radio1" title="Excelente" >★</label><!--
						--><input id="radio2" type="radio" name="puntaje" value="4"><!--
						--><label for="radio2" title="Muy Buena" >★</label><!--
						--><input id="radio3" type="radio" name="puntaje" value="3"><!--
						--><label for="radio3" title="Buena">★</label><!--
						--><input id="radio4" type="radio" name="puntaje" value="2"><!--
						--><label for="radio4" title="Regular">★</label><!--
						--><input id="radio5" type="radio" name="puntaje" value="1"><!--
						--><label for="radio5" title="Mala">★</label>
					  </p>
					 </div>
					<p> Comentarios: </p>
					<input type="text" name="descripcion" maxlength="99" size="30">   <!-- si lo pongo como textarea me pueden ingresar valores nulos que me hacen fallar la query al subir la calificacion. -->
									
					<input type="hidden" name="viaje" value="<?php echo  $cali['viaje_id'] ?>" >
					<input type="hidden" name="calificado" value="<?php echo  $cali['calificado_id'] ?>" >
					<input type="submit" value="Calificar"> 
					</form>
				
					</div>	
			
				<?php } ?>
				
			<?php }	?>
		  
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
