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
		
		li {
			font-size:25px;
			line-height:1.5;
		}
		
		p{
			line-height:1.4;
		}
	
	</style>
</head>

<body>
<body>
	<div id='container'>
	<h2>Ayuda</h2>
		<div id='menucostado'>
			<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
		</div>
		<div id='datos'>
			
			<h2 style=>Parece que necesitas algo de ayuda. </h2>
			<h3 style="color:lightgreen">Hace click sobre nuestras preguntas frecuentes para encontrar su respuesta</h3>
		
			<ul>
				<li onclick="mostrar(1)"> Para que sirve esta pagina? </li>
				<div class="pregunta" style="display:none" id="1">
					<p> Aventon es una pagina destinada a compartir viajes entre usuarios para poder asi compartir los gastos entre los mismos. <br/>
					Cuando un usuario debe realizar un viaje en su vehiculo, y cuenta con espacio para mas personas, cuenta con la posibilidad de crear un viaje en Aventon. <br/>
					Al crear un viaje en Aventon el usuario pasa a ser el conductor del viaje, el cual sera visible en nuestra pagina por todos nuestros usuarios. <br/>
					Los usuarios podran postularse al viaje para poder ser incluidos como pasajeros a cambio de compartir los gastos, siempre y cuando el dueño del viaje acepte a dichos usuarios como pasajeros</p>
				</div>
				<li onclick="mostrar(2)"> Que es un conductor, un postulado, y un pasajero? </li>
				<div class="pregunta" style="display:none" id="2">
					<p> En aventon nos referimos a nuestros preciados usuarios como pasajeros, postulados, y conductores dependiendo del rol que cumplen en un determinado viaje. <br/>
					Conductor: Es un usuario que crea un viaje para compartir su vehiculo con otros usuarios de la pagina <br/>
					Postulado: Es un usuario que se postula a un viaje en la pagina, y que aun NO ha sido aceptado por el conductor del mismo <br/>
					Pasajero: Es un usuario que se postulo a un viaje en la pagina, y fue aceptado por el conductor del mismo</p>
				</div>
				<li onclick="mostrar(3)"> Cual es el precio de un viaje? </li>
				<div class="pregunta" style="display:none"id="3">
					<p> El precio de un viaje lo define el usuario que comparte su vehiculo. Cuenta con total libertad de elegir el precio que quiera, y dicho precio sera abonado por cada uno de los usuarios que participen en el viaje <span style="color:gold"> incluyendo al conductor </span> Pero debe tener en cuenta que aventon recaudara un 5% de todo pago asociado a un viaje como costo de servicio</p>
				</div>
				<li onclick="mostrar(4)"> Cuando publico un viaje cualquiera puede unirse al mismo? </li>
				<div class="pregunta" style="display:none" id="4">
					<p> Cuando publiques un viaje en nuestro sitio todos los usuarios podran verlo y postularse al mismo, pero solo aquellos a quienes aceptes como pasajeros podran efectivamente participar del mismo y ponerse en contacto con vos. <br/> 
					A la hora de elegir a quien aceptar como pasajero te mostraremos datos de dicho usuario, entre ellos su edad, y una lista con todas las calificaciones de gente que ha compartido viajes con el en nuestro sitio</p>
				</div>
				<li onclick="mostrar(5)"> Como puedo crear un viaje? </li>
				<div class="pregunta" style="display:none" id="5">
					<p> Para crear un viaje, lo primero que necesitas es estar registrado en el sitio, Una vez registrado deberas registrar el vehiculo en el cual deseas realizar el viaje a compartir, finalmente podras crear un viaje desde la pagina <a href="crearviaje.php">Crear viaje</a> la cual es accesible desde nuestra pagina principal. <br/>
					En la pagina crear viaje ingresa los datos del mismo, pulsa el boton "Crear Viaje", y tu viaje ya sera visible por todos en nuestro sitio. <br/>
					<span style="color:gold"> No te olvides de revisar la pagina <a href="misviajespendientes.php">Mis viajes pendientes</a> donde podras ver tu viaje recien creado y aceptar las postulaciones de los usuarios interesados en el<span>
				</p>
				</div>
				<li onclick="mostrar(6)"> Como puedo postularme a un viaje? </li>
				<div class="pregunta" style="display:none" id="6">
					<p> Para postularte a un viaje, lo primero que necesitas es estar registrado en el sitio, accede a la pagina del viaje que te interese pulsando el boton "Ver Detalles" desde nuestra pagina principal o desde nuestro <a href="buscarviaje.php">Buscardor</a> y en la pagina del viaje  pulsa el boton "Postularse" para postularte al mismo <br/>
					Ahora solo es cuestion de esperar por la respuesta del conductor del mismo, la cual sera visible en esa misma pagina, a la que ahora puedes llegar tambien por medio de <a href="misviajespendientes.php">Mis viajes pendientes</a> </p>
				</div>
				<li onclick="mostrar(7)"> Como puedo registrarme en Aventon? </li>
				<div class="pregunta" style="display:none" id="7">
					<p> Si queres registrarte en Aventon, dirigete a nuestra <a href="registrarusuario.php">Pagina de registro</a>, Ahi poder insertar tus datos y registrarte </p>
				</div>
				<li onclick="mostrar(99)"> Como debo hacer para pagar por un viaje? </li>
				<div class="pregunta" style="display:none" id="99">
					<p> En cuanto crees un viaje, o te hayan aceptado como pasajero a uno, podras pagar por el mismo desde la pagina <a href=" mispagos.php">Mis pagos</a> <br/> 
					Busca ahi el viaje en cuestion, pulsa el boton "pagar viaje", ingresa los datos de tu tarjeta de credito y pulsa el boton "Realizar Pago" </p>
				</div>
				<li onclick="mostrar(8)"> Como hago para aceptar pasajeros a mi viaje? </li>
				<div class="pregunta" style="display:none" id="8">
					<p> En cuanto hayas creado un viaje dirigete a la pagina <a href="misviajespendientes.php">Mis viajes pendientes</a>, donde podras acceder a tu viaje recien creado. <br/>
					Desde la pagina del viaje pulsa el boton "Ver postulados" donde podras ver una lista con todos los postulados en tu viaje, y donde podras aceptarlos mediante el boton "Aceptar Postulacion" </p>
				</div>
				
				
				
				
				<!--Estas las dejo a modo de ejemplo para llenar con lo que haga falta -->
				
				<!--	
				
				<li onclick="mostrar(9)"> Como hago tal cosa 9? </li>
				<div class="pregunta" style="display:none" id="9">
					<p> Para eso haces tal cosa 9 </p>
				</div>
				<li onclick="mostrar(10)"> Como hago tal cosa 10? </li>
				<div class="pregunta" style="display:none" id="10">
					<p> Para eso haces tal cosa 10 </p>
				</div>
			</ul>

			-->

</body>
</html>

<script>

function mostrar( id ) {
    var x = document.getElementById(id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

</script>