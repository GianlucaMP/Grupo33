PEQUENOS FIXS DE CODIGO:

1) crear viaje: 

a) chequear disponibilidad hora a hora 

b) los botones + - no hacen nada


2) registrar vehiculo: chequear que lo de recordar los campos ingresados en caso de error funcione en firefox


3) campo de eliminado de vehiculos. puede que halla quedado alguna pagina que no lo tenga en cuenta






BUGS DESTACABLES:

1) crear viaje: el chequeo por la hora del dia no haya pasado al crear viaje estan fallando, puede que halla un offset en la hora, aunque capaz ya este solucionado

2) creaviaje y registrar vehiculo: guarda capaz que el javascript que se ejecuta en crear viaje, ya no hace falta mas xq ya se chequea todo por php, y capaz q si justo se chequea por javascript me olvida los camopos ingresados en caso de error

3) chequear que todos los headers que usen una variable tengan comillas dobles " " y no simples ya que asi no sirve

4) revisar siempre que se usan elementos de arrays asociativos en strings que esten bien escritos para convertir texto en variables. Hay unos cuantes que no puse entre llaves el signo $, y otros que quiriendo copiar la tecnica del append cerrando el string, lo hice mal, revisar todos los echo, y otras cosas por el estilo










GRANDES IMPLEMENTACIONES PENDIENTES:

0) eliminacion de usuarios:  chequear campo de borrado todos lados 

1) el metodo regular que hace que se pase lo terminado de viajes a viajes_finalizados (esto tiene dependencia con el tema de los viajes que impiden eliminar un vehiculo ??y algo mas???)

2) viaje periodico

3) buscar viaje A ESTO DARLE UNA MUY BUENA PRIORIDAD, Y TESTEARLO BIEN. 





IMPORTANTE:

EN LA BD:  los posibles estados de la postulacion de un user son: NO POSTULADO (N), POSTULADO (P), ACEPTADO (A), RECHAZADO (R), cosa que deberian ser definidas como constantes en cada pagina que sea necesario. Ya estan definidas en la pagina verviaje.php, copiar lo que esta ahi donde haga falta cuando sea necesario.


EN CUANTO A LAS PLAZAS: AL REGISTRAR EL VEHICULO SE DICE CUANTAS PLAZSA TIENE INCLUYENDO A LA QUE OCUPA EL CONDUCTOR. A PARTIR DE QUE SE CREA EL VIAJE, Y TODO EN ADELANTE, CUANDO SE HABLA DE PLAZAS SE HABLA EXCLUSIVAMENTE DE PLAZS DISPONIBLES PARA PASAJEROS (SIN CONTAR AL CONDUCTOR)






PREGUNTAS CON EL PROFE:

1) pensamos en la DB a partir de ahora mantener 2 tablas, viajes y viajes finalizados. La idea es obvia, los viajes que ya se les paso la fecha, irlos mandando a la otra tabla
Esto facilita las consultas en cuanto haya viajes con pagos, viajes cancelados, etc. 

La otra pregunta, se necesita algo que periodicamente chequee por los viajes que finalizan y mandarlos a la tabla de finalizados, cual seria una buena manera de implementarlo?


OTRAS DUDAS A A CONSULTAR Y PASAR EN PIVOTAL:

1) Si en mis viajes publicados se muestran los viajes que estan pendientes ??? en algun lado se muestran todos los viajes incluidos los ya finalizados??? por ahi en la misma pagina con un checkbox???

2) en que consiste exactamete la HU verificar e-mail?

3)  cuales son los posibles valores para una calificaccion, si un puntaje del 1 al 5 creo que era, o sino positivo/negativo?

4) como se recuperaria una contraseña?






TESTEO PENDIENTE:

1) ver perfil: que la determinacion de si mostrar o no los datos de contacto se haga bien. (sobre todo la query que se usa para esto) ES UNA CONSULTA DIFICIL ASI QUE CHEUQEARLA BIEN!!!



2) postulaciones (todo en general, por ahora esta testeado mas o menos y funciona, pero revisar a fondo) especialmente el como se manejan las plazas ocupadas


e) ver postulados (testear todo en general que seguro algo falla)


3) baja usuario: todo en general



4) verviaje:

a) mostrar plazas ocupadas

