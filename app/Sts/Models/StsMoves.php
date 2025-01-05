<?php

namespace Sts\Models;

class StsMoves
{
    private object $reader;
    private int $pkmId;
    function __construct()
    {
        $this->reader = new \Sts\Models\Helper\StsRead();
    }

    public function movesTypesClass($moveId)
    {
        $this->reader->fullRead("SELECT moves.name, moves.accuracy, moves.power, moves.pp, moves.effect, moves.type_id, moves.damage_class_id
                        FROM moves
                        WHERE moves.id = :moveId", "moveId={$moveId}");
        return $this->reader->getResult();
    }
}
