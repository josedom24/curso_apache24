# Módulo rewrite

El módulo [`rewrite`](http://httpd.apache.org/docs/current/mod/mod_rewrite.html) nos va a permitir acceder a una URL e internamente estar accediendo a otra. Ayudado por los ficheros `.htaccess`, el módulo `rewrite` nos va a ayudar a formar URL amigables que son más consideradas por los motores de búsquedas y mejor recordadas por los humanos. Por ejemplo estas URL:

    www.dominio.com/articulos/muestra.php?id=23
    www.dominio.com/pueblos/pueblo.php?nombre=utrera

Es mucho mejor escribirlas como:

    www.dominio.com/articulos/23.php
    www.dominio.com/pueblos/utrera.php

## Ejemplo 1: Cambiar la extensión de los ficheros

Si tenemos el siguiente fichero php [operacion.php](https://raw.githubusercontent.com/josedom24/curso_apache24/master/curso/u23/fich/operacion.php), podríamos usarlo de la siguiente manera:

        http://www.pagina1.org/operacion.php?op=suma&op1=6&op2=8

Y si queremos reescribir la URL y que usemos en vez de php html, de esta forma:

        http://www.pagina1.org/operacion.html?op=suma&op1=6&op2=8

Para ello activamos el `mod_rewite`, y escribimos un `.htaccess` de la siguiente manera:

        Options FollowSymLinks
        RewriteEngine On
        RewriteBase /
        RewriteRule ^(.+).html$ $1.php [nc]

El flag `[nc]` lo ponemos para no distinguir entre mayúsculas y minúsculas.

Esto puede ser penalizado por los motores de búsqueda ya que podemos acceder a la misma página con dos URL distintas, para solucionar esto podemos hacer una redirección:

        RewriteRule ^(.+).html$ $1.php [r,nc]

## Ejemplo 2: Crear URL amigables

Creando una URL amigable podríamos llamar a este fichero de la siguiente manera:

        http://www.pagina1.org/suma/8/6

Escribimos un `.htaccess` de la siguiente manera:

        Options FollowSymLinks
        RewriteEngine On
        RewriteBase /
        RewriteRule ^([a-z]+)/([0-9]+)/([0-9]+)$ operacion.php?op=$1&op1=$2&op2=$3

## Ejemplo 3: Uso del RewriteCond

La directiva `RewriteCond` nos permite especificar una condición que si se cumple se ejecuta la directiva `RewriteRule` posterior. Se pueden poner varias condiciones con `RewriteCond`, en este caso cuando se cumplen todas se ejecuta la directiva `RewriteRule` posterior.

Como vemos en la documentación podemos preguntar por varios parámetros, entre los que destacamos los siguientes:

* `%{HTTP_USER_AGENT}`: Información del cliente que accede.
    Por ejemplo, podemos mostrar una página distinta para cada navegador:

        RewriteCond %{HTTP_USER_AGENT} ^Mozilla
        RewriteRule ^/$ /index.max.html [L]

        RewriteCond %{HTTP_USER_AGENT} ^Lynx
        RewriteRule ^/$ /index.min.html [L]

        RewriteRule ^/$ /index.html [L]

* `%{QUERY_STRING}`: Guarda la cadena de parámetros de una URL dinámica.Por ejemplo:

    Teníamos un fichero index.php que recibía un parámetro lang, para traducir el mensaje de bienvenida.

        http://www.pagina1.org/index.php?lang=es

    Actualmente hemos cambiado la forma de traducir, y se han creado distintos directorios para cada idioma y dentro un index.php con el mensaje traducido.

        http://www.pagina1.org/es/index.php

    Sin embargo se quiere seguir utilizando la misma forma de traducir.

        RewriteCond %{QUERY_STRING} lang=(.*)
        RewriteRule ^index.php$ /%1/$1

* `%{REMOTE_ADDR}`: Dirección de destino. Por ejemplo puedo denegar el acceso a una dirección:

        RewriteCond %{REMOTE_ADDR} 145.164.1.8
        RewriteRule ^(.*)$ / [R,NC,L]
   