b) mostrar aviso de que ya estas postulado (y si aceptado o no) si ya te postulaste.

c) link a la pagina  con todos los datos de postulacion si sos el conductor



5) todo lo referente al horario de salida en todas las paginas que aparezca esto







MODIFICACIONES Y FIXES BAJA PRIORIDAD:

1) el checkbox de periodico que queda haciendo las cosas al reves.





------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------
LISTA DE CAMBIOS:
------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------


4.9.1:

altarespuestapostulacion: se corrigo un bug que permitia aceptar una postulacion aun cuando todas las plazas del viaje estaban ocupadas

verviaje.php: ahora no muestra el boton de postularse en caso de que todas las plazas esten ocupadas

4.9:

verpostulados.php: se agrego una lista de pasajeros y una lista de postulados rechazados

se corrigieron y testearon varias cosas con respecto a las postulaciones (al parecer ya esta funcionando bien todo este sistema)

Se corrigieron muchos errores con respecto a las plazas ocupadas en un viaje las cuales eran administradas erroneamente

se mejoro el formato en el que se imprimen las fechas y horas en algunas paginas



4.8:

bajaviaje: se corrigio la consulta de INSERT INTO viajes_finalizados, la cual fallaba completamente

altausuario: se marcan a los users de NO borrados al registrarlos

bajausuario: se marcan los user de borrados al eliminarlos

logeo: se chequea al logear porque el user NO este eliminado



4.7:


verviaje: se agrego un link para eliminar el viaje en caso de que el usuario que este viendo la pagina sea el conductor

bajaviaje: se agregaron campos a la hora de registrar el viaje como finalizado en la BD


se agrego el campo eliminado a la tabla de enlace de vehiculos y usuarios.

se implemento el uso de dicho campo en varias funciones:
altavehiculo  se setea en N el campo al registar un vehiculo
altaviaje chequea que el vehiculo recibido no este eliminado
baja de vehiculos se setea en 'S'  el campo al registar un vehiculo
baja de usuarios se setea en 'N' para eliminar sus vehiculos
crearviaje chequea que los vehiculos a listar NO esten eliminados
mi perfil  chequea que los vehiculos a listar NO esten eliminados

4.6:

bajausuario: se creo la estructura basica del codigo de esta pagina (con muchos errores y testeos pendientes)

otros cuantos cambios que no recuerdo pero que pueden generar problemas

4.5:

Baja vehiculo: se agrego la consideracion por tener viajes pendientes al eliminar un vehiuclo, 
se agrego un chequeo por que el vehiculo a ser eliminado sea efectivamente propiedad de quien lo quiere eliminar

4.4:

Se corrigio un bug importante haciendo que ahora un user pueda ver los datos de contacto de otro cuando es correcto (bastante testeado pero hay que testearlo mas)
se corrigieron varios bugs chicos
se elimino codigo viejo innecesario

4.3:

se modifico gran parte de la interfaz de verperfil, verpostulados, y misviajespublicados. Y algo del codigo backend de estas paginas

se rehizo gran parte de la logica interna de postulaciones (se implemento y testeo gran parte de esto, para usar solo 1 tabla de postulados)


4.2.2:

ver perfil: se agrego un boton para volver al viaje que te llevo a este perfil

4.2:

se cambio el nombre de agregarviaje por altaviaje

se cambio el nombre de postulados.php por verpostulados.php

se cambio el nombre de evaluar por evaluarpostulacion

se agregaron sentencias exit despues de todos las redirecciones en caso de error

4.1:

se agrego el manejo de la hora de salida (aunque se testeo poco)

4.0:

se agrego la tabla viajes_finalziados a la BD

se hizo la baja de viaje 

3.5:

misviajespublicados:

se agrego confirmacion al intentar eliminar un viaje

se corrigieron algunos bugs

3.4:

Se hizo merge con lo de piriz (todo referente a los postulados)

se completo casi totalmente la pagina verperfil, con linda interfaz y todo

3.3.1:

no recuerdo ningun cambio hecho, salvo que esta es la ultima ver antes del merge

3.3:

se agrego chequeo por disponibilidad del vehiculo (por ahora solo se chequea que no tenga un viaje el mismo dia)

3.2.1:

