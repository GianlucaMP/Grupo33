<?php
	class sesion{
		function login($usuario, $clave){
			// se crea una nueva conexion sql porque es necesario en esta funcion, el require no la pasa por alguna razón
			$coneccion = conectar();
			// $usuario y $clave se buscan en la SQL, si hay resultados, se hace el login, si no, retorna false
			$sql = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE nombreusuario='".$usuario."' AND password='".$clave."'");
			if($datosuser = mysqli_fetch_array($sql)){
				if($datosuser['eliminado'] =='N') {
					session_start();
					//Se cargan los datos del user en las variables de sesion
					$_SESSION['id'] = $datosuser['id'];
					$_SESSION['usuario'] = $datosuser['nombreusuario'];
					return true;
				}
			}else{
				return false;
				exit;
			}
		}
		function logout(){
			session_start();
			// si la sesion esta seteada se realiza, si no, se avisa.
		    if(isset($_SESSION['usuario'])) {
		        session_destroy();
		        session_unset();
		        header("Location: index.php");
		    }else {
		        echo "Para cerrar sesion debes iniciarla primero.";
		    }
		}
		function logeado(){
			session_start();
			// si la sesion esta seteada retorna true, si no, false.
			if(isset($_SESSION['usuario'])){
				return true;
			}else{
				return false;
			}
		}
		function datosuser() {
			// se crea una nueva conexion sql porque es necesario en esta funcion, el require no la pasa por alguna razón
			$coneccion = conectar();
			if (!isset($_SESSION['usuario'])) return null;
			$sql = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE nombreusuario='".$_SESSION['usuario']."'");
			if($datosuser = mysqli_fetch_array($sql)){
				return $datosuser;  
			}
			else {
				return null; //???creo que faltaba un retorno nulo. Si falla, cualquier cosa sacarlo???
			}
		}
	}
?>