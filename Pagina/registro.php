<?php
	//Un intento de registro de usuario retorna a este lugar (onda codigo recursivo)
	// se chequea si llego el parametro get "error", si llego, se informa el error por su codigo segun reg.php
	if (!empty($_GET['error'])) {
		switch ($_GET['error']) {
			case '1':
				$error = 'Uno o mas campos estan en blanco.';
				break;

			case '2':
				$error = 'El nombre de usuario no puede tener menos de 6 caracteres ni mas de 16.';
				break;

			case '3':
				$error = 'La clave debe tener mayusculas, minusculas y un numero y/o caracter, ademas de ser al menos 6 caracteres de longitud.';
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

			case '8':
				$error = 'Las claves no son iguales';
				break;

			case '9':
				$error = 'Debe ser mayor de edad para registrarse';
				break;
				
			case '10':
				$error = 'El numero de telefono contiene caracteres invalidos';
				break;		
			
			case '11':
				$error = 'El numero de telefono no es valido';
				break;
			case '12':
				$error = 'Error al realizar la operacion en la base de datos';	
				break;
			default:
				$error = 'Error desconocido.';
				break;
		}
	}else{
		$error = '&nbsp;';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>TS</title>
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
		input{
			width:200px;
		}
		
		#container{
			width: 1000px;
			margin-left: auto;
			margin-right: auto;
		}
		#bienvenide{
			float: left;*/
			width: 40%;
		}
		#reg{
			float: right;
			width: 59%;
		}
		@keyframes cambiaColor {
			to {
				background-color: grey;
				/*transform: translateY(100px);*/
			}
		}
	</style>
	<script src="jquery.min.js"></script>
	<script>								//???QUE HACE ESTE SCRIPT????
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
		<div id="bienvenide" align="center"><h2>Bienvenido <i id='user'>visitante</i></h2></div>	</div>
	<div style="clear: both;"></div>
	<div align="center">
		<h1>AVENTON</h1>
	</div>
	<div align="center" id=viajes>
	<?php
				session_start();
				if(isset($_SESSION['usuario'])){
			?>
				<p>Error: Ya estas logeado en una cuenta.</p>
			<?php }else{
				?>
				<form method="POST" action="reg.php" style="padding-bottom: 20px">

					<fieldset>
						<legend>Crea tu cuenta</legend>
						<input class="registroinput" id="user" type="text" name="user" placeholder="Nick">
						<input class="registroinput" id="email" type="text" name="mail" placeholder="Tu e-mail"> <br/>
						<input id="clave" class="registroinput" type="password" name="pass" placeholder="Clave">
						<input id="claveconf" class="registroinput" type="password" name="passconf" placeholder="Ingresa la clave de nuevo"> <br/>
						<input id="name" class="registroinput" type="text" name="name" placeholder="Nombre">
						<input id="date" class="registroinput" type="date" name="date" placeholder="Fecha de nacimiento"> <br/>  <!--???el placeholder nunca se muestra, deberiamos ponerlo de otra manera-->
						<input class="registroinput" id="telefono" type="text" name="telefono" placeholder="Telefono"> <br>
						<input class="botonregistro" style="margin: 10px" type="submit" onclick="return registrovacio()" value="Registrate">
					</fieldset>
					<p id="error" style="color: red;"><?php echo $error?></p>
					<p style="color: gray;"><small>*El nick no puede tener mas de 16 caracteres</small></p>
					<p style="color: gray;"><small>**La clave debe tener al menos una mayuscula y un numero o simbolo</small></p>
				</form>
				<?php
			}
				?>
	</div>
	</div>
</body>
</html>