Se agrego en misviajespublicados un boton para eliminar el viaje (que por ahora solo te lleva a una pagina que no hace nada). y un aviso si no se tiene ningun viaje

3.2:

se hizo merge con codigo de piriz: varias vosas (codigo de periodico, mi perfil, mis viajes publicados, alta postulacion, etc)

altaviaje: se agrego un chequeo para que el user no se pase del limite de plazas

3.1.1:

No se si se hicieron cambios, pero se creo esta version como definitiva antes de intentar mergear con lo de piriz

3.1:

se unseteo los valores recorddados de formularios para que una vez registrado en la BD un formulario este no siga apareciendo ocn los valores cargados al querer crear uno nuevo

3.0:

se logro implementar el recordar los campos ingresados en caso de error tanto en crearviaje como en registrarvehiculo

2.4.2:

Se agregaron varios comentarios con codigo casi completo de como hacer lo de no olvdiar los campos, pero esta todo oculto ya que ninguno se pudo terminar

2.4.1:

se actualizo la BD: se cambio de nuevo la tabla viajes, ya no hay mas datos de contacto en esta tabla, se ven todos desde el perfil

crearviaje y agregarviaje fueron modificados para soportar estos cambios


2.4:

se cambio nuevamente la tabla viajes de la BD sacando contacto y poniendo email y telefono (se habia acordado hacerlo de esta manera con el ayudante)

crearviaje: se pueden modificar los datos telefono y contacto ya que ahora se cargan posibles datos de contacto alternativo en el viaje (distintos a los que posee el usuario en sus datos)

agregarviaje y crearviaje: se proveen muchos datos de debug y casi la implementacion total para poder conservar los datos tras un error al completar el formulario

2.3:

index.php: se agrego un orden a la lista de viajes

2.2:

crearviaje: se agrego un chequeo por si el user tiene autos registrados. Si no los tiene solo se muestra un aviso de que registre uno


2.1:

en mi perfil se creo la logica e interfaz pra mostrar un aviso en caso de que el usuario no tenga autos

en ver viaje se agrego el boton para postularse, y se definio la estructura para mostrar los mensajes de error/exito al postularse al viaje



2.0:

SE HIZO EL MERGE CON EL CODIGO DE PIRIZ:

1) agregar viaje (saco momentamenteamente el tema de la hora de inicio, modifico la query de agregar viaje, pero parece estar todo bien)

2) altavehiculo 

3) bajavehiculo 

4) crearviaje (cambio la query para acceder a vehiculo dada la nueva estructura de la DB. (hay que testaerla). le agrego un input hidden al formu. y comento para sacar momentaneamente la duracion estimada)

5) editar vehiculo (solo cambio un minimo mensaje de error)

6) index (solo cambio el color del cuadrito)

7) mi perfil (saco 1 sola linea mia de la consulta q trae la lista de vehiculos y puso otra mucho mas elabroada por la nueva compleijdad de la BD.) 

8) modificar vehiculo (solo cambio la porcion de codigo para chequear si es el vehiculo que quiero modificar)

9) registrar vehiculo (solo cambio un mensaje de error)

10) travelsahre (solo hubo un par de cambios estructurales, se agrego la tabla de enlace entre vehiculos y conductores). Ademas se cambiaron el nombre de algunas columnas

11) verviaje (cambios leves)



1.7:

Se corrigieron un par de bugs (entre ellos un "}" que faltaba en eliminar vehiculo que hacia fallar totalmente la pagina)

1.6:

Se modifico los nombres de archivos (y las referencias internas a los mismos) para que al menos la mayoria respeten el formato verbo-sustantivo (editarperfil, eliminarvehiculo, etc):

todos los archivos de operacion DB son llamados alta/baja/modificacion de algo

todos los arcihvos de paginas mas estilo HTML (para llenar formularios y eso), son llamados ver/agregar/registrar/editar/eliminar algo



se saco el campo contacto a la hora de realizar la transaccion con la BD en agregarviaje.php




1.5:

Primer version en historial.

Se termino gran parte de la interfaz grafica.

Se cambio la implementaicon interna de como se crea y agrega un viaje

quedaron pendientes varios bugs:

checkbox de viaje periodico que actua "al reves", cuando se va para atras

no se mantienen los datos cargados en los campos tras llenar un formulario 



