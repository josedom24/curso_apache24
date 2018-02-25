# Uso de módulos en Apache 2.4

Uno de los aspectos característicos del servidor HTTP Apache es su modularidad, Apache tiene un sinfín de características adicionales que si estuvieran siempre incluidas, harían de él un programa demasiado grande y pesado. En lugar de esto, Apache se compila de forma modular y se cargan en memoria sólo los módulos necesarios en cada caso.

Los módulos se guardan en la configuración de apache2 en dos directorios:

* `/etc/apache2/mods-available/`: Directorio que contiene los módulos disponibles en la instalación actual.
* `/etc/apache2/mods-enabled/`: Directorio que incluye mediante enlaces simbólicos al directorio anterior, los módulos que se van a cargar en memoria la próxima vez que se inicie Apache.

## Módulos de apache

Los módulos de apache se pueden encontrar de dos maneras, compilados dentro del ejecutable apache2 o compilados de forma individual como una biblioteca de enlace dinámico (con extensión .so). Para saber qué módulos incluye el ejecutable de nuestra instalación de apache, podemos utilizar la siguiente instrucción:

	# apache2 -l	
	Compiled in modules:
	  core.c
	  mod_so.c
	  mod_watchdog.c
	  http_core.c
	  mod_log_config.c
	  mod_logio.c
	  mod_version.c
	  mod_unixd.c

El resto de módulos disponibles para cargar en tiempo de ejecución se encuentran en el
directorio `/usr/lib/apache2/modules/`:

	# ls /usr/lib/apache2/modules/

	httpd.exp		mod_dav.so	    mod_proxy_fcgi.so
	mod_access_compat.so	mod_dbd.so	    mod_proxy_fdpass.so
	mod_actions.so		mod_deflate.so	    mod_proxy_ftp.so
	...

Pueden parecer muchos, pero son sólo los módulos de la instalación estándar y se incluyen dentro del paquete `apache2-data`. Hay otros muchos módulos que se distribuyen en paquetes separados, que en *debian* reciben el nombre `libapache2-mod-*`:

	# apt-cache search libapache2-mod
	libapache2-mod-auth-ntlm-winbind - apache2 module for NTLM authentication against Winbind
	libapache2-mod-upload-progress - upload progress support for the Apache web server
	libapache2-mod-xforward - Apache module implements redirection based on X-Forward response header
	...

## Utilización de módulos

Si vamos al directorio donde se ubican los módulos disponibles de Apache `/etc/apache2/mods-available` y hacemos un
listado encontramos ficheros `*.load` y `*.conf`.

Los ficheros con extensión `load` suelen incluir una línea con la directiva `LoadModule`, por ejemplo:

	# cat userdir.load 
	LoadModule userdir_module /usr/lib/apache2/modules/mod_userdir.so

Además de cargar el módulo, en muchos casos es necesario realizar alguna configuración mediante directivas, por lo que en esos casos se existe un fichero con extensión `.conf`.

Si queremos que Apache utilice cualquier módulo, lo que tendríamos que hacer es un enlace simbólico del fichero de extensión `.load` (y del `.conf` si existe) en el directorio `/etc/apache2/mods-enabled`. Este enlace lo podemos hacer con la instrucción `a2enmod`, por ejemplo:

	# a2enmod userdir
	Enabling module userdir.
	To activate the new configuration, you need to run:
	  systemctl restart apache2

Para desactivarlo (borrar el enlace simbólico) utilizamos la instrucción `a2dismod`. después de utilizar estos comandos hay que reiniciar el servicio.

## Módulos activos por defecto

Para ver los módulos activados en apache2:

	# apache2ctl -M

	Loaded Modules:
	 core_module (static)
	 so_module (static)
	 watchdog_module (static)
	 http_module (static)
	 log_config_module (static)
	 ...

