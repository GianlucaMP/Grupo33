function viaje() {
	// carga los contenidos de los campos en variables
	var origen = document.getElementById("origen").value;
	var destino = document.getElementById("destino").value;
	var fecha = document.getElementById("fecha").value;
	var vehiculo = document.getElementById("vehiculo").value;
	var preciototal = document.getElementById("preciototal").value;
	var contacto = document.getElementById("contacto").value;
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
		alert("Falta la fecha.");
		return false;
	}
	if (vehiculo === "") {
		alert("Falta el vehiculo.");
		return false;
	}
	if (preciototal === "") {
		alert("Falta el preciototal.");
		return false;
	}
	if (contacto === "") {
		alert("Falta el contacto.");
		return false;
	}
}	