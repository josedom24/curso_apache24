# Ejercicios: mod_security

Hay que instalar mysql

	apt install mysql php7.0-mysql

	mysql_secure_installation
	create database sample;
	use sample;
	create table users(username VARCHAR(100),password VARCHAR(100));
	insert into users values('pepe','password');
	CREATE USER 'user'@'localhost';
	GRANT ALL PRIVILEGES ON sample.* To 'user'@'localhost' IDENTIFIED BY 'password';
	flush priveleges;

Activamos mod_security

	apt-get install libapache2-mod-security2

Por defecto el módulo trae una configuración recomendado, para activarla le cambiamos el nombre:

	# cd /etc/modsecurity
	# mv modsecurity.conf-recommended modsecurity.conf

Fichero auditorias: `/var/log/apache2/modsec_audit.log`.

En `/etc/modsecurity/modsecurity.conf`, podemos encontrar:
	
	SecRuleEngine DetectionOnly

Activando las reglas de detección

Por defecto tenemos un conjunto de reglas activadas, que llamamos CRS (*Core Rules Set*). Si nos fijamos en el fichero de configuración del módulo `/etc/apache2/mods-available/security.conf`, ademas de indicar el directorio donde se va a guardar información (directiva `SecDataDir`), incluye el fichero donde están definida las CRS:

	IncludeOptional /usr/share/modsecurity-crs/owasp-crs.load

Las reglas se encuentran en el directorio `/usr/share/modsecurity-crs/rules`.


