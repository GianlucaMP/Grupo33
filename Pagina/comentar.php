<?php
// Se crea la coneccion a la SQL y se coloca en $coneccion
require('dbc.php');
$coneccion = conectar();
// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
require('usuarioclass.php');
$sesion = new sesion;
$logeado = $sesion->logeado();

$sql = mysqli_query($coneccion, "SELECT * FROM usuarios WHERE id={$_SESSION['id']}");
$datos = mysqli_fetch_array($sql);
$nombreUsuario = $datos['nombreusuario'];

if(!$logeado){
  header('Location: index.php');
  exit;
}

if(!isset($_POST['comentario'])|| empty($_POST['comentario'])) {
  header('Location: consultas.php?error=1');
  exit;
}

$enviar= mysqli_query($coneccion,"INSERT INTO preguntas  (viajes_id,usuarios,pregunta) VALUES ('".$_POST['viaje']."','".$nombreUsuario."','".$_POST['comentario']."')");

if(!$enviar) {
header("Location: consultas.php?id={$_SESSION['id']}&viaje={$_POST['viaje']}&error=2");
  exit;
}
else {
  header("Location: consultas.php?id={$_SESSION['id']}&viaje={$_POST['viaje']}");
}

?>
