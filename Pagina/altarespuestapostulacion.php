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
		exit;
	}
	
	
	//se chequea que se hayan recibido todos los parametros necesarios
	if(!isset($_GET['postulado']) || !isset($_GET['viaje']) || !isset($_GET['accion'])){
		header('Location: verpostulados.php?result=3');
		exit;
	}	
	
	
	//chequeo porque el viaje realmente le pertenezca al user actual
	$sqltoken = mysqli_query($coneccion, "SELECT * FROM viajes WHERE id='".$_GET['viaje']."' ");
	if (!$sqltoken) {//si no lo puedo recibir, entonces no existe o hubo un error en la operacion
		header('Location: index.php?result=9999'); //por el momento lo defino como error desconocido
		exit;
	}
	
	//guardo el viaje en $viaje
	$viaje = mysqli_fetch_array($sqltoken);
	
	
	//si el viaje no pertenece al user cancelo la operacion
	if($user['id'] != $viaje['usuarios_id']) {
		header('Location: index.php?result=5');
		exit;
	}
		
	
	//obtengo la cantidad de plazas ocupadas
	$sqltoken2 = mysqli_query($coneccion, "SELECT * FROM postulaciones WHERE viajes_id={$_GET['viaje']} AND estado='A'");
	if (!$sqltoken2) {//si no lo puedo recibir, entonces no existe o hubo un error en la operacion
		header('Location: index.php?result=9959'); //por el momento lo defino como error desconocido
		exit;
	}
	$plazasOcupadas = (mysqli_num_rows($sqltoken2)); //ya NO se tiene en cuenta la plaza ocupada por el conductor, ya que esa NO se considera desde el momento que se crea el viaje
	
	
	
	//para facilitar la escritura del codigo
	$viajeid = $_GET['viaje'];
	$postulado = $_GET['postulado'];
	$userid = $user['id'];
	
	
	//se opera segun la accion recibida como parametro
	switch ($_GET['accion']) {
		case 'aceptar':
			//si hay plazas disponibles se actualiza el estado del postulado como "aceptado" 
			if ($plazasOcupadas < $viaje['plazas']) {
				$actualizar = mysqli_query($coneccion, "UPDATE postulaciones SET estado='A' WHERE viajes_id={$_GET['viaje']} AND postulados_id={$_GET['postulado']}");
			}
			else {//no hay cupo
				header('Location: verpostulados.php?result=4&id="'.$_GET['viaje'].'"');
				die(); 
			}			
			if ($actualizar) {
				//se crea un pago pendiente en la BD para el postulado aceptado con respecto a este viaje
				$sqlpago = mysqli_query($coneccion, "INSERT INTO pagos (viajes_id, usuarios_id, pago) VALUES ({$_GET['viaje']}, {$_GET['postulado']}, 'F' )");

				if(!$sqlpago){//no se pudo crear la entrada de pago asociada al viaje
					//???SE DEBERIA ELIMINAR LA POSTULACION RECIEN HECHA PARA QUE NO QUEDE UNA POSTULACION SIN UN PAGO ASOCIADO????
					//???PENDIENTE???
					header('Location: verpostulados.php?result=3&id="'.$_GET['viaje'].'"');
					exit;
				}
				else {//postulacion aceptada y pago pendiente registrado, creo las 2 entradas de calificaciones del viaje (uso -1 como puntaje nulo)
					
				
					$sqlcalificacion =  mysqli_query($coneccion, "INSERT INTO calificaciones (viaje_id, calificador_id, calificado_id, puntaje) VALUES ($viajeid, $userid, $postulado, -1)");
					$sqlcalificacion2 =  mysqli_query($coneccion, "INSERT INTO calificaciones (viaje_id, calificador_id, calificado_id, puntaje) VALUES ($viajeid, $postulado, $userid, -1)");
					
					
					
					if (!sqlcalificacion || !sqlcalificacion2) {
						header('Location: verpostulados.php?result=3&id="'.$_GET['viaje'].'"');
						exit;
					}				
					else{ //todo bien, retorno con aviso positivo			
						header('Location: verpostulados.php?result=1&id="'.$_GET['viaje'].'"');
						die(); 
					}
				}
			}
			else {
				header('Location: verpostulados.php?result=3&id="'.$_GET['viaje'].'"');
				die(); 
			}
			break;
		case 'rechazar':
			//se actualiza el estado del postulado como "rechazado"
			$actualizar = mysqli_query($coneccion, "UPDATE postulaciones SET estado='R' WHERE viajes_id={$_GET['viaje']} AND postulados_id={$_GET['postulado']}");
			if ($actualizar) {
				header('Location: verpostulados.php?result=2&id="'.$_GET['viaje'].'"');
				die(); 
			}
			else {
				header('Location: verpostulados.php?result=3&id="'.$_GET['viaje'].'"');
				die(); 
			}	
			break;
		default:
			header('Location: verpostulados.php?result=3&id="'.$_GET['viaje'].'"');
			die();	
	}		
?>