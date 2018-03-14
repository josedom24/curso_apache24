# Ejecución de script PHP

## Apache2 y módulo PHP

Instalamos apache2 y el módulo que permite que los procesos de apache2 sean capaz de ejecutar el código PHP:

	apt install apache2 php7.0 libapache2-mod-php7.0

Cuando hacemos la instalación se desactiva el MPM `event` y se activa el `prefork`:

	...
	Module mpm_event disabled.
	Enabling module mpm_prefork.
	apache2_switch_mpm Switch to prefork
	...

Si vemos el contenido del fichero de configuración del módulo php de apache2, `/etc/apache2/mods-available/php7.0.conf`, nos encontramos las siguientes líneas:

	<FilesMatch ".+\.ph(p[3457]?|t|tml)$">
	    SetHandler application/x-httpd-php
	</FilesMatch>
	...

Donde se crea un nuevo manejador, que hace que los ficheros cuya extensión es `php` sean gestionados por el módulo que interpreta el código php.


### Configuración de php

La configuración de php está dividida en distintos directorios para las distintas formas de ejecutar el código php:

* `/etc/php/7.0/cli`: Configuración de php para `php7.0-cli`, cuando se utiliza php desde la línea de comandos.
* `/etc/php/7.0/apache2`: Configuración de php para apache2 cuando utiliza el módulo.
* `/etc/php/7.0/fpm`: Configuración de php para php-fpm.
* `/etc/php/7.0/mods-available`: Módulos disponibles de php que puedes estar configurados en cualquiera de los escenarios anteriores.

Si nos fijamos en la configuración de php para apache2:

* `/etc/php/7.0/apache2/conf.d`: Módulos instalados en esta configuración de php (enlaces simbólicos a `/etc/php/7.0/mods-available`).
* `/etc/php/7.0/apache2/php.ini`: Configuración de php para este escenario.

## PHP-FPM

FPM (FastCGI Process Manager) es una implementación alternativa al PHP FastCGI. FPM se encarga de interpretar código PHP. Aunque normalmente se utiliza junto a un servidor web (Apache2 o ngnix) vamos a hacer en primer lugar una instalación del proceso y vamos a estudiar algunos parámetros de configuración y estudiar su funcionamiento.

Para instalarlo en Debian 9:

	apt install php7.0-fpm php7.0

Ahora podemos desactivar el módulo de php, y volver a activar el MPM event.

	a2dismod php7.0
	a2dismod mpm_prefork
	a2enmod mpm_event

### Configuración

Con esto hemos instalado php 7.0 y php-fpm. Veamos primeros algunos ficheros de configuración de php:

Si nos fijamos en la configuración de php para php-fpm:

* `/etc/php/7.0/fpm/conf.d`: Módulos instalados en esta configuración de php (enlaces simbólicos a `/etc/php/7.0/mods-available`).
* `/etc/php/7.0/fpm/php-fpm.conf`: Configuración general de php-fpm.
* `/etc/php/7.0/fpm/php.ini`: Configuración de php para este escenario.
* `/etc/php/7.0/fpm/pool.d`: Directorio con distintos pool de configuración. Cada aplicación puede tener una configuración distinta (procesos distintos) de php-fpm.

Por defecto tenemos un pool cuya configuración la encontramos en `/etc/php/7.0/fpm/pool.d/www.conf`, en este fichero podemos configurar muchos parámetros, los más importantes son:

* `[www]`: Es el nombre del pool, si tenemos varios, cada uno tiene que tener un nombre.
* `user` y `grorup`: Usuario y grupo con el que se va ejecutar los procesos.
* `listen`: Se indica el socket unix o el socket TCP donde van a escuchar los procesos:
	* Por defecto, escucha por un socket unix:
		`listen = /run/php/php7.0-fpm.sock`
	* Si queremos que escuche por un socket TCP:
		`listen = 127.0.0.1:9000`
	* En el caso en que queramos que escuche en cualquier dirección:
		`listen = 9000`

* Directivas de procesamiento, gestión de procesos: 
	* `pm`: Por defecto igual a `dynamic` (el número de procesos se crean y destruyen de forma dinámica). Otros valores: `static` o `ondemand`.
	* Otras directivas: `pm.max_children`, `pm.start_servers`, `pm.min_spare_servers`,...

* `pm.status_path = /status`: No es necesaria, pero vamos a activar la URL de `status` para comprobar el estado del proceso.

Por último reiniciamos el servicio:

	systemctl restart php7.0-fpm


### Configuración de Apache2 con php-fpm

Necesito activar los siguientes módulos:

	a2enmod proxy proxy_fcgi


#### Activarlo para cada virtualhost

Podemos hacerlo de dos maneras:

* Si php-fpm está escuchando en un socket TCP:

		ProxyPassMatch ^/(.*\.php)$ fcgi://127.0.0.1:9000/var/www/html/$1

* Si php-fpm está escuchando en un socket UNIX:

		ProxyPassMatch ^/(.*\.php)$ unix:/run/php/php7.0-fpm.sock|fcgi://127.0.0.1/var/www/html

Otra forma de hacerlo es la siguiente:

* Si php-fpm está escuchando en un socket TCP:

		<FilesMatch "\.php$">
	    	SetHandler "proxy:fcgi://127.0.0.1:9000"
		</FilesMatch>

* Si php-fpm está escuchando en un socket UNIX:

		<FilesMatch "\.php$">
   	    	SetHandler "proxy:unix:/run/php/php7.0-fpm.sock|fcgi://127.0.0.1/"
		</FilesMatch>

#### Activarlo para todos los virtualhost

Tenemos a nuestra disposición un fichero de configuración `php7.0-fpm` en el directorio `/etc/apache2/conf-available`. Por defecto funciona cuando php-fpm está escuchando en un socket UNIX, si escucha por un socket TCP, hay que cambiar la línea:

	SetHandler "proxy:unix:/run/php/php7.0-fpm.sock|fcgi://localhost"

por esta:

	SetHandler "proxy:fcgi://127.0.0.1:9000"

Por último activamos la configuración:

	a2enconf php7.0-fpm

