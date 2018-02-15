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
* Los ficheros añadidos del directorio `sites-enabled` coresponden a la configuración de los sitios virtuales activos.
* Del directorio `conf-enabled` añadimos ficheros de configuración adicionales.
* Por último en el fichero `ports.conf` se especifica los puertos de escucha del servidor.

## Opciones de configuración para los servidores virtuales

Por defecto se indican las opciones de configuración del directorio `/var/www` y de todos sus subdirectorios, por lo tanto los `DocumentRoot` de los virtualhost que se crean deben ser subdirectorios del este directorio:

	<Directory /var/www/>
	    Options Indexes FollowSymLinks
	    AllowOverride None
	    Require all granted
	</Directory>

Podemos indicar como directorio raíz de nuestros virtualhost otro directorio (tenemos que descomentar):

	#<Directory /srv/>
	#    Options Indexes FollowSymLinks
	#    AllowOverride None
	#    Require all granted
	#</Directory>

 