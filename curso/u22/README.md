# Creación de un servidor WebDAV

**WebDAV** ("*Edición y versionado distribuidos sobre la web*") es un protocolo para hacer que la www sea un medio legible y editable. Este protocolo proporciona funcionalidades para crear, cambiar y mover documentos en un servidor remoto (típicamente un servidor web). Esto se utiliza sobre todo para permitir la edición de los documentos que sirve un servidor web, pero puede también aplicarse a sistemas de almacenamiento generales basados en web, que pueden ser accedidos desde cualquier lugar. La mayoría de los sistemas operativos modernos proporcionan soporte para WebDAV, haciendo que los ficheros de un servidor WebDAV aparezcan como almacenados en un directorio local.

## Configuración de un servidor WebDAV

Para crear un directorio en nuestro servidor Web que pueda ser accesible por medio de un cliente WebDAV debemos activar los módulos `dav` y `dav_fs`.

    # a2enmod dav dav_fs

Lo primero es indicar el nombre de la base de datos de lock que se utilizará, mediante la directiva `DAVLockDB`. Es importante tener especial cuidado con esta directiva, ya que es frecuente fuente de errores.

    DavLockDB /tmp/DAVLockDB

Lo que indica la directiva no es ni el nombre de un archivo ni el de una carpeta, si no la parte inicial del nombre de un archivo. El módulo creará un archivo de nombre `DAVLockDB.orig` y otro de nombre `DAVLockDB.xxxxx` dentro de la carpeta indicada, para lo cual es necesario que el usuario *"Apache"* tenga permisos de escritura en ella.

A continuación creamos una sección `Directory` para el directorio que queremos acceder por WebDav y activar el modo WebDav con la directiva `dav on`. Además por seguridad se debe autentificar el acceso, por lo que quedaría parecido a esto:

        DavLockDB /tmp/DavLock
        <Directory /var/www/webdav>
                dav on
                Options Indexes FollowSymLinks MultiViews
                AllowOverride None
                AuthType digest
                AuthUserFile "/etc/apache2/digest.txt"
                AuthName "Dominio"
                Require valid-user
        </Directory>

Por último podemos comprobar el acceso al servidor WebDAV con un cliente.
