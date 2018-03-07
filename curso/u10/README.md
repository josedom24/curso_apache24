# Opciones de directorios

Cuando indicamos la configuración de un servidor servidor por apache, por ejemplo con la directiva [`Directory`](http://httpd.apache.org/docs/2.4/mod/core.html#directory), podemos indicar algunas opciones con la directiva [`Options`](http://httpd.apache.org/docs/2.4/mod/core.html#options). Algunas de las opciones que podemos indicar son las siguientes:

* `All`: Todas las opciones excepto `MultiViews`.
* `FollowSymLinks`: Se pueden seguir los enlaces simbólicos. 
* `Indexes`: Cuando accedemos al directorio y no se encuentra un fichero por defecto (indicado en la directiva `DirectoryIndex` del módulo `mod_dir`), por ejemplo el `index.html`, se muestra la lista de ficheros (esto lo realiza el módulo `mod_autoindex`).
* `MultiViews`: Permite la [negociación de contenido](http://httpd.apache.org/docs/2.4/content-negotiation.html), mediante el módulo `mod_negotiation`.
* `SymLinksIfOwnerMatch`: Se pueden seguir enlaces simbólicos, sólo cuando el fichero destino es del mismo propietario que el enlace simbólico.
* `ExecCGI`: Permite ejecutar script CGI usando el módulo `mod_cgi`.

Podemos activar o desactivar una opción en referencia con la configuración de un directorio padre mediante el signo `+` o `-`.

## Ejemplo

En el fichero `/etc/apache2/apache2.conf`, nos encontramos el siguiente código:

	<Directory /var/www/>
	    Options Indexes FollowSymLinks
	    ...

A continuación podría cambiar las opción del virtual host `pagina1`, incluyendo en su fichero de configuración:

	<Directory /var/www/pagina1>
	    Options -Indexes +Multiviews
	    ...

## Ejercicios

* Crea un enlace símbolico al directorio  `/home/usuario/` y comprueba si es posible seguirlo. Cambia las opciones del directorio para que no siga los enlaces simbólicos.
* Deshabilita la opción de que se listen los archivos existentes en la carpeta cuando no existe un fichero definido en la directiva [`DirectoryIndex`](http://httpd.apache.org/docs/2.4/mod/mod_dir.html#directoryindex).

