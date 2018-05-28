<?php
   	require('usuarioclass.php');
   	// se requiere el usuarioclass con las funciones y se ejecuta el logout.
   	$logout = new sesion;
	$logout->logout();
?> 