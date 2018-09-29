# Redirecciones

La directiva [`redirect`](https://httpd.apache.org/docs/2.4/mod/mod_alias.html#redirect) es usada para pedir al cliente que haga otra petición a una URL diferente. Normalmente la usamos cuando el recurso al que queremos acceder ha cambiado de localización.

Podemos crear redirecciones de dos tipos:

* **Permanentes**: se da cuando el recurso sobre el que se hace la petición ha sido ‘movido permanentemente‘ hacia una dirección distinta, es decir, hacia otra URL. Se devuelve el código de estado 301. Es la que debemos realizar cuando queremos cambiar la URL de un recurso para que los buscadores, por ejemplo cuando cambiamos de dominio, sigan guardando la posición que tenía nuestra página.
* **Temporales**: se da cuando el recurso  sobre el que se hace la petición ha sido "encontrado" pero reside temporalmente en una dirección distinta, es decir, en otra URL. Se devuelve un código de estado 302. Es la opción por defecto.

## Ejemplos de redirecciones temporales

	Redirect "/service" "http://www.pagina.com/service"
	Redirect "/one" "/two"

Como vemos podemos hacer redirecciones a URL de otro servidor o del mismo servidor.

## Ejemplos de redirecciones permanentes

	Redirect permanent "/one" "http://www.pagina2.com/two"
	Redirect 301 "/otro" "/otra"

De forma similar a `AliasMatch`, podemos usar la directiva [`RedirectMatch`](https://httpd.apache.org/docs/2.4/mod/mod_alias.html#redirectmatch) para poder usar expresiones regulares para determinar la URL origen. Por ejemplo:

	RedirectMatch "(.*)\.gif$" "http://www.pagina2.org/$1.jpg"

## Ejercicios 

Cuando se entre a la dirección `www.pagina1.org` se redireccionará automáticamente a `www.pagina1.org/principal`, donde se mostrará una página html con un mensaje de bienvenida. 