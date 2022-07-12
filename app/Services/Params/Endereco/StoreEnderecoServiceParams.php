<?php

namespace App\Services\Params\Endereco;

use App\Services\Params\BaseServiceParams;

class StoreEnderecoServiceParams extends BaseServiceParams
{
    public $contato_id;
    public $titulo;
    public $cep;
    public $logradouro;
    public $bairro;
    public $localidade;
    public $uf;
    public $numero;

    public function __construct(
        int    $contato_id,
        string $titulo,
        string $cep,
        string $logradouro,
        string $bairro,
        string $localidade,
        string $uf,
        string $numero
    ) {
        parent::__construct();
    }
}
