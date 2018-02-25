# Introducción a Virtual Hosting

El término Hosting Virtual se refiere a hacer funcionar más de un sitio web (tales como `www.pagina1.com` y `www.pagina2.com`) en una sola máquina. Los sitios web virtuales pueden estar "basados en direcciones IP", lo que significa que cada sitio web tiene una dirección IP diferente, o "basados en nombres diferentes", lo que significa que con una sola dirección IP están funcionando sitios web con diferentes nombres (de dominio). Apache fue uno de los primeros servidores web en soportar hosting virtual basado en direcciones IP.

Como hemos visto en la unidad anterior el servidor web Apache2 se instala por defecto con un host virtual en `/etc/apache2/sites-available/000-default.conf`.

Cuyo contenido podemos ver:

	<VirtualHost *:80>
	        #ServerName www.example.com	
	        ServerAdmin webmaster@localhost
	        DocumentRoot /var/www/html	
	        ErrorLog ${APACHE_LOG_DIR}/error.log
	        CustomLog ${APACHE_LOG_DIR}/access.log combined	
	</VirtualHost>

Donde encontramos los siguientes parámetros:

* [ServerName](https://httpd.apache.org/docs/2.4/mod/core.html#servername): Nombre por el que se va a acceder al virtual host.
* [ServerAdmin](https://httpd.apache.org/docs/2.4/mod/core.html#serveradmin): Correo electrónico del responsable de este virtual host.
* [ServerAlias](https://httpd.apache.org/docs/2.4/mod/core.html#serveralias): Otros nombres con los que se puede acceder al sitio.
* [DocumentRoot](https://httpd.apache.org/docs/2.4/mod/core.html#documentroot): directorio donde se guardan los ficheros servidos en este virtual host.
* [ErrorLog](https://httpd.apache.org/docs/2.4/mod/core.html#errorlog): Fichero donde se guardan los errores.
* [CustomLog](http://httpd.apache.org/docs/current/mod/mod_log_config.html#customlog): Fichero donde se guarda los accesos al sitio.

Podemos habilitar o deshabilitar nuestros host virtuales utilizando los comandos `a2ensite` y `a2dissite`.
