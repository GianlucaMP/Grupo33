<?php

	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	
	// se chequea si esta logeado, y si no lo esta se lo redirecciona al inicio.
	if(!$logeado){
		header('Location: index.php');
		exit;
	}
	
	$user = $sesion->datosuser();
	

		
	
	//obtengo los pagos pendientes
	$sqlpagos = mysqli_query($coneccion, "SELECT * FROM pagos WHERE usuarios_id={$user['id']} AND pago='F' ");

	if (!$sqlpagos){
		header('Location: index.php?result=4');
		exit;
	}
	
	//determino si el usuario tiene deudas
	$tieneDeudas = (mysqli_num_rows($sqlpagos) > 0) ? true : false;
	
	

	//obtengo los pagos realizados
	$sqlpagosrealizados = mysqli_query($coneccion, "SELECT * FROM pagos WHERE usuarios_id={$user['id']} AND pago='T' ");

	if (!$sqlpagosrealizados){
		header('Location: index.php?result=4');
		exit;
	}
	
	//determino si el usuario tiene pagos ya realizados
	$tienePagosRealizados = (mysqli_num_rows($sqlpagosrealizados) > 0) ? true : false;
	
	
	
	if(!empty($_GET['result'])){
		switch ($_GET['result']) {
			case '1':
				$mensaje='Pago realizado con exito';
				$color= "lightgreen";
				break;
			case '2':
				$mensaje='El pago no se pudo completar';
				$color= "red";
				break;
			case '5':
				$mensaje='El campo "tarjeta" esta vacio'; 
				$color= "red";
				break;
			case '6':
				$mensaje='El campo "titular" esta vacio'; 
				$color= "red";
				break;
			case '7':
				$mensaje='El campo "fecha de vencimiento" esta vacio';
				$color= "red";
				break;
			case '8':
				$mensaje='El campo "codigo de seguridad" esta vacio';
				$color= "red";
				break;
			case '9':
				$mensaje='Numero de tarjeta no valido';
				$color= "red";
				break;
			case '10':
				$mensaje='Fecha de vecimiento no valida';
				$color= "red";
				break;
			case '11':
				$mensaje='Codigo de seguridad no valido';
				$color= "red";
				break;
			default: 
				$mensaje='Error desconocido';
				$color= "red";
		}
	}	
	else {
		$mensaje='&nbsp;';
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
	<h2>Mis Pagos</h2>
	<div id='menucostado'>
		<h2> <a href="miperfil.php" style="text-decoration:none">Volver </a></h2>
		<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
	</div>
	<div id='datos'>
		<p id="error" style="color: <?php echo $color; ?>;font-size:25px"><?php echo $mensaje?></p>
		<?php if ($tieneDeudas) { ?>
			<p  style="font-size:25px"> Tenes viajes pendientes por pagar. </p>
			<p style="font-size:25px"> Si no los pagas, no podras continuar utilizando el servicio</p>		
		<?php }
		else { ?>
			<p style="font-size:25px"> No tenes ningun viaje pendiente por pagar</p>
		
		<?php } ?>
		<div>
		<br> 
		<br> 
		
		
		<h2> Pagos Realizados </h2>
		<?php if (!$tienePagosRealizados) { ?>
			<p  style="font-size:22px"> No tenes ningun pago realizado </p>
		<?php }
		else { 
			//muestro la informacion de cada pago realizado
			while ($pagoRealizado = mysqli_fetch_array($sqlpagosrealizados)) {
				
				//obtengo la informacion del viaje asociado a ese pago
				$sqlviaje  = mysqli_query($coneccion, "SELECT * FROM viajes WHERE id={$pagoRealizado['viajes_id']} ");

				if (!$sqlviaje){
					header('Location: index.php?result=4');
					exit;
				}
				$viaje = mysqli_fetch_array($sqlviaje);  ?>
				
				<div class="pago" align="center" style="padding: 10px; font-size:18px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 600px; margin-bottom:15px; float: left">
				<h2 style="text-decoration:underline"> Viaje </h2>
				<p> Origen: <?php echo $viaje['origen'] ?>  </p>
				<p> Destino: <?php echo $viaje['destino'] ?>  </p>
				<p> Fecha: <?php echo (Date("d-m-Y",strtotime($viaje['fecha']))); ?>  </p>
				<p> Importe: $<?php echo $viaje['preciototal'] ?>  </p>
				</div>
			
		<?php
			}
		} ?>
		</div>		
		<br> 
		<br> 
		
		<?php if ($tieneDeudas) { ?>
			
		<div>
		<h2> Pagos Pendientes </h2>
		
		<!--??? PENDIENTE ??? HAY QUE DARLE UN FORMATO ACEPTABLE A ESTA PAGINA, QUE SEGURO QUEDO TODO DESORDENADO, LA PARTE DE PAGAR, Y SI HAY MAS DE UN VIAJE PARA PAGAR-->
		<!--itero por sobre cada pago pendiente y muestro un boton para pagar por el mismo-->
		<?php while ($pago = mysqli_fetch_array($sqlpagos)) {
			
			//obtengo la informacion del viaje asociado a ese pago
			$sqlviaje  = mysqli_query($coneccion, "SELECT * FROM viajes WHERE id={$pago['viajes_id']} ");

			if (!$sqlviaje){
				header('Location: index.php?result=4');
				exit;
			}
			$viaje = mysqli_fetch_array($sqlviaje);
			
		?>
			<div class="pago" align="center" style="padding: 10px; font-size:18px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 600px; margin-bottom:15px; float: left">
			<h2 style="text-decoration:underline"> Viaje </h2>
			<p>Origen: <?php echo $viaje['origen'] ?>  </p>
			<p>Destino: <?php echo $viaje['destino'] ?>  </p>
			<p>Fecha: <?php echo (Date("d-m-Y",strtotime($viaje['fecha']))); ?>  </p>
			<p>Importe: $<?php echo $viaje['preciototal'] ?>  </p>
			<button type="button"  onclick=mostrarFormulario() style="font-size:25px;  margin:auto;  width:30%"> Pagar viaje </button>
			<div id='formularioTarjeta'  style="display:none">
				<form action="altapago.php" method="POST" enctype="multipart/form-data" align="justify" onsubmit="return confirm('Estas seguro que quieres efectuar el pago?')">
					<fieldset>
					<p>Numero de tarjeta: <input type="text" id="tarjeta" name="tarjeta"  placeholder="xxxx-xxxx-xxxx-xxxx" value="<?php echo  (  (isset($_SESSION['tarjeta']) && (!empty($_SESSION['tarjeta'])))  ?  $_SESSION['tarjeta'] : ''  ); ?>"></p>
					<p>Titular de la tarjeta: <input type="text" id="titular" name="titular" value="<?php echo  (  (isset($_SESSION['titular']) && (!empty($_SESSION['titular'])))  ?  $_SESSION['titular'] : ''  ); ?>"></p>
					<p>Fecha de vencimiento: <input type="string" id="fecha" name="fecha" placeholder="mm/aa" maxlength="5" value="<?php echo  (  (isset($_SESSION['fecha']) && (!empty($_SESSION['fecha'])))  ?  $_SESSION['fecha'] : ''  ); ?>"></p>
					<p>Codigo de seguridad: <input type="number" id="codigo" name="codigo" min="0" max="999" placeholder="999" value="<?php echo  (  (isset($_SESSION['codigo']) && (!empty($_SESSION['codigo'])))  ?  $_SESSION['codigo'] : ''  ); ?>" ></p>
					<input type="hidden" id="pago" name="pago" value="<?php echo $pago['id'] ?>">
					<input type="submit" value="Realizar Pago">
					</fieldset>
				</form>			
			</div>
			
			</DIV>
			</div>		
		<?php
		} ?>

		
		
		<?php
		} ?>
		
		
	<div style="clear: both;"></div>
	</div>
</body>
</html>

<script>

function mostrarFormulario() {
    var x = document.getElementById("formularioTarjeta");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

</script>