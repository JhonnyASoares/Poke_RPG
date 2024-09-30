<?php

namespace Sts\Controllers;

class Error
{
    private array|string|null $data = null;
    public function index()
    {
        $loadView = new \Core\ConfigView("Sts/Views/Error", $this->data);
        $loadView->loadView();
    }
}
