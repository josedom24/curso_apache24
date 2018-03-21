# Módulo userdir

En sistemas con múltiples usuarios, cada usuario puede tener un sitio web en su directorio *home* usando el módulo `UserDir`. Los visitantes de una URL `http://example.com/~username/` recibirán el contenido del directorio home del usuario "username", en el subdirectorio especificado por la directiva `UserDir`.

La directiva [`UserDir`](https://httpd.apache.org/docs/2.4/es/mod/mod_userdir.html#userdir) la podemos modificar en el fichero `/etc/apache2/mods-available/userdir.conf`, y se puede configurar de distintas maneras:

* `UserDir public_html`: Valor por defecto, la URL `http://example.com/~rbowen/file.html` se traducirá en la ruta del fichero `/home/rbowen/public_html/file.html`.
* `UserDir /var/html`: La URL `http://example.com/~rbowen/file.html` se traducirá en la ruta del fichero `/var/html/rbowen/file.html`.
* `UserDir /var/www/*/docs`: La URL `http://example.com/~rbowen/file.html` se traducirá en la ruta del fichero `/var/www/rbowen/docs/file.html`
* `UserDir public_html /var/html`: Para la URL `http://example.com/~rbowen/file.html`, Apache buscará `~rbowen`. Si no lo encuentra, Apache buscará rbowen en `/var/html`.

## Desactivando userdir para algunos usuarios

Por ejemplo, con la directiva `UserDir disabled root` desactivamos la funcionalidad que ofrece el módulo para el usuario root.

## Configurando el directorio de acceso de cada usuario

Como vemos en el fichero `/etc/apache2/mods-available/userdir.conf` debemos configurar las opciones del directorio al que se accede al pedir la página del usuario.

	<Directory /home/*/public_html>
        AllowOverride FileInfo AuthConfig Limit Indexes
        Options MultiViews Indexes SymLinksIfOwnerMatch IncludesNoExec
        Require method GET POST OPTIONS
    </Directory>


## Activación del módulo

Para activar el módulo:

	# a2enmod userdir

Reiniciamos el servidor, creamos una carpeta `public_html` en el home del usuario y creamos un fichero `index.html`. Y podemos probar el acceso a la URL `http://www.pagina1.org/~usuario`.