# Introducción a Virtual Hosting

El término Hosting Virtual se refiere a hacer funcionar más de un sitio web (tales como ``www.company1.com`` y ``www.company2.com``) en una sola máquina. Los sitios web virtuales pueden estar "basados en direcciones IP", lo que significa que cada sitio web tiene una dirección IP diferente, o "basados en nombres diferentes", lo que significa que con una sola dirección IP están funcionando sitios web con diferentes nombres (de dominio). Apache fue uno de los primeros servidores web en soportar hosting virtual basado en direcciones IP.

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

* [ServerName](https://httpd.apache.org/docs/2.4/mod/core.html#servername)
* [ServerAdmin](https://httpd.apache.org/docs/2.4/mod/core.html#serveradmin)
* [DocumentRoot](https://httpd.apache.org/docs/2.4/mod/core.html#documentroot)
* [ErrorLog](https://httpd.apache.org/docs/2.4/mod/core.html#errorlog)
* [CustomLog](http://httpd.apache.org/docs/current/mod/mod_log_config.html#customlog)

Podemos habilitar o deshabilitar nuestros host virtuales utilizando los siguientes comandos:

	a2ensite
	a2dissite

