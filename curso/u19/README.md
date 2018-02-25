# Configuración de Apache mediante archivo .htaccess

Un fichero `.htaccess` (hypertext access), también conocido como archivo de configuración distribuida, es un fichero especial, popularizado por el Servidor HTTP Apache que nos permite definir diferentes directivas de configuración para cada directorio (con sus respectivos subdirectorios) sin necesidad de editar el archivo de configuración principal de Apache.

Para permitir el uso de los ficheros .htaccess o restringir las directivas que se puedn aplicar usamos ela directiva [`AllowOverride`](http://httpd.apache.org/docs/2.4/mod/core.html#allowoverride), que puede ir acompañada de una o varias opciones: 

* `All`: Se pueden usar todas las directivas permitidas.
* `None`: Se ignora el fichero `.htaccess`. Valor por defecto.
* `AuthConfig`: Directivas de autentificación y autorización: `AuthName`, `AuthType`, `AuthUserFile`, `Require`, ...
* `FileInfo`: Directivas relacionadas con el mapeo de URL: redirecciones, módulo rewrite, ...
* `Indexes`: Directiva que controlan la visualización de listado de ficheros.
* `Limit`: Directivas para controlar el control de acceso: `Allow`, `Deny` y `Order`.


## Ejercicios

Mediante el uso de un fichero `.htaccess`:

* Deshabilitar la opción de listar los ficheros en ese directorio.
* Protege tu directorio y ficheros con autentificación básica.
* Hacer que los ficheros txt no sean accesibles.
* Crear una lista de IPs prohibidas

