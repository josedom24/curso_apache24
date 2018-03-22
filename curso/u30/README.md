# Introducción al módulo mod_security2

[modSecurity](`https://www.modsecurity.org/`) es un firewall de aplicaciones Web que se ejecuta como módulo del servidor web Apache, provee protección contra diversos ataques hacia aplicaciones Web y permite monitorizar tráfico HTTP, así como realizar análisis en tiempo real sin necesidad de hacer cambios a la infraestructura existente.

## Instalación de modSecurity

Para instalar y activar el módulo ejecutamos:

	# apt-get install libapache2-mod-security2

Por defecto el módulo trae una configuración recomendado, para activarla le cambiamos el nombre:

	# cd /etc/modsecurity
	# mv modsecurity.conf-recommended modsecurity.conf

Cuando reiniciamos el servicio, se ha creado un nuevo fichero de log, donde `mod_security` va a guardar información detallada de las peticiones y respuestas para posibles auditorias: `/var/log/apache2/modsec_audit.log`.

Por defecto la configuración de modsecurity solo permite la detención de los ataques, pero no los evita. En el fichero de configuración `/etc/modsecurity/modsecurity.conf`, podemos encontrar:
	
	SecRuleEngine DetectionOnly

Podemos modificar otras directivas:

* `SecResponseBodyAccess`: Podemos desactivarla para evitar que se guarde el cuerpo de la respuesta.
* `SecRequestBodyLimit`: Podemos especificar el tamaño máximo de los datos POST.
* `SecRequestBodyNoFilesLimit`: De forma similar podemos indicar el tamaño de los datos POST menos el tamaño de los ficheros de subida. Este valor debe ser lo más pequeño posible (128K) (se supone que si no tenemos en cuenta los ficheros subidos los datos que se mandan por POST no deben ser muy grandes).
* `SecRequestBodyInMemoryLimit`: Indica el tamaño de RAM que se utiliza para cachear la petición. Variar este parámetro puede tener consecuencia en el rendimiento del servidor.

## Activando las reglas de detección

Por defecto tenemos un conjunto de reglas activadas, que llamamos CRS (*Core Rules Set*). Si nos fijamos en el fichero de configuración del módulo `/etc/apache2/mods-available/security2.conf`, ademas de indicar el directorio donde se va a guardar información (directiva `SecDataDir`), incluye el fichero donde están definida las CRS:

	IncludeOptional /usr/share/modsecurity-crs/owasp-crs.load

Las reglas se encuentran en el directorio `/usr/share/modsecurity-crs/rules`.

## Demostración: evitar un ataque SQL Injection

Tenemos preparado un [servidor LAMP](https://linuxconfig.org/how-to-install-a-lamp-server-on-debian-9-stretch-linux), donde hemos creado una tabla con usuarios y contraseñas:

	# mysql -u root -p
    mysql> create database sample;
    mysql> use sample;
    mysql> create table users(username VARCHAR(100),password VARCHAR(100));
    mysql> insert into users values('pepe','password');
    mysql> create user 'user'@'localhost';
	mysql> grant all privileges on sample.* to 'user'@'localhost' identified by 'password';
	mysql> flush privileges;

Y una aplicación PHP (`login.php`) que realiza la operación de 'login':

	<html>
	<body>
	<?php
	    if(isset($_POST['login']))
	    {
	        $username = $_POST['username'];
	        $password = $_POST['password'];
	        $con = mysqli_connect('localhost','user','password','sample');
	        $result = mysqli_query($con, "SELECT * FROM `users` WHERE username='$username' AND password='$password'");
	        if(mysqli_num_rows($result) == 0)
	            echo 'Invalid username or password';
	        else
	            echo '<h1>Logged in</h1><p>This is text that should only be displayed when logged in with valid credentials.</p>';
	    }
	    else
	    {
	?>
	        <form action="" method="post">
	            Username: <input type="text" name="username"/><br />
	            Password: <input type="password" name="password"/><br />
	            <input type="submit" name="login" value="Login"/>
	        </form>
	<?php
	    }
	?>
	</body>
	</html>

El programa parece que funciona correctamente, pero sin necesidad de poner contraseña, podemos acceder si introducimos como nombre de usuario la cadena:

	' or true -- 

Nota: Es importante señalar que la cadena termina en un espacio.

Si lo probamos y comprobamos el fichero de log de auditoria podemos encontrar que se ha detectado el ataque:

	Message: Warning. detected SQLi using libinjection with fingerprint 's&1' [file "/usr/share/modsecurity-crs/rules/REQUEST-942-APPLICATION-ATTACK-SQLI.conf"] ...

Como vemos la regla que detecta el *SQL injection* se encuentra definida en el fichero `/usr/share/modsecurity-crs/rules/REQUEST-942-APPLICATION-ATTACK-SQLI.conf`.

Para terminar podemos evitar que se produzca el ataque habilitando el módulo en el fichero de configuración `/etc/modsecurity/modsecurity.conf`:

	SecRuleEngine On
