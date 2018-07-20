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
			case '9':
				$error = 'La cantidad de plazas ingresadas supera el maximo que posee el vehiculo. Acordate que una de las plazas va a ser automaticamente ocupada por el conductor';
				break;	
			case '10':
				$error = 'Error en la operacion con la base de datos. Intentalo de nuevo';
				break;	
			case '11':
				$error = 'El vehiculo tiene otro viaje asignado en ese mismo momento.';
				break;
			case '20':
				$error = 'Ha ingresado una fecha invalida o ya ocurrida';
				break;
			case '21':
				$error = 'Ha ingresado una hora invalida o ya ocurrida';
				break;
			case '22':
				$error = 'El vehiculo elegido para el viaje ha sido eliminado y no puede usarse';
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
		exit();
	}
	//si esta logeado cargo varios datos del usuario en la variable $datosUsuario
	else {
		$datosUsuario = $sesion->datosuser();
	}
	
	
	//SELECCIONO los campos que se mencionan DE la tabla de vehiculos Y la tabla de enlace DONDE los campos de enlace y de vehiculo (vehiculos_id) son iguales y DE usuarios DONDE los campos de enlace y de usuarios (usuarios.id) son iguales
	$vehiculos = mysqli_query($coneccion,"SELECT vehiculos.* FROM vehiculos INNER JOIN enlace ON enlace.vehiculos_id=vehiculos.id INNER JOIN usuarios ON enlace.usuarios_id=usuarios.id WHERE usuarios.id={$user['id']} AND enlace.eliminado='N' ");


	
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

.mediano{
	width: 90px;
}

.grande {
	font-size: 25px;
	text-align:center;
	margin: 0;
}


<!-- ALGUNOS BUGS PENDIENTES:!!!!

capaz  que los errores detectados a nivel javascript impiden que se mantengan los datos del formulario, ya que no se llegan a guardar en PHP. en ese caso, lo facil seria cambiar el javascript por php

