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
									echo 'Uno o mas campos estan en blanco.';
									break;

								case '2':
									echo 'Contraseña incorrecta o el usuario no esta registrado.';
									break;

								case '3':
									echo 'Usuario registrado con exito.';
									break;
								
								default:
									echo 'Error desconocido.';
									break;
							}
						}
					?>
					<input type="text" id="usern" class="inputregistro" name="user" placeholder="Nombre de usuario">
					<input type="password" id="claven" class="inputregistro" name="clave" placeholder="Contraseña">
					<input type="submit" class="botonregistro" onclick="return loginvacio()" value="Logeate!">
				</form>
				<p>¿No tenes cuenta?<br/>
				<a href="registro.php">Create una</a></p>
			<?php 
			}else{
			?>
				<h3>Sesión Actual</h3>
				<p>Usuario: <?php echo $_SESSION['usuario'] ?></p>
				<p><a href="miperfil.php">Mi Perfil</a></p>
				<p><a href="salir.php">Cerrar Sesión</a></p>
			<?php }?>