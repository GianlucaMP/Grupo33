PEQUENOS FIXS DE CODIGO:


1) se podria agregar al hacer alta de calificaciones un chequeo de que si ya hay una calificacion con ese viaje_id, y de ese user_id que se cancele el alta ???aunque no deberia ser necesario???


2) viaje periodico






IMPORTANTE:


EN LA BD:  los posibles estados de la postulacion de un user son: NO POSTULADO (N), POSTULADO (P), ACEPTADO (A), RECHAZADO (R), cosa que deberian ser definidas como constantes en cada pagina que sea necesario. Ya estan definidas en la pagina verviaje.php, copiar lo que esta ahi donde haga falta cuando sea necesario.

EN LA BD: una calificacion pendiente tiene como puntaje "-1"


EN CUANTO A LAS PLAZAS: al registrar el vehiculo se dice cuantas plazas tiene incluyendo a la que ocupa el conductor. A partir de que se crea el viaje, y todo en adelante, cuando se habla de plazas se habla exclusivamente de plazas disponibles para pasajeros (sin contar al conductor)






TESTEO PENDIENTE:

0) PREGUNTAS Y REPSUESTAS!!!!


1) sistema de pagos:

a) que un postulado aceptado se le cree un pago pendiente en la BD

b) todo el sistema en general



2) postulaciones:

a)(todo en general, por ahora esta testeado mas o menos y funciona, pero revisar a fondo) especialmente el como se manejan las plazas ocupadas

b) bajapostulacion (ya esta medianamente chequeado)


3) ver postulados (testear todo en general que seguro algo falla)


4) altaviaje (lo del vehiculo que no este ocupado, es un codigo complicado, testear a fondo, aunque parece funcionar)!!!!


5)calificaciones (todo en genral)



6) verviaje:

a) mostrar plazas ocupadas

b) mostrar aviso de que ya estas postulado (y si aceptado o no) si ya te postulaste.

c) link a la pagina  con todos los datos de postulacion si sos el conductor







MODIFICACIONES Y FIXES BAJA PRIORIDAD:

1) el checkbox de periodico que queda haciendo las cosas al reves.





------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------
LISTA DE CAMBIOS:
------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------

6.9:

se corrigio el tema de las fechas en verificardeudas.php

se corrigio el tema de las fechas en verificarcalificaciones.php

mispagos.php habia quedado codigo comentado que deberia estar funcional, ya se lo agrego nuevamente

6.8.2:

se corriegieron algunos errores en lo que es preguntas/comentarios

6.8.1:

verperfil.php: Se agrego un aviso de que el user esta eliminado

6.8:

SE REINICIO LA BD PARA DARLE CONSISTENCIA. TESTEAR QUE SE MANTENGA ASI!!!!

se agregaron los cambios de piriz en buscarviaje.php y index.php (tambien la etiqueta que faltaba cerrar en verviaje.php)

verviaje.php: se agrego un chequeo para mostrar tambien viajes eliminados (y que avisa claramente que esta eliminado)

misviajespublicados.php: se agrego un chequeo para mostrar tambien viajes eliminados (y que avisa claramente que esta eliminado)

verpostualdos.php: se agrego un chequeo para mostrar tambien viajes eliminados (y que avisa claramente que esta eliminado)


baja viaje.php:

ahora los viajes se pasan a viajes finalizados con su id de siempre

se corrigio un bug a la hora de hacer un alta en viajes_finalizados
 
 
se modifico la tabla viajes_finalizados, cambiando la clave principal por idnueva, y se agrego otro campo id , el cual tiene la id vieja, de la otra tabla, la cual va a ser utilizada para identificar los viajes. y el resto de los campos de la tabla pasaron a ser identicos a los de la tabla viajes

6.7.2:

Se corrigieron problemas de layout en: verperfil.php, mispagos.php, calificar.php y miperfil.php

6.7.1:

Se completo la pagina de ayuda

6.7:

misviajespendientes.php: se tomo el fix de piriz (ahora efectivamente muestra los viajes pendientes y NO todos, y se corrigio el layout)

comentar, consultas y responder (se actualizaron por camila)

se agrego lo que hizo piriz con respecto a las busquedas (buscarviaje.php) y una ligera modificacion de index.php)

bajausuario.php:

se agrego el chequeo de contrasena

se corrigieron bugs

altapago.php:

se agregaron validaciones simples al realizar pagos con sus mensajes de error

eliminarusuario.php: se termino la pagina 

ayuda.php: se agrego un script para ocultar los textos y mostrar solo una lista de temas de ayuda (que se muestran al clickear)


6.6.4:

miperfil.php: se agrego enlace a opcion para eliminar usuario

eliminarusuario.php: se creo y codifico parte de la pagina


6.6.3:


crearviaje.php: 

se agrego un aviso de que se cobra un 5% por costos de servicio al crear el viaje

se agrego un include verificarcalificaiones.php para chequear calificaciones pendintes que impidan crear un viaje

se codifico la interfaz para mostrar aviso de calificaiones pendeintes si las hay

se elimino el testeo de deudas o calfiicaiones pendientes en esa apagina ahora se hacen en altaviaje.php 


verificarcalfiifaciones.php:

se creo el archivo para verificar si hay calificaiones pendientes que deban impedir el uso de la pagina


verviaje.php: se elimino el testeo de deudas o calificaones en esa pagina para hacerse en altapostulacion.php


altapostulacion.php:

se agrego un include verificarcalificaiones.php para chequear calificaciones pendintes que impidan postularse

se codifico la interfaz para mostrar aviso de calificaiones pendeintes si las hay



6.6.2:

se agrego la descripcion a las calificaciones

se agrego descrpcion a los calificaciones negativas automaticas

