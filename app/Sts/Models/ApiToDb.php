<?php

namespace Sts\Models;


class ApiToDb
{

    private array $data = [];

    public function saveTypeInDb()
    {
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/type/?offset=0&limit=50');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $this->data['name'] = $values->name;
            $registerType = new \Sts\Models\Helper\StsCreate;
            $registerType->exeCreate('types', $this->data);
        }
        die();
    }
    public function saveDamageClassDb()
    {
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/move-damage-class/');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $this->data['name'] = $values->name;
            $registerDmgClass = new \Sts\Models\Helper\StsCreate;
            $registerDmgClass->exeCreate('moves_damage_class', $this->data);
        }
        die();
    }
    public function saveMovesDb()
    {
        print_r('<pre>');
        $testarApi = new \Sts\Models\GetApi('https://pokeapi.co/api/v2/move/?offset=0&limit=1000');
        $filterResults = $testarApi->result->results;
        foreach ($filterResults as $values) {
            $interMove = new \Sts\Models\GetApi($values->url);
            $iMResult = $interMove->result;

            $damageClassName = $iMResult->damage_class->name;
            $typeName = $iMResult->type->name;

            $getDmgId = new \Sts\Models\Helper\StsRead;
            $getDmgId->exeRead('moves_damage_class', "WHERE `name`='$damageClassName'");
            $getDmgIdOnly = $getDmgId->getResult();

            $getTypeId = new \Sts\Models\Helper\StsRead;
            $getTypeId->exeRead('types', "WHERE `name`='$typeName'");
            $getTypeIdOnly = $getTypeId->getResult();
            $effectResume = null;

            if (isset($iMResult->effect_entries['0']->short_effect)) {
                $effectResume = $iMResult->effect_entries['0']->short_effect;
            }

            $this->data['id'] = $iMResult->id;
            $this->data['name'] = $iMResult->name;
            $this->data['accuracy'] = $iMResult->accuracy;
            $this->data['power'] = $iMResult->power;
            $this->data['pp'] = $iMResult->pp;
            $this->data['effect'] = $effectResume;
            $this->data['damage_class_id'] = $getDmgIdOnly[0]['id'];
            $this->data['type_id'] = $getTypeIdOnly[0]['id'];

            //print_r($this->data);
            print_r($iMResult->id);

            $registerMove = new \Sts\Models\Helper\StsCreate;
            $registerMove->exeCreate('moves', $this->data);
        }
    }
}



/*
$id = $resp->id;
$nome = $resp->name;
$acerto = $resp->accuracy;
$power = $resp->power;
$damage_class = $resp->damage_class->name;
$type = $resp->type->name;
$pp = $resp->pp;
$description = $resp->effect_entries['0']->effect;

echo 'id: ' . $id . '<br>';
echo 'nome: ' . $nome . '<br>';
echo 'acerto: ' . $acerto . '<br>';
echo 'poder: ' . $power . '<br>';
echo 'tipo/elemento: ' . $type . '<br>';
echo 'classe de dano: ' . $damage_class . '<br>';
echo 'pp: ' . $pp . '<br>';
echo 'descrição: ' . $description . '<br>';
*/




/*
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://pokeapi.co/api/v2/move/2/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$resp = json_decode($response);
*/