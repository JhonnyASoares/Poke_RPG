<?php

namespace Sts\Controllers;

class Api
{
    /** @var array|string|null $dados Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /**
     * Instanciar a MODELS e receber o retorno
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        print_r('<pre>');
        $teste = new \Sts\Models\ApiToDb();
        //$teste->saveTypeInDb();
        //$teste->saveDamageClassDb();
        //$teste->saveMovesDb();
        //$teste->saveNaturesDb();
        //$teste->saveAbilitysDb();
        //$teste->savePokemonsDb();
        //$teste->savePokemonsSpeciesDb();


        //$loadView = new \Core\ConfigView("sts/Views/Api", $this->data);
        //$loadView->loadView();
    }
}
