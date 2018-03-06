# Estructura de los ficheros de configuración

El fichero principal de configuración de Apache2 es `/etc/apache2/apache2.conf`. En ese fichero se incluyen los ficheros que forman parte de la configuración de Apache2:

	...
	IncludeOptional mods-enabled/*.load
	IncludeOptional mods-enabled/*.conf
	...
	Include ports.conf
	...
	IncludeOptional conf-enabled/*.conf
	IncludeOptional sites-enabled/*.conf

* Los ficheros que se añaden guardados en el directorio `mods-enabled` correponden a los módulos activos.
* Los ficheros añadidos del directorio `sites-enabled` corresponden a la configuración de los sitios virtuales activos.
* Del directorio `conf-enabled` añadimos ficheros de configuración adicionales.
* Por último en el fichero `ports.conf` se especifica los puertos de escucha del servidor.

## Opciones de configuración para los servidores virtuales

Por defecto se indican las opciones de configuración del directorio `/var/www` y de todos sus subdirectorios, por lo tanto los `DocumentRoot` de los virtual host que se crean deben ser subdirectorios del este directorio, por lo tanto encontramos en el fichero `/etc/apache2/apache2.conf` lo siguiente:

	<Directory /var/www/>
	    Options Indexes FollowSymLinks
	    AllowOverride None
	    Require all granted
	</Directory>

Podemos indicar como directorio raíz de nuestros virtual host otro directorio (tenemos que descomentar):

	#<Directory /srv/>
	#    Options Indexes FollowSymLinks
	#    AllowOverride None
	#    Require all granted
	#</Directory>

## Añadir nueva configuración

Si tenemos configuración adicional para nuestro servidor podemos guardarla en un fichero (por ejemplo `prueba.conf`) dentro del directorio `/etc/apache2/conf-available`. Para añadir dicho fichero de configuración a la configuración general del servidor usamos la instrucción:

	# a2enconf prueba

Esta instrucción crea un enlace simbólico en el directorio `/etc/apache2/conf-enabled`. Para desactivar una configuración usamos:

	# a2disconf prueba 

## Variables de entorno de Apache

El servidor HTTP Apache HTTP ofrece un mecanismo para almacenar información en variables especiales que se llaman variables de entorno. Esta información puede ser usada para controlar diversas operaciones como por ejemplo, almacenar datos en ficheros de registro (`log files`) o controlar el acceso al servidor. Podemos encontrar estas variables definidas en el fichero `/etc/apache2/envvars`.