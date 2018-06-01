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
}
//chequea que no haya campos vacios
$campos = array('user', 'name', 'date', 'mail');
foreach($campos AS $campo) {
  if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
    header('Location: editar.php?error=1');
    die();
  }
}
// se vuelcan los post a variables normales para trabajar mejor con ellas
$email =  $_POST['mail'];
$nombre =  $_POST['name'];
$date = $_POST['date'];
$nick =  $_POST['user'];
// se valida que el mail sea correcto
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
	header('Location: editar.php?error=5');
	die();
}
// se valida el tamaño del nick del usuario
if(strlen($user) > 16 || strlen($user) < 6){ 
	header('Location: editar.php?error=2');die();}
	
// chequea que el email y el user no hayan sido registrados, para ello se pide el usuario que cumpla con tal mail o tal user, si el numero de resultads es 0, se asume que no lo hay y se continua
$chequeo = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE nombreusuario='".$user."'");
	if(mysqli_num_rows($chequeo) > 0) {
        header('Location: editar.php?error=6');
        exit;
    }
$chequeo2 = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE email='".$email."'");
	if(mysqli_num_rows($chequeo2) > 1) {
        header('Location: editar.php?error=7');
        exit;
    }
$f1 = new DateTime($_POST["date"]);
$f2 = new DateTime("now");
$diferencia =  $f1->diff($f2);
if ($diferencia->format("%y") > 18) {
  // se envia el usuario a la DB
  $sql = mysqli_query($coneccion, "UPDATE usuarios SET nombreusuario='".$_POST['user']."', nombre='".$_POST['name']."', email='".$_POST['mail']."', fecha='".$_POST['date']."' WHERE id=".$user['id']);
if($sql){
	$exito = true;
}else{
	$exito = false;
}
// si todo salio bien en la query, se envia al user a la home, si no, se da aviso de un error desconocido.
if(!$exito){
	header('Location: editar.php?error=desc');
}else{
	$_SESSION['usuario'] = $_POST['user'];
	header('Location: miperfil.php');
}}
else {
header('Location: editar.php?error=9');
}
?>
