# Obtener un certificado en CAcert

Aunque en los últimos tiempos se está poniendo de moda [Let's Encrypt](https://letsencrypt.org/), que es una autoridad de certificación que proporciona certificados X.509 gratuitos para el cifrado de Seguridad de nivel de transporte (TLS), la utilización de un cliente llamado [Certbot](https://certbot.eff.org/) que automatiza todo el ciclo de vida de la gestión de certificados: obtención, renovación, revocación, instalación en el servidor web,... nos dificulta estudiar en profundidad el proceso de gestionar nuestro propios certificados.

Por lo tanto vamos a usar la CA llamada CAcert que nos permite realizar un proceso similar al que debemos hacer si gestionamos nuestros certificados con cualquier CA comercial. 

El lema de [CAcert](http://www.CAcert.org/) es *Free digital certificates for everyone* y es que la utilización de certificados emitidos por CA comerciales no es posible para todos los sitios de Internet debido a su coste, lo que los limita su uso a transacciones económicas o sitios con datos relevantes. CAcert es una organización sin ánimo de lucro que mantiene una infraestructura equivalente a una CA comercial aunque con ciertas limitaciones.

Los pasos que hay que dar para utilizar un certificado X.509 emitido por CAcert son los siguientes:

* Darse de alta como usuario en el sitio web.
* Dar de alta el dominio para el que queremos obtener el certificado. (opción **Domains -> Add**)
* CAcert verifica que podemos hacer uso legítimo del dominio enviando un mensaje de correo electrónico.
* Dar de alta el certificado de un servidor mediante una solicitud de firma certificado (CSR).
* Configurar el servidor web con el certificado X.509 emitido por la CA.

## Instalación del certificado raíz de CAcert

Una limitación que tiene el uso de este CA, es que su certificado raíz no está instalado por defecto en los navegadores, por lo tanto tenemos que instalarlo manualmente. Para ello, simplemente vamos a la página web de CAcert y en la opción **Certificado raíz** podemos descargar la versión **Certificado Raíz (Formato PEM)**. A continuación marcamos la opción: *Confiar en esta CA para identificar sitios web* y ya la tenemos instalada.

Este proceso nos puede ayudar a entender la circunstancia de que una empresa tenga su propia CA para gestionar sus propios certificados y ,por ejemplo, sus empleados tengan que instalar el certificado raíz de una forma similar.
 
## Creación del CSR

CSR son las siglas de *Certificate Signing Request* o solicitud de firma de certificado. En primer lugar necesitamos generar una clave privada RSA de 4096 bits mediante la instrucción:

	  # openssl genrsa 4096 > /etc/ssl/private/ssl-cert.key

Modificamos de forma apropiada los propietarios y permisos:

	# chown root:ssl-cert /etc/ssl/private/ssl-cert.key
	# chmod 640 /etc/ssl/private/ssl-cert.key

Utilizando la clave privada, generamos una CSR mediante la instrucción:

	# openssl req -new -key /etc/ssl/private/ssl-cert.key -out /etc/ssl/private/midominio.csr

El CSR contiene información que será incluida finalmente en el certificado SSL, como por ejemplo tu nombre o el de al empresa, la dirección, el país de residencia o el *common name* (dominio para el que es generado el SSL), además de estos datos también incluirá un clave pública que será incluida también en tu certificado.


Este fichero csr es el que enviamos a la CA a través del formulario web (opción **Server Certificates -> New**), que lo procesa y obtiene a partir de él un certificado X.509 compatible con nuestra clave privada, pero emitido por la CA. 

El certificado que descargamos lo guardamos en el fichero `/etc/ssl/certs/midominio-cacert.pem`.
