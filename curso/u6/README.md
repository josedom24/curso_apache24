# Probando nuestro servidor web

El servidor web Apache 2.4 se instala por defecto con la configuración de un servidor virtual. La configuración de este sitio la podemos encontrar en:

    /etc/apache2/sites-available/000-default.conf

Y por defecto este sitio virtual está habilitado, por lo que podemos comprobar que existe un enlace simbólico a este fichero en el directorio ``/etc/apache2/sites-enabled``:

    lrwxrwxrwx 1 root root   35 Oct  3 15:24 000-default.conf -> ../sites-available/000-default.conf

Una de las directivas más importantes que nos encontramos en el fichero de configuración es [`DocumentRoot`](https://httpd.apache.org/docs/2.4/mod/core.html#documentroot) donde se indica el directorio donde van a estar guardados los ficheros de nuestro sitio web, los ficheros que se van a servir. En la configuración del virtual host por defecto el directorio es:

	/var/www/html

En el fichero de configuración general `/etc/apache2/apache2.conf` nos encontramos las opciones de configuración del directorio padre del indicado en la directiva `DocumentRoot` (suponemos que todos los host virtuales van a estar guardados en subdirectorios de este directorio):

	...
	<Directory /var/www/>
		Options Indexes FollowSymLinks
		AllowOverride None
		Require all granted
	</Directory>
	...

Por lo tanto podemos acceder desde un navegador a la ip de nuestro servidor (también podemos usar un nombre del servidor) y accederemos a la página de bienvenida del servidor que se encuentra en:

	/var/www/html/index.html

Por defecto los errores de nuestro sitio virtual se guardan en `/var/log/apache2/error.log` y los accesos a nuestro servidor se guardan en `/var/log/apache2/access.log`.

## Ejercicio

Cambia el contenido del fichero `index.html` (o crea un nuevo fichero `html`) del directorio `/var/www/html` y comprueba, accediendo por el navegador, los cambios realizados.

