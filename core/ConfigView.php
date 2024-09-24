<?php

namespace Core;

class ConfigView extends Config
{

    public function __construct(private string $nameView, private array|string|null $data)
    {
    }

    public function loadView(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')) {
            include 'app/Sts/Views/Include/Header.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/Sts/Views/Include/Footer.php';
        } else {
            echo "Não achou a porra do Login";
        }
    }
}