6.6.1:

crearviaje.php unas 5 lineas que modifico piriz que se habian traspapelado se modificaron correctamente

6.6:

verviaje.php: 

si el viaje que se esta viendo es propio,  o si ya esta acepado/postulado/rechazado, por mas que tengas deudas te muestro todo igual...

se agrego la opcion para darse de baja de un viaje

se creo y codifico bajapostulacion.php

misviajespendites.php se muestran en distintos colores los viajes que uno es condcutor o pasajero para facilitar diferenciarlos mientra el layout este mal


6.5.2 (merge parte 3):


se modifico verviaje.php (se corrigo un bug en caso que el user no este logeado)

se modifico usarioclass.php (simple fix de una linea)



6.5.1 (merge parte 2):

se modifico verviaje.php agregandole cosas realacionadas a los comentarios (seguramente links para poder acceder a esa pagina)

se creo y codifico el archivo consultas.php


se creo y codifico el archivo comentar.php



6.5 (merge parte 1):

se modifico grosamente altaviaje.php. Sacando gran parte del codigo y moviendolo a chequeos.php ???que mas se hizo???

se creo y codifico el archivo chequeos.php (se verifican la consistencia de las fechas y disponibilidad del vehiculo a la hora de crear un viaje)

crearviaje.php se modificaron unas 10 lineas de codigo de viaje periodico



6.4 (ultima version antes del merge):

bajaviaje.php se codifico la calificacion negativa automatica

6.3:

se agrego en mi perfil.php y verperfil.php la lista de calificaciones y el promedio

altacalificacion.php se codifico casi completamente la pagina (hay un bug en caso de que la calificacion incluya una descripcion)

calificar.php se codifico casi completamente la pagina (testeo pendiente)

se crean 2 entradas en la tabla calificaciones al aceptar una postulacion (una para cada usuario involucrado)

altarespuestapostulacion.php: se agrega una entrada en la tabla calificaciones al confirmarse una postulacion 

se completo la pagina contacto.php


6.2:

se creo misviajespendientes.php que deberia mostrar todos los viajes como condcutor, pasajero y postulado del user. (SE TIENEN QUE CORREGIR LAS 2 CONSULTAS QUE OBTIENEN LOS VIAJES PARA QUE MUESTRE SOLO LOS PENDIENTES!!!! Y se tiene que arreglar el formato de la pagina para que no se superponga cuando hay viajes de ambos tipos)

altarespuestapostulacion.php: ahora se crea una entrada en la BD de un pago pendiente tras la confirmacion de una postulacion de un pasajero 

se agrego en verperfil.php y miperfil.php el caso de mostrar una calificacion de "pendiente (sin califiaciones)"

se mejoro el estilo de la pagina mispagos.php

se modifico el menu del costado en mispagos.php para solo mostrar las opciones de volver a mi perfil, y de ir a inicio


6.1 (merge):

se agrego a la BD en la tabla usuarios los campos "calificacion" y "cantidad_votos"

se agrego el archivo calificar.php

se agrego en bajaviaje.php el codigo para dar una calificaion negativa automatica (aun en proceso)

se agrego en miperfil.php codigo para determinar y mostrar la reputacion del user

se agrego en verperfil.php codigo para determinar y mostrar la reputacion del user



6.0.1:

ultima version antes del merge


6.0:

se completo el codigo back-end que permite registrar un pago realizado en la BD

se completo la verificacion de que el vehiculo no este ocupado a la hora de crear un viaje en altaviaje.php (testeo pendiente)

se agrego a la tabla viajes las columnas "horario" y "fechayhorario", ahora se almacenan la fecha y hora tanto por separado, como tambien un campo las almacena combinadas, para utilizarla como sea conveniente

se modifico el codigo de altaviaje, para crear viajes almacenando tanto fecha, hora, y fechayhora

se corrigio un error de tipo en la BD (pagos.pago paso a ser tipo CHAR (1), estaba como tinyint)

5.2.1:

Se agrego en index.php y en miperfil.php un footer con links a las paginas de contacto y ayuda

se crearon los archivos contacto.php y ayuda.php con la definicion basica de la estructura de la pagina (todavia vacia)

5.2:

se creo y codifico la mayor parte de la pagina pagardeudas.php (aun pendiente la parte back-end en la que se recuperan pagos de la BD para efectuarlos y en la que se registran como pagos)

se modificaron nombres de los campos de la BD para respetar los nombres usados previamente (se cambio en la tabla pagos: usuario_id por usuarios_id, y viaje_id por viajes_id)

en crearviaje.php y verviaje.php se creo un chequeo que  en caso de tener deudas impide usar dichas paginas, y muestra un link a la pagina para pagar,


5.1: 

se creo e implemento el archivo verificardeudas.php (testeo pendiente)

se agrego la tabla preguntas

5.0.2:

Se removio temporalmente la parte que hacia no funcioanr a alta viaje (el chequeo de si el vehiculo etsa ocupado en ese momento)


5.0.1:

altaviaje ESTA MOMENTANEAMENTE ROTO por el tema de que esta pendiente determinar como se almacenan las fechas y horas (pero puede ser solucionado con solo sacar la parte de chequear por si el vehiculo esta ocupado en ese momento)

se elimino el uso del la columna horario de la BD en todo lugar donde aparecia (verviaje, verpostulados y bajaviaje)

se elimino la columna horario de la tabla viajes de la BD


5.0:

altaviaje: se modifico el codigo para poder almacenar la fecha y hora en una unica variable (y campo de la BD) para facilitar los chequeos relacionados

se modifico la tabla usuarios, ahora la columna fecha no solo almacena la fecha sino tambien el horario (tipo datetime)


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



