<?php

namespace Sts\Controllers;

class Nav
{
    private array $data;

    public function pokedexes()
    {
        $pokedexes = new \Sts\Models\StsPokedex();
        $this->data[] = $pokedexes->getPokedexes();
        return $this->data;
    }
}
