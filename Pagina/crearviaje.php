<?php
//Tras un intento de crear viaje vuelve aca en un estilo recursivo
if (!empty($_GET['error'])) {
		switch ($_GET['error']) {
			case '1':
				$error = 'El campo precio esta en blanco';
				break;
			case '2':
				$error = 'El campo origen esta en blanco';
				break;
			case '3':
				$error = 'El campo destino esta en blanco';
				break;
			case '4':
				$error = 'No se selecciono una fecha';
				break;
			case '5':
				$error = 'El campo horario esta en blanco';
				break;
			case '6':
				$error = 'El campo duracion esta en blanco';
				break;
			case '7':
				$error = 'No se eligio ningun vehiculo'; //este creo que no puede pasra nunca y convedria hacer un chequeo de otro tipo ???
				break;
			case '8':
				$error = 'El campo plazas esta en blanco';
				break;
			case '20':
				$error = 'Ha ingresado una fecha invalida';
				break;
			default:
				$error = 'error desconocido';
		}	
}

else{
		$error = '&nbsp;';
	}
	// Se crea la conexion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();

	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user= $sesion->datosuser();
	
	// se chequea si esta logeado, y si no lo esta se lo redirecciona al inicio.
	if(!$logeado){
		header('Location: index.php');
	}
	//si esta logeado cargo varios datos del usuario en la variable $datosUsuario
	else {
		$datosUsuario = $sesion->datosuser();
	}
	
	//$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");
	#este es la consulta vieja cuando los vehiculos tenian el campo unico de id de usuario

	//SELECCIONO los campos que se mencionan DE la tabla de vehiculos Y la tabla de enlace DONDE los campos de enlace y de vehiculo (vehiculos_id) son iguales y DE usuarios DONDE los campos de enlace y de usuarios (usuarios.id) son iguales
	$vehiculos=mysqli_query($coneccion,"SELECT vehiculos.* FROM vehiculos INNER JOIN enlace ON enlace.vehiculos_id=vehiculos.id INNER JOIN usuarios ON enlace.usuarios_id=usuarios.id WHERE usuarios.id=".$user['id']);

	
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<title></title>
	<!--<script type="text/javascript" src="js/js_viajes.js"></script>-->
</head>
<style>					

input, select { 			/*se busca definir que todos los elementos de los formularios tengan tamano/forma similar para que queden parejos*/
    width: 200px;
	margin: auto 0;
}

.chiquito{ 			/*para definir un tamano chico y uniforme de los campos para ingresar horas o numeros de pocas cifras. Tambien para que una casilla quede pegada al texto que la describe*/
	width: 40px;
}

.grande {
	font-size: 25px;
	text-align:center;
	margin: 0;
}


<!-- IMPORTANTE!!!!

FALTAN HACER PROBABLEMNTE ALGUNOS CHEQUEOS DE LOS NUEVOS CAMPOS DEL FORMULARIO (todos los datos del vehiculo) EN EL ARCHIVO AGREGARVIAJE.PHP

FALTA AGREGAR EL CALENDARIO PARA VIAJES PERIODICOS

IMPORATNTE BUG HACE QUE EL CHECBOX DE VIAJE PERIODICO QUEDE INVERTIDO (mostrando el resto del formu opuesto) SI SE MARCA, SE LLENA MAL EL FORMU Y SE VUELVE PARA ATRAS... CORREGIR -->
	

