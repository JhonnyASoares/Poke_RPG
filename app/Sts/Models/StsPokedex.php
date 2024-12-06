<?php

namespace Sts\Models;

class StsPokedex
{
    private object $reader;

    public function __construct()
    {
        $this->reader = new \Sts\Models\Helper\StsRead();
    }

    public function getPokedexes()
    {
        $this->reader->fullRead("SELECT id, name FROM `pokedexes`");
        return $this->reader->getResult();
    }

    public function getPokedexPkms($id, $offset = 0)
    {
        $this->reader->fullRead("SELECT pkdx_link.entry_number, pkm.id, pkm.name, pk_img.front_default
                                FROM `pokedexes` AS pkdx 
                                INNER JOIN pokedexes_pokemons_link AS pkdx_link ON pkdx.id = pkdx_link.pokedex_id
                                INNER JOIN pokemons AS pkm ON pkdx_link.pokemon_id = pkm.id
                                INNER JOIN pokemons_imgs AS pk_img ON pkm.id = pk_img.pokemon_id
                                WHERE pkdx.id = :id
                                LIMIT 20
                                OFFSET :offset", "id={$id} &offset={$offset}");
        return $this->reader->getResult();
    }
    public function getPokedexName($id)
    {
        $this->reader->fullRead("SELECT `name` FROM `pokedexes` WHERE id = :id", "id={$id}");
        return $this->reader->getResult();
    }
    public function pokedexCount($id)
    {
        $this->reader->fullRead("SELECT COUNT(*) AS count FROM `pokedexes_pokemons_link` WHERE pokedex_id = :id", "id={$id}");
        return $this->reader->getResult()[0];
    }
}
