# Instalación del servidor web Apache 2.4

## Instalación en Debian/Ubuntu

Para instalar  el servidor web Apache en sistemas GNU/Linux Debian/Ubuntu y derivados, ejecutamos como administrador:

	apt-get install apache2

Para controlar el servicio apache2 podemos usar (para más [información](http://httpd.apache.org/docs/2.4/es/stopping.html)):

    apache2ctl [-k start|restart|graceful|graceful-stop|stop]

La opción `graceful` es un reinicio suave, se terminan de servir las peticiones que están establecidas y cuando se finaliza se hace una reinicio del servidor.

Con esta herramienta podemos obtener también más información del servidor:

* `apache2ctl -t` : Comprueba la sintaxis del fichero de configuración.
* `apache2ctl -M` : Lista los módulos cargados.
* `apache2ctl -S` : Lista los sitios virtuales y las opciones de configuración.
* `apache2ctl -V` : Lista las opciones de compilación

Evidentemente el servidor está gestionado por `Systemd`, por lo tanto para controlar el arranque, reinicio y parada del servicio utilizaremos la siguiente instrucción:

	systemctl [start|stop|restart|reload|status] apache2.service

## Instalación en Windows

* [Using Apache HTTP Server on Microsoft Windows](https://httpd.apache.org/docs/2.4/platform/windows.html)

## Ejemplo

Vamos a instalar el servidor web Apache2 en un servidor remoto y en un servidor local. Los nombres del servidor remoto están registrado en un DNS, sin embargo los nombres del servidor local habrá que gestionarlo con resolución estática.