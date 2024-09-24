<?php

namespace Sts\Controllers;

class Login
{
    private array|null $data;
    public function index()
    {
        $this->data = null;
        $loadView = new \Core\ConfigView("Sts/Views/Login", $this->data);
        $loadView->loadView();
    }
}
