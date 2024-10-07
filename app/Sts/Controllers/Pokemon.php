<?php

namespace Sts\Controllers;

class Pokemon
{
    private array|string|null $data = null;
    public function index()
    {
        $pokemons = new \Sts\Models\StsPokemon();
        $this->data = $pokemons->pokemonAllData();
        echo '<pre>';
        var_dump($this->data);
        $loadView = new \Core\ConfigView("Sts/Views/Pokemon", $this->data);
        $loadView->loadView();
    }
}
