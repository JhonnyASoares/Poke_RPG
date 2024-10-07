<?php

namespace Sts\Controllers;

class Logout
{
    /**
     * Redireciona para a tela de login e destroi a sessao do usuario.
     *
     * @return void
     */
    public function index(): void
    {
        session_destroy();
        header("Location: /login");
    }
}
