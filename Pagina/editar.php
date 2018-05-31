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

	//se hace la consulta de los datos del usuario


	// la accion que se recibe define que se mostrara en la pagina, si no llega nada, accion se iguala a "asd", que puede ser cualquier cosa, para que el chequeo no de error de variable inexistente y simplemente muestre la pagina de bienvenida
	/*if(!isset($_GET['accion'])){
		$accion = 'asd';
	}else{
		$accion = $_GET['accion'];
	}

	if($accion == 'editar'){
		$peliculas = mysqli_query($coneccion, "SELECT * FROM peliculas ORDER BY id");
	}*/
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
			width: 40%;
		}
		#datos{
			float: right;
			width: 59%;
		}
	</style>
</head>
<body> 
	<div id='container'>
	<h3>Mi perfil</h3>
		<div id='menucostado'>
			<p> <a href="editar.php">Editar Perfil</a> </p>
			<p>Ver Listado de vehiculos</p>
		</div>
		<div id='datos'>
			<h4>Editando perfil: <?php echo $user['nombre']; ?></h3>
			<form enctype="multipart/form-data" method="POST" action="edicion.php">
				<p>Nick: <input type="text" id="user" name="user" value="<?php echo $user['nombreusuario']; ?>"></p>
				<p>Nombre: <input type="text" id="name" name="name" value="<?php echo $user['nombre']; ?>"></p>
				<p>Email: <input type="text" id="email" name="mail" value="<?php echo $user['email']; ?>"></p>
				<p>Fecha: <input type="date" id="date" name="date" value="<?php echo $user['fecha']; ?>"></p>
				<!--<p>Descrpcion:</p>
				<textarea name="sinopsis" id="sinopsis" style="width: 450px; height: 200px;"><?php /*echo $datopelicula['sinopsis']; */?></textarea>-->
			<input type="submit" class="botonregistro" style="margin: 10px;" onclick="return registrovacio()" style="margin-bottom: 20px;" value="Listo!">
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>