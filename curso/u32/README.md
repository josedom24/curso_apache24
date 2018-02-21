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

### Sirviendo una página estática

En nuestro servidor interno hemos creado un virtual host para servir una página estática, `index.html`.
Vamos a utilizar la directiva [`ProvyPass`]() en el fichero de configuración del virtual host, de la siguiente forma:

	ProxyPass "/web/" "http://interno.example.org/"

También lo podemos configurar de forma similar con:

	<Location "/web/">
		ProxyPass "http://interno.example.org/"
	</Location>

Evidentemente debe funcionar la resolución de nombre para que el proxy pueda acceder al servidor interno.

De esta manera al acceder desde el cliente la URL `http://proxy.example.org/web/` se mostraría la página que se encuentra en el servidor interno.

### El probelmas de las redirecciones

Cuando creamos una redirección en un servidor web y el cliente intenta acceder al recurso, el servidor manda una respuesta con código de estado `301` o `302`, e indica la URL de la nueva ubicación del recurso en una cabecera HTTP llamada `Location`.

Si hemos configurado una redirección en el servidor interno, cuando se accede al recurso a través del proxy, la redirección de seraliza pero la cabecera `Location` viene referencia con la dirección del servidor interno, por lo que el cliente es incapaz de acceder a la nueva ubicación