<?php

namespace Sts\Models;


class StsLogin
{
    /**
     * Metodo para logar o usuario, recebe o email e a senha e realiza a sessão
     * @param string $email User email
     * @param string $password User password
     * @return bool Retorna true quando o login foi efetuado com sucesso e false quando houver erro
     */
    public function login(string $email, string $password)
    {
        $getUser = new \Sts\Models\Helper\StsRead();
        $getUser->exeRead("users", "WHERE `email`='$email' AND `password`=MD5('$password')");
        if ($getUser->getResult() != null) {
            $userData = $getUser->getResult()[0];

            // if (password_verify($password, $userData['password'])) {
            $_SESSION['user_id'] = $userData['id'];

            return true;
        } else {
            $_SESSION['msg'] = "Email ou senha inválidos!";
            return false;
        }
    }
}
