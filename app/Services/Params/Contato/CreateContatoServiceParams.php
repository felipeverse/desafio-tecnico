<?php

namespace App\Services\Params\Contato;

use App\Services\Params\BaseServiceParams;

class CreateContatoServiceParams extends BaseServiceParams
{
    public $nome;
    public $email;

    public function __construct(string $nome, string $email)
    {
        parent::__construct;
    }
}