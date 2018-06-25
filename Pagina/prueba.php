
<?php

$a = array(
  'blue'   => 'nice',
  'car'    => 'fast',
  'number' => 'none'
);

foreach($a AS $campo) {
	echo "el elemento es: $campo <br>";
}
$b= 'hola';




$indiceNumerico = array_search("car",array_keys($a));
echo ($indiceNumerico==null?"nulo":$indiceNumerico);

?>

<HTML>

<HEAD>

<BODY>

<form>

<input type="checkbox" name="aca"> aca

<input type="submit">

</form>


</BODY>

</HEAD>


</HTML>