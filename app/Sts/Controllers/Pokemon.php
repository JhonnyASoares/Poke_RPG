<?php

namespace Sts\Controllers;

class Pokemon
{
    private array|string|null $data = null;
    private array $evChain = [];
    private object $pokemon;

    public function __construct()
    {
        $this->pokemon = new \Sts\Models\StsPokemon();
    }
    public function index()
    {
        $pkm = $_GET['name'];

        $pkmFullData = $this->pokemon->pokemonsData($pkm);
        //print_r($pkmFullData);
        foreach ($pkmFullData as $pkmData) {
            $this->makeEvChain($pkmData['id']);
            $pkmData['evolution_chain'] = $this->makeEvChain($pkmData['id']);
            $pkmData['types'] = $this->pokemon->pokemonTypes($pkmData['id']);
            $pkmData['abilities'] = $this->pokemon->pokemonAbilities($pkmData['id']);
            $pkmData['images'] = $this->pokemon->pokemonImgs($pkmData['id'])[0];
            //$pkmData['gifs'] = $ths>pokemon->pokemonGifs($pkmData['id'])[0];
            $pkmData['species'] = $this->pokemon->pokemonSpecies($pkmData['id'])[0];
            $pkmData['moves'] = $this->pokemon->pokemonMoves($pkmData['id']);
            $this->data[] = $pkmData;
        }
        $loadView = new \Core\ConfigView("Sts/Views/Pokemon", $this->data[0]);
        $loadView->loadView();
    }
    public function makeEvChain($pkmId)
    {
        $evChain = $this->pokemon->pokemonEvolution($pkmId);
        if (count($evChain) > 0) {
            foreach ($evChain as &$ev) {
                $ev['evolves_to'] = $this->makeEvChain($ev['id']);
            }
            return $evChain;
        }
    }
}
