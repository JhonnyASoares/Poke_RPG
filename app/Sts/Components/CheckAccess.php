<?php

namespace Sts\Components;

class CheckAccess
{
    public function indexAccess()
    {
        if (!defined('P0K3M4RP5G')) {
            header("Location: /");
            die("Erro: Pagina nao encontrada!");
        }
    }
}
