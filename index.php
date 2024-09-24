<?php


//Constante que define que o usuario esta acessando paginas internas atraves da pagina "index.php".
define('P0K3M4RP5G', true);


//Carregar o Composer
require './vendor/autoload.php';

//Instanciar a classe ConfigController, responsável em tratar a URL
$url = new Core\ConfigController();

//Instanciar o método para carregar a página/controller
$url->loadPage();
