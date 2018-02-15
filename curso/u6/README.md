# Probando nuestro servidor web

El servidor web Apache 2.4 se instala por defecto con la configuración de un servidor virtual. La configuración de este sitio la podemos encontrar en:

    /etc/apache2/sites-available/000-default.conf

Cuyo contenido podemos ver:

	<VirtualHost *:80>
	        #ServerName www.example.com	
	        ServerAdmin webmaster@localhost
	        DocumentRoot /var/www/html	
	        ErrorLog ${APACHE_LOG_DIR}/error.log
	        CustomLog ${APACHE_LOG_DIR}/access.log combined	
	</VirtualHost>

Donde encontramos los siguientes parámetros:

* [ServerName](https://httpd.apache.org/docs/2.4/mod/core.html#servername)
* [ServerAdmin](https://httpd.apache.org/docs/2.4/mod/core.html#serveradmin)
* [DocumentRoot](https://httpd.apache.org/docs/2.4/mod/core.html#documentroot)
* [ErrorLog](https://httpd.apache.org/docs/2.4/mod/core.html#errorlog)
* [CustomLog](http://httpd.apache.org/docs/current/mod/mod_log_config.html#customlog)


Y por defecto este sitio virtual está habilitado, por lo que podemos comprobar que existe un enlace simbólico a este fichero en el directorio ``/etc/apache2/sites-enables``:

    lrwxrwxrwx 1 root root   35 Oct  3 15:24 000-default.conf -> ../sites-available/000-default.conf

En el fichero de configuración general ``/etc/apache2/apache2.conf`` nos encontramos las opciones de configuración del directorio padre del indicado en la directiva ``DocumentRoot`` (suponemos que todos los host virtuales van a estar guardados en subdirectorios de este directorio):

	...
	<Directory /var/www/>
		Options Indexes FollowSymLinks
		AllowOverride None
		Require all granted
	</Directory>
	...

Por lo tanto podemos acceder desde un navegador a la ip de nuestro servidor (también podemos usar un nombre del servidor) y accederemos a la página de bienvenida del servidor que se encuntra en:

	/var/www/html/index.html

	