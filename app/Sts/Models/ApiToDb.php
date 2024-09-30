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
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/pokemon/?offset=0&limit=1500');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interPkm = new \Sts\Models\GetApi($values->url);
            $iMResult = $interPkm->result;
            //Atribuindo os dados que irão para tabela 'pokemons' no array $this->data
            $this->data['id'] = $iMResult->id;
            $this->data['name'] = $iMResult->name;
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
            try {
                $registerPokemon = new \Sts\Models\Helper\StsCreate;
                $registerPokemon->exeCreate('pokemons', $this->data);
            } catch (Exception $err) {
                echo "ERRO AO REGISTRAR O POKEMON " .  $err;
                die;
            }
            // Criando a ligação entre a table 'pokemons' e a table 'types'
            $this->pokemonTypeLink($iMResult);
            // Criando a ligação entre a table 'pokemons' e a table 'abilities'
            $this->pokemonAbilityLink($iMResult);
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
    public function savePokemonsSpeciesDb(): void
    {
        //Classe \GetApi recebe o link da API, aplica o cURL e atribui os dados com json_decode aplicado ao objeto $this->result 
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/pokemon-species/?offset=0&limit=2000');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interPkm = new \Sts\Models\GetApi($values->url);
            $iMResult = $interPkm->result;

            //Buscando o id do pokemon no banco de dados
            $pkmName = $iMResult->varieties[0]->pokemon->name;
            $getPkmData = new \Sts\Models\Helper\StsRead;
            $getPkmData->exeRead('pokemons', "WHERE `name`='$pkmName'");
            $pkmData = $getPkmData->getResult();

            //Atribuindo ao $this->data os dados que serão salvos do banco de dados
            $this->data['pokemon_id'] = $pkmData[0]['id'];
            $this->data['is_baby'] = (int) $iMResult->is_baby;
            $this->data['is_legendary'] = (int) $iMResult->is_legendary;
            $this->data['is_mythical'] = (int) $iMResult->is_mythical;
            $this->data['base_happiness'] = $iMResult->base_happiness;
            $this->data['capture_rate'] = $iMResult->capture_rate;
            $this->data['gender_rate'] = $iMResult->gender_rate;
            $this->data['hatch_counter'] = $iMResult->hatch_counter;

            //Salvando os dados do banco de dados
            try {
                $registerPkmSpecies = new \Sts\Models\Helper\StsCreate;
                $registerPkmSpecies->exeCreate('pokemons_species', $this->data);
            } catch (Exception $err) {
                echo "ERRO AO REGISTRAR O POKEMON " .  $err;
                die;
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
                try {
                    $registerTypesPLink = new \Sts\Models\Helper\StsCreate;
                    $registerTypesPLink->exeCreate('pokemons_types_link', $typesArray);
                } catch (Exception $err) {
                    echo "ERRO AO FAZER LINK COM OS TYPES " . $err;
                    die;
                }
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
                try {
                    $registerAblyLink = new \Sts\Models\Helper\StsCreate;
                    $registerAblyLink->exeCreate('pokemons_abilities_link', $abilityArray);
                } catch (Exception $err) {
                    echo "ERRO AO FAZER LINK DO COM AS HABILIDADES " . $err;
                    die;
                }
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
        try {
            $registerPkmImgs = new \Sts\Models\Helper\StsCreate;
            $registerPkmImgs->exeCreate('pokemons_imgs', $imagensArray);
        } catch (Exception $err) {
            echo "ERRO AO REGISTRAR AS IMAGENS PNG " . $err;
            die;
        }
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
        try {
            $registerPkmGifs = new \Sts\Models\Helper\StsCreate;
            $registerPkmGifs->exeCreate('pokemons_gifs', $gifsArray);
        } catch (Exception $err) {
            echo "ERRO AO REGISTRAR OD GIFS" . $err;
            die;
        }
    }
}
