
<?php

require('dbc.php');
$coneccion = conectar();


?>

<HTML>

<HEAD>

<style>


label { 
	color:grey;
	font-size:40px;
}

.calificacion{
    direction: rtl;
    unicode-bidi: bidi-override;
}

input[type = "radio"]{ 
	display:none;
}

label:hover,
label:hover ~ label{color:gold;}
input[type = "radio"]:checked ~ label{color:gold;}


</style>

</HEAD>

<BODY>

<form action="altacalificacion.php">
  <p class="calificacion">
    <input id="radio1" type="radio" name="estrellas" value="5"><!--
    --><label for="radio1" title="Excelente" >★</label><!--
    --><input id="radio2" type="radio" name="estrellas" value="4"><!--
    --><label for="radio2" title="Muy Buena" >★</label><!--
    --><input id="radio3" type="radio" name="estrellas" value="3"><!--
    --><label for="radio3" title="Buena">★</label><!--
    --><input id="radio4" type="radio" name="estrellas" value="2"><!--
    --><label for="radio4" title="Regular">★</label><!--
    --><input id="radio5" type="radio" name="estrellas" value="1"><!--
    --><label for="radio5" title="Mala">★</label>
  </p>
<input type="submit" value="Calificar">
</form>

</BODY>


</HTML>