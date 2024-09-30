<?php

namespace Sts\Controllers;

class Pokedex
{
    private array|string|null $data = null;
    public function index()
    {
        $loadView = new \Core\ConfigView("Sts/Views/Pokedex", $this->data);
        $loadView->loadView();
    }
}
