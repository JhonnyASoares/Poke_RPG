<?php

namespace Sts\Models;

/**
 * Classe responsavel por pegar os dados da API e retorna-los com url dinâmica
 */
class GetApi
{


    public object $result;
    /**
     * Undocumented function
     *
     * @param string $apiUrl requer a URL da api desejada
     * @return array com os conteudos da api
     */
    public function __construct(string $apiUrl)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $this->result = json_decode($response);
    }
}
