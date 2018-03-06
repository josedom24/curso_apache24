# Negociación de contenidos

Apache puede escoger la mejor representación de un recurso basado en las preferencias proporcionadas por el navegador (browser) para los distintos tipos de medios, idiomas, conjunto de de caracteres y codificación. A esta funcionalidad se le llama [negociación de contenidos](http://httpd.apache.org/docs/2.4/content-negotiation.html). Un recurso puede estar disponible en diferentes representaciones. Por ejemplo, puede estar disponible en diferentes idiomas, es posible que el servidor haga una selección automáticamente de la página que tiene que servir. Esto funciona porque los navegadores pueden enviar como parte de su petición información sobre qué representación prefieren. Por ejemplo, un navegador podría indicar que prefiere ver información en francés y, si no fuera posible, en inglés. Los navegadores indican sus preferencias a través de cabeceras en la petición. Para pedir representaciones únicamente en español, el navegador podría enviar algo así: 

	Accept-Language: es

Para llevar a cabo esta funcionalidad Apache2 utiliza el módulo `negotiation_module` que está habilitado por defecto.

## Configuración del módulo de negociación de contenidos con Multiviews

Queremos que al acceder a la ULR `www.pagina1.org/internacional` se muestre un `index.html` con el idioma adecuado según la cabecera `Accept-Languaje` enviada por el cliente.

Lo primero que tenemos es crear varios ficheros `index.html` con los distintos idiomas ofrecidos por el servidor:

	# ls /var/www/html/internacional
	index.html.en  index.html.es

Hemos creado dos ficheros: [`index.html.en`](https://raw.githubusercontent.com/josedom24/curso_apache24/master/curso/u12/fich/index.html.en) para el idioma inglés y [`index.html.es`](https://raw.githubusercontent.com/josedom24/curso_apache24/master/curso/u12/fich/index.html.es) para el español.

A continuación debemos activar la opción `Multiviews` para el directorio con el que estamos trabajando, por lo tanto en el fichero de configuración del virtual host `/etc/apache2/sites-availables/pagina1.conf` creamos una sección `Directory`:

	...
	<Directory /var/www/html/internacional>
		Options +Multiviews
	</Directory>
	...

Ya tan sólo tenemos que configurar el idioma en el navegado y acceder a la URL y podemos comprobar como se sirve las distintas páginas según el idioma seleccionado.

## Configuración del módulo de negociación de contenidos con ficheros type-map

Un [`handler`](https://httpd.apache.org/docs/2.4/es/handler.html) es una representación interna de Apache de una acción que se va a ejecutar cuando hay una llamada a un fichero. Generalmente, los ficheros tienen *handlers* implícitos, basados en el tipo de fichero de que se trata. Normalmente, todos los ficheros son simplemente servidos por el servidor, pero algunos tipos de ficheros se tratan de forma diferente.

Nosotros vamos a tener un fichero especial que denominamos *type-map* con extensión `var` al que le vamos a crear un *handler* para manejarlo de una manera especial para el negociado de contenidos.

Los ficheros de tipo mapa tienen una entrada para cada variante disponible. Estas entradas consisten en líneas de cabecera contiguas en formato HTTP. Las entradas para diferentes variantes se separan con líneas en blanco. Las líneas en blanco no están permitidas dentro de una entrada. Existe el acuerdo de empezar un fichero mapa con una entrada para la entidad combinada como un todo.

Por lo tanto la configuración del directorio sería:

	<Directory /var/www/html/internacional>
		DirectoryIndex index.var
		AddHandler type-map .var
	</Directory>
	...

Con la directiva `DirectoryIndex` indicamos que el fichero por defecto será `index.var`.

En el directorio `/var/www/html/internacional`, ademas de tener los ficheros: `index.html.en` y `index.html.es`, tendremos un fichero `index.var` con el siguiente contenido:

	URI: index	

	URI: index.html.en
	Content-type: text/html
	Content-language: en	

	URI: index.html.es
	Content-type: text/html
	Content-language: es

