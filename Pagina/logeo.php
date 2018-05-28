<?php
	// se requiere lo de la sql y las funciones de usuario
	require('dbc.php');
	require('usuarioclass.php');

	// ..que no haya nada vacio
	if(empty($_POST['user']) OR empty($_POST['clave'])){
		header('Location: index.php?res=1');
		exit;
	}

	// hashear la clave en md5, crear un objeto session en $login, y ejecutar sobre $exito el logeo
	$clave = md5($_POST['clave']);
	$login = new sesion;
	$exito = $login->login($_POST['user'], $clave);

	// si se pudo a index, si no, a index pero con error, y obviamente sin logear.
	if($exito){
		header('Location: index.php');
	}else{
		header('Location: index.php?res=2');
	}
?>