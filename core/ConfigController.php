<?php

namespace Core;

/**
 * Recebe e manipula a URL
 * Carregar a Controller
 * 
 * @author Jhonny
 */
class ConfigController extends Config
{
    /** @var [string] $url Recebe a URL do .htaccess*/
    private $url;
    /** @var [array] $urlArray Recebe a URL convertida para array*/
    private $urlArray; //array
    /** @var [string] $urlController Recebe a URL final pra pagina que deve ser carregada*/
    private $urlController;
    /** @var [string] $urlSlugController Recebe a URL com apenas as primeiras letras de cada palavra em maiusculo*/
    private $urlSlugController;
    /** @var [array] $format Recebe caracteres especiais e por quais caracteres eles devem ser substituidos*/
    private $format; //array

    /**
     * Recebe a URL do .htaccess
     * Valida a URL
     * 
     */
    public function __construct()
    {
        $this->config();
        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

            $this->clearURL();

            $this->urlArray = explode("/", $this->url); //separa o conteudo da URL pelas barras

            if (isset($this->urlArray[0])) {
                $this->urlController = $this->slugController($this->urlArray[0]);
            } else {
                $this->urlController = CONTROLLER;
            }
        } else {
            $this->urlController = CONTROLLER;
        }
    }

    /**
     * Limpa a URL, eleminando as tags, espaços em branco, barra final da URL e substitui caractes especiais.
     *
     * @return void
     */
    private function clearURL(): void
    {
        //Eliminar as tags da url
        $this->url = strip_tags($this->url);
        //Eliminar espaço em pranco da url
        $this->url = trim($this->url);
        //Eliminar a barra final da url
        $this->url = rtrim($this->url, "/");
        //Substituir caracteres
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-------------------------------------------------------------------------------------------------';
        $this->url = strtr(utf8_decode($this->url), utf8_decode($this->format['a']), $this->format['b']);
    }

    /**
     * Converter o valor obtido da URL "home-controller" para o formato da classe "HomeController".
     * Utilizando funções para converter tudo para minusculo, converter traco em espaco em branco, 
     * converter cada letra da primeira palavra em maiusculo e retirar espaco em branco.
     * 
     * @param string $slugController Nome da classe
     * @return string Retorna a controller "home-controller" convertido para o nome da classe "HomeController".
     */
    private function slugController($slugController): string
    {
        //Convertendo tudo para minusculo 
        $this->urlSlugController = strtolower($slugController);
        //Convertendo traco em espaco em branco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        //Convertendo cada letra da primeira palavra em maiusculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        //Retirar espaço em braco
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);
        return $this->urlSlugController;
    }


    /**
     * Carregar as Controllers.
     * Instanciar as classes da Controller e carregar o método index.
     *
     * @return void
     */
    public function loadPage(): void
    {
        //$urlCtl = $this->urlController;
        //if (strpos($urlCtl, "controller") !== false or strpos($urlCtl, "Controller") !== false) {
        //    str_replace("controller", "Controller", $urlCtl);
        //    $classLoad = "\\Sts\\Controllers\\" . $urlCtl;
        //} else {
        //    $classLoad = "\\Sts\\Controllers\\" . $urlCtl . "Controller";
        //}

        $classLoad = "\\Sts\\Controllers\\" . $this->urlController;
        $classPage = new $classLoad();
        $classPage->index();
    }
}
