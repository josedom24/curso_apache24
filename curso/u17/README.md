# Autentificación digest

La autentificación tipo digest soluciona el problema de la transferencia de contraseñas en claro sin necesidad de usar SSL.  Se aplica una función hash a la contraseña antes de ser enviada sobre la red, lo que resulta más seguro que enviarla en texto plano como en la autenticación básica. El procedimiento, como veréis, es muy similar al tipo básico pero cambiando algunas de las directivas y usando la utilidad `htdigest` en lugar de `htpassword` para crear el fichero de contraseñas. El módulo de autenticación necesario suele venir con Apache pero no habilitado por defecto. Para activarlo usamos la utilidad `a2enmod` y, a continuación reiniciamos el servidor Apache:

    a2enmod auth_digest
    systemctl restart apache2 

Luego incluimos una sección como esta en el fichero de configuración de nuestro Virtual Host:

	<Directory "/var/www/pagina1/privado">
		AuthType Digest
		AuthName "dominio"
		AuthUserFile "/etc/claves/digest.txt"
		Require valid-user
	</Directory>

Como vemos, es muy similar a la configuración necesaria en la autenticación básica. La directiva `AuthName`, que en la autenticación básica se usaba para mostrar un mensaje en la ventana que pide el usuario y contraseña, ahora se usa también para identificar un nombre de dominio (realm) que debe de coincidir con el que aparezca después en el fichero de contraseñas. Dicho esto, vamos a generar dicho fichero con la utilidad htdigest:

    $ htdigest -c /etc/claves/digest.txt dominio josemaria
    Adding password for josemaria in realm dominio.
    New password:
    Re-type new password:

Al igual que ocurría con `htpasswd`, la opción `-c` (create) sólo debemos de usarla al crear el fichero con el primer usuario. Luego añadiremos los restantes usuarios prescindiendo de ella. A continuación vemos el fichero que se genera después de añadir un segundo usuario:

    josemaria:dominio:8d6af4e11e38ee8b51bb775895e11e0f
    gemma:dominio:dbd98f4294e2a49f62a486ec070b9b8c

## Demostración

Autentificación digest al directorio `www.pagina2.org\privado`.

## Ejercicio

Crea dos subdirectorios en el host virtual `pagina1` que se llamen `grupo1` y `grupo2`. Crea varios usuarios con la utilidad `htdigest`, asignando a cada uno un dominio distinto (`domgrupo1` y `domgrupo2`). Configura los directorios para que al primero `grupo1` sólo puedan acceder los usuarios del dominio `domgrupo1`, y el directorio `grupo2` solo accedan los usuarios del dominio `domgrupo2`.