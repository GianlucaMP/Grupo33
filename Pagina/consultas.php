<?php // Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	$user = $sesion->datosuser();
	// si el usuario no esta logeado se redirecciona automaticamente al inicio

  $preguntas = mysqli_query ($coneccion,"SELECT * FROM preguntas WHERE preguntas.viajes_id=".$_GET['viaje']);

	$soyConductor=false;

	if ($_GET['id']== $_SESSION['id']) {
		$soyConductor=true;
	}

  //chequeo si falla la consulta
  if (!$preguntas) {
    echo "Error en la operacion con la Base de datos";
    exit;
  }

	if(!$logeado){
		header('Location: index.php');
		exit;
	}



  if (!empty($_GET['error'])) {
  		switch ($_GET['error']) {
  			case '1':
  				$error = 'Debe escribir un comentario';
  				break;
			case '2':
    			$error = 'No se pudo publicar el comentario';
    			break;
			case '3':
	    		$error = 'No se pudo publicar la respuesta';
	    		break;
			default:
    			$error = 'error desconocido';
    		}
    }

    else{
    	$error = '&nbsp;';
    }

		$conductor = mysqli_query ($coneccion,"SELECT * FROM usuarios WHERE usuarios.id=".$_GET['id']);
		$datosConductor = mysqli_fetch_array($conductor);
		$nombreConductor= $datosConductor['nombreusuario'];


		$yo = mysqli_query ($coneccion,"SELECT * FROM usuarios WHERE usuarios.id=".$_SESSION['id']);
		$datosYo = mysqli_fetch_array($yo);
		$miNombre= $datosYo['nombreusuario'];


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheets.css">
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
			width: 25%;
		}
		#datos{
			float: right;
			width: 74%;
		}

    #com{
      width: 50%;
      height: 35px;
      padding-left: 5px;
    }

    #boton{
      height: 40px;
    }

		.grande {
			font-size: 22px;
			margin: 0;
		}

		.dorado {
			color:gold;
		}



		<!--???El layout de esta pagina esta hecho muy por arriba, deberia ser re-hecho desde 0???-->

	</style>
</head>
<body>
	<div id='container'>
	<h2>Consultas del viaje</h2>
		<div id='menucostado'>
			<h2> <a style="text-decoration:none" href="verviaje.php<?php echo ( isset($_GET['viaje']) ? "?id=${_GET['viaje']}" : "" ) ?>">Volver</h2>
			<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
		</div>
		<div id='datos'>
        <p id="error" class="grande" style="color: red;"><?php echo $error?></p>
        <form method="post" action="comentar.php">
            <input type="text" id="com" name="comentario" placeholder="Ingrese su comentario">
            <input type="hidden" id="viaje" name="viaje" value="<?php echo ( isset($_GET['viaje']) ? "${_GET['viaje']}" : "" ) ?>">
						<input type="hidden" id="id" name="id" value="<?php echo ( isset($_GET['id']) ? "${_GET['id']}" : "" ) ?>">
            <input type="submit" value="Comentar" id="boton">
        </form>
        <div align="center" id=comentarios>
        <h4>Comentarios:</h4>
        <?php
        $tienecomentarios = false;
        while ($listarcomentarios=mysqli_fetch_array($preguntas)) {
          $tienecomentarios = true; //no es muy lindo el codigo pero se entiende y sirve
          echo '<div class="viaje" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 800px; margin-bottom:15px;">';?>
          <p> Usuario: <?php echo $listarcomentarios['usuarios_id'] ?> </p>
					<p><?php echo $listarcomentarios['pregunta'] ?> </p><?php
					if ($soyConductor && $listarcomentarios['tiene_respuesta']=='0' && $listarcomentarios['usuarios']<>"$miNombre") { ?>
						<form method="post" action="responder.php">
		            <input type="text" id="com" name="respuesta" placeholder="Ingrese su respuesta">
		            <input type="hidden" id="viaje" name="viaje" value="<?php echo $_GET['viaje'] ?>">
		            <input type="hidden" id="num" name="num" value="<?php echo $listarcomentarios['id'] ?>">
								<input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>">
		            <input type="submit" value="Responder" id="boton">
		        </form> <?php }
						else {
							if ($listarcomentarios['tiene_respuesta']=='1'){?>
							<p> Respuesta del conductor: <?php echo $nombreConductor ?> </p>
							<p><?php echo $listarcomentarios['respuesta'] ?> </p>
					<?php	}}
          echo '</div>';
        }
        if (!$tienecomentarios){
          ?>  <div align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 800px; margin-bottom:15px;">
            <p style="font-size:25px	"> No hay ningun comentario </p>
          </div><?php
        }
        ?>
        </div>
		</div>
		<div style="clear: both;"></div>
	</div>
</body>
</html>
