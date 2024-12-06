<?php

namespace Sts\Controllers;

class Pokedex
{
    private array|string|null $data = null;
    public function index()
    {
        $pokedex = new \Sts\Models\StsPokedex();
        if (isset($_GET['pdx'])) {
            $pg = $_GET['pg'] ?? 1;
            $offset = 0;
            while ((($offset / 20) + 1) < $pg) {
                $offset += 20;
            }

            $this->data['pokedex_name'] = $pokedex->getPokedexName($_GET['pdx'])[0]['name'];
            $this->data['pgs'] = ceil($pokedex->pokedexCount($_GET['pdx'])['count'] / 20);
            $this->loadTypes($pokedex->getPokedexPkms($_GET['pdx'], $offset));
        } else {
            $this->data['pokemons'] = $pokedex->getPokedexPkms(1);
        }
        $loadView = new \Core\ConfigView("Sts/Views/Pokedex", $this->data);
        $loadView->loadView();
    }
    private function loadTypes($pokemonsArray): void
    {
        $getTypes = new \Sts\Models\StsPokemon();
        foreach ($pokemonsArray as $pokemon) {
            $pokemon['types'] = $getTypes->pokemonTypes($pokemon['id']);
            $this->data['pokemons'][] = $pokemon;
        }
    }
}
