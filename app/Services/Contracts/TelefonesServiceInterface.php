<?php

namespace App\Services\Contracts;

use App\Services\Responses\ServiceResponse;

interface TelefonesServiceInterface
{
    public function storeMultipleTelefones(int $contato_id, array $telefones): ServiceResponse;
    public function storeTelefone(int $contato_id, string $telefone): ServiceResponse;
}
