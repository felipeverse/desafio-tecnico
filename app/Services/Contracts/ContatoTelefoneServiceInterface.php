<?php

namespace App\Services\Contracts;

use App\Services\Responses\ServiceResponse;

interface ContatoTelefoneServiceInterface
{
    public function storeMultiple(int $contato_id, array $telefones): ServiceResponse;
    public function store(int $contato_id, string $telefone): ServiceResponse;
}
