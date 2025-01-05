<?php

namespace Sts\Controllers;

class Ficha
{
    private array|string|null $data = null;
    public function index()
    {
        $loadView = new \Core\ConfigView("Sts/Views/Ficha", $this->data);
        $loadView->loadView();
    }
}