bug hace que el checbox de viaje periodico quede invertido (mostrando el resto del formu opuesto) ocurre cuando se marca el checkbox, se llena mal el formu y se vuelve para atras... -->
	
	
</style>
<body>
	<h2>Agregar nuevo viaje </h2>
	<h2> <a/ href="index.php" style="text-decoration:none">volver </a> </h2>
	
	
		<!-- si no tiene vehiculos-->
		<?php if(mysqli_num_rows($vehiculos) == 0) { ?> 
			<p id="error" class="grande" style="color: red;"><?php echo $error?></p>
			<p class="grande" style="color:gold;">Aviso: No tenes ningun vehiculo registrado. </p>
			<p class="grande">Antes de crear un viaje vas a necesitar <a href="registrarvehiculo.php"> registrar un vehiculo </a> </p>
					
		<?php } else { ?>
			
		<div class="formulario"> <!-- defino un div para poder dar un formato mas lindo a todo el formulario en su conjunto-->
		<form method="POST" enctype="multipart/form-data" action="altaviaje.php" align="justify">		
			<fieldset>
			<fieldset>
			<p>Precio: <input type="number" id="preciototal" name="preciototal" min="0" max="1000000" value="<?php echo  (  (isset($_SESSION['preciototal']) && (!empty($_SESSION['preciototal'])))  ?  $_SESSION['preciototal'] : ''  ); ?>" ></p>	
			<p>Origen: <input type="text" id="origen" name="origen" value="<?php echo  (  (isset($_SESSION['origen']) && (!empty($_SESSION['origen'])))  ?  $_SESSION['origen'] : ''  ); ?>"></p>	
			<p>Destino: <input type="text" id="destino" name="destino" value="<?php echo  (  (isset($_SESSION['destino']) && (!empty($_SESSION['destino'])))  ?  $_SESSION['destino'] : ''  ); ?>"></p>
			<p>Este viaje se realizara periodicamente
			<input type=checkbox id="periodico" name="periodico" onclick=intercambiarOcasionalPeriodico() class="chiquito" title="si el viaje se realizara periodicamente debes marcar esta casilla"> </p>	
			<div id="formularioOcasional">	
			<p>Fecha: <input type="date" id="fecha" name="fecha" value="<?php echo  (  (isset($_SESSION['fecha']) && (!empty($_SESSION['fecha'])))  ?  $_SESSION['fecha'] : ''  ); ?>"></p>
			</div>
			<div id="formularioPeriodico" style="display:none">
			<form id="myForm">
			<div id="input1" class="clonedInput" style="margin-bottom: 4px;">Fecha: <input id="name1" type="date" name="name1" /></div>
			<div id="input2" class="clonedInput" style="margin-bottom: 4px;">Fecha: <input id="name2" type="date" name="name2" /></div>
			<div><input id="btnAdd" type="button" style="background:url('icono_mas.png') no-repeat; border:none; width: 24px;height: 24px"/>
			<input id="btnDel" type="button"  disabled="disabled" style="background:url('icono_menos.png') no-repeat; border:none; width: 24px;height: 24px" /></div>
			</form> 
			</div>
						
			Horario de Salida: <input type="time" id="horario" class="mediano" name="horario" value="<?php echo  (  (isset($_SESSION['horario']) && (!empty($_SESSION['horario'])))  ?  $_SESSION['horario'] : ''  ); ?>"> horas:minutos
			<p> Duracion Estimada: <input type="time" id="duracion" name="duracion" class="mediano" value="<?php echo  (  (isset($_SESSION['duracion']) && (!empty($_SESSION['duracion'])))  ?  $_SESSION['duracion'] : ''  ); ?>"> horas:minutos </p>
			</fieldset>	<p> </p>		
			
			
			<fieldset>
			<p>Vehiculo: <select id="vehiculo" name="vehiculo">
				<?php while($listarvehiculos = mysqli_fetch_array($vehiculos)){
					if ((isset($_SESSION['vehiculo'])) && ($_SESSION['vehiculo'] == $listarvehiculos['id'])) { //si el vehiculo ya fue elegido, con esto lo elijo automaticamente
						echo '<option selected="selected" value="'.$listarvehiculos['id'].'">'.$listarvehiculos['marca'].' '.$listarvehiculos['modelo'].'  ('.$listarvehiculos['plazas'].' plazas)</option>';
					}
					else {//en este caso el vehiculo no se eligio previamente asi que NO se preselecciona
						echo '<option value="'.$listarvehiculos['id'].'">'.$listarvehiculos['marca'].' '.$listarvehiculos['modelo'].'  ('.$listarvehiculos['plazas'].' plazas)</option>';
					}
				} ?>
			</select></p>
			<p style="font-size:small"> *Los datos de tu vehiculo seleccionado seran compartidos con todo aquel que consulte los detalles del viaje</p>
			<p> Si queres modificar los datos de tu vehiculo, hacelo desde  <a href="miperfil.php"> Mi Perfil </a> </p>
			<p> Plazas disponibles para pasajeros: <input type="number" id="plazas" name="plazas" class="chiquito" value="<?php echo  (  (isset($_SESSION['plazas']) && (!empty($_SESSION['plazas'])))  ?  $_SESSION['plazas'] : ''  ); ?>">  </p> 	<!-- ????CARGAR EL VALOR POR PHP??? -->
			<p style="font-size:small"> *De todas las plazas que posee el vehiculo, una de ellas sera ocupada por el conductor. Ingresa aqui la cantidad de plazas restantes que pueden ser ocupadas por pasajeros </p>
			</fieldset>	<p> </p> 
			
			
			<fieldset>
			<!--se muestran los datos de contacto que van a ser visibles a los pasajeros (pero NO se pueden cambiar) -->
			<p>Email de Contacto: <input type="text" id="email" name="email" value=<?php echo $datosUsuario['email'] ?> readonly > </p>
			<p>Telefono de Contacto: <input type="text" id="telefono" name="telefono" value=<?php echo $datosUsuario['telefono'] ?> readonly> </p>
			<input type="hidden" name="creador" value="<?php echo ''.$user['id'].'' ?>"> 
			<p>Tus datos de contacto seran compartidos con los pasajeros con los que aceptes compartir el viaje. </p>
			<p> Si queres modificar tus datos de contacto, hacelo desde  <a href="editarusuario.php"> Editar Perfil </a> </p>
			</fieldset> <p> </p>
			
			<input type="hidden" id="flagRegistro" name="flagRegistro" value="1"> <!--permite saber si se hizo un intento de registro con chequear si $_POST['flagRegistro'] === 1 -->
			
			<input type="submit" class="botonregistro" style="margin-bottom: 20px;" value="Crear viaje">
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
<script src="jquery.min.js" type="text/javascript"></script>
<script>
jQuery( function ( $ ) {
	$( '#btnAdd' ).click( function() {
		var num = $( '.clonedInput' ).length;		// how many "duplicatable" input fields we currently have
		var newNum	= new Number( num + 1 );		// the numeric ID of the new input field being added
		var newElem = $( '#input' + num ).clone().attr( 'id', 'input' + newNum );
		
		newElem.children( ':first' ).attr( 'id', 'fecha' + newNum ).attr( 'fecha', 'fecha' + newNum );
		$( '#input' + num ).after( newElem );
		$( '#btnDel' ).attr( 'disabled', false );
		//if ( newNum == 5 )
			//$( '#btnAdd' ).attr( 'disabled', 'disabled' );
	});
	
	$( '#btnDel' ).click( function() {
		var num = $( '.clonedInput' ).length;		// how many "duplicatable" input fields we currently have
		$( '#input' + num ).remove();				// remove the last element
		$( '#btnAdd' ).attr( 'disabled', false );	// enable the "add" button
		
		// if only one element remains, disable the "remove" button
		if ( num-1 == 1 )
			$( '#btnDel' ).attr( 'disabled', 'disabled' );
	});
			
	$( '#btnDel' ).attr( 'disabled', 'disabled' );
});
</script>
