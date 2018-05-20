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
	<meta charset="utf-8">
	<title>Compartir</title>
	<style type="text/css">
		body {
			background-color: white;
			font-family: sans-serif;
			text-align: center;
			
			
		}
		h1 {
			background-color: black;
			padding: 55px;
			color: white;
			/*animation: cambiaColor 3000ms infinite alternate;*/

		}
		@keyframes cambiaColor {
			to {
				background-color: grey;
				/*transform: translateY(100px);*/
			}
		}
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
		<h2>Bienvenid@ <i id='user'>visitante</i></h2>
	</div>
	<div align="center">
		<h1>TravelShare</h1>
		<h3></h3> 
		<p>
			<b> Somos el servicio para compartir viajes mas completo del pais!!!</b><br/>
			Animate a viajar
		</p>
		<!--<p>Te gustaria crear un viaje y compartirlo???<br/>
			<a href="crearviaje.php">Creae un viaje</a></p>
		-->
	</div>
	<div align="center" id=viajes > 
		<div align="center" style="padding: 10px; box-shadow: 0px 0px 5px 5px darkgrey; width: 800px; margin-bottom:15px;">
			<p>
				<?php echo "Origen: ".$datoviaje['origen'];?><br/>
				<?php echo "Destino: ".$datoviaje['destino'];?><br/> 
				<?php echo "Fecha: ".$datoviaje['fecha'];?><br/>
				<?php echo "Precio: ".$datoviaje['preciototal'];?><br/>
				<?php echo "Vehiculo: ".$datoviaje['vehiculo'];?><br/>
				<?php echo "Contacto: ".$datoviaje['contacto'];?><br/>
			</p>
		</div>
	</div>
	<!--
	<script>
		let visitante = prompt('What is your name?');
		let texto = document.getElementById('user');
		texto.innerText = visitante;
	</script>
	-->
	</div>
</body>
</html>