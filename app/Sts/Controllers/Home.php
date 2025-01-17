<?php

namespace Sts\Controllers;

class Home
{
    private array|string|null $data = null;
    public function index()
    {
        $loadView = new \Core\ConfigView("Sts/Views/Home", $this->data);
        $loadView->loadView();
    }
}
