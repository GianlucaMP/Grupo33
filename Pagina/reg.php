<?php
require('dbc.php');
$coneccion = conectar();

//chequea que no haya campos vacios
$campos = array('user', 'pass', 'name', 'date', 'mail');
foreach($campos AS $campo) {
  if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
    header('Location: registro.php?error=1');
    die();
  }
} 

// chequea que la clave y la clave de confirmación sean identicas
if ($_POST['pass'] != $_POST['passconf']) {
	header('Location: registro.php?error=8');
    die();
}
//chequea que la clave cumpla con los pedidos del TP
if(!preg_match("/[a-z]/i",$_POST['pass'])){
	header('Location: registro.php?error=3');
	die();
}
if(!preg_match("/[A-Z]/i",$_POST['pass'])){
	header('Location: registro.php?error=3');
	die();
}
// la funcion numsin comienza en falso, y se chequea que la clave tenga al menos un numero O un simbolo, si una se cumple, se setea a true y se continua.
$numsin = false;
if(preg_match("/[0-9]/",$_POST['pass'])){
	$numsin = true;
}
if(preg_match('/[^a-zA-Z0-9]/',$_POST['pass'])){
	$numsin = true;
}
if(!$numsin){
	header('Location: registro.php?error=3');
	die();
}

// se vuelcan los post a variables normales para trabajar mejor con ellas
$email =  $_POST['mail'];
$nombre =  $_POST['name'];
$pass =  md5($_POST['pass']);
$date = $_POST['date'];
$user =  $_POST['user'];

// se valida que el mail sea correcto
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
	header('Location: registro.php?error=5');
	die();
}

// se valida el tamaño del user
if(strlen($user) > 16 || strlen($user) < 6){
	header('Location: registro.php?error=2');
	die();
}

// chequea que el email y el user no hayan sido registrados, para ello se pide el usuario que cumpla con tal mail o tal user, si el numero de resultads es 0, se asume que no lo hay y se continua
$chequeo = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE nombreusuario='".$user."'");
	if(mysqli_num_rows($chequeo) > 0) { 
        header('Location: registro.php?error=6');
        exit;
    }
$chequeo2 = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE email='".$email."'");
	if(mysqli_num_rows($chequeo2) > 0) { 
        header('Location: registro.php?error=7');
        exit;
    }

// se envia el usuario a la DB
$registrar = mysqli_query($coneccion, "INSERT INTO usuarios (nombreusuario, email, password, nombre, fecha) VALUES ('".$user."', '".$email."', '".$pass."', '".$nombre."', '".$date."')");
if($registrar){
	$exito = true;
}else{
	$exito = false;
}

// si todo salio bien en la query, se envia al user a la home, si no, se da aviso de un error desconocido.
if(!$exito){
	header('Location: registro.php?error=desc');
}else{
	header('Location: index.php?res=3');
}
?>