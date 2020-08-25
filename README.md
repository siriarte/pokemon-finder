## Pokemon Finder

Pokemon Finder es una aplicación desarrollada en Laravel 7, que permite buscar Pokemones a por nombre parcial utilizando la [PokeApi](https://pokeapi.co)

Actualmente lista de cada pokemon encontrado:
-Imagen
-Nombre
-Tipos

## Instalación

Clonar el respositorio e instalar las dependencias.

    $ git clone https://github.com/siriarte/pokemon-finder && cd pokemon-finder
    $ composer install


Instalar node y npm siguiendo alguna de las siguientes técnicas: [link](https://gist.github.com/isaacs/579814) para crear y compilar los assets de la aplicación.	

    $ npm install
    $ npm run production

Por ultimo inicie el servidor

    $ php artisan serve

Abra [http://localhost:8000/create-pokemons-name-db](http://localhost:8000/create-pokemons-name-db) en su nagevador para crear la base de nombres de Pokemons.
Recibirá un mensaje de éxito con la cantidad de pokemons registrados.

Luego abra [http://localhost:8000/](http://localhost:8000/) para utilizar la aplicación.