</style>
<body>
	<h2>Agregar nuevo viaje</h2>
	
	
		<!-- si no tiene vehiculos-->
		<?php if(mysqli_num_rows($vehiculos) == 0) { ?> 
		
			<p class="grande" style="color:gold;">Aviso: No tenes ningun vehiculo registrado. </p
			>
			<p class="grande">Antes de crear un viaje vas a necesitar <a href="registrarvehiculo.php"> registrar un vehiculo </a> </p>
		
		<?php } else { ?>
			
		<div class="formulario"> <!-- defino un div para poder dar un formato mas lindo a todo el formulario en su conjunto-->
		<form method="POST" enctype="multipart/form-data" action="agregarviaje.php" align="justify">		
			<fieldset>
			<fieldset>
			<p>Precio: <input type="number" id="preciototal" name="preciototal" min="0" max="1000000"></p>	
			<p>Origen: <input type="text" id="origen" name="origen"></p>	
			<p>Destino: <input type="text" id="destino" name="destino"></p>
			<p>Este viaje se realizara periodicamente
			<input type=checkbox id="periodico" name="periodico" onclick=intercambiarOcasionalPeriodico() class="chiquito" title="si el viaje se realizara periodicamente debes marcar esta casilla"> </p>	
			<div id="formularioOcasional">	
			<p>Fecha: <input type="date" id="fecha" name="fecha"></p>
			</div>
			<div id="formularioPeriodico" style="display:none">
			<p> IMAGINATE QUE SOY UN CALENDARIO</p> 
			<!--???AGREGAR EL CALENDARIO EN CASO DE QUE SEA PERIODICO??? --> 
			</div>
			<!--			
			<p> Horario de Salida: <input type="number" id="horario" name="horario" min="0" max="23" class="chiquito"> horas</p>
			<p> Duracion Estimada: <input type="number" id="duracion" name="duracion" min="1" max="200"  class="chiquito"> horas </p>-->
			<p> Duracion Estimada: <input type="time" id="duracion" name="duracion" style="width: 90px"> horas </p>
			</fieldset>	<p> </p>		
			
			
			<fieldset>
			<!--USAR SEGURAMENTE EVENTO HTML onChange() para llamar script que llene los valores de los campos del auto
			Parece que no se puede invocar a PHP con eventos, por lo que capaz que tenga que por PHP cargar en la pagina todos los datos del auto de una, y luego con javascript tomar la variable en cuestion de PHP e ir llenando los campos-->
			<p>Vehiculo: <select id="vehiculo" name="vehiculo">
				<?php while($listarvehiculos = mysqli_fetch_array($vehiculos)){
					echo '<option value="'.$listarvehiculos['id'].'">'.$listarvehiculos['marca'].' '.$listarvehiculos['modelo'].'  ('.$listarvehiculos['plazas'].' plazas)</option>';
				} ?>
			</select></p>
			<p> Plazas disponibles para pasajeros: <input type="number" id="plazas" name="plazas" class="chiquito">  </p> 	<!-- ????CARGAR EL VALOR POR PHP??? -->
			<p style="font-size:small"> *De todas las plazas que posee el vehiculo, una de ellas sera ocupada por el conductor. Ingresa aqui la cantidad de plazas restantes que pueden ser ocupadas por pasajeros </p>
			<!--<p> Modelo:<input type="text" id="modelo" name="modelo" readonly> </p> 		-->		<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR CON READONLY??? -->
			<!--<p> Marca:<input type="text" id="marca" name="marca" readonly> </p>			-->		<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR CON READONLY??? -->
			<!--<p> Color:<input type="text" id="color" name="color" readonly> </p>			-->		<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR CON READONLY??? -->
			<!--<p> Patente:<input type="text" id="patente" name="patente" readonly> </p> 	-->		<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR CON READONLY??? -->
			</fieldset>	<p> </p> 
			
			
			<fieldset>
			<!--Los datos de contacto son readonly para que el user sepa que se envian. pero en realidad se toman siempre de los datos de contacto cargados en su perfil)-->
			<p>Email de Contacto: <input type="text" id="contacto" name="contacto" value=<?php echo $datosUsuario['email'] ?> readonly> </p>
			<p>Telefono de Contacto: <input type="text" id="telefono" name="telefono" value=<?php echo $datosUsuario['telefono'] ?> readonly> </p>
			<input type="hidden" name="creador" value="<?php echo ''.$user['id'].'' ?>"> 
			<p>Tus datos de contacto seran compartidos con los pasajeros con los que aceptes compartir el viaje. </p>
			<p> Si queres modificar tus datos de contacto, hacelo desde  <a href="editarusuario.php"> Editar Perfil </a> </p>
			</fieldset> <p> </p>
			
			<input type="hidden" id="flagRegistro" name="flagRegistro" value="1"> <!--permite saber si se hizo un intento de registro con chequear si $_POST['flagRegistro'] === 1 -->
			
			<input type="submit" class="botonregistro" onclick="return viaje()" style="margin-bottom: 20px;" value="Crear viaje">
			<p id="error" style="color: red;"><?php echo $error?></p>
			</fieldset> 
		</form>
		</div>
		
		<?php }  ?>
</body>
</html>

<script>

function intercambiarOcasionalPeriodico() {
    var x = document.getElementById("formularioOcasional");
    var y = document.getElementById("formularioPeriodico");
    if (x.style.display === "none") {
        x.style.display = "block";
		y.style.display = "none";
    } else {
        x.style.display = "none";
		y.style.display = "block";
    }
}
</script>


