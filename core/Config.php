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
        define('URL', 'http://pokerpg.shop//');
        // 
        define('URLCSS', '/app/Sts/Assets/Css/');
        define('URLJS', '/app/Sts/Assets/Js/');

        define('CONTROLLER', 'Home');


        //Constantes do banco de dados 

        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DBNAME', 'pokemon_rpg');
        define('PORT', 3306);

        define('EMAILADM', 'jhonny.mg35@gmail.com');
    }
}
