# Configuración de acceso a los servidores virtuales

## Configuración de los puertos de escucha

Para determinar los puertos de escucha del servidor web utilizamos la directiva [`Listen`](http://httpd.apache.org/docs/2.4/es/mod/mpm_common.html#listen) que podemos modificar en el archivo `/etc/apache2/ports.conf`.

## Como funciona en los Virtual Host

`Listen` solo le dice al servidor principal en qué direcciones y puertos tiene que escuchar. Si no se usan directivas `<VirtualHost>`, el servidor se comporta de la misma manera con todas las peticiones que se acepten. Sin embargo, `<VirtualHost>` puede usarse para especificar un comportamiento diferente en una o varias direcciones y puertos. Para implementar un host virtual, hay que indicarle primero al servidor que escuche en aquellas direcciones y puertos a usar. Posteriormente se debe crear un una sección `<VirtualHost>` en una dirección y puerto específicos para determinar el comportamiento de ese host virtual. 

## Ejemplos