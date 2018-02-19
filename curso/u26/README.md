# Ejecución de script python

## Apache2 y módulo wsgi

Instalamos el módulo de apache2 que nos permite ejecutar código python: `libapache2-mod-wsgi`.

Veamos un ejemplo de configuración para una aplicación django. Suponemos que el fichero wsgi se encuentra en el directorio: ``/var/www/html/mysite/mysite/wsgi.py`` y configuramos apache2 de la siguiente manera::

    <VirtualHost *>
        ServerName www.example.com
        DocumentRoot /var/www/html/mysite
        WSGIDaemonProcess mysite user=www-data group=www-data processes=1 threads=5 python-path=/var/www/html/mysite
        WSGIScriptAlias / /var/www/html/mysite/mysite/wsgi.py

        <Directory /var/www/html/mysite>
                WSGIProcessGroup mysite
                WSGIApplicationGroup %{GLOBAL}
                Require all granted
        </Directory>
    </VirtualHost>

Si hemos usado un entorno virtual ecreado en el directorio ``/home/debian/python``, la siguiente línea de configuración quedaría de la siguiente manera:

    ...
    WSGIDaemonProcess mysite user=www-data group=www-data processes=1 threads=5 python-path=/var/www/html/mysite:/home/debian/python/lib/python2.7/site-packages
    ...

## Usando servidores wsgi

Otra forma de ejecutar código python es usar servidores de aplicación wsgi. Tenemos a nuestra disposición varios servidores: [A Comparison of Web Servers for Python Based Web Applications](https://www.digitalocean.com/community/tutorials/a-comparison-of-web-servers-for-python-based-web-applications). Realmente usamos apache2 como proxy inverso que envía la petición python al servidor WSGI que estemos utilizando.

### uwsgi

Para instalarlo en Debian 9 Stretch:

    apt install uwsgi
    apt install uwsgi-plugin-python

También lo podemos instalar con `pip` en un entorno virtual.  

**Despliegue de una aplicación django con uwsgi**

Hemos creado una aplicación django en el directorio: `/home/debian/myapp` para desplegarla con uwsgi ejecutamos:

    uwsgi --http :8080 --plugin python --chdir /home/debian/myapp --wsgi-file myapp/wsgi.py --process 4 --threads 2 --master 

Otra alternativa es crear un fichero `.ini` de configuración, `ejemplo.ini` de la siguiente manera:

    [uwsgi]
    http = :8080
    chdir = /home/debian/myapp 
    wsgi-file = myapp/wsgi.py
    processes = 4
    threads = 2

Y para ejecutar el servidor, simplemente:

    uwsgi ejemplo.ini

De esta forma puedo tener varios ficheros de configuración del servidor uwsgi para las distintas aplicaciones python que sirva el servidor.

Podemos tener los ficheros de configuración en `/etc/uwsgi/apps-available` y para habiliatar podemos crear un enlace simbólico a estos ficheros en `/etc/uwsgi/apps-enabled`.

En el ejemplo anterior hemos usado la opción `http` para indicar que se va a devolver una respuesta HTTP, podemos usar varias opciones:

* `http`: Se comporta como un servidor http.
* `http-socket`: Si vamos a utilizar un proxy inverso usando el servidor uwsgi.
* `socket`: La respuesta ofrecida por el servidor no es HTTP, es usando el protocolo uwsgi.

Existen muchas más opciones que puedes usar: [http://uwsgi-docs.readthedocs.io/en/latest/Options.html](http://uwsgi-docs.readthedocs.io/en/latest/Options.html).

## Apache con uwsgi

FALTA!!!!!!!!!!!!!!!!!!!!!!!