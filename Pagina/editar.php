<?php
	// se chequea si llego el parametro get "error", si llego, se informa el error por su codigo segun reg.php
	if (!empty($_GET['error'])) {
		switch ($_GET['error']) {
			case '1':
				$error = 'Uno o mas campos estan en blanco.';
				break;

			case '2':
				$error = 'El nombre de usuario no puede tener menos de 6 caracteres ni mas de 16.';
				break;
				
			case '4':
				$error = 'El nombre de usuario no puede tener espacios en blanco.';
				break;

			case '5':
				$error = 'El e-mail no es valido.';
				break;

			case '6':
				$error = 'El nombre de usuario ya esta en uso';
				break;

			case '7':
				$error = 'El e-mail ya esta en uso';
				break;

			case '9':
				$error = 'Debe ser mayor de edad para registrarse';
				break;

			default:
				$error = 'Error desconocido.';
				break;
		}
	}else{
		$error = '&nbsp;';
	}
?>
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
			<p> <a href="miperfil.php">Volver</a></p>
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
			<p id="error" style="color: red;"><?php echo $error?></p>
			<p style="color: gray;"><small>El nick no puede tener mas de 16 caracteres</small></p>
			<p style="color: gray;"><small>La clave debe tener al menos una mayuscula, una minuscula, y un numero o simbolo</small></p>
			</form>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
