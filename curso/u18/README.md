# Implementación de políticas de autentificación y acceso

## Políticas de acceso en Apache 2.2

Como hemos visto anteriormente el control de acceso en versiones anteriores de Apache2, se hacía con las directivas `Order`, `Allow` y `Deny`. Además teníamos otra directiva [`Satisfy`](http://httpd.apache.org/docs/2.2/mod/core.html#satisfy) (**Nota: Esta directiva no existe en Apache 2.4**) que nos permitía controlar como el se debía comportar el servidor cuando tenemos varios instrucciones de control de acceso (`allow`, `deny` , `require`). de esta manera:

* `Satisfy All`: Se tenían que cumplir todas las condiciones para obtener el acceso.
* `Satisfy Any`: Bastaba con que se cumpliera una de las condiciones.

Ejemplo:

	<Directory /dashboard>
		Order deny,allow
		Deny from all
		Allow from 10.1
		Require group admins
		Satisfy any
	</Directory>	

El uso de esas directiva hacía muy complicado hacer políticas de acceso complejas.

## Políticas de acceso en Apache 2.4

En la nueva versión el control de acceso se determinan con la directiva `Require`, y las políticas de acceso la podemos indicar usando las directivas:

* [`RequireAll`](https://httpd.apache.org/docs/2.4/es/mod/mod_authz_core.html#requireall): Todas las condiciones dentro del bloque se deben cumplir para obtener el acceso.
* [`RequireAny`](https://httpd.apache.org/docs/2.4/es/mod/mod_authz_core.html#requireany): Al menos una de las condiciones en el bloque se debe cumplir.
* [`RequireNone`](https://httpd.apache.org/docs/2.4/es/mod/mod_authz_core.html#requirenone): Ninguna de las condiciones se deben cumplir para permitir el acceso.

El ejemplo anterior quedaría:

	<Directory /dashboard>
		<RequireAny>
			Require ip 10.1
			Require group admins
		</RequireAny>
	</Directory>	

## Ejemplo

En Apache 2.2 podríamos tener:

	Order Allow,Deny
	Allow from all
	Deny from 212.100.100.100

En Apache 2.4 lo podríamos indicar de dos formas distintas:

	<RequireNone>
		Require ip 212.100.100.100
	</RequireNone>

O también:

	<RequireAll>
		Require all granted
		Require not ip 212.100.100.100
	</RequireAll>

## Ejemplo complejo

Podemos crear varios bloques como vemos en el siguiente ejemplo:

	<RequireAny>
	    <RequireAll>
	        Require user root
	        Require ip 123.123.123.123
	    </RequireAll>
	    <RequireAll>
	        <RequireAny>
	            Require group sysadmins
	            Require group useraccounts
	            Require user anthony
	        </RequireAny>
	        <RequireNone>
	            Require group restrictedadmin
	            Require host bad.host.com
	        </RequireNone>
	    </RequireAll>
	</RequireAny>

## Demostración

Tenemos un recurso que para acceder tenemos que autentificarnos, además a ese recurso sólo puedo acceder desde la red interna. Puede implementar dos políticas: 

* Se deben cumplir las dos: el recurso sólo es accesible desde la red interna y habiéndonos autentificados.
* Se debe cumplir una de las dos: el recurso es accesible de la red interna, sin necesidad de autentificarnos, y es accesible desde la red externa pero nos debemos autentificar.