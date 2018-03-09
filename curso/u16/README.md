# Autentificación básica

El servidor web Apache puede acompañarse de distintos módulos para proporcionar diferentes modelos de autenticación.
La primera forma que veremos es la más simple. Usamos para ello el módulo de autenticación básica que viene instalada "de serie" con cualquier Apache: [`mod_auth_basic`](http://httpd.apache.org/docs/2.4/es/mod/mod_auth_basic.html). La configuración que tenemos que añadir en el fichero de definición del Virtual Host a proteger podría ser algo así:

	<Directory "/var/www/pagina1/privado">
		AuthUserFile "/etc/apache2/claves/passwd.txt"
		AuthName "Palabra de paso"
		AuthType Basic
		Require valid-user
	</Directory>

El método de autentificación básica se indica en la directiva [AuthType](http://httpd.apache.org/docs/2.4/es/mod/core.html#authtype).  

* En `Directory` escribimos el directorio a proteger, que puede ser el raíz de nuestro Virtual Host o un subdirectorio.
* En [`AuthUserFile`](http://httpd.apache.org/docs/2.4/es/mod/mod_authn_file.html#authuserfile) ponemos el fichero que guardará la información de usuarios y contraseñas que debería de estar, como en este ejemplo, en un directorio que no sea visitable desde nuestro Apache. Ahora comentaremos la forma de generarlo. 
* Por último, en [`AuthName`](http://httpd.apache.org/docs/2.4/es/mod/core.html#authname) personalizamos el mensaje que aparecerá en la ventana del navegador que nos pedirá la contraseña.
* Para controlar el control de acceso, es decir, que usuarios tienen permiso para obtener el recurso utilizamos las siguientes directivas: [`AuthGroupFile`](http://httpd.apache.org/docs/2.4/es/mod/mod_authz_groupfile.html#authgroupfile), [`Require user`](http://httpd.apache.org/docs/2.4/es/mod/mod_authz_core.html#require), [`Require group`](http://httpd.apache.org/docs/2.4/es/mod/mod_authz_core.html#require).

El fichero de contraseñas se genera mediante la utilidad `htpasswd`. Su sintaxis es bien sencilla. Para añadir un nuevo usuario al fichero operamos así:

    $ htpasswd /etc/apache2/claves/passwd.txt carolina
    New password:
    Re-type new password:
    Adding password for user carolina

Para crear el fichero de contraseñas con la introducción del primer usuario tenemos que añadir la opción `-c` (create) al comando anterior. Si por error la seguimos usando al incorporar nuevos usuarios borraremos todos los anteriores, así que cuidado con esto. Las contraseñas, como podemos ver a continuación, no se guardan en claro. Lo que se almacena es el resultado de aplicar una [función hash](http://es.wikipedia.org/wiki/Hash):

    josemaria:rOUetcAKYaliE
    carolina:hmO6V4bM8KLdw
    alberto:9RjyKKYK.xyhk

Para denegar el acceso a algún usuario basta con que borremos la línea correspondiente al mismo. No es necesario que le pidamos a Apache que vuelva a leer su configuración cada vez que hagamos algún cambio en este fichero de contraseñas.

Si lo que se desea es permitir a un grupo de usuarios, necesitarás crear un archivo de grupo que asocie los nombres de grupos con el de usuario para permitirles el acceso. El formato de este fichero es bastante sencillo, y puedes crearlo con tu editor de texto favorito. El contenido del fichero se parecerá a:

    NombreGrupo: usuario1 usuario2 usuario3

La directiva que tendríamos que utiliazar para inidicar el fichero de grupo sería [`AuthGroupFile`](https://httpd.apache.org/docs/2.4/es/mod/mod_authz_groupfile.html#authgroupfile). Y para permitir el acceso a los grupos utilizaríamos:

    Require group NombreGrupo

La principal ventaja de este método es su sencillez. Sus inconvenientes: lo incómodo de delegar la generación de nuevos usuarios en alguien que no sea un administrador de sistemas o de hacer un front-end para que sea el propio usuario quien cambie su contraseña. Y, por supuesto, que dichas contraseñas viajan en claro a través de la red. Si queremos evitar esto último podemos configurtar Apache2 con SSL.

## Demostración

Autentificación básica al directorio `www.pagina1.org\privado`.

## Ejercicio

Realiza la auntenfificación básica de un directorio de un  virtual host que tengas en tu servidor. Crea varios usuarios que puedan acceder. A continuación crea un grupo de usuarios, y dale permiso de acceso a ese grupo (usando la directivas `AuthGroupFile` y `Require group`).