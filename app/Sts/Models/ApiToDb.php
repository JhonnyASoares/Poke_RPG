<?php

namespace Sts\Models;

use Exception;

class ApiToDb
{

    private array $data = [];

    /**
     * Função responavel por salvar os Types no Bando de Dados
     *
     * @return void
     */
    public function saveTypeInDb(): void
    {
        //Classe \GetApi recebe o link da API, aplica o cURL e atribui os dados com json_decode aplicado ao objeto $this->result 
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/type/?offset=0&limit=50');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $this->data['name'] = $values->name;
            //Salvando os dados do array '$this->data' na tabela 'types' 
            $registerType = new \Sts\Models\Helper\StsCreate;
            $registerType->exeCreate('types', $this->data);
        }
    }
    /**
     * Função responavel por salvar as DamageClass no Bando de Dados
     *
     * @return void
     */
    public function saveDamageClassDb(): void
    {
        //Classe \GetApi recebe o link da API, aplica o cURL e atribui os dados com json_decode aplicado ao objeto $this->result 
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/move-damage-class/');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $this->data['name'] = $values->name;
            //Salvando os dados do array '$this->data' na tabela 'moves_damage_class' 
            $registerDmgClass = new \Sts\Models\Helper\StsCreate;
            $registerDmgClass->exeCreate('moves_damage_class', $this->data);
        }
    }
    /**
     * Função responavel por salvar as Moves no Bando de Dados fazendo o link deles com as DamageClass e com os Types
     *
     * @return void
     */
    public function saveMovesDb(): void
    {
        //Classe \GetApi recebe o link da API, aplica o cURL e atribui os dados com json_decode aplicado ao objeto $this->result 
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/move/?offset=0&limit=1000');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interMove = new \Sts\Models\GetApi($values->url);
            $iMResult = $interMove->result;
            $damageClassName = $iMResult->damage_class->name;
            $typeName = $iMResult->type->name;
            //Buscando o ID da DamageClass no Banco de Dados
            $getDmgId = new \Sts\Models\Helper\StsRead;
            $getDmgId->exeRead('moves_damage_class', "WHERE `name`='$damageClassName'");
            $getDmgIdOnly = $getDmgId->getResult();
            //Buscando o ID do Type no Banco de Dados
            $getTypeId = new \Sts\Models\Helper\StsRead;
            $getTypeId->exeRead('types', "WHERE `name`='$typeName'");
            $getTypeIdOnly = $getTypeId->getResult();
            $effectResume = null;
            //Verificando se tem descrição
            if (isset($iMResult->effect_entries['0']->short_effect)) {
                $effectResume = $iMResult->effect_entries['0']->short_effect;
            }
            //Atribuindo os valores pra uma array
            $this->data['id'] = $iMResult->id;
            $this->data['name'] = $iMResult->name;
            $this->data['accuracy'] = $iMResult->accuracy;
            $this->data['power'] = $iMResult->power;
            $this->data['pp'] = $iMResult->pp;
            $this->data['effect'] = $effectResume;
            $this->data['damage_class_id'] = $getDmgIdOnly[0]['id'];
            $this->data['type_id'] = $getTypeIdOnly[0]['id'];
            //Salvando os dados do array '$this->data' na tabela 'moves' 
            $registerMove = new \Sts\Models\Helper\StsCreate;
            $registerMove->exeCreate('moves', $this->data);
        }
    }
    /**
     * Função responavel por salvar as Natures no Bando de Dados
     *
     * @return void
     */
    public function saveNaturesDb(): void
    {
        //Classe \GetApi recebe o link da API, aplica o cURL e atribui os dados com json_decode aplicado ao objeto $this->result 
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/nature/?offset=0&limit=50');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interPkm = new \Sts\Models\GetApi($values->url);
            $iMResult = $interPkm->result;
            //Atribuindo os valores que irão para tabela
            $this->data['name'] = $iMResult->name;
            $this->data['increased_stat'] = null;
            $this->data['decreased_stat'] = null;
            //Verificando se o atributo existe na API se existir substitui os null
            if (!empty($iMResult->increased_stat)) {
                $this->data['increased_stat'] = $iMResult->increased_stat->name;
                $this->data['decreased_stat'] = $iMResult->decreased_stat->name;
            }
            //Salvando os dados do array '$this->data' na tabela 'natures' 
            $registerNature = new \Sts\Models\Helper\StsCreate;
            $registerNature->exeCreate('natures', $this->data);
        }
    }
    /**
     * Função responavel por salvar as Abilities no Bando de Dados
     *
     * @return void
     */
    public function saveAbilitysDb(): void
    {
        //Classe \GetApi recebe o link da API, aplica o cURL e atribui os dados com json_decode aplicado ao objeto $this->result 
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/ability/?offset=0&limit=400');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interPkm = new \Sts\Models\GetApi($values->url);
            $iMResult = $interPkm->result;
            //Atribuindo os valores que irão para tabela
            $this->data['id'] = $iMResult->id;
            $this->data['name'] = $iMResult->name;
            $this->data['description'] = null;
            //Buscando a descrição em ingles para salvar na tabela 
            // 'break' utilizado para sair do foreach quando encontrar o resultado desejado
            foreach ($iMResult->effect_entries as $effect_entries) {
                if ($effect_entries->language->name = 'en') {
                    $this->data['description'] = $effect_entries->short_effect;
                    break;
                }
            }
            //Busca a descrição para tabela em outro local caso não tenha encontrado anteriormente
            if ($this->data['description'] === null) {
                // 'array_reverse()' utilizado para pegar dados mais atuais 
                // 'break' utilizado para sair do foreach quando encontrar o resultado desejado
                foreach (array_reverse($iMResult->flavor_text_entries) as $otherValues) {
                    if ($otherValues->language->name == 'en') {
                        $this->data['description'] = $otherValues->flavor_text;
                        break;
                    }
                }
            }
            //Salvando os dados do array '$this->data' na tabela 'abilities' 
            $registerAbility = new \Sts\Models\Helper\StsCreate;
            $registerAbility->exeCreate('abilities', $this->data);
        }
    }
    /**
     * Funcao responsavel por salvar os dados na tabela 'pokemons' e chamar outras funções para
     * salvar outros dados referentes aos pokemons em outra tabela
     *
     * @return void
     */
    public function savePokemonsDb(): void
    {
        //Classe \GetApi recebe o link da API, aplica o cURL e atribui os dados com json_decode aplicado ao objeto $this->result 
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/pokemon/?offset=0&limit=2000');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interPkm = new \Sts\Models\GetApi($values->url);
            $iMResult = $interPkm->result;
            echo $iMResult->id . '<br>';

            if (!$iMResult->is_default) {
                die;
            }
            //Atribuindo os dados que irão para tabela 'pokemons' no array $this->data
            $this->data['id'] = $iMResult->id;
            $this->data['name'] = $iMResult->species->name;
            foreach ($iMResult->stats as $statData) {
                $statName = $statData->stat->name;
                if ($statName == 'hp') {
                    $this->data['hp'] = $statData->base_stat;
                } else if ($statName == 'attack') {
                    $this->data['attack'] = $statData->base_stat;
                } else if ($statName == 'defense') {
                    $this->data['defense'] = $statData->base_stat;
                } else if ($statName == 'special-attack') {
                    $this->data['special_attack'] = $statData->base_stat;
                } else if ($statName == 'special-defense') {
                    $this->data['special_defense'] = $statData->base_stat;
                } else if ($statName == 'speed') {
                    $this->data['speed'] = $statData->base_stat;
                }
            }
            $this->data['height'] = $iMResult->height;
            $this->data['weight'] = $iMResult->weight;


            //Salvando os dados do array '$this->data' na tabela 'pokemons' 
            $registerPokemon = new \Sts\Models\Helper\StsCreate;
            $registerPokemon->exeCreate('pokemons', $this->data);
            // Salvando os dados da tabela 'pokemons' na tabela 'pokemons_species'
            $this->savePokemonsSpeciesDb($iMResult->species->url, $iMResult->id);
            // Criando a ligação entre a table 'pokemons' e a table 'types'
            $this->pokemonTypeLink($iMResult);
            // Criando a ligação entre a table 'pokemons' e a table 'abilities'
            $this->pokemonAbilityLink($iMResult);
            // Criando a ligação entre a table 'pokemons' e a table 'moves'
            $this->savePkmMoveLink($iMResult->moves, $iMResult->id);
            // Salvando as imagens do pokemon em outra tabela 
            $this->pokemonImages($iMResult);
            // Verificando se os pokemons realmente tem gifs antes de tentar salvados
            if (!empty($iMResult->sprites->other->showdown->back_default)) {
                // Salvando os gifs dos pokemons em outra tabela 
                $this->pokemonGifs($iMResult);
            }
        }
    }
    /**
     * Funcao responsavel por salvar outros dados referentes aos pokemons na tabela 'pokemons_species'
     *
     * @return void
     */
    private function savePokemonsSpeciesDb($speciesUrl, $pkmId): void
    {

        $interPkm = new \Sts\Models\GetApi($speciesUrl);
        $iMResult = $interPkm->result;
        //Atribuindo ao $saveData os dados que serão salvos do banco de dados
        $saveData['pokemon_id'] = $pkmId;
        $saveData['is_baby'] = (int) $iMResult->is_baby;
        $saveData['is_legendary'] = (int) $iMResult->is_legendary;
        $saveData['is_mythical'] = (int) $iMResult->is_mythical;
        $saveData['base_happiness'] = $iMResult->base_happiness;
        $saveData['capture_rate'] = $iMResult->capture_rate;
        $saveData['gender_rate'] = $iMResult->gender_rate;
        $saveData['hatch_counter'] = $iMResult->hatch_counter;
        //Salvando os dados na tabela 'pokemons_species'
        $registerPkmSpecies = new \Sts\Models\Helper\StsCreate;
        $registerPkmSpecies->exeCreate('pokemons_species', $saveData);
    }

    /**
     * Função responsável por criar a ligação entre a tabela 'pokemons' e a tabela 'moves' via tabela 'pokemons_moves_link'
     *
     * @return void
     */
    private function savePkmMoveLink($movesArray, $pkmId): void
    {

        //Atribuindo ao $saveData os dados que serão salvos do banco de dados
        $saveData['pokemon_id'] = $pkmId;
        //Buscando o id do move no banco de dados
        foreach ($movesArray as $objMove) {
            //Buscando o id do move no banco de dados
            $getMoveId = new \Sts\Models\Helper\StsRead();
            $getMoveId->fullRead("SELECT id FROM moves WHERE name = '{$objMove->move->name}'");
            $moveId = $getMoveId->getResult();
            //Atribuindo ao $saveData os dados que serão salvos do banco de dados
            $saveData['move_id'] = $getMoveId->getResult()[0]['id'];
            //Salvando os dados do banco de dados
            $registerMoveLink = new \Sts\Models\Helper\StsCreate();
            $registerMoveLink->exeCreate('pokemons_moves_link', $saveData);
        }
    }
    /**
     * Função responsável por salvar as Pokedex no Bando de Dados
     *
     * @return void
     */
    public function savePokedexes(): void
    {
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/pokedex/?offset=0&limit=50');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interPkm = new \Sts\Models\GetApi($values->url);
            $iMResult = $interPkm->result;

            //Atribuindo os dados que irão para tabela 'pokedexes' no array $this->data
            $this->data['id'] = $iMResult->id;
            //Buscando o nome em inglês para salvar na tabela
            foreach ($iMResult->names as $value) {
                if ($value->language->name == 'en') {
                    $this->data['name'] = $value->name;
                }
            }
            //Caso não encontre o nome em inglês, buscando o nome em outro local
            if (empty($iMResult->names)) {
                $this->data['name'] = $iMResult->name;
            }
            //Salvando os dados na tabela 'pokedexes'
            $registerPokedex = new \Sts\Models\Helper\StsCreate;
            $registerPokedex->exeCreate('pokedexes', $this->data);

            foreach ($iMResult->pokemon_entries as $pkm) {
                //Buscando o id do pokemon no banco de dados
                $getPkmId = new \Sts\Models\Helper\StsRead;
                $getPkmId->fullRead("SELECT id FROM pokemons WHERE name = '{$pkm->pokemon_species->name}'");
                $saveData['pokemon_id'] = $getPkmId->getResult()[0]['id'];
                $saveData['pokedex_id'] = $this->data['id'];
                $saveData['entry_number'] = $pkm->entry_number;
                //Salvando os dados na tabela 'pokedexes_pokemons_link'
                $registerPokedex->exeCreate('pokedexes_pokemons_link', $saveData);
            }
        }
    }
    /**
     * Função responsável por criar a ligação evolutiva dos pokemons na tabela 'evolution_chains'
     * 
     * @return void
     */
    public function evolutionChain(): void
    {
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/evolution-chain/?offset=0&limit=1000'); //46
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interPkm = new \Sts\Models\GetApi($values->url);
            $iMResult = $interPkm->result;
            echo $iMResult->id . '<br>';

            //Utilizando função recursiva para criar a ligação evolutiva dos pokemons
            $this->evolveRecursive($iMResult->chain);
        }
    }

    /**
     * Função recursiva responsável por criar a ligação evolutiva dos pokemons
     * na tabela 'evolution_chains'
     *
     * @param object $chain objeto com a informação de evolução
     *
     * @return void
     */
    private function evolveRecursive($chain): void
    {
        //Verificando se tem evolucao
        if (!empty($chain->evolves_to)) {
            //Pegando o ID do pokemon e atribuindo ao array $pkmsId
            //$getPkmId = new \Sts\Models\GetApi($chain->species->url);
            //$iMResultAlter = $getPkmId->result;
            $getPkmId = new \Sts\Models\Helper\StsRead();
            $getPkmId->fullRead("SELECT id FROM pokemons WHERE name = '{$chain->species->name}'");
            $iResult = $getPkmId->getResult();
            //print_r($chain->species->name);
            echo $chain->species->name . "<br>";
            $pkmsId['pokemon_id'] = $iResult[0]['id'];

            //Pegando o ID das evolucoes e atribuindo ao array $pkmsId
            foreach ($chain->evolves_to as $objEvo) {

                //$getPkmId = new \Sts\Models\GetApi($chain->species->url);
                //$iMResultAlter = $getPkmId->result;
                $getPkmId->fullRead("SELECT id FROM pokemons WHERE name = '{$objEvo->species->name}'");
                $iResult = $getPkmId->getResult();
                echo $objEvo->species->name . "<br>";
                //print_r($objEvo->species->name);
                $pkmsId['evolves_to'] = $iResult[0]['id'];

                //Salvando os dados do array $pkmsId na tabela 'evolution_chains'
                $registerChain = new \Sts\Models\Helper\StsCreate;
                $registerChain->exeCreate('evolution_chains', $pkmsId);

                //Verificando se a evolucao tem evolucoes, se sim, chamando a funcao recursiva
                if (!empty($objEvo->evolves_to)) {
                    $this->evolveRecursive($objEvo);
                }
            }
        }
    }
    /**
     * Funcao responsavel por fazer a ligação entre as tables 'pokemons' e 'types'
     *
     * @param object $iMResult
     * @return void
     */
    private function pokemonTypeLink($iMResult): void
    {
        foreach ($iMResult->types as $objType) {
            //Buscando a ability pelo nome no banco de dados
            $getType = new \Sts\Models\Helper\StsRead;
            $getType->exeRead('types', "WHERE `name`='{$objType->type->name}'");
            $typeDbData = $getType->getResult();
            //Atribuindo os dados que serão salvos em $typesArray
            $typesArray['pokemon_id'] = $this->data['id'];
            foreach ($typeDbData as $v) {
                $typesArray['type_id'] = $v['id'];
                //Salvando os dados do array '$typesArray' na tabela 'pokemons_types_link' 

                $registerTypesPLink = new \Sts\Models\Helper\StsCreate;
                $registerTypesPLink->exeCreate('pokemons_types_link', $typesArray);
            }
        }
    }
    /**
     * Funcao responsavel por fazer a ligação entre as tables 'pokemons' e 'abilities'
     *
     * @param object $iMResult
     * @return void
     */
    private function pokemonAbilityLink($iMResult): void
    {
        foreach ($iMResult->abilities as $objAbility) {
            //Buscando a ability pelo nome no banco de dados
            $getAbility = new \Sts\Models\Helper\StsRead;
            $getAbility->exeRead('abilities', "WHERE `name`='{$objAbility->ability->name}'");
            $abilityDbData = $getAbility->getResult();
            //Atribuindo os dados que serão salvos em $abilityArray
            $abilityArray['pokemon_id'] = $this->data['id'];
            foreach ($abilityDbData as $ability) {
                $abilityArray['abilities_id'] = $ability['id'];
                //Forcando boolean virar int pois estava dando erro
                $abilityArray['is_hidden'] = (int) $objAbility->is_hidden;
                //Salvando os dados do array '$abilityArray' na tabela 'pokemons_abilities_link' 
                $registerAblyLink = new \Sts\Models\Helper\StsCreate;
                $registerAblyLink->exeCreate('pokemons_abilities_link', $abilityArray);
            }
        }
    }
    /**
     * Funcao responsavel por salvar os imagens dos pokemons na tabela 'pokemons_imgs'
     *
     * @param object $iMResult
     * @return void
     */
    private function pokemonImages($iMResult): void
    {
        $imagens = $iMResult->sprites->other->{"official-artwork"};
        $imagensArray = [
            'pokemon_id' => $this->data['id'],
            'front_default' => $imagens->front_default,
            'front_shiny' => $imagens->front_shiny
        ];
        //Salvando os dados do array '$imagensArray' na tabela 'pokemons_imgs' 
        $registerPkmImgs = new \Sts\Models\Helper\StsCreate;
        $registerPkmImgs->exeCreate('pokemons_imgs', $imagensArray);
    }
    /**
     * Funcao responsavel por salvar os gifs dos pokemons na tabela 'pokemons_gifs'
     *
     * @param object $iMResult
     * @return void
     */
    private function pokemonGifs($iMResult): void
    {
        $gifs = $iMResult->sprites->other->showdown;
        $gifsArray = [
            'pokemon_id' => $this->data['id'],
            'front_default' => $gifs->front_default,
            'front_shiny' => $gifs->front_shiny,
            'back_default' => $gifs->back_default,
            'back_shiny' => $gifs->back_shiny
        ];
        //Salvando os dados do array '$gifsArray' na tabela 'pokemons_gifs' 

        $registerPkmGifs = new \Sts\Models\Helper\StsCreate;
        $registerPkmGifs->exeCreate('pokemons_gifs', $gifsArray);
    }
}
