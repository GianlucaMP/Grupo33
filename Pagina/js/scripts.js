function loginvacio() {
	// carga los contenidos de los campos en variables
	var user = document.getElementById("usern").value;
	var clave = document.getElementById("claven").value;
	if (user === "") {
		alert("Falta el usuario.");
		return false;
	}
	if (clave === "") {
		alert("Falta la clave.");
		return false;
	}
	if (user.length < 6) {
		alert("El usuario es demaciado corto.");
		return false;
	}
	if (clave.length < 6) {
		alert("La clave es demaciado corta.");
		return false;
	}
}