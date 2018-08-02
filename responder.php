<?php
// Se crea la coneccion a la SQL y se coloca en $coneccion
require('dbc.php');
$coneccion = conectar();
// Se chequea si el usuario esta logeado y se deja en una variable a traves de la funcion logeado()
require('usuarioclass.php');
$sesion = new sesion;
$logeado = $sesion->logeado();


if(!$logeado){
  header('Location: index.php');
  exit;
}


if(!isset($_POST['respuesta'])|| empty($_POST['respuesta'])) {
  header("Location: consultas.php?id={$_POST['id']}&viaje={$_POST['viaje']}&error=1");
  exit;
}

$enviar= mysqli_query($coneccion, "UPDATE preguntas SET tiene_respuesta='1', respuesta='".$_POST['respuesta']."' WHERE id={$_POST['num']}");

if(!$enviar) {
header("Location: consultas.php?id={$_POST['id']}&viaje={$_POST['viaje']}&error=3");
  exit;
}
else {
  header("Location: consultas.php?id={$_POST['id']}&viaje={$_POST['viaje']}");
}

?>
