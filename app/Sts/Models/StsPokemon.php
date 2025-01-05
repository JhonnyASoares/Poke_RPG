<?php

namespace Sts\Models;

class StsPokemon
{
    private object $reader;
    private int $pkmId;
    function __construct()
    {
        $this->reader = new \Sts\Models\Helper\StsRead();
    }
    public function pokemonsData($name)
    {
        $this->reader->fullRead(
            "SELECT pkm.id, pkm.name, pkm.hp, pkm.attack, pkm.defense, pkm.special_attack, pkm.special_defense, pkm.speed, pkm.height, pkm.weight
            FROM pokemons AS pkm
            WHERE name = :name",
            "name={$name}"
        );
        return $this->reader->getResult();
    }

    public function pokemonSpecies($pkmId)
    {
        $this->reader->fullRead("SELECT is_baby, is_legendary, is_mythical FROM pokemons_species WHERE pokemon_id = :pkmId", "pkmId={$pkmId}");
        return $this->reader->getResult();
    }

    public function pokemonTypes($pkmId)
    {
        $this->reader->fullRead("SELECT types.name, types.color
                            FROM pokemons_types_link AS pktl
                            INNER JOIN types ON pktl.type_id = types.id 
                            WHERE pktl.pokemon_id = :pkmId
                            GROUP BY types.name", "pkmId={$pkmId}");
        return $this->reader->getResult();
    }
    public function pokemonAbilities($pkmId)
    {
        $this->reader->fullRead("SELECT abilities.name, abilities.description, pkal.is_hidden 
                                FROM pokemons_abilities_link AS pkal
                                INNER JOIN abilities ON pkal.abilities_id = abilities.id 
                                WHERE pkal.pokemon_id = :pkmId
                                GROUP BY abilities.name, pkal.is_hidden", "pkmId={$pkmId}");
        return $this->reader->getResult();
    }

    public function pokemonMoves($pkmId)
    {
        $this->reader->fullRead("SELECT moves.name, moves.accuracy, moves.power, moves.pp, moves.effect, mdc.name AS damage_class, types.name AS type, types.color AS type_color
                            FROM pokemons_moves_link AS pkml
                            INNER JOIN moves ON pkml.move_id = moves.id 
                            INNER JOIN moves_damage_class AS mdc ON moves.damage_class_id = mdc.id
                            INNER JOIN types ON moves.type_id = types.id
                            WHERE pkml.pokemon_id = :pkmId
                            GROUP BY moves.name", "pkmId={$pkmId}");
        return $this->reader->getResult();
    }
    public function pokemonImgs($pkmId)
    {
        $this->reader->fullRead("SELECT front_default, front_shiny FROM pokemons_imgs WHERE pokemon_id = :pkmId GROUP BY front_default, front_shiny", "pkmId={$pkmId}");
        return $this->reader->getResult();
    }
    public function pokemonGifs($pkmId)
    {
        $this->reader->fullRead("SELECT front_default, front_shiny, back_default, back_shiny FROM pokemons_gifs WHERE pokemon_id = :pkmId GROUP BY front_default, front_shiny, back_default, back_shiny", "pkmId={$pkmId}");
        return $this->reader->getResult();
    }
    public function pokemonEvolution($pkmId)
    {
        $this->reader->fullRead("SELECT pokemons.id, pokemons.name, pokemons_imgs.front_default
                                FROM evolution_chains
                                INNER JOIN pokemons ON evolution_chains.evolves_to = pokemons.id
                                INNER JOIN pokemons_imgs ON pokemons.id = pokemons_imgs.pokemon_id
                                WHERE evolution_chains.pokemon_id = :pkmId", "pkmId={$pkmId}");
        return $this->reader->getResult();
    }

    public function getPkmLike($name)
    {
        $this->reader->fullRead(
            "SELECT pkm.name, pokemons_imgs.front_default
            FROM pokemons AS pkm
            INNER JOIN pokemons_imgs ON pkm.id = pokemons_imgs.pokemon_id
            WHERE name LIKE :name
            LIMIT 20",
            "name={$name}"
        );
        return $this->reader->getResult();
    }
}
