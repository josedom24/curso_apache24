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
Vamos a utilizar la directiva [`ProvyPass`](https://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypass) en el fichero de configuración del virtual host, de la siguiente forma:

	ProxyPass "/web/" "http://interno.example.org/"

También lo podemos configurar de forma similar con:

	<Location "/web/">
		ProxyPass "http://interno.example.org/"
	</Location>

Evidentemente debe funcionar la resolución de nombre para que el proxy pueda acceder al servidor interno.

De esta manera al acceder desde el cliente la URL `http://proxy.example.org/web/` se mostraría la página que se encuentra en el servidor interno.

### El probelmas de las redirecciones

Cuando creamos una redirección en un servidor web y el cliente intenta acceder al recurso, el servidor manda una respuesta con código de estado `301` o `302`, e indica la URL de la nueva ubicación del recurso en una cabecera HTTP llamada `Location`.

Si hemos configurado una redirección en el servidor interno, cuando se accede al recurso a través del proxy, la redirección de seraliza pero la cabecera `Location` viene referencia con la dirección del servidor interno, por lo que el cliente es incapaz de acceder a la nueva ubicación. Para solucionarlo utilizamos la directiva [`ProxyPassReverse`](https://httpd.apache.org/docs/2.4/mod/mod_proxy.html#proxypassreverse) que se encarga de resscribir la URL de la cabacera `Location`.

La configuración quedaría:

	ProxyPass "/web/" "http://interno.example.org/"
	ProxyPassReverse "/web/" "http://interno.example.org/"

O de esta otra forma:

	<Location "/web/">
		ProxyPass "http://interno.example.org/"
		ProxyPassReverse "http://interno.example.org/"
	</Location>

### El problema de las rutas HTML

La página que servimos a través del proxy que se guarada en el servidor interno puede tener declarada rutas, por ejemplo en imágenes o enlaces. Nos podemos encontrar con difrentes tipos de rutas:

* `http://interno.example.org/img/imagen.jpg`
* `/imagen.jpg`
* `imagen.jpg`

* La primera es una ruta absoluta donde aparece la dirección del servidor interno y que evidentemente el cliente no va a poder seguir.
* La segunda es una ruta absoluta, referenciada a la raíz del `DocumentRoot`.
* La tercera es una ruta relativa.

Si tenemos una ruta relativa, el cliente la va a poder seguir sin problema cuando accede a través del proxy, pero si tenemos una ruta como la segunda no lo va a poder hacer, porque en el `DocumentRoot` del proxy no existe este recurso.

Para solucionar este problema debemos reescribir el HTML para cambiar la referencia del enlace. Para ello necesitamos activar un nuevo módulo:

	# a2enmod proxy_html

Y realizar la siguiente configuración:

	ProxyPass "/ejercicio1/"  "http://ejercicio.gonzalonazareno.org/"
	ProxyPassReverse "/ejercicio1/"  "http://ejercicio.gonzalonazareno.org/"
	ProxyHTMLURLMap http://ejercicio.gonzalonazareno.org /ejercicio1
	<Location /ejercicio1/>
	    ProxyPassReverse /
	    ProxyHTMLEnable On
	    ProxyHTMLURLMap / /ejercicio1/
	    RequestHeader    unset  Accept-Encoding
	</Location>