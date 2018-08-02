<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheets.css"/>
	<title> Ver Perfil </title>
	<style> 

	#container{
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
		}
	
	#menucostado{
		float: left;
		width: 20%;
	}
	
	
	#datos{
			float: right;
			width: 79%;
	}
	
	.centrado{
		margin: 70px 0; <!--centrado vertical-->
	

		width: 50%; <!--centrado horizontal muchas veces hace lo que se le canta con solo agregar un comment-->
		text-align: center; 
	}
	
	p, span{
		font-size:22px;
		line-height:0.8;
	}
	
	.alerta{
		color:red;
	}
	
	
	button{
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 20%;
		height: 3em;
		font-size:25px;
	}	
	
	</style>
</head>
<body>

<div id="container">
	<h2> Eliminar mi cuenta </h2>
	<div id='menucostado' style="font-size:22px">
		<p> <a href="index.php" style="text-decoration:none">Inicio</a></p>
	</div>
	<div id="datos">
		<p> si queres eliminar tu cuenta... apreta el boton de aca abajo</p>
		<button type="button" onclick="mostrar() "> Eliminar cuenta</button>
		
	</div>
	
	
<div style="clear: both;"></div>
</div>
</body>
</html>


<script>

function mostrar() {
    var x = document.getElementById("formularioOcasional");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

</script>


<!--
<div style="padding: 10px; box-shadow: 0px 0px 5px 5px lightblue; width: 700px;">
</div> -->	
