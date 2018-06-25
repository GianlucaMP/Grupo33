
<?php

$caracteresAEliminar = array( '-' , '(' , ')', " " ); 
$telefono = "(221) 440-1212";
echo "telefono vale: $telefono <br>";

//$telefono = preg_replace($caracteresAEliminar, "", $telefono);
$telefono = str_replace($caracteresAEliminar,"", $telefono);

echo "telefono ahora vale: $telefono";

?>