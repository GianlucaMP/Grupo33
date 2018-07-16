<?php
	// Se crea la coneccion a la SQL y se coloca en $coneccion
	require('dbc.php');
	$coneccion = conectar();
	// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
	require('usuarioclass.php');
	$sesion = new sesion;
	$logeado = $sesion->logeado();
	//$user = $sesion->datosuser();
	// si el usuario no esta logeado se redirecciona automaticamente al inicio
	if(!$logeado){
		header('Location: index.php');
	}
	// si hay una ID seteada se sigue, si no, se activa $err
	if(!isset($_GET['postulado'])||!isset($_GET['viaje'])||!isset($_GET['accion'])){
		$err = true;
	}else{
		// "accion" define el orden en el que se muestra, y hay una query para cada cosa.
		switch ($_GET['accion']) {
			case 'aceptar':
				#se agreaga al postulado a la lista de pasajeros
				$agregar = mysqli_query($coneccion,"INSERT INTO pasajeros (viajes_id,pasajeros_id)VALUES('".$_GET['viaje']."','".$_GET['postulado']."')");
				#se lo elimina de la lista de postulados
				$eliminar = mysqli_query($coneccion,"DELETE FROM postulaciones WHERE postulados_id='".$_GET['postulado']."' AND viajes_id='".$_GET['viaje']."' ");
				#yeaaaaaaaaaaaaah nigga yeeeeeea
				if ($agregar and $eliminar) {
					header('Location: postulados.php?result=1&id="'.$_GET['viaje'].'"');
					die(); 
				}
				break;

			case 'rechazar':
				$eliminar = mysqli_query($coneccion,"DELETE FROM postulaciones WHERE postulados_id='".$_GET['postulado']."' AND viajes_id='".$_GET['viaje']."' ");
				if ($eliminar) {
					header('Location: postulados.php?result=2&id="'.$_GET['viaje'].'"');
					die(); 
				}
				break;
			
			default:
				header('Location: postulados.php?result=3&id="'.$_GET['viaje'].'"');
				die();
				break;
		}

		/*
		#Primero se elimina el enlace entre el usuario y el vehiculo
		$mienlace = mysqli_query($coneccion,"DELETE FROM enlace WHERE usuarios_id='".$_SESSION['id']."' AND vehiculos_id='".$_GET['id']."' ");
		#Se verifica que la query haya sido exitosa, CC error desconocido
		if(!$mienlace) header('Location: miperfil.php?result=default');
		#Se verifica la cantidad de enlaces restantes del vehiculo. 
		$enlaces = mysqli_query($coneccion,"SELECT * FROM enlace WHERE vehiculos_id=".$_GET['id']);
		if (mysqli_num_rows($enlaces) < 1) { #Si enlaces del vehiculo es menor a 1, el vehiculo no tiene mas dueños
			#En ese caso se lo elimina definitivamente de la BD
			$sql = $comentar = mysqli_query($coneccion, "DELETE FROM vehiculos WHERE id=".$_GET['id']);
		}
		//$sql = $comentar = mysqli_query($coneccion, "DELETE FROM vehiculos WHERE id=".$_GET['id']);
		if($mienlace||$sql) header('Location: miperfil.php?result=3');
		else header('Location: miperfil.php?result=4');*/
	}
?>