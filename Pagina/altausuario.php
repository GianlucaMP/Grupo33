<?php
require('dbc.php');
$coneccion = conectar();
//chequea que no haya campos vacios
$campos = array('user', 'pass', 'name', 'date', 'mail', 'telefono');
foreach($campos AS $campo) {
  if(!isset($_POST[$campo]) || empty($_POST[$campo])) {
    header('Location: registrarusuario.php?error=1');
    die();
  }
}
// chequea que la clave y la clave de confirmación sean identicas
if ($_POST['pass'] != $_POST['passconf']) {
	header('Location: registrarusuario.php?error=8');
    die();
}
//chequea que la clave cumpla con los pedidos del TP ???hay que modificar este comment???
if(!preg_match("/[a-z]/i",$_POST['pass'])){
	header('Location: registrarusuario.php?error=3');
	die();
}
if(!preg_match("/[A-Z]/i",$_POST['pass'])){
	header('Location: registrarusuario.php?error=3');
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
	header('Location: registrarusuario.php?error=3');
	die();
}



// se vuelcan los post a variables normales para trabajar mejor con ellas
$email =  $_POST['mail'];
$nombre =  $_POST['name'];
$pass =  md5($_POST['pass']);
$date = $_POST['date'];
$user =  $_POST['user'];
$telefono = $_POST['telefono'];


//se remueven todos los caracteres no numericos que son aceptables de encontrar en un campo de ingreso de un telefono: "("; ")"; " "; y "-" 
$caracteresAEliminar = array( '-' , '(' , ')', " " ); 
$telefono = str_replace($caracteresAEliminar,"", $telefono);

//se chequea que el telefono tenga un tamano razonable
if (strlen($telefono) < 6 || strlen($telefono) > 20) {		
	header('Location: registrarusuario.php?error=11');
	exit;
}


//Se chequea que NO hallan quedado caracteres NO numericos
if (!ctype_digit($telefono)) {  
	header('Location: registrarusuario.php?error=10');
	exit; 
}

// se valida que el mail sea correcto
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
	header('Location: registrarusuario.php?error=5');
	die();
}
// se valida el tamaño del user
if(strlen($user) > 16 || strlen($user) < 6){
	header('Location: registrarusuario.php?error=2');
	die();
}
// chequea que el email y el user no hayan sido registrados, para ello se pide el usuario que cumpla con tal mail o tal user, si el numero de resultads es 0, se asume que no lo hay y se continua
$chequeo = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE nombreusuario='".$user."'");
	if(mysqli_num_rows($chequeo) > 0) {
        header('Location: registrarusuario.php?error=6');
        exit;
    }
$chequeo2 = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE email='".$email."'");
	if(mysqli_num_rows($chequeo2) > 0) {
        header('Location: registrarusuario.php?error=7');
        exit;
    }

	
	
$f1 = new DateTime($_POST["date"]);
$f2 = new DateTime("now");
$diferencia =  $f1->diff($f2);


//se modifico esta porcion de codigo que sigue, ya que fallaba en algunos casos, debe ser testeada????

if ($diferencia->format("%y") > 18) {
	// se envia el usuario a la DB
	$registrar = mysqli_query($coneccion, "INSERT INTO usuarios (nombreusuario, email, password, nombre, fecha, telefono) VALUES ('".$user."', '".$email."', '".$pass."', '".$nombre."', '".$date."','".$telefono."')");
	if($registrar){//si la ooperacion de la BD salio bien -> $registar deberia evaluar a true ??casi seguro???. y lo envia a la home
		header('Location: index.php?res=3');
		die();	
	}
	else { //si llega aca, seguramente sea un error con la BD
		header('Location: registrarusuario.php?error=12');  
		die();
	}
}
else{ //es menor de edad -> no se puede registrar
	header('Location: registrarusuario.php?error=9');
	die();
}
?>
