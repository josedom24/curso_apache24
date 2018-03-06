# Configuración de Virtual Hosting

Vamos a realizar un ejercicio para mostrar como podemos configurar distintos sitios virtuales en Apache 2.4 (basados en nombre). El objetivo es la puesta en marcha de dos sitios web utilizando el mismo servidor web apache. Hay que tener en cuenta lo siguiente:

* Cada sitio web tendrá nombres distintos.
* Cada sitio web compartirán la misma dirección IP y el mismo puerto (80).

Queremos construir en nuestro servidor web apache dos sitios web con las siguientes características:

* El nombre de dominio del primero será `www.pagina1.org`, su directorio base será `/var/www/pagina1` y contendrá una página llamada `index.html`, donde se verá un mensaje de bienvenida.
* El nombre de dominio del primero será `www.pagina2.org`, su directorio base será `/var/www/pagina2` y contendrá una página llamada `index.html`, donde se verá un mensaje de bienvenida.

Para conseguir estos dos sitios virtuales debes seguir los siguientes pasos:

1. Los ficheros de configuración de los sitios webs se encuentran en el directorio `/etc/apache2/sites-available`, por defecto hay dos ficheros, uno se llama `000-default.conf` que es la configuración del sitio web por defecto. Necesitamos dos nuevos ficheros para realizar la configuración de los dos sitios virtuales, para ello vamos a copiar el fichero `000-default.conf` a los dos nuevos ficheros:

		cd /etc/apache2/sites-available
		cp 000-default.conf pagina1.conf
		cp 000-default.conf pagina2.conf

	De esta manera tendremos un fichero llamado `pagina1.conf` para realizar la configuración del sitio web `www.pagina1.org`, y otro llamado `pagina2.conf` para el sitio web `www.pagina2.org`.

2. Modificamos los ficheros `pagina1.conf` y `pagina2.conf`, para indicar el nombre que vamos a usar para acceder al host virtual (`ServerName`) y el directorio  de trabajo (`DocumentRoot`). También podríamos cambiar el nombre del fichero donde se guarda los logs.
3. No es suficiente crear los ficheros de configuración de cada sitio web, es necesario crear un enlace simbólico a estos ficheros dentro del directorio `/etc/apache2/sites-enabled`, para ello:

        a2ensite pagina1
        a2ensite pagina2

	La creación de los enlaces simbólicos se puede hacer con la instrucción `a2ensite nombre_fichero_configuracion`, para deshabilitar el sitio tenemos que borrar el enlace simbólico o usar la instrucción `a2dissite nombre_fichero_configuracion`.

4. Creamos los directorios y los ficheros `index.html` necesarios en `/var/www` y reiniciamos el servicio. Recuerda que los ficheros servidos deben ser propiedad del usuario y grupo que usa Apache, es decir usuario `www-data` y grupo `www-data`.

		# chown -R www-data:www-data /var/www/pagina1
		# chown -R www-data:www-data /var/www/pagina2

5. Para terminar lo único que tendremos que hacer es cambiar el fichero hosts en los clientes y poner dos nuevas líneas donde se haga la conversión entre los dos nombre de dominio y la dirección IP del servidor.

## Ejemplo

Vamos a crear dos virtual host en nuestro servidor remoto. Vamos a probar que pasa si accedemos al servidor con la IP. Es interesante dejar el virtual host por defecto aunque no muestre ninguna información.

## Ejercicio

Repite el ejercicio cambiando los directorios de trabajo a `/srv/www`. ¿Qué modificación debes hacer en el fichero `/etc/apache2/apache2.conf`?
