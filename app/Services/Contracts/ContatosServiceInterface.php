<?php

namespace App\Services\Contracts;

use App\Services\Responses\ServiceResponse;
use App\Services\Params\Contato\CreateContatoServiceParams;
use App\Services\Params\Contato\UpdateContatoServiceParams;
use App\Services\Params\Contato\CreateCompleteContatoServiceParams;
use App\Services\Params\Contato\UpdateCompleteContatoServiceParams;

interface ContatosServiceInterface
{
    public function all(string $searchName = null): ServiceResponse;
    public function find(int $id): ServiceResponse;
    public function create(CreateContatoServiceParams $params): ServiceResponse;
    public function createCompleteContato(CreateCompleteContatoServiceParams $params): ServiceResponse;
    public function updateContato(UpdateContatoServiceParams $attributes, int $id): ServiceResponse;
    public function updateCompleteContato(UpdateCompleteContatoServiceParams $attributes, int $id): ServiceResponse;
}
