function viaje() {
	// carga los contenidos de los campos en variables
	var origen = document.getElementById("origen").value;
	var destino = document.getElementById("destino").value;
	var fecha = document.getElementById("fecha").value;
	var vehiculo = document.getElementById("vehiculo").value;
	var preciototal = document.getElementById("preciototal").value;
	var horario = document.getElementById("horario").value;
	var duracion = document.getElementById("duracion").value;
	var plazas = document.getElementById("plazas").value;
	
	 
		
	// se chequean vacios
	if (origen === "") {
		alert("Falta el origen.");
		return false;
	}
	if (destino === "") {
		alert("Falta el destino.");
		return false;
	}
	if (fecha === "") {
		alert("Falta la fecha.");	//esto en viajes periodicos capaz no va tan asi
		return false;
	}
	if (vehiculo === "") {
		alert("Falta el vehiculo.");
		return false;
	}
	if (preciototal === "") {
		alert("Falta el precio total.");
		return false;
	}
	if (duracion === "") {
		alert("Falta la duracion.");
		return false;
	}
	if (plazas === "") {
		alert("Falta especificar las plazas disponibles.");
		return false;
	}
	
	
}	

//falta agregar chequeo por todos los demas campos????