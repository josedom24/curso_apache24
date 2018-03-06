# Páginas de errores personalizadas

Apache ofrece la posibilidad de que los administradores puedan configurar las respuestas que muestra el servidor Apache cuando se producen algunos errores o problemas. Se puede hacer que el servidor siga uno de los siguientes comportamientos:

1. Desplegar un texto diferente, en lugar de los mensajes que aparecen por defecto.
2. Redireccionar la petición a una URL local.
3. Redireccionar la petición a una URL externa.

La directiva [`ErrorDocument`](https://httpd.apache.org/docs/2.4/es/mod/core.html#errordocument) me permite configurar la página de error personalizada para cada tipo de error (código de estados). Por ejemplo:

	ErrorDocument 403 "Sorry can't allow you access today" 
	ErrorDocument 404 /error/404.html
	ErrorDocument 500 http://www.pagina2.org/error.html

La directiva `ErrorDocument` la podemos usar en diferentes ámbitos de nuestra configuración, por ejemplo si la ponemos dentro de un Host Virtual la páginas de errores personalizadas se verán sólo en ese host virtual.

Si queremos configurar las páginas de error personalizadas podemos hacerlo en un fichero de configuración: `/etc/apache2/conf-available/localized-error-pages.conf`. Este fichero de configuración está activo, podemos ver el enlace simbólico que existe en el directorio `/etc/apache2/conf-enabled`.

## Cambiando el idioma de las páginas de error personalizadas

En el directorio `/usr/share/apache2/error` nos encontramos fichero tipo mapa donde se encuentra definida las páginas de error personalizadas para distintos idiomas. Por negociación de contenidos podemos activar la funcionalidad de que sirva la versión adecuada, para ello debemos descomentar en el fichero `/etc/apache2/conf-available/localized-error-pages.conf` el siguiente bloque:

	<IfModule mod_negotiation.c>
	        <IfModule mod_include.c>
	                <IfModule mod_alias.c>	

	                        Alias /error/ "/usr/share/apache2/error/"	

	                        <Directory "/usr/share/apache2/error">
	                                Options IncludesNoExec
	                                AddOutputFilter Includes html
	                                AddHandler type-map var
	                                Order allow,deny
	                                Allow from all
	                                LanguagePriority en cs de es fr it nl sv pt-br ro
	                                ForceLanguagePriority Prefer Fallback
	                        </Directory>	

	                        ErrorDocument 400 /error/HTTP_BAD_REQUEST.html.var
	                        ErrorDocument 401 /error/HTTP_UNAUTHORIZED.html.var
	                        ErrorDocument 403 /error/HTTP_FORBIDDEN.html.var
	                        ErrorDocument 404 /error/HTTP_NOT_FOUND.html.var
	                        ErrorDocument 405 /error/HTTP_METHOD_NOT_ALLOWED.html.var
	                        ErrorDocument 408 /error/HTTP_REQUEST_TIME_OUT.html.var
	                        ErrorDocument 410 /error/HTTP_GONE.html.var
	                        ErrorDocument 411 /error/HTTP_LENGTH_REQUIRED.html.var
	                        ErrorDocument 412 /error/HTTP_PRECONDITION_FAILED.html.var
	                        ErrorDocument 413 /error/HTTP_REQUEST_ENTITY_TOO_LARGE.html.var
	                        ErrorDocument 414 /error/HTTP_REQUEST_URI_TOO_LARGE.html.var
	                        ErrorDocument 415 /error/HTTP_UNSUPPORTED_MEDIA_TYPE.html.var
	                        ErrorDocument 500 /error/HTTP_INTERNAL_SERVER_ERROR.html.var
	                        ErrorDocument 501 /error/HTTP_NOT_IMPLEMENTED.html.var
	                        ErrorDocument 502 /error/HTTP_BAD_GATEWAY.html.var
	                        ErrorDocument 503 /error/HTTP_SERVICE_UNAVAILABLE.html.var
	                        ErrorDocument 506 /error/HTTP_VARIANT_ALSO_VARIES.html.var
	                </IfModule>
	        </IfModule>
	</IfModule>

Como se puede observar es necesario (directiva [`IfModule`](http://httpd.apache.org/docs/2.4/es/mod/core.html#ifmodule)) tener activo los módulos `negotiation`, `alias` (que están activos por defectos) y [`include`](http://httpd.apache.org/docs/current/mod/mod_include.html) que hay que activarlo:

	# a2enmod include

## Ejercicio

En todos los host virtuales se debe redefinir los mensajes de error de objeto no encontrado y no permitido. Para ello se crearan dos ficheros html dentro del directorio error. Realiza los cambios necesarias para llevarlo a cabo.

