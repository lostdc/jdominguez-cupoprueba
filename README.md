
Prueba de busquedas y estadistica cuponatic
==================================

requisitos
------------
composer
nodejs
npm
use PHP 7.2
Mysql 15

instalación
-------------
*copiar el repositorio git en la carpeta de proyecto
*agregar los parametros de host,usuario,pass de base de datos en config/database.php
*instalamos dependencias javascript, npm install
*instalamos dependencias php composer install

Creación de base de datos y datos de prueba
--------------------------------------------

* podemos crear la base de datos las migraciones de laravel utilizando php artisan migration
o podemos utilizar el archivo dump_cupo.sql

* podemos generar datos de prueba crea 50 productos utilizando  php artisan db:seed
* tambien podemos ingresar un archivo csv en localhost/public/productos
* presionamos el boton cargar CSV y seleccionamos el archivo luego presionamos el boton Subir CSV luego de unos segundos se mostraran los datos en una lista

Modo de uso
--------------------------
* disponemos de un boton "borrar todos los productos y estadisticas" el cual eliminara todos los productos, estadisticas y actualizara la lista de productos
* tambien tenemos un seleccionador para mostrar la cantidad de registros mostrados por pagina
* al final de pa pagina la lista posee un paginador
* la lista dispone de un buscador el cual al presionar "enter" realiza la busqueda de la palabra en en los campos titulo,descripcion y tags
* al presionar enter en alguna busqueda se generan los registros para la estadistica
* al presionar el boton ver las estadisticas, veremos una lista con los productos mas buscados y las 5 palabras mas utilizadas con la cantidad de veces que fueron utilizadas.















se puede cambiar la configuracion del nombre y conexion de base de datos en 


una vez realizada la conexion puede utilizar la base de datos dump.sql

o tambien puede ejecutar las migraciones de laravel
con php artisan migrate, que creara todas las tablas de da base de datos

luego puede insertar datos de pruebas con el csv en la pagina de producto
o puede ejecutar los seeder que crearan la lista de productos 

php artisan db:seed


jdominguez/cupoprueba





Documentación

Webservice lista de productos

http://prueba-cuponatic.herokuapp.com/productos/listProductos
metodo Post

Parametros
search[value]: //Keyword valor de busqueda  
flagSearch:1   // 1 = indica que la busqueda fue ingresada por teclado enter buscador, 0 =  que fue por paginación
page:1         //numero de pagina de la busqueda

retorna la data en JSON



Webservice estadisticas
http://prueba-cuponatic.herokuapp.com 

metodo GET
No requiere parametros
retorna la data en JSON 
