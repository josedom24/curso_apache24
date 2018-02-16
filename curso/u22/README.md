# Módulo rewrite

El módulo [`rewrite`](http://httpd.apache.org/docs/current/mod/mod_rewrite.html) nos va a permitir acceder a una URL e internamente estar accediendo a otra. Ayudado por los ficheros `.htaccess`, el módulo `rewrite` nos va a ayudar a formar URL amigables que son más consideradas por los motores de búsquedas y mejor recordadas por los humanos. Por ejemplo estas URL:

	www.dominio.com/articulos/muestra.php?id=23
	www.dominio.com/pueblos/pueblo.php?nombre=torrelodones

Es mucho mejor escribirlas como:

	www.dominio.com/articulos/23.php
	www.dominio.com/pueblos/torrelodones.php

## Ejemplo 1: Cambiar la extensión de los ficheros

Si queremos usar la extensión `do` en vez de `html` podríamos usar este `.htaccess`:

        Options FollowSymLinks
        RewriteEngine On
        RewriteRule ^(.+).do$ $1.html [nc]

Esto puede ser penalizado por los motores de búsqueda ya que podemos acceder a la misma página con dos URL distintas, para solucionar esto podemos hacer una redirección:

        RewriteRule ^(.+).do$ $1.html [r,nc]

## Ejemplo 2: Crear URL amigables

Si tenemos el siguiente fichero php ([descargar](<php class="txt"></php>)) llamado operacion.php, podríamos usarlo de la siguiente manera:

        http://localhost/operacion.php?op=suma&op1=6&op2=8

Y si queremos reescribir la URL y que usemos en vez de php html, de esta forma:

        http://localhost/operacion.html?op=suma&op1=6&op2=8

Para ello activamos el mod_rewite, y escribimos un .htaccess de la siguiente manera:

Como habíamos visto anteriormente el fichero operacion.php se podía ejecutar de la siguiente manera:

         http://localhost/operacion.php?op=suma&op1=6&op2=8

Creando una URL amigable podríamos llamar a este fichero de la siguiente manera:

        http://localhost/suma/8/6

¿Cómo podemos conseguir esto?

Crea un .htaccess con el siguiente contenido:

        Options FollowSymLinks
        RewriteEngine On
        RewriteBase /
        RewriteRule ^([a-z]+)/([0-9]+)/([0-9]+)$ operacion.php?op=$1&op1=$2&op2=$3

#### Ejemplo 4: Acortar URL

Supongamos que dentro de nuestro DocumentRoot tenemos una carpeta búsqueda con un fichero buscar.php ([descargar](http://informatica.gonzalonazareno.org/plataforma/file.php/40/buscar.txt)). Este fichero me permite obtener la página de búsqueda de google con el parámetro dado, de esta forma:

        http://localhost/busqueda/buscar.php?id=hola

Nos gustaría poder crear una URL más corta que haga lo mismo, escribiríamos en nuestro .htaccess un RewriteRule de la siguiente forma:

        RewriteRule ^buscar busqueda/buscar.php

De esta forma accederíamos por medio de la URL:

        http://localhost/buscar?id=hola

**Ejercicio:** Siguiendo las técnicas anteriormente vistas, realiza una reescritura de URL para que pudiéramos realizar búsquedas con URL de la siguiente manera:

        http://localhost/buscar/hola.html

#### Ejemplo 5: Uso del RewriteCond

La directiva RewriteCond nos permite especificar una condición que si se cumple se ejecuta la directiva RewriteRule posterior. Se pueden poner varias condiciones con RewriteCond, en este caso cuando se cumplen todas se ejecuta la directiva RewriteRule posterior.

Como vemos en la documentación podemos preguntar por varios parámetros , entre los que destacamos los siguientes:

**%{HTTP_USER_AGENT}**: Información del cliente que accede.
Por ejemplo, podemos mostrar una página distinta para cada navegador:

        RewriteCond %{HTTP_USER_AGENT} ^Mozilla
        RewriteRule ^/$ /index.max.html [L]

        RewriteCond %{HTTP_USER_AGENT} ^Lynx
        RewriteRule ^/$ /index.min.html [L]

        RewriteRule ^/$ /index.html [L]

**%{QUERY_STRING}**: Guarda la cadena de parámetros de una URL dinámica.Por ejemplo:

Teníamos un fichero index.php que recibía un parámetro lang, para traducir el mensaje de bienvenida.

        http://localhost/index.php?lang=es

Actualmente hemos cambiado la forma de traducir, y se han creado distintos directorios para cada idioma y dentro un index.php con el mensaje traducido.

        http://localhost/es/index.php

Sin embargo se quiere seguir utilizando la misma forma de traducir.

        RewriteCond %{QUERY_STRING} lang=(.*)
        RewriteRule ^index.php$ /%1/$1

**%{REMOTE_ADDR}**: Dirección de destino. Por ejemplo puedo denegar el acceso a una dirección:

        RewriteCond %{REMOTE_ADDR} 145.164.1.8
        RewriteRule ^(.*)$ / [R,NC,L]

También podemos controlar la reescritura de URL según la hora y la fecha, para saber más lee este [artículo](http://www.askapache.com/htaccess/time_hour-rewritecond-time.html).

**%{HTTP_REFERER}**: Guarda la URL que accede a nuestra página y %{REQUEST_URI} guarda la URI, URL sin nombre de dominio. Podemos evitar el Hot_Linking, o uso de recursos de tu servidor desde otra web. Por ejemplo, un caso muy común es usar imágenes alojadas en tu servidor puestas en otras web. Para ello podemos escribir el siguiente .htaccess:

        RewriteCond %{HTTP_REFERER} !^$
        RewriteCond %{HTTP_REFERER} !^http://(www\.)?dominio\.com/ [NC]
        RewriteCond %{REQUEST_URI} !hotlink\.(gif|png) [NC]
        RewriteRule .*\.(gif|jpg|png)$ http://www.dominio.com/image/hotlink.png [NC]

En el anterior ejemplo el primer RewriteCond permite la solicitud directa pero no desde otras páginas (referrer vacío). La siguiente línea indica que si el navegador ha enviado una cabecera Referrer y esta no contiene la palabra "dominio.com" se ejecutará el RewriteRule. La ultima instrucción RewriteCond indica que si en la url solicitada se encuentra el nombre de la imagen "hotlink" no se realizará el RewriteRule; esto se pone porque la imagen hotlink.png va a ser la que vamos a usar en RewriteRule y si no ponemos este RewriteCond también sería redirigida la solicitud a esta imagen. La última instrucción del ejemplo es el RewriteRule que indica que cualquier solicitud a una imagen desde otro referrer será reescrita en el servidor hacia la imagen hotlink.png y esta será la imagen que se vea en la web que te esté intentando robar la imagen.