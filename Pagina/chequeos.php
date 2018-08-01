<?php
	if(!isset($_POST['periodico'])) {
	//mezclo fecha y hora en una variable (son strings concatenables)
	$fechaYHora = "{$_POST['fecha']}". ' '. "{$_POST['horario']}"; 
		
	//chequeo que la fecha no halla ya ocurrido
	date_default_timezone_set("America/Argentina/Buenos_Aires");	
	$fechaactual = strtotime(date("Y-m-d H:i")); //convierto las fechas a formato unix timestamp para compararlas
	$fechaevento = strtotime($fechaYHora);
	if ($fechaactual > $fechaevento){	//fecha ya ocurrida
		header('Location: crearviaje.php?error=20');
		die();
	}
	
	
	//(en las proximas 50 lineas de codigo) chequeo que el vehiculo no tenga otro viaje asignado en ese momento 		

	
	//extraigo en variables separadas las horas y minutos de la duracion del viaje
	$duracionTimeStamp = strtotime ($_POST['duracion']); //convierto la duracion a timestamp, pero queda con tambien con la informacion de dia, mes y año actual que deben ser truncados
	$duracionHoras = date("H", $duracionTimeStamp); //convierto a String la duracion en horas
	$duracionMinutos = date("i", $duracionTimeStamp); //convierto a String la duracion en minutos
	
		
	//instancio objetos para almacenar y comparar fecha y hora del inicio del viaje
	$objetoInicioDeViaje = new DateTime($fechaYHora);
	$objetoFinDeViaje = new DateTime($fechaYHora);
	//le agrego las horas y minutos de la duracion que faltan para el momento de fin del viaje
	$objetoFinDeViaje = $objetoFinDeViaje->add(new DateInterval("PT"."$duracionHoras"."H"."$duracionMinutos"."M"));
	
	 
	//convierto a string el inicio y fin del viaje solamente para imprimirlos //DEBUG
	//$inicioDeViaje =  $objetoInicioDeViaje->format("Y-m-d H:i"); //DEBUG
	//$finDeViaje = $objetoFinDeViaje->format("Y-m-d H:i"); //DEBUG

	//echo "inicio nuevo viaje vale: $inicioDeViaje <br>"; //DEBUG
	//echo "fin del nuev viaje vale: $finDeViaje <br>"; //DEBUG
	
	
	
	//obtengo el dia anterior en un formato string, tal como se guarda en la BD para poder buscarlo
	$diaAnterior = date("Y-m-d",strtotime("{$_POST['fecha']} -1 day ")); 
	$diaViaje = date("Y-m-d", strtotime($_POST['fecha']));		
	

	//echo "post fecha vale: {$_POST['fecha']} <br>"; //DEBUG	
	//echo "dia anterior vale $diaAnterior <br>"; //DEBUG		
	//echo "el dia vale: $diaViaje <br>"; //DEBUG	

	
	
	//antes daba error la consulta, al querer hacer algo como:???)
	//$sqlfecha = mysqli_query($coneccion, "SELECT * FROM viajes WHERE fecha=$diaViaje"); 
		
	
	$query = mysqli_query($coneccion, "SELECT * FROM viajes WHERE vehiculos_id = '".$_POST['vehiculo']."' AND fecha = '".$_POST['fecha']."'");   
		
	
	if (!$query) {
		header('Location: crearviaje.php?error=10');
		exit;
	}
	
	//echo "el retorno de mysqli_error es: "; //DEBUG
	//echo (mysqli_error($coneccion)); //DEBUG
	//echo "<br> el retorno de mysqli_get_warnings es: "; //DEBUG
	//echo ((mysqli_get_warnings($coneccion))->message); //DEBUG
	//echo "<br>";
	
	//echo ("la cantidad de columnas de la consulta es: ". mysqli_num_rows($query) . "<br>"); //DEBUG
	
	
	while ($otroViaje = mysqli_fetch_array($query)) { //para todos los viejos en esos dias, tengo que chequear que el vehiculo no este ocupado en ese momento
	
			
		//extraigo en variables separadas las horas y minutos de la duracion del otro viaje
		$duracionOtroViaje = strtotime ($otroViaje['duracion']); //convierto la duracion a timestamp, pero queda con tambien con la informacion de dia, mes y año actual que deben ser truncados
		$horasOtroViaje = date("H", $duracionOtroViaje); //convierto a String la duracion en horas
		$minutosOtroViaje = date("i", $duracionOtroViaje); //convierto a String la duracion en minutos
		
		
		//instancio objetos para comparar el momento de inicio y fin del otro viaje
		$objetoInicioDeOtroViaje = new DateTime($otroViaje['fechayhora']);
		$objetoFinDeOtroViaje = new DateTime($otroViaje['fechayhora']);
		$objetoFinDeOtroViaje = $objetoFinDeOtroViaje->add(new DateInterval("PT"."$horasOtroViaje"."H"."$minutosOtroViaje"."M"));
	
	
		//convierto a string el inicio y fin del viaje para poder imprimirlos
		//$inicioDeOtroViaje =  $objetoInicioDeOtroViaje->format("Y-m-d H:i"); //DEBUG
		//$finDeOtroViaje = $objetoFinDeOtroViaje->format("Y-m-d H:i"); //DEBUG

		//echo "iniciotroViaje vale: $inicioDeOtroViaje <br>"; //DEBUG
		//echo "finDeOtroViaje vale: $finDeOtroViaje <br>"; //DEBUG
			
	
		//si la hora de salida del nuevo viaje esta entre las horas de salida y fin de otro viaje doy aviso que el vehiculo esta ocupado
		if (($objetoInicioDeViaje  >= $objetoInicioDeOtroViaje)  &&($objetoInicioDeViaje  <= $objetoFinDeOtroViaje)) {
			echo "entro al if"; //DEBUG
			header('Location: crearviaje.php?error=11');
			exit;
		}
		
		//si la hora de llegada estimada del nuevo viaje esta entre las horas de salida y fin de otro viaje doy aviso que el vehiculo esta ocupado
		if (($objetoFinDeViaje  >= $objetoInicioDeOtroViaje)  &&($objetoFinDeViaje  <= $objetoFinDeOtroViaje)) {
			echo "entro al if"; //DEBUG
			header('Location: crearviaje.php?error=11');
			exit;
		}		
	}
		
	
	
	//se envian los datos a la base de datos
	$sql = mysqli_query($coneccion, "INSERT INTO viajes (preciototal, origen, destino, fecha, horario, fechayhora, duracion, plazas, vehiculos_id, usuarios_id) VALUES ('".$_POST['preciototal']."', '".$_POST['origen']."', '".$_POST['destino']."' , '".$_POST['fecha']."' , '".$_POST['horario']."' , '".$fechaYHora."', '".$_POST['duracion']."','".$_POST['plazas']."','".$_POST['vehiculo']."','".$_POST['creador']."')");

	if(!$sql) {//si falla la opearcion
		header('Location: index.php?result=2');
		exit;
	}
	
	//obtengo el id que se le autogenero al viaje recien creado 
	$idViaje = mysqli_insert_id ($coneccion);
	
	//si es 0 hay un comportamiento inesperado, el cual me dejaria la base de datos incosistente
	if ($idViaje == 0) {
		//???en este caso deberia borrar el viaje recien creado, para no comprometer el estado de la BD??? 
		//???PENDIENTE???
		header('Location: index.php?result=2'); //este es error 2, cambiarlo despues //DEBUG
		exit;
		
		}
	}
	else {
		$i=1;
		$fechas=[];
		$guardar=true;
		while (isset($_POST['fecha'.$i])) {
			//mezclo fecha-i y hora en una variable (son strings concatenables)
			$fechaYHora = "{$_POST['fecha'.$i]}". ' '. "{$_POST['horario']}"; 
				
			//chequeo que la fecha no halla ya ocurrido
			date_default_timezone_set("America/Argentina/Buenos_Aires");	
			$fechaactual = strtotime(date("Y-m-d H:i")); //convierto las fechas a formato unix timestamp para compararlas
			$fechaevento = strtotime($fechaYHora);
			if ($fechaactual > $fechaevento){	//fecha ya ocurrida
				$fechas[]=$i;
				$guardar=false;
				exit;
				//header('Location: crearviaje.php?error=20');
				//die();
			}
			
			//(en las proximas 50 lineas de codigo) chequeo que el vehiculo no tenga otro viaje asignado en ese momento 		
			//extraigo en variables separadas las horas y minutos de la duracion del viaje
			$duracionTimeStamp = strtotime ($_POST['duracion']); //convierto la duracion a timestamp, pero queda con tambien con la informacion de dia, mes y año actual que deben ser truncados
			$duracionHoras = date("H", $duracionTimeStamp); //convierto a String la duracion en horas
			$duracionMinutos = date("i", $duracionTimeStamp); //convierto a String la duracion en minutos
			
				
			//instancio objetos para almacenar y comparar fecha y hora del inicio del viaje
			$objetoInicioDeViaje = new DateTime($fechaYHora);
			$objetoFinDeViaje = new DateTime($fechaYHora);
			//le agrego las horas y minutos de la duracion que faltan para el momento de fin del viaje
			$objetoFinDeViaje = $objetoFinDeViaje->add(new DateInterval("PT"."$duracionHoras"."H"."$duracionMinutos"."M"));
			
			 
			//convierto a string el inicio y fin del viaje solamente para imprimirlos //DEBUG
			//$inicioDeViaje =  $objetoInicioDeViaje->format("Y-m-d H:i"); //DEBUG
			//$finDeViaje = $objetoFinDeViaje->format("Y-m-d H:i"); //DEBUG

			//echo "inicio nuevo viaje vale: $inicioDeViaje <br>"; //DEBUG
			//echo "fin del nuev viaje vale: $finDeViaje <br>"; //DEBUG
			
			
			
			//obtengo el dia anterior en un formato string, tal como se guarda en la BD para poder buscarlo
			$diaAnterior = date("Y-m-d",strtotime("{$_POST['fecha'.$i]} -1 day ")); 
			$diaViaje = date("Y-m-d", strtotime($_POST['fecha'.$i]));		
			

			//echo "post fecha vale: {$_POST['fecha.$i']} <br>"; //DEBUG	
			//echo "dia anterior vale $diaAnterior <br>"; //DEBUG		
			//echo "el dia vale: $diaViaje <br>"; //DEBUG	

			
			//antes daba error la consulta, al querer hacer algo como:???)
			//$sqlfecha = mysqli_query($coneccion, "SELECT * FROM viajes WHERE fecha=$diaViaje"); 
				
			
			$query = mysqli_query($coneccion, "SELECT * FROM viajes WHERE vehiculos_id = '".$_POST['vehiculo']."' AND fecha = '".$_POST['fecha'.$i]."'");   
				
			
			if (!$query) {
				$fechas[]=$i;
				$guardar=false;
				exit;
				//header('Location: crearviaje.php?error=10');
				//exit;
			}
			
			//echo "el retorno de mysqli_error es: "; //DEBUG
			//echo (mysqli_error($coneccion)); //DEBUG
			//echo "<br> el retorno de mysqli_get_warnings es: "; //DEBUG
			//echo ((mysqli_get_warnings($coneccion))->message); //DEBUG
			//echo "<br>";
			
			//echo ("la cantidad de columnas de la consulta es: ". mysqli_num_rows($query) . "<br>"); //DEBUG
			
			
			while ($otroViaje = mysqli_fetch_array($query)) { //para todos los viejos en esos dias, tengo que chequear que el vehiculo no este ocupado en ese momento
			
					
				//extraigo en variables separadas las horas y minutos de la duracion del otro viaje
				$duracionOtroViaje = strtotime ($otroViaje['duracion']); //convierto la duracion a timestamp, pero queda con tambien con la informacion de dia, mes y año actual que deben ser truncados
				$horasOtroViaje = date("H", $duracionOtroViaje); //convierto a String la duracion en horas
				$minutosOtroViaje = date("i", $duracionOtroViaje); //convierto a String la duracion en minutos
				
				
				//instancio objetos para comparar el momento de inicio y fin del otro viaje
				$objetoInicioDeOtroViaje = new DateTime($otroViaje['fechayhora']);
				$objetoFinDeOtroViaje = new DateTime($otroViaje['fechayhora']);
				$objetoFinDeOtroViaje = $objetoFinDeOtroViaje->add(new DateInterval("PT"."$horasOtroViaje"."H"."$minutosOtroViaje"."M"));
			
			
				//convierto a string el inicio y fin del viaje para poder imprimirlos
				//$inicioDeOtroViaje =  $objetoInicioDeOtroViaje->format("Y-m-d H:i"); //DEBUG
				//$finDeOtroViaje = $objetoFinDeOtroViaje->format("Y-m-d H:i"); //DEBUG

				//echo "iniciotroViaje vale: $inicioDeOtroViaje <br>"; //DEBUG
				//echo "finDeOtroViaje vale: $finDeOtroViaje <br>"; //DEBUG
					
			
				//si la hora de salida del nuevo viaje esta entre las horas de salida y fin de otro viaje doy aviso que el vehiculo esta ocupado
				if (($objetoInicioDeViaje  >= $objetoInicioDeOtroViaje)  &&($objetoInicioDeViaje  <= $objetoFinDeOtroViaje)) {
					$fechas[]=$i;
					$guardar=false;
					exit;
					//echo "entro al if"; //DEBUG
					//header('Location: crearviaje.php?error=11');
					//exit;
				}
				
				//si la hora de llegada estimada del nuevo viaje esta entre las horas de salida y fin de otro viaje doy aviso que el vehiculo esta ocupado
				if (($objetoFinDeViaje  >= $objetoInicioDeOtroViaje)  &&($objetoFinDeViaje  <= $objetoFinDeOtroViaje)) {
					$fechas[]=$i;
					$guardar=false;
					exit;
					//echo "entro al if"; //DEBUG
					//header('Location: crearviaje.php?error=11');
					//exit;
				}		
			}
				
			
			
			//si paso los chequeos se envian los datos a la base de datos
			if($guardar){
			$sql = mysqli_query($coneccion, "INSERT INTO viajes (preciototal, origen, destino, fecha, horario, fechayhora, duracion, plazas, vehiculos_id, usuarios_id) VALUES ('".$_POST['preciototal']."', '".$_POST['origen']."', '".$_POST['destino']."' , '".$_POST['fecha'.$i]."' , '".$_POST['horario']."' , '".$fechaYHora."', '".$_POST['duracion']."','".$_POST['plazas']."','".$_POST['vehiculo']."','".$_POST['creador']."')");

			if(!$sql) {//si falla la opearcion
				header('Location: index.php?result=2');
				exit;
			}
			
			//obtengo el id que se le autogenero al viaje recien creado 
			$idViaje = mysqli_insert_id ($coneccion);
			
			//si es 0 hay un comportamiento inesperado, el cual me dejaria la base de datos incosistente
			if ($idViaje == 0) {
				//???en este caso deberia borrar el viaje recien creado, para no comprometer el estado de la BD??? 
				//???PENDIENTE???
				header('Location: index.php?result=2'); //este es error 2, cambiarlo despues //DEBUG
				exit;
				
				}
			}
		$i=$i+1;
		}
		
		//header('Location: index.php?result=1');
		//exit;
	}
	

?>