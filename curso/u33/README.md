# Analizador de logs: awstats

[AWStats](http://www.awstats.org/) es una herramienta open source analizar datos de acceso a un servidor web y genera informes HTML. Los datos son presentados visualmente en informes de tablas y gráficos de barra. Pueden crearse informes estáticos mediante una interfaz de línea de comando, y se pueden obtener informes a través de un navegador web, gracias a un programa CGI.

Vamos a instalar y configurar awstats para mostrar los datos estadísticos del virtual host `www.pagina1.org`. Para cualquier otro virtual host los pasos de configuración serían similares.

## Preparación del virtual host

Si queremos que awstats lea los acceso a cada virtual host por separado tenemos que tener que guardar los accesos en ficheros separados para cad virtual host, por la tanto en el fichero `/etc/apache2/sites-availables/pagina1.conf`:

	...
	CustomLog ${APACHE_LOG_DIR}/access_pagina1.log combined
	...

## Instalación de awstats

Para realizar la instalación de awstats:

	# apt-get install awstats

Vamos a crear la configuración de apache para el acceso al script CGI `awstats.pl` en el fichero `/etc/apache2/conf-available/awstats.conf`:

	ScriptAlias /awstats/ /usr/lib/cgi-bin/
	Alias /awstats-icon/ /usr/share/awstats/icon/
	Alias /awstatsclasses/ /usr/share/java/awstats/

	<Directory "/usr/lib/cgi-bin/">
    	Options None
    	AllowOverride None
	</Directory>

Para finalizar la instalación activamos la configuración el módulo `cgi`:

	# a2enmod cgi
	# a2enconf awstats

Y reinciamos el servidor.

## Configuración de awstats

Ahora tenemos que crear un fichero de configuración de awstats para cada virtual host, para ello:

	# cd /etc/awstats
	# cp awstats.conf awstats.www.pagina1.org.conf

Editamos el fichero (tenemos muchos parámetros) pero es suficiente indicar los siguientes:

	LogFile="/var/log/apache2/access_pagina1.log"
	SiteDomain="www.pagina1.org" 

## Generamos los informes 

Para generar los datos que se van a mostrar en el informe, ejecutamos:

	/usr/lib/cgi-bin/awstats.pl -config=www.pagina1.org -update

Es conveniente añadir una tarea programa para que se generen los informes cada cierto tiempo, por ejemplo cada hora:

	# crontab -e

	0 * * * * /usr/lib/cgi-bin/awstats.pl -config=www.pagina1.org -update

Para visualizar el informe en el navegado accedemos a la siguiente URL:

	http://www.pagina1.org/awstats/awstats.pl?config=www.pagina1.org