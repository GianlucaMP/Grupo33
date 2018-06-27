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

        //se busca el vehiculo del viaje por su id
    $vehiculo=mysqli_query($coneccion,"SELECT * FROM vehiculos WHERE vehiculos.id='".$datoviaje['vehiculos_id']."'");
    // se colocan los datos del vehiculo en un array
    $datovehiculo = mysqli_fetch_array($vehiculo);
	
	//por facilidad de escritura de codigo (por tema de escape de comillas, etc)
	$idConductor = $datoviaje['usuarios_id'];
	
	
	
			
	//necesito obtener el nombre del conductor
	$sql = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE id='".$idConductor."'");
	if($datosConductor = mysqli_fetch_array($sql)){
		$nombreConductor = $datosConductor['nombre'];
	}
	else {
		echo "error inesperado. No se encuentra el conductor en la Base de Datos"; //ver bien como tratar este error. si es posbile que se de y  si se puede hacer algo mejor
		die();
	}

	
	
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
	<meta charset="utf-8">
	<title>Compartir</title>
	<style type="text/css">
		body {
			font-family: sans-serif;
			text-align: center;			
		}
		h1 {
			background-color: black;
			padding: 55px;
		}
		/*@keyframes cambiaColor {
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
		<h2>Bienvenido <i id='user'>visitante</i></h2>
	</div>
	<div align="center">
		<h1>AVENTON</h1>
		<h3></h3> 
		<p>
			<b> Somos el servicio para compartir viajes mas completo del pais!!!</b><br/>
			Animate a viajar
		</p>
	</div>
	<div align="center" id=viajes > 
		<div align="center" style="padding: 10px; box-shadow: 0px 0px 5px 5px lightblue; width: 800px; margin-bottom:15px;">
			<p>
				<?php echo "Origen: ".$datoviaje['origen'];?><br/>
				<?php echo "Destino: ".$datoviaje['destino'];?><br/> 
				<?php echo "Fecha: ".$datoviaje['fecha'];?><br/>
				<?php echo "Precio: ".$datoviaje['preciototal'];?><br/>
				
				<?php echo "Vehiculo: ".$datovehiculo['marca']."  ".$datovehiculo['modelo']."" ;?><br/>

				<p style="font-size:20px; float:right"> <?php echo "<a style=\"text-decoration:none;\" href=\"verperfil.php/?id=$idConductor\">" ?>  <?php echo "Conductor: ".$nombreConductor;?>  </p>
				 <br/> 
			</p>
		</div>
	</div>
	</div>
</body>
</html>