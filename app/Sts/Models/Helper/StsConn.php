<?php

namespace Sts\Models\Helper;

// Redirecionar ou para o processamento quando o usuário não acessa o arquivo index.php
if (!defined('P0K3M4RP5G')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use PDO;
use PDOException;

/**
 * Classe responsavel por fazer a conexão com o banco de dados, utilizando dados definidos em constantes do arquivo Config.php
 * 
 * @author Jhonny
 */
abstract class StsConn
{
    /** @var string $host Recebe o host da constante HOST */
    private string $host = HOST;
    /** @var string $user Recebe o usuário da constante USER */
    private string $user = USER;
    /** @var string $pass Recebe a senha da constante PASS */
    private string $pass = PASS;
    /** @var string $dbName Recebe a base de dados da constante DBNAME */
    private string $dbname = DBNAME;
    /** @var object $connect Recebe a conexão com o banco de dados */
    private object $connect;

    /**
     * Realiza a conexão com o banco de dados.
     * Não realizando o conexão corretamente, para o processamento da página e apresenta a mensagem de erro, com o e-mail de contato do administrador
     * @return object retorna a conexão com o banco de dados
     */
    public function connectDb(): object
    {
        try {
            $this->connect = new PDO("mysql:host={$this->host};dbname=" . $this->dbname, $this->user, $this->pass);

            return $this->connect;
        } catch (PDOException $err) {
            die("Erro: Por favor tente novamente, caso o erro persista, entre em contato com o adiministrador" . EMAILADM);
        }
    }
}
