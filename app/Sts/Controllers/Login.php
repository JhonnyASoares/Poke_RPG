<?php

namespace Sts\Controllers;

class Login
{
    /** @var array|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = null;
    /** @var array|null $dataForm Recebe os dados que devem ser enviados para MODEL */
    private array|string|null $dataForm;
    /**
     * Verifica se os dados de email e senha estão corretos,
     * se não, mantém na página de login com uma mensagem de erro.
     *
     * @return void
     */
    public function index(): void
    {
        //Pega os dados do POST em forma de array
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Mandando os dados para a MODEL para verificar se o email e a senha batem
        $getUser = new \Sts\Models\StsLogin();
        if (!empty($this->dataForm) && ($getUser->login($this->dataForm['email'], $this->dataForm['password']))) {
            $_SESSION['msg'] = "Email ou senha inválidos!";
        };
        //Atribuindo os dados que serao mandados para a VIEW
        $this->data['form'] = $this->dataForm;
        $loadView = new \Core\ConfigView("Sts/Views/Login", $this->data);
        $loadView->loadView();
    }
}
