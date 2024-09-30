<?php

namespace Sts\Controllers;

class Login
{
    private array|string|null $data = null;
    public function index()
    {
        $loadView = new \Core\ConfigView("Sts/Views/Login", $this->data);
        $loadView->loadView();
    }
}
