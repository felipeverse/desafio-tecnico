<?php

namespace App\Services\Contracts;

use App\Services\Responses\ServiceResponse;
use App\Services\Params\Endereco\StoreEnderecoServiceParams;

interface EnderecosServiceInterface
{
    public function storeMultipleEnderecos(int $contato_id, array $enderecos): ServiceResponse;
    public function storeEndereco(StoreEnderecoServiceParams $attributes): ServiceResponse;
}
