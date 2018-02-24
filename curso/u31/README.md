# Consejos de seguridad

Además de utilizar HTTPS y activar y configurar modSecurity, podemos tener en cuanta algunos otros consejos de seguridad:

## Ocultar versión y sistema 

En el fichero `/etc/apache2/conf-enabled/security.conf`, podemos configurar las directivas [`ServerSignature`](https://httpd.apache.org/docs/2.4/es/mod/core.html#serversignature) y [`ServerTokens`](https://httpd.apache.org/docs/2.4/es/mod/core.html#servertokens).


* `ServerTokens`: Donde configuramos la información devuelta en las cabeceras de respuesta HTTP. Además si la otra directiva está activa, muestra esa información en las páginas de error predeterminada.
* `ServerSignature`: Permite controlar si se muestra información en las páginas de errores por defecto (la versión de apache que tenemos instalada, la IP y el puerto).

En un servidor en producción los valores deberían ser:

	ServerSignature Off
	ServerTokens Prod

## Desactivar listado de directorios 

Es aconsejable desactivar la opción de `Indexes` para evitar que apache2 muestre la lista de ficheros y directorios sino encuentra un fichero que tenga un nombre predeterminado por la directiva `DirectotyIndex`. Por ejemplo:

	<Directory /var/www/pagina1/>
		Options -Indexes
	</Directory>

## Deshabilitar módulos innecesarios 

Esto es necesario por dos razones, para reducir la ocupación de recurso, aumentando el rendimiento, y para evitar posibles ataques debido a vulnerabilidades que algunos módulos puedan tener. Podemos visualizar los módulos activos ejecutamos:

	# apache2ctl -M

Por ejemplo, por defecto tenemos activo el módulo `status` que nos permite ver el estado del servidor si accedermos a la URL `/server-status` (por defecto sólo desde localhost). este m´odulo lo podríamos desactivar:

	# a2dismod status

## Deshabilitar enlaces simbólicos 

 Por defecto de permite seguir los enlaces símbolicos dentro de nuestros Virtual Host. Esta funcionalidad puede traer consecuencias no deseables si por una mal configuración se filtran contenidos de ficheros que no deberían ser visibles para els ervidor web. Por lo tanto en el fichero `/etc/apache2/apache2.conf` deberíamos tener:

 	<Directory /var/www/>
        # Options Indexes FollowSymLinks 
        AllowOverride None
        Require all granted
	</Directory>

Comentamos o quitamos la línea que permite mostrar el índice de ficheros y directorios y seguir enlaces simbólicos.

## Limitar tamaño de peticiones 



## Limitar acceso a sistemas de control de versiones

## Limitar tamaño de peticiones 

## Mantenernos actualizados 

