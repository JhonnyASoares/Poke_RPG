<?php

namespace Core;

/**
 * Classe usada para definir constantes 
 */
abstract class Config
{
    /**
     * Define constante "URL" com o valor "http://pokemon.test/"
     * Define constante "CONTROLLER" com o valor "Home"
     *
     * @return void
     */
    protected function config(): void
    {
        define('URL', 'http://pokemon.test/');

        define('CONTROLLER', 'Home');


        //Constantes do banco de dados 

        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DBNAME', 'pokemon_rpg');
        //define('PORT', );

        define('EMAILADM', 'jhonny.mg35@gmail.com');
    }
}
