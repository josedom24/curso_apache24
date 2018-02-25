# Empezamos estudiando algunas directivas

Estudiemos algunas directivas que podemos encontrar en `/etc/apache2/apache2.conf`:

## Directivas de control de la conexión

* [`Timeout`](http://httpd.apache.org/docs/2.4/mod/core.html#timeout): define, en segundos, el tiempo que el servidor esperará por recibir y transmitir durante la comunicación. `Timeout` está configurado por defecto a 300 segundos, lo cual es apropiado para la mayoría de las situaciones. 
* [`KeepAlive`](http://httpd.apache.org/docs/2.4/mod/core.html#keepalive): Define si las conexiones persistentes están activadas. Por defecto están activadas.
* [`MaxKeepAliveRequests`](http://httpd.apache.org/docs/2.4/mod/core.html#maxkeepaliverequests): Establece el número máximo de peticiones permitidas por cada conexión persistente. Por defecto está establecido como 100.
* [`KeepAliveTimeout`](http://httpd.apache.org/docs/2.4/mod/core.html#keepalivetimeout): Establece el número de segundos que el servidor esperará tras haber dado servicio a una petición, antes de cerrar la conexión. Por defecto 5 segundos.

## Otras directivas

* [`User`](http://httpd.apache.org/docs/2.4/mod/mpm_common.html#user): define el usuario que ejecuta los procesos de Apache2.
* [`Group`](http://httpd.apache.org/docs/2.4/mod/mpm_common.html#group): define el grupo al que corresponde el usuario.
* [`LogLevel`](http://httpd.apache.org/docs/2.4/mod/core.html#loglevel): Controla el nivel de información que se guarda en los ficheros de registro o logs.
* [`LogFormat`](http://httpd.apache.org/docs/2.4/mod/mod_log_config.html#logformat): Controla el formato de información que se va a guardar en los ficheros logs.
* [`Directory`](http://httpd.apache.org/docs/2.4/mod/core.html#directory) o [`DirectoryMatch`](http://httpd.apache.org/docs/2.4/mod/core.html#directorymatch): Declara un contexto para un directorio y todos sus directorios.
* [`Files`](http://httpd.apache.org/docs/2.4/mod/core.html#files) o [`FilesMatch`](http://httpd.apache.org/docs/2.4/mod/core.html#filesmatch): Declara un contexto para un conjunto de ficheros.