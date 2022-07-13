<?php

namespace App\Services\Params\Contato;

use App\Services\Params\BaseServiceParams;

class UpdateCompleteContatoServiceParams extends BaseServiceParams
{
    public $nome;
    public $email;
    public $telefones;
    public $enderecos;

    public function __construct(
        string $nome,
        string $email,
        array $telefones,
        array $enderecos
    ) {
        parent::__construct();
    }
}
