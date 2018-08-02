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
          default:
    				$error = 'error desconocido';
    		}
    }

    else{
    	$error = '&nbsp;';
    }


	// se bajan los datos del viaje en $viaje, para despues volcarse en un array.
    $sqlviaje = mysqli_query($coneccion, "SELECT * FROM viajes WHERE viajes.id=".$_GET['id']);
	if (!$sqlviaje) {
 		header('Location: miperfil.php?result=30');
		exit;
 	}
	$viaje = mysqli_fetch_array($sqlviaje);


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
	<h2>Mi perfil</h2>
		<div id='menucostado'>
			<h2> <a style="text-decoration:none" href="verviaje.php<?php echo ( isset($_GET['viaje']) ? "?id=${_GET['viaje']}" : "" ) ?>">Volver</h2>
			<p> <a href="index.php" style="text-decoration:none">INICIO</a></p>
		</div>
		<div id='datos'>
        <p id="error" class="grande" style="color: red;"><?php echo $error?></p>
        <form method="post" action="comentar.php">
            <input type="text" id="com" name="comentario" placeholder="Ingrese su comentario">
            <input type="hidden" id="viaje" name="viaje" value="<?php echo ( isset($_GET['viaje']) ? "${_GET['viaje']}" : "" ) ?>">
            <input type="submit" value="comentar" id="boton">
        </form>
        <div align="center" id=comentarios>
        <h4>Comentarios:</h4>
        <?php
        $tienecomentarios = false;
        while ($listarcomentarios=mysqli_fetch_array($preguntas)) {
          $tienecomentarios = true; //no es muy lindo el codigo pero se entiende y sirve
          echo '<div class="viaje" align="center" style="padding: 10px; color:white; box-shadow: 0px 0px 5px 5px lightblue; width: 800px; margin-bottom:15px;">';?>
          <p> Usuario: <?php echo $listarcomentarios['usuarios'] ?> </p>
					<p><?php echo $listarcomentarios['pregunta'] ?> </p><?php
          echo '<a href="responder.php">Responder</a>';
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
