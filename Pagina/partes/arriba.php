<?php
				//si el usuario esta logeado se muestra un pequeño menu con el nombre y para cerrar la sesión, en caso contrario, se muestra el formulario de login y un link para crear una cuenta
				if(!$logeado){
			?>
				<form method="post" action="logeo.php">
					<h3>Logueate</h3>
					<?php
						// ?res es una variable get que entra cuando hay que mostrar un mensaje sobre el formulario de login
						if(!empty($_GET['res'])){
							switch ($_GET['res']) {
								case '1':
									$fallo='Uno o mas campos estan en blanco.';
									$color= "red";/////////////////////////////////
		//							echo 'Uno o mas campos estan en blanco.';
									break;
								case '2':
										$fallo=	'Contraseña incorrecta o el usuario no esta registrado.';////////////////////
										$color="red";///////////////////////
							//		echo 'Contraseña incorrecta o el usuario no esta registrado.';
									break;
								case '3':
										$fallo='Usuario registrado con exito.';///////////////////
										$color= "lightgreen";/////////////////////
								//	echo 'Usuario registrado con exito.';
									break;
								case '4':
									$fallo='parece que no estas logueado, intentalo de nuevo';
									$color="red";
									break;
								default:
									$fallo='Error desconocido.';
									$color="red";
	//								echo 'Error desconocido.';
									break;
							}
						}
						else{
							$fallo = '&nbsp;';
						}
					?>
					<input type="text" id="usern" class="inputregistro" name="user" placeholder="Nombre de usuario">
					<input type="password" id="claven" class="inputregistro" name="clave" placeholder="Contraseña">
					<input type="submit" class="botonregistro" onclick="return loginvacio()" value="Logeate!">
				</form>
				<p>¿No tenes cuenta?<br/>
				<a href="registrarusuario.php">Create una</a></p>
				<p id="error" style="color: <?php echo $color; ?>;"><?php echo $fallo?></p> 
			<?php
			}else{
			?>
				<h3>Sesión Actual</h3>
				<p>Usuario: <?php echo $_SESSION['usuario'] ?></p>
				<p><a href="miperfil.php">Mi Perfil</a></p>
				<p><a href="salir.php">Cerrar Sesión</a></p>
			<?php }?>
