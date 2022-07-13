<?php

namespace App\Services\Contracts;

use App\Services\Responses\ServiceResponse;
use App\Services\Params\Endereco\StoreEnderecoServiceParams;

interface ContatoEnderecoServiceInterface
{
    public function storeMultiple(int $contato_id, array $enderecos): ServiceResponse;
    public function store(StoreEnderecoServiceParams $params): ServiceResponse;
}
