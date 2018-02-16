# Negociación de contenidos

Apache puede escoger la mejor representación de un recurso basado en las preferencias proporcionadas por el navegador (browser) para los distintos tipos de medios, idiomas, conjunto de de caracteres y codificación. A esta funcionalidad se le llama [negociación de contenidos](http://httpd.apache.org/docs/2.4/content-negotiation.html). Un recurso puede estar disponible en diferentes representaciones. Por ejemplo, puede estar disponible en diferentes idiomas, es posible que el servidor haga una selección automáticamente de la página que tiene que servir. Esto funciona porque los navegadores pueden enviar como parte de su petición información sobre qué representación prefieren. Por ejemplo, un navegador podría indicar que prefiere ver información en francés y, si no fuera posible, en inglés. Los navegadores indican sus preferencias a través de cabeceras en la petición. Para pedir representaciones únicamente en español, el navegador podría enviar algo así: 

	Accept-Language: es

Para llevar a cabo esta funcionalidad Apache2 utiliza el módulo `negotiation_module` que está habilitado por defecto.

## Configuración del módulo de negociación de contenidos

Queremos que al acceder a la ULR `www.pagina1.org/internacional` se muetre un `index.html` con el idioma adecuado según la cabacera `Accept-Languaje` enviada por el cliente.

Lo primero que tenemos es crear varios ficheros `index.html` con los distintos idiomas ofrecidos por el servidor:

	# ls /var/www/html/internacional
	index.html.en  index.html.es

Hemos creado dos ficheros: [`index.html.en`]() para el idioma inglés y [`index.html.es`]() para el español.

A continuación debemos activar la opción `Multiviwes` para el directorio con el que estamos trabajando, por lo tanto en el fichero de configuración del virtual host `/wtc/apache2/sites-availables/paginaq.conf` creamos una sección `Directory`:

	...
	<Directory /var/www/html/internacional>
		Options +Multiviews
	</Directory>
	...

Ya tan sólo tenemos que confiurar el idioma en el navegado y acceder a la URL y podemos comprobar como se sirve las distintas páginas según el idioma seleccionado.

