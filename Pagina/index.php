<?php 
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>TS</title>
	<style type="text/css">
		body {
			background-color: lightgrey;
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
</head>
<body>
	<div>
	<div align="center">
		<h2>Bienvenid@ <i id='user'>visitante</i></h2>
	</div>
	<div align="center">
		<h1>Ultimo momento</h1>
		<h3>Somos lo que estabas buscando</h3> 
		<p>Travel Share, el servicio para compartir viajes mas completo del pais!!!</p>
		<p>Te gustaria crear un viaje y compartirlo???<br/>
			<a href="crearviaje.php">Create una</a></p>
	</div>
	<div align="center" id=viajes>
		<!-- En este div la idea es poner dos opciones
			la primera seria "Crear viaje"
			la segunda "Ver viajes disponibles"
			o algo por el estilo
		-->
		<div class="viaje" align="center" style="box-shadow: 0px 0px 5px 5px lightgrey;">
			Viaje 1 unico viaje
		</div>
	</div>
	<script>
		let visitante = prompt('What is your name?');
		let texto = document.getElementById('user');
		texto.innerText = visitante;
	</script>
	</div>
</body>
</html>