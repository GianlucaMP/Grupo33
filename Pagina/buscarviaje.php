<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	
	// Se chequea si el usuario esta logeado y se deja en una variable
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	//$user = $sesion->datosuser();
	if(!empty($_GET['result'])){
		switch ($_GET['result']) {
		case '1':
			$result = 'Viaje creado con exito!';
			$color = "lightgreen";
			break;
		case '2':
			$result = 'Error al crear el viaje :(';
			$color = "red";
			break;
		case '3':
			$result = 'el viaje indicado no existe';
			$color = "red";
			break;
		case '4':
			$result = 'Error en la operacion con la base de datos. Intentalo de nuevo';
			$color = "red";
			break;
		case '5':
			$result = 'El viaje que deseas administrar no te pertenece';
			$color = "red";
			break;
		case '6': //DEBUG
			$result = 'Error en la consulta a la BD. seguro esta mal escrita'; //DEBUG
			$color = "red"; //DEBUG
			break; //DEBUG
		case '7':
			$result = 'Usuario eliminado con exito';
			$color = 'gold';
			break;
		default:
			$result = 'Error desconocido.';
			$color = "red";
		}
	}else{
		$result = '&nbsp;';
	}

	// revisa que no este nada en blanco
	if(empty($_GET['origen']) AND empty($_GET['destino']) AND empty($_GET['fecha'])AND ($_GET['ordenp']==='Opcional')AND ($_GET['ordenf']==='Opcional')) {
		$resultados = false;
		$noreser = 'Todos los campos se enviaron en blanco.';
	}else{
		//revisa que la fecha este seteada
		if($_GET['fecha'] !== ''){
			if ($_GET['fecha']>= date("Y-m-d")) $fechaquery = "AND fecha = '".$_GET['fecha']."'";
			else $fechaquery= "AND fecha >= '".date("Y-m-d")."'	AND fecha = '".$_GET['fecha']."'";
		}else{
			$fechaquery = "AND fecha >= '".date("Y-m-d")."'";
		}
		// setea los valores segun lo que llegue de la busqueda, asi se puede introducir en la query SQL mas adelante
		if ($_GET['ordenp']!='Opcional'||$_GET['ordenf']!='Opcional') {
			$ordenquery='ORDER BY ';
			if ($_GET['ordenp']!='Opcional'&& $_GET['ordenf']!='Opcional') {
				$ordenquery="".$ordenquery." preciototal ".$_GET['ordenp'].", fecha ".$_GET['ordenf']."";}
				else {					
					if($_GET['ordenp']!='Opcional'){
						$ordenquery="".$ordenquery." preciototal ".$_GET['ordenp']."";
					}
					if($_GET['ordenf']!='Opcional'){
						$ordenquery="".$ordenquery." fecha ".$_GET['ordenf']."";
				}
			}
		}
		else {
			//if ($_GET['ordenp']==='Opcional' && $_GET['ordenf']==='Opcional') {
				$ordenquery='';
			//}
		}

		//echo $ordenquery; //DEBUG
		//$query= "SELECT * FROM viajes WHERE origen LIKE '%".$_GET['origen']."%' AND destino LIKE '%".$_GET['destino']."%' ".$fechaquery." ".$ordenquery." ";//DEBUG
		//echo $query;//DEBUG

		// se envia a la SQL que devuelva los viajes segun lo pedido
		$viajes=mysqli_query($coneccion, "SELECT * FROM viajes WHERE origen LIKE '%".$_GET['origen']."%' AND destino LIKE '%".$_GET['destino']."%' ".$fechaquery." ".$ordenquery." " );
		
		// si la cantidad de objetos no es mayor a 0, se asume que no hubo resultados.
		if(mysqli_num_rows($viajes) > 0) { 
	        $resultados = true;
	    }else{
	    	$resultados = false;
	    	$noreser = 'No hubo resultados.';
	    }
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<meta charset="utf-8">
	<title>Aventon: Somos lo que estabas buscando</title>
	<style type="text/css"> 
		body {
			font-family: sans-serif;
			text-align: center;
		}
		h1 {
			padding: 55px;
		}
		#container{
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
		}
		#bienvenide{
			float: left;
			width: 40%;
		}
		#reg{
			float: right;
			width: 59%;
		}
	
			
		
	</style>
	<script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
	<div id="container">
	<div id="encabezado">
		<img src="partes\Logo.jpg" width="200" height="100" align="left"> </>
		<div id="bienvenide" align="center"><h2>Bienvenido <i id='user'>
			<?php
			if (!$logeado) echo 'visitante';
			else echo $_SESSION['usuario'] ; ?></i></h2></div>
		<div id="reg" align="right">
			<?php include('partes/arriba.php'); ?>
		</div>
		<div style="clear: both;"></div>
	</div>

	<div align="center">
		<a href="index.php" style="text-decoration:none">
		<h1 style="background-color:black;">AVENTON</h1></a>
		<h3>Resultados de tu busqueda</h3>
		<div id="menuarriba">
				<form action="buscarviaje.php" method="GET">
					<input id="origen" type="text" name="origen" placeholder="Origen..." value="<?php echo ((isset($_GET['origen']) && (!empty($_GET['origen'])))  ?  $_GET['origen'] : ''  ); ?>" >
					<input id="destino" type="text" name="destino" placeholder="Destino..." value="<?php echo ((isset($_GET['destino']) && (!empty($_GET['destino'])))  ?  $_GET['destino'] : ''  ); ?>" >
					<input id="fecha" type="date" name="fecha" value="<?php echo ((isset($_GET['fecha']) && (!empty($_GET['fecha'])))  ?  $_GET['fecha'] : ''  ); ?>">
					<br><br>
					
					<?php $valoresp=array('ASC'=>"Menor",'DESC'=>"Mayor");?>
					Precio: <select id="ordenp" name="ordenp">
							<option>Opcional</option>
						    <?php 
						    foreach($valoresp as $key=>$value){
								// Si coincide lo enviado por el formulario con el valor...
						        if($_GET["ordenp"]==$key)
						        {
									echo "<option value='".$key."' selected>".$value."</option>";
						        }else{
						        	echo "<option value='".$key."'>".$value."</option>";
        						}
    						}?>

					</select>
					&nbsp &nbsp
					<?php $valoresf=array('ASC'=>"Mas Cercana",'DESC'=>"Menos Cercana");?>
					Fecha: <select id="ordenf" name="ordenf">
						<option>Opcional</option>
						<?php 
						    foreach($valoresf as $key=>$value){
								// Si coincide lo enviado por el formulario con el valor...
						        if($_GET["ordenf"]==$key)
						        {
									echo "<option value='".$key."' selected>".$value."</option>";
						        }else{
						        	echo "<option value='".$key."'>".$value."</option>";
        						}
    						}?>
					</select>
					&nbsp &nbsp
					<input type="submit" class="botonregistro" onclick="return busquedavacia()" value="Buscar!">
				</form>
				<br>
		</div>
	</div>
	<div align="center" id=viajes>
		<?php
		if ($resultados) {
			while ($listarviajes=mysqli_fetch_array($viajes)) {  
				$fechaactual = Date("Y-m-d");
				$fechaevento = $listarviajes['fecha'];
				if ($fechaactual <= $fechaevento) {
					echo '<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 800px; margin-bottom:15px;">';
					echo '<div>';
					echo "Origen: ".$listarviajes['origen']."<br/>";
					echo "Destino: ".$listarviajes['destino']."<br/>";
					echo "Fecha: ".$listarviajes['fecha']."<br/>";
					echo "Precio: ".$listarviajes['preciototal']."<br/>";
					echo'</div>';
					echo '<div>';
					echo '...<a style="color: white;" href="verviaje.php?id='.$listarviajes['id'].'">Ver Mas</a>';
					echo '</div>';
					echo '</div>';
				}//
			}
		}
		else {
			echo "$noreser";
		}
		?>
	</div>
	</div>
	
	
<footer>

<div class="footer" align="right">
	<a href="ayuda.php" style="font-size:20px; text-decoration:none" >Ayuda</a> <span> &nbsp &nbsp </span>
	<a href="contacto.php" style="font-size:20px; text-decoration:none ">Contacto</a>
</div>
</footer>

	
</body>
</html>
