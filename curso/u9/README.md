# Configuración de acceso a los servidores virtuales

## Configuración de los puertos de escucha

Para determinar los puertos de escucha del servidor web utilizamos la directiva [`Listen`](http://httpd.apache.org/docs/2.4/es/mod/mpm_common.html#listen) que podemos modificar en el archivo `/etc/apache2/ports.conf`.

## Como funciona en los Virtual Host

`Listen` solo le dice al servidor principal en qué direcciones y puertos tiene que escuchar. Si no se usan directivas `<VirtualHost>`, el servidor se comporta de la misma manera con todas las peticiones que se acepten. Sin embargo, `<VirtualHost>` puede usarse para especificar un comportamiento diferente en una o varias direcciones y puertos. Para implementar un host virtual, hay que indicarle primero al servidor que escuche en aquellas direcciones y puertos a usar. Posteriormente se debe crear un una sección `<VirtualHost>` en una dirección y puerto específicos para determinar el comportamiento de ese host virtual. 

Por defecto los Virtual Host que hemos definido responden desde cualquier IP en el puerto 80, en el fichero `/etc/apache2/sites-available/000-default.conf` encontramos:

	<VirtualHost *:80>
	...

## Ejemplo: Virtual Host basado en IP

En este caso nuestra máquina debe tener configurado varias IP (lo vamos a probar en nuestro servidor local que tiene configurado dos interfaces de red), por cada IP se va servir un virtual host.

	<VirtualHost 172.20.30.40:80>
	    ServerAdmin webmaster@www1.example.com
	    DocumentRoot "/www/vhosts/www1"
	    ServerName www1.example.com
	    ErrorLog "/www/logs/www1/error_log"
	    CustomLog "/www/logs/www1/access_log" combined
	</VirtualHost>	

	<VirtualHost 172.20.30.50:80>
	    ServerAdmin webmaster@www2.example.org
	    DocumentRoot "/www/vhosts/www2"
	    ServerName www2.example.org
	    ErrorLog "/www/logs/www2/error_log"
	    CustomLog "/www/logs/www2/access_log" combined
	</VirtualHost>

## Ejemplo: Servir el mismo contenido en varias IP

Suponemos que nuestro servidor tiene dos interfaces de red (una interfaz interna (intranet) y otra externa (internet)), queremos que responda a las dos direcciones:

	<VirtualHost 192.168.1.1 172.20.30.40>
    	DocumentRoot "/www/server1"
    	ServerName server.example.com
    	ServerAlias server
	</VirtualHost>

## Ejemplo: Sirviendo distintos sitios en distintos puertos

En esta ocasión hemos definido dos puertos de escucha en el fichero `/etc/apache2/ports.conf`:

	Listen 80
	Listen 8080

Y la configuración de los virtual host podría ser la siguiente:

	<VirtualHost *:80>
    	ServerName www.example.com
    	DocumentRoot "/www/domain-80"
	</VirtualHost>

	<VirtualHost *:8080>
    	ServerName www.example.com
    	DocumentRoot "/www/domain-8080"
	</VirtualHost>

