<?php
//Tras un intento de crear viaje vuelve aca en un estilo recursivo
if (!empty($_GET['error'])) {
		switch ($_GET['error']) {
			case '1':
				$error = 'Uno o mas campos estan en blanco.';
				break;

			case '2':
				$error = 'Ha ingresado una fecha invalida';
				break;}}
else{
		$error = '&nbsp;';
	}
	// Se crea la coneccion a la SQL y se coloca en $coneccion
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
	//si esta logeado cargo varios datos del usuario en la variable $datosUsuario ???puede que ya halla una variable para esto, en ese caso modificarlo???
	else {
		$datosUsuario = $sesion->datosuser();
	}
	
	$vehiculos=mysqli_query($coneccion, "SELECT * FROM vehiculos WHERE usuarios_id = '".$user['id']."'");
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


</style>
<body>
	<h2>Agregar nuevo viaje</h2>
		<div class="formulario"> <!-- defino un div para poder dar un formato mas lindo a todo el formulario en su conjunto-->
		<form enctype="multipart/form-data" method="POST" action="agregar.php" align="justify" >
			<fieldset>
			<fieldset>
			<p>Precio Total: <input type="number" id="preciototal" name="preciototal" min="0" max="1000000"></p>	
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
						
			<p> Horario de Salida: <input type="number" id="horario" name="horario" min="0" max="23" class="chiquito"> horas</p>
			<p> Duracion Estimada: <input type="number" id="duracion" name="duracion" min="1" max="200"  class="chiquito"> horas </p>
			</fieldset>	<p> </p>		
			
			
			<fieldset>
			<!--USAR SEGURAMENTE EVENTO HTML onChange() para llamar script que llene los valores de los campos del auto
			cParece que no se puede invocar a PHP con eventos, por lo que capaz que tenga que por PHP cargar en la pagina todos los datos del auto de una, y luego con javascript tomar la variable en cuestion de PHP e ir llenando los campos-->
			<p>Vehiculo: <select id="vehiculo" name="vehiculo">
				<?php while($listarvehiculos = mysqli_fetch_array($vehiculos)){
					//???Sugiero mostrar solo marca modelo y patente del vehiculo en la version final. Aunque en la version de prueba dejarlo asi, ver si se puede hacer una compilacion condiccional???
					echo '<option value="'.$listarvehiculos['id'].'">'.$listarvehiculos['marca'].' '.$listarvehiculos['modelo'].' | '.$listarvehiculos['plazas'].' plazas</option>';
				} ?>
			</select></p>
			<p> Plazas disponibles para pasajeros: <input type="number" id="plazas" name="plazas" class="chiquito">  </p> 	<!-- ????CARGAR EL VALOR POR PHP??? -->
			<p style="font-size:small"> *De todas las plazas que posee el vehiculo, una de ellas sera ocupada por el conductor. Ingresa aqui la cantidad de plazas restantes que pueden ser ocupadas por pasajeros </p>
			<p> Modelo:<input type="text" id="modelo" name="modelo" readonly> </p>		<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR CON READONLY??? -->
			<p> Marca:<input type="text" id="marca" name="marca" readonly> </p>			<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR CON READONLY??? -->
			<p> Color:<input type="text" id="color" name="color" readonly> </p>			<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR CON READONLY??? -->
			<p> Patente:<input type="text" id="patente" name="patente" readonly> </p>	<!-- ????CARGAR EL VALOR POR PHP Y MOSTRAR QUE NO SE PEUDE CAMBIAR CON READONLY??? -->
			</fieldset>	<p> </p>
			
			
			<fieldset>
			<!--por el momento los datos de contacto son readonly para que el user sepa que se envian. pero en realidad se toman siempre de los datos de contacto cargados en su perfil
			Para cambiar esto. hay que sacar el readoly, que en la BD se creen viajes con email y contacto "personalizados" (y no sacados de la tabla users)-->
			<p>Email de Contacto: <input type="text" value=<?php echo $datosUsuario['email'] ?> readonly> </p>
			<p>Telefono de Contacto: <input type="text" id="telefono" name="telefono" value=<?php echo $datosUsuario['telefono'] ?> readonly> </p> 
			<!-- ????en cuanto los datos de contacto dejen de ser readonly hay que verificarlos???-->
			</fieldset> <p> </p>
			
			<input type="hidden" id="flagRegistro" name="flagRegistro" value="1"> <!--permite saber si se hizo un intento de registro con chequear si $_POST['flagRegistro'] === 1 -->
			
			<input type="submit" class="botonregistro" onclick="return viaje()" style="margin-bottom: 20px;" value="Crear viaje">
			<p id="error" style="color: red;"><?php echo $error?></p>
			</fieldset> 
		</form>
		</div>
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


<!-- IMPORTANTE!!!!

FALTAN HACER TODOS LOS CHEQUEOS DE LOS NUEVOS CAMPOS DEL FORMULARIO (todos los datos del vehiculo) EN EL ARCHIVO AGREGARVIAJE.PHP
FALTA AGREGAR EL CALENDARIO PARA VIAJES PERIODICOS-->
