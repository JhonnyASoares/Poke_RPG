<?php

namespace Sts\Models;

class StsPokemon
{
    public function pokemonAllData()
    {
        $getPokemon = new \Sts\Models\Helper\StsRead();
        $getPokemon->fullRead(
            "SELECT pkm.name
            FROM pokemons AS pkm
            LEFT JOIN pokemons_imgs AS pk_img ON pkm.id = pk_img.pokemon_id
            LEFT JOIN pokemons_gifs AS pk_gif ON pkm.id = pk_gif.pokemon_id
            LEFT JOIN pokemons_species AS pk_sps ON pkm.id = pk_sps.pokemon_id

            LEFT JOIN pokemons_types_link AS pk_ty ON pkm.id = pk_ty.pokemon_id
            LEFT JOIN types ON pk_ty.type_id = types.id

            LEFT JOIN pokemons_abilities_link AS pk_ab ON pkm.id = pk_ab.pokemon_id
            LEFT JOIN abilities ON pk_ab.abilities_id = abilities.id
            GROUP BY pkm.id
            ORDER BY pkm.id DESC
            LIMIT 5"
        );
        return $getPokemon->getResult();
    } //ASC 
}
/*
"SELECT pkm.name
FROM pokemons AS pkm
INNER JOIN pokemons_imgs AS pk_img ON pkm.id = pk_img.pokemon_id
INNER JOIN pokemons_gifs AS pk_gif ON pkm.id = pk_gif.pokemon_id
INNER JOIN pokemons_species AS pk_sps ON pkm.id = pk_sps.pokemon_id

INNER JOIN pokemons_types_link AS pk_ty ON pkm.id = pk_ty.pokemon_id
INNER JOIN types ON pk_ty.type_id = types.id

INNER JOIN pokemons_abilities_link AS pk_ab ON pkm.id = pk_ab.pokemon_id
INNER JOIN abilities ON pk_ab.abilities_id = abilities.id
GROUP BY pkm.id

ORDER BY pkm.id DESC
LIMIT 5
;"
*/