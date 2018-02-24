# Obtener un certificado en Letsˋs Encrypt

[Let's Encrypt](https://letsencrypt.org/) es una autoridad de certificación que proporciona certificados X.509 gratuitos para el cifrado de Seguridad de nivel de transporte (TLS). Está siendo desarrollado por el Internet Security Research Group, un grupo de entidades sin ánimo de lucro, que tienen como objetivo hacer más fácil la obtención de certificados para realizar conexiones seguras con el protocolo HTTPS. Sólo se emiten certificados de dominio validado, no se ofrecerán la validación de organizaciones certificados de validación extendida.

Una de las principales caracterśiticas de Let Encrypt es la posibilidad de usar un cliente llamado [Certbot](https://certbot.eff.org/) que automatiza todo el ciclo de vida de la gestión de certificados: obtención, renovación, revocación, intalación en el servidor web,...

Evidentemente esto es muy cómodo pero evita conocer los pasos que normalmente se realizan para la obtención de un certificado en cualquier CA. Por esta razón nosotros vamos a utilizar el servicio [ZeroSSL](https://zerossl.com/) para obtener "manualmente" un certificado de Let Encrypt.

## Utilizando ZeroSSL para conseguir un certificado Let's Encrypt

Gracias a ZeroSSL, vamos a poder conseguir un certificado SSL de Let’s Encrypt, y  a través de un sencillo asistente. Los pasos que vamos a seguri son los siguientes:

* Poseer un dominio para el que queremos obtener el certificado. Para verificar que somos propietarios del mismo vamos a tener que realizar una de estas dos acciones:
	* Verificación de DNS: deberemos crear un registro DNS específico de tipo TXT para el dominio.
    * Verificación HTTP: requiere la creación de un archivo de texto sin formato, con un contenido específico en el servidor web.
* Dar de alta el certificado de un servidor mediante una solicitud de firma certificado (CSR).
* Configurar el servidor web con el certificado X.509 emitido por la CA.

## Creación del CSR

CSR son las siglas de Certificate Signing Request o solicitud de firma de certificado. En primer lugar necesitamos generar una clave privada RSA de 4096 bits mediante la instrucción:

	  # openssl genrsa 4096 > /etc/ssl/private/ssl-cert.key

Modificamos de forma apropiada los propietarios y permisos:

	# chown root:ssl-cert /etc/ssl/private/ssl-cert.key
	# chmod 640 /etc/ssl/private/ssl-cert.key

Utilizando la clave privada, generamos una CSR mediante la instrucción:

