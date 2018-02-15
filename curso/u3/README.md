# Instalación del servidor web Apache 2.4

## Instalación en Debian/Ubuntu

Para instalar  el servidor web Apache en sistemas GNU/Linux Debian/Ubuntu y derivados, ejecutamos como administrador:

	apt-get install apache2

Para controlar el servicio apache2 podemos usar (para más [información](http://httpd.apache.org/docs/2.4/es/stopping.html)):

    apache2ctl [-k start|restart|graceful|graceful-stop|stop]

La opción `graceful` es un reinicio suave, se terminan de servir las peticiones que están establecidas y cuando se finaliza se hace una reinicio del servidor.

Evidentemente el servidor está gestionado por el Systemd, por lo tanto para gestionar el arranque, reincio y parada del servicio utilizaremos la siguiente instrucción:

	systemctl [start|stop|restart|reload|status] apache2.service

## Instalación en CentOS

En sistemas GNU/Linux CentOS/Red Hat tendráimos que ejecutar como administrador:

	yum install httpd

Para gestionar el servicio:

	systemctl [start|stop|restart|reload|status] httpd.service

## Instalación en Windows

* [Using Apache HTTP Server on Microsoft Windows](https://httpd.apache.org/docs/2.4/platform/windows.html)