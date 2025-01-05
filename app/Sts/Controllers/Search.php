<?php

namespace Sts\Controllers;

class Search
{
    public function search($pkm)
    {
        $search = new \Sts\Models\StsPokemon();
        return print_r(json_encode($search->getPkmLike('%' . $pkm . '%')));
    }
}
