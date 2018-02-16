# Uso de módulos en Apache 2.4

Uno de los aspectos característicos del servidor HTTP Apache es su modularidad, Apache tiene un sinfín de características adicionales que si estuvieran siempre incluidas, harían de él un programa demasiado grande y pesado. En lugar de esto, Apache se compila de forma modular y se cargan en memoria sólo los módulos necesarios en cada caso.

Los módulos de sugardan en la configuración de apache2 en dos directorios:

* `/etc/apache2/mods-available/`: Directorio que contiene los módulos disponibles en la instalación actual.
* `/etc/apache2/mods-enabled/`: Directorio que incluye mediante enlaces simbólicos al directorio anterior, los módulos que se van a cargar en memoria la próxima vez que se inicie Apache.

	

Poner módulos cargados
 (módulos activos por defecto: dir)