<?php 
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	$id = $_GET['id'];

    // si el ID esta vacio, se asume un error y se envia al index
    if(!isset($id) || empty($id)){
    	header('Location: index.php');
    }
    // se bajan los datos de la viaje en $viaje, para despues volcarse en un array. 
    $viaje=mysqli_query($coneccion, "SELECT * FROM viajes WHERE viajes.id=".$id);

    // se colocan los datos de la viaje en un array
    $datoviaje = mysqli_fetch_array($viaje);
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<meta charset="utf-8">
	<title>Compartir</title>
	<style type="text/css">
		body {
			font-family: sans-serif;
			text-align: center;			
		}
		h1 {
			background-color: black;
			padding: 55px;
		}
		/*@keyframes cambiaColor {
			to {
				background-color: grey;
				/*transform: translateY(100px);*/
			}
		}*/
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
	<div>
	<div align="center">
		<h2>Bienvenido <i id='user'>visitante</i></h2>
	</div>
	<div align="center">
		<h1>AVENTON</h1>
		<h3></h3> 
		<p>
			<b> Somos el servicio para compartir viajes mas completo del pais!!!</b><br/>
			Animate a viajar
		</p>
	</div>
	<div align="center" id=viajes > 
		<div align="center" style="padding: 10px; box-shadow: 0px 0px 5px 5px lightblue; width: 800px; margin-bottom:15px;">
			<p>
				<?php echo "Origen: ".$datoviaje['origen'];?><br/>
				<?php echo "Destino: ".$datoviaje['destino'];?><br/> 
				<?php echo "Fecha: ".$datoviaje['fecha'];?><br/>
				<?php echo "Precio: ".$datoviaje['preciototal'];?><br/>
				<?php echo "Vehiculo: ".$datoviaje['vehiculo'];?><br/>
				<?php echo "Contacto: ".$datoviaje['contacto'];?><br/> <!--sacar esta linea en cuanto se registre el conductor del viaje en la BD -->
				<?php echo "Conductor: (COMPLETAR)" ?> <!--Mostrar aca el conductor, (hay que agregarlo a la tabla de viajes), y a su vez, al mostrarlo que este sea un link al pefil del mismo -->
			</p>
		</div>
	</div>
	</div>
</body>
</html>