# Módulos de Multiprocesamiento (MPM)

Los servidores web pueden ser configurado para manejar las peticiones de diferente forma, desde el punto de vista en que son creados y manejados los subprocesos necesarios que atienden a cada cliente conectado a este. En esta unidad vamos a explicar los MPM (Módulos de multiprocesamiento) que nos permiten configurar el servidor Web para gestionar las peticiones que llegan al servidor.

## event

Por defecto apache2 se configura con el MPM event, podemos ver el MPM que estamos utilizando con la siguiente instrucción:

	# apachectl -V
	...
	Server MPM:     event
	...

El MPM [event](https://httpd.apache.org/docs/2.4/mod/event.html) en versiones anteriores de apache2 era un módulo experimental, pero en Apache 2.4 se considera estable y mejora el funcionamiento del PMP worker. Este módulo usa procesos y al mismo tiempo hace uso de threads (también llamados hilos), es decir, combina las técnicas de forking y threading. Al iniciar Apache Event se crean varios procesos hijo y a su vez cada proceso hijo emplea varios threads. Con esto se consigue que cada proceso hijo pueda manejar varias peticiones simultaneas gracias a los threads. 

En `/etc/apache2/mods-availables/mpm_event.conf` podemos configurar las opciones de configuración de este módulo:

* `StartServers`: Número de procesos hijos que se crean al iniciar el servidor, por defecto 2.
* `MinSpareThreads`: Mínimo número de hilos esperando para responder, por defecto 25.
* `MaxSpareThreads`: Máximo número de hilos esperando para responder, por defecto 75.
* `ThreadLimit`: Límite superior del número de hilos por proceso hijo que pueden especificarse, por defecto 64.
* `ThreadsPerChild`: Número de hilos de cada proceso, por defecto 25.
* `MaxRequestWorkers`: Límite de peticiones simultaneas que se pueden responder, por defecto 150.
* `MaxConnectionsPerChild`: Límite  en  el  número  de  peticiones  que  un  proceso  hijo  puede  atender  durante  su  vida,por defecto 0 (no se indica).

## prefork

 Este módulo crea diferentes procesos independientes para manejar las diferentes peticiones. Esta técnica de crear varios procesos se la denomina forking, de ahí el nombre mpm-prefork. Al iniciar Apache Prefork se crean varios procesos hijo y cada uno puede responder una petición.

Para cambiar de MPM tenemos que desactivar el actual y activar el nuevo módulo::

	# a2dismod mpm_event
	# a2enmod mpm_prefork
	# service apache2 restart	

	# apachectl -V
	...
	Server MPM:     prefork
	...

En `/etc/apache2/mods-availables/mpm_prefork.conf` podemos configurar las opciones de configuración de este módulo:

* `StartServers`: Número de procesos hijos que se crean al iniciar el servidor, por defecto 5.
* `MinSpareServers`: Mínimo número de procesos esperando para responder, por defecto 5.
* `MaxSpareServers`: Máximo número de procesos esperando para responder, por defecto 10.
* `MaxRequestWorkers`:  Límite de peticiones simultaneas que se pueden responder, por defecto 150.
* `MaxConnectionsPerChild`: Límite  en  el  número  de  peticiones  que  un  proceso  hijo  puede  atender  durante  su  vida,por defecto 0 (no se indica).
