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
        define('URL', 'https://pokerpg.shop/'); // adicionar URL do site
        // 
        define('URLCSS', '/app/Sts/Assets/Css/');
        define('URLJS', '/app/Sts/Assets/Js/');

        define('CONTROLLER', 'Home');


        //Constantes do banco de dados 

        define('HOST', 'localhost'); // adicionar host do banco de dados
        define('USER', 'root'); // adicionar usuário do banco de dados
        define('PASS', ''); // adicionar senha do banco de dados
        define('DBNAME', 'teste'); // adicionar nome do banco de dados
        define('PORT', 3306); // adicionar porta do banco de dados

        define('EMAILADM', 'jhonny.mg35@gmail.com');
    }
}
