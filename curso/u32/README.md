# Configuración de un proxy inverso

 Un proxy inverso es un tipo de servidor proxy que recupera recursos en nombre de un cliente desde uno o más servidores. Por lo tanto el cliente hace la petición al puerto 80 y es el proxy el que hace la petición al servidor web que normamente está en una red interna no accesible desde el cliente.

 ![proxy](img/proxy.png)

## Apache como proxy inverso

Apache2.4 puede funcionar como proxy inverso usando el módulo `proxy` juanto a otros módulos, por ejemplo:

* proxy_http: Para trabajar con el protocolo HTTP.
* proxy_ftp: Para trabajar con el protocolo FTP.
* proxy_html: Permite reescribir los enlaces HTML en el espacio de direcciones de un proxy.
* proxy_ajp: Para trabajar con el protocolo AJP para Tomcat.
* ...

Por lo tanto, para empezar, vamos activar los módulos que necesitamos:

	# a2enmod proxy proxy_http

## Ejemplo de utilización de proxy inverso

Tenemos a nuestra disposición un servidor interno (no accesible desde el cliente) en la dirección 192.168.1.2, con el nombre de `interno.example.org`. Tenemos un servidor que va a funcionar de proxy, llamado `proxy.example.org` con dos intyerfaces de red: una pública conectada a la red donde se encuentra el cliente, y otra interna conectada a la red donde se encuentra el servidor interno.